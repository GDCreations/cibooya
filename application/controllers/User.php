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
        $data['acm'] = ''; //Module
        $data['acp'] = 'systMsg'; //Page

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('user/common/userHeader', $per);

        $dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('systMsg');
        $dataArr['uslvlinfo'] = $this->Generic_model->getData('user_level', '', "stat = 1 AND id != 1");

        $this->load->view('user/systemMessage',$dataArr);
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
}
