<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stock_model extends CI_Model
{
    //SEARCH SUPPLIER DETAILS </JANAKA 2019-09-19>
    var $cl_srch1 = array('spcd','spnm','addr','mbno','tele','email'); //set column field database for datatable searchable
    var $cl_odr1 = array(null, 'spcd', 'spnm', 'addr', 'mbno', 'user_mas.innm', 'crdt', 'stat',''); //set column field database for datatable orderable
    var $order1 = array('crdt' => 'DESC'); // default order

    function suppDet_query()
    {
        $stat = $this->input->post('stat');

        $this->db->select("supp_mas.*,user_mas.innm");
        $this->db->from('supp_mas');
        $this->db->join('user_mas','user_mas.auid=supp_mas.crby');
        if($stat!='all'){
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
    var $cl_srch2 = array('ctcd','ctnm'); //set column field database for datatable searchable
    var $cl_odr2 = array(null, 'ctcd', 'ctnm', 'user_mas.innm', 'crdt', 'stat',''); //set column field database for datatable orderable
    var $order2 = array('crdt' => 'DESC'); // default order

    function catDet_query()
    {
        $stat = $this->input->post('stat');

        $this->db->select("category.*,user_mas.innm");
        $this->db->from('category');
        $this->db->join('user_mas','user_mas.auid=category.crby');
        if($stat!='all'){
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
    var $cl_srch3 = array('bdcd','bdnm'); //set column field database for datatable searchable
    var $cl_odr3 = array(null, 'bdcd','','bdnm', 'user_mas.innm', 'crdt', 'stat',''); //set column field database for datatable orderable
    var $order3 = array('crdt' => 'DESC'); // default order

    function brdDet_query()
    {
        $stat = $this->input->post('stat');

        $this->db->select("brand.*,user_mas.innm");
        $this->db->from('brand');
        $this->db->join('user_mas','user_mas.auid=brand.crby');
        if($stat!='all'){
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
    var $cl_srch4 = array('tpcd','tpnm'); //set column field database for datatable searchable
    var $cl_odr4 = array(null, 'tpcd','tpnm', 'user_mas.innm', 'crdt', 'stat',''); //set column field database for datatable orderable
    var $order4 = array('crdt' => 'DESC'); // default order

    function typDet_query()
    {
        $stat = $this->input->post('stat');

        $this->db->select("type.*,user_mas.innm");
        $this->db->from('type');
        $this->db->join('user_mas','user_mas.auid=type.crby');
        if($stat!='all'){
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
    var $cl_srch5 = array('itcd','itnm','ctcd','bdcd','tpcd','mdl','mlcd'); //set column field database for datatable searchable
    var $cl_odr5 = array(null, 'itcd','itnm','ctcd','bdcd','tpcd','mdl','mlcd','item.stat',''); //set column field database for datatable orderable
    var $order5 = array('item.crdt' => 'DESC'); // default order

    function itmDet_query()
    {
        $cat = $this->input->post('cat');
        $brd = $this->input->post('brd');
        $typ = $this->input->post('typ');
        $dtrg = explode('/',$this->input->post('dtrg'));
        $frdt = trim($dtrg[0],' ');
        $todt = trim($dtrg[1],' ');
        $stat = $this->input->post('stat');

        $this->db->select("item.itid,item.itnm,item.itcd,item.mdl,item.mlcd,item.size,item.szof,item.clr,item.clcd,item.stat,item.crdt,item.dscr,
        user_mas.innm,cat.ctcd,cat.ctnm,brd.bdcd,brd.bdnm,typ.tpcd,typ.tpnm");
        $this->db->from('item');
        $this->db->join('user_mas','user_mas.auid=item.crby');
        $this->db->join('category cat','cat.ctid=item.ctid');
        $this->db->join('brand brd','brd.bdid=item.bdid');
        $this->db->join('type typ','typ.tpid=item.tpid');
        if($stat!='all'){
            $this->db->where("item.stat=$stat");
        }
        if($cat!='all'){
            $this->db->where("item.ctid=$cat");
        }
        if($brd!='all'){
            $this->db->where("item.bdid=$brd");
        }
        if($typ!='all'){
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
    var $cl_srch6 = array('whcd','whnm','mobi','addr'); //set column field database for datatable searchable
    var $cl_odr6 = array(null, 'whcd','whnm','mobi','addr','cr.fnme','wh.crdt','wh.stat',''); //set column field database for datatable orderable
    var $order6 = array('wh.crdt' => 'DESC'); // default order

    function whDet_query()
    {
        $stat = $this->input->post('stat');

        $this->db->select("wh.*,CONCAT(cr.fnme,' ',cr.lnme) AS crnm");
        $this->db->from('stock_wh wh');
        $this->db->join('user_mas cr','cr.auid=wh.crby');
        if($stat!='all'){
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
}

?>