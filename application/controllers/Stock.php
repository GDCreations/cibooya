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
        $this->load->model('Stock_model');       // load model
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
    function supReg()
    {
        $data['acm'] = 'supMng'; //Module
        $data['acp'] = 'supReg'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('supReg');
        $data2['bank'] = $this->Generic_model->getSortData('bank', '', array('stat' => 1), '', '', 'bkcd', 'ASC');
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
        $this->db->where("(mbno=$mobi OR tele=$mobi)");
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

//CHECK ALREADY ENTERED SUPPLIER NAME </JANAKA 2019-09-20>
    function chk_spName()
    {
        $name = $this->input->post('name');
        $stat = $this->input->post('stat'); //0-Add/1-Edit

        $this->db->select("spnm");
        $this->db->from('supp_mas');
        $this->db->where('spnm', $name);
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
//END ALREADY ENTERED SUPPLIER NAME </JANAKA 2019-09-20>

//CHECK ALREADY ENTERED BANK NUMBER </JANAKA 2019-09-19>
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
//END CHECK ALREADY ENTERED BANK NUMBER </JANAKA 2019-09-19>

//SUPPLIER REGISTRATION </JANAKA 2019-09-19>
    function supp_Regist()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

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
        $this->Generic_model->insertData('sup_bnk_acc', array(
            'spid' => $lstId,
            'bnid' => $this->input->post('bnknm'),
            'brid' => $this->input->post('bnkbr'),
            'acno' => $this->input->post('acno'),
            'dfst' => 1,
            'stat' => 1,
        ));

        $funcPerm = $this->Generic_model->getFuncPermision('supReg');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Supplier Added ($lstId)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END SUPPLIER REGISTRATION </JANAKA 2019-09-19>

//SEARCH SUPPLIER </JANAKA 2019-09-19>
    function searchSupp()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('supReg');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->apvl == 1) {
            $app = "";
        } else {
            $app = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edit = "";
        } else {
            $edit = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rejt = "";
        } else {
            $rejt = "disabled";
        }
        if ($funcPerm[0]->dact == 1) {
            $dac = "";
        } else {
            $dac = "disabled";
        }
        if ($funcPerm[0]->reac == 1) {
            $reac = "";
        } else {
            $reac = "disabled";
        }

        $result = $this->Stock_model->get_suppDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            if ($row->stat == 0) {
                $stat = "<label class='label label-warning'>Pending</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewSupp($row->spid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewSupp($row->spid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $app id='app' data-toggle='modal' data-target='#modal-view' onclick='viewSupp($row->spid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' $rejt onclick='rejectSupp($row->spid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 1) {
                $stat = "<label class='label label-success'>Active</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewSupp($row->spid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewSupp($row->spid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' $dac onclick='inactSupp($row->spid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-hand-stop-o' aria-hidden='true'></i></button>";
            } else if ($row->stat == 2) {
                $stat = "<label class='label label-danger'>Reject</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewSupp($row->spid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 3) {
                $stat = "<label class='label label-indi'>Inactive</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewSupp($row->spid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $reac onclick='reactSupp($row->spid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-hand-stop-o' aria-hidden='true'></i></button>";
            } else {
                $stat = "--";
                $option = "<button type='button' disabled data-toggle='modal' data-target='#modal-view' onclick='viewSupp($row->spid)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='editSupp($row->spid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='approveSupp($row->spid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='rejectSupp($row->spid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->spcd;
            $sub_arr[] = $row->spnm;
            $sub_arr[] = $row->addr;
            $sub_arr[] = $row->mbno;
            $sub_arr[] = $row->innm;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_supp(),
            "recordsFiltered" => $this->Stock_model->count_filtered_supp(),
            "data" => $data,
        );
        echo json_encode($output);
    }
//END SEARCH SUPPLIER </JANAKA 2019-09-19>

//GET SUPPLIER DETAILS </JANAKA 2019-09-20>
    function get_SuppDet()
    {
        $id = $this->input->post('id');
        //Supplier Details
        $this->db->select("sup.*,cr.innm AS crnm,ap.innm AS apnm,md.innm AS mdnm,rj.innm AS rjnm");
        $this->db->from('supp_mas sup');
        $this->db->join('user_mas cr', 'cr.auid=sup.crby');
        $this->db->join('user_mas ap', 'ap.auid=sup.apby', 'LEFT');
        $this->db->join('user_mas md', 'md.auid=sup.mdby', 'LEFT');
        $this->db->join('user_mas rj', 'rj.auid=sup.rjby', 'LEFT');
        $this->db->where("sup.spid=$id");
        $data['spdet'] = $this->db->get()->result();
        //Bank Details
        $this->db->select("bnk.acid,bnk.acno,bnk.dfst,bank.bkcd,bank.bknm,bank_brch.brcd,bank_brch.bcnm");
        $this->db->from('sup_bnk_acc bnk');
        $this->db->join('bank', 'bank.bnid=bnk.bnid');
        $this->db->join('bank_brch', 'bank_brch.brid=bnk.brid');
        $this->db->where("bnk.stat=1 AND spid=$id");
        $data['bkdet'] = $this->db->get()->result();

        echo json_encode($data);
    }
//END GET SUPPLIER DETAILS </JANAKA 2019-09-20>

