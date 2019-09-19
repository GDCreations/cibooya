<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        // Deletes cache for the currently requested URI
        $this->output->delete_cache();
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
        //$user = $this->Generic_model->getMdulPermis('user');    // USER MODULE
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

    }

//************************************************
//***           SUPPLIER REGISTRATION          ***
//************************************************
//OPEN PAGE </JANAKA 2019-09-18>
    function sup_reg()
    {
        $data['acm'] = 'sup_mng'; //Module
        $data['acp'] = 'sup_reg'; //Page
        $data2['bank'] = $this->Generic_model->getSortData('bank', '', array('stat' => 1), '', '', 'bkcd', 'ASC');
        $this->load->view('common/tmpHeader');
        $this->load->view('admin/common/adminHeader');

        $this->load->view('admin/stock/supplier_Reg', $data2);

        $this->load->view('common/tmpFooter', $data);
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

//CHECK ALREADY ENTERED MOBILE NUMBER </JANAKA 2019-09-19>
    function chk_mobile()
    {
        $mobi = $this->input->post('mobi');
        $stat = $this->input->post('stat'); //0-Add/1-Edit

        $this->db->select("mbno,tele");
        $this->db->from('supp_mas');
        $this->db->where("mbno=$mobi OR tele=$mobi");
        if ($stat == 1) {
            $this->db->where("spid!=" . $this->input->post('spid'));
        }
        $res = $this->db->get()->result();

        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK ALREADY ENTERED MOBILE NUMBER </JANAKA 2019-09-19>

//CHECK ALREADY ENTERED MOBILE NUMBER </JANAKA 2019-09-19>
    function chk_bnkAcno()
    {
        $acno = $this->input->post('acno');
        $stat = $this->input->post('stat'); //0-Add/1-Edit

        $this->db->select("acno,acid");
        $this->db->from('sup_bnk_acc');
        $this->db->where("acno=$acno");
        if ($stat == 1) {
            $this->db->where("spid!=" . $this->input->post('spid'));
        }
        $res = $this->db->get()->result();

        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK ALREADY ENTERED MOBILE NUMBER </JANAKA 2019-09-19>

//SUPPLIER REGISTRATION </JANAKA 2019-09-19>
    function supp_Regist()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        //Creating customer next number
        $this->db->select("spcd");
        $this->db->from('supp_mas');
        $this->db->order_by('spcd', 'DESC');
        $this->db->where("stat NOT IN(0,2)");
        $this->db->limit(1);
        $res = $this->db->get()->result();
        if (sizeof($res) > 0) {
            $number = explode('-', $res[0]->spcd);
            $aa = intval($number[1]) + 1;
            $cc = strlen($aa);

            if ($cc == 1) {
                $xx = '0000' . $aa;
            } else if ($cc == 2) {
                $xx = '000' . $aa;
            } else if ($cc == 3) {
                $xx = '00' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            } else if ($cc == 5) {
                $xx = '0' . $aa;
            }
            $supcd = "S-" . $xx;
        } else {
            $supcd = "S-0001";
        }

        //Inserting supplier details
        $this->Generic_model->insertData('supp_mas', array(
            'spcd' => "TMP",
            'spnm' => $this->input->post('name'),
            'addr' => $this->input->post('addr'),
            'mbno' => $this->input->post('mobi'),
            'tele' => $this->input->post('tele'),
            'email' => $this->input->post('email'),
            'dscr' => $this->input->post('remk'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        ));
        $lstId = $this->db->insert_id();
        //Inserting bank details
        $this->Generic_model->insertData('sup_bnk_acc',array(
            'spid'=> $lstId,
            'bnid'=> $this->input->post('bnknm'),
            'brid'=> $this->input->post('bnkbr'),
            'acno'=> $this->input->post('acno'),
            'dfst'=> 1,
            'stat'=> 1,
        ));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END SUPPLIER REGISTRATION </JANAKA 2019-09-19>
//************************************************
//***       END SUPPLIER REGISTRATION          ***
//************************************************
}
