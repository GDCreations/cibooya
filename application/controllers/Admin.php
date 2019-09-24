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
        $this->load->model('Admin_model');      // load model

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

    // BEGIN COMMON DATA LOADING
// Get user data
    public function getUser()
    {
        $bid = $this->input->post('brid');
        $uslv = $this->input->post('uslv');

        $this->db->select("auid,fnme,lnme,brch");
        $this->db->from("user_mas");
        $this->db->where('user_mas.usmd  != 1');
        $this->db->where('user_mas.stat', 1);
        if ($bid != 'all') {
            $this->db->where('user_mas.brch ', $bid);
        }
        if ($uslv != 'all') {
            $this->db->where('user_mas.usmd ', $uslv);
        }

        $query = $this->db->get();
        echo json_encode($query->result());
    }


    // END COMMON DATA LOADING


    // COMPANY BRANDING
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
        $this->db->trans_begin(); // SQL TRANSACTION START

        $data_ar1 = array(
            'cmne' => $this->input->post('cmne'),
            'synm' => strtoupper($this->input->post('synm')),
            'cadd' => ucwords(strtolower($this->input->post('cadd'))),
            'ctel' => $this->input->post('ctel'),
            'ceml' => $this->input->post('ceml'),
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

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // SYSTEM POLICY
    public function policyMng()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'policyMng'; //Page

        $this->load->view('common/tmpHeader');
        $this->load->view('admin/common/adminHeader');

        $dataArr['policyinfo'] = $this->Generic_model->getData('sys_policy', '', '');

        $this->load->view('admin/systmPolicy', $dataArr);
        $this->load->view('common/tmpFooter', $data);
    }

    function updatePolicy()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $date = date('Y-m-d H:i:s');

        $digey = $this->input->post('digey');   // DIGITAL EYE CODE ENABLE/ DISABLE
        $eycd = $this->input->post('eycd');     // DIGITAL EYE CODE

        $_01 = array('pov3' => $eycd, 'post' => $digey, 'mdby' => $_SESSION['userId'], 'mddt' => $date);

        $this->Generic_model->updateData('sys_policy', $_01, array('poid' => 1));


        //$funcPerm = $this->Generic_model->getFuncPermision('policyMng');
        //$this->Log_model->userFuncLog($funcPerm[0]->pgid, 'System Policy Update');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // RECENTY ACTIVITY
    public function rcntAct()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'rcntAct'; //Page

        $this->load->view('common/tmpHeader');
        $this->load->view('admin/common/adminHeader');

        $dataArr['branchinfo'] = $this->Generic_model->getBranch();
        $dataArr['uslvlinfo'] = $this->Generic_model->getData('user_level', '', "stat = 1 AND id != 1");

        $this->load->view('admin/recentActivity', $dataArr);
        $this->load->view('common/tmpFooter', $data);
    }

// Recent activity search
    function srchActivit()
    {
        $result = $this->Admin_model->get_recntDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            //$img = "<img src='../uploads/userimg/" . $row->uimg . "'  class='sm-image' title='" . $row->usnm . "' style='width: 27px;height: 27px' />";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] =  $row->usnm . ' (' . $row->brcd . ')';
            if ($row->pnm != '' && $row->func != '') {
                $sub_arr[] = $row->pnm . ' --> ' . $row->func;
            } else if ($row->pnm != '') {
                $sub_arr[] = $row->pnm;
            } else if ($row->func != '') {
                $sub_arr[] = $row->func;
            }
            $date = date_create($row->lgdt);
            $sub_arr[] = date_format($date, 'g:i:s A \o\n l j F Y ');
            //$sub_arr[] = date_format($date, 'g:ia \o\n l jS F Y');
            $sub_arr[] = $row->lgip;

            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->all_recnt(),
            "recordsFiltered" => $this->Admin_model->filtered_recnt(),
            "data" => $data,
        );
        echo json_encode($output);
        //$funcPerm = $this->Generic_model->getFuncPermision('recn_actv');
        //$this->Log_model->userFuncLog($funcPerm[0]->pgid, 'View Recent Activity');

    }


}
