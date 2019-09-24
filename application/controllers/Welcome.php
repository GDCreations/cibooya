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
    function lockScren(){
        $_SESSION['userId'] ='';
        $data['sysinfo'] = $this->Generic_model->getData('com_det', array('cmne', 'synm', 'cplg', 'syvr'), array('stat' => 1));
        $this->load->view('common/lock_screen', $data);
    }


}
