<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
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
        $data['acm'] = ''; //Module
        $data['acp'] = 'dashbrd'; //Page
        $this->load->view('common/tmpHeader');
        $this->load->view('admin/common/adminHeader');

        $this->load->view('admin/adminDash');

        $this->load->view('common/tmpFooter', $data);

    }

    public function branding()
    {
        $data['acm'] = 'gnrl'; //Module
        $data['acp'] = 'branding'; //Page

        $this->load->view('common/tmpHeader');
        $this->load->view('admin/common/adminHeader');

        $dataArr['compInfo'] = $this->Generic_model->getData('com_det', '', array('stat' => 1));

        $this->load->view('admin/companyDetails', $dataArr);

        $this->load->view('common/tmpFooter', $data);

    }

    function updateBranding()
    {
        $data_ar1 = array(
            'cmne' => $this->input->post('cmne'),
            'synm' => strtoupper($this->input->post('synm')),
            'cadd' => ucwords(strtolower($this->input->post('cadd'))),
            'ctel' => $this->input->post('ctel'),
            'ceml' => $this->input->post('ceml'),
            //'chot' => $this->input->post('mobi'),
            //'rplg' => $rplg,
            //'cplg' => $cplg,
            //'regn' => strtoupper($this->input->post('rgno')),
            'regd' => $this->input->post('regd'),
            'syln' => $this->input->post('syln'),
            'wbml' => $this->input->post('wbml'),

            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s'),
        );
        $where_arr = array(
            'cmid' => 1
        );
        $result22 = $this->Generic_model->updateData('com_det', $data_ar1, $where_arr);

        // $funcPerm = $this->Generic_model->getFuncPermision('brand');
        // $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Company Details Update ');
        if (count($result22) > 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

}
