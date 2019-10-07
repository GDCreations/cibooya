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
        $this->load->model('Log_model');        // load model
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
        $data['acm'] = 'stcCmp'; //Module
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

        if ($this->input->post('bnkDtl') == '')
            $bkdt = 0;
        else
            $bkdt = 1;

        //Inserting supplier details
        $this->Generic_model->insertData('supp_mas', array(
            'spcd' => "TMP",
            'spnm' => $this->input->post('name'),
            'addr' => $this->input->post('addr'),
            'mbno' => $this->input->post('mobi'),
            'tele' => $this->input->post('tele'),
            'email' => $this->input->post('email'),
            'dscr' => $this->input->post('remk'),
            'bkdt' => $bkdt,
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        ));
        $lstId = $this->db->insert_id();
        if ($bkdt == 1) {
            //Inserting bank details
            $this->Generic_model->insertData('sup_bnk_acc',
                array(
                    'spid' => $lstId,
                    'bnid' => $this->input->post('bnknm'),
                    'brid' => $this->input->post('bnkbr'),
                    'acno' => $this->input->post('acno'),
                    'dfst' => 1,
                    'stat' => 1,
                ));
        }

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
                    "<button type='button' $dac onclick='inactSupp($row->spid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
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
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
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
        $this->db->select("sup.*,CONCAT(cr.fnme,' ',cr.lnme) AS crnm, CONCAT(ap.fnme,' ',ap.lnme) AS apnm, CONCAT(md.fnme,' ',md.lnme) AS mdnm, CONCAT(rj.fnme,' ',rj.lnme) AS rjnm");
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

        // supplier previous bank account remove the default
        $this->Generic_model->updateData('sup_bnk_acc', array('dfst' => 0,), array('spid' => $spid));

        $this->Generic_model->insertData('sup_bnk_acc',
            array(
                'spid' => $spid,
                'bnid' => $bknm,
                'brid' => $bkbr,
                'acno' => $acc,
                'dfst' => 1,
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

        if ($this->input->post('bnkDtlEdt') == '')
            $bkdt = 0;
        else
            $bkdt = 1;

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
                'bkdt' => $bkdt,
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
                'bkdt' => $bkdt,

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
        $this->load->view('admin/stock/category_Manage', $data2);

        $this->load->view('common/tmpFooter', $data);
    }
//END OPEN PAGE </JANAKA 2019-09-25>

//ADD NEW CATEGORY </JANAKA 2019-09-25>
    function cat_Add()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        //Inserting Category details
        $this->Generic_model->insertData('category', array(
            'ctnm' => $this->input->post('name'),
            'ctcd' => strtoupper($this->input->post('code')),
            'remk' => $this->input->post('remk'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        ));
        $lstId = $this->db->insert_id();

        $funcPerm = $this->Generic_model->getFuncPermision('catMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Category Added ($lstId)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END ADD NEW CATEGORY </JANAKA 2019-09-25>

//CHECK CATEGORY NAME ALREADY EXIST </JANAKA 2019-09-25>
    function chk_catName()
    {
        $stat = $this->input->post('stat');
        $name = $this->input->post('name');
        $ctid = $this->input->post('ctid');

        $this->db->select("ctid");
        $this->db->from('category');
        $this->db->where('ctnm', $name);
        if ($stat == 1) {
            $this->db->where("ctid!=$ctid");
        }
        $res = $this->db->get()->result();

        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK CATEGORY NAME ALREADY EXIST </JANAKA 2019-09-25>

//CHECK CATEGORY CODE ALREADY EXIST </JANAKA 2019-09-25>
    function chk_catCode()
    {
        $stat = $this->input->post('stat');
        $code = $this->input->post('code');
        $ctid = $this->input->post('ctid');

        $this->db->select("ctid");
        $this->db->from('category');
        $this->db->where('ctcd', $code);
        if ($stat == 1) {
            $this->db->where("ctid!=$ctid");
        }
        $res = $this->db->get()->result();

        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK CATEGORY CODE ALREADY EXIST </JANAKA 2019-09-25>

//SEARCH SUPPLIER </JANAKA 2019-09-25>
    function searchCat()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('catMng');

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

        $result = $this->Stock_model->get_catDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            if ($row->stat == 0) {
                $stat = "<label class='label label-warning'>Pending</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewCat($row->ctid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewCat($row->ctid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $app id='app' data-toggle='modal' data-target='#modal-view' onclick='viewCat($row->ctid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' $rejt onclick='rejectCat($row->ctid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 1) {
                $stat = "<label class='label label-success'>Active</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewCat($row->ctid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewCat($row->ctid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' $dac onclick='inactCat($row->ctid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else if ($row->stat == 2) {
                $stat = "<label class='label label-danger'>Reject</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewCat($row->ctid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 3) {
                $stat = "<label class='label label-indi'>Inactive</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewSupp($row->ctid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $reac onclick='reactCat($row->ctid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else {
                $stat = "--";
                $option = "<button type='button' disabled data-toggle='modal' data-target='#modal-view' onclick='viewCat($row->ctid)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='viewCat($row->ctid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='viewCat($row->ctid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='rejectCat($row->ctid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->ctcd;
            $sub_arr[] = $row->ctnm;
            $sub_arr[] = $row->innm;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_cat(),
            "recordsFiltered" => $this->Stock_model->count_filtered_cat(),
            "data" => $data,
        );
        echo json_encode($output);
    }
//END SEARCH SUPPLIER </JANAKA 2019-09-25>

//GET SUPPLIER DETAILS </JANAKA 2019-09-25>
    function get_CatDet()
    {
        $id = $this->input->post('id');
        //Category Details
        $this->db->select("sup.*,CONCAT(cr.fnme,' ',cr.lnme) AS crnm, CONCAT(md.fnme,' ',md.lnme) AS mdnm");
        $this->db->from('category sup');
        $this->db->join('user_mas cr', 'cr.auid=sup.crby');
        $this->db->join('user_mas md', 'md.auid=sup.mdby', 'LEFT');
        $this->db->where("sup.ctid=$id");
        $data = $this->db->get()->result();

        echo json_encode($data);
    }
//END GET SUPPLIER DETAILS </JANAKA 2019-09-25>

//CATEGORY UPDATE || APPROVE </JANAKA 2019-09-25>
    function cat_update()
    {
        $func = $this->input->post('func');
        $ctid = $this->input->post('ctid');

        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($func == 'edit') {
            //Updating supplier details
            $this->Generic_model->updateData('category', array(
                'ctnm' => $this->input->post('name_edt'),
                'ctcd' => strtoupper($this->input->post('code_edt')),
                'remk' => $this->input->post('remk_edt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('ctid' => $ctid));

            $funcPerm = $this->Generic_model->getFuncPermision('catMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Category Details Updated ($ctid)");

        } else if ($func == 'app') {
            //Updating supplier details
            $this->Generic_model->updateData('category', array(
                'ctnm' => $this->input->post('name_edt'),
                'ctcd' => strtoupper($this->input->post('code_edt')),
                'remk' => $this->input->post('remk_edt'),
                'stat' => 1,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('ctid' => $ctid));

            $funcPerm = $this->Generic_model->getFuncPermision('catMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Category Approved ($ctid)");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END CATEGORY UPDATE || APPROVE </JANAKA 2019-09-25

//REJECT CATEGORY </JANAKA 2019-09-25>
    function cat_Reject()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $ctid = $this->input->post('id');
        $this->Generic_model->updateData('category', array(
            'stat' => 2,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('ctid' => $ctid));

        $funcPerm = $this->Generic_model->getFuncPermision('catMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Category Rejected ($ctid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END REJECT CATEGORY </JANAKA 2019-09-25>

//DEACTIVATE CATEGORY </JANAKA 2019-09-25>
    function cat_Deactive()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $ctid = $this->input->post('id');
        $this->Generic_model->updateData('category', array(
            'stat' => 3,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('ctid' => $ctid));

        $funcPerm = $this->Generic_model->getFuncPermision('catMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Category Deactivated ($ctid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END DEACTIVATE CATEGORY </JANAKA 2019-09-25>

//ACTIVATE CATEGORY </JANAKA 2019-09-25>
    function cat_Activate()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $ctid = $this->input->post('id');
        $this->Generic_model->updateData('category', array(
            'stat' => 1,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('ctid' => $ctid));

        $funcPerm = $this->Generic_model->getFuncPermision('catMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Category Reactivated ($ctid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END ACTIVATE CATEGORY </JANAKA 2019-09-25>
//************************************************
//***          CATEGORY REGISTRATION           ***
//************************************************

//************************************************
//***          BRAND REGISTRATION              ***
//************************************************
//OPEN PAGE </JANAKA 2019-09-26>
    function brndMng()
    {
        $data['acm'] = 'stcCmp'; //Module
        $data['acp'] = 'brndMng'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('brndMng');
        $this->load->view('admin/stock/brand_Manage', $data2);

        $this->load->view('common/tmpFooter', $data);
    }
//END OPEN PAGE </JANAKA 2019-09-26>

//ADD NEW BRAND </JANAKA 2019-09-26>
    function brnd_Add()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $code = strtoupper($this->input->post('code'));
        if (!empty($_FILES['logo']['name'])) {
            $flnme = $code;
            $config['upload_path'] = 'uploads/img/brand';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '5000'; //KB
            $config['file_name'] = $flnme;

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('logo')) {
                $uploadData = $this->upload->data();
                $logo = $uploadData['file_name'];
            } else {
                $logo = 'brand-def.png';
            }
        } else {
            $logo = "brand-def.png";
        }

        //Inserting Category details
        $this->Generic_model->insertData('brand', array(
            'bdnm' => $this->input->post('name'),
            'bdcd' => $code,
            'logo' => $logo,
            'remk' => $this->input->post('remk'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        ));
        $lstId = $this->db->insert_id();

        $funcPerm = $this->Generic_model->getFuncPermision('brndMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Brand Added ($lstId)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END ADD NEW CATEGORY </JANAKA 2019-09-26>

//CHECK BRAND NAME ALREADY EXIST </JANAKA 2019-09-26>
    function chk_brdName()
    {
        $stat = $this->input->post('stat');
        $name = $this->input->post('name');
        $bdid = $this->input->post('bdid');

        $this->db->select("bdid");
        $this->db->from('brand');
        $this->db->where('bdnm', $name);
        if ($stat == 1) {
            $this->db->where("bdid!=$bdid");
        }
        $res = $this->db->get()->result();

        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK BRAND NAME ALREADY EXIST </JANAKA 2019-09-26>

//CHECK BRAND CODE ALREADY EXIST </JANAKA 2019-09-26>
    function chk_brdCode()
    {
        $stat = $this->input->post('stat');
        $code = $this->input->post('code');
        $bdid = $this->input->post('bdid');

        $this->db->select("bdid");
        $this->db->from('brand');
        $this->db->where('bdcd', $code);
        if ($stat == 1) {
            $this->db->where("bdid!=$bdid");
        }
        $res = $this->db->get()->result();

        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK BRAND CODE ALREADY EXIST </JANAKA 2019-09-26>

//SEARCH BRAND </JANAKA 2019-09-26>
    function searchBrnd()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('brndMng');

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

        $result = $this->Stock_model->get_brdDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            if ($row->stat == 0) {
                $stat = "<label class='label label-warning'>Pending</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewBrd($row->bdid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewBrd($row->bdid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $app id='app' data-toggle='modal' data-target='#modal-view' onclick='viewBrd($row->bdid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' $rejt onclick='rejectBrd($row->bdid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 1) {
                $stat = "<label class='label label-success'>Active</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewBrd($row->bdid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewBrd($row->bdid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' $dac onclick='inactBrd($row->bdid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else if ($row->stat == 2) {
                $stat = "<label class='label label-danger'>Reject</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewBrd($row->bdid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 3) {
                $stat = "<label class='label label-indi'>Inactive</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewBrd($row->bdid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $reac onclick='reactBrd($row->bdid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else {
                $stat = "--";
                $option = "<button type='button' disabled data-toggle='modal' data-target='#modal-view' onclick='viewBrd($row->bdid)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='viewBrd($row->bdid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='viewBrd($row->bdid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='rejectBrd($row->bdid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            }

            $img = "<img class='sm-image' src='" . base_url() . "uploads/img/brand/" . $row->logo . "'/>";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->bdcd;
            $sub_arr[] = $img;
            $sub_arr[] = $row->bdnm;
            $sub_arr[] = $row->innm;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_brd(),
            "recordsFiltered" => $this->Stock_model->count_filtered_brd(),
            "data" => $data,
        );
        echo json_encode($output);
    }
//END SEARCH BRAND </JANAKA 2019-09-26>

//GET BRAND DETAILS </JANAKA 2019-09-26>
    function get_BrdDet()
    {
        $id = $this->input->post('id');
        //Category Details
        $this->db->select("sup.*,CONCAT(cr.fnme,' ',cr.lnme) AS crnm, CONCAT(md.fnme,' ',md.lnme) AS mdnm");
        $this->db->from('brand sup');
        $this->db->join('user_mas cr', 'cr.auid=sup.crby');
        $this->db->join('user_mas md', 'md.auid=sup.mdby', 'LEFT');
        $this->db->where("sup.bdid=$id");
        $data = $this->db->get()->result();

        echo json_encode($data);
    }
//END GET BRAND DETAILS </JANAKA 2019-09-26>

//BRAND UPDATE || APPROVE </JANAKA 2019-09-26>
    function brd_update()
    {
        $func = $this->input->post('func');
        $bdid = $this->input->post('bdid');

        $this->db->trans_begin(); // SQL TRANSACTION START

        $code = strtoupper($this->input->post('code_edt'));
        if (!empty($_FILES['logo_edt']['name'])) {
            $flnme = $code;
            $config['upload_path'] = 'uploads/img/brand';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '5000'; //KB
            $config['file_name'] = $flnme;

            $imagename = $this->input->post('brd_logo');
            if ($imagename != 'brand-def.png') {
                unlink('uploads/img/brand/' . $imagename);
            }

            //Load upload library and initialize configuration
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('logo_edt')) {
                $uploadData = $this->upload->data();
                $logo = $uploadData['file_name'];
            } else {
                $logo = 'brand-def.png';
            }
        } else {
            $logo = $this->input->post('brd_logo');
        }

        if ($func == 'edit') {
            //Updating supplier details
            $this->Generic_model->updateData('brand', array(
                'bdnm' => $this->input->post('name_edt'),
                'bdcd' => $code,
                'logo' => $logo,
                'remk' => $this->input->post('remk_edt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('bdid' => $bdid));

            $funcPerm = $this->Generic_model->getFuncPermision('brndMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Brand Details Updated ($bdid)");

        } else if ($func == 'app') {
            //Updating supplier details
            $this->Generic_model->updateData('brand', array(
                'bdnm' => $this->input->post('name_edt'),
                'bdcd' => $code,
                'logo' => $logo,
                'remk' => $this->input->post('remk_edt'),
                'stat' => 1,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('bdid' => $bdid));

            $funcPerm = $this->Generic_model->getFuncPermision('brndMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Brand Approved ($bdid)");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END BRAND UPDATE || APPROVE </JANAKA 2019-09-26>

//REJECT BRAND </JANAKA 2019-09-26>
    function brd_Reject()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $bdid = $this->input->post('id');
        $this->Generic_model->updateData('brand', array(
            'stat' => 2,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('bdid' => $bdid));

        $funcPerm = $this->Generic_model->getFuncPermision('brndMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Brand Rejected ($bdid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END REJECT BRAND </JANAKA 2019-09-26>

//DEACTIVATE BRAND </JANAKA 2019-09-26>
    function brd_Deactive()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $bdid = $this->input->post('id');
        $this->Generic_model->updateData('brand', array(
            'stat' => 3,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('bdid' => $bdid));

        $funcPerm = $this->Generic_model->getFuncPermision('brndMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Brand Deactivated ($bdid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END DEACTIVATE BRAND </JANAKA 2019-09-26>

//ACTIVATE BRAND </JANAKA 2019-09-26>
    function brd_Activate()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $bdid = $this->input->post('id');
        $this->Generic_model->updateData('brand', array(
            'stat' => 1,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('bdid' => $bdid));

        $funcPerm = $this->Generic_model->getFuncPermision('brndMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Brand Reactivated ($bdid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END ACTIVATE BRAND </JANAKA 2019-09-26>
//************************************************
//***      END BRAND REGISTRATION              ***
//************************************************

//************************************************
//***          TYPE REGISTRATION               ***
//************************************************
//OPEN PAGE </JANAKA 2019-09-27>
    function typeMng()
    {
        $data['acm'] = 'stcCmp'; //Module
        $data['acp'] = 'typeMng'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('typeMng');
        $this->load->view('admin/stock/type_Manage', $data2);

        $this->load->view('common/tmpFooter', $data);
    }
//END OPEN PAGE </JANAKA 2019-09-27>

//CHECK TYPE NAME ALREADY EXIST </JANAKA 2019-09-27>
    function chk_typName()
    {
        $stat = $this->input->post('stat');
        $name = $this->input->post('name');
        $tpid = $this->input->post('tpid');

        $this->db->select("tpid");
        $this->db->from('type');
        $this->db->where('tpnm', $name);
        if ($stat == 1) {
            $this->db->where("tpid!=$tpid");
        }
        $res = $this->db->get()->result();

        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK TYPE NAME ALREADY EXIST </JANAKA 2019-09-27>

//CHECK TYPE CODE ALREADY EXIST </JANAKA 2019-09-27>
    function chk_typCode()
    {
        $stat = $this->input->post('stat');
        $code = $this->input->post('code');
        $tpid = $this->input->post('tpid');

        $this->db->select("tpid");
        $this->db->from('type');
        $this->db->where('tpcd', $code);
        if ($stat == 1) {
            $this->db->where("tpid!=$tpid");
        }
        $res = $this->db->get()->result();

        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK TYPE CODE ALREADY EXIST </JANAKA 2019-09-27>

//ADD NEW TYPE </JANAKA 2019-09-27>
    function typ_Add()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $code = strtoupper($this->input->post('code'));
        //Inserting Brand details
        $this->Generic_model->insertData('type', array(
            'tpnm' => $this->input->post('name'),
            'tpcd' => $code,
            'remk' => $this->input->post('remk'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        ));
        $lstId = $this->db->insert_id();

        $funcPerm = $this->Generic_model->getFuncPermision('typeMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Type Added ($lstId)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END ADD NEW TYPE </JANAKA 2019-09-27>

//SEARCH TYPE </JANAKA 2019-09-27>
    function searchTyp()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('typeMng');

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

        $result = $this->Stock_model->get_typDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            if ($row->stat == 0) {
                $stat = "<label class='label label-warning'>Pending</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewTyp($row->tpid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewTyp($row->tpid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $app id='app' data-toggle='modal' data-target='#modal-view' onclick='viewTyp($row->tpid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' $rejt onclick='rejectTyp($row->tpid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 1) {
                $stat = "<label class='label label-success'>Active</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewTyp($row->tpid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewTyp($row->tpid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' $dac onclick='inactTyp($row->tpid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else if ($row->stat == 2) {
                $stat = "<label class='label label-danger'>Reject</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewTyp($row->tpid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 3) {
                $stat = "<label class='label label-indi'>Inactive</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewTyp($row->tpid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $reac onclick='reactTyp($row->tpid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else {
                $stat = "--";
                $option = "<button type='button' disabled data-toggle='modal' data-target='#modal-view' onclick='viewTyp($row->tpid)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='viewTyp($row->tpid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='viewTyp($row->tpid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='rejectTyp($row->tpid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->tpcd;
            $sub_arr[] = $row->tpnm;
            $sub_arr[] = $row->innm;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_typ(),
            "recordsFiltered" => $this->Stock_model->count_filtered_typ(),
            "data" => $data,
        );
        echo json_encode($output);
    }
//END SEARCH TYPE </JANAKA 2019-09-27>

//GET TYPE DETAILS </JANAKA 2019-09-27>
    function get_TypDet()
    {
        $id = $this->input->post('id');
        //Category Details
        $this->db->select("sup.*,CONCAT(cr.fnme,' ',cr.lnme) AS crnm, CONCAT(md.fnme,' ',md.lnme) AS mdnm");
        $this->db->from('type sup');
        $this->db->join('user_mas cr', 'cr.auid=sup.crby');
        $this->db->join('user_mas md', 'md.auid=sup.mdby', 'LEFT');
        $this->db->where("sup.tpid=$id");
        $data = $this->db->get()->result();

        echo json_encode($data);
    }
//END GET TYPE DETAILS </JANAKA 2019-09-27>

//TYPE UPDATE || APPROVE </JANAKA 2019-09-27>
    function typ_update()
    {
        $func = $this->input->post('func');
        $tpid = $this->input->post('tpid');

        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($func == 'edit') {
            //Updating supplier details
            $this->Generic_model->updateData('type', array(
                'tpnm' => $this->input->post('name_edt'),
                'tpcd' => strtoupper($this->input->post('code_edt')),
                'remk' => $this->input->post('remk_edt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('tpid' => $tpid));

            $funcPerm = $this->Generic_model->getFuncPermision('typeMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Type Details Updated ($tpid)");

        } else if ($func == 'app') {
            //Updating supplier details
            $this->Generic_model->updateData('type', array(
                'tpnm' => $this->input->post('name_edt'),
                'tpcd' => strtoupper($this->input->post('code_edt')),
                'remk' => $this->input->post('remk_edt'),
                'stat' => 1,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('tpid' => $tpid));

            $funcPerm = $this->Generic_model->getFuncPermision('typeMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Type Approved ($tpid)");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END TYPE UPDATE || APPROVE </JANAKA 2019-09-27>

//REJECT TYPE </JANAKA 2019-09-27>
    function typ_Reject()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $tpid = $this->input->post('id');
        $this->Generic_model->updateData('type', array(
            'stat' => 2,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('tpid' => $tpid));

        $funcPerm = $this->Generic_model->getFuncPermision('typeMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Type Rejected ($tpid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END REJECT TYPE </JANAKA 2019-09-27>

//DEACTIVATE TYPE </JANAKA 2019-09-27>
    function typ_Deactive()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $tpid = $this->input->post('id');
        $this->Generic_model->updateData('type', array(
            'stat' => 3,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('tpid' => $tpid));

        $funcPerm = $this->Generic_model->getFuncPermision('typeMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Type Deactivated ($tpid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END DEACTIVATE TYPE </JANAKA 2019-09-27>

//ACTIVATE TYPE </JANAKA 2019-09-27>
    function typ_Activate()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $tpid = $this->input->post('id');
        $this->Generic_model->updateData('type', array(
            'stat' => 1,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('tpid' => $tpid));

        $funcPerm = $this->Generic_model->getFuncPermision('typeMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Type Reactivated ($tpid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END ACTIVATE TYPE </JANAKA 2019-09-27>
//************************************************
//***      END TYPE REGISTRATION               ***
//************************************************

//************************************************
//***          ITEM REGISTRATION               ***
//************************************************
//OPEN PAGE </JANAKA 2019-09-30>
    function itemMng()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'itemMng'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('itemMng');
        $data2['category'] = $this->Generic_model->getData('category', array('ctid', 'ctcd', 'ctnm', 'stat'), "stat IN(1,3)");
        $data2['brand'] = $this->Generic_model->getData('brand', array('bdid', 'bdcd', 'bdnm', 'logo', 'stat'), "stat IN(1,3)");
        $data2['type'] = $this->Generic_model->getData('type', array('tpid', 'tpcd', 'tpnm', 'stat'), "stat IN(1,3)");
        $data2['nature'] = $this->Generic_model->getData('nature', array('ntid', 'ntnm', 'dscr'), array('stat' => 1));
        $data2['store'] = $this->Generic_model->getData('str_type', array('strid', 'stnm'), array('stat' => 1));
        $data2['storeScl'] = $this->Generic_model->getData('scale', array('slid', 'scl', 'scnm'), array('stat' => 1));
        $this->load->view('admin/stock/item_Manage', $data2);

        $this->load->view('common/tmpFooter', $data);
    }
//END OPEN PAGE </JANAKA 2019-09-30>

//CHECK ALREADY EXIST ITEM NAME </JANAKA 2019-10-01>
    function chk_itmName()
    {
        $name = $this->input->post('name');
        $id = $this->input->post('itid');
        $stat = $this->input->post('stat');

        $this->db->select("itid");
        $this->db->from('item');
        $this->db->where('itnm', $name);
        if ($stat == 1) {
            $this->db->where("itid!=$id");
        }
        $res = $this->db->get()->result();
        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK ALREADY EXIST ITEM NAME </JANAKA 2019-10-01>

//CHECK ALREADY EXIST ITEM CODE </JANAKA 2019-10-01>
    function chk_itmCode()
    {
        $it_code = $this->input->post('it_code');
        $id = $this->input->post('itid');
        $stat = $this->input->post('stat');

        $this->db->select("itid");
        $this->db->from('item');
        $this->db->where('itcd', $it_code);
        if ($stat == 1) {
            $this->db->where("itid!=$id");
        }
        $res = $this->db->get()->result();
        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK ALREADY EXIST ITEM CODE </JANAKA 2019-10-01>

//CHECK ALREADY EXIST MODEL </JANAKA 2019-10-01>
    function chk_mdlName()
    {
        $model = $this->input->post('model');
        $id = $this->input->post('itid');
        $stat = $this->input->post('stat');

        $this->db->select("itid");
        $this->db->from('item');
        $this->db->where('mdl', $model);
        if ($stat == 1) {
            $this->db->where("itid!=$id");
        }
        $res = $this->db->get()->result();
        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK ALREADY EXIST MODEL </JANAKA 2019-10-01>

//CHECK ALREADY EXIST MODEL CODE </JANAKA 2019-10-01>
    function chk_mdlCode()
    {
        $md_code = $this->input->post('md_code');
        $id = $this->input->post('itid');
        $stat = $this->input->post('stat');

        $this->db->select("itid");
        $this->db->from('item');
        $this->db->where('mlcd', $md_code);
        if ($stat == 1) {
            $this->db->where("itid!=$id");
        }
        $res = $this->db->get()->result();
        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK ALREADY EXIST MODEL CODE </JANAKA 2019-10-01>

//ADD NEW ITEM </JANAKA 2019-10-01>
    function item_Add()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $code = strtoupper($this->input->post('it_code'));
        $year = date('Y');

        $this->Generic_model->insertData('item', array(
            'ctid' => $this->input->post('cat'),
            'bdid' => $this->input->post('brd'),
            'tpid' => $this->input->post('typ'),
            'ntid' => $this->input->post('ntr'),
            'strid' => $this->input->post('strtp'),
            'itnm' => $this->input->post('name'),
            'itcd' => strtoupper($this->input->post('it_code')),
            'mdl' => $this->input->post('model'),
            'mlcd' => strtoupper($this->input->post('md_code')),
            'szof' => $this->input->post('szof'),
            'size' => $this->input->post('size'),
            'clr' => $this->input->post('clrnm'),
            'clcd' => $this->input->post('clr'),
            'dscr' => $this->input->post('dscr'),
            'scli' => $this->input->post('strscl'),
            'mxlv' => $this->input->post('mxlv'),
            'stat' => 0,
            'remk' => $this->input->post('remk'),
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        ));
        $lstId = $this->db->insert_id();

        if (!empty($_FILES['pics']['name'][0])) {
            $flCount = sizeof($_FILES['pics']['name']);
            $files = $_FILES['pics'];

            for ($it = 0; $it < $flCount; $it++) {
                if (is_dir('uploads/img/item/' . $year)) {
                    $config['upload_path'] = 'uploads/img/item/' . $year;  //'uploads/images/'
                } else {
                    mkdir('uploads/img/item/' . $year, 0777, true);
                    $config['upload_path'] = 'uploads/img/item/' . $year;  //'uploads/images/'
                }

                $flnme = $code . '_' . (sizeof(glob("uploads/img/item/$year/*")) + 1);
                $config['allowed_types'] = 'jpg|png|jpeg';
//                $config['encrypt_name'] = true;
                $config['max_size'] = '5000'; //KB
                $config['file_name'] = $flnme;
                //Load upload library and initialize configuration
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                $_FILES['pics']['name'] = $files['name'][$it];
                $_FILES['pics']['type'] = $files['type'][$it];
                $_FILES['pics']['tmp_name'] = $files['tmp_name'][$it];
                $_FILES['pics']['error'] = $files['error'][$it];
                $_FILES['pics']['size'] = $files['size'][$it];

                if ($this->upload->do_upload('pics')) {
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $this->Generic_model->insertData('item_pics', array(
                        'itid' => $lstId,
                        'pcnm' => $picture,
                        'size' => $_FILES['pics']['size'],
                        'stat' => 1,
                        'crby' => $_SESSION['userId'],
                        'crdt' => date('Y-m-d H:i:s'),
                    ));
                }
            }
        }

        $funcPerm = $this->Generic_model->getFuncPermision('itemMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Item Added ($lstId)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END ADD NEW ITEM </JANAKA 2019-10-01>

//SEARCH ITEMS
    function searchItem()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('itemMng');

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

        $result = $this->Stock_model->get_itmDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            if ($row->stat == 0) {
                $stat = "<label class='label label-warning'>Pending</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewItm($row->itid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewItm($row->itid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $app id='app' data-toggle='modal' data-target='#modal-view' onclick='viewItm($row->itid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' $rejt onclick='rejectItm($row->itid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 1) {
                $stat = "<label class='label label-success'>Active</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewItm($row->itid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewItm($row->itid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' $dac onclick='inactItm($row->itid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else if ($row->stat == 2) {
                $stat = "<label class='label label-danger'>Reject</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewItm($row->itid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 3) {
                $stat = "<label class='label label-indi'>Inactive</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewItm($row->itid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $reac onclick='reactItm($row->itid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else {
                $stat = "--";
                $option = "<button type='button' disabled data-toggle='modal' data-target='#modal-view' onclick='viewItm($row->itid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='viewItm($row->itid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='viewItm($row->itid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='rejectItm($row->itid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->itcd;
            $sub_arr[] = "<span data-html='true' data-toggle='tooltip' data-placement='top' title='' data-original-title='$row->dscr'>" . $row->itnm . "</span>";
            $sub_arr[] = "<span data-html='true' data-toggle='tooltip' data-placement='top' title='' data-original-title='$row->ctnm'>" . $row->ctcd . "</span>";
            $sub_arr[] = "<span data-html='true' data-toggle='tooltip' data-placement='top' title='' data-original-title='$row->bdnm'>" . $row->bdcd . "</span>";
            $sub_arr[] = "<span data-html='true' data-toggle='tooltip' data-placement='top' title='' data-original-title='$row->tpnm'>" . $row->tpcd . "</span>";
            $sub_arr[] = $row->mdl;
            $sub_arr[] = $row->mlcd;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_itm(),
            "recordsFiltered" => $this->Stock_model->count_filtered_itm(),
            "data" => $data,
        );
        echo json_encode($output);
    }
//END SEARCH ITEMS

//GET ITEM DETAILS
    function get_ItmDet()
    {
        $id = $this->input->post('id');

        $this->db->select("item.*,
        CONCAT(cr.fnme,' ',cr.lnme) AS crnm, CONCAT(ap.fnme,' ',ap.lnme) AS apnm, CONCAT(md.fnme,' ',md.lnme) AS mdnm, CONCAT(rj.fnme,' ',rj.lnme) AS rjnm");
        $this->db->from('item');
        $this->db->join('user_mas cr', 'cr.auid=item.crby');
        $this->db->join('user_mas ap', 'ap.auid=item.apby', 'LEFT');
        $this->db->join('user_mas md', 'md.auid=item.mdby', 'LEFT');
        $this->db->join('user_mas rj', 'rj.auid=item.rjby', 'LEFT');
        $this->db->where('item.itid', $id);
        $res['item'] = $this->db->get()->result();

        $this->db->select("*");
        $this->db->from('item_pics');
        $this->db->where("itid=$id AND stat=1");
        $res['pics'] = $this->db->get()->result();
        echo json_encode($res);
    }
//END GET ITEM DETAILS

//UPDATE & APPROVE ITEM </JANAKA 2019-10-02>
    function itm_update()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $code = strtoupper($this->input->post('it_code_edt'));
        $id = $this->input->post('itid');
        $func = $this->input->post('func');
        $year = date('Y');

        if ($func == 'edit') {
            $msg = "Item Updated";
            $this->Generic_model->updateData('item', array(
                'ctid' => $this->input->post('cat_edt'),
                'bdid' => $this->input->post('brd_edt'),
                'tpid' => $this->input->post('typ_edt'),
                'ntid' => $this->input->post('ntr_edt'),
                'strid' => $this->input->post('strtp_edt'),
                'itnm' => $this->input->post('name_edt'),
                'itcd' => strtoupper($this->input->post('it_code_edt')),
                'mdl' => $this->input->post('model_edt'),
                'mlcd' => strtoupper($this->input->post('md_code_edt')),
                'szof' => $this->input->post('szof_edt'),
                'size' => $this->input->post('size_edt'),
                'clr' => $this->input->post('clrnm_edt'),
                'clcd' => $this->input->post('clr_edt'),
                'dscr' => $this->input->post('dscr_edt'),
                'scli' => $this->input->post('strscl_edt'),
                'mxlv' => $this->input->post('mxlvEdt'),
                'remk' => $this->input->post('remk_edt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('itid' => $id));
        } else if ($func == 'app') {
            $msg = "Item Approved";
            $this->Generic_model->updateData('item', array(
                'ctid' => $this->input->post('cat_edt'),
                'bdid' => $this->input->post('brd_edt'),
                'tpid' => $this->input->post('typ_edt'),
                'ntid' => $this->input->post('ntr_edt'),
                'strid' => $this->input->post('strtp_edt'),
                'itnm' => $this->input->post('name_edt'),
                'itcd' => strtoupper($this->input->post('it_code_edt')),
                'mdl' => $this->input->post('model_edt'),
                'mlcd' => strtoupper($this->input->post('md_code_edt')),
                'szof' => $this->input->post('szof_edt'),
                'size' => $this->input->post('size_edt'),
                'clr' => $this->input->post('clrnm_edt'),
                'clcd' => $this->input->post('clr_edt'),
                'dscr' => $this->input->post('dscr_edt'),
                'scli' => $this->input->post('strscl_edt'),
                'mxlv' => $this->input->post('mxlvEdt'),
                'stat' => 1,
                'remk' => $this->input->post('remk_edt'),
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            ), array('itid' => $id));
        }

        if (!empty($_FILES['pics_edt']['name'][0])) {
            $flCount = sizeof($_FILES['pics_edt']['name']);
            $files = $_FILES['pics_edt'];
            $hsImg = $this->input->post('hsImg');

            if ($hsImg == 1) {//unlink exist images
                //Get Exist Pics
                $this->db->select("pcid,pcnm,crdt");
                $this->db->from('item_pics');
                $this->db->where("itid=$id AND stat=1");
                $ePics = $this->db->get()->result();
                foreach ($ePics as $pic) {
                    unlink('uploads/img/item/' . date('Y', strtotime($pic->crdt)) . "/" . $pic->pcnm);
                    $this->Generic_model->updateData('item_pics', array('stat' => 0), array('pcid' => $pic->pcid));
                }
            }

            for ($it = 0; $it < $flCount; $it++) {
                if (is_dir('uploads/img/item/' . $year)) {
                    $config['upload_path'] = 'uploads/img/item/' . $year;  //'uploads/images/'
                } else {
                    mkdir('uploads/img/item/' . $year, 0777, true);
                    $config['upload_path'] = 'uploads/img/item/' . $year;  //'uploads/images/'
                }

                $flnme = $code . '_' . (sizeof(glob("uploads/img/item/$year/*")) + 1);
                $config['allowed_types'] = 'jpg|png|jpeg';
//                $config['encrypt_name'] = true;
                $config['max_size'] = '5000'; //KB
                $config['file_name'] = $flnme;
                //Load upload library and initialize configuration
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                $_FILES['pics_edt']['name'] = $files['name'][$it];
                $_FILES['pics_edt']['type'] = $files['type'][$it];
                $_FILES['pics_edt']['tmp_name'] = $files['tmp_name'][$it];
                $_FILES['pics_edt']['error'] = $files['error'][$it];
                $_FILES['pics_edt']['size'] = $files['size'][$it];

                if ($this->upload->do_upload('pics_edt')) {
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $this->Generic_model->insertData('item_pics', array(
                        'itid' => $id,
                        'pcnm' => $picture,
                        'size' => $_FILES['pics_edt']['size'],
                        'stat' => 1,
                        'crby' => $_SESSION['userId'],
                        'crdt' => date('Y-m-d H:i:s'),
                    ));
                }
            }
        }

        $funcPerm = $this->Generic_model->getFuncPermision('itemMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "$msg ($id)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END UPDATE & APPROVE ITEM </JANAKA 2019-10-02>

//REJECT ITEM </JANAKA 2019-10-02>
    function itm_Reject()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $id = $this->input->post('id');
        $this->Generic_model->updateData('item', array(
            'stat' => 2,
            'rjby' => $_SESSION['userId'],
            'rjdt' => date('Y-m-d H:i:s')
        ), array('itid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('itemMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Item Rejected ($id)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END REJECT ITEM </JANAKA 2019-10-02>

//DEACTIVATE ITEM </JANAKA 2019-10-02>
    function itm_Deactive()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $id = $this->input->post('id');
        $this->Generic_model->updateData('item', array(
            'stat' => 3,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('itid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('itemMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Item Deactivated ($id)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END DEACTIVATE ITEM </JANAKA 2019-10-02>

//ACTIVATE ITEM </JANAKA 2019-10-02>
    function itm_Activate()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $id = $this->input->post('id');
        $this->Generic_model->updateData('item', array(
            'stat' => 1,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('itid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('itemMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Item Reactivated ($id)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END ACTIVATE ITEM </JANAKA 2019-10-02>
//************************************************
//***      END ITEM REGISTRATION               ***
//************************************************

//************************************************
//***           WAREHOUSE REGISTRATION         ***
//************************************************
//OPEN PAGE </JANAKA 2019-10-02>
    function whsMng()
    {
        $data['acm'] = 'stcCmp'; //Module
        $data['acp'] = 'whsMng'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('whsMng');
        $this->load->view('admin/stock/warehouse_Manage', $data2);

        $this->load->view('common/tmpFooter', $data);
    }
//END OPEN PAGE </JANAKA 2019-10-02>

//WAREHOUSE REGISTRATION </JANAKA 2019-10-03>
    function wh_Add()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        //Inserting supplier details
        $this->Generic_model->insertData('stock_wh', array(
            'whcd' => $this->input->post('code'),
            'whnm' => $this->input->post('name'),
            'addr' => $this->input->post('addr'),
            'mobi' => $this->input->post('mobi'),
            'tele' => $this->input->post('tele'),
            'email' => $this->input->post('email'),
            'dscr' => $this->input->post('remk'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        ));
        $lstId = $this->db->insert_id();

        $funcPerm = $this->Generic_model->getFuncPermision('whsMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Warehouse Added ($lstId)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END WAREHOUSE REGISTRATION </JANAKA 2019-10-03>

//CHECK EXIST WAREHOUSE NAME
    function chk_whName()
    {
        $name = $this->input->post('name');
        $stat = $this->input->post('stat'); //0-Add/1-Edit

        $this->db->select("whid");
        $this->db->from('stock_wh');
        $this->db->where('whnm', $name);
        if ($stat == 1) {
            $this->db->where("whid!=" . $this->input->post('whid'));
        }
        $res = $this->db->get()->result();
        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK EXIST WAREHOUSE NAME

//CHECK EXIST WAREHOUSE CODE
    function chk_whCode()
    {
        $code = $this->input->post('code');
        $stat = $this->input->post('stat'); //0-Add/1-Edit

        $this->db->select("whid");
        $this->db->from('stock_wh');
        $this->db->where('whcd', $code);
        if ($stat == 1) {
            $this->db->where("whid!=" . $this->input->post('whid'));
        }
        $res = $this->db->get()->result();
        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
//END CHECK EXIST WAREHOUSE CODE

//SEARCH WAREHOUSE </JANAKA 2019-10-03>
    function searchWh()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('whsMng');

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

        $result = $this->Stock_model->get_whDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            if ($row->stat == 0) {
                $stat = "<label class='label label-warning'>Pending</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewWh($row->whid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewWh($row->whid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $app id='app' data-toggle='modal' data-target='#modal-view' onclick='viewWh($row->whid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' $rejt onclick='rejectWh($row->whid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 1) {
                $stat = "<label class='label label-success'>Active</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewWh($row->whid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewWh($row->whid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' $dac onclick='inactWh($row->whid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else if ($row->stat == 2) {
                $stat = "<label class='label label-danger'>Reject</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewWh($row->whid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 3) {
                $stat = "<label class='label label-indi'>Inactive</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewWh($row->whid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $reac onclick='reactWh($row->whid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else {
                $stat = "--";
                $option = "<button type='button' disabled data-toggle='modal' data-target='#modal-view' onclick='viewWh($row->whid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='editWh($row->whid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='approveWh($row->whid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='rejectWh($row->whid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->whcd;
            $sub_arr[] = $row->whnm;
            $sub_arr[] = $row->mobi . "<span style='color: dodgerblue; font-weight: bold'> / </span>" . $row->tele;
            $sub_arr[] = $row->addr;
            $sub_arr[] = $row->crnm;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_wh(),
            "recordsFiltered" => $this->Stock_model->count_filtered_wh(),
            "data" => $data,
        );
        echo json_encode($output);
    }
//END SEARCH WAREHOUSE </JANAKA 2019-10-03>

//GET WAREHOUSE DETAILS </JANAKA 2019-10-03>
    function get_WhDet()
    {
        $id = $this->input->post('id');
        //Supplier Details
        $this->db->select("sup.*,CONCAT(cr.fnme,' ',cr.lnme) AS crnm,CONCAT(md.fnme,' ',md.lnme) AS mdnm");
        $this->db->from('stock_wh sup');
        $this->db->join('user_mas cr', 'cr.auid=sup.crby');
        $this->db->join('user_mas md', 'md.auid=sup.mdby', 'LEFT');
        $this->db->where("sup.whid=$id");
        $data = $this->db->get()->result();

        echo json_encode($data);
    }
//END GET WAREHOUSE DETAILS </JANAKA 2019-10-03>

//SUPPLIER UPDATE || APPROVE </JANAKA 2019-09-23>
    function wh_update()
    {
        $func = $this->input->post('func');
        $id = $this->input->post('whid');

        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($func == 'edit') {
            //Updating supplier details
            $this->Generic_model->updateData('stock_wh', array(
                'whnm' => $this->input->post('name_edt'),
                'whcd' => $this->input->post('code_edt'),
                'addr' => $this->input->post('addr_edt'),
                'mobi' => $this->input->post('mobi_edt'),
                'tele' => $this->input->post('tele_edt'),
                'email' => $this->input->post('email_edt'),
                'dscr' => $this->input->post('remk_edt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('whid' => $id));

            $funcPerm = $this->Generic_model->getFuncPermision('whsMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Warehous Details Updated ($id)");

        } else if ($func == 'app') {
            //Updating supplier details
            $this->Generic_model->updateData('stock_wh', array(
                'whnm' => $this->input->post('name_edt'),
                'whcd' => $this->input->post('code_edt'),
                'addr' => $this->input->post('addr_edt'),
                'mobi' => $this->input->post('mobi_edt'),
                'tele' => $this->input->post('tele_edt'),
                'email' => $this->input->post('email_edt'),
                'dscr' => $this->input->post('remk_edt'),
                'stat' => 1,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('whid' => $id));

            $funcPerm = $this->Generic_model->getFuncPermision('whsMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Warehouse Approved ($id)");
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
    function wh_Reject()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $id = $this->input->post('id');
        $this->Generic_model->updateData('stock_wh', array(
            'stat' => 2,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('whid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('whsMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Warehouse Rejected ($id)");

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
    function wh_Deactive()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $id = $this->input->post('id');
        $this->Generic_model->updateData('stock_wh', array(
            'stat' => 3,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('whid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('whsMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Warehouse Deactivated ($id)");

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
    function wh_Activate()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $id = $this->input->post('id');
        $this->Generic_model->updateData('stock_wh', array(
            'stat' => 1,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('whid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('whsMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Warehouse Reactivated ($id)");

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
//***       END WAREHOUSE REGISTRATION         ***
//************************************************

//************************************************
//***               PURCHASE ORDER             ***
//************************************************
//OPEN PAGE </JANAKA 2019-10-03>
    function pchOdr()
    {
        $data['acm'] = 'stcAcs'; //Module
        $data['acp'] = 'pchOdr'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('pchOdr');
        $data2['supplier'] = $this->Generic_model->getData('supp_mas', array('spid', 'spcd', 'spnm'), array('stat' => 1));
        $data2['warehouse'] = $this->Generic_model->getData('stock_wh', array('whid', 'whcd', 'whnm'), array('stat' => 1));
        //Item With Storing Scale
        $this->db->select("itid,itcd,itnm,slid,scnm,scl");
        $this->db->from('item');
        $this->db->join('scale', 'scale.slid=item.scli');
        $this->db->where('item.stat', 1);
        $data2['item'] = $this->db->get()->result();
        $this->load->view('admin/stock/purchase_Order', $data2);

        $this->load->view('common/tmpFooter', $data);
    }
//END OPEN PAGE </JANAKA 2019-10-03>

//CHECK MAX ITEM LEVEL AND AVAILABLE COUNT
    function chk_Mx_ItmLvl()
    {
        $qnty = $this->input->post('qnty');

        $this->Stock_model->qty_status();
        $res = $this->Stock_model->qty_status();
        $ttl = $res[0]->penpoqty + $res[0]->togrnqty + $res[0]->pengrnqty + $res[0]->tostqty + $res[0]->penstqty + $res[0]->avstqty;

        if (sizeof($res) > 0) {
            if ($qnty > ($res[0]->mxlv - $ttl)) {
                echo json_encode("Can't enter more than " . ($res[0]->mxlv - $ttl));
            } else {
                echo json_encode(true);
            }
        } else {
            echo json_encode(true);
        }
    }
//CHECK MAX ITEM LEVEL AND AVAILABLE COUNT

//ADD PURCHASE ORDER </JANAKA 2019-10-04>
    function po_Add()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        //Creating PO next number
        $this->db->select("pono");
        $this->db->from('stock_po');
        $this->db->order_by('poid', 'DESC');
        $this->db->limit(1);
        $res = $this->db->get()->result();

        $yr = date('y');

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
                $xx = '' . $aa;
            }
            $pono = "PO/" . $yr . "/" . $xx;
        } else {
            $pono = "PO/" . $yr . "/00001";
        }

        $this->Generic_model->insertData('stock_po', array(
            'spid' => $this->input->post('supp'),
            'whid' => $this->input->post('whs'),
            'pono' => $pono,
            'oddt' => $this->input->post('oddt'),
            'rfno' => strtoupper($this->input->post('refd')),
            'sbtl' => $this->input->post('sbttl'),
            'vtrt' => $this->input->post('vtrt'),
            'vtvl' => $this->input->post('vtvl'),
            'nbrt' => $this->input->post('nbrt'),
            'nbvl' => $this->input->post('nbvl'),
            'btrt' => $this->input->post('btrt'),
            'btvl' => $this->input->post('btvl'),
            'txrt' => $this->input->post('txrt'),
            'txvl' => $this->input->post('tax'),
            'ochg' => $this->input->post('otchg'),
            'totl' => $this->input->post('ttlAmt'),
            'remk' => $this->input->post('remk'),
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        ));
        $id = $this->db->insert_id();

        $itmcd = $this->input->post("itid[]");
        $qunty = $this->input->post('qunty[]');
        $untpr = $this->input->post('unitpr[]');
        $subvl = $this->input->post('unttl[]');
        $siz = sizeof($itmcd);

        for ($it = 0; $it < $siz; $it++) {
            $this->Generic_model->insertData('stock_po_des', array(
                'poid' => $id,
                'spid' => $this->input->post('supp'),
                'itid' => $itmcd[$it],
                'qnty' => $qunty[$it],
                'untp' => $untpr[$it],
                'sbvl' => $subvl[$it],
                'stat' => 1,
            ));
        }

        $funcPerm = $this->Generic_model->getFuncPermision('pchOdr');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Purchase Order added ($id)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END ADD PURCHASE ORDER </JANAKA 2019-10-04>

//SEARCH PO </2019-10-04>
    function searchPo()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('pchOdr');

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
        if ($funcPerm[0]->prnt == 1) {
            $prnt = "";
        } else {
            $prnt = "disabled";
        }

        $result = $this->Stock_model->get_poDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            if ($row->stat == 0) {
                $stat = "<label class='label label-warning'>Pending</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewPo($row->poid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-edit' onclick='editPo($row->poid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $app id='app' data-toggle='modal' data-target='#modal-edit' onclick='editPo($row->poid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' $rejt onclick='rejectPo($row->poid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 1) {
                $stat = "<label class='label label-success'>Active</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewPo($row->poid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled id='edit' data-toggle='modal' data-target='#modal-edit' onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $app id='app' onclick='sendPo($row->poid)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Send Mail'><i class='fa fa-envelope' aria-hidden='true'></i></button> " .
                    "<button type='button' $prnt onclick='printPo($row->poid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button>";
            } else if ($row->stat == 2) {
                $stat = "<label class='label label-danger'>Reject</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewPo($row->poid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else {
                $stat = "--";
                $option = "<button type='button' disabled data-toggle='modal' data-target='#modal-view' onclick='viewPo($row->poid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='editPo($row->poid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='approvePo($row->poid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='rejectPo($row->poid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->pono;
            $sub_arr[] = $row->spcd . " - " . $row->spnm;
            $sub_arr[] = $row->oddt;
            $sub_arr[] = number_format($row->totl, 2);
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_po(),
            "recordsFiltered" => $this->Stock_model->count_filtered_po(),
            "data" => $data,
        );
        echo json_encode($output);
    }
//END SEARCH PO </2019-10-04>

//GET PO DETAILS TO VIEW
    function get_PoDet()
    {
        $id = $this->input->post('id');

        $data['po'] = $this->Generic_model->getData('stock_po', '', array('poid' => $id));

        $this->db->select("item.itid,item.itcd,item.itnm,scl.scl,scl.scnm,pod.qnty,pod.untp,pod.sbvl,pod.pdid");
        $this->db->from('stock_po_des pod');
        $this->db->join('item', 'item.itid=pod.itid');
        $this->db->join('scale scl', 'scl.slid=item.scli');
        $this->db->where("pod.poid=$id AND pod.stat=1");
        $data['pod'] = $this->db->get()->result();

        echo json_encode($data);
    }
//END GET PO DETAILS TO VIEW

//GET ITEM QUANTITY AND STATUS OF THEM
    function getItm_QtySt()
    {
        $res = $this->Stock_model->qty_status();
        echo json_encode($res);
    }
//GET ITEM QUANTITY AND STATUS OF THEM

//APPROVE || EDIT PO </JANAKA 2019-10-07>
    function po_update(){
        $this->db->trans_begin(); // SQL TRANSACTION START
        $id = $this->input->post('poid');
        $func = $this->input->post('func');

        if($func=='app'){
            $msg = 'Purchase Order approved';

            $this->Generic_model->updateData('stock_po', array(
                'spid' => $this->input->post('supp_edt'),
                'whid' => $this->input->post('whs_edt'),
                'oddt' => $this->input->post('oddt_edt'),
                'rfno' => strtoupper($this->input->post('refd_edt')),
                'sbtl' => $this->input->post('sbttl_edt'),
                'vtrt' => $this->input->post('vtrt_edt'),
                'vtvl' => $this->input->post('vtvl_edt'),
                'nbrt' => $this->input->post('nbrt_edt'),
                'nbvl' => $this->input->post('nbvl_edt'),
                'btrt' => $this->input->post('btrt_edt'),
                'btvl' => $this->input->post('btvl_edt'),
                'txrt' => $this->input->post('txrt_edt'),
                'txvl' => $this->input->post('tax_edt'),
                'ochg' => $this->input->post('otchg_edt'),
                'totl' => $this->input->post('ttlAmt_edt'),
                'remk' => $this->input->post('remk_edt'),
                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            ),array('poid'=>$id));
        }else if($func=='edit'){
            $msg = 'Purchase Order updated';

            $this->Generic_model->updateData('stock_po', array(
                'spid' => $this->input->post('supp_edt'),
                'whid' => $this->input->post('whs_edt'),
                'oddt' => $this->input->post('oddt_edt'),
                'rfno' => strtoupper($this->input->post('refd_edt')),
                'sbtl' => $this->input->post('sbttl_edt'),
                'vtrt' => $this->input->post('vtrt_edt'),
                'vtvl' => $this->input->post('vtvl_edt'),
                'nbrt' => $this->input->post('nbrt_edt'),
                'nbvl' => $this->input->post('nbvl_edt'),
                'btrt' => $this->input->post('btrt_edt'),
                'btvl' => $this->input->post('btvl_edt'),
                'txrt' => $this->input->post('txrt_edt'),
                'txvl' => $this->input->post('tax_edt'),
                'ochg' => $this->input->post('otchg_edt'),
                'totl' => $this->input->post('ttlAmt_edt'),
                'remk' => $this->input->post('remk_edt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ),array('poid'=>$id));
        }

        //stock_po_des table update
        $this->Generic_model->updateData('stock_po_des',array('stat'=>0),array('poid'=>$id));

        $pdid = $this->input->post("pdid[]");
        $itmcd = $this->input->post("itid_edt[]");
        $qunty = $this->input->post('qunty_edt[]');
        $untpr = $this->input->post('unitpr_edt[]');
        $subvl = $this->input->post('unttl_edt[]');
        $siz = sizeof($itmcd);

        for ($it = 0; $it < $siz; $it++) {
            if($pdid[$it]!=0){
                $this->Generic_model->updateData('stock_po_des', array(
                    'stat' => 1,
                ),array('pdid'=>$pdid[$it]));
            }else{
                $this->Generic_model->insertData('stock_po_des', array(
                    'poid' => $id,
                    'spid' => $this->input->post('supp_edt'),
                    'itid' => $itmcd[$it],
                    'qnty' => $qunty[$it],
                    'untp' => $untpr[$it],
                    'sbvl' => $subvl[$it],
                    'stat' => 1,
                ));
            }
        }

        $funcPerm = $this->Generic_model->getFuncPermision('pchOdr');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "$msg ($id)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//APPROVE || EDIT PO </JANAKA 2019-10-07>
//************************************************
//***             END PURCHASE ORDER           ***
//************************************************
}
