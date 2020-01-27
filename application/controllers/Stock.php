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
        $this->load->library('Pdf'); // Load library
        $this->pdf->fontpath = 'font/'; // Specify font folder
//
        $this->load->database();                // load database
        $this->load->model('Generic_model');    // load model
        $this->load->model('Stock_model');       // load model
        $this->load->model('Log_model');        // load model
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
        $data2['category'] = $this->Generic_model->getSortData('category', array('ctid', 'ctcd', 'ctnm', 'stat'), "stat IN(1,3)", '', '', 'ctnm', 'ASC');
        $data2['brand'] = $this->Generic_model->getSortData('brand', array('bdid', 'bdcd', 'bdnm', 'logo', 'stat'), "stat IN(1,3)", '', '', 'bdnm', 'ASC');
        $data2['type'] = $this->Generic_model->getSortData('type', array('tpid', 'tpcd', 'tpnm', 'stat'), "stat IN(1,3)", '', '', 'tpnm', 'ASC');
        $data2['nature'] = $this->Generic_model->getSortData('nature', array('ntid', 'ntnm', 'dscr'), array('stat' => 1), '', '', 'ntnm', 'ASC');
        $data2['store'] = $this->Generic_model->getSortData('str_type', array('strid', 'stnm'), array('stat' => 1), '', '', 'stnm', 'ASC');
        $data2['storeScl'] = $this->Generic_model->getSortData('scale', array('slid', 'scl', 'scnm'), array('stat' => 1), '', '', 'scnm', 'ASC');
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
            'szsl' => $this->input->post('szscl'),
            'size' => $this->input->post('size'),
            'clr' => $this->input->post('clrnm'),
            'clcd' => $this->input->post('clr'),
            'dscr' => $this->input->post('dscr'),
            'scli' => $this->input->post('strscl'),
            'mxlv' => $this->input->post('mxlv'),
            'rolv' => $this->input->post('rolv'),
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
                'szsl' => $this->input->post('szscl_edt'),
                'size' => $this->input->post('size_edt'),
                'clr' => $this->input->post('clrnm_edt'),
                'clcd' => $this->input->post('clr_edt'),
                'dscr' => $this->input->post('dscr_edt'),
                'scli' => $this->input->post('strscl_edt'),
                'mxlv' => $this->input->post('mxlvEdt'),
                'rolv' => $this->input->post('rolv_edt'),
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
                'szsl' => $this->input->post('szscl_edt'),
                'size' => $this->input->post('size_edt'),
                'clr' => $this->input->post('clrnm_edt'),
                'clcd' => $this->input->post('clr_edt'),
                'dscr' => $this->input->post('dscr_edt'),
                'scli' => $this->input->post('strscl_edt'),
                'mxlv' => $this->input->post('mxlvEdt'),
                'rolv' => $this->input->post('rolv_edt'),
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
            'whcd' => strtoupper($this->input->post('code')),
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
                'whcd' => strtoupper($this->input->post('code_edt')),
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
                'whcd' => strtoupper($this->input->post('code_edt')),
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
        $data2['supplier'] = $this->Generic_model->getSortData('supp_mas', array('spid', 'spcd', 'spnm'), array('stat' => 1), '', '', 'spnm', 'ASC');
        $data2['warehouse'] = $this->Generic_model->getSortData('stock_wh', array('whid', 'whcd', 'whnm'), array('stat' => 1), '', '', 'whnm', 'ASC');
        //Item With Storing Scale
        $this->db->select("itid,itcd,itnm,slid,scnm,scl");
        $this->db->from('item');
        $this->db->join('scale', 'scale.slid=item.scli');
        $this->db->where('item.stat', 1);
        $this->db->order_by('item.itnm', 'ASC');
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
            $number = explode('/', $res[0]->pono);
            $aa = intval($number[2]) + 1;
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

            if ($row->grnst == 1) {
                $grn = "<label class='label label-info label-bordered label-ghost' title='GRN / GRRN process done'>GRN</label>";
            } else {
                $grn = "";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->pono;
            $sub_arr[] = $row->spcd . " - " . $row->spnm;
            $sub_arr[] = $row->oddt;
            $sub_arr[] = number_format($row->totl, 2);
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat . " " . $grn;
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

        $this->db->select("stock_po.*,supp_mas.spnm,stock_wh.whnm,
        CONCAT(cr.fnme,' ',cr.lnme) AS crnm,CONCAT(ap.fnme,' ',ap.lnme) AS apnm,CONCAT(md.fnme,' ',md.lnme) AS mdnm,
        CONCAT(rj.fnme,' ',rj.lnme) AS rjnm,CONCAT(pr.fnme,' ',pr.lnme) AS prnm,CONCAT(rp.fnme,' ',rp.lnme) AS rpnm");
        $this->db->from('stock_po');
        $this->db->join('supp_mas', 'supp_mas.spid=stock_po.spid');
        $this->db->join('stock_wh', 'stock_wh.whid=stock_po.whid');
        $this->db->join('user_mas cr', 'cr.auid=stock_po.crby');
        $this->db->join('user_mas ap', 'ap.auid=stock_po.apby', 'LEFT');
        $this->db->join('user_mas md', 'md.auid=stock_po.mdby', 'LEFT');
        $this->db->join('user_mas rj', 'rj.auid=stock_po.rjby', 'LEFT');
        $this->db->join('user_mas pr', 'pr.auid=stock_po.prby', 'LEFT');
        $this->db->join('user_mas rp', 'rp.auid=stock_po.rpby', 'LEFT');
        $this->db->where('stock_po.poid', $id);
        $data['po'] = $this->db->get()->result();

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
    function po_update()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $id = $this->input->post('poid');
        $func = $this->input->post('func');

        if ($func == 'app') {
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
            ), array('poid' => $id));
        } else if ($func == 'edit') {
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
            ), array('poid' => $id));
        }

        //stock_po_des table update
        $this->Generic_model->updateData('stock_po_des', array('stat' => 0), array('poid' => $id));

        $pdid = $this->input->post("pdid[]");
        $itmcd = $this->input->post("itid_edt[]");
        $qunty = $this->input->post('qunty_edt[]');
        $untpr = $this->input->post('unitpr_edt[]');
        $subvl = $this->input->post('unttl_edt[]');
        $siz = sizeof($itmcd);

        for ($it = 0; $it < $siz; $it++) {
            if ($pdid[$it] != 0) {
                $this->Generic_model->updateData('stock_po_des', array(
                    'stat' => 1,
                ), array('pdid' => $pdid[$it]));
            } else {
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
//END APPROVE || EDIT PO </JANAKA 2019-10-07>

//REJECT PO </JANAKA 2019-10-07>
    function po_Reject()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $id = $this->input->post('id');

        $this->Generic_model->updateData('stock_po', array(
            'stat' => 2,
            'rjby' => $_SESSION['userId'],
            'rjdt' => date('Y-m-d H:i:s')
        ), array('poid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('pchOdr');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Purchase Order Rejected ($id)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }

    }
//END REJECT PO </JANAKA 2019-10-07>

// PRINT PO </2019-10-08>
    function prchOrderPrint($auid)
    {
        $rcdt = $this->Generic_model->getData('stock_po', array('prct'), array('poid' => $auid));
        $pntc = $rcdt[0]->prct + 1;

        // PRINT COUNT UPDATE PO TB
        if (($pntc - 1) > 0) {
            $data_ar1 = array(
                'rpby' => $_SESSION['userId'],
                'rpdt' => date('Y-m-d H:i:s'),
                'prct' => $pntc,
            );
        } else {
            $data_ar1 = array(
                'prby' => $_SESSION['userId'],
                'prdt' => date('Y-m-d H:i:s'),
                'prct' => $pntc,
            );
        }
        $result1 = $this->Generic_model->updateData('stock_po', $data_ar1, array('poid' => $auid));


        if (count($result1) > 0) {
            $this->load->library('ciqrcode');

            $this->db->select("po.*,spp.spcd, spp.spnm, spp.addr, spp.mbno, spp.tele, spp.email, wh.whnm, wh.whcd,
             wh.addr AS whadr , wh.tele AS whtele, wh.email AS whemil, CONCAT(cr.fnme,' ',cr.lnme) AS crnm");
            $this->db->from("stock_po po");
            $this->db->join('supp_mas spp', 'spp.spid = po.spid ');
            $this->db->join('user_mas cr', 'cr.auid = po.crby ');
            $this->db->join('stock_wh wh', 'wh.whid = po.whid ');
            $this->db->where('po.poid', $auid);
            $query = $this->db->get();
            $data = $query->result();

            // PO DETAILS
            $this->db->select("pod.*, item.itcd, item.itnm, item.mdl, item.mlcd, item.mdl");
            $this->db->from("stock_po_des pod");
            $this->db->join('item', 'item.itid = pod.itid ');
            $this->db->where('pod.poid', $auid);
            $this->db->where('pod.stat', 1);
            $query = $this->db->get();
            $rest = $query->result();

            // LOGIN USER
            $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
            $usr = $usedetails[0]->fnme;
            $comdt = $this->Generic_model->getData('com_det', array('cmne', 'cadd', 'ctel', 'ceml', 'chot'), array('stat' => 1));
            //$branc = $this->Generic_model->getData('brch_mas', '', array('brid' => $data[0]->brco));

            $_SESSION['hid'] = mt_rand(10000000, 999999999);
            $cy = date('Y');
            $date = date('Y-m-d H:i:s');
            ob_start();
            $this->pdf->AddPage('P', 'A4');
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetTextColor(50, 50, 50);
            $this->pdf->SetXY(10, 32);
            $this->pdf->Cell(0, 0, 'PURCHASE ORDER', 0, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(188, 37);

            // Top left company details
            $this->pdf->SetFont('Helvetica', 'B', 9);
            $this->pdf->SetXY(5, 9);
            $this->pdf->Cell(0, 0, $comdt[0]->cmne);
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(5.5, 14);
            $this->pdf->Cell(0, 0, $comdt[0]->cadd);
            $this->pdf->SetXY(5.5, 18);
            $this->pdf->Cell(0, 0, $comdt[0]->ctel);
            $this->pdf->SetXY(5.5, 22);
            $this->pdf->Cell(0, 0, $comdt[0]->chot);
            $this->pdf->SetXY(5.5, 26);
            $this->pdf->Cell(0, 0, $comdt[0]->ceml);

            // TOP RIGHT
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(145, 9);
            $this->pdf->Cell(1, 0, 'PURCHASE ORDER', 0, 1, 'L');
            $this->pdf->SetXY(145, 14);
            $this->pdf->Cell(1, 0, 'ORDER NO', 0, 1, 'L');
            $this->pdf->SetXY(145, 18);
            $this->pdf->Cell(1, 0, 'ORDER DATE : ', 0, 1, 'L');
            $this->pdf->SetXY(145, 22);
            $this->pdf->Cell(1, 0, 'SUPPLY', 0, 1, 'L');
            $this->pdf->SetXY(170, 14);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->pono, 0, 1, 'L');
            $this->pdf->SetXY(170, 18);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->oddt, 0, 1, 'L');
            $this->pdf->SetXY(170, 22);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->spcd, 0, 1, 'L');

            // TABLE MAIN LEFT ( VENDOR )
            $this->pdf->SetTextColor(0, 0, 0); // BOX COLOR CHANGE
            $this->pdf->SetFont('Helvetica', 'B', 9);
            $this->pdf->SetXY(10, 41);
            $this->pdf->Cell(1, 0, 'VENDOR ', 0, 1, 'L');
            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(10, 45);
            $this->pdf->Cell(1, 0, $data[0]->spnm, 0, 1, 'L');
            $this->pdf->SetXY(10, 49);
            $this->pdf->Cell(1, 0, $data[0]->addr, 0, 1, 'L');
            $this->pdf->SetXY(10, 53);
            $this->pdf->Cell(1, 0, $data[0]->tele . ' | ' . $data[0]->mbno, 0, 1, 'L');
            $this->pdf->SetXY(10, 57);
            $this->pdf->Cell(1, 0, $data[0]->email);

            // TABLE MAIN RIGHT ( DELIVERY  )
            $this->pdf->SetFont('Helvetica', 'B', 9);
            $this->pdf->SetXY(135, 41);
            $this->pdf->Cell(1, 0, 'DELIVERY TO', 0, 1, 'L');
            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(135, 45);
            $this->pdf->Cell(1, 0, $data[0]->whnm, 0, 1, 'L');

            $this->pdf->SetXY(135, 49);
            $this->pdf->Cell(1, 0, $data[0]->whadr, 0, 1, 'L');
            $this->pdf->SetXY(135, 53);
            $this->pdf->Cell(1, 0, $data[0]->whtele, 0, 1, 'L');
            $this->pdf->SetXY(135, 57);
            $this->pdf->Cell(1, 0, $data[0]->whemil, 0, 1, 'L');

            //----- TABLE -------//
            $this->pdf->SetFont('Helvetica', 'B', 8);   // Table Header set bold font
            $this->pdf->SetTextColor(0, 0, 0);
            $this->pdf->SetXY(5, 37);
            $this->pdf->Cell(200, 30, '', '1');

            // Payment details table border
            $this->pdf->SetXY(5, 60);
            $this->pdf->Cell(10, 150, '', '1');
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(40, 150, '', '1');
            $this->pdf->SetXY(55, 60);
            $this->pdf->Cell(80, 150, '', '1');
            $this->pdf->SetXY(135, 60);
            $this->pdf->Cell(20, 150, '', '1');
            $this->pdf->SetXY(155, 60);
            $this->pdf->Cell(20, 150, '', '1');
            $this->pdf->SetXY(175, 60);
            $this->pdf->Cell(30, 150, '', '1');

            // #0
            $this->pdf->SetXY(5, 60);
            $this->pdf->Cell(10, 7, 'NO', 1, 1, 'C');
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(40, 7, 'ITEM CODE', 1, 1, 'C');
            $this->pdf->SetXY(55, 60);
            $this->pdf->Cell(80, 7, 'ITEM NAME', 1, 1, 'C');
            $this->pdf->SetXY(135, 60);
            $this->pdf->Cell(20, 7, 'QTY', 1, 1, 'C');
            $this->pdf->SetXY(155, 60);
            $this->pdf->Cell(20, 7, 'UNIT PRICE', 1, 1, 'C');
            $this->pdf->SetXY(175, 60);
            $this->pdf->Cell(30, 7, 'TOTAL', 1, 1, 'C');

            $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
            $this->pdf->SetTextColor(0, 0, 0);

            // #1 - n recode
            $len = sizeof($rest);
            $y = 70;
            $ttlsub = $qnty = 0;
            for ($i = 0; $i < $len; $i++) {
                $this->pdf->SetXY(5, $y);
                $this->pdf->Cell(10, 3, $i + 1, 0, 0, 'C');
                $this->pdf->SetXY(15, $y);
                $this->pdf->Cell(40, 3, $rest[$i]->itcd, 'L');
                $this->pdf->SetXY(55, $y);
                $this->pdf->MultiCell(80, 3, $rest[$i]->itnm . "\nMODEL - " . $rest[$i]->mdl . " (" . $rest[$i]->mlcd . ")", 0);
                $y2 = $this->pdf->getY();
                $this->pdf->SetXY(135, $y);
                $this->pdf->Cell(20, 3, $rest[$i]->qnty, 0, '', 'C');
                $this->pdf->SetXY(155, $y);
                $this->pdf->Cell(20, 3, number_format($rest[$i]->untp, 2, '.', ','), 0, 0, 'R');
                $this->pdf->SetXY(175, $y);
                $this->pdf->Cell(30, 3, number_format($rest[$i]->sbvl, 2, '.', ','), 0, 0, 'R');

                $y = $y2 + 3;
                $qnty = $qnty + $rest[$i]->qnty;
                $ttlsub = $ttlsub + $rest[$i]->sbvl;
            }
            //-----TOTAL AMOUNT--------//

            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(130, 210);
            $this->pdf->Cell(6, 10, 'TOTAL ', 0, 1, 'R');

            $this->pdf->SetXY(135, 210);
            $this->pdf->Cell(20, 8, $qnty, 1, 0, 'C');
            $this->pdf->SetXY(155, 210);
            $this->pdf->Cell(20, 8, '', 1, 0, 'R');

            $this->pdf->SetXY(175, 210);
            $this->pdf->Cell(30, 8, number_format($ttlsub, 2, '.', ','), 1, 0, 'R');

            // REMARKS
            $this->pdf->SetXY(10, 220);
            $this->pdf->Cell(20, 8, 'REMARKS / INTERDICTION ', 0, 0, 'L');
            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(10, 225);
            $this->pdf->MultiCell(80, 5, $data[0]->remk, '0.5', 'L', FALSE);

            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(155, 220);
            $this->pdf->Cell(20, 8, 'SUB TOTAL', 0, 0, 'R');
            $this->pdf->SetXY(175, 220);
            $this->pdf->Cell(30, 8, number_format($ttlsub, 2, '.', ','), 0, 0, 'R');

            $this->pdf->SetXY(155, 225);
            $this->pdf->Cell(20, 8, 'VAT (' . $data[0]->vtrt . '%)', 0, 0, 'R');
            $this->pdf->SetXY(175, 225);
            $this->pdf->Cell(30, 8, number_format($data[0]->vtvl, 2, '.', ','), 0, 0, 'R');

            $this->pdf->SetXY(155, 230);
            $this->pdf->Cell(20, 8, 'NBT (' . $data[0]->nbrt . '%)', 0, 0, 'R');
            $this->pdf->SetXY(175, 230);
            $this->pdf->Cell(30, 8, number_format($data[0]->nbvl, 2, '.', ','), 0, 0, 'R');

            $this->pdf->SetXY(155, 235);
            $this->pdf->Cell(20, 8, 'BTT (' . $data[0]->btrt . '%)', 0, 0, 'R');
            $this->pdf->SetXY(175, 235);
            $this->pdf->Cell(30, 8, number_format($data[0]->btvl, 2, '.', ','), 0, 0, 'R');

            $this->pdf->SetXY(155, 240);
            $this->pdf->Cell(20, 8, 'OTHER TAX (' . $data[0]->txrt . '%)', 0, 0, 'R');
            $this->pdf->SetXY(175, 240);
            $this->pdf->Cell(30, 8, number_format($data[0]->txvl, 2, '.', ','), 0, 0, 'R');

            $this->pdf->SetXY(155, 245);
            $this->pdf->Cell(20, 8, 'OTHER CHARGE', 0, 0, 'R');
            $this->pdf->SetXY(175, 245);
            $this->pdf->Cell(30, 8, number_format($data[0]->ochg, 2, '.', ','), 0, 0, 'R');

            /* $this->pdf->SetXY(155, 250);
             $this->pdf->Cell(20, 8, 'DISCOUNT (' . $data[0]->dsrt . '%)', 0, 0, 'R');
             $this->pdf->SetXY(175, 250);
             $this->pdf->Cell(30, 8, number_format($data[0]->dsvl, 2, '.', ','), 0, 0, 'R');*/

            $this->pdf->SetXY(155, 255);
            $this->pdf->SetFillColor(50, 50, 50);
            $this->pdf->Cell(20, 8, 'TOTAL', 0, 0, 'R');
            $this->pdf->SetXY(175, 255);
            $this->pdf->Cell(30, 8, number_format(($ttlsub + $data[0]->vtvl + $data[0]->nbvl + $data[0]->btvl + $data[0]->txvl + $data[0]->ochg) - $data[0]->dsvl, 2, '.', ','), 0, 0, 'R');

            $this->pdf->SetAutoPageBreak(false);

            //FOOTER
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(-15, 275);
            $this->pdf->Cell(10, 6, $_SESSION['hid'], 0, 1, 'R');
            $this->pdf->SetFont('Helvetica', 'I', 7);
            $this->pdf->SetXY(-15, 280);
            $this->pdf->Cell(10, 6, 'Copyright @ ' . $cy . ' - www.gdcreations.com', 0, 1, 'R');
            $this->pdf->SetXY(4, 280);
            $this->pdf->Cell(0, 6, 'Printed : ' . $usedetails[0]->fnme . ' | ' . $date, 0, 1, 'L');

            // REPRINT TAG
//            $policy = $this->Generic_model->getData('sys_policy', array('post'), array('popg' => 'vouc', 'stat' => 1));
//            if ($policy[0]->post == 1) {
            if ($rcdt[0]->prct > 1) {
                $this->pdf->SetFont('Helvetica', 'B', 7);
                $this->pdf->SetXY(4, 280);
                $this->pdf->Cell(0, 0, 'REPRINTED (' . $pntc . ')');
            }
//            }

            //QR CODE
            // $cd = 'Vou No : ' . $data[0]->vuno . ' | Date : ' . $data[0]->crdt . ' | Payee Name : ' . $data[0]->spnm . ' | Branch : ' . $data[0]->brnm . ' | Pay Type : ' . $data[0]->dsnm . ' | Total : Rs.' . $pyamt . ' | Printed By : ' . $usr . ' | ' . $_SESSION["hid"];
            // $this->pdf->Image(str_replace(" ", "%20", 'http://chart.apis.google.com/chart?cht=qr&chs=190x190&chl=' . $cd), 176, 7, 26, 0, 'PNG');

            $this->pdf->SetTitle('po - ' . $data[0]->pono);
            $this->pdf->Output('po_' . $data[0]->pono . '.pdf', 'I');
            ob_end_flush();

        } else {
            echo json_encode(false);
        }
        $funcPerm = $this->Generic_model->getFuncPermision('vouc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'po print (' . $data[0]->vuno . ')');

    }
    //END PRINT PO </2019-10-08>
//************************************************
//***             END PURCHASE ORDER           ***
//************************************************
//          GRN & GRRN
//************************************************
    function grnMng()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'grnMng'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('supReg');
        $data2['supplyInfo'] = $this->Generic_model->getSortData('supp_mas', array('spid,spcd,spnm'), array('stat' => 1), '', '', 'spcd', 'ASC');
        $data2['whouseInfo'] = $this->Generic_model->getSortData('stock_wh', array('whid,whcd,whnm'), array('stat' => 1), '', '', 'whcd', 'ASC');
        $this->load->view('admin/stock/grnManagement', $data2);

        $this->load->view('common/tmpFooter', $data);
    }

    //GET PO DETAILS
    function getPodet()
    {
        $spid = $this->input->post('supid');
        $st = $this->input->post('st');

        $this->db->select("stock_po.poid, pono, oddt ");
        $this->db->from("stock_po");
        //$this->db->join("(SELECT * FROM `stock_grn` WHERE `grtp` = 1 AND `stat` IN (0,1)) AS aa", 'aa.poid = stock_po.poid ', 'left');
        $this->db->where('stock_po.spid', $spid);
        $this->db->where('stock_po.stat', 1);
        $this->db->where('stock_po.grnst', $st);
        //$this->db->where(" aa.poid IS NULL ");
        $query = $this->db->get();
        $data = $query->result();

        echo json_encode($data);
    }

    // GET PO DETAILS
    function getPodetils()
    {
        $poid = $this->input->post('poid');

        $this->db->select("stock_po.whid, stock_po_des.*, item.itnm, item.itcd");
        $this->db->from("stock_po");
        $this->db->join('stock_po_des', 'stock_po_des.poid = stock_po.poid ');
        $this->db->join('item', 'item.itid = stock_po_des.itid ');
        $this->db->where('stock_po.poid', $poid);
        $this->db->where('stock_po_des.stat', 1);
        $this->db->order_by('stock_po_des.pdid', 'asc'); // desc
        $query = $this->db->get();
        $data['podet'] = $query->result();

        $data['grndt'] = $this->Generic_model->getData('stock_grn', '', "poid = $poid AND stat IN(0,1)");

        echo json_encode($data);
    }

    // ADD GRN DETAILS
    function addGrndet()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        // IF RECIVE QTY > 0
        if ($this->input->post('rcvqt') > 0) {

            // GRN PROCESS
            $this->db->select("grno");
            $this->db->from("stock_grn");
            $this->db->where('grtp', 1);
            $this->db->order_by('grid', 'desc');
            $this->db->limit(1);
            $query = $this->db->get();
            $data = $query->result();

            $yr = date('y');
            if (count($data) == '0') {
                $grno = 'GRN/' . $yr . '/1/0001';  // Ex GRN/YR/1/NO - GRN/18/1/0001

            } else {
                $grno = $data[0]->grno;
                $re = (explode("/", $grno));

                $aa = intval($re[3]) + 1;
                $cc = strlen($aa);
                if ($cc == 1) {
                    $xx = '000' . $aa;
                } else if ($cc == 2) {
                    $xx = '00' . $aa;
                } else if ($cc == 3) {
                    $xx = '0' . $aa;
                } else if ($cc == 4) {
                    $xx = '0' . $aa;
                }
                $grno = 'GRN/' . $yr . '/1/' . $xx;
            }

            // GRN DETAILS SAVE MAIN TABLE
            $data_arr = array(
                'grtp' => 1,
                'grno' => $grno,
                'spid' => $this->input->post('suplSrc'),
                'poid' => $this->input->post('podt'),
                'grdt' => $this->input->post('grdt'),
                'whid' => $this->input->post('whsid'),

                'odqt' => $this->input->post('odrqt'),
                'rcqt' => $this->input->post('rcvqt'),
                'frqt' => ($this->input->post('tfrqt') == "") ? 0 : $this->input->post('tfrqt'),
                'rtqt' => 0,
                'remk' => $this->input->post('remk'),
                'chby' => $this->input->post('chkby'),
                'stat' => 0,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $this->Generic_model->insertData('stock_grn', $data_arr);

            // GRN DETAILS SAVE SUB DETAILS TABLE
            // get voucher last recode id
            $grdt = $this->Generic_model->getData('stock_grn', array('grid'), array('grno' => $grno));
            $lstid = $grdt[0]->grid;

            $itid = $this->input->post("itid[]");
            $gdqt = $this->input->post('grgd[]');
            $frqt = $this->input->post('grfr[]');
            $odqt = $this->input->post('odrQty[]');
            $gdrm = $this->input->post('rtnRmk[]');
            $untp = $this->input->post('untp[]');
            $siz = sizeof($itid);

            for ($a = 0; $a < $siz; $a++) {
                if ($gdqt[$a] != 0) {
                    $data_arr2 = array(
                        'grid' => $lstid,                     // grn id
                        'spid' => $this->input->post('suplSrc'),
                        'itid' => $itid[$a],
                        'odqt' => $odqt[$a],
                        'qnty' => $gdqt[$a],
                        'frqt' => ($frqt[$a] == "" || $frqt[$a] == null) ? 0 : $frqt[$a],
                        'untp' => $untp[$a],
                        'sbvl' => ($untp[$a] * $gdqt[$a]),
                        'stat' => 1,
                        //'remk' => $gdrm[$a],
                    );
                    $result2 = $this->Generic_model->insertData('stock_grn_des', $data_arr2);
                }
            }
            $funcPerm = $this->Generic_model->getFuncPermision('grnMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New GRN (' . $grno . ')');
        }

        // IF RETURN QTY > 0
        if ($this->input->post('rtnqt') > 0) {

            // GRRN PROCESS
            $this->db->select("grno");
            $this->db->from("stock_grn");
            $this->db->where('grtp', 0);
            $this->db->order_by('grid', 'desc');
            $this->db->limit(1);
            $query = $this->db->get();
            $data = $query->result();

            $yr = date('y');
            if (count($data) == '0') {
                $grno = 'GRN/' . $yr . '/0/0001';  // Ex GRN/YR/1/NO - GRN/18/0/0001
            } else {
                $grno = $data[0]->grno;
                $re = (explode("/", $grno));

                $aa = intval($re[3]) + 1;
                $cc = strlen($aa);
                if ($cc == 1) {
                    $xx = '000' . $aa;
                } else if ($cc == 2) {
                    $xx = '00' . $aa;
                } else if ($cc == 3) {
                    $xx = '0' . $aa;
                } else if ($cc == 4) {
                    $xx = '0' . $aa;
                }
                $grno = 'GRN/' . $yr . '/0/' . $xx;
            }

            // GRRN DETAILS SAVE MAIN TABLE
            $data_arr = array(
                'grtp' => 0,
                'grno' => $grno,
                'spid' => $this->input->post('suplSrc'),
                'poid' => $this->input->post('podt'),
                'grdt' => $this->input->post('grdt'),
                'whid' => $this->input->post('whsid'),

                'odqt' => $this->input->post('odrqt'),
                'rcqt' => 0,
                'frqt' => 0,
                'rtqt' => $this->input->post('rtnqt'),
                'remk' => $this->input->post('remk'),
                'chby' => $this->input->post('chkby'),
                'stat' => 0,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            );
            $this->Generic_model->insertData('stock_grn', $data_arr);

            // GRN DETAILS SAVE SUB DETAILS TABLE
            // get voucher last recode id
            $grdt = $this->Generic_model->getData('stock_grn', array('grid'), array('grno' => $grno));
            $lstid = $grdt[0]->grid;

            $itid = $this->input->post("itid[]");
            $grbd = $this->input->post('grbd[]');
            $odqt = $this->input->post('odrQty[]');
            $gdrm = $this->input->post('rtnRmk[]');
            $untp = $this->input->post('untp[]');
            $siz = sizeof($itid);

            for ($a = 0; $a < $siz; $a++) {
                if ($grbd[$a] != 0) {
                    $data_arr2 = array(
                        'grid' => $lstid,                     // grn id
                        'spid' => $this->input->post('suplSrc'),
                        'itid' => $itid[$a],
                        'odqt' => $odqt[$a],
                        'qnty' => $grbd[$a],
                        'untp' => $untp[$a],
                        'sbvl' => ($untp[$a] * $grbd[$a]),
                        'stat' => 1,
                        'remk' => $gdrm[$a],
                    );
                    $this->Generic_model->insertData('stock_grn_des', $data_arr2);
                }
            }
            $funcPerm = $this->Generic_model->getFuncPermision('grnMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New GRRN (' . $grno . ')');
        }

        $this->Generic_model->updateData('stock_po', array('grnst' => 1), array('poid' => $this->input->post('podt')));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // SEARCH GRN
    function srchGrnDeti()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('grnMng');

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

        $result = $this->Stock_model->get_grnDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $grid = $row->grid;

            if ($row->stst == '0') {
                $stst = " <span class='label label-warning' title='Stock Not Added'>S:N </span> ";
            } else {
                $stst = " <span class='label label-success' title='Stock Added'> S:A </span> ";
            }
            //"<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewSupp($row->spid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .

            if ($row->stat == '0') {                   // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option =
                    "<button type='button' id='view' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewGrn($grid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' $app  data-toggle='modal' data-target='#modal-view'  onclick='viewGrn($grid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' $rejt disabled onclick='rejecPo($grid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($row->stat == '1') {           // Approved
                $stat = " <span class='label label-success'> Approved </span> ";
                $option =
                    "<button type='button' id='view' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewGrn($grid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='pnt' $app onclick='prntGrn($grid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Print'><i class='fa fa-print' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecPo($grid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($row->stat == '2') {            // Rejected
                $stat = " <span class='label label-danger'> Inactive</span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewGrn($grid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed btn-rounded' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed btn-rounded' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecPo($grid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else {
                $stat = " <span class='label label-danger'> --</span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewGrn($grid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed btn-rounded' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed btn-rounded' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecPo($grid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->grno;
            $sub_arr[] = $row->spnm;
            $sub_arr[] = $row->pono;
            $sub_arr[] = $row->grdt;
            $sub_arr[] = $row->odqt;
            $sub_arr[] = $row->frqt;
            $sub_arr[] = $row->rcqt;
            $sub_arr[] = $row->rtqt;
            $sub_arr[] = $stat; // . '  ' . $stst
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $option;
            $data[] = $sub_arr;

        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_grn(),
            "recordsFiltered" => $this->Stock_model->count_filtered_grn(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // GET GRN VIEW DETAILS
    function vewGrnDetails()
    {
        $auid = $this->input->post('auid');

        $this->db->select("stock_grn.*, supp_mas.spnm,  stock_po.pono, stock_wh.whnm, stock_wh.whcd, DATE_FORMAT(stock_grn.crdt, '%Y-%m-%d') AS crdt, 
        CONCAT(cr.fnme,' ',cr.lnme) AS crnm, CONCAT(ap.fnme,' ',ap.lnme) AS apnm, CONCAT(rj.fnme,' ',rj.lnme) AS rjnm");
        $this->db->from("stock_grn");
        $this->db->join('supp_mas', 'supp_mas.spid = stock_grn.spid ');
        $this->db->join('stock_po', 'stock_po.poid = stock_grn.poid ');
        $this->db->join('stock_wh', 'stock_wh.whid = stock_grn.whid ');

        $this->db->join('user_mas cr', 'cr.auid=stock_grn.crby');
        $this->db->join('user_mas ap', 'ap.auid=stock_grn.apby', 'LEFT');
        //$this->db->join('user_mas md', 'md.auid=stock_grn.mdby', 'LEFT');
        $this->db->join('user_mas rj', 'rj.auid=stock_grn.rjby', 'LEFT');

        $this->db->where('stock_grn.grid', $auid);
        $query = $this->db->get();
        $data['grndtl'] = $query->result();

        $this->db->select("stock_grn_des.*, item.itnm, item.itcd");
        $this->db->from("stock_grn_des");
        $this->db->join('item', 'item.itid = stock_grn_des.itid ');
        $this->db->where('stock_grn_des.grid', $auid);
        $this->db->where('stock_grn_des.stat', 1);
        $this->db->order_by('stock_grn_des.gdid', 'asc'); // desc
        $query = $this->db->get();
        $data['poitem'] = $query->result();

        echo json_encode($data);
    }

    // GRN UPDATE || APPROVE
    function updateGrn()
    {
        $func = $this->input->post('func');
        $grid = $this->input->post('grnid');

        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($func == 'app') {
            //Updating supplier details
            $this->Generic_model->updateData('stock_grn',
                array(
                    'stat' => 1,
                    'apby' => $_SESSION['userId'],
                    'apdt' => date('Y-m-d H:i:s'),
                ), array('grid' => $grid));

            $funcPerm = $this->Generic_model->getFuncPermision('grnMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "GRN Approved ($grid)");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // PRINT GRN
    function grnPrint($auid)
    {
        $dt1 = date('Y-m-d');
        $dt2 = date('Y / M');

        $rcdt = $this->Generic_model->getData('stock_grn', array('pntc', 'grtp'), array('grid' => $auid));
        $pntc = $rcdt[0]->pntc + 1;

        if ($rcdt[0]->grtp == 1) {
            $nttp = "GOOD RECEIVED NOTE ";
            $abc = "RECIVE QTY ";
        } else {
            $nttp = "GOOD RECEIVED RETURN NOTE ";
            $abc = "RETURN QTY ";
        }

        // PRINT COUNT UPDATE PO TB
        if (($pntc - 1) > 0) {
            $data_ar1 = array(
                'rpby' => $_SESSION['userId'],
                'rpdt' => date('Y-m-d H:i:s'),
                'pntc' => $pntc,
            );
        } else {
            $data_ar1 = array(
                'prby' => $_SESSION['userId'],
                'prdt' => date('Y-m-d H:i:s'),
                'pntc' => $pntc,
            );
        }
        $result1 = $this->Generic_model->updateData('stock_grn', $data_ar1, array('grid' => $auid));

        if (count($result1) > 0) {
            $this->load->library('ciqrcode');

            $this->db->select("stock_grn.*,supp_mas.spcd, supp_mas.spnm, supp_mas.addr, supp_mas.mbno, supp_mas.tele, supp_mas.email, stock_wh.whnm, stock_wh.whcd,
             stock_wh.addr AS whadr , stock_wh.tele, stock_wh.email AS whemil,  user_mas.fnme AS crby, u.fnme AS apby ");
            $this->db->from("stock_grn");
            $this->db->join('supp_mas', 'supp_mas.spid = stock_grn.spid ');
            $this->db->join('user_mas', 'user_mas.auid = stock_grn.crby ');
            $this->db->join("(SELECT u.auid, u.fnme FROM `user_mas` AS u )AS u ", 'u.auid = stock_grn.apby', 'left');  // GRN approval by
            $this->db->join('stock_wh', 'stock_wh.whid = stock_grn.whid ');
            $this->db->where('stock_grn.grid', $auid);
            $query = $this->db->get();
            $data = $query->result();

            // GRN DETAILS
            $this->db->select("stock_grn_des.*, item.itcd, item.itnm, item.itcd AS pbcd,item.mdl,item.mlcd");
            $this->db->from("stock_grn_des");
            $this->db->join('item', 'item.itid = stock_grn_des.itid ');
            $this->db->where('stock_grn_des.grid', $auid);
            $this->db->where('stock_grn_des.stat', 1);
            $query = $this->db->get();
            $rest = $query->result();

            // LOGIN USER
            $usedetails = $this->Generic_model->getData('user_mas', '', array('auid' => $_SESSION['userId']));
            $usr = $usedetails[0]->fnme;
            $comdt = $this->Generic_model->getData('com_det', array('cmne', 'cadd', 'ctel', 'ceml', 'chot'), array('stat' => 1));
            //$branc = $this->Generic_model->getData('brch_mas', '', array('brid' => $data[0]->brco));

            $_SESSION['hid'] = mt_rand(10000000, 999999999);
            $cy = date('Y');
            $date = date('Y-m-d H:i:s');
            ob_start();
            $this->pdf->AddPage('P', 'A4');
            $this->pdf->SetFont('Helvetica', 'B', 15);
            $this->pdf->SetTextColor(50, 50, 50);
            $this->pdf->SetXY(10, 32);
            $this->pdf->Cell(0, 0, $nttp, 0, 1, 'C');
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(188, 37);

            // Top left company details
            $this->pdf->SetFont('Helvetica', 'B', 9);
            $this->pdf->SetXY(5, 9);
            $this->pdf->Cell(0, 0, $comdt[0]->cmne);
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(5.5, 14);
            $this->pdf->Cell(0, 0, $comdt[0]->cadd);
            $this->pdf->SetXY(5.5, 18);
            $this->pdf->Cell(0, 0, $comdt[0]->ctel);
            $this->pdf->SetXY(5.5, 22);
            $this->pdf->Cell(0, 0, $comdt[0]->chot);
            $this->pdf->SetXY(5.5, 26);
            $this->pdf->Cell(0, 0, $comdt[0]->ceml);

            // TOP RIGHT
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(145, 9);
            $this->pdf->Cell(1, 0, 'NOTE DETAILS', 0, 1, 'L');
            $this->pdf->SetXY(145, 14);
            $this->pdf->Cell(1, 0, 'NO', 0, 1, 'L');
            $this->pdf->SetXY(145, 18);
            $this->pdf->Cell(1, 0, 'DATE : ', 0, 1, 'L');
            $this->pdf->SetXY(145, 22);
            $this->pdf->Cell(1, 0, 'SUPPLY', 0, 1, 'L');
            $this->pdf->SetXY(170, 14);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->grno, 0, 1, 'L');
            $this->pdf->SetXY(170, 18);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->grdt, 0, 1, 'L');
            $this->pdf->SetXY(170, 22);
            $this->pdf->Cell(1, 0, ': ' . $data[0]->spcd, 0, 1, 'L');

            // TABLE MAIN LEFT ( VENDOR )
            $this->pdf->SetTextColor(0, 0, 0); // BOX COLOR CHANGE
            $this->pdf->SetFont('Helvetica', 'B', 9);
            $this->pdf->SetXY(10, 41);
            $this->pdf->Cell(1, 0, 'SUPPLY ', 0, 1, 'L');
            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(10, 45);
            $this->pdf->Cell(1, 0, $data[0]->spnm, 0, 1, 'L');
            $this->pdf->SetXY(10, 49);
            $this->pdf->Cell(1, 0, $data[0]->addr, 0, 1, 'L');
            $this->pdf->SetXY(10, 53);
            $this->pdf->Cell(1, 0, $data[0]->tele . ' | ' . $data[0]->mbno, 0, 1, 'L');
            $this->pdf->SetXY(10, 57);
            $this->pdf->Cell(1, 0, $data[0]->email);

            //----- TABLE -------//
            $this->pdf->SetFont('Helvetica', 'B', 8);   // Table Header set bold font
            $this->pdf->SetTextColor(0, 0, 0);
            $this->pdf->SetXY(5, 37);
            $this->pdf->Cell(200, 30, '', '1');

            // Payment details table border
            $this->pdf->SetXY(5, 60);
            $this->pdf->Cell(10, 150, '', '1');
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(25, 150, '', '1');
            $this->pdf->SetXY(40, 60);
            $this->pdf->Cell(65, 150, '', '1');
            $this->pdf->SetXY(105, 60);
            $this->pdf->Cell(20, 150, '', '1');
            $this->pdf->SetXY(125, 60);
            $this->pdf->Cell(20, 150, '', '1');
            $this->pdf->SetXY(145, 60);
            $this->pdf->Cell(20, 150, '', '1');
            $this->pdf->SetXY(165, 60);
            $this->pdf->Cell(20, 150, '', '1');
            $this->pdf->SetXY(185, 60);
            $this->pdf->Cell(20, 150, '', '1');

            // #0
            $this->pdf->SetXY(5, 60);
            $this->pdf->Cell(10, 7, 'NO', 1, 1, 'C');
            $this->pdf->SetXY(15, 60);
            $this->pdf->Cell(25, 7, 'ITEM CODE', 1, 1, 'C');
            $this->pdf->SetXY(40, 60);
            $this->pdf->Cell(65, 7, 'ITEM NAME', 1, 1, 'C');
            $this->pdf->SetXY(105, 60);
            $this->pdf->Cell(20, 7, 'UNIT PRICE', 1, 1, 'C');
            $this->pdf->SetXY(125, 60);
            $this->pdf->Cell(20, 7, 'ORDER QTY', 1, 1, 'C');
            $this->pdf->SetXY(145, 60);
            $this->pdf->Cell(20, 7, 'FREE QTY', 1, 1, 'C');
            $this->pdf->SetXY(165, 60);
            $this->pdf->Cell(20, 7, $abc, 1, 1, 'C');
            $this->pdf->SetXY(185, 60);
            $this->pdf->Cell(20, 7, 'TOTAL PRICE', 1, 1, 'C');

            $this->pdf->SetFont('Helvetica', '', 8);  // Table body unset bold font
            $this->pdf->SetTextColor(0, 0, 0);

            // #1 - n recode
            $len = sizeof($rest);
            $y = 70;
            $todqt = $qnty = $frqty = 0;
            $ttlPrc = 0.00;
            for ($i = 0; $i < $len; $i++) {
                $this->pdf->SetXY(5, $y);
                $this->pdf->Cell(10, 3, $i + 1, 0, 0, 'C');
                $this->pdf->SetXY(15, $y);
                $this->pdf->Cell(25, 3, $rest[$i]->pbcd, 'L');
                $this->pdf->SetXY(40, $y);
                $this->pdf->MultiCell(65, 3, $rest[$i]->itnm . "\nMODEL - " . $rest[$i]->mdl . " (" . $rest[$i]->mlcd . ")", 0);
                $y2 = $this->pdf->getY();
                $this->pdf->SetXY(105, $y);
                $this->pdf->Cell(20, 3, number_format($rest[$i]->untp, 2, '.', ','), 0, '', 'R');
                $this->pdf->SetXY(125, $y);
                $this->pdf->Cell(20, 3, $rest[$i]->odqt, 0, 0, 'R');
                $this->pdf->SetXY(145, $y);
                $this->pdf->Cell(20, 3, $rest[$i]->frqt, 0, 0, 'R');
                $this->pdf->SetXY(165, $y);
                $this->pdf->Cell(20, 3, $rest[$i]->qnty, 0, 0, 'R');
                $this->pdf->SetXY(185, $y);
                $this->pdf->Cell(20, 3, number_format($rest[$i]->untp * $rest[$i]->qnty, 2, '.', ','), 0, '', 'R');

                $y = $y2 + 3;
                $qnty = $qnty + $rest[$i]->qnty;
                $frqty = $frqty + $rest[$i]->frqt;
                $todqt = $todqt + $rest[$i]->odqt;
                $ttlPrc = $ttlPrc + ($rest[$i]->untp * $rest[$i]->qnty);
            }
            //-----TOTAL AMOUNT--------//

            $this->pdf->SetFont('Helvetica', 'B', 8);
            $this->pdf->SetXY(60, 210);
            $this->pdf->Cell(65, 10, 'TOTAL ', 0, 1, 'C');
            //$this->pdf->SetXY(95, 210);
            // $this->pdf->Cell(25, 8, '', 1, 0, 'C');
            $this->pdf->SetXY(125, 210);
            $this->pdf->Cell(20, 8, $todqt, 1, 0, 'R');
            $this->pdf->SetXY(145, 210);
            $this->pdf->Cell(20, 8, $frqty, 1, 0, 'R');
            $this->pdf->SetXY(165, 210);
            $this->pdf->Cell(20, 8, $qnty, 1, 0, 'R');
            $this->pdf->SetXY(185, 210);
            $this->pdf->Cell(20, 8, number_format($ttlPrc, 2, '.', ','), 1, 0, 'R');

            // REMARKS
            $this->pdf->SetXY(5, 210);
            $this->pdf->Cell(20, 8, 'REMARKS  ', 0, 0, 'L');
            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(10, 225);
            $this->pdf->MultiCell(80, 5, $data[0]->remk, '0.5', 'L', FALSE);

            // FOOTER
            $this->pdf->Line(5, 260, 210 - 5, 260);
            $this->pdf->SetFont('Helvetica', '', 8);
            $this->pdf->SetXY(5, 265);
            $this->pdf->Cell(0, 0, 'Check By : ' . $data[0]->chby);
            $this->pdf->SetXY(5, 275);
            $this->pdf->Cell(0, 0, 'Check By : .....................................');
            $this->pdf->SetXY(65, 265);
            $this->pdf->Cell(0, 0, 'Prepared By : ' . $data[0]->crby . ' | ' . $data[0]->crdt);
            $this->pdf->SetXY(65, 275);
            $this->pdf->Cell(0, 0, 'Prepared By : .......................................');
            $this->pdf->SetXY(140, 265);
            $this->pdf->Cell(0, 0, 'Approval By : ' . $data[0]->apby . ' | ' . $data[0]->apdt);
            $this->pdf->SetXY(140, 275);
            $this->pdf->Cell(0, 0, 'Approval By : .......................................');

            $this->pdf->SetAutoPageBreak(false);
            //FOOTER
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(-15, 285);
            $this->pdf->Cell(10, 6, $_SESSION['hid'], 0, 1, 'R');
            $this->pdf->SetFont('Helvetica', 'I', 7);
            $this->pdf->SetXY(-15, 290);
            $this->pdf->Cell(10, 6, 'Copyright @ ' . $cy . ' - www.gdcreations.com', 0, 1, 'R');
            $this->pdf->SetXY(4, 290);
            $this->pdf->Cell(0, 6, 'Printed : ' . $usedetails[0]->fnme . ' | ' . $date, 0, 1, 'L');

            // REPRINT TAG
            //$policy = $this->Generic_model->getData('sys_policy', array('post'), array('popg' => 'vouc', 'stat' => 1));
            //if ($policy[0]->post == 1) {
            if ($rcdt[0]->pntc > 1) {
                $this->pdf->SetFont('Helvetica', 'B', 7);
                $this->pdf->SetXY(4, 288);
                $this->pdf->Cell(0, 0, 'REPRINTED (' . $pntc . ')');
            }
            //}

            //QR CODE
            // $cd = 'Vou No : ' . $data[0]->vuno . ' | Date : ' . $data[0]->crdt . ' | Payee Name : ' . $data[0]->spnm . ' | Branch : ' . $data[0]->brnm . ' | Pay Type : ' . $data[0]->dsnm . ' | Total : Rs.' . $pyamt . ' | Printed By : ' . $usr . ' | ' . $_SESSION["hid"];
            // $this->pdf->Image(str_replace(" ", "%20", 'http://chart.apis.google.com/chart?cht=qr&chs=190x190&chl=' . $cd), 176, 7, 26, 0, 'PNG');

            $this->pdf->SetTitle('GRN - ' . $data[0]->grno);
            $this->pdf->Output('GRN_' . $data[0]->grno . '.pdf', 'I');
            ob_end_flush();

        } else {
            echo json_encode(false);
        }
        $funcPerm = $this->Generic_model->getFuncPermision('grn_mng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'GRN print (' . $data[0]->grno . ')');
    }

    // REJECT GRN
    function grnRejectXX()
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


//************************************************


//************************************************
//***             STOCK MANAGEMENT             ***
//************************************************
//LOAD PAGE </ 2019-10-08>
    function stckMng()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'stckMng'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('stckMng');
        $data2['category'] = $this->Generic_model->getSortData('category', array('ctid', 'ctcd', 'ctnm', 'stat'), "stat IN(1,3)", '', '', 'ctnm', 'ASC');
        $data2['brand'] = $this->Generic_model->getSortData('brand', array('bdid', 'bdcd', 'bdnm', 'logo', 'stat'), "stat IN(1,3)", '', '', 'bdnm', 'ASC');
        $data2['type'] = $this->Generic_model->getSortData('type', array('tpid', 'tpcd', 'tpnm', 'stat'), "stat IN(1,3)", '', '', 'tpnm', 'ASC');
        $data2['supplier'] = $this->Generic_model->getSortData('supp_mas', array('spid', 'spcd', 'spnm'), array('stat' => 1), '', '', 'spnm', 'ASC');

        $this->load->view('admin/stock/stckManagement', $data2);

        $this->load->view('common/tmpFooter', $data);
    }
    //END LOAD PAGE </ 2019-10-08>

    //GET GRN
    function getGrn()
    {
        $spid = $this->input->post('spid');

        $this->db->select("grn.grid,grn.grno,grn.grdt");
        $this->db->from("stock_grn grn");
        $this->db->where('grn.spid', $spid);
        $this->db->where('grn.stat', 1);
        $this->db->where('grn.grtp', 1);
        $this->db->where('grn.stst', 0);
        $query = $this->db->get();
        $data = $query->result();

        echo json_encode($data);
    }
    //GET GRN

    //GET GRN DETAILS
    function getGrnDet()
    {
        $grid = $this->input->post('grid');

        $this->db->select("grn.*,wh.whcd,wh.whnm,(po.vtrt + po.nbrt + po.btrt + po.txrt) AS rate");
        $this->db->from('stock_grn grn');
        $this->db->join('stock_wh wh', 'wh.whid=grn.whid');
        $this->db->join('stock_po po', 'po.poid=grn.poid');
        $this->db->where('grn.grid', $grid);
        $res['grn'] = $this->db->get()->result();

        $this->db->select("grnd.*,it.itcd,it.itnm");
        $this->db->from('stock_grn_des grnd');
        $this->db->join('item it', 'it.itid=grnd.itid');
        $this->db->where("grnd.grid=$grid AND grnd.stat=1");
        $this->db->where("grnd.gdid NOT IN((SELECT gdid FROM stock WHERE stock.stat IN(0,1,2,4) AND grid=$grid))");
        $res['grnd'] = $this->db->get()->result();

        echo json_encode($res);
    }
    //END GET GRN DETAILS

    //GET SERIAL NUMBER ITEM </2019-10-10>
    function srch_SrlNum()
    {
        $val = $this->input->post('val');
        $stid = $this->input->post('stid');

        $this->db->select("stb.*");
        $this->db->from('stock_sub stb');
        $this->db->where('stb.stid', $stid);
        if ($val != '') {
            $this->db->where("stb.srno=$val");
        }
        $res = $this->db->get()->result();
        echo json_encode($res);
    }
    //GET SERIAL NUMBER ITEM </2019-10-10>

    // STOCK ADD ADD </2019-10-09>
    function addStock()
    {
        $spid = $this->input->post('spid');
        $this->db->trans_begin(); // SQL TRANSACTION START

        //STOCK CODE GENERATE
        $supply = $this->Generic_model->getData('supp_mas', array('spcd'), array('stat' => 1, 'spid' => $spid));
        $spcd = $supply[0]->spcd;

        $this->db->select("stcd");
        $this->db->from("stock");
        //$this->db->where('spid', $spid);
        $this->db->order_by('stid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');

        if (sizeof($data) > 0) {
            $icde = $data[0]->stcd;
            $re = (explode("-", $icde));

            $aa = intval($re[1]) + 1;
            $cc = strlen($aa);
            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '' . $aa;
            }
            $stno = 'ST' . $yr . '-' . $xx;
        } else {
            $stno = 'ST' . $yr . '-0001';  // Ex (STOCK)(YEAR)-NO - ST18-0001
        }

        $len = $this->input->post('leng');

        $itid = $this->input->post('itid[]');   // ITEM CODE
        $untp = $this->input->post('untp[]');   // UNIT PRICE
        $txpr = $this->input->post('txpr[]');   // TAX + COST
        $csvl = $this->input->post('csvl[]');   // COST
        $fcvl = $this->input->post('dsvl[]');   // DISPLY
        $slvl = $this->input->post('slvl[]');   // SALES
        $mkvl = $this->input->post('mkvl[]');   // MARKET
        $frqt = $this->input->post('frqt[]');
        $qunt = $this->input->post('qunt[]');   // QUENTY
        $dscr = $this->input->post('rmks[]');   // REMARKS

        $gdid = $this->input->post('gdid[]');   // GRN DES TB ID

        $stidNw = 0;
        $stidNw2 = 0;
        for ($a = 0; $a < $len; $a++) {
            // IF SALES VALUE & FACE VALUE NOT EMPTY & NOT ZERO
            if ($fcvl[$a] != 0 || $fcvl[$a] != 0 && $slvl[$a] != 0 || $slvl[$a] != 0) {
                $this->Generic_model->insertData('stock', array(
                    'stcd' => $stno,
                    'spid' => $spid,
                    'grid' => $this->input->post('grid'),
                    'gdid' => $gdid[$a],
                    'whid' => $this->input->post('whid'),
                    'itid' => $itid[$a],

                    'untp' => $untp[$a],
                    'txvl' => $txpr[$a],
                    'csvl' => $csvl[$a],
                    'fcvl' => $fcvl[$a],
                    'slvl' => $slvl[$a],
                    'mkvl' => $mkvl[$a],
                    'frqt' => $frqt[$a],
                    'qunt' => $qunt[$a],
                    'avqn' => ($frqt[$a] + $qunt[$a]),
                    'dscr' => $dscr[$a],
                    'stat' => 0,
                    'blsk' => 0,
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                ));
                if ($a == 0) {
                    $stidNw = $this->db->insert_id();
                }
                $stidNw2 = $this->db->insert_id();
            }
        }

        if ($stidNw == $stidNw2) {
            $msg = $stidNw;
        } else {
            $msg = $stidNw . " - " . $stidNw2;
        }

        $this->Generic_model->updateData('stock_grn', array('stst' => 1), array('grid' => $this->input->post('grid')));

        $funcPerm = $this->Generic_model->getFuncPermision('stckMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Add New Stocks ($msg)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    // END STOCK ADD ADD </2019-10-09>

    //SEARCH STOCK </2019-10-09>
    function srchStck()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('stckMng');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->apvl == 1) {
            $app = "";
        } else {
            $app = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
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

        $result = $this->Stock_model->get_mnStock();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $stid = $row->stid;
            if ($st == '0') {                   // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($stid);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modal-edit'  onclick='edtStck($stid,this.id);' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  $app  data-toggle='modal' data-target='#modal-edit'  onclick='edtStck($stid,this.id);' class='btn btn-xs btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  $rej  onclick='rejecStck($stid,$row->grid,$row->gdid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '1') {           // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($stid);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='dec' $dac onclick='deacStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Deactivate' ><i class='fa fa-close' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {            // Finished
                $stat = " <span class='label label-primary'> Finish </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($stid);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '3') {
                $stat = " <span class='label label-danger'> Reject </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($stid);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '4') {
                $stat = " <span class='label label-indi'> Deactive </span> ";
                $option =
                    "<button type='button' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($stid);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rec' $reac onclick='reacStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Reactivate' ><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->stcd;
            $sub_arr[] = $row->spnm;
            $sub_arr[] = $row->itcd . ' | ' . $row->itnm;
            $sub_arr[] = number_format($row->csvl, 2, '.', ',');
            $sub_arr[] = number_format($row->fcvl, 2, '.', ',');
            $sub_arr[] = number_format($row->slvl, 2, '.', ',');
            $sub_arr[] = $row->qunt;
            $sub_arr[] = $row->frqt;
            $sub_arr[] = $row->avqn;
            $sub_arr[] = $row->crdtf;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        //$output = array("data" => $data);
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_mnStock(),
            "recordsFiltered" => $this->Stock_model->count_filtered_mnStock(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    //SEARCH STOCK </2019-10-09>

    //VIEW STOCK </2019-10-09>
    function vewStock()
    {
        $auid = $this->input->post('auid');

        $this->db->select("stk.*, sp.spcd, sp.spnm, item.itnm, item.itcd, item.mdl,item.mlcd,item.size, 
        sl.scl,sl.scnm,ssl.scl AS sscl,ssl.scnm AS sscnm,
        cat.ctcd, cat.ctnm, bd.bdcd, bd.bdnm, tp.tpcd, tp.tpnm, CONCAT(cr.fnme,' ',cr.lnme) AS crnm,
        CONCAT(ap.fnme,' ',ap.lnme) AS apnm,CONCAT(md.fnme,' ',md.lnme) AS mdnm, CONCAT(rj.fnme,' ',rj.lnme) AS rjnm,
        grn.grno,wh.whcd, wh.whnm, ");
        $this->db->from("stock stk");
        $this->db->join('item', 'item.itid = stk.itid ');
        $this->db->join('scale sl', 'sl.slid = item.scli ');
        $this->db->join('scale ssl', 'ssl.slid = item.szsl ');
        $this->db->join('supp_mas sp', 'sp.spid = stk.spid ');
        $this->db->join('stock_grn grn', 'grn.grid = stk.grid ');
        $this->db->join('stock_wh wh', 'wh.whid = stk.whid ');
        $this->db->join('category cat', 'cat.ctid = item.ctid ');
        $this->db->join('brand bd', 'bd.bdid = item.bdid ');
        $this->db->join('type tp', 'tp.tpid = item.tpid ');
        $this->db->join('user_mas cr', 'cr.auid = stk.crby ');
        $this->db->join('user_mas ap', 'ap.auid=stk.apby', 'LEFT');
        $this->db->join('user_mas md', 'md.auid=stk.mdby', 'LEFT');
        $this->db->join('user_mas rj', 'rj.auid=stk.rjby', 'LEFT');
        $this->db->where('stk.stid', $auid);
        $query = $this->db->get();
        $result['stdt'] = $query->result();

        $result['sbdt'] = $this->Generic_model->getData('stock_sub', '', array('stid' => $auid));

        echo json_encode($result);
    }
    //END VIEW STOCK </2019-10-09>

    // REJECT STOCK </2019-10-09>
    function rejStock()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $id = $this->input->post('id');
        $grid = $this->input->post('grid');
        $this->Generic_model->updateData('stock', array('stat' => 3), array('stid' => $id));
        $this->Generic_model->updateData('stock_sub', array('stat' => 0), array('stid' => $id));

        $this->Generic_model->updateData('stock_grn', array('stst' => 0), array('grid' => $grid));

        $funcPerm = $this->Generic_model->getFuncPermision('stckMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Stock Reject id(' . $id . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    //END REJECT STOCK </2019-10-09>

    // UPDATE || APPROVE STOCK </2019-10-10>
    function edtStock()
    {
        $func = $this->input->post('func'); // 1 - edit / 2 - approval
        $auid = $this->input->post('stkid');
        // GET STOCK SUB TABLE DETAILS
        $subdt = $this->Generic_model->getData('stock_sub', '', array('stid' => $auid));

        $csvl = $this->input->post('csvlEdt[]');   // COST
        $fcvl = $this->input->post('dsvlEdt[]');   // DISPLY
        $slvl = $this->input->post('slvlEdt[]');   // SALES
        $mkvl = $this->input->post('mkvlEdt[]');   // MARKET
        $dscr = $this->input->post('rmksEdt[]');   // REMARKS

        if ($func == 'edt') {
            $this->db->trans_begin();           // SQL TRANSACTION START
            $data_ar1 = array(
                'csvl' => $csvl[0],   // COST
                'fcvl' => $fcvl[0],   // DISPLY
                'slvl' => $slvl[0],   // SALES
                'mkvl' => $mkvl[0],   // MARKET
                'dscr' => $dscr[0],   // REMARKS
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'stid' => $auid
            );
            $this->Generic_model->updateData('stock', $data_ar1, $where_arr);

            // STOCK SUB TABLE UPDATE
            $serno = $this->input->post('serno[]');   // ITEM CODE
            $batno = $this->input->post('batno[]');   // UNIT PRICE
            $prtno = $this->input->post('prtno[]');   // TAX + COST
            $brcod = $this->input->post('brcod[]');   // COST
            $abcno = $this->input->post('abcno[]');   // DISPLY
            $xyzno = $this->input->post('xyzno[]');   // SALES
            $subrm = $this->input->post('subrm[]');   // REMARKS

            if (sizeof($subdt) > 0) {
                $sbid = $this->input->post('sbid[]');   // SUB TABLE AUID
                for ($a = 0; $a < sizeof($serno); $a++) {
                    $data_arr = array(
                        'srno' => $serno[$a],
                        'btno' => $batno[$a],
                        'prno' => $prtno[$a],
                        'brcd' => $brcod[$a],
                        'abc' => $abcno[$a],
                        'xyz' => $xyzno[$a],
                        'remk' => $subrm[$a],
                        'stat' => 1,
                        'crby' => $_SESSION['userId'],
                        'crdt' => date('Y-m-d H:i:s'),
                    );
                    $where_arr = array(
                        'ssid' => $sbid[$a]
                    );
                    $this->Generic_model->updateData('stock_sub', $data_arr, $where_arr);
                }

            } else {
                for ($a = 0; $a < sizeof($serno); $a++) {
                    $data_arr = array(
                        'stid' => $auid,
                        'srno' => $serno[$a],
                        'btno' => $batno[$a],
                        'prno' => $prtno[$a],
                        'brcd' => $brcod[$a],
                        'abc' => $abcno[$a],
                        'xyz' => $xyzno[$a],
                        'remk' => $subrm[$a],
                        'stat' => 1,
                        'crby' => $_SESSION['userId'],
                        'crdt' => date('Y-m-d H:i:s'),
                    );
                    $this->Generic_model->insertData('stock_sub', $data_arr);
                }
            }

            $funcPerm = $this->Generic_model->getFuncPermision('stckMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Stock Update id(' . $auid . ')');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
        } else if ($func == 'app') {
            $this->db->trans_begin();           // SQL TRANSACTION START

            $data_ar1 = array(
                'csvl' => $csvl[0],   // COST
                'fcvl' => $fcvl[0],   // DISPLY
                'slvl' => $slvl[0],   // SALES
                'mkvl' => $mkvl[0],   // MARKET
                'dscr' => $dscr[0],   // REMARKS
                'stat' => 1,
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s')
            );
            $where_arr = array(
                'stid' => $auid
            );
            $this->Generic_model->updateData('stock', $data_ar1, $where_arr);

            // STOCK SUB TABLE UPDATE
            $serno = $this->input->post('serno[]');   // ITEM CODE
            $batno = $this->input->post('batno[]');   // UNIT PRICE
            $prtno = $this->input->post('prtno[]');   // TAX + COST
            $brcod = $this->input->post('brcod[]');   // COST
            $abcno = $this->input->post('abcno[]');   // DISPLY
            $xyzno = $this->input->post('xyzno[]');   // SALES
            $subrm = $this->input->post('subrm[]');   // REMARKS

            if (sizeof($subdt) > 0) {
                $sbid = $this->input->post('sbid[]');   // SUB TABLE AUID
                for ($a = 0; $a < sizeof($serno); $a++) {
                    $data_arr = array(
                        'srno' => $serno[$a],
                        'btno' => $batno[$a],
                        'prno' => $prtno[$a],
                        'brcd' => $brcod[$a],
                        'abc' => $abcno[$a],
                        'xyz' => $xyzno[$a],
                        'remk' => $subrm[$a],
                        'stat' => 1,
                        'crby' => $_SESSION['userId'],
                        'crdt' => date('Y-m-d H:i:s'),
                    );
                    $where_arr = array(
                        'ssid' => $sbid[$a]
                    );
                    $this->Generic_model->updateData('stock_sub', $data_arr, $where_arr);
                }

            } else {
                for ($a = 0; $a < sizeof($serno); $a++) {
                    $data_arr = array(
                        'stid' => $auid,
                        'srno' => $serno[$a],
                        'btno' => $batno[$a],
                        'prno' => $prtno[$a],
                        'brcd' => $brcod[$a],
                        'abc' => $abcno[$a],
                        'xyz' => $xyzno[$a],
                        'remk' => $subrm[$a],
                        'stat' => 1,
                        'crby' => $_SESSION['userId'],
                        'crdt' => date('Y-m-d H:i:s'),
                    );
                    $this->Generic_model->insertData('stock_sub', $data_arr);
                }
            }


            $funcPerm = $this->Generic_model->getFuncPermision('stckMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Stock Approval Update id(' . $auid . ')');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(false);
            } else {
                $this->db->trans_commit(); // SQL TRANSACTION END
                echo json_encode(true);
            }
        }

    }
    //END UPDATE || APPROVE STOCK </2019-10-10>

    //DEACTIVATE STOCK </2019-10-10>
    function stck_Deactive()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $id = $this->input->post('id');
        $this->Generic_model->updateData('stock', array(
            'stat' => 4,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('stid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('stckMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Stock Deactivated ($id)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END DEACTIVATE STOCK </2019-10-10>

//ACTIVATE STOCK </2019-10-10>
    function stck_Activate()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $id = $this->input->post('id');
        $this->Generic_model->updateData('stock', array(
            'stat' => 1,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('stid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('stckMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Stock Reactivated ($id)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END ACTIVATE STOCK </2019-10-10>
//************************************************
//***           END STOCK MANAGEMENT           ***
//************************************************

//************************************************
//***               STOCK CONVERSION           ***
//************************************************
//LOAD PAGE </ 2019-10-14>
    function stckCnv()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'stckCnv'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('stckCnv');
        $data2['branchinfo'] = $this->Generic_model->getBranch();
        $data2['scale'] = $this->Generic_model->getData('scale', '', array('stat' => 1));
        $data2['item'] = $this->Generic_model->getSortData('item', array('itid', 'itcd', 'itnm', 'stat'), array('stat' => 1), '', '', 'itnm', 'ASC');
        $data2['supplier'] = $this->Generic_model->getSortData('supp_mas', array('spid', 'spcd', 'spnm'), array('stat' => 1), '', '', 'spnm', 'ASC');

        $this->load->view('admin/stock/stckConversion', $data2);

        $this->load->view('common/tmpFooter', $data);
    }
    //END LOAD PAGE </ 2019-10-14>

    //SEARCH BRANCH STOCK TO CONVERT </2019-10-14>
    function srchBrchStck_Cn()
    {
        $brch = $this->input->post('brch');
        $itid = $this->input->post('itid');

        $this->db->select("stb.*,it.itcd,it.itnm,it.mdl,it.mlcd,it.size,sc.scl,sc.scnm,
        szs.scl As zscl,szs.scnm AS zscnm,
        (SELECT COUNT(*) FROM stock_brn_sub sbs JOIN stock_brn stb1 ON stb1.stbid=sbs.stcid WHERE stb1.stat=0 AND sbs.stbid=stb.stbid) AS pcnt");
        $this->db->from('stock_brn stb');
        $this->db->join('item it', 'it.itid=stb.itid');
        $this->db->join('scale sc', 'sc.slid=it.scli');
        $this->db->join('scale szs', 'szs.slid=it.szsl');
        $this->db->where('stb.stat', 1);
        $this->db->where('stb.cst', 0);
        if ($brch != 'all') {
            $this->db->where('stb.brid', $brch);
        }
        if ($itid != 'all') {
            $this->db->where('stb.itid', $itid);
        }
        $res = $this->db->get()->result();

        $scl = $this->Generic_model->getData('scale', '', array('stat' => 1));
        $scaleO = "<option value='0'>Select Scale</option>";
        foreach ($scl as $sl) {
            $scaleO = $scaleO . "<option value='$sl->slid'>$sl->scnm - ($sl->scl)</option>";
        }

        $data = array();
        $i = 0;

        foreach ($res as $row) {
            ++$i;
            $scaleS = "<select class='form-control' id='nscl_$i' name='nscl_$i' onchange='checkScale(this.value,$i)'>" . $scaleO . "</select>";

            $opt = "<button type='button' id='addConBtn_$i' onclick='addCon($row->stbid,$i)' class='btn btn-xs btn-info btn-condensed' title='Add to convert'>
                            <span class='fa fa-angle-double-right'></span></button>";

            $sub_arr = array();
            $sub_arr[] = $i;
            $sub_arr[] = $row->stcd;
            $sub_arr[] = $row->itcd;
            $sub_arr[] = "<span data-html='true' data-toggle='tooltip' data-placement='top' data-original-title='Model<br>$row->mdl<br>$row->mlcd'>" . $row->itnm . "</span>";
            $sub_arr[] = $row->scnm . " (" . $row->scl . ")";
            $sub_arr[] = $row->avqn . "<input type='hidden' id='avqn_$i' name='avqn_$i' value='$row->avqn'/>";
            $sub_arr[] = "<span title='$row->zscnm'>" . $row->size . " ($row->zscl)</span><input type='hidden' id='size_$i' name='size_$i' value='$row->size'/>";
            $sub_arr[] = $scaleS;
            $sub_arr[] = "<input type='text' data-container='body' data-toggle='popover' data-placement='top'
                                                   data-html='true'
                                                   data-trigger='focus'
                                                   data-content='Pending Conversion QTY<br><h3 style=\"text-align: center; color: #e69c0f; font-size: 18px; font-weight: bold\">$row->pcnt</h3>' 
                                                   class='form-control' id='qty_$i' name='qty_$i' style='text-align: right; width: 100%' onkeyup='checkQty(this.value,$i);'/>";
            $sub_arr[] = number_format(($row->csvl / $row->size), 2) . "<input type='hidden' id='csvl_$i' value='" . ($row->csvl / $row->size) . "'>";
            $sub_arr[] = "<input type='text' style='text-align: right; width: 100%' class='form-control' id='slvl_$i' name='slvl_$i' onkeyup='checkSlvl(this.value,$i)'>";
            $sub_arr[] = "<input type='text' style='text-align: right; width: 100%' class='form-control' id='fcvl_$i' name='fcvl_$i' onkeyup='checkFcvl(this.value,$i)'>";
            $sub_arr[] = "<input type='text' style='text-align: right; width: 100%' class='form-control' id='mkvl_$i' name='mkvl_$i' onkeyup='checkMkvl(this.value,$i)'>";
            $sub_arr[] = $opt;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => sizeof($res),
            "recordsFiltered" => sizeof($res),
            "data" => $data,
        );
        echo json_encode($output);
    }
    //END SEARCH BRANCH STOCK TO CONVERT </2019-10-14>

    //GET SERIAL NUMBER ITEM </2019-10-15>
    function srch_SrlNumCon()
    {
        $val = $this->input->post('val');
        $stid = $this->input->post('stid');

        $this->db->select("stb.*,sb.srno,sb.btno,sb.prno,sb.brcd,sb.abc,sb.xyz");
        $this->db->from('stock_brn_sub stb');
        $this->db->join('stock_sub sb', 'sb.ssid=stb.ssid');
        $this->db->where('stb.stbid', $stid);
        $this->db->where("stb.stat=1 AND stb.trst=0");
        if ($val != '') {
            $this->db->where("sb.srno=$val");
        }
        $res = $this->db->get()->result();
        echo json_encode($res);
    }
    //GET SERIAL NUMBER ITEM </2019-10-15>

    //ADD TO CONVERTION </2019-10-15>
    function addToConv()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $stid = $this->input->post('stBrchID');
        $qty = $this->input->post('addQty');
        $nscl = $this->input->post('newScal');

        //Get Item Details
        $this->db->select("stb.stid,stb.brid,stb.itid,
        bm.brcd,it.size");
        $this->db->from('stock_brn stb');
        $this->db->join('brch_mas bm', 'bm.brid=stb.brid');
        $this->db->join('item it', 'it.itid=stb.itid');
        $this->db->where('stb.stbid', $stid);
        $item = $this->db->get()->result();

        //Get next Stock code
        $this->db->select("stcd");
        $this->db->from("stock_brn");
        $this->db->where('cst', 1);
        $this->db->order_by('stbid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');

        if (sizeof($data) > 0) {
            $icde = $data[0]->stcd;
            $re = (explode("-", $icde));

            $aa = intval($re[2]) + 1;
            $cc = strlen($aa);
            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '' . $aa;
            }
            $stno = 'STC' . $yr . '-' . $item[0]->brcd . '-' . $xx;
        } else {
            $stno = 'STC' . $yr . '-' . $item[0]->brcd . '-0001';  // Ex (STOCK)(YEAR)-NO - ST18-0001
        }

        $this->Generic_model->insertData('stock_brn', array(
            'stcd' => $stno,
            'stfr' => 2,
            'stid' => $item[0]->stid,
            'itid' => $item[0]->itid,
            'brid' => $item[0]->brid,
            'frid' => $item[0]->brid,
            'csvl' => $this->input->post('newCsvl'),
            'fcvl' => $this->input->post('newFcvl'),
            'slvl' => $this->input->post('newSlvl'),
            'mkvl' => $this->input->post('newMkvl'),
            'qunt' => $qty * $item[0]->size,
            'avqn' => $qty * $item[0]->size,
            'stat' => 0,
            'cst' => 1,
            'cslid' => $nscl,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
        ));
        $lstid = $this->db->insert_id();

        $srl = $this->input->post('srlnum[]');
        for ($it = 0; $it < sizeof($srl); $it++) {
            $this->Generic_model->updateData('stock_brn_sub', array('stcid' => $lstid, 'stat' => 3), array('sbsid' => $srl[$it]));
        }

        $funcPerm = $this->Generic_model->getFuncPermision('stckCnv');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Add to convert stock ($lstid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    //END ADD TO CONVERTION </2019-10-15>

    //SEARCH CONVERSION STOCKS </2019-10-15>
    function srchConStck()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('stckMng');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->apvl == 1) {
            $app = "";
        } else {
            $app = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
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

        $result = $this->Stock_model->get_sbcStock();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $stid = $row->stbid;
            if ($st == '0') {                   // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($stid,this.id);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($stid,this.id);' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  $app  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($stid,this.id);' class='btn btn-xs btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  $rej  onclick='rejecStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '1') {           // Approved
                $stat = " <span class='label label-success'> Active </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($stid,this.id);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='dec' $dac onclick='deacStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Deactivate' ><i class='fa fa-close' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {            // Finished
                $stat = " <span class='label label-primary'> Finish </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($stid,this.id);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '3') {
                $stat = " <span class='label label-danger'> Reject </span> ";
                $option =
                    "<button type='button' disabled  data-toggle='modal' data-target='#modal-view'  onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '4') {
                $stat = " <span class='label label-indi'> Deactive </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($stid,this.id);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='edtStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rec' $reac onclick='reacStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Reactivate' ><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck($stid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->stcd;
            $sub_arr[] = "<span data-html='true' data-toggle='tooltip' data-placement='top' data-original-title='$row->brnm'>" . $row->brcd . "</span>";
            $sub_arr[] = $row->itcd . ' | ' . $row->itnm;
            $sub_arr[] = number_format($row->csvl, 2, '.', ',');
            $sub_arr[] = number_format($row->fcvl, 2, '.', ',');
            $sub_arr[] = number_format($row->slvl, 2, '.', ',');
            $sub_arr[] = $row->qunt;
            $sub_arr[] = $row->avqn;
            $sub_arr[] = $row->crdtf;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        //$output = array("data" => $data);
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_sbcStock(),
            "recordsFiltered" => $this->Stock_model->count_filtered_sbcStock(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    //END SEARCH CONVERSION STOCKS </2019-10-15>

    //REJECT CONVERSION STOCK </2019-10-15>
    function rejConStock()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $id = $this->input->post('id');

        $this->Generic_model->updateData('stock_brn', array('stat' => 3), array('stbid' => $id));
        $this->Generic_model->updateData('stock_brn_sub', array('stat' => 1), array('stcid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('stckCnv');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Conversion Stock Reject id(' . $id . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    //END REJECT CONVERSION STOCK </2019-10-15>

    //VIEW CONVERSION STOCK </2019-10-16>
    function vewConStock()
    {
        $auid = $this->input->post('auid');

        $this->db->select("stk.*,item.itnm, item.itcd, item.mdl,item.mlcd,item.size,
        sl.scl,sl.scnm,ssl.scl AS sscl,ssl.scnm AS sscnm,
        cat.ctcd, cat.ctnm, bd.bdcd, bd.bdnm, tp.tpcd, tp.tpnm, CONCAT(cr.fnme,' ',cr.lnme) AS crnm,
        CONCAT(ap.fnme,' ',ap.lnme) AS apnm,CONCAT(md.fnme,' ',md.lnme) AS mdnm, CONCAT(rj.fnme,' ',rj.lnme) AS rjnm");
        $this->db->from("stock_brn stk");
        $this->db->join('item', 'item.itid = stk.itid ');
        $this->db->join('scale ssl', 'ssl.slid = item.szsl ');
        $this->db->join('scale sl', 'sl.slid = stk.cslid ');
        $this->db->join('category cat', 'cat.ctid = item.ctid');
        $this->db->join('brand bd', 'bd.bdid = item.bdid ');
        $this->db->join('type tp', 'tp.tpid = item.tpid ');
        $this->db->join('user_mas cr', 'cr.auid = stk.crby ');
        $this->db->join('user_mas ap', 'ap.auid=stk.apby', 'LEFT');
        $this->db->join('user_mas md', 'md.auid=stk.mdby', 'LEFT');
        $this->db->join('user_mas rj', 'rj.auid=stk.rjby', 'LEFT');
        $this->db->where('stk.stbid', $auid);
        $query = $this->db->get();
        $result['stdt'] = $query->result();

        $this->db->select("ss.srno,sbs.sbsid,sbs.stbid");
        $this->db->from('stock_brn_sub sbs');
        $this->db->join('stock_sub ss', 'ss.ssid=sbs.ssid');
        $this->db->where('stcid', $auid);
        $result['sbdt'] = $this->db->get()->result();

        echo json_encode($result);
    }
    //END VIEW CONVERSION STOCK </2019-10-16>

    //EDIT || APPROVE CONVERTION STOCK </2019-10-16>
    function edtConStock()
    {
        $this->db->trans_begin();           // SQL TRANSACTION START
        $func = $this->input->post('func');
        $auid = $this->input->post('stid_Vw');

        if ($func == 'edt') {
            $msg = "Stock conversion updated";
            //Update Stock
            $this->Generic_model->updateData('stock_brn', array(
                'fcvl' => $this->input->post('vewFcvl'),
                'slvl' => $this->input->post('vewSalvl'),
                'mkvl' => $this->input->post('vewMktvl'),
                'cst' => 1,
                'cslid' => $this->input->post('vewScale'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('stbid' => $auid));
        } else if ($func == 'app') {
            $msg = "Stock conversion completed";
            //Update Stock
            $this->Generic_model->updateData('stock_brn', array(
                'fcvl' => $this->input->post('vewFcvl'),
                'slvl' => $this->input->post('vewSalvl'),
                'mkvl' => $this->input->post('vewMktvl'),
                'cst' => 1,
                'stat' => 1,
                'cslid' => $this->input->post('vewScale'),
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            ), array('stbid' => $auid));

            $this->db->select("sb.avqn,sbs.stbid,COUNT(sbs.stcid) AS cnt");
            $this->db->from('stock_brn_sub sbs');
            $this->db->join('stock_brn sb', 'sb.stbid=sbs.stbid');
            $this->db->where("stcid=$auid");
            $prvStk = $this->db->get()->result();

            //Previous Stock AVQTY update
            $this->Generic_model->updateData('stock_brn', array(
                'avqn' => $prvStk[0]->avqn - $prvStk[0]->cnt,
            ), array('stbid' => $prvStk[0]->stbid));
        }

        $srl = $this->input->post('srlnumEdt[]');
        $this->Generic_model->updateData('stock_brn_sub', array('stcid' => 0, 'stat' => 1), array('stcid' => $auid));
        for ($it = 0; $it < sizeof($srl); $it++) {
            $this->Generic_model->updateData('stock_brn_sub', array('stcid' => $auid, 'stat' => 3), array('sbsid' => $srl[$it]));
        }

        $funcPerm = $this->Generic_model->getFuncPermision('stckCnv');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, $msg . ' id(' . $auid . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    //END EDIT || APPROVE CONVERTION STOCK </2019-10-16>

//DEACTIVATE STOCK </2019-10-16>
    function conStck_Deactive()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $id = $this->input->post('id');
        $this->Generic_model->updateData('stock_brn', array(
            'stat' => 4,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('stbid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('stckCnv');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Converted Stock Deactivated ($id)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END DEACTIVATE STOCK </2019-10-16>

//ACTIVATE STOCK </2019-10-16>
    function conStck_Activate()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $id = $this->input->post('id');
        $this->Generic_model->updateData('stock_brn', array(
            'stat' => 1,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('stbid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('stckCnv');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Converted Stock Reactivated ($id)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
//END ACTIVATE STOCK </2019-10-16>

//************************************************
//***           END STOCK CONVERSION           ***
//************************************************

//************************************************
//***               STOCK REQUEST              ***
//************************************************
//LOAD PAGE </ 2019-10-17>
    function stckReq()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'stckReq'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('stckReq');
        $data2['brncFrm'] = $this->Generic_model->getBranch();
        $data2['brncTo'] = $this->Generic_model->getSortData('brch_mas', array('brid', 'brcd', 'brnm'), array('stat' => 1), '', '', 'brnm', 'ASC');

        //Item With Storing Scale
        $this->db->select("itid,itcd,itnm,slid,scnm,scl,mdl,mlcd");
        $this->db->from('item');
        $this->db->join('scale', 'scale.slid=item.scli');
        $this->db->where('item.stat', 1);
        $this->db->order_by('itnm', 'ASC');
        $data2['item'] = $this->db->get()->result();

        $data2['warehouse'] = $this->Generic_model->getSortData('stock_wh', array('whid', 'whcd', 'whnm'), array('stat' => 1), '', '', 'whnm', 'ASC');

        $this->load->view('admin/stock/stckRequest', $data2);

        $this->load->view('common/tmpFooter', $data);
    }
    //END LOAD PAGE </ 2019-10-17>

    //ADD REQUEST </2019-10-17>
    function stReq_Add()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $rqBrch = $this->Generic_model->getData('brch_mas', '', array('brid' => $this->input->post('tobrc')));
        //Create next request number
        $this->db->select("rqno");
        $this->db->from("stock_req");
        $this->db->where('rsbc', $rqBrch[0]->brid);
        $this->db->order_by('rqid', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result();

        $yr = date('y');

        if (count($data) == '0') {
            $rqno = 'SRQ' . $yr . '-' . $rqBrch[0]->brcd . '-0001';  // Ex GRN/YR/1/NO - GRN/18/0/0001
        } else {
            $rqno = $data[0]->rqno;
            $re = (explode("-", $rqno));

            $aa = intval($re[2]) + 1;
            $cc = strlen($aa);
            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '0' . $aa;
            }
            $rqno = 'SRQ' . $yr . '-' . $rqBrch[0]->brcd . '-' . $xx;
        }

        if ($this->input->post('reqFr') == 1) {
            $rqfr = 1;
            $rrbc = $this->input->post('frwh');
        } else {
            $rqfr = 2;
            $rrbc = $this->input->post('frBrn');
        }

        //Insert Main Details
        $this->Generic_model->insertData('stock_req', array(
            'rqno' => $rqno,
            'rqfr' => $rqfr,
            'rsbc' => $rqBrch[0]->brid,
            'rrbc' => $rrbc,
            'stat' => 0,
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
            'rmk' => $this->input->post('remk')
        ));

        $lstid = $this->db->insert_id();
        //Insert Sub Details
        $itid = $this->input->post('itid[]');
        $qty = $this->input->post('qunty[]');

        for ($it = 0; $it < sizeof($itid); $it++) {
            $this->Generic_model->insertData('stock_req_sub', array(
                'rqid' => $lstid,
                'rsbc' => $rqBrch[0]->brid,
                'itid' => $itid[$it],
                'reqty' => $qty[$it],
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
                'stat' => 0
            ));
        }

        $funcPerm = $this->Generic_model->getFuncPermision('stckReq');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Made a stock request (' . $rqno . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    //END ADD REQUEST </2019-10-17>

    //SEARCH REQUESTED STOCKS </2019-10-18>
    function searchStReq()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('stckReq');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->apvl == 1) {
            $app = "";
        } else {
            $app = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }
        if ($funcPerm[0]->reac == 1) {
            $reac = "";
        } else {
            $reac = "disabled";
        }

        $result = $this->Stock_model->get_ReqStock();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $rqid = $row->rqid;

            //IS EVEN AN ITEM APPROVED
            $isItIss = "disabled";
            $isItIssMsg = "Goods not issued yet";
            $styl = "btn btn-xs btn-default btn-condensed";
            if ($row->niscnt > 0) {
                $isItIss = "";
                $isItIssMsg = $row->niscnt . " goods issued (Make as received)";
                $styl = "label-icon label-icon-info label-icon-bordered";
            }

            $isRej = 'View'; //main stock side
            if ($row->rjcnt > 0) {
                $isRej = $row->rjcnt . " rejected goods here";
            }

            if ($st == '0') {                   // Pending
                $stat = " <span class='label label-warning'> Pending </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  $edt  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  $app  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  $rej  onclick='rejecStck($rqid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

            } else if ($st == '1') {           // Approved
                $stat = " <span class='label label-success'> Waiting For Goods </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='$isRej' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modal-view'  onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modal-view'  onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rec' $isItIss $reac data-toggle='modal' data-target='#modal-view' onclick='viewStck($rqid,this.id);' class='$styl' title='$isItIssMsg'><i class='fa fa-chevron-down' aria-hidden='true'></i></button> ";

            } else if ($st == '2') {            // Cancelled
                $stat = " <span class='label label-danger'> Cancelled </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck($rqid);' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '3') {        //Recieved
                $stat = " <span class='label label-info'> Received </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck();' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '4') {
                $stat = " <span class='label label-primary' title='Issue rejected'> Issue Rej. </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej'  disabled  onclick='rejecStck();' class='btn btn-xs btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";
            } else if ($st == '5') {
                $stat = " <span class='label label-indi' title='Issue rejected'> On The Way </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='view' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='edit' ><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app'  disabled  data-toggle='modal' data-target='#modalEdt'  onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='approval' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rec' $isItIss $reac data-toggle='modal' data-target='#modal-view' onclick='viewStck($rqid,this.id);' class='$styl' title='$isItIssMsg'><i class='fa fa-chevron-down' aria-hidden='true'></i></button> ";
            }

            if ($row->rqfr == 1) {
                $rqfr = "<label class='label label-info label-bordered label-ghost' title='Warehouse'>WH</label> ";
            } else {
                $rqfr = "<label class='label label-info label-bordered label-ghost' title='Branch'>BR</label> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->rqno;
            $sub_arr[] = $row->rsbrcd . " - " . $row->rsbrnm;
            $sub_arr[] = $rqfr . $row->rrbrcd . " - " . $row->rrbrnm;
            $sub_arr[] = "<strong><span style='color: #76AB3C'>" . str_pad($row->ascnt, 2, 0, STR_PAD_LEFT) . "</span> / <span style='color: #F69F00'>" . str_pad($row->cnt, 2, 0, STR_PAD_LEFT) . "</span></strong>";
            $sub_arr[] = "<strong><span style='color: #CC00E0'>" . str_pad($row->rccnt, 2, 0, STR_PAD_LEFT) . "</span> / <span style='color: #4FB5DD'>" . str_pad($row->iscnt, 2, 0, STR_PAD_LEFT) . "</span></strong>";
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        //$output = array("data" => $data);
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_ReqStock(),
            "recordsFiltered" => $this->Stock_model->count_filtered_ReqStock(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    //END SEARCH REQUESTED STOCKS </2019-10-18>

    //VIEW REQ STOCK </2019-10-18>
    function vewReqStock()
    {
        $id = $this->input->post('id');
        $data['req'] = $this->Stock_model->getReqDet();

        $this->db->select("rqs.auid,rqs.itid,rqs.reqty,rqs.stat,rqs.crdt,rqs.mddt,rqs.apdt,rqs.rjdt,rqs.asdt,rqs.isdt,
        it.itcd,it.itnm,it.mdl,it.mlcd,sc.scl,sc.scnm,
        CONCAT(cr.fnme,' ',cr.lnme) AS crnm, CONCAT(ap.fnme,' ',ap.lnme) AS apnm,CONCAT(md.fnme,' ',md.lnme) AS mdnm, 
        CONCAT(rj.fnme,' ',rj.lnme) AS rjnm, CONCAT(as.fnme,' ',as.lnme) AS asnm,CONCAT(is.fnme,' ',is.lnme) AS isnm");
        $this->db->from('stock_req_sub rqs');
        $this->db->join('item it', 'it.itid=rqs.itid');
        $this->db->join('scale sc', 'sc.slid=it.scli');
        $this->db->join('user_mas cr', 'cr.auid = rqs.crby ');
        $this->db->join('user_mas ap', 'ap.auid=rqs.apby', 'LEFT');
        $this->db->join('user_mas md', 'md.auid=rqs.mdby', 'LEFT');
        $this->db->join('user_mas rj', 'rj.auid=rqs.rjby', 'LEFT');
        $this->db->join('user_mas as', 'as.auid=rqs.asby', 'LEFT');
        $this->db->join('user_mas is', 'is.auid=rqs.isby', 'LEFT');
        $this->db->where("rqs.rqid=$id AND rqs.stat!=6");
        $data['reqs'] = $this->db->get()->result();
        echo json_encode($data);
    }

    function vewReqStock3()
    {
        $id = $this->input->post('id');

        $data['reqs'] = $this->Stock_model->getReqSubDet();

        $this->db->select("rqin.*,CONCAT(cr.fnme,' ',cr.lnme) AS crnm");
        $this->db->from('stock_req_sub sb');
        $this->db->join('stock_req_sub2 sb2', 'sb2.sbid=sb.auid');
        $this->db->join('stock_req_in rqin', 'rqin.inid=sb2.inid');
        $this->db->join('user_mas cr', 'cr.auid=rqin.crby');
        $this->db->where("sb.rqid=$id AND sb.stat!=6");
        $data['rqin'] = $this->db->get()->result();
        echo json_encode($data);
    }
    //END VIEW REQ STOCK </2019-10-18>

    //EDIT || APPROVE REQUEST STOCK </2019-10-18>
    function edtReqStock()
    {
        $this->db->trans_begin();           // SQL TRANSACTION START
        $func = $this->input->post('func');
        $auid = $this->input->post('reqId');

        if ($this->input->post('reqFrEdt') == 1) {
            $rqfr = 1;
            $rrbc = $this->input->post('frwhEdt');
        } else {
            $rqfr = 2;
            $rrbc = $this->input->post('frBrnEdt');
        }

        if ($func == 'edt') {
            $msg = "Stock request updated";
            //Update Stock
            $this->Generic_model->updateData('stock_req', array(
                'rqfr' => $rqfr,
                'rsbc' => $this->input->post('tobrcEdt'),
                'rrbc' => $rrbc,
                'stat' => 0,
                'rmk' => $this->input->post('remkEdt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
            ), array('rqid' => $auid));
        } else if ($func == 'app') {
            $msg = "Stock request completed";
            //Update Stock
            $this->Generic_model->updateData('stock_req', array(
                'rqfr' => $rqfr,
                'rsbc' => $this->input->post('tobrcEdt'),
                'rrbc' => $rrbc,
                'stat' => 1,
                'rmk' => $this->input->post('remkEdt'),
                'apby' => $_SESSION['userId'],
                'apdt' => date('Y-m-d H:i:s'),
            ), array('rqid' => $auid));
        }

        $itid = $this->input->post('itidEdt[]');
        $rqsid = $this->input->post('rqsid[]');
        $qty = $this->input->post('quntyEdt[]');

        $this->Generic_model->updateData('stock_req_sub', array('stat' => 6), array('rqid' => $auid, 'stat' => 0));
        for ($it = 0; $it < sizeof($itid); $it++) {
            if ($rqsid[$it] != 0) {
                $this->Generic_model->updateData('stock_req_sub', array(
                    'stat' => 0,
                ), array('auid' => $rqsid[$it]));
            } else {
                $this->Generic_model->insertData('stock_req_sub', array(
                    'rqid' => $auid,
                    'rsbc' => $this->input->post('tobrcEdt'),
                    'itid' => $itid[$it],
                    'reqty' => $qty[$it],
                    'crby' => $_SESSION['userId'],
                    'crdt' => date('Y-m-d H:i:s'),
                    'stat' => 0
                ));
            }
        }

        $funcPerm = $this->Generic_model->getFuncPermision('stckReq');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, $msg . ' id(' . $auid . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    //END EDIT || APPROVE REQUEST STOCK </2019-10-18>

    //ADD REQUEST GOODS AS STOCK </2019-10-25>
    function addReqGd_toStc()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $id = $this->input->post('id'); //stock_req_sub2 ID
        $rqid = $this->input->post('rqid'); //stock_req ID
        $inid = $this->input->post('inid'); //stock_req_in ID

        $this->db->select("sb2.*,bm.brcd,rq.rsbc,rq.rrbc");
        $this->db->from('stock_req_sub2 sb2');
        $this->db->join('stock_req rq', 'rq.rqid=sb2.rqid');
        $this->db->join('brch_mas bm', 'bm.brid=rq.rsbc');
        $this->db->where("sb2.auid=$id AND sb2.inid=$inid AND sb2.rqid=$rqid");
        $sb2 = $this->db->get()->result();

        if ($sb2[0]->sttp == 1) {
            $this->db->select("sb.*,stc.csvl,stc.fcvl,stc.slvl,stc.mkvl");
            $this->db->from('stock_sub sb');
            $this->db->join('stock stc', 'stc.stid=sb.stid');
            $this->db->where("sb.stat=1 AND sb.trrf=$id AND sb.trst=1");
            $srl = $this->db->get()->result();
        } else {
            $this->db->select("st.*,stc.csvl,stc.fcvl,stc.slvl,stc.mkvl");
            $this->db->from('stock_brn_sub stb');
            $this->db->join('stock_sub st', 'st.ssid=stb.ssid');
            $this->db->join('stock stc', 'stc.stid=st.stid');
            $this->db->where("stb.stat=1 AND stb.trrf=$id AND stb.trst=1");
            $srl = $this->db->get()->result();
        }

        $this->db->select("stcd");
        $this->db->from("stock_brn");
        $this->db->order_by('stbid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $stcd = $query->result();

        $yr = date('y');

        if (sizeof($stcd) > 0) {
            $icde = $stcd[0]->stcd;
            $re = (explode("-", $icde));

            $aa = intval($re[2]) + 1;
            $cc = strlen($aa);
            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '' . $aa;
            }
            $stno = 'ST' . $yr . '-' . $sb2[0]->brcd . '-' . $xx;
        } else {
            $stno = 'ST' . $yr . '-' . $sb2[0]->brcd . '-0001';  // Ex (STOCK)(YEAR)-(BRCD)-NO - ST18-TM-0001
        }

        $this->Generic_model->insertData('stock_brn', array(
            'stcd' => $stno,
            'stfr' => $sb2[0]->sttp,
            'stid' => $srl[0]->stid, //main stock id
            'itid' => $sb2[0]->itid, //item id
            'brid' => $sb2[0]->rsbc, //current branch id
            'frid' => $sb2[0]->rrbc, //Stock from branch id
            'csvl' => $srl[0]->csvl,
            'fcvl' => $srl[0]->fcvl,
            'slvl' => $srl[0]->slvl,
            'mkvl' => $srl[0]->mkvl,
            'qunt' => $sb2[0]->asqty,
            'avqn' => $sb2[0]->asqty,
            'stat' => 1,
            'cst' => 0,             //converted stock 0-no, 1-yes
            'cslid' => 0,           //Conversion id
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
            'apby' => $_SESSION['userId'],
            'apdt' => date('Y-m-d H:i:s'),
        ));
        $lstid = $this->db->insert_id();

        for ($it = 0; $it < sizeof($srl); $it++) {
            $this->Generic_model->insertData('stock_brn_sub',array(
                'stbid' => $lstid,
                'stcid' => 0,
                'stid' => $srl[$it]->stid,
                'ssid' => $srl[$it]->ssid,
                'stat' => 1,
                'trst' => 0,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            ));
        }

        $this->Generic_model->updateData('stock_req_sub2',array('stat'=>3),array('auid'=>$id));
        //Check all stock_req_sub2 is received
        $rec = $this->Generic_model->getData('stock_req_sub2','',array('stat'=>1,'sbid'=>$sb2[0]->sbid));
        if(sizeof($rec)<=0){
            //Update As received
            $this->Generic_model->updateData('stock_req_sub',array(
                'asqty' => $sb2[0]->asqty,
                'stat' => 5,
                'reby' => $_SESSION['userId'],
                'redt' => date('Y-m-d H:i:s')
            ),array('auid'=>$sb2[0]->sbid));
        }

        //Checking all stock_req_sub is recieved
        $des2 = $this->Generic_model->getData('stock_req_sub', array('auid'), "stat IN(0,3,4) AND rqid=".$sb2[0]->rqid);
        if (sizeof($des2) <= 0) {
            $this->Generic_model->updateData('stock_req', array(
                'stat' => 3,
                'reby' => $_SESSION['userId'],
                'redt' => date('Y-m-d H:i:s')
            ), array('rqid' => $sb2[0]->rqid));
        }

        $funcPerm = $this->Generic_model->getFuncPermision('stckReq');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Made request as stock(' . $lstid . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    //END ADD REQUEST GOODS AS STOCK </2019-10-25>
//************************************************
//***           END STOCK REQUEST              ***
//************************************************

//************************************************
//***               STOCK TRANSFER             ***
//************************************************
//LOAD PAGE </ 2019-10-17>
    function stckTrnf()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'stckTrnf'; //Page
        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $data2['funcPerm'] = $this->Generic_model->getFuncPermision('stckTrnf');
        $data2['brncFrm'] = $this->Generic_model->getBranch();
        $data2['brncTo'] = $this->Generic_model->getSortData('brch_mas', array('brid', 'brcd', 'brnm'), array('stat' => 1), '', '', 'brnm', 'ASC');

        //Item With Storing Scale
        $this->db->select("itid,itcd,itnm,slid,scnm,scl,mdl,mlcd");
        $this->db->from('item');
        $this->db->join('scale', 'scale.slid=item.scli');
        $this->db->where('item.stat', 1);
        $this->db->order_by('itnm', 'ASC');
        $data2['item'] = $this->db->get()->result();

        $data2['warehouse'] = $this->Generic_model->getSortData('stock_wh', array('whid', 'whcd', 'whnm'), array('stat' => 1), '', '', 'whnm', 'ASC');
        $data2['warehouse'] = $this->Generic_model->getData('stock_wh', array('whid', 'whcd', 'whnm'), array('stat' => 1));

        $this->load->view('admin/stock/stckTransfer', $data2);

        $this->load->view('common/tmpFooter', $data);
    }
    //END LOAD PAGE </ 2019-10-17>

    //SEARCH REQUESTED STOCKS TO ISSUE</2019-10-18>
    function srchReqStck()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('stckTrnf');

        if ($funcPerm[0]->view == 1) {
            $viw = "";
        } else {
            $viw = "disabled";
        }
        if ($funcPerm[0]->edit == 1) {
            $edt = "";
        } else {
            $edt = "disabled";
        }
        if ($funcPerm[0]->apvl == 1) {
            $app = "";
        } else {
            $app = "disabled";
        }
        if ($funcPerm[0]->rejt == 1) {
            $rej = "";
        } else {
            $rej = "disabled";
        }
        if ($funcPerm[0]->prnt == 1) {
            $prnt = "";
        } else {
            $prnt = "disabled";
        }

        $result = $this->Stock_model->get_ReqStock();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $st = $row->stat;
            $rqid = $row->rqid;

            //Have assigned goods
            if ($row->ascnt > 0) {
                $ascnt = $row->ascnt . " assigned to issue";
                $asDes = "disabled";
                $isDes = "";
            } else {
                $ascnt = "No assigned to issue";
                $asDes = "";
                $isDes = "disabled";
            }

            //Have printed issue notes to issue
            if ($row->inpcnt > 0) {
                $isnote = "<button type='button' id='prt' $prnt $isDes data-toggle='modal' data-target='#modal-iss'  onclick='issStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='Print issue note' ><i class='fa fa-print' aria-hidden='true'></i></button> ";
            } else {
                $isnote = "<button type='button' id='app' $app $isDes data-toggle='modal' data-target='#modal-iss'  onclick='issStck($rqid,this.id,$row->lstInid);' class='btn btn-xs btn-default btn-condensed' title='$ascnt' ><i class='fa fa-check' aria-hidden='true'></i></button> ";
            }

            if ($st == '1') {           // TO ISSUE GOODS
                $stat = " <span class='label label-warning'> To Issue </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='View' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='ass' $edt data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='Assign' ><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    $isnote .
                    "<button type='button' id='rej' $rej $asDes onclick='rejReq($rqid);' class='btn btn-xs btn-default btn-condensed' title='Reject' ><i class='fa fa-ban' aria-hidden='true'></i></button>";

            } else if ($st == '3') {            // Delivered
                $stat = " <span class='label label-success'> Delivered </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='View' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='Assign' ><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='Issue' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' disabled onclick='rejStck($rqid);' class='btn btn-xs btn-default btn-condensed' title='Reject' ><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($st == '4') {        //Issue Reject
                $stat = " <span class='label label-danger'> Reject </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='View' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='Assign' ><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='Issue' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' disabled onclick='rejStck($rqid);' class='btn btn-xs btn-default btn-condensed' title='Reject' ><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($st == '5') {        //Issued
                $stat = " <span class='label label-indi'> Issued </span> ";
                $option =
                    "<button type='button' id='vew' $viw  data-toggle='modal' data-target='#modal-view'  onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='View' ><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' id='edt' disabled onclick='viewStck();' class='btn btn-xs btn-default btn-condensed' title='Assign' ><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' id='app' disabled onclick='viewStck($rqid,this.id);' class='btn btn-xs btn-default btn-condensed' title='Issue' ><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' id='rej' disabled onclick='rejStck($rqid);' class='btn btn-xs btn-default btn-condensed' title='Reject' ><i class='fa fa-ban' aria-hidden='true'></i></button>";
            }

            if ($row->rqfr == 1) {
                $rqfr = "<label class='label label-info label-bordered label-ghost' title='Warehouse'>WH</label> ";
            } else {
                $rqfr = "<label class='label label-info label-bordered label-ghost' title='Branch'>BR</label> ";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->rqno;
            $sub_arr[] = $row->rsbrcd . " - " . $row->rsbrnm;
            $sub_arr[] = $rqfr . $row->rrbrcd . " - " . $row->rrbrnm;
            $sub_arr[] = "<strong><span style='color: #76AB3C'>" . str_pad($row->ascnt, 2, 0, STR_PAD_LEFT) . "</span> / <span style='color: #F69F00'>" . str_pad($row->cnt, 2, 0, STR_PAD_LEFT) . "</span></strong>";
            $sub_arr[] = "<strong><span style='color: #CC00E0'>" . str_pad($row->rccnt, 2, 0, STR_PAD_LEFT) . "</span> / <span style='color: #4FB5DD'>" . str_pad($row->iscnt, 2, 0, STR_PAD_LEFT) . "</span></strong>";
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        //$output = array("data" => $data);
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_ReqStock(),
            "recordsFiltered" => $this->Stock_model->count_filtered_ReqStock(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    //END SEARCH REQUESTED STOCKS TO ISSUE</2019-10-18>

    //REQUEST REJECT IN ISSUING AREA </2019-10-23>
    function reqIsReject()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $id = $this->input->post('id');

        $this->Generic_model->updateData('stock_req', array(
            'stat' => 4,
            'isrby' => $_SESSION['userId'],
            'isrdt' => date('Y-m-d H:i:s'),
        ), array('rqid' => $id));

        $funcPerm = $this->Generic_model->getFuncPermision('stckTrnf');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Stock Request Reject id(' . $id . ')');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    //END REQUEST REJECT IN ISSUING AREA </2019-10-23>

    //VIEW REQ STOCK </2019-10-21>
    function vewReqStock2()
    {
        $id = $this->input->post('id');
        $data['req'] = $this->Stock_model->getReqDet();

        $_POST['rqfr'] = $data['req'][0]->rqfr; //Request From 1-Warehouse / 2- Branch
        $_POST['rrbc'] = $data['req'][0]->rrbc; //Request Receiver

        $data['reqs'] = $this->Stock_model->getReqSubDet();

        $this->db->select("rqin.*,CONCAT(cr.fnme,' ',cr.lnme) AS crnm");
        $this->db->from('stock_req_sub sb');
        $this->db->join('stock_req_sub2 sb2', 'sb2.sbid=sb.auid');
        $this->db->join('stock_req_in rqin', 'rqin.inid=sb2.inid');
        $this->db->join('user_mas cr', 'cr.auid=rqin.crby');
        $this->db->where("sb.rqid=$id AND sb.stat!=6");
        $data['rqin'] = $this->db->get()->result();
        echo json_encode($data);
    }
    //END VIEW REQ STOCK </2019-10-21>
    //
    //VIEW REQ STOCK TO ISSUE </2019-10-23>
    function vewReqStockIss()
    {
        $id = $this->input->post('id');
        $func = $this->input->post('func');
        $inid = $this->input->post('inid');
        $data['req'] = $this->Stock_model->getReqDet();

        $rqfr = $data['req'][0]->rqfr; //Request From 1-Warehouse / 2- Branch
        $rrbc = $data['req'][0]->rrbc; //Request Receiver

        $this->db->select("stc.avqn,stc.stid,stc.stcd,stc.csvl,stc.fcvl,stc.slvl,stc.mkvl,
        sb2.asqty AS thsAsCnt,sb2.auid AS sb2auid,
        rqs.auid,rqs.itid,rqs.reqty,rqs.stat,rqs.crdt,
        it.itcd,it.itnm,it.mdl,it.mlcd,sc.scl,sc.scnm,
        ");
        $this->db->from('stock_req_sub2 sb2');
        $this->db->join('stock_req_sub rqs', 'rqs.auid=sb2.sbid');
        $this->db->join('item it', 'it.itid=rqs.itid');
        $this->db->join('scale sc', 'sc.slid=it.scli');
        if ($rqfr == 1) {
            $this->db->join('(SELECT stcd,avqn,stid,itid,csvl,fcvl,slvl,mkvl
             FROM stock WHERE stock.stat=1 AND stock.whid=' . $rrbc . ') stc', 'stc.stid=sb2.stid');
        } else {
            $this->db->join('(SELECT stcd,avqn,stbid AS stid,itid,csvl,fcvl,slvl,mkvl
             FROM stock_brn WHERE stock_brn.stat=1 AND stock_brn.brid=' . $rrbc . ') stc', 'stc.stbid=sb2.stid');
        }

        //0-To Print / 1- To Issue
        if ($func == 'app') {
            $inpr = 1;
            $inidq = "AND sb2.inid=$inid";
        } else {
            $inpr = 0;
            $inidq = "";
        }
        $this->db->where("rqs.rqid=$id AND rqs.stat=3 AND sb2.inpr=$inpr $inidq AND sb2.stat=1");
        $data['reqs'] = $this->db->get()->result();

        $data['rqin'] = $this->Generic_model->getData('stock_req_in', '', array('inid' => $inid));
        echo json_encode($data);
    }
    //END VIEW REQ STOCK TO ISSUE</2019-10-23>

    //GET SERIAL NUMBER ITEM </2019-10-22>
    function srch_SrlNumTrn()
    {
        $val = $this->input->post('val');
        $stid = $this->input->post('stid');
        $rqfr = $this->input->post('rqfr');

        if ($rqfr == 1) {
            $this->db->select("sb.*");
            $this->db->from('stock_sub sb');
            $this->db->where('sb.stid', $stid);
            $this->db->where("sb.stat=1 AND sb.trst=0");
            if ($val != '') {
                $this->db->where("sb.srno=$val");
            }
        } else {
            $this->db->select("stb.sbsid AS ssid,sb.srno,sb.btno,sb.prno,sb.brcd,sb.abc,sb.xyz");
            $this->db->from('stock_brn_sub stb');
            $this->db->join('stock_sub sb', 'sb.ssid=stb.ssid');
            $this->db->where('stb.stbid', $stid);
            $this->db->where("stb.stat=1 AND stb.trst=0");
            if ($val != '') {
                $this->db->where("sb.srno=$val");
            }
        }

        $res = $this->db->get()->result();
        echo json_encode($res);
    }
    //GET SERIAL NUMBER ITEM </2019-10-22>

    //ADD TO TRANSFER </2019-10-22>
    function addToTran()
    {
        $this->db->trans_begin();           // SQL TRANSACTION START
        $stid = $this->input->post('stid');
        $rqfr = $this->input->post('rqfr');
        $rqid = $this->input->post('rqid');
        $sbid = $this->input->post('sbid');
        $itid = $this->input->post('itid');
        $qty = $this->input->post('qty');
        $func = $this->input->post('func');

        if ($func == 'ass') {
            $this->Generic_model->insertData('stock_req_sub2', array(
                'rqid' => $rqid,
                'sbid' => $sbid,
                'sttp' => $rqfr,
                'stid' => $stid,
                'itid' => $itid,
                'asqty' => $qty,
                'stat' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            ));
            $lstId = $this->db->insert_id();

            $srlnum = $this->input->post('srlnum[]');
            if ($rqfr == 1) {
                for ($it = 0; $it < sizeof($srlnum); $it++) {
                    $this->Generic_model->updateData('stock_sub', array(
                        'trst' => 1,
                        'trrf' => $lstId
                    ), array('ssid' => $srlnum[$it]));
                }
            } else {
                for ($it = 0; $it < sizeof($srlnum); $it++) {
                    $this->Generic_model->updateData('stock_brn_sub', array(
                        'trst' => 1,
                        'trrf' => $lstId
                    ), array('ssid' => $srlnum[$it]));
                }
            }

            $this->Generic_model->updateData('stock_req_sub', array('stat' => 3), array('auid' => $sbid));

            $funcPerm = $this->Generic_model->getFuncPermision('stckTrnf');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Add to transfer stock ($lstId)");
        } else if ($func == 'edt') {
            $det = $this->Generic_model->getData('stock_req_sub2', '', array('rqid' => $rqid, 'sbid' => $sbid, 'stid' => $stid, 'itid' => $itid, 'sttp' => $rqfr, 'stat' => 1));
            $sb2Id = $det[0]->auid;
            //Update stock_req_sub2 qty
            $this->Generic_model->updateData('stock_req_sub2', array(
                'asqty' => $qty
            ), array('auid' => $sb2Id));

            //Update stock_sub
            $srlnum = $this->input->post('srlnum[]');
            if ($rqfr == 1) {
                $this->Generic_model->updateData('stock_sub', array(
                    'trst' => 0,
                    'trrf' => 0
                ), array('trrf' => $sb2Id));
                //Add Updates Serials
                for ($it = 0; $it < sizeof($srlnum); $it++) {
                    $this->Generic_model->updateData('stock_sub', array(
                        'trst' => 1,
                        'trrf' => $sb2Id
                    ), array('ssid' => $srlnum[$it]));
                }

            } else {
                $this->Generic_model->updateData('stock_brn_sub', array(
                    'trst' => 0,
                    'trrf' => 0
                ), array('trrf' => $sb2Id));
                //Add Updates Serials
                for ($it = 0; $it < sizeof($srlnum); $it++) {
                    $this->Generic_model->updateData('stock_brn_sub', array(
                        'trst' => 1,
                        'trrf' => $sb2Id
                    ), array('ssid' => $srlnum[$it]));
                }
            }
            $funcPerm = $this->Generic_model->getFuncPermision('stckTrnf');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Update goods to transfer stock ($sb2Id)");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    //END ADD TO TRANSFER </2019-10-22>

    //GET ADDED SERIAL NUMBERS </2019-10-23>
    function getAddSrlNumTrn()
    {
        $sbid = $this->input->post('sbid');
        $stid = $this->input->post('stid');
        $rqfr = $this->input->post('rqfr');

        if ($rqfr == 1) {
            $this->db->select("sb.*");
            $this->db->from('stock_req_sub2 sb2');
            $this->db->join('stock_sub sb', 'sb.trrf=sb2.auid');
            $this->db->where('sb2.stid', $stid);
            $this->db->where("sb2.stat=1 AND sb2.sbid=$sbid");
        } else {
            $this->db->select("stb.sbsid AS ssid,sb.srno,sb.btno,sb.prno,sb.brcd,sb.abc,sb.xyz");
            $this->db->from('stock_req_sub2 sb2');
            $this->db->join('stock_brn_sub stb', 'stb.trrf=sb2.auid');
            $this->db->join('stock_sub sb', 'sb.ssid=stb.ssid');
            $this->db->where('stb.stbid', $stid);
            $this->db->where("sb2.stat=1 AND sb2.sbid=$sbid");
        }

        $res = $this->db->get()->result();
        echo json_encode($res);
    }
    //END GET ADDED SERIAL NUMBERS </2019-10-23>

    //CANCEL ASSIGNED GOODS </2019-10-23>
    function canAsnGds()
    {
        $this->db->trans_begin();           // SQL TRANSACTION START
        $stid = $this->input->post('stid');
        $rqfr = $this->input->post('rqfr');
        $rqid = $this->input->post('rqid');
        $sbid = $this->input->post('sbid');
        $itid = $this->input->post('itid');
        $qty = $this->input->post('qty');

        $det = $this->Generic_model->getData('stock_req_sub2', '', array('rqid' => $rqid, 'sbid' => $sbid, 'stid' => $stid, 'itid' => $itid, 'sttp' => $rqfr, 'stat' => 1));
        $sb2Id = $det[0]->auid;
        //Update stock_req_sub2 qty
        $this->Generic_model->updateData('stock_req_sub2', array(
            'asqty' => 0,
            'stat' => 0
        ), array('auid' => $sb2Id));

        //Update stock_sub
        if ($rqfr == 1) {
            $this->Generic_model->updateData('stock_sub', array(
                'trst' => 0,
                'trrf' => 0
            ), array('trrf' => $sb2Id));
        } else {
            $this->Generic_model->updateData('stock_brn_sub', array(
                'trst' => 0,
                'trrf' => 0
            ), array('trrf' => $sb2Id));
        }

        //IF Have any other assigned goods
        $det2 = $this->Generic_model->getData('stock_req_sub2', '', array('stat' => 1, 'sbid' => $sbid));
        if (sizeof($det2) <= 0) {
            //backto Pending mode
            $this->Generic_model->updateData('stock_req_sub', array('stat' => 0), array('auid' => $sbid));
        }

        $funcPerm = $this->Generic_model->getFuncPermision('stckTrnf');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Cancelled goods to transfer stock ($sb2Id)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    //END CANCEL ASSIGNED GOODS </2019-10-23>

    //MAKE ISSUE NOTE </2019-10-23>
    function makeIsNote()
    {
        $this->db->trans_begin();

        $yr = date('y');
        //issue not number auto generate
        $this->db->select("inno");
        $this->db->from('stock_req_in rqin');
        $this->db->order_by('rqin.inid', 'desc');
        $this->db->limit(1);
        $data = $this->db->get()->result();

        if (count($data) == '0') {
            $inno = 'IN' . $yr . "-0001";
        } else {
            $re = (explode("-", $data[0]->inno));
            $aa = intval($re[1]) + 1;
            $cc = strlen($aa);
            // next loan no
            if ($cc == 1) {
                $xx = '000' . $aa;
            } else if ($cc == 2) {
                $xx = '00' . $aa;
            } else if ($cc == 3) {
                $xx = '0' . $aa;
            } else if ($cc == 4) {
                $xx = '' . $aa;
            }
            $inno = 'IN' . $yr . "-" . $xx;
        }
        //issue not number auto generate

        $this->Generic_model->insertData('stock_req_in', array(
            'inno' => $inno,
            'vno' => $this->input->post('vhnm'),
            'drnm' => $this->input->post('drnm'),
            'mbno' => $this->input->post('dctno'),
            'rmk' => $this->input->post('remkIss'),
            'crby' => $_SESSION['userId'],
            'crdt' => date('Y-m-d H:i:s'),
            'inpr' => 1,
            'stat' => 1
        ));
        $lstId = $this->db->insert_id();

        $sb2auid = $this->input->post('sb2auid[]');
        for ($it = 0; $it < sizeof($sb2auid); $it++) {
            $this->Generic_model->updateData('stock_req_sub2', array(
                'inid' => $lstId,
                'inpr' => 1
            ), array('auid' => $sb2auid[$it]));
        }

        $funcPerm = $this->Generic_model->getFuncPermision('stckTrnf');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Made Issue Note ($lstId)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode($lstId);
        }
    }
    //END MAKE ISSUE NOTE </2019-10-23>

    //PRINT ISSUE NOTE </2019-10-24>
    function issue_note_print($inid, $tms)
    {
        if ($tms == 2) {
            $inpr = $this->Generic_model->getData('stock_req_in', array('inpr'), array('inid' => $inid));
            $this->Generic_model->updateData('stock_req_in', array('inpr' => $inpr[0]->inpr + 1), array('inid' => $inid));
        }

        //Issued goods details
        $this->db->select("rqin.inno,rqin.vno,rqin.drnm,rqin.inpr,rqin.rmk,rqin.crby,rqin.crdt,
        sb2.auid AS sauid, sb2.asqty,sl.scl,sl.scnm,req.rqno,req.rqfr,req.rqid,req.rsbc,req.rrbc,
        item.itcd,item.itnm,item.mdl,item.mlcd,bd.bdcd,bd.bdnm,CONCAT(in.fnme,' ',in.lnme) AS innm");
        $this->db->from('stock_req_in rqin');
        $this->db->join('stock_req_sub2 sb2', 'sb2.inid=rqin.inid');
        $this->db->join('stock_req req', 'req.rqid=sb2.rqid');
        $this->db->join('item', 'item.itid=sb2.itid');
        $this->db->join('scale sl', 'sl.slid=item.scli');
        $this->db->join('brand bd', 'bd.bdid=item.bdid');
        $this->db->join('user_mas in', 'in.auid=rqin.crby');
        $this->db->where("rqin.inid=$inid");
        $res = $this->db->get()->result();
        //Issued goods details

        //Issued Branch Or Warehouse details
        if ($res[0]->rqfr == 1) {
            $this->db->select("wh.whcd AS swhcd, wh.whnm AS swhnm, wh.addr AS saddr, wh.tele AS stele, wh.email AS semail,
                    brc.brnm AS rbrnm, brc.brcd AS rbrcd, brc.brad AS rbraddr");
            $this->db->from('stock_req req');
            $this->db->join('stock_wh wh', 'wh.whid=req.rrbc');
            $this->db->join('brch_mas brc', 'brc.brid=req.rsbc');
            $this->db->where("req.rqid=" . $res[0]->rqid);
            $rrDet = $this->db->get()->result();
        } else if ($res[0]->rqfr == 2) {
            $this->db->select("wh.brcd AS swhcd,wh.brnm AS swhnm, wh.brad AS saddr, wh.brtp AS stele, wh.brem AS semail,
                    brc.brnm AS rbrnm, brc.brcd AS rbrcd, brc.brad AS rbraddr");
            $this->db->from('stock_req req');
            $this->db->join('brch_mas wh', 'wh.brid=req.rrbc');
            $this->db->join('brch_mas brc', 'brc.brid=req.rsbc');
            $this->db->where("req.rqid=" . $res[0]->rqid);
            $rrDet = $this->db->get()->result();
        } else {
            die();
        }
        //Issued Branch Or Warehouse details

        //Company details
        $comDet = $this->Generic_model->getData('com_det', '');
        //Company details
        $date = date('Y-m-d H:i:s');

        ob_start();
        $this->pdf->AddPage('P', 'A5');
        $this->pdf->SetAutoPageBreak(true, 10);
        //$this->pdf->Rect(5, 5, 200, 287, ''); //For A4
        $this->pdf->SetFont('Helvetica', 'B', 11);
        $this->pdf->SetTextColor(50, 50, 50);
        $this->pdf->SetXY(10, 12);
        $this->pdf->Cell(0, 0, $rrDet[0]->swhnm . ' | ' . $rrDet[0]->swhcd, 0, 1, 'C');
        $this->pdf->SetFont('Helvetica', '', 9);
        $this->pdf->SetXY(10, 16);
        $this->pdf->Cell(0, 0, $rrDet[0]->saddr, 0, 1, 'C');
        $this->pdf->SetXY(10, 20);
        $this->pdf->Cell(0, 0, "Tele " . $rrDet[0]->stele . " | Email " . $rrDet[0]->semail, 0, 1, 'C');

        // Top left company details
        $this->pdf->SetFont('Helvetica', 'B', 9);
        $this->pdf->SetXY(5, 27);
        $this->pdf->Cell(0, 0, "Issue Note No. : " . $res[0]->inno);
        $this->pdf->SetFont('Helvetica', '', 10);
        $this->pdf->SetXY(5, 32);
        $this->pdf->Cell(0, 0, 'Delivery Address', 0, 0, '');
        $this->pdf->Line(5, 34.5, 35, 34.5);
        $this->pdf->Ln();
        $this->pdf->SetFont('Helvetica', '', 9);
        $this->pdf->SetXY(5, 37);
        $this->pdf->Cell(0, 0, $comDet[0]->cmne . " (" . $rrDet[0]->rbrnm | $rrDet[0]->rbrcd . ")");
        $this->pdf->SetFont('Helvetica', '', 9);
        $this->pdf->SetXY(5, 41);
        $this->pdf->Cell(0, 0, $rrDet[0]->rbraddr);
        $this->pdf->SetFont('Helvetica', '', 9);
        $this->pdf->SetXY(5, 48);
        $this->pdf->Cell(1, 0, 'Delivery Date : ' . date('Y-m-d'), 0, 1, 'L');
        $this->pdf->SetXY(5, 52);
        $this->pdf->Cell(1, 0, 'Vehicle No : ' . $res[0]->vno, 0, 1, 'L');
        $this->pdf->SetXY(5, 56);
        $this->pdf->Cell(1, 0, 'Driver Name : ' . $res[0]->drnm, 0, 1, 'L');

        //Top Right
        $this->pdf->SetFont('Helvetica', 'B', 9);
        $this->pdf->SetXY(90, 27);
        $this->pdf->Cell(1, 0, 'Date : ' . $res[0]->crdt, 0, 1, 'L');
        $this->pdf->SetFont('Helvetica', '', 9);
        $this->pdf->SetXY(90, 48);
        $this->pdf->Cell(1, 0, 'Issued By : ' . $res[0]->innm, 0, 1, 'L');

        $this->pdf->Line(5, 59, 145, 59);
        $this->pdf->Ln();
        $this->pdf->SetFont('Helvetica', 'B', 9);

        $this->pdf->SetXY(5, 59);
        $this->pdf->Cell(10, 110, '', '1');
        $this->pdf->SetXY(15, 59);
        $this->pdf->Cell(30, 110, '', '1');
        $this->pdf->SetXY(45, 59);
        $this->pdf->Cell(80, 110, '', '1');
        $this->pdf->SetXY(125, 59);
        $this->pdf->Cell(20, 110, '', '1');

        $this->pdf->SetXY(5, 59);
        $this->pdf->Cell(10, 5, '#', 1, 1, 'C');
        $this->pdf->SetXY(15, 59);
        $this->pdf->Cell(30, 5, 'Item', 1, 1, 'C');
        $this->pdf->SetXY(45, 59);
        $this->pdf->Cell(80, 5, 'Description', 1, 1, 'C');
        $this->pdf->SetXY(125, 59);
        $this->pdf->Cell(20, 5, 'QTY', 1, 1, 'C');
        $this->pdf->Line(5, 64, 145, 64);
        $this->pdf->Ln();
        $this->pdf->SetXY(5, 64);

        $tQty = 0;
        for ($it = 0; $it < sizeof($res); $it++) {
            //loading serial numbers
            if ($res[0]->rqfr == 1) {
                $this->db->select("sb.srno,sb.btno,sb.prno,sb.brcd,sb.abc,sb.xyz");
                $this->db->from('stock_sub sb');
                $this->db->where("sb.trrf=" . $res[$it]->sauid);
                $srno = $this->db->get()->result();
            } else {
                $this->db->select("sb.srno,sb.btno,sb.prno,sb.brcd,sb.abc,sb.xyz");
                $this->db->from('stock_brn_sub sbb');
                $this->db->join('stock_sub sb', 'sb.ssid=sbb.ssid');
                $this->db->where("sbb.trrf=" . $res[$it]->sauid);
                $srno = $this->db->get()->result();
            }

            $y = $this->pdf->GetY();
            $this->pdf->SetFont('Helvetica', '', 9);
            $this->pdf->SetXY(5, $y);
            $this->pdf->Cell(10, 5, $it + 1, 0, 0, 'C');
            $this->pdf->SetXY(15, $y);
            $this->pdf->Cell(30, 5, $res[$it]->itcd, 0, 0, 'L');

            if (sizeof($srno) > 0) {
                $srl = "SRL - ";
                for ($sr = 0; $sr < sizeof($srno); $sr++) {
                    $this->pdf->SetX(35);
                    $ref = '';
                    if ($srno[$sr]->srno != "") {
                        $ref = $srno[$sr]->srno;
                    } else if ($srno[$sr]->btno != "") {
                        $ref = $srno[$sr]->btno;
                    } else if ($srno[$sr]->prno != "") {
                        $ref = $srno[$sr]->prno;
                    } else if ($srno[$sr]->brcd != "") {
                        $ref = $srno[$sr]->brcd;
                    } else if ($srno[$sr]->abc != "") {
                        $ref = $srno[$sr]->abc;
                    } else if ($srno[$sr]->xyz != "") {
                        $ref = $srno[$sr]->xyz;
                    }

                    if ($sr == 0) {
                        $srl = $srl . $ref;
                    } else {
                        $srl = $srl . " | " . $ref;
                    }
                }
            } else {
                $srl = "BULK";
            }

            $this->pdf->SetXY(45, $y);
            $this->pdf->MultiCell(80, 5, $res[$it]->itnm . "\n MODEL - " . $res[$it]->mdl . " (" . $res[$it]->mlcd . ") " . $res[$it]->bdnm . "\n$srl", 0);
            $y2 = $this->pdf->getY();
            $this->pdf->SetXY(125, $y);
            $this->pdf->Cell(20, 5, str_pad($res[$it]->asqty, 2, 0, STR_PAD_LEFT), 0, 0, 'R');
            $this->pdf->SetXY(45, $y2 + 3);

            $tQty += $res[$it]->asqty;
        }

        if ($this->pdf->GetY() > ($this->pdf->h / 3) * 2) {
            // FOOTER
            $this->pdf->SetFont('Helvetica', '', 7);
            $this->pdf->SetXY(10, $this->pdf->h - 10);
            $this->pdf->Cell(0, 0, '(' . $res[0]->inno . '|' . $date . '|' . $_SESSION['username'] . ')'); /* AGNO | DATE | USER */
            if ($res[0]->inpr == 1) {
                $this->pdf->SetXY(120, $this->pdf->h - 10);
                $this->pdf->Cell(0, 0, 'Original Issue Note');
            } else {
                $this->pdf->SetXY(120, $this->pdf->h - 10);
                $this->pdf->Cell(0, 0, 'Copy (' . $res[0]->inpr . ')');
            }
            $this->pdf->AddPage('P', 'A5');
            $this->pdf->SetAutoPageBreak(true, 10);
        }

        $this->pdf->SetFont('Helvetica', 'B', 9);
        $this->pdf->SetXY(45, $this->pdf->h - 40);
        $this->pdf->Cell(80, 5, "Total", 0, 0, 'R');
        $this->pdf->Cell(20, 5, str_pad($tQty, 2, 0, STR_PAD_LEFT), 0, 0, 'R');

        $this->pdf->SetFont('Helvetica', '', 9);
        $this->pdf->SetXY(10, $this->pdf->h - 20);
        $this->pdf->Cell(35, 0, ".............................................", 0, 0, 'C');
        $this->pdf->SetFont('Helvetica', 'B', 9);
        $this->pdf->SetXY(10, $this->pdf->h - 17);
        $this->pdf->Cell(35, 0, "Issued By", 0, 0, 'C');

        $this->pdf->SetFont('Helvetica', '', 9);
        $this->pdf->SetXY(55, $this->pdf->h - 20);
        $this->pdf->Cell(35, 0, ".............................................", 0, 0, 'C');
        $this->pdf->SetFont('Helvetica', 'B', 9);
        $this->pdf->SetXY(55, $this->pdf->h - 17);
        $this->pdf->Cell(35, 0, "Delivered By", 0, 0, 'C');

        $this->pdf->SetFont('Helvetica', '', 9);
        $this->pdf->SetXY(100, $this->pdf->h - 20);
        $this->pdf->Cell(35, 0, ".............................................", 0, 0, 'C');
        $this->pdf->SetFont('Helvetica', 'B', 9);
        $this->pdf->SetXY(100, $this->pdf->h - 17);
        $this->pdf->Cell(35, 0, "Received By", 0, 0, 'C');
        // FOOTER
        $this->pdf->SetFont('Helvetica', '', 7);
        $this->pdf->SetXY(10, $this->pdf->h - 10);
        $this->pdf->Cell(0, 0, '(' . $res[0]->inno . '|' . $date . '|' . $_SESSION['username'] . ')'); /* AGNO | DATE | USER */

        if ($res[0]->inpr == 1) {
            $this->pdf->SetXY(120, $this->pdf->h - 10);
            $this->pdf->Cell(0, 0, 'Original Issue Note');
        } else {
            $this->pdf->SetXY(120, $this->pdf->h - 10);
            $this->pdf->Cell(0, 0, 'Copy (' . $res[0]->inpr . ')');
        }

        $this->pdf->SetTitle('Agreement No  :' . $res[0]->inno);
        $this->pdf->Output($res[0]->inno . '.pdf', 'I');
        ob_end_flush();

        $funcPerm = $this->Generic_model->getFuncPermision('stckTrnf');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Issue Note Printed " . $res[0]->inno . " (TM " . ($inpr[0]->inpr + 1) . ")");
    }
    //END PRINT ISSUE NOTE </2019-10-24>

    //DELIVER THE GOODS </2019-10-24>
    function issGoods()
    {
        $this->db->trans_begin();  //SQL BEGIN TRANSACTION
        $func = $this->input->post('func');
        $inid = $this->input->post('inid');

        $des = $this->Generic_model->getData('stock_req_sub2', array('sbid', 'asqty', 'stid', 'sttp', 'rqid'), array('inid' => $inid));
        $this->Generic_model->updateData('stock_req_sub2',array('stat'=>2),array('stat'=>1,'inid'=>$inid));
        for ($it = 0; $it < sizeof($des); $it++) {
            $this->Generic_model->updateData('stock_req_sub', array(
                'stat' => 4,
                'isby' => $_SESSION['userId'],
                'isdt' => date('Y-m-d H:i:s')
            ), array('auid' => $des[$it]->sbid));

            $cnt = $des[$it]->asqty;
            if ($des[$it]->sttp == 1) {
                $this->db->set('avqn', "avqn - $cnt", false);
                $this->db->where('stid', $des[$it]->stid);
                $this->db->update('stock');

                //Checking and Update as finish stock
                $this->db->set('stat', "IF(avqn=0,2,stat)", false);
                $this->db->where('stid', $des[$it]->stid);
                $this->db->update('stock');
            } else {
                $this->db->set('avqn', "avqn - $cnt", false);
                $this->db->where('stbid', $des[$it]->stid);
                $this->db->update('stock_brn');

                //Checking and Update as finish stock
                $this->db->set('stat', "IF(avqn=0,2,stat)", false);
                $this->db->where('stbid', $des[$it]->stid);
                $this->db->update('stock_brn');
            }
        }

        //Check if all stock_req_sub issued
        $des2 = $this->Generic_model->getData('stock_req_sub', array('auid'), "stat IN(0,3) AND rqid=".$des[0]->rqid);
        if (sizeof($des2) <= 0) {
            $this->Generic_model->updateData('stock_req', array('stat' => 5), array('rqid' => $des[0]->rqid));
        }

        $funcPerm = $this->Generic_model->getFuncPermision('stckTrnf');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Issue Goods From Stock (INID : $inid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    //END DELIVER THE GOODS </2019-10-24>

    //SEARCH ISSUED NOTES </2019-10-25>
    function srchIssNote()
    {
        $result = $this->Stock_model->get_issNotes();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->inno;
            $sub_arr[] = $row->drnm;
            $sub_arr[] = $row->vno;
            $sub_arr[] = $row->mbno;
            $sub_arr[] = $row->crnm;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = "<button class='btn btn-xs btn-primary' onclick='issNtRp($row->inid);'><span class='fa fa-print'></span></button>";
            $data[] = $sub_arr;
        }

        //$output = array("data" => $data);
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Stock_model->count_all_issNotes(),
            "recordsFiltered" => $this->Stock_model->count_filtered_issNotes(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    //END SEARCH ISSUED NOTES </2019-10-25>
//************************************************
//***           END STOCK TRANSFER             ***
//************************************************

}
