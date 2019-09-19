<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
        $data['acm'] = ''; //Module
        $data['acp'] = 'dashbrd'; //Page
		$this->load->view('common/tmpHeader');
        $this->load->view('admin/common/adminHeader');

        $this->load->view('admin/adminDash');

        $this->load->view('common/tmpFooter',$data);

	}

	public function branding()
	{
        $data['acm'] = 'gnrl'; //Module
        $data['acp'] = 'branding'; //Page

		$this->load->view('common/tmpHeader');
        $this->load->view('admin/common/adminHeader');

        $dataArr['compInfo'] = $this->Generic_model->getData('com_det', '', array('stat' => 1));

        $this->load->view('admin/companyDetails',$dataArr);

        $this->load->view('common/tmpFooter',$data);

	}



}
