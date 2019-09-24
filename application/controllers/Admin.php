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

    //*******************************************************
    //**********    PERMISSION MANAGEMENT       *************
    //*******************************************************

    function permis()
    {
        $data['acm'] = ''; //Module
        $data['acp'] = 'permis'; //Page
        $dataArr['branchinfo'] = $this->Generic_model->getBranch();
        $dataArr['uslvlinfo'] = $this->Generic_model->getUserLvl();

        $this->load->view('common/tmpHeader');
        $per['permission'] = $this->Generic_model->getPermision();
        $this->load->view('admin/common/adminHeader',$per);

        $this->load->view('admin/permissionManagement', $dataArr);
        $this->load->view('common/tmpFooter',$data);
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
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Normal Permission Update' . $nte);

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
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Advance permission Update' . $nte);


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
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Special permission Update');

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
        $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Module permission Update');

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
        $brch = $this->input->post('brch');
        $user = $this->input->post('user'); // user id

        $this->db->select(" user_page.* ,user_page_mdl.mdnm ");
        $this->db->from("user_page");
        $this->db->where('user_page.stst', 1);
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
}
