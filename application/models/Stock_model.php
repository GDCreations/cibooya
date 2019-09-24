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
}

?>