//ADD NEW SUPPLIER BANK ACCOUNT </JANAKA 2019-09-20>
    function supp_add_bnkAcc()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $spid = $this->input->post('spid');
        $bknm = $this->input->post('bknm');
        $bkbr = $this->input->post('bkbr');
        $acc = $this->input->post('acc');

        $this->Generic_model->insertData('sup_bnk_acc', array(
            'spid' => $spid,
            'bnid' => $bknm,
            'brid' => $bkbr,
            'acno' => $acc,
            'dfst' => 0,
            'stat' => 1
        ));
        $lstid = $this->db->insert_id();

        $funcPerm = $this->Generic_model->getFuncPermision('supReg');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Supplier's Bank Account Added ($lstid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            //Get entered data
            $this->db->select("bnk.acid,bnk.acno,bnk.dfst,bank.bkcd,bank.bknm,bank_brch.brcd,bank_brch.bcnm");
            $this->db->from('sup_bnk_acc bnk');
            $this->db->join('bank', 'bank.bnid=bnk.bnid');
            $this->db->join('bank_brch', 'bank_brch.brid=bnk.brid');
            $this->db->where("bnk.stat=1 AND spid=$spid");
            $data['accDet'] = $this->db->get()->result();
            echo json_encode($data);
        }
    }
//END NEW SUPPLIER BANK ACCOUNT </JANAKA 2019-09-20>

//SUPPLIER UPDATE || APPROVE </JANAKA 2019-09-23>
    function supp_update()
    {
        $func = $this->input->post('func');
        $spid = $this->input->post('spid');

        $this->db->trans_begin(); // SQL TRANSACTION START

        $df = $this->input->post('dfstRd[]');
        $acc = $this->input->post('acnoList[]');

        //accounts updates
        $this->Generic_model->updateData('sup_bnk_acc', array('stat' => 0, 'dfst' => 0), array('spid' => $spid));
        for ($it = 0; $it < sizeof($acc); $it++) {
            if ($acc[$it] == $df[0]) {
                $def = 1;
            } else {
                $def = 0;
            }
            $this->Generic_model->updateData('sup_bnk_acc', array(
                'stat' => 1,
                'dfst' => $def), array('acid' => $acc[$it]));
        }

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
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = $aa;
            }
            $supcd = "S-" . $xx;
        } else {
            $supcd = "S-0001";
        }

        if ($func == 'edit') {
            //Updating supplier details
            $this->Generic_model->updateData('supp_mas', array(
                'spnm' => $this->input->post('name_edt'),
                'addr' => $this->input->post('addr_edt'),
                'mbno' => $this->input->post('mobi_edt'),
                'tele' => $this->input->post('tele_edt'),
                'email' => $this->input->post('email_edt'),
                'dscr' => $this->input->post('remk_edt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('spid' => $spid));

            $funcPerm = $this->Generic_model->getFuncPermision('supReg');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Supplier's Details Updated ($spid)");

        } else if ($func == 'app') {
            //Updating supplier details
            $this->Generic_model->updateData('supp_mas', array(
                'spcd' => $supcd,
                'spnm' => $this->input->post('name_edt'),
                'addr' => $this->input->post('addr_edt'),
                'mbno' => $this->input->post('mobi_edt'),
                'tele' => $this->input->post('tele_edt'),
                'email' => $this->input->post('email_edt'),
                'dscr' => $this->input->post('remk_edt'),
                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('spid' => $spid));

            $funcPerm = $this->Generic_model->getFuncPermision('supReg');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Supplier Approved ($spid)");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END SUPPLIER UPDATE || APPROVE </JANAKA 2019-09-23>

//REJECT SUPPLIER </JANAKA 2019-09-23>
    function supp_Reject()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $spid = $this->input->post('id');
        $this->Generic_model->updateData('supp_mas', array(
            'stat' => 2,
            'rjby' => $_SESSION['userId'],
            'rjdt' => date('Y-m-d H:i:s')
        ), array('spid' => $spid));

        $funcPerm = $this->Generic_model->getFuncPermision('supReg');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Supplier Rejected ($spid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END REJECT SUPPLIER </JANAKA 2019-09-23>

//DEACTIVATE SUPPLIER </JANAKA 2019-09-23>
    function supp_Deactive()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $spid = $this->input->post('id');
        $this->Generic_model->updateData('supp_mas', array(
            'stat' => 3,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('spid' => $spid));

        $funcPerm = $this->Generic_model->getFuncPermision('supReg');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Supplier Deactivated ($spid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END DEACTIVATE SUPPLIER </JANAKA 2019-09-23>

//ACTIVATE SUPPLIER </JANAKA 2019-09-23>
    function supp_Activate()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $spid = $this->input->post('id');
        $this->Generic_model->updateData('supp_mas', array(
            'stat' => 1,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('spid' => $spid));

        $funcPerm = $this->Generic_model->getFuncPermision('supReg');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Supplier Reactivated ($spid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END ACTIVATE SUPPLIER </JANAKA 2019-09-23>
//************************************************
//***       END SUPPLIER REGISTRATION          ***
//************************************************

//************************************************
//***          CATEGORY REGISTRATION           ***
//************************************************
//OPEN PAGE </JANAKA 2019-09-25>
    function catMng()
    {
        $data['acm'] = 'stcCmp'; //Module
        $data['acp'] = 'catMng'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('catMng');
        $data2['bank'] = $this->Generic_model->getSortData('bank', '', array('stat' => 1), '', '', 'bkcd', 'ASC');
        $this->load->view('admin/stock/supplier_Reg', $data2);

        $this->load->view('common/tmpFooter', $data);
    }
//END OPEN PAGE </JANAKA 2019-09-25>
//************************************************
//***          CATEGORY REGISTRATION           ***
//************************************************
}
