<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mitadmin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        // Deletes cache for the currently requested URI
        $this->output->delete_cache();

        //$this->load->library('Pdf'); // Load library
        //$this->pdf->fontpath = 'font/'; // Specify font folder

        $this->load->database();                // load database
        $this->load->model('Generic_model');    // load model
        $this->load->model('Admin_model');      // load model
        $this->load->model('Log_model');      // load model

        date_default_timezone_set('Asia/Colombo');

        if (!empty($_SESSION['userId']) && $_SESSION['role'] == 1 ) {

            $user = $this->Generic_model->chckVlidUsr();    // IF CHECK VALIDE USER SESSION
            if ($user > 0) {

            } else {
                $this->session->sess_destroy();
                redirect('/');
            }
        } else {
            redirect('/');
        }
    }

    public function index()
    {
    }

    //*******************************************************
    //**********    MIT SPECIAL MANAGEMENT       *************
    //*******************************************************

//*******************************************************
// SYSTEM UPDATE
    public function sysUpdate()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'sysUpdate'; //Page

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        //$dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('sysUpdate');

        $this->load->view('mitadmin/systmUpdate');
        $this->load->view('common/tmpFooter', $data);
    }

    //SEARCH
    function srchSystmUpdte()
    {
        $result = $this->Admin_model->get_systmUpdtDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            if ($row->stat == 0) {
                if (date('Y-m-d', strtotime($row->date)) == date('Y-m-d') && (date('H:i:s', strtotime($row->totm)) > date('H:i:s') && date('H:i:s') >= date('H:i:s', strtotime($row->frtm)))) {
                    $mode = '<label class="label label-info"> Executing </label>';
                } else {
                    $mode = '<label class="label label-warning"> Pending </label>';
                }
                $edt = "";
                $edtt = "";
            } else if ($row->stat == 1) {
                $mode = '<label class="label label-success"> Executed </label>';
                $edt = "disabled";
                $edtt = "disabled";
            } else if ($row->stat == 2) {
                $mode = '<label class="label label-danger"> Reject </label>';
                $edt = "disabled";
                $edtt = "disabled";
            } else {
                $mode = '';
                $edtt = "";
            }

            $option = "<button $edt type='button' id='edt' data-toggle='modal' data-target='#modal-view' onclick='edtSchedule($row->auid,this.id);' class='btn btn-xs btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                " <button type='button'  $edtt id='rej'  onclick='doneSchedule($row->auid);' class='btn btn-xs btn-default btn-condensed' title='Done'><i class='fa fa-check' aria-hidden='true'></i></button> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->date;
            $sub_arr[] = $row->mesg;
            $sub_arr[] = $row->frtm;
            $sub_arr[] = $row->totm;
            $sub_arr[] = $row->innm;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $mode;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->count_all_systmUpdt(),
            "recordsFiltered" => $this->Admin_model->count_filtered_systmUpdt(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // INSERT
    function addSysDown()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $this->Generic_model->insertData('syst_update',
            array(
                'mesg' => $this->input->post('mssg'),
                'date' => $this->input->post('scdt'),
                'frtm' => $this->input->post('sttm'),
                'totm' => $this->input->post('entm'),
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
                'stat' => 0
            ));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // VIEW USER for edit approval
    function getDetSysDown()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->getData('syst_update', '', array('auid' => $id));
        echo json_encode($result);
    }

    // UPDATE
    function edtSysDown()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        if (date_create($this->input->post('entmEdt')) < date_create(date('H:i:s'))) {
            $stat = 1;
        } else {
            $stat = 0;
        }

        $this->Generic_model->updateData('syst_update',
            array(
                'mesg' => $this->input->post('mssgEdt'),
                'date' => $this->input->post('scdtEdt'),
                'frtm' => $this->input->post('sttmEdt'),
                'totm' => $this->input->post('entmEdt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
                'stat' => $stat
            ),
            array('auid' => $this->input->post('auid')));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    //down finish
    function SysDownFinished()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $this->Generic_model->updateData('syst_update', array('stat' => $this->input->post('stat')), array('auid' => $this->input->post('auid')));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    function doneSchedule()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $this->Generic_model->updateData('syst_update', array('stat' => 1), array('auid' => $this->input->post('auid')));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

//******************************************************* //
// SYSTEM CHANGE LOG
    function sysChanlg()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'sysChanlg'; //Page

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);
        //$dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('sysChanlg');

        $this->load->view('mitadmin/systmChangLog');
        $this->load->view('common/tmpFooter', $data);
    }

    function srchRelenseNt()
    {
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select(" * ");
        $this->db->from("syst_changelog");
        $this->db->where("DATE_FORMAT(syst_changelog.rcdt, '%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
        //$this->db->where('test.uslv', $srlv);
        $query = $this->db->get();
        $result = $query->result();

        $data = array();
        $i = 0;

        if ($_SESSION['role'] == 1) {
            $dis = "";
        } else {
            $dis = "disabled";
        }

        foreach ($result as $row) {

            if ($row->stat == 0) {
                $st = " <span class='label label-warning'> Pending </span> ";
                $option =
                    "<button type='button'   data-toggle='modal' data-target='#modal-view'  onclick='edtReleseNote($row->chid);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $dis onclick='sendMail($row->chid);' class='btn btn-xs btn-default btn-condensed' title='Send Mail' ><i class='fa fa-envelope' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' $dis onclick='rejecSppy($row->chid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($row->stat == 1) {
                $st = " <span class='label label-success'> Send Mail</span> ";
                $option =
                    "<button type='button'  data-toggle='modal' data-target='#modal-view'  onclick='edtReleseNote($row->chid);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled id='app'  onclick='sendMail($row->chid);' class='btn btn-xs btn-default btn-condensed' title='Send Mail' ><i class='fa fa-envelope' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled id='rej'  onclick='rejecSppy($row->chid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($row->stat == 2) {
                $st = " <span class='label label-danger'> Reject </span> ";
                $option =
                    "<button type='button'  data-toggle='modal' data-target='#modal-view'  onclick='edtReleseNote($row->chid);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled id='app'  onclick='sendMail($row->chid);' class='btn btn-xs btn-default btn-condensed' title='Send Mail' ><i class='fa fa-envelope' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled id='rej'  onclick='rejecSppy($row->chid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->rcdt;
            $sub_arr[] = $row->rfno;
            $sub_arr[] = $st;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }
        $output = array(
            "sEcho" => 2,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($output);
    }

    // ADD
    function addRelesNote()
    {
        $data_arr = array(
            'rfno' => $this->input->post('tag'),
            'rmks' => $this->input->post('remk'),
            'rcdt' => $this->input->post('rcdt'),
            'poby' => ucwords($this->input->post('poby')),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        );
        $result = $this->Generic_model->insertData('syst_changelog', $data_arr);
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function getReleseNote()
    {
        $chid = $this->input->post('chid');
        $this->db->select("*");
        $this->db->from("syst_changelog");
        $this->db->where('chid', $chid);
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // SEND EMAIL
    public function sendMail()
    {
        $chid = $this->input->post('chid');

        $this->db->select("*");
        $this->db->from("syst_changelog");
        $this->db->where('chid', $chid);
        $data = $this->db->get()->result();

        // SEND MAIL CONFIGURATION
        /* https://stackoverflow.com/questions/13469891/smtp-gmail-error-with-codeigniter-2-1-3 */
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',      //'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'support@gdcreations.com',   // change it to yours
            'smtp_pass' => 'S!upp#ort@*19',                  // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            // 'charset' => 'utf-8',
            'wordwrap' => TRUE
        );

        // ALL CC MAIL USER
        $tomlcc = $data[0]->rfno;
        //$tomlcc = 'cronjobs@gdcreations.com';
        // EMAIL MESSAGE
        $comDt = $this->Generic_model->getData('com_det', '', array('stat' => 1), '');
        $message = " This is a " . $data[0]->rcdt . ', ' . ucfirst($comDt[0]->synm) . " System update Release Notes <br> " . $data[0]->rmks . " <br> From  " . $data[0]->poby . " <br> (This is a system generated email.)";

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('support@gdcreations.com', 'GDC support');   // change it to yours
        $this->email->to($tomlcc);                                      // change it to yours    'gamunu@gdcreations.com'
        //$this->email->cc('geeth@gdcreations.com');                      // change it to yours
        $this->email->bcc('gemunu@gdcreations.com');                    // change it to yours
        $this->email->subject('System Updates Release Notes ' . $data[0]->rcdt);
        $this->email->message($message);

        if ($this->email->send()) {
            $this->Generic_model->updateData('syst_changelog', array('stat' => 1, 'snby' => $_SESSION['userId'], 'sndt' => date('Y-m-d H:i:s')), array('chid' => $chid));

            echo json_encode(true);
        } else {
            show_error($this->email->print_debugger());
            echo json_encode(false);
        }
    }

    //reject System Update Release Notes
    function rejecSppy()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->updateData('syst_changelog', array('stat' => 2), array('chid' => $id));
        if (count($result) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

// END SYSTEM UPDATE RELEASE NOTE

//******************************************************* //
// SYSTEM CHANGE LOG
    function mitVers()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'mitVers'; //Page

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);
        //$dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('sysChanlg');

        $this->load->view('mitadmin/versionPackage');
        $this->load->view('common/tmpFooter', $data);
    }

    function getPageMdul()
    {
        $this->db->select(" * ");
        $this->db->from("user_page_mdl");
        //$this->db->where('test.uslv', $srlv);
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // EDIT
    function editMitVirs()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $len = $this->input->post('len5');

        for ($a = 0; $a < $len; $a++) {
            $pgid = $this->input->post("mdid[" . $a . "]");
            $pgac = $this->input->post("pgac[" . $a . "]");

            $this->Generic_model->updateData('user_page_mdl', array('stat' => $pgac), array('aid' => $pgid));
        }

        //$funcPerm = $this->Generic_model->getFuncPermision('permis');
        //$this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Page Access Update');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    function getReleseNoteXX()
    {
        $chid = $this->input->post('chid');
        $this->db->select("*");
        $this->db->from("syst_changelog");
        $this->db->where('chid', $chid);
        $query = $this->db->get();
        echo json_encode($query->result());
    }



// END SYSTEM UPDATE RELEASE NOTE


}
