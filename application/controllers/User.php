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
        $this->load->model('User_model');       // load model
        $this->load->model('Log_model');        // load model

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

                if (count($chkupdt) > 0 && $_SESSION['role'] != 1) { /// && $_SESSION['role'] != 1
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
    function Test()
    {
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
        $this->load->view('user/common/userHeader', $per);

        $this->load->view('user/dashboard');

        $this->load->view('common/tmpFooter', $data);

    }

    function upload()
    {
        var_dump($_FILES['input-id']);
        echo "<br>" . $this->input->post('files');
    }

//******************************************************* //
// MESSAGE MODULE
    public function systMsg()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'systMsg'; //Page

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('user/common/userHeader', $per);

        $dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('systMsg');
        $dataArr['uslvlinfo'] = $this->Generic_model->getData('user_level', '', "stat = 1 AND id != 1");

        $this->load->view('user/systemMessage', $dataArr);
        $this->load->view('common/tmpFooter', $data);
    }

    //get user search
    function getusersrh()
    {
        $user = $this->input->post('uslv');
        $this->db->select("user_mas.usnm,user_mas.auid, user_level.id,user_level.lvnm");
        $this->db->from("user_mas");
        $this->db->join('user_level', 'user_level.id = user_mas.usmd');
        $this->db->where('user_level.id', $user);
        $this->db->where('user_mas.stat', 1);
        $query = $this->db->get();
        $data = $query->result();
        echo json_encode($data);
    }

    //SEARCH
    function srchSysMsg()
    {
        $result = $this->User_model->get_systmMsg();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            $option = "<button  type='button' id='edt' data-toggle='modal' data-target='#modal-view' onclick='edtModule($row->chid,this.id);' class='btn btn-xs btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->msgTp;
            $sub_arr[] = $row->lvnm;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $row->mdle;
            $sub_arr[] = $row->chng;
            $sub_arr[] = "<label class='label label-info' title='Notification'>$row->ntfy</label>";
            $sub_arr[] = $row->crby;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->all_systmMsg(),
            "recordsFiltered" => $this->User_model->filtered_systmMsg(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // INSERT
    function addNewmessg()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($this->input->post('ntfy') == '') {
            $swnt = 0;
        } else {
            $swnt = $this->input->post('ntfy');
        }

        $this->Generic_model->insertData('syst_mesg',
            array(
                'cmtp' => $this->input->post('type'),
                'uslv' => $this->input->post('srcUslv'),
                'mgus' => $this->input->post('srcUsr'),
                'swnt' => $swnt,
                'mdle' => ucwords(strtolower($this->input->post('titl'))),
                'chng' => ucwords(strtolower($this->input->post('msgs'))),
                'stat' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
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
    function getSysMsgDet()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->getData('syst_mesg', '', array('chid' => $id));
        echo json_encode($result);
    }

    // UPDATE
    function sysMsgEdit()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($this->input->post('ntfyEdt') == '') {
            $swnt = 0;
        } else {
            $swnt = $this->input->post('ntfyEdt');
        }

        $this->Generic_model->updateData('syst_mesg',
            array(
                'cmtp' => $this->input->post('typeEdt'),
                'uslv' => $this->input->post('srcUslvEdt'),
                'mgus' => $this->input->post('srcUsrEdt'),
                'swnt' => $swnt,
                'mdle' => ucwords(strtolower($this->input->post('titlEdt'))),
                'chng' => ucwords(strtolower($this->input->post('msgsEdt'))),
                'stat' => 1,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ),
            array('chid' => $this->input->post('auid')));

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
//
//********************** CUSTOMER MANAGEMENT ********************************* //
    function cusReg()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'cusReg'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('user/common/userHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('cusReg');
        //$data2['bank'] = $this->Generic_model->getSortData('bank', '', array('stat' => 1), '', '', 'bkcd', 'ASC');
        $this->load->view('user/customerRegist', $data2);

        $this->load->view('common/tmpFooter', $data);
    }

// CHECK ALREADY ENTERED MOBILE NUMBER
    function chk_mobile()
    {
        $mobi = $this->input->post('mobi');
        $stat = $this->input->post('stat'); //0-Add/1-Edit

        $this->db->select("mobi,tele");
        $this->db->from('cus_mas');
        $this->db->where("(mobi=$mobi OR tele=$mobi)");
        if ($stat == 1) {
            $this->db->where("cuid!=" . $this->input->post('auid'));
        }
        $res = $this->db->get()->result();
        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
// END CHECK ALREADY ENTERED MOBILE NUMBER


// CUSTOMER REGISTRATION
    function custmerRegist()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        /*
         *  //Creating customer next number
        $this->db->select("spcd");
        $this->db->from('supp_mas');
        $this->db->order_by('spcd', 'DESC');
        $this->db->where("stat NOT IN(0,2)");
        $this->db->limit(1);
        $res = $this->db->get()->result();
        if (sizeof($res) > 0) {
            $number = explode('-', $res[0]->spcd);
            $aa = intval($number[1]) + 1;
            $cc = strlen($aa);

            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = $aa;
            }
            $supcd = "S-" . $xx;
        } else {
            $supcd = "S-0001";
        }*/

        $this->Generic_model->insertData('cus_mas',
            array(
                'brco' => 1,
                'rgtp' => 0, // cash customer
                'cuno' => "TMP",
                'funm' => $this->input->post('cusnm'),
                'hoad' => $this->input->post('addr'),
                'mobi' => $this->input->post('mobi'),
                'tele' => $this->input->post('tele'),
                'anic' => $this->input->post('anic'),
                'emil' => $this->input->post('email'),
                'rmks' => $this->input->post('remk'),
                'stat' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            ));
        $lstId = $this->db->insert_id();

        $funcPerm = $this->Generic_model->getFuncPermision('cusReg');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Customer Added ($lstId)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
// END CUSTOMER REGISTRATION

// SEARCH CUSTOMER
    function searchCustmer()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('cusReg');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->apvl == 1) {
            $app = "";
        } else {
            $app = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edit = "";
        } else {
            $edit = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rejt = "";
        } else {
            $rejt = "disabled";
        }
        if ($funcPerm[0]->dact == 1) {
            $dac = "";
        } else {
            $dac = "disabled";
        }
        if ($funcPerm[0]->reac == 1) {
            $reac = "";
        } else {
            $reac = "disabled";
        }

        $result = $this->User_model->get_custDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            if ($row->stat == 0) {
                $stat = "<label class='label label-warning'>Pending</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewCust($row->cuid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewCust($row->cuid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $rejt onclick='rejectSupp($row->cuid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 1) {
                $stat = "<label class='label label-success'>Active</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewCust($row->cuid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewCust($row->cuid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $dac onclick='inactSupp($row->cuid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else if ($row->stat == 2) {
                $stat = "<label class='label label-indi'>Inactive</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewCust($row->cuid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $reac onclick='reactSupp($row->cuid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else {
                $stat = "--";
                $option = "<button type='button' disabled data-toggle='modal' data-target='#modal-view' onclick='viewCust($row->cuid)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='editSupp($row->cuid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='approveSupp($row->cuid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='rejectSupp($row->cuid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->cuno;
            $sub_arr[] = $row->funm;
            $sub_arr[] = $row->anic;
            $sub_arr[] = $row->hoad;
            $sub_arr[] = $row->mobi;
            $sub_arr[] = $row->innm;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->User_model->count_all_cust(),
            "recordsFiltered" => $this->User_model->count_filtered_cust(),
            "data" => $data,
        );
        echo json_encode($output);
    }
// END SEARCH CUSTOMER

// GET CUSTOMER DETAILS
    function get_customerDet()
    {
        $id = $this->input->post('id');

        $this->db->select("sup.*,CONCAT(cr.fnme,' ',cr.lnme) AS crnm, CONCAT(ap.fnme,' ',ap.lnme) AS apnm, CONCAT(md.fnme,' ',md.lnme) AS mdnm, CONCAT(rj.fnme,' ',rj.lnme) AS rjnm");
        $this->db->from('cus_mas sup');
        $this->db->join('user_mas cr', 'cr.auid=sup.crby');
        $this->db->join('user_mas ap', 'ap.auid=sup.apby', 'LEFT');
        $this->db->join('user_mas md', 'md.auid=sup.mdby', 'LEFT');
        $this->db->join('user_mas rj', 'rj.auid=sup.rjby', 'LEFT');
        $this->db->where("sup.cuid", $id);
        $data = $this->db->get()->result();

        echo json_encode($data);
    }
// END GET CUSTOMER DETAILS

// CUSTOMER UPDATE
    function custmUpdate()
    {
        $func = $this->input->post('func');
        $cuid = $this->input->post('cuid');

        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($func == 'edit') {
            //Updating supplier details
            $this->Generic_model->updateData('cus_mas',
                array(
                'funm' => $this->input->post('cusnmEdt'),
                'hoad' => $this->input->post('addrEdt'),
                'mobi' => $this->input->post('mobiEdt'),
                'tele' => $this->input->post('teleEdt'),
                'anic' => $this->input->post('anicEdt'),
                'emil' => $this->input->post('emailEdt'),
                'rmks' => $this->input->post('remkEdt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('cuid' => $cuid));

            $funcPerm = $this->Generic_model->getFuncPermision('cusReg');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Customer's Details Updated ($cuid)");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END CUSTOMER UPDATE
//
// REJECT CUSTOMER
    function supp_Reject()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $spid = $this->input->post('id');
        $this->Generic_model->updateData('supp_mas', array(
            'stat' => 2,
            'rjby' => $_SESSION['userId'],
            'rjdt' => date('Y-m-d H:i:s')
        ), array('spid' => $spid));

        $funcPerm = $this->Generic_model->getFuncPermision('supReg');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Supplier Rejected ($spid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
// END REJECT CUSTOMER


}
