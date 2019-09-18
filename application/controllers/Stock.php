<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        // Deletes cache for the currently requested URI
//        $this->output->delete_cache();
//
//        $this->load->library('Pdf'); // Load library
//        $this->pdf->fontpath = 'font/'; // Specify font folder
//
//        $this->load->database();                // load database
//        $this->load->model('Generic_model');    // load model
//        $this->load->model('User_model');       // load model
//        $this->load->model('Log_model');        // load model
//        $this->load->model('Hire_model');       // load model
//
//        date_default_timezone_set('Asia/Colombo');
//
//        //$user = $this->Generic_model->getMdulPermis('user');    // USER MODULE
//        if (!empty($_SESSION['userId'])) {
//
//            $user = $this->Generic_model->chckVlidUsr();    // IF CHECK VALIDE USER SESSION
//            if ($user > 0) {
//            } else {
//                $this->session->sess_destroy();
//                redirect('/');
//            }
//        } else {
//            redirect('/');
//        }
    }

    public function index()
    {

    }

//************************************************
//***           SUPPLIER REGISTRATION          ***
//************************************************
//OPEN PAGE </JANAKA 2019-09-17>
function sup_reg(){
    $data['acm'] = 'sup_mng';
    $data['acp'] = 'sup_reg';
    $this->load->view('common/tmpHeader');
    $this->load->view('admin/common/adminHeader');

    $this->load->view('admin/supplier_Reg');

    $this->load->view('common/tmpFooter',$data);
}
//END OPEN PAGE </JANAKA 2019-09-17>

//************************************************
//***       END SUPPLIER REGISTRATION          ***
//************************************************
}
