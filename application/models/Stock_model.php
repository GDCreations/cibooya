<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stock_model extends CI_Model
{
    //SEARCH SUPPLIER DETAILS </JANAKA 2019-09-19>
    var $cl_srch1 = array('spcd', 'spnm', 'addr', 'mbno', 'tele', 'email'); //set column field database for datatable searchable
    var $cl_odr1 = array(null, 'spcd', 'spnm', 'addr', 'mbno', 'user_mas.fnme', 'crdt', 'stat', ''); //set column field database for datatable orderable
    var $order1 = array('crdt' => 'DESC'); // default order

    function suppDet_query()
    {
        $stat = $this->input->post('stat');

        $this->db->select("supp_mas.*,CONCAT(user_mas.fnme,' ',user_mas.lnme) AS innm");
        $this->db->from('supp_mas');
        $this->db->join('user_mas', 'user_mas.auid=supp_mas.crby');
        if ($stat != 'all') {
            $this->db->where("supp_mas.stat=$stat");
        }
    }

    private function suppDet_queryData()
    {
        $this->suppDet_query();
        $i = 0;
        foreach ($this->cl_srch1 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cl_srch1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order1)) {
            $order1 = $this->order1;
            $this->db->order_by(key($order1), $order1[key($order1)]);
        }
    }

    function get_suppDtils()
    {
        $this->suppDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_supp()
    {
        $this->suppDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_supp()
    {
        // $this->db->from($this->table);
        $this->suppDet_query();
        return $this->db->count_all_results();
    }
    //END SEARCH SUPPLIER DETAILS </JANAKA 2019-09-19>

    //SEARCH CATEGORY DETAILS </JANAKA 2019-09-25>
    var $cl_srch2 = array('ctcd', 'ctnm'); //set column field database for datatable searchable
    var $cl_odr2 = array(null, 'ctcd', 'ctnm', 'user_mas.fnme', 'crdt', 'stat', ''); //set column field database for datatable orderable
    var $order2 = array('crdt' => 'DESC'); // default order

    function catDet_query()
    {
        $stat = $this->input->post('stat');

        $this->db->select("category.*, CONCAT(user_mas.fnme,' ',user_mas.lnme) AS innm");
        $this->db->from('category');
        $this->db->join('user_mas', 'user_mas.auid=category.crby');
        if ($stat != 'all') {
            $this->db->where("category.stat=$stat");
        }
    }

    private function catDet_queryData()
    {
        $this->catDet_query();
        $i = 0;
        foreach ($this->cl_srch2 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cl_srch2) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order2)) {
            $order2 = $this->order2;
            $this->db->order_by(key($order2), $order2[key($order2)]);
        }
    }

    function get_catDtils()
    {
        $this->catDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_cat()
    {
        $this->catDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_cat()
    {
        // $this->db->from($this->table);
        $this->catDet_query();
        return $this->db->count_all_results();
    }
    //END SEARCH CATEGORY DETAILS </JANAKA 2019-09-25>

    //SEARCH BRAND DETAILS </JANAKA 2019-09-26>
    var $cl_srch3 = array('bdcd', 'bdnm'); //set column field database for datatable searchable
    var $cl_odr3 = array(null, 'bdcd', '', 'bdnm', 'user_mas.fnme', 'crdt', 'stat', ''); //set column field database for datatable orderable
    var $order3 = array('crdt' => 'DESC'); // default order

    function brdDet_query()
    {
        $stat = $this->input->post('stat');

        $this->db->select("brand.*,CONCAT(user_mas.fnme,' ',user_mas.lnme) AS innm");
        $this->db->from('brand');
        $this->db->join('user_mas', 'user_mas.auid=brand.crby');
        if ($stat != 'all') {
            $this->db->where("brand.stat=$stat");
        }
    }

    private function brdDet_queryData()
    {
        $this->brdDet_query();
        $i = 0;
        foreach ($this->cl_srch3 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cl_srch3) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr3[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order3)) {
            $order3 = $this->order3;
            $this->db->order_by(key($order3), $order3[key($order3)]);
        }
    }

    function get_brdDtils()
    {
        $this->brdDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_brd()
    {
        $this->brdDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_brd()
    {
        // $this->db->from($this->table);
        $this->brdDet_query();
        return $this->db->count_all_results();
    }
    //END SEARCH BRAND DETAILS </JANAKA 2019-09-26>

    //SEARCH TYPE DETAILS </JANAKA 2019-09-27>
    var $cl_srch4 = array('tpcd', 'tpnm'); //set column field database for datatable searchable
    var $cl_odr4 = array(null, 'tpcd', 'tpnm', 'user_mas.fnme', 'crdt', 'stat', ''); //set column field database for datatable orderable
    var $order4 = array('crdt' => 'DESC'); // default order

    function typDet_query()
    {
        $stat = $this->input->post('stat');

        $this->db->select("type.*,CONCAT(user_mas.fnme,' ',user_mas.lnme) AS innm");
        $this->db->from('type');
        $this->db->join('user_mas', 'user_mas.auid=type.crby');
        if ($stat != 'all') {
            $this->db->where("type.stat=$stat");
        }
    }

    private function typDet_queryData()
    {
        $this->typDet_query();
        $i = 0;
        foreach ($this->cl_srch4 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cl_srch4) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr4[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order4)) {
            $order4 = $this->order4;
            $this->db->order_by(key($order4), $order4[key($order4)]);
        }
    }

    function get_typDtils()
    {
        $this->typDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_typ()
    {
        $this->typDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_typ()
    {
        // $this->db->from($this->table);
        $this->typDet_query();
        return $this->db->count_all_results();
    }
    //END SEARCH TYPE DETAILS </JANAKA 2019-09-27>

    //SEARCH ITEM DETAILS </JANAKA 2019-10-01>
    var $cl_srch5 = array('itcd', 'itnm', 'ctcd', 'bdcd', 'tpcd', 'mdl', 'mlcd'); //set column field database for datatable searchable
    var $cl_odr5 = array(null, 'itcd', 'itnm', 'ctcd', 'bdcd', 'tpcd', 'mdl', 'mlcd', 'item.stat', ''); //set column field database for datatable orderable
    var $order5 = array('item.crdt' => 'DESC'); // default order

    function itmDet_query()
    {
        $cat = $this->input->post('cat');
        $brd = $this->input->post('brd');
        $typ = $this->input->post('typ');
        $dtrg = explode('/', $this->input->post('dtrg'));
        $frdt = trim($dtrg[0], ' ');
        $todt = trim($dtrg[1], ' ');
        $stat = $this->input->post('stat');

        $this->db->select("item.itid,item.itnm,item.itcd,item.mdl,item.mlcd,item.size,item.szof,item.clr,item.clcd,item.stat,item.crdt,item.dscr,
        CONCAT(user_mas.fnme,' ',user_mas.lnme) AS innm,cat.ctcd,cat.ctnm,brd.bdcd,brd.bdnm,typ.tpcd,typ.tpnm");
        $this->db->from('item');
        $this->db->join('user_mas', 'user_mas.auid=item.crby');
        $this->db->join('category cat', 'cat.ctid=item.ctid');
        $this->db->join('brand brd', 'brd.bdid=item.bdid');
        $this->db->join('type typ', 'typ.tpid=item.tpid');
        if ($stat != 'all') {
            $this->db->where("item.stat=$stat");
        }
        if ($cat != 'all') {
            $this->db->where("item.ctid=$cat");
        }
        if ($brd != 'all') {
            $this->db->where("item.bdid=$brd");
        }
        if ($typ != 'all') {
            $this->db->where("item.tpid=$typ");
        }
        $this->db->where("DATE_FORMAT(item.crdt,'%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
    }

    private function itmDet_queryData()
    {
        $this->itmDet_query();
        $i = 0;
        foreach ($this->cl_srch5 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cl_srch5) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr5[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order5)) {
            $order5 = $this->order5;
            $this->db->order_by(key($order5), $order5[key($order5)]);
        }
    }

    function get_itmDtils()
    {
        $this->itmDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_itm()
    {
        $this->itmDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_itm()
    {
        // $this->db->from($this->table);
        $this->itmDet_query();
        return $this->db->count_all_results();
    }
    //END SEARCH ITEM DETAILS </JANAKA 2019-10-01>

    //SEARCH WAREHOUSE DETAILS </JANAKA 2019-10-013>
    var $cl_srch6 = array('whcd', 'whnm', 'mobi', 'addr'); //set column field database for datatable searchable
    var $cl_odr6 = array(null, 'whcd', 'whnm', 'mobi', 'addr', 'cr.fnme', 'wh.crdt', 'wh.stat', ''); //set column field database for datatable orderable
    var $order6 = array('wh.crdt' => 'DESC'); // default order

    function whDet_query()
    {
        $stat = $this->input->post('stat');

        $this->db->select("wh.*,CONCAT(cr.fnme,' ',cr.lnme) AS crnm");
        $this->db->from('stock_wh wh');
        $this->db->join('user_mas cr', 'cr.auid=wh.crby');
        if ($stat != 'all') {
            $this->db->where("wh.stat=$stat");
        }
    }

    private function whDet_queryData()
    {
        $this->whDet_query();
        $i = 0;
        foreach ($this->cl_srch6 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cl_srch6) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr6[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order6)) {
            $order6 = $this->order6;
            $this->db->order_by(key($order6), $order6[key($order6)]);
        }
    }

    function get_whDtils()
    {
        $this->whDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_wh()
    {
        $this->whDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_wh()
    {
        // $this->db->from($this->table);
        $this->whDet_query();
        return $this->db->count_all_results();
    }
    //END SEARCH WAREHOUSE DETAILS </JANAKA 2019-10-03>

    //SEARCH WAREHOUSE DETAILS </JANAKA 2019-10-04>
    var $cl_srch7 = array('pono', 'spnm', 'oddt'); //set column field database for datatable searchable
    var $cl_odr7 = array(null, 'pono', 'spnm', 'oddt', 'totl', 'po.crdt', 'po.stat', ''); //set column field database for datatable orderable
    var $order7 = array('po.crdt' => 'DESC'); // default order

    function poDet_query()
    {
        $stat = $this->input->post('stat');
        $supp = $this->input->post('supp');
        $dtrg = explode('/', $this->input->post('dtrg'));
        $frdt = trim($dtrg[0], ' ');
        $todt = trim($dtrg[1], ' ');

        $this->db->select("po.grnst,po.poid,po.pono,po.oddt,po.stat,po.crdt,po.totl,sp.spid,sp.spnm,sp.spcd");
        $this->db->from('stock_po po');
        $this->db->join('supp_mas sp', 'sp.spid=po.spid');
        if ($stat != 'all') {
            $this->db->where("po.stat=$stat");
        }
        if ($supp != 'all') {
            $this->db->where("po.spid=$supp");
        }
        $this->db->where("DATE_FORMAT(po.crdt,'%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
    }

    private function poDet_queryData()
    {
        $this->poDet_query();
        $i = 0;
        foreach ($this->cl_srch7 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cl_srch7) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr7[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order7)) {
            $order7 = $this->order7;
            $this->db->order_by(key($order7), $order7[key($order7)]);
        }
    }

    function get_poDtils()
    {
        $this->poDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_po()
    {
        $this->poDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_po()
    {
        // $this->db->from($this->table);
        $this->poDet_query();
        return $this->db->count_all_results();
    }
    //END SEARCH WAREHOUSE DETAILS </JANAKA 2019-10-04>

    //QUANTITY STATUS OF ITEMS
    function qty_status()
    {
        $id = $this->input->post('item');
        $this->db->select("item.mxlv,
        IFNULL((SELECT SUM(stock_po_des.qnty) FROM stock_po 
            JOIN stock_po_des ON stock_po_des.poid=stock_po.poid 
            WHERE stock_po_des.itid=item.itid AND stock_po.stat=0),0) AS penpoqty,
        IFNULL((SELECT SUM(stock_po_des.qnty) FROM stock_po 
            JOIN stock_po_des ON stock_po_des.poid=stock_po.poid 
            WHERE stock_po_des.itid=item.itid AND stock_po.stat=1 AND grnst=0),0) AS togrnqty,
        IFNULL((SELECT SUM(stock_grn_des.qnty+stock_grn_des.frqt) FROM stock_grn 
            JOIN stock_grn_des ON stock_grn_des.grid=stock_grn.grid
            WHERE stock_grn_des.itid=item.itid AND stock_grn.stat=0),0) AS pengrnqty,
        IFNULL((SELECT SUM(stock_grn_des.qnty+stock_grn_des.frqt) FROM stock_grn 
            JOIN stock_grn_des ON stock_grn_des.grid=stock_grn.grid
            WHERE stock_grn_des.itid=item.itid AND stock_grn.stat=1 AND stock_grn.stst=0),0) AS tostqty,
        IFNULL((SELECT SUM(qunt+frqt) FROM stock WHERE stock.stat=0),0) AS penstqty,
        IFNULL((SELECT SUM(avqn) FROM stock WHERE stock.itid=item.itid AND stock.stat=1),0) AS avstqty
        ");
        $this->db->from('item');
        $this->db->where('item.itid', $id);
        $res = $this->db->get()->result();
        return $res;
    }

    //SEARCH GRN DETAILS
    var $cl_srch8 = array('spcd', 'spnm', 'addr', 'mbno', 'tele', 'email'); //set column field database for datatable searchable
    var $cl_odr8 = array(null, 'spcd', 'spnm', 'addr', 'mbno', 'user_mas.fnme', 'crdt', 'stat', ''); //set column field database for datatable orderable
    var $order8 = array('crdt' => 'DESC'); // default order

    function grnDet_query()
    {
        $stat = $this->input->post('stat');
        $supl = $this->input->post('supl');
        $dtrg = explode('/', $this->input->post('dtrng'));
        $frdt = trim($dtrg[0], ' ');
        $todt = trim($dtrg[1], ' ');

        $this->db->select("stock_grn.*, supp_mas.spnm, stock_po.pono,  CONCAT(user_mas.usnm) AS exc, DATE_FORMAT(stock_grn.crdt, '%Y-%m-%d') AS crdt,
        IFNULL(stock_grn.rcqt,0) AS rcqt, IFNULL(stock_grn.frqt,0) AS frqt, IFNULL(stock_grn.rtqt,0) AS rtqt");
        $this->db->from("stock_grn");
        $this->db->join('stock_po', 'stock_po.poid = stock_grn.poid ');
        $this->db->join('supp_mas', 'supp_mas.spid = stock_grn.spid ');
        $this->db->join('user_mas', 'user_mas.auid = stock_po.crby ');

        if ($supl != 'all') {
            $this->db->where('stock_grn.spid', $supl);
        }
        if ($stat != 'all') {
            $this->db->where('stock_grn.stat', $stat);
        }
        $this->db->where(" stock_grn.grdt BETWEEN '$frdt' AND '$todt'");
    }

    private function grnDet_queryData()
    {
        $this->grnDet_query();
        $i = 0;
        foreach ($this->cl_srch8 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cl_srch8) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr8[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order8)) {
            $order8 = $this->order8;
            $this->db->order_by(key($order8), $order8[key($order8)]);
        }
    }

    function get_grnDtils()
    {
        $this->grnDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_grn()
    {
        $this->grnDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_grn()
    {
        $this->grnDet_query();
        return $this->db->count_all_results();
    }
    //END SEARCH

    //STOCK
    var $cl_srch9 = array('stcd', 'spnm', 'itnm', 'itcd'); //set column field database for datatable searchable
    var $cl_odr9 = array(null, 'stcd', 'spnm', 'itnm', 'csvl', 'fcvl', 'slvl', 'qunt', 'frqt', 'avqt', 'crdt', 'stat', ''); //set column field database for datatable orderable
    var $order9 = array('stk.crdt' => 'desc'); // default order

    function mnStock_query()
    {
        $cat = $this->input->post('cat'); // CATEGORY
        $brnd = $this->input->post('brnd'); // BRAND
        $typ = $this->input->post('typ'); // TYPE
        $stat = $this->input->post('stat'); // Stat
        $dtrng = explode('/', $this->input->post('dtrng')); // DateRange
        $frdt = trim($dtrng[0], ' ');
        $todt = trim($dtrng[1], ' ');

        $this->db->select("stk.*, item.itcd,item.itnm,sp.spnm,CONCAT(cr.fnme,' ',cr.lnme) AS exc, DATE_FORMAT(stk.crdt, '%Y-%m-%d') AS crdtf");
        $this->db->from("stock stk");
        $this->db->join('item', 'item.itid = stk.itid');
        $this->db->join('supp_mas sp', 'sp.spid = stk.spid ');
        $this->db->join('user_mas cr', 'cr.auid = stk.crby ');

        if ($cat != 'all') {
            $this->db->where('item.ctid', $cat);
        }
        if ($brnd != 'all') {
            $this->db->where('item.bdid', $brnd);
        }
        if ($typ != 'all') {
            $this->db->where('item.tpid', $typ);
        }
        if ($stat != 'all') {
            $this->db->where('stk.stat', $stat);
        }

        $this->db->where("DATE_FORMAT(stk.crdt,'%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
    }

    private function mnStock_queryData()
    {
        $this->mnStock_query();
        $i = 0;
        foreach ($this->cl_srch9 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cl_srch9) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr9[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order9)) {
            $order9 = $this->order9;
            $this->db->order_by(key($order9), $order9[key($order9)]);
        }
    }

    function get_mnStock()
    {
        $this->mnStock_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_mnStock()
    {
        $this->mnStock_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_mnStock()
    {
        $this->mnStock_query();
        return $this->db->count_all_results();
    }

// END HIRE STOCK

//CONVERTION STOCK </2019-10-15>
    var $cl_srch10 = array('stcd', 'spnm', 'itnm', 'itcd'); //set column field database for datatable searchable
    var $cl_odr10 = array(null, 'stcd', 'spnm', 'itnm', 'csvl', 'fcvl', 'slvl', 'qunt', 'avqt', 'crdt', 'stat', ''); //set column field database for datatable orderable
    var $order10 = array('stk.crdt' => 'desc'); // default order

    function sbcStock_query()
    {
        $brch = $this->input->post('brch'); // Branch
        $item = $this->input->post('item'); // Item
        $stat = $this->input->post('stat'); // Stat
        $dtrng = explode('/', $this->input->post('dtrng')); // DateRange
        $frdt = trim($dtrng[0], ' ');
        $todt = trim($dtrng[1], ' ');

        $this->db->select("stk.*, item.itcd,item.itnm,CONCAT(cr.fnme,' ',cr.lnme) AS exc, DATE_FORMAT(stk.crdt, '%Y-%m-%d') AS crdtf,
        bm.brcd,bm.brnm");
        $this->db->from("stock_brn stk");
        $this->db->join('brch_mas bm', 'bm.brid = stk.brid');
        $this->db->join('item', 'item.itid = stk.itid');
        $this->db->join('user_mas cr', 'cr.auid = stk.crby ');

        if ($brch != 'all') {
            $this->db->where('stk.brid', $brch);
        }
        if ($item != 'all') {
            $this->db->where('stk.itid', $item);
        }
        if ($stat != 'all') {
            $this->db->where('stk.stat', $stat);
        }

        $this->db->where("DATE_FORMAT(stk.crdt,'%Y-%m-%d') BETWEEN '$frdt' AND '$todt' AND stk.cst=1");
    }

    private function sbcStock_queryData()
    {
        $this->sbcStock_query();
        $i = 0;
        foreach ($this->cl_srch10 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cl_srch10) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr10[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order10)) {
            $order10 = $this->order10;
            $this->db->order_by(key($order10), $order10[key($order10)]);
        }
    }

    function get_sbcStock()
    {
        $this->sbcStock_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_sbcStock()
    {
        $this->sbcStock_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_sbcStock()
    {
        $this->sbcStock_query();
        return $this->db->count_all_results();
    }

    //END CONVERTION STOCK </2019-10-15>

    //REQUEST STOCK </2019-10-18>
    function getReqDet(){
        $id = $this->input->post('id');

        $this->db->select("rq.rqno,rq.rqfr,rq.stat,rq.crdt,rq.apdt,rq.mddt,rq.rjdt,rq.isrdt,rq.redt,rq.rsbc,rq.rrbc,rq.rmk,
        bm.brcd AS rsbrcd, bm.brnm AS rsbrnm,
        bm2.brcd AS rrbrcd, bm2.brnm AS rrbrnm,
        wh.whcd,wh.whnm, CONCAT(cr.fnme,' ',cr.lnme) AS crnm,
        CONCAT(ap.fnme,' ',ap.lnme) AS apnm,CONCAT(md.fnme,' ',md.lnme) AS mdnm, CONCAT(rj.fnme,' ',rj.lnme) AS rjnm,
        CONCAT(isr.fnme,' ',isr.lnme) AS isrnm,CONCAT(re.fnme,' ',re.lnme) AS renm");
        $this->db->from('stock_req rq');
        $this->db->join('brch_mas bm', 'bm.brid = rq.rsbc');
        $this->db->join('brch_mas bm2','bm2.brid = rq.rrbc','LEFT');
        $this->db->join('stock_wh wh','wh.whid = rq.rrbc','LEFT');
        $this->db->join('user_mas cr', 'cr.auid = rq.crby ');
        $this->db->join('user_mas ap', 'ap.auid=rq.apby', 'LEFT');
        $this->db->join('user_mas md', 'md.auid=rq.mdby', 'LEFT');
        $this->db->join('user_mas rj', 'rj.auid=rq.rjby', 'LEFT');
        $this->db->join('user_mas isr', 'isr.auid=rq.isrby', 'LEFT');
        $this->db->join('user_mas re', 're.auid=rq.reby', 'LEFT');
        $this->db->where('rq.rqid',$id);
        return $this->db->get()->result();
    }
    function getReqSubDet(){
        $id = $this->input->post('id'); //Request ID
        $rqfr = $this->input->post('rqfr'); //Request From 1-Warehouse / 2- Branch
        $rrbc = $this->input->post('rrbc'); //Request Receiver

        $this->db->select("stc.ascnt,stc.avqn,stc.stid,stc.stcd,stc.csvl,stc.fcvl,stc.slvl,stc.mkvl,
        IFNULL((SELECT sb3.asqty FROM stock_req_sub2 sb3 WHERE sb3.stat IN(1,2,3) AND sb3.rqid=rqs.rqid AND sb3.stid=stc.stid),0) AS thsAsCnt,
        (SELECT sb4.inpr FROM stock_req_sub2 sb4 WHERE sb4.stat IN(1,2,3) AND sb4.rqid=rqs.rqid AND sb4.stid=stc.stid) AS isInpr,
        (SELECT sb5.inid FROM stock_req_sub2 sb5 WHERE sb5.stat IN(1,2,3) AND sb5.rqid=rqs.rqid AND sb5.stid=stc.stid) AS inid,
        (SELECT sb6.auid FROM stock_req_sub2 sb6 WHERE sb6.stat IN(1,2,3) AND sb6.rqid=rqs.rqid AND sb6.stid=stc.stid) AS sb2id,
        rqs.auid,rqs.itid,rqs.reqty,rqs.stat,rqs.crdt,rqs.stat,
        it.itcd,it.itnm,it.mdl,it.mlcd,sc.scl,sc.scnm,
        ");
        $this->db->from('stock_req_sub rqs');
        $this->db->join('item it', 'it.itid=rqs.itid');
        $this->db->join('scale sc', 'sc.slid=it.scli');
        if ($rqfr == 1) {
            $this->db->join('(SELECT stcd,avqn,stid,itid,csvl,fcvl,slvl,mkvl,
             IFNULL((SELECT SUM(sb2.asqty) FROM stock_req_sub2 sb2 
                JOIN stock_req_sub sb ON sb.auid = sb2.sbid
                WHERE sb2.stid=stock.stid AND sb2.stat IN(1,2) AND sb2.sttp=1 AND sb.stat=3),0) AS ascnt
             FROM stock WHERE stock.stat=1 AND stock.whid=' . $rrbc . ') stc', 'stc.itid=rqs.itid', 'LEFT');
        } else {
            $this->db->join('(SELECT stcd,avqn,stbid AS stid,itid,csvl,fcvl,slvl,mkvl,
             IFNULL((SELECT SUM(sb2.asqty) FROM stock_req_sub2 sb2 
                JOIN stock_req_sub sb ON sb.auid = sb2.sbid
                JOIN stock_req rq ON rq.rqid = sb.rqid WHERE sb2.stat IN(1,2) AND sb2.stid=stock_brn.stbid AND rq.rqfr=2 AND sb.stat=3),0) AS ascnt
             FROM stock_brn WHERE stock_brn.stat=1 AND stock_brn.brid=' . $rrbc . ') stc', 'stc.itid=rqs.itid', 'LEFT');
        }
        $this->db->where("rqs.rqid=$id AND rqs.stat!=6");
        return $this->db->get()->result();
    }

    var $cl_srch11 = array('rqno', 'bm.brnm', 'bm2.rrbrnm', 'str.crdt', 'str.stat'); //set column field database for datatable searchable
    var $cl_odr11 = array(null, 'rqno', 'bm.brnm', 'bm2.rrbrnm', '', '', 'str.crdt', '', ''); //set column field database for datatable orderable
    var $order11 = array('str.crdt' => 'desc'); // default order

    function ReqStock_query()
    {
        $rqfr = $this->input->post('rqfr');
        $rqbr = $this->input->post('rqbr');
        $rcbr = $this->input->post('rcbr');
        $rcwh = $this->input->post('rcwh');
        $stat = $this->input->post('stat');
        $mode = $this->input->post('mode');
        $dtrng = explode('/', $this->input->post('dtrg')); // DateRange
        $frdt = trim($dtrng[0], ' ');
        $todt = trim($dtrng[1], ' ');

        $this->db->select("str.rqid,str.rqno,str.rqfr,str.stat,str.crdt,bm.brcd AS rsbrcd, bm.brnm AS rsbrnm,
        bm2.rrbrcd,bm2.rrbrnm,
        (SELECT COUNT(rqs.auid) FROM stock_req_sub rqs JOIN stock_req_sub2 sb2 ON sb2.sbid=rqs.auid
            WHERE rqs.rqid=str.rqid AND rqs.stat=3 AND sb2.inpr=0 AND sb2.stat=1) AS inpcnt,
        IFNULL((SELECT rqin.inid FROM stock_req_sub2 sb3 JOIN stock_req_in rqin ON rqin.inid=sb3.inid 
            WHERE sb3.stat=1 AND rqin.stat=1 AND sb3.rqid=str.rqid ORDER BY rqin.inid DESC LIMIT 1),0) AS lstInid,
        (SELECT COUNT(rqs.auid) FROM stock_req_sub rqs WHERE rqs.rqid=str.rqid AND rqs.stat!=6) AS cnt,
        (SELECT COUNT(rqs.auid) FROM stock_req_sub rqs WHERE rqs.rqid=str.rqid AND rqs.stat IN(4,5)) AS iscnt,
        (SELECT COUNT(rqs.auid) FROM stock_req_sub rqs JOIN stock_req_sub2 sbb ON sbb.sbid=rqs.auid WHERE rqs.rqid=str.rqid AND rqs.stat IN(4,5) AND sbb.stat=2) AS niscnt,
        (SELECT COUNT(rqs.auid) FROM stock_req_sub rqs WHERE rqs.rqid=str.rqid AND rqs.stat=2) AS rjcnt,
        (SELECT COUNT(rqs.auid) FROM stock_req_sub rqs WHERE rqs.rqid=str.rqid AND rqs.stat IN(3,4)) AS ascnt,
        (SELECT COUNT(rqs.auid) FROM stock_req_sub rqs WHERE rqs.rqid=str.rqid AND rqs.stat=5) AS rccnt");
        $this->db->from("stock_req str");
        $this->db->join('brch_mas bm', 'bm.brid = str.rsbc');
        if ($rqfr == 'true') {
            $this->db->join('(SELECT whnm AS rrbrnm, whcd AS rrbrcd,whid FROM stock_wh) bm2', 'bm2.whid = str.rrbc');
            if ($rcwh != 'all') {
                $this->db->where('str.rrbc', $rcwh);
            }
            $this->db->where('str.rqfr', 1);
        } else {
            $this->db->join('(SELECT brnm AS rrbrnm, brcd AS rrbrcd,brid FROM brch_mas) bm2', 'bm2.brid = str.rrbc');
            if ($rcbr != 'all') {
                $this->db->where('str.rrbc', $rcbr);
            }
            $this->db->where('str.rqfr', 2);
        }
        if ($rqbr != 'all') {
            $this->db->where('str.rsbc', $rqbr);
        }
        if ($stat != 'all') {
            $this->db->where('str.stat', $stat);
        }
        if ($mode == 2) {
            $this->db->where("str.stat NOT IN(0,2)");
        }

        $this->db->where("DATE_FORMAT(str.crdt,'%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
    }

    private function ReqStock_queryData()
    {
        $this->ReqStock_query();
        $i = 0;
        foreach ($this->cl_srch11 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cl_srch11) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr11[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order11)) {
            $order11 = $this->order11;
            $this->db->order_by(key($order11), $order11[key($order11)]);
        }
    }

    function get_ReqStock()
    {
        $this->ReqStock_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_ReqStock()
    {
        $this->ReqStock_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_ReqStock()
    {
        $this->ReqStock_query();
        return $this->db->count_all_results();
    }

    //END CONVERTION STOCK </2019-10-18>

//    GET ISSUED NOTES </2019-10-25>
    var $cl_srch12 = array('inno', 'drnm', 'vno', 'mbno', 'crnm', 'rqin.crdt'); //set column field database for datatable searchable
    var $cl_odr12 = array(null, 'inno', 'drnm', 'vno', 'mbno', 'crnm', 'rqin.crdt', ''); //set column field database for datatable orderable
    var $order12 = array('rqin.crdt' => 'DESC'); // default order

    function issNotes_query()
    {
        $isfr = $this->input->post('isfr');
        $isbr = $this->input->post('isbr');
        $iswh = $this->input->post('iswh');
        $dtrng = explode('/', $this->input->post('dtrg')); // DateRange
        $frdt = trim($dtrng[0], ' ');
        $todt = trim($dtrng[1], ' ');

        $this->db->select("rqin.*,CONCAT(cr.fnme,' ',cr.lnme) AS crnm");
        $this->db->from('stock_req_in rqin');
        $this->db->join('stock_req_sub2 sb2','sb2.inid=rqin.inid');
        $this->db->join('stock_req rq','rq.rqid=sb2.rqid');
        $this->db->join('user_mas cr','cr.auid=rqin.crby');
        if ($isfr == 'true') {
            if($iswh!='all'){
                $this->db->where('rq.rsbc',$iswh);
            }
            $this->db->where('rq.rqfr',1);
        }else{
            if($isbr!='all') {
                $this->db->where('rq.rsbc',$isbr);
            }
            $this->db->where('rq.rqfr',2);
        }
        $this->db->where("DATE_FORMAT(rqin.crdt,'%Y-%m-%d') BETWEEN '$frdt' AND '$todt'");
        $this->db->group_by('rqin.inid');
    }

    private function issNotes_queryData()
    {
        $this->issNotes_query();
        $i = 0;
        foreach ($this->cl_srch12 as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cl_srch12) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->cl_odr12[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order12)) {
            $order12 = $this->order12;
            $this->db->order_by(key($order12), $order12[key($order12)]);
        }
    }

    function get_issNotes()
    {
        $this->issNotes_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_issNotes()
    {
        $this->issNotes_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_issNotes()
    {
        $this->issNotes_query();
        return $this->db->count_all_results();
    }
//   END GET ISSUED NOTES </2019-10-25>
}

?>