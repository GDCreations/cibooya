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
        //redirect('user');

        //$this->load->view('welcome_message');
        if (!empty($_SESSION['userId'])) {
            redirect('user');

        } else {
            $data['sysinfo'] = $this->Generic_model->getData('com_det', array('cmne', 'synm', 'cplg', 'syvr'), array('stat' => 1));
            $this->load->view('common/login', $data);
        }

    }


}
