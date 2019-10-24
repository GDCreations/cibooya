<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    // System Message
    var $cl_srch7 = array('', '', ''); //set column field database for datatable searchable
    var $cl_odr7 = array(null, 'cmtp', 'cmtp', 'cmtp', 'cmtp', 'cmtp', 'cmtp', '', ''); //set column field database for datatable orderable
    var $order7 = array('cnnm' => 'asc'); // default order

    function systmMsg_query()
    {
        $dteRng = $this->input->post('dteRng');
        $dteRng2 = explode("/", $dteRng);
        $frdt = trim($dteRng2[0], ' ');
        $todt = trim($dteRng2[1], ' ');

        $this->db->select("syst_mesg.*, user_mas.usnm, user_level.lvnm, us.usnm AS crby, IF(cmtp = 0,'All User',IF(cmtp =1,'User Level',IF(cmtp=2,'User','--'))) AS msgTp, IF(swnt = 1,'Yes','No') AS ntfy ");
        $this->db->from("syst_mesg");
        $this->db->join('user_mas', 'user_mas.auid = syst_mesg.mgus', 'left');
        $this->db->join('user_mas us', 'us.auid = syst_mesg.crby', 'left');
        $this->db->join('user_level', 'user_level.id = syst_mesg.uslv', 'left');
        $this->db->where("DATE_FORMAT(syst_mesg.crdt, '%Y-%m-%d') BETWEEN '$frdt' AND  '$todt' ");
    }

    private function systmMsg_queryData()
    {
        $this->systmMsg_query();
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

    function get_systmMsg()
    {
        $this->systmMsg_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function filtered_systmMsg()
    {
        $this->systmMsg_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function all_systmMsg()
    {
        $this->systmMsg_query();
        return $this->db->count_all_results();
    }
//  End

// SEARCH DETAILS
    var $cl_srch8 = array('spcd', 'spnm', 'addr', 'mbno', 'tele', 'email'); //set column field database for datatable searchable
    var $cl_odr8 = array(null, 'spcd', 'spnm', 'addr', 'mbno', 'user_mas.fnme', 'crdt', 'stat', ''); //set column field database for datatable orderable
    var $order8 = array('crdt' => 'DESC'); // default order

    function custDet_query()
    {
        $stat = $this->input->post('stat');

        $this->db->select("cus_mas.*,CONCAT(user_mas.fnme,' ',user_mas.lnme) AS innm");
        $this->db->from('cus_mas');
        $this->db->join('user_mas', 'user_mas.auid=cus_mas.crby');
        if ($stat != 'all') {
            $this->db->where("cus_mas.stat", $stat);
        }
    }

    private function custDet_queryData()
    {
        $this->custDet_query();
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

    function get_custDtils()
    {
        $this->custDet_queryData();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_cust()
    {
        $this->custDet_queryData();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_cust()
    {
        $this->custDet_query();
        return $this->db->count_all_results();
    }
// END SEARCH DETAILS


}

?>