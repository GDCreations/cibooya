<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    // Recent activity
    var $cl_srch7 = array('pnm', 'func', 'lgdt'); //set column field database for datatable searchable
    var $cl_odr7 = array(null, 'fnme', 'pnm', 'lgdt'); //set column field database for datatable orderable
    var $order7 = array('cnnm' => 'asc'); // default order

    function recnt_query()
    {
        $brn = $this->input->post('brn');
        $usr = $this->input->post('user');
        $act = $this->input->post('act');
        $frdt = $this->input->post('frdt');
        $todt = $this->input->post('todt');

        $this->db->select("user_log.*,user_mas.uimg,user_mas.usnm,brch_mas.brcd");
        $this->db->from("user_log");
        $this->db->join('user_mas', 'user_mas.auid = user_log.usid');
        $this->db->join('brch_mas', 'brch_mas.brid = user_mas.brch');
        $this->db->where("DATE_FORMAT(user_log.lgdt, '%d-%m-%Y') BETWEEN '$frdt' AND  '$todt' ");

        if ($brn != 'all') {
            $this->db->where('user_mas.brch ', $brn);
        }
        if ($usr != 'all') {
            $this->db->where('user_log.usid ', $usr);
        }
        /*if ($act != 'all') {
            $this->db->like('user_log.func', $act, 'both');
            // Produces: WHERE title LIKE '%match%'
        }*/
        if ($_SESSION['role'] != 1) {
            $this->db->where('user_mas.usmd != 1 ');
        }
    }

    private function recnt_queryData()
    {
        $this->recnt_query();
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

    function get_recntDtils()
    {
        $this->recnt_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function filtered_recnt()
    {
        $this->recnt_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function all_recnt()
    {
        $this->recnt_query();
        return $this->db->count_all_results();
    }

//  End Recent activity

//SEARCH BRANCH DETAILS
    var $cl_srch8 = array('spcd', 'spnm', 'addr', 'mbno', 'tele', 'email'); //set column field database for datatable searchable
    var $cl_odr8 = array(null, 'spcd', 'spnm', 'addr', 'mbno', 'user_mas.innm', 'crdt', 'stat', ''); //set column field database for datatable orderable
    var $order8 = array('crdt' => 'DESC'); // default order

    function brnDet_query()
    {
        $stat = $this->input->post('stat');

        $this->db->select("brch_mas.*, user_mas.usnm ");
        $this->db->from('brch_mas');
        $this->db->join('user_mas', 'user_mas.auid=brch_mas.crby');
        if ($stat != 'all') {
            $this->db->where("brch_mas.stat", $stat);
        }
    }

    private function brnDet_queryData()
    {
        $this->brnDet_query();
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

    function get_brnDtils()
    {
        $this->brnDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_brn()
    {
        $this->brnDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_brn()
    {
        $this->brnDet_query();
        return $this->db->count_all_results();
    }
    //END SEARCH BRANCH
}

?>