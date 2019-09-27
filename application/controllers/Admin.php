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
        $this->load->model('Log_model');      // load model

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
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

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
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('branding');
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
        $this->Generic_model->updateData('com_det', $data_ar1, $where_arr);

        $funcPerm = $this->Generic_model->getFuncPermision('branding');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Company Details Updated');

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
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('policyMng');
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

        $rgmil = $this->input->post('rgmil');     // USER REGISTER EMAIL SEND

        $_01 = array('pov3' => $eycd, 'post' => $digey, 'mdby' => $_SESSION['userId'], 'mddt' => $date);
        $_02 = array('post' => $rgmil, 'mdby' => $_SESSION['userId'], 'mddt' => $date);

        $this->Generic_model->updateData('sys_policy', $_01, array('poid' => 1));
        $this->Generic_model->updateData('sys_policy', $_02, array('poid' => 2));


        $funcPerm = $this->Generic_model->getFuncPermision('policyMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'System Policy Updated');

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
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('rcntAct');
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
            $sub_arr[] = $row->usnm . ' (' . $row->brcd . ')';
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

//        $funcPerm = $this->Generic_model->getFuncPermision('rcntAct');
//        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'View Recent Activity');

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->all_recnt(),
            "recordsFiltered" => $this->Admin_model->filtered_recnt(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    //*******************************************************
    //**********    PERMISSION MANAGEMENT       *************
    //*******************************************************

    function permis()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'permis'; //Page

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('permis');
        $dataArr['branchinfo'] = $this->Generic_model->getBranch();
        $dataArr['uslvlinfo'] = $this->Generic_model->getUserLvl();
        $this->load->view('admin/permissionManagement', $dataArr);
        $this->load->view('common/tmpFooter', $data);
    }

    // normal permission
    function srchPermis()
    {
        $prtp = $this->input->post('prtp');
        $uslv = $this->input->post('uslv');
        $user = $this->input->post('user');

        $this->db->select("user_prmis.prid,user_prmis.pgac,user_prmis.view,user_prmis.inst,user_prmis.edit,user_prmis.apvl,user_prmis.rejt,user_prmis.dact,user_prmis.reac,user_page.pgnm,user_page.aid ,user_page.mntp, user_page_mdl.mdnm  ");
        $this->db->from("user_prmis");
        $this->db->join('user_page', 'user_page.aid = user_prmis.pgid');
        $this->db->join('user_page_mdl', 'user_page_mdl.aid = user_page.modu', 'left');
        $this->db->where('user_prmis.stat', 1);
        $this->db->where('user_page.stst', 1);
        $this->db->where('user_page.mntp', 0);
        // default permission
        if ($prtp == '1') {
            $this->db->where('user_prmis.prtp', 0);
            $this->db->where('user_prmis.ulid', $uslv);
        } else if ($prtp == '2') {
            // manuel permission
            $this->db->where('user_prmis.prtp', 1);
            $this->db->where('user_prmis.usid', $user);
        }
        $this->db->order_by('user_page.modu', 'ASC'); //ASC  DESC
        $this->db->order_by('user_page.aid', 'ASC'); //ASC  DESC

        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // Master permission
    function srchPermisMs()
    {
        $prtp = $this->input->post('prtp');
        $uslv = $this->input->post('uslv');
        $user = $this->input->post('user');

        $this->db->select("user_prmis.prid,user_prmis.pgac,user_prmis.view,user_prmis.inst,user_prmis.edit,user_prmis.apvl,user_prmis.rejt,user_prmis.dact,user_prmis.reac,user_page.pgnm,user_page.aid ,user_page.mntp, user_page_mdl.mdnm  ");
        $this->db->from("user_prmis");
        $this->db->join('user_page', 'user_page.aid = user_prmis.pgid');
        $this->db->join('user_page_mdl', 'user_page_mdl.aid = user_page.modu', 'left');
        $this->db->where('user_prmis.stat', 1);
        $this->db->where('user_page.stst', 1);
        $this->db->where('user_page.mntp', 1);
        // default permission
        if ($prtp == '1') {
            $this->db->where('user_prmis.prtp', 0);
            $this->db->where('user_prmis.ulid', $uslv);
        } else if ($prtp == '2') {
            // manuel permission
            $this->db->where('user_prmis.prtp', 1);
            $this->db->where('user_prmis.usid', $user);
        }
        $this->db->order_by('user_page.modu', 'ASC'); //ASC  DESC
        $this->db->order_by('user_page.aid', 'ASC'); //ASC  DESC

        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // advance permission
    function srchPermisAdvn()
    {
        $prtp = $this->input->post('prtp');
        $uslv = $this->input->post('uslv');
        $user = $this->input->post('user');

        $this->db->select("user_prmis.prid,user_prmis.prnt,user_prmis.rpnt,  user_page.pgnm,user_page.aid   ");
        $this->db->from("user_prmis");  // user_page    user_prmis
        $this->db->join('user_page', 'user_page.aid = user_prmis.pgid');
        $this->db->where('user_prmis.stat', 1);
        $this->db->where('user_page.adpr', 1);

        if ($prtp == '1') {         // default permission
            $this->db->where('user_prmis.prtp', 0);
            $this->db->where('user_prmis.ulid', $uslv);
        } else if ($prtp == '2') {      // manuel permission
            $this->db->where('user_prmis.prtp', 1);
            $this->db->where('user_prmis.usid', $user);
        }

        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // normal permission add
    function edtPermin()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $len = $this->input->post('len');

        for ($a = 0; $a < $len; $a++) {
            $prid = $this->input->post("prid[" . $a . "]");
            $view = $this->input->post("view[" . $a . "]");
            $inst = $this->input->post("inst[" . $a . "]");
            $edit = $this->input->post("edit[" . $a . "]");
            $rejt = $this->input->post("rejt[" . $a . "]");
            $apvl = $this->input->post("apvl[" . $a . "]");
            $pgac = $this->input->post("pgac[" . $a . "]");
            $reac = $this->input->post("reac[" . $a . "]");
            $dact = $this->input->post("dact[" . $a . "]");

            $data_ar1 = array(
                'pgac' => $pgac,
                'view' => $view,
                'inst' => $inst,
                'edit' => $edit,
                'rejt' => $rejt,
                'apvl' => $apvl,
                'dact' => $dact,
                'reac' => $reac
            );
            $this->Generic_model->updateData('user_prmis', $data_ar1, array('prid' => $prid));
        }

        // ------ permission change save -----
        $prid = $this->input->post("prid[0]");
        $prmdt = $this->Generic_model->getData('user_prmis', array('prtp', 'ulid', 'usid'), array('prid' => $prid));
        // user level wise permission
        if ($prmdt[0]->prtp == 0) {
            $lvldt = $this->Generic_model->getData('user_level', array('lvnm'), array('id' => $prmdt[0]->ulid));
            $nte = " (" . $lvldt[0]->lvnm . ')';
        } else {
            $usdt = $this->Generic_model->getData('user_mas', array('usnm'), array('auid' => $prmdt[0]->usid));
            $nte = " (" . $usdt[0]->usnm . ')';
        }
        // ------ end permission change save -----

        $funcPerm = $this->Generic_model->getFuncPermision('permis');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Normal Permission Updated' . $nte);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // Master permission add
    function edtPerminMs()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $len = $this->input->post('lenms');

        for ($a = 0; $a < $len; $a++) {
            $prid = $this->input->post("prid[" . $a . "]");
            $view = $this->input->post("view[" . $a . "]");
            $inst = $this->input->post("inst[" . $a . "]");
            $edit = $this->input->post("edit[" . $a . "]");
            $rejt = $this->input->post("rejt[" . $a . "]");
            $apvl = $this->input->post("apvl[" . $a . "]");
            $pgac = $this->input->post("pgac[" . $a . "]");
            $reac = $this->input->post("reac[" . $a . "]");
            $dact = $this->input->post("dact[" . $a . "]");

            $data_ar1 = array(
                'pgac' => $pgac,
                'view' => $view,
                'inst' => $inst,
                'edit' => $edit,
                'rejt' => $rejt,
                'apvl' => $apvl,
                'dact' => $dact,
                'reac' => $reac
            );
            $this->Generic_model->updateData('user_prmis', $data_ar1, array('prid' => $prid));
        }

        // ------ permission change save -----
        $prid = $this->input->post("prid[0]");
        $prmdt = $this->Generic_model->getData('user_prmis', array('prtp', 'ulid', 'usid'), array('prid' => $prid));
        // user level wise permission
        if ($prmdt[0]->prtp == 0) {
            $lvldt = $this->Generic_model->getData('user_level', array('lvnm'), array('id' => $prmdt[0]->ulid));
            $nte = " (" . $lvldt[0]->lvnm . ')';
        } else {
            $usdt = $this->Generic_model->getData('user_mas', array('usnm'), array('auid' => $prmdt[0]->usid));
            $nte = " (" . $usdt[0]->usnm . ')';
        }
        // ------ end permission change save -----

        $funcPerm = $this->Generic_model->getFuncPermision('permis');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Master Permission Updated' . $nte);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // advance permission add
    function edtPerminAdvan()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $len = $this->input->post('lensp');

        for ($a = 0; $a < $len; $a++) {
            $prid = $this->input->post("prid[" . $a . "]");
            $prnt = $this->input->post("prnt[" . $a . "]");
            $rpnt = $this->input->post("rpnt[" . $a . "]");

            $data_ar1 = array(
                'prnt' => $prnt,
                'rpnt' => $rpnt
            );
            $this->Generic_model->updateData('user_prmis', $data_ar1, array('prid' => $prid));
        }

        // ------ permission change save -----
        $prid = $this->input->post("prid[0]");
        $prmdt = $this->Generic_model->getData('user_prmis', array('prtp', 'ulid', 'usid'), array('prid' => $prid));
        // user level wise permission
        if ($prmdt[0]->prtp == 0) {
            $lvldt = $this->Generic_model->getData('user_level', array('lvnm'), array('id' => $prmdt[0]->ulid));
            $nte = " (" . $lvldt[0]->lvnm . ')';
        } else {
            $usdt = $this->Generic_model->getData('user_mas', array('usnm'), array('auid' => $prmdt[0]->usid));
            $nte = " (" . $usdt[0]->usnm . ')';
        }
        // ------ end permission change save -----

        $funcPerm = $this->Generic_model->getFuncPermision('permis');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Advance permission Updated' . $nte);


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // Specil permission
    function srchPermisSpecil()
    {
        $prtp = $this->input->post('prtp');     // permission type 1-default | 2-manuel
        $uslv = $this->input->post('uslv');     // user level
        $user = $this->input->post('user');     // user id

        $this->db->select("* ");
        $this->db->from("user_prmis_advance");
        $this->db->where('user_prmis_advance.stat', 1);

        if ($prtp == 1) {
            $this->db->where('user_prmis_advance.prtp', 0);
            $this->db->where('user_prmis_advance.lvid', $uslv);
        } else {
            $this->db->where('user_prmis_advance.prtp', 1);
            $this->db->where('user_prmis_advance.usid', $user);
            //$this->db->where('user_prmis_advance.lvid', $uslv);
        }
        $query = $this->db->get();
        $data['perm'] = $query->result();

        $data['uslv'] = $this->Generic_model->getData('user_level', array('id', 'lvnm'), array('stat' => 1, 'id' => $uslv));
        echo json_encode($data);
    }

    // SPECIAL BRANCH
    function getSpecilBrnch()
    {
        $prtp = $this->input->post('prtp');     // permission type 1-default | 2-manuel
        $uslv = $this->input->post('uslv');     // user level
        $user = $this->input->post('user');     // user id

        $this->db->select("* ");
        $this->db->from("user_spec_brn");
        //$this->db->where('user_spec_brn.stat', 1);
        if ($prtp == 1) {
            $this->db->where('user_spec_brn.prtp', 0);
            $this->db->where('user_spec_brn.lvid', $uslv);
        } else {
            $this->db->where('user_spec_brn.prtp', 1);
            $this->db->where('user_spec_brn.usid', $user);
            //$this->db->where('user_prmis_advance.lvid', $uslv);
        }
        //$this->db->order_by('b.brid asc');
        $query = $this->db->get();
        $data['perm'] = $query->result();

        $data['brnc'] = $this->Generic_model->getData('brch_mas', array('brid', 'brcd', 'brnm'), array('stat' => 1));

        $data['uslv'] = $this->Generic_model->getData('user_level', array('id', 'lvnm'), array('stat' => 1, 'id' => $uslv));
        echo json_encode($data);
    }

    // special permission edit
    function edtPerminSpecil()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $len = $this->input->post('lenMst');
        $type = $this->input->post('type');
        $prtp = $this->input->post('adprtp'); // PERMISSION TYPE
        $prus = $this->input->post('adprus'); // PERMISSION USER

        if ($prtp == 1) {
            $prtpn = 0; // DEFAULT PERMISSION
            $prusn = 0;
        } else {
            $prtpn = 1; // MANUAL PERMISSION
            $prusn = $prus;
        }

        // INSERT
        if ($type == 1) {
            for ($a = 0; $a < $len; $a++) {
                $lvid = $this->input->post("lvid[" . $a . "]");
                $msst = $this->input->post("msst[" . $a . "]");
                $albr = $this->input->post("albr[" . $a . "]");
                $alof = $this->input->post("alof[" . $a . "]");
                $alcn = $this->input->post("alcn[" . $a . "]");
                $tpsp = $this->input->post("tpsp[" . $a . "]");
                $spbr = $this->input->post("spbr[" . $a . "]");

                (!empty($msst)) ? $msst = $msst : $msst = 0;
                (!empty($albr)) ? $albr = $albr : $albr = 0;
                (!empty($alof)) ? $alof = $alof : $alof = 0;
                (!empty($alcn)) ? $alcn = $alcn : $alcn = 0;
                (!empty($tpsp)) ? $tpsp = $tpsp : $tpsp = 0;
                (!empty($spbr)) ? $spbr = $spbr : $spbr = 0;

                $data_ar1 = array(
                    'prtp' => $prtpn,
                    'lvid' => $lvid,
                    'usid' => $prusn,
                    'msve' => $msst,
                    'albr' => $albr,
                    'alof' => $alof,
                    'alcn' => $alcn,
                    'tpsp' => $tpsp,
                    'spbr' => $spbr,
                    'stat' => 1,
                );
                $this->Generic_model->insertData('user_prmis_advance', $data_ar1);
            }
        } else {
            // UPDATE
            for ($a = 0; $a < $len; $a++) {
                $lvid = $this->input->post("lvid[" . $a . "]");
                $msst = $this->input->post("msve[" . $a . "]");
                $albr = $this->input->post("albr[" . $a . "]");
                $alof = $this->input->post("alof[" . $a . "]");
                $alcn = $this->input->post("alcn[" . $a . "]");
                $tpsp = $this->input->post("tpsp[" . $a . "]");
                $spbr = $this->input->post("spbr[" . $a . "]");

                $auid = $this->input->post("auid[" . $a . "]");

                $data_ar1 = array(
                    //'lvid' => $lvid,
                    'prtp' => $prtpn,
                    'usid' => $prusn,
                    'msve' => $msst,
                    'albr' => $albr,
                    'alof' => $alof,
                    'alcn' => $alcn,
                    'tpsp' => $tpsp,
                    'spbr' => $spbr,
                    //'stat' => 1,
                );
                $this->Generic_model->updateData('user_prmis_advance', $data_ar1, array('auid' => $auid));
            }
        }

        // SPECIAL BRANCH ADD
        $bridn = $this->input->post('bridn'); // ALL ACTIVE BRANCH spbrln

        // NEW BRANCH ADD WITH PERMISION
        if ($this->input->post('brnLn') == 1) {

            for ($a = 0; $a < sizeof($bridn); $a++) {
                // NEW INSERT
                $spBrnN = $this->input->post("sppbrn_nm[" . $a . "]"); // user_spec_brn TB AUTO ID
                $lvid = $this->input->post("lvid[" . $a . "]");

                if (!empty($spBrnN)) {
                    $data_ar1 = array(
                        'prtp' => $prtpn,
                        'lvid' => $lvid,
                        'usid' => $prusn,
                        'brid' => $spBrnN,
                        'stat' => 1,
                    );
                    $this->Generic_model->insertData('user_spec_brn', $data_ar1);
                }
            }
            // UPDATE BRANCH WITH PERMISSION
        } else {
            for ($a = 0; $a < sizeof($bridn); $a++) {

                $baid = $this->input->post("bridn[" . $a . "]");    // BRNCH MASTER AUID
                $spbrn = $this->input->post("sppbrn[" . $a . "]");  // user_spec_brn TB BRNCH ID
                $buAuid = $this->input->post("buAuid[" . $a . "]"); // user_spec_brn TB AUTO ID

                //  var_dump($baid . ' x ' . $buAuid . ' * ' . $spbrn . ' <br> ');
                // UPDATE
                if (!empty($spbrn)) {
                    $this->Generic_model->updateData('user_spec_brn', array('stat' => 1), array('auid' => $buAuid));
                } else {
                    $this->Generic_model->updateData('user_spec_brn', array('stat' => 0), array('auid' => $buAuid));
                }

                // NEW INSERT
                $spBrnN = $this->input->post("sppbrn_nm[" . $a . "]"); // user_spec_brn TB AUTO ID
                $lvid = $this->input->post("lvid[" . $a . "]");

                if (!empty($spBrnN)) {
                    $data_ar1 = array(
                        'prtp' => $prtpn,
                        'lvid' => $lvid,
                        'usid' => $prusn,
                        'brid' => $spBrnN,
                        'stat' => 1,
                    );
                    $this->Generic_model->insertData('user_spec_brn', $data_ar1);
                }
            }
        }

        $funcPerm = $this->Generic_model->getFuncPermision('permis');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Special permission Updated');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // MODULE PERMISION SEARCH
    function srchMdulPermis()
    {
        $prtp = $this->input->post('prtp');     // permission type 1-default | 2-manuel
        $uslv = $this->input->post('uslv');     // user level
        $user = $this->input->post('user');     // user id

        $this->db->select("* ");
        $this->db->from("user_prmis_modul");
        $this->db->where('user_prmis_modul.stat', 1);

        if ($prtp == 1) {
            $this->db->where('user_prmis_modul.prtp', 0);
            $this->db->where('user_prmis_modul.lvid', $uslv);
        } else {
            $this->db->where('user_prmis_modul.prtp', 1);
            $this->db->where('user_prmis_modul.usid', $user);
            //$this->db->where('user_prmis_advance.lvid', $uslv);
        }
        $query = $this->db->get();
        $data['perm'] = $query->result();

        $data['uslv'] = $this->Generic_model->getData('user_level', array('id', 'lvnm'), array('stat' => 1, 'id' => $uslv));
        echo json_encode($data);
    }

    // MODULE PERMISION EDIT
    function edtMdulPermis()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $len = $this->input->post('lenMst2');
        $type = $this->input->post('type2');
        $prtp = $this->input->post('adprtp2'); // PERMISSION TYPE
        $prus = $this->input->post('adprus2'); // PERMISSION USER

        if ($prtp == 1) {
            $prtpn = 0; // DEFAULT PERMISSION
            $prusn = 0;
        } else {
            $prtpn = 1; // MANUAL PERMISSION
            $prusn = $prus;
        }

        // INSERT
        if ($type == 1) {
            for ($a = 0; $a < $len; $a++) {
                $lvid = $this->input->post("lvid[" . $a . "]");
                $user = $this->input->post("user[" . $a . "]");
                $admi = $this->input->post("admi[" . $a . "]");
                $stck = $this->input->post("stck[" . $a . "]");

                (!empty($user)) ? $user = $user : $user = 0;
                (!empty($admi)) ? $admi = $admi : $admi = 0;
                (!empty($stck)) ? $stck = $stck : $stck = 0;

                $data_ar1 = array(
                    'prtp' => $prtpn,
                    'lvid' => $lvid,
                    'usid' => $prusn,
                    'user' => $user,
                    'admi' => $admi,
                    'stck' => $stck,
                    'stat' => 1,
                );
                $result = $this->Generic_model->insertData('user_prmis_modul', $data_ar1);
            }

        } else {
            // UPDATE
            for ($a = 0; $a < $len; $a++) {
                $lvid = $this->input->post("lvid[" . $a . "]");
                $usid = $this->input->post("usid[" . $a . "]");
                $auid = $this->input->post("auid[" . $a . "]");

                $user = $this->input->post("user[" . $a . "]");
                $admi = $this->input->post("admi[" . $a . "]");
                $stck = $this->input->post("stck[" . $a . "]");

                $data_ar1 = array(
                    'prtp' => $prtpn,
                    'usid' => $prusn,

                    'user' => $user,
                    'admi' => $admi,
                    'stck' => $stck,
                );
                $result1 = $this->Generic_model->updateData('user_prmis_modul', $data_ar1, array('auid' => $auid));
            }
        }
        $funcPerm = $this->Generic_model->getFuncPermision('permis');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Module permission Updated');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // module search & add new module
    function srchModul()
    {
        $prtp = $this->input->post('prtp');
        $uslv = $this->input->post('uslv'); // user level id
        $type = $this->input->post('type'); // user level id
        $brch = $this->input->post('brch');
        $user = $this->input->post('user'); // user id

        $this->db->select(" user_page.* ,user_page_mdl.mdnm ");
        $this->db->from("user_page");
        $this->db->where('user_page.stst', 1);
        $this->db->where('user_page.mntp', $type);
        $this->db->join('user_page_mdl', 'user_page_mdl.aid = user_page.modu', 'left');

        if ($prtp == 1) {
            $this->db->where("user_page.aid NOT IN (SELECT aid FROM `user_page` AS c 
            JOIN user_prmis AS d ON c.aid = d.pgid WHERE d.ulid = '$uslv') ");
        } elseif ($prtp == 2) {
            $this->db->where("user_page.aid NOT IN (SELECT aid FROM `user_page` AS c 
            JOIN user_prmis AS d ON  c.aid = d.pgid WHERE d.usid = '$user') ");
        }
        $this->db->order_by('user_page.modu', 'ASC'); //ASC  DESC
        $this->db->order_by('user_page.aid', 'ASC'); //ASC  DESC
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    function addModul()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $len = $this->input->post('mdlen');
        $uslv = $this->input->post('uslvl');
        $usid = $this->input->post('usid');
        $ptp = $this->input->post('ptp');

        if ($ptp == 1) { // default
            $prtp = 0;
            $uslv2 = $uslv;
            $usid2 = 0;
        } else {          // manuel
            $prtp = 1;
            $uslv2 = 0;
            $usid2 = $usid;
        }

        for ($a = 0; $a < $len; $a++) {

            $addm = $this->input->post("addm[" . $a . "]");
            $aid = $this->input->post("aid[" . $a . "]");

            if (!empty($addm)) {
                $data_ar1 = array(
                    'pgid' => $aid,
                    'prtp' => $prtp,
                    'ulid' => $uslv2,
                    'usid' => $usid2,
                    //'pgac' => 1,
                    'stat' => 1
                );

                $result = $this->Generic_model->insertData('user_prmis', $data_ar1);
            }
        }

        $funcPerm = $this->Generic_model->getFuncPermision('permis');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Page Added ($aid) To ($usid2)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // PAGE ACCESS
    function srchPgAcss()
    {
        $this->db->select("user_page.* ,user_page_mdl.mdnm");
        $this->db->from("user_page");
        $this->db->join('user_page_mdl', 'user_page_mdl.aid = user_page.modu', 'left');
        $this->db->order_by('user_page.modu', 'ASC'); //ASC  DESC
        $this->db->order_by('user_page.aid', 'ASC'); //ASC  DESC
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    // PAGE ACCESS PERMISION UPDATE
    function edtPgaccs()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $len = $this->input->post('len5');

        for ($a = 0; $a < $len; $a++) {
            $pgid = $this->input->post("pgid[" . $a . "]");
            $pgac = $this->input->post("pgac[" . $a . "]");

            $this->Generic_model->updateData('user_page', array('stst' => $pgac), array('aid' => $pgid));
        }

        $funcPerm = $this->Generic_model->getFuncPermision('permis');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Page Access Update');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }
    //*******************************************************
    //**********   END PERMISSION MANAGEMENT       **********
    //*******************************************************

    // SYSTEM COMPONENT - BRANCH
    public function sysBrnc()
    {
        $data['acm'] = 'sysCmp'; //Module
        $data['acp'] = 'sysBrnc'; //Page

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('sysBrnc');
        $dataArr['policyinfo'] = $this->Generic_model->getData('sys_policy', '', '');

        $this->load->view('admin/branchManagement', $dataArr);
        $this->load->view('common/tmpFooter', $data);
    }

    //SEARCH BRANCH
    function searchBranc()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('sysBrnc');

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

        $result = $this->Admin_model->get_brnDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $auid = $row->brid;

            if ($row->stat == 0) {
                $stat = "<label class='label label-warning'>Pending</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $app id='app' data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' $rejt onclick='rejectSupp($auid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 1) {
                $stat = "<label class='label label-success'>Active</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' $dac onclick='inactSupp($auid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else if ($row->stat == 3) {
                $stat = "<label class='label label-danger'>Reject</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 2) {
                $stat = "<label class='label label-indi'>Inactive</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $reac onclick='reactSupp($auid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button>";
            } else {
                $stat = "--";
                $option = "<button type='button' disabled data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='editSupp($auid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='approveSupp($auid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='rejectSupp($auid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->brnm;
            $sub_arr[] = $row->brad;
            $sub_arr[] = $row->brmb;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $row->brcrdt;
            $sub_arr[] = $stat;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->count_all_brn(),
            "recordsFiltered" => $this->Admin_model->count_filtered_brn(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // BRANCH NAME CHECK
    function chkBrncName()
    {
        $name = $this->input->post('name');
        $stat = $this->input->post('stat'); //0-Add/1-Edit

        $this->db->select("brnm");
        $this->db->from('brch_mas');
        $this->db->where('brnm', $name);
        if ($stat == 1) {
            $this->db->where("brid != " . $this->input->post('auid'));
        }
        $res = $this->db->get()->result();
        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // BRANCH CODE CHECK
    function chkBrnCode()
    {
        $name = $this->input->post('code');
        $stat = $this->input->post('stat'); //0-Add/1-Edit

        $this->db->select("brcd");
        $this->db->from('brch_mas');
        $this->db->where('brcd', $name);
        if ($stat == 1) {
            $this->db->where("brid !=" . $this->input->post('auid'));
        }
        $res = $this->db->get()->result();
        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // BRANCH INSERT
    function branchCreate()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $brcd = strtoupper($this->input->post('code'));

        $this->Generic_model->insertData('brch_mas',
            array(
                'brcd' => $brcd,
                'brnm' => $this->input->post('name'),
                'brad' => $this->input->post('addr'),
                'brmb' => $this->input->post('mobi'),
                'brtp' => $this->input->post('tele'),
                'brem' => $this->input->post('email'),
                'remk' => $this->input->post('remk'),
                'stat' => 0,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
            ));

        $funcPerm = $this->Generic_model->getFuncPermision('sysBrnc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "New Branch Added ($brcd)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // VIEW BRANCH for edit approval
    function getBrncDet()
    {
        $auid = $this->input->post('id');

        $this->db->select(" * ");
        $this->db->from('brch_mas');
        /*$this->db->join('user_mas cr', 'cr.auid=sup.crby');
        $this->db->join('user_mas ap', 'ap.auid=sup.apby', 'LEFT');
        $this->db->join('user_mas md', 'md.auid=sup.mdby', 'LEFT');
        $this->db->join('user_mas rj', 'rj.auid=sup.rjby', 'LEFT');*/
        $this->db->where("brch_mas.brid", $auid);
        $data = $this->db->get()->result();

        echo json_encode($data);
    }

    // UPDATE & APPROVAL
    function brncEdit()
    {
        $func = $this->input->post('func');
        $auid = $this->input->post('auid');
        $brcd = strtoupper($this->input->post('codeEdt'));

        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($func == 'edit') {
            //Updating
            $this->Generic_model->updateData('brch_mas',
                array(
                    'brcd' => $brcd,
                    'brnm' => $this->input->post('nameEdt'),
                    'brad' => $this->input->post('addrEdt'),
                    'brmb' => $this->input->post('mobiEdt'),
                    'brtp' => $this->input->post('teleEdt'),
                    'brem' => $this->input->post('emailEdt'),
                    'remk' => $this->input->post('remkEdt'),
                    'mdby' => $_SESSION['userId'],
                    'mddt' => date('Y-m-d H:i:s'),
                ),
                array('brid' => $auid));

            $funcPerm = $this->Generic_model->getFuncPermision('sysBrnc');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Branch Updated ($brcd)");

        } else if ($func == 'app') {

            //Updating
            $this->Generic_model->updateData('brch_mas',
                array(
                    'brcd' => $brcd,
                    'brnm' => $this->input->post('nameEdt'),
                    'brad' => $this->input->post('addrEdt'),
                    'brmb' => $this->input->post('mobiEdt'),
                    'brtp' => $this->input->post('teleEdt'),
                    'brem' => $this->input->post('emailEdt'),
                    'remk' => $this->input->post('remkEdt'),
                    'stat' => 1,
                    'apby' => $_SESSION['userId'],
                    'apdt' => date('Y-m-d H:i:s'),
                    'mdby' => $_SESSION['userId'],
                    'mddt' => date('Y-m-d H:i:s'),
                ),
                array('brid' => $auid));

            $funcPerm = $this->Generic_model->getFuncPermision('sysBrnc');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Branch Approved ($brcd)");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // BRANCH REJECT
    function brnReject()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $auid = $this->input->post('id');
        $this->Generic_model->updateData('brch_mas',
            array(
                'stat' => 3,
            ),
            array('brid' => $auid));

        $funcPerm = $this->Generic_model->getFuncPermision('sysBrnc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Branch Rejected ($auid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // DEACTIVE
    function brnDeactive()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $auid = $this->input->post('id');
        $this->Generic_model->updateData('brch_mas', array(
            'stat' => 2,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('brid' => $auid));

        $funcPerm = $this->Generic_model->getFuncPermision('sysBrnc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Branch Deactivated ($auid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // REACTIVE
    function brncReactiv()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $spid = $this->input->post('id');
        $this->Generic_model->updateData('brch_mas', array(
            'stat' => 1,
            'mdby' => $_SESSION['userId'],
            'mddt' => date('Y-m-d H:i:s')
        ), array('brid' => $spid));

        $funcPerm = $this->Generic_model->getFuncPermision('sysBrnc');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Branch Reactivated ($spid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    //******************************************************* //
    // SYSTEM COMPONENT - USER MANAGEMENT
    public function usrMng()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'usrMng'; //Page

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('usrMng');
        $dataArr['policyinfo'] = $this->Generic_model->getData('sys_policy', '', '');

        $dataArr['branchinfo'] = $this->Generic_model->getBranch();
        $dataArr['uslvlinfo'] = $this->Generic_model->getData('user_level', '', "stat = 1 AND id != 1");

        $this->load->view('admin/userManagement', $dataArr);
        $this->load->view('common/tmpFooter', $data);
    }

    //SEARCH USER
    function searchUser()
    {
        $funcPerm = $this->Generic_model->getFuncPermision('usrMng');

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

        $result = $this->Admin_model->get_userDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {
            $auid = $row->auid;

            if ($row->prmd == 0) {
                $prmd = "<label class='label label-info' title='Default Permission'>DP</label>";
            } else {
                $prmd = "<label class='label label-warning' title='Manual Permission'>MP</label>";
            }

            if ($row->stat == 1) {
                $stat = "<label class='label label-success'>Active</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' $edit id='edit' data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid,this.id);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $dac onclick='inactUser($auid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Deactivate'><i class='fa fa-close' aria-hidden='true'></i></button> " .
                    "<button type='button' onclick='resetPass($auid)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reset Password'><i class='fa fa-key' aria-hidden='true'></i></button> ";
            } else if ($row->stat == 0) {
                $stat = "<label class='label label-danger'>Inactive</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            } else if ($row->stat == 2) {
                $stat = "<label class='label label-indi'> Tmp Disable</label>";
                $option = "<button type='button' $viw id='view' data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid,this.id)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' $reac onclick='reactUser($auid);' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Activate'><i class='fa fa-wrench' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reset Password'><i class='fa fa-key' aria-hidden='true'></i></button>";
            } else {
                $stat = "--";
                $option = "<button type='button' disabled data-toggle='modal' data-target='#modal-view' onclick='viewBrnc($auid)' class='btn btn-xs btn-default btn-condensed btn-rounded' title='View'><i class='fa fa-eye' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='editSupp();' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='approveSupp();' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Approve'><i class='fa fa-check' aria-hidden='true'></i></button> " .
                    "<button type='button' disabled onclick='rejectSupp();' class='btn btn-xs btn-default btn-condensed btn-rounded' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button>";
            }

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->brcd;
            $sub_arr[] = $row->usnm;
            $sub_arr[] = $row->fnme . ' ' . $row->lnme;
            $sub_arr[] = $row->almo;
            $sub_arr[] = $row->unic;
            $sub_arr[] = $row->lvnm;
            $sub_arr[] = $stat . ' ' . $prmd;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->count_all_user(),
            "recordsFiltered" => $this->Admin_model->count_filtered_user(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // USER NAME CHECK
    function chkUserName()
    {
        $name = $this->input->post('usnm');
        $stat = $this->input->post('stat'); //0-Add/1-Edit

        $this->db->select("usnm");
        $this->db->from('user_mas');
        $this->db->where('usnm', $name);
        if ($stat == 1) {
            $this->db->where("auid != " . $this->input->post('auid'));
        }
        $res = $this->db->get()->result();
        if (sizeof($res) > 0) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

    // USER INSERT
    function userCreate()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($this->input->post('prmTp') == '') {
            $prmd = 0;
        } else {
            $prmd = $this->input->post('prmTp');
        }

        /* https://arjunphp.com/generating-alphanumeric-unique-id-in-codeigniter/ */
        /*  1) alpha: A string with lower and uppercase letters only.
            2) alnum: Alpha-numeric string with lower and uppercase characters.
            3) numeric: Numeric string.
            4) nozero: Numeric string with no zeros.
        */

        $this->load->helper('string');
        $rdcode = random_string('nozero', 6);

        /*$funm = $this->input->post('funm');
        $innm = $this->input->post('innm');*/
        $email = $this->input->post('emil');
        $usnm = $this->input->post('usnm');
        $fnme = $this->input->post('frnm');
        $lnme = $this->input->post('lsnm');

        $this->Generic_model->insertData('user_mas',
            array(
                'usnm' => $usnm,
                'brch' => $this->input->post('brchNw'),
                'usmd' => $this->input->post('uslvNw'),
                'prmd' => $prmd,

                'fnme' => $fnme,
                'lnme' => $lnme,
                'emid' => $email,

                'unic' => $this->input->post('unic'),
                'tpno' => $this->input->post('tele'),
                'almo' => $this->input->post('mobi'),
                'udob' => $this->input->post('udob'),
                'gend' => $this->input->post('ugnd'),

                'stat' => 1,
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),

                'lgps' => '$2y$10$KgBH6wkYF0/B1GF/dyvuxukPt/nObT9mzNmrf84SjJJM9IUD1RBfC', // asd@123
                'lgcd' => $rdcode,
                'fslg' => 1,
            ));

        $funcPerm = $this->Generic_model->getFuncPermision('usrMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "New User Added ($usnm)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END

            // CHECK POLICY USER REGISTER EMAIL SEND OR NOT
            $pocyemil = $this->Generic_model->getData('sys_policy', array('post', 'stat'), array('poid' => 2));
            if ($pocyemil[0]->stat == 1 && $pocyemil[0]->post == 1) {

                $comdt = $this->Generic_model->getData('com_det', array('cmne', 'syln'), array('stat' => 1));
                $systnm = $comdt[0]->cmne;
                $sysLink = $comdt[0]->syln;

                // SEND MAIL CONFIGURATION
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://mail.northpony.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'noreply@northpony.com', // change it to yours
                    'smtp_pass' => '&8,SlFRE_D3y', // change it to yours
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1',
                    // 'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );

                // SEND MAIL MESSAGE
                $message = "<tbody>
        <tr><td bgcolor='#F6F8FA' style='background-color:#F6F8FA; padding:12px; border-bottom:1px solid #ECECEC'></td>
        </tr><tr><td style=''><table border='0' cellspacing='0' cellpadding='0' width='100%' style=''><tbody>
        <tr><td style='padding:24px 0 48px'><table border='0' cellspacing='0' cellpadding='0' width='100%' style=''><tbody>
        <tr><td align='center' style='padding:0 2.2% 32px; text-align:center'><h2 style='margin:0; word-wrap:break-word; color:#262626; word-break:; font-weight:700; font-size:20px; line-height:1.2'></h2><h2 style='margin:0; color:#262626; font-weight:200; font-size:20px; line-height:1.2'> Get Started On Your " . $systnm . " System Account Now. </h2></td></tr>
        <tr><td align='center' style=''><table border='0' class='x_face-grid x_small' cellspacing='0' cellpadding='0' width='100%' style='table-layout:fixed'><tbody>Thank you for join with us, " . $fnme . ' ' . $lnme . "<br><br>To get started, activate your account by setting up your username and password. .<br><br>Username: " . $usnm . "<br>Password: asd@123 <br>Digital Eye : $rdcode <br><br></tbody></table></td></tr>
        <tr><td align='center' style='text-align:center'><h2 style='margin:0; color:#262626; font-weight:200; font-size:20px; line-height:1.2'> <a href=' " . $sysLink . "'  style='color:#008CC9; display:inline-block; text-decoration:none'>Login to System</a></h2></td></tr></tbody></table></td></tr></tbody></table></td></tr>
        <tr><td style=''><table border='0' cellspacing='0' cellpadding='0' width='100%' bgcolor='#EDF0F3' align='center' style='background-color:#EDF0F3; padding:0 24px; color:#999999; text-align:center'><tbody>
        <tr><td style=''><table align='center' border='0' cellspacing='0' cellpadding='0' width='100%' style=''><tbody><tr><td valign='middle' align='center' style='padding:0 0 16px 0; vertical-align:middle; text-align:center'></td></tr></tbody></table><table border='0' cellspacing='0' cellpadding='0' width='100%' style=''><tbody><tr><td align='center' style='padding:0 0 12px 0; text-align:center'><p style='margin:0; color:#737373; font-weight:400; font-size:12px; line-height:1.333'>This is a system generated email to help you to get Login Details.</p></td></tr>
        <tr><td align='center' style='padding:0 0 12px 0; text-align:center'><p style='margin:0; word-wrap:break-word; color:#737373; word-break:break-word; font-weight:400; font-size:12px; line-height:1.333'>If you have any questions or if you are encountering problems, our support team at support@gdcreations.com is happy to assist you. Alternatively, you can visit our Support Desk.</p></td></tr>
        <tr><td align='center' style='padding:0 0 8px 0; text-align:center'></td></tr>
        </tbody></table></td></tr></tbody></table></td></tr></tbody>";

                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from('noreply@northpony.com', $systnm);   // change it to yours
                $this->email->to($email);                               // change it to yours    'gamunu@gdcreations.com'
                $this->email->subject('Get Started On Your ' . $systnm . ' Account.');
                $this->email->message($message);

                if ($this->email->send()) {
                    echo json_encode(true);

                } else {
                    show_error($this->email->print_debugger());
                    echo json_encode(false);
                }
            } else {
                echo json_encode(true);
            }
        }
    }

    // VIEW USER for edit approval
    function getUserDet()
    {
        $auid = $this->input->post('id');

        $this->db->select(" * ");
        $this->db->from('user_mas');
        $this->db->where("user_mas.auid", $auid);
        $data = $this->db->get()->result();

        echo json_encode($data);
    }

    // UPDATE
    function userEdit()
    {
        $func = $this->input->post('func');
        $auid = $this->input->post('auid');
        $usnm = $this->input->post('usnmEdt');

        if ($this->input->post('prmTpEdt') == '') {
            $prmd = 0;
        } else {
            $prmd = $this->input->post('prmTpEdt');
        }

        $this->db->trans_begin(); // SQL TRANSACTION START

        if ($func == 'edit') {
            //Updating
            $this->Generic_model->updateData('user_mas',
                array(
                    'usnm' => $usnm,
                    'brch' => $this->input->post('brchNwEdt'),
                    'usmd' => $this->input->post('uslvNwEdt'),
                    'prmd' => $prmd,

                    'fnme' => $this->input->post('frnmEdt'),
                    'lnme' => $this->input->post('lsnmEdt'),
                    'emid' => $this->input->post('emilEdt'),

                    'unic' => $this->input->post('unicEdt'),
                    'tpno' => $this->input->post('teleEdt'),
                    'almo' => $this->input->post('mobiEdt'),
                    'udob' => $this->input->post('udobEdt'),
                    'gend' => $this->input->post('ugndEdt'),

                    'mdby' => $_SESSION['userId'],
                    'mddt' => date('Y-m-d H:i:s'),
                ),
                array('auid' => $auid));

            $funcPerm = $this->Generic_model->getFuncPermision('usrMng');
            $this->Log_model->userFuncLog($funcPerm[0]->pgid, "User Updated ($usnm)");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // USER REJECT
    function brnRejectXX()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $auid = $this->input->post('id');
        $this->Generic_model->updateData('brch_mas',
            array(
                'stat' => 3,
            ),
            array('brid' => $auid));

        $funcPerm = $this->Generic_model->getFuncPermision('usrMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "Branch Rejected ($auid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // DEACTIVE
    function userDeactive()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $auid = $this->input->post('id');
        $this->Generic_model->updateData('user_mas',
            array(
                'stat' => 2,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s')
            ), array('auid' => $auid));

        $funcPerm = $this->Generic_model->getFuncPermision('usrMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "User Deactivated ($auid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // REACTIVE
    function userReactiv()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $spid = $this->input->post('id');
        $this->Generic_model->updateData('user_mas',
            array(
                'stat' => 1,
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s')
            ), array('auid' => $spid));

        $funcPerm = $this->Generic_model->getFuncPermision('usrMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "User Reactivated ($spid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // PASSWORD RESET
    function userPassReset()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $spid = $this->input->post('id');

        //$podt = $this->Generic_model->getData('sys_policy', array('pov3'), array('poid' => 34), '');
        //$eycd = $podt[0]->pov3;

        $this->Generic_model->updateData('user_mas',
            array(
                'lgps' => '$2y$10$KgBH6wkYF0/B1GF/dyvuxukPt/nObT9mzNmrf84SjJJM9IUD1RBfC', // asd@123
                'lgcd' => 123456,

                'upby' => $_SESSION['userId'],
                'updt' => date('Y-m-d H:i:s'),
            ), array('auid' => $spid));

        $funcPerm = $this->Generic_model->getFuncPermision('usrMng');
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, "User Password Reset ( auid: $spid)");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

//******************************************************* //
    // SYSTEM COMPONENT - USER LEVEL
    public function usrLvl()
    {
        $data['acm'] = 'sysCmp'; //Module
        $data['acp'] = 'usrLvl'; //Page

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('usrLvl');
        $dataArr['policyinfo'] = $this->Generic_model->getData('sys_policy', '', '');

        $this->load->view('admin/userLevel', $dataArr);
        $this->load->view('common/tmpFooter', $data);
    }

    //SEARCH USER LEVEL
    function searchUserLvl()
    {
        $stat = $this->input->post('stat');

        $this->db->select(" * ");
        $this->db->from("user_level");
        if ($stat != 'all') {
            $this->db->where('user_level.stat', $stat);
        }

        $result = $this->db->get()->result();
        $data = array();
        $i = 0;

        foreach ($result as $row) {
            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->lvnm;

            $data[] = $sub_arr;
        }
        $output = array(
            "sEcho" => 2,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($output);
    }

//******************************************************* //
// SYSTEM UPDATE
    public function sysUpdate()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'sysUpdate'; //Page

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader', $per);

        $dataArr['funcPerm'] = $this->Generic_model->getFuncPermision('usrMng');
        $dataArr['policyinfo'] = $this->Generic_model->getData('sys_policy', '', '');

        $dataArr['branchinfo'] = $this->Generic_model->getBranch();
        $dataArr['uslvlinfo'] = $this->Generic_model->getData('user_level', '', "stat = 1 AND id != 1");

        $this->load->view('admin/systmUpdate', $dataArr);
        $this->load->view('common/tmpFooter', $data);
    }

    //SEARCH
    function srchSystmUpdte()
    {
        $result = $this->Admin_model->get_systmUpdtDtils();
        $data = array();
        $i = $_POST['start'];

        foreach ($result as $row) {

            if ($row->stat == 0) {
                if (date('Y-m-d', strtotime($row->date)) == date('Y-m-d') && (date('H:i:s', strtotime($row->totm)) > date('H:i:s') && date('H:i:s') >= date('H:i:s', strtotime($row->frtm)))) {
                    $mode = '<label class="label label-info"> Executing </label>';
                } else {
                    $mode = '<label class="label label-warning"> Pending </label>';
                }
                $edt = "";
                $edtt = "";
            } else if ($row->stat == 1) {
                $mode = '<label class="label label-success"> Executed </label>';
                $edt = "disabled";
                $edtt = "disabled";
            } else if ($row->stat == 2) {
                $mode = '<label class="label label-danger"> Reject </label>';
                $edt = "disabled";
                $edtt = "disabled";
            } else {
                $mode = '';
                $edtt = "";
            }

            $option = "<button $edt type='button' id='edt' data-toggle='modal' data-target='#modal-view' onclick='edtSchedule($row->auid,this.id);' class='btn btn-xs btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                " <button type='button'  $edtt id='rej'  onclick='doneSchedule($row->auid);' class='btn btn-xs btn-default btn-condensed' title='Done'><i class='fa fa-check' aria-hidden='true'></i></button> ";

            $sub_arr = array();
            $sub_arr[] = ++$i;
            $sub_arr[] = $row->date;
            $sub_arr[] = $row->mesg;
            $sub_arr[] = $row->frtm;
            $sub_arr[] = $row->totm;
            $sub_arr[] = $row->innm;
            $sub_arr[] = $row->crdt;
            $sub_arr[] = $mode;
            $sub_arr[] = $option;
            $data[] = $sub_arr;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Admin_model->count_all_systmUpdt(),
            "recordsFiltered" => $this->Admin_model->count_filtered_systmUpdt(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    // INSERT
    function addSysDown()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        $this->Generic_model->insertData('syst_update',
            array(
                'mesg' => $this->input->post('mssg'),
                'date' => $this->input->post('scdt'),
                'frtm' => $this->input->post('sttm'),
                'totm' => $this->input->post('entm'),
                'crby' => $_SESSION['userId'],
                'crdt' => date('Y-m-d H:i:s'),
                'stat' => 0
            ));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    // VIEW USER for edit approval
    function getDetSysDown()
    {
        $id = $this->input->post('id');
        $result = $this->Generic_model->getData('syst_update', '', array('auid' => $id));
        echo json_encode($result);
    }

    // UPDATE
    function edtSysDown()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START

        if (date_create($this->input->post('entmEdt')) < date_create(date('H:i:s'))) {
            $stat = 1;
        } else {
            $stat = 0;
        }

        $this->Generic_model->updateData('syst_update',
            array(
                'mesg' => $this->input->post('mssgEdt'),
                'date' => $this->input->post('scdtEdt'),
                'frtm' => $this->input->post('sttmEdt'),
                'totm' => $this->input->post('entmEdt'),
                'mdby' => $_SESSION['userId'],
                'mddt' => date('Y-m-d H:i:s'),
                'stat' => $stat
            ),
            array('auid' => $this->input->post('auid')));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    //down finish
    function SysDownFinished()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $this->Generic_model->updateData('syst_update', array('stat' => $this->input->post('stat')), array('auid' => $this->input->post('auid')));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }

    function doneSchedule()
    {
        $this->db->trans_begin(); // SQL TRANSACTION START
        $this->Generic_model->updateData('syst_update', array('stat' => 1), array('auid' => $this->input->post('auid')));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->Log_model->ErrorLog('0', '1', '2', '3');
            echo json_encode(false);
        } else {
            $this->db->trans_commit(); // SQL TRANSACTION END
            echo json_encode(true);
        }
    }


}
