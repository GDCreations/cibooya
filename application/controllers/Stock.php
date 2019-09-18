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
        $this->load->database();                // load database
        $this->load->model('Generic_model');    // load model
//        $this->load->model('User_model');       // load model
//        $this->load->model('Log_model');        // load model
//        $this->load->model('Hire_model');       // load model
//
        date_default_timezone_set('Asia/Colombo');
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
//OPEN PAGE </JANAKA 2019-09-18>
function sup_reg(){
    $data['acm'] = 'sup_mng'; //Module
    $data['acp'] = 'sup_reg'; //Page
    $data2['bank'] = $this->Generic_model->getSortData('bank','',array('stat'=>1),'','','bkcd','ASC');
    $this->load->view('common/tmpHeader');
    $this->load->view('admin/common/adminHeader');

    $this->load->view('admin/supplier_Reg',$data2);

    $this->load->view('common/tmpFooter',$data);
}
//END OPEN PAGE </JANAKA 2019-09-18>

//GET BRANCHES BY BANK </JANAKA 2019-09-18>
    function getbnkbrch()
    {
        $bkid = $this->input->post('id');
        $this->db->select("brid,bcnm,brcd");
        $this->db->from("bank_brch");
        $this->db->where('bank_brch.bnid', $bkid);
        $this->db->where('bank_brch.stat', 1);
        $this->db->order_by('bank_brch.brcd', 'ASC');
        $query = $this->db->get();
        $data['bkbrch'] = $query->result();
        echo json_encode($data);
    }
//END GET BRANCHES BY BANK </JANAKA 2019-09-18>
//************************************************
//***       END SUPPLIER REGISTRATION          ***
//************************************************
}
