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
	    //Active Page Id
        $data['acm'] = ''; //Module
        $data['acp'] = 'dashbrd'; //Page
		$this->load->view('common/tmpHeader');
        $this->load->view('user/common/userHeader');

        $this->load->view('user/dashboard');

        $this->load->view('common/tmpFooter',$data);

	}
}
