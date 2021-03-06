<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        // Deletes cache for the currently requested URI
        $this->output->delete_cache();

        $this->load->model('Generic_model', '', TRUE);
        date_default_timezone_set('Asia/Colombo');

    }

    public function index()
    {
        if (!empty($_SESSION['userId'])) {
            redirect('user');
        } else {
            $data['sysinfo'] = $this->Generic_model->getData('com_det', array('cmne', 'synm', 'cplg', 'syvr'), array('stat' => 1));
            $data['polyinfo'] = $this->Generic_model->getData('sys_policy', array('post'), array('poid' => 1));
            $this->load->view('common/login', $data);
        }
    }

    // USER LOGOUT
    function logout()
    {
        if (!empty($_SESSION['userId'])) {

            $username = $this->session->userdata('username');
            $userid = $this->session->userdata('userId');
            //MAC Accress Code for PHP
            ob_start(); // Turn on output buffering
            system('ipconfig /all'); //Execute external program to display output
            $mycom = ob_get_contents(); // Capture the output into a variable
            ob_clean(); // Clean (erase) the output buffer
            $findme = "Physical";
            $pmac = strpos($mycom, $findme); // Find the position of Physical text
            $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
            //echo $mac;

            $logdata_arr = array(
                'usid' => $userid,
                'usnm' => $username,
                'func' => 'User Logout --> ' . $username,
                'stat' => 1,
                'lgdt' => date('Y-m-d H:i:s'),
                'lgip' => $_SERVER['REMOTE_ADDR'],
                'mcid' => $mac,
            );
            $this->db->insert('user_log', $logdata_arr);

            $this->Generic_model->updateDataWithoutlog('user_mas', array('islg' => 0), array('auid' => $_SESSION['userId'])); // user table

            $this->session->sess_destroy();
            $this->index();
        } else {
            redirect('/');
        }
    }

    // USER LOCK
    function lockScren()
    {
        $_SESSION['userId'] = '';
        $data['sysinfo'] = $this->Generic_model->getData('com_det', array('cmne', 'synm', 'cplg', 'syvr'), array('stat' => 1));
        $this->load->view('common/lock_screen', $data);
    }

    //AUTO LOGOUT
    function auto_lgout()
    {
        if (!empty($_SESSION['userId'])) {
            $username = $this->session->userdata('username');
            $userid = $this->session->userdata('userId');
            //MAC Accress Code for PHP
            ob_start(); // Turn on output buffering
            system('ipconfig /all'); //Execute external program to display output
            $mycom = ob_get_contents(); // Capture the output into a variable
            ob_clean(); // Clean (erase) the output buffer
            $findme = "Physical";
            $pmac = strpos($mycom, $findme); // Find the position of Physical text
            $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
            //echo $mac;

            $logdata_arr = array(
                'usid' => $userid,
                'usnm' => $username,
                'func' => 'Auto Logout --> ' . $username,
                'stat' => 1,
                'lgdt' => date('Y-m-d H:i:s'),
                'lgip' => $_SERVER['REMOTE_ADDR'],
                'mcid' => $mac,
            );
            $this->db->insert('user_log', $logdata_arr);
            $this->Generic_model->updateDataWithoutlog('user_mas', array('islg' => 0), array('auid' => $_SESSION['userId'])); // user table

            $this->session->sess_destroy();
            $this->index();
        } else {
            redirect('/');
        }
    }

    // SYSTEM UPDATE AUTO REDIRECT
    public function sysupdate()
    {
        if (!empty($_SESSION['userId'])) {
            $this->load->view('common/sysUpdate');
        } else {
            $this->session->sess_destroy();
            $this->index();
            redirect('/');
        }
    }

    // SYSTEM UPDATE TIME CAL
    function timestamp()
    {
        $this->db->select("*");
        $this->db->from("syst_update");
        $this->db->where(" stat = 0 AND date = CURDATE() AND DATE_FORMAT(NOW(), '%H:%i:%s') BETWEEN frtm AND totm ");
        $query = $this->db->get();
        $chkupdt = $query->result();

        if (count($chkupdt) > 0 && $_SESSION['role'] != 1) {  // && $_SESSION['role'] != 1
            $start_date = new DateTime($chkupdt[0]->totm);
            $since_start = $start_date->diff(new DateTime(date('H:i:s')));

            echo
                (strlen($since_start->h) < 2 ? '0' . $since_start->h : $since_start->h) . ':'
                . (strlen($since_start->i) < 2 ? '0' . $since_start->i : $since_start->i) . ':'
                . (strlen($since_start->s) < 2 ? '0' . $since_start->s : $since_start->s);

        } else {
            $this->session->sess_destroy();
        }
    }

    // userProfile
    function userProfile()
    {
        if (!empty($_SESSION['userId'])) {
            $data['acm'] = ''; //Module
            $data['acp'] = 'systMsg'; //Page

            $this->load->view('common/tmpHeader');
            $per['permission'] = $this->Generic_model->getPermision();
            $this->load->view('user/common/userHeader', $per);

            //$dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('userProfile');

            $usid = $_SESSION['userId'];
            $usbr = $_SESSION['usrbrnc'];

            $this->db->select("user_mas.*, user_level.lvnm, brch_mas.brcd, brch_mas.brnm, ");
            $this->db->from("user_mas");
            $this->db->join("user_level", 'user_level.id = user_mas.usmd');
            $this->db->join("brch_mas", 'brch_mas.brid = user_mas.brch');
            $this->db->where(" user_mas.auid", $usid);
            $query = $this->db->get();
            $dataArr['userinfo'] = $query->result();

            $dataArr['memberinfo'] = $this->Generic_model->getData('user_mas', '', "stat = 1 AND usmd != 1 AND  auid != $usid AND brch = $usbr"); //

            $this->load->view('common/userProfile', $dataArr);
            $this->load->view('common/tmpFooter', $data);
        } else {
            $this->session->sess_destroy();
            $this->index();
        }
    }

    // USER PROFILE DETAILS EDIT
    function editProfile()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $name = $this->input->post('name');
        $value = $this->input->post('value');

        if ($name == 'emil') {
            $updtArr = array('emid' => $value);

        } else if ($name == 'mobile') {
            $updtArr = array('almo' => $value);
        } else {
        }

        $this->Generic_model->updateData('user_mas', $updtArr, array('auid' => $this->input->post('pk')));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // USER PASSWORD CHANGES
    public function upd_pass()
    {
        $cur_usr = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']), '');
        $pass = $this->input->post('olpss');
        $nw_pswd = $this->input->post('nwpss');
        //MAC Accress Code for PHP
        ob_start(); // Turn on output buffering
        system('ipconfig /all'); //Execute external program to display output
        $mycom = ob_get_contents(); // Capture the output into a variable
        ob_clean(); // Clean (erase) the output buffer
        $findme = "Physical";
        $pmac = strpos($mycom, $findme); // Find the position of Physical text
        $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
        //echo $mac;

        $res = password_verify($pass, $cur_usr[0]->lgps);

        // GET NEW PASSWORD VALID DATE
        $nxdt = date('Y-m-d', strtotime(date('Y-m-d') . ' + 45 days'));

        if ($res == 1) {
            $newpassword = password_hash($nw_pswd, PASSWORD_DEFAULT);
            $where_arr = array(
                'auid' => $_SESSION['userId']
            );
            $data_ar = array(
                'lgps' => $newpassword,
                'pwxp' => $nxdt,
                'fslg' => 0,
                'upby' => $_SESSION['userId'],
                'updt' => date('Y-m-d'),
            );
            $this->Generic_model->updateDataWithoutlog('user_mas', $data_ar, $where_arr);

            $username = $this->session->userdata('username');
            $userid = $this->session->userdata('userId');

            $logdata_arr = array(
                'usid' => $userid,
                'usnm' => $username,
                'func' => 'User Update Password --> ' . $username,
                'stat' => 1,
                'lgdt' => date('Y-m-d H:i:s'),
                'lgip' => $_SERVER['REMOTE_ADDR'],
                'mcid' => $mac,
            );
            $this->db->insert('user_log', $logdata_arr);

            echo json_encode(true);

        } else {
            echo json_encode(false);
        }
    }


}
