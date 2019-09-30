<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
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
        //$this->load->model('User_model');       // load model

        date_default_timezone_set('Asia/Colombo');

        if (!empty($_SESSION['userId'])) {

            $user = $this->Generic_model->chckVlidUsr();    // IF CHECK VALIDE USER SESSION
            if ($user > 0) {

                // CHECK CURRENT TIME IN SYSTEM UPDATE
                $this->db->select("*");
                $this->db->from("syst_update");
                $this->db->where(" stat = 0 AND date = CURDATE() AND DATE_FORMAT(NOW(), '%H:%i:%s') BETWEEN frtm AND totm ");
                $query = $this->db->get();
                $chkupdt = $query->result();

                if (count($chkupdt) > 0 && $_SESSION['role'] != 1 ) { /// && $_SESSION['role'] != 1
                    redirect('/Welcome/sysupdate');
                }
                // END CHECK CURRENT TIME IN SYSTEM UPDATE

            } else {
                $this->session->sess_destroy();
                redirect('/');
            }
        } else {
            redirect('/');
        }
    }
//</TESTING AREA>
    function Test(){
        $this->load->view('blank');
    }
//</END TESTING AREA>
	public function index()
	{
	    //Active Page Id
        $data['acm'] = ''; //Module
        $data['acp'] = 'dashbrd'; //Page
		$this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('user/common/userHeader',$per);

        $this->load->view('user/dashboard');

        $this->load->view('common/tmpFooter',$data);

	}

    function cusReg()
    {
        $data['acm'] = 'cusMng'; //Module
        $data['acp'] = 'cusReg'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('user/common/userHeader',$per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('cusReg');
        $data2['bank'] = $this->Generic_model->getSortData('bank', '', array('stat' => 1), '', '', 'bkcd', 'ASC');
        $this->load->view('user/customerRegist', $data2);

        $this->load->view('common/tmpFooter', $data);
    }

    function upload(){
        var_dump($_FILES['input-id']);
        echo "<br>".$this->input->post('files');
    }

//******************************************************* //
// MESSAGE MODULE
    public function systMsg()
    {
        $data['acm'] = 'msgModul'; //Module
        $data['acp'] = 'systMsg'; //Page

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('user/common/userHeader', $per);

        $dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('systMsg');
        $dataArr['uslvlinfo'] = $this->Generic_model->getData('user_level', '', "stat = 1 AND id != 1");

        $this->load->view('user/systemMessage',$dataArr);
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
}
