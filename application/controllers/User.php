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
}
