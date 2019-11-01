<?php


class Sale extends CI_Controller
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
//        $this->load->model('Sale_model');      // load model

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

                if (count($chkupdt) > 0 && $_SESSION['role'] != 1) { /// && $_SESSION['role'] != 1
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

    public function sale(){
        $data['acm'] = 'slsModul'; //Module
        $data['acp'] = 'sale'; //Page

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('user/common/userHeader', $per);

        $dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('sale');
        $this->load->view('user/sale/saleMain', $dataArr);
        $this->load->view('common/tmpFooter', $data);
    }
}