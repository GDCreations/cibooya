<?php

class Generic_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();

    }

    //makes this to work with columns and without where,limit and offset
    function getData($tablename = '', $columns_arr = array(), $where_arr = array(), $limit = 0, $offset = 0)
    {
        $limit = ($limit == 0) ? Null : $limit;

        if (!empty($columns_arr)) {
            $this->db->select(implode(',', $columns_arr), FALSE);
        }

        if ($tablename == '') {
            return array();
        } else {
            $this->db->from($tablename);

            if (!empty($where_arr)) {
                $this->db->where($where_arr);
            }

            if ($limit > 0 AND $offset > 0) {
                $this->db->limit($limit, $offset);
            } elseif ($limit > 0 AND $offset == 0) {
                $this->db->limit($limit);
            }

            $query = $this->db->get();

            return $query->result();
        }
    }

    // GET ORDERING DATA
    function getSortData($tablename = '', $columns_arr = array(), $where_arr = array(), $limit = 0, $offset = 0, $orderby = '', $order = 'ASC')
    {
        ini_set('MAX_EXECUTION_TIME', -1);
        $limit = ($limit == 0) ? Null : $limit;

        if (!empty($columns_arr)) {
            $this->db->select(implode(',', $columns_arr), FALSE);
        }

        if ($tablename == '') {
            return array();
        } else {
            $this->db->from($tablename);

            if (!empty($where_arr)) {
                $this->db->where($where_arr);
            }
            $this->db->order_by($orderby, $order); // or 'DESC'

            if ($limit > 0 AND $offset > 0) {
                $this->db->limit($limit, $offset);
            } elseif ($limit > 0 AND $offset == 0) {
                $this->db->limit($limit);
            }

            $query = $this->db->get();

            return $query->result();
        }
    }

    public function get_user()
    {
        if (!empty($this->session->userdata('userId'))) {
            $id = $this->session->userdata('userId');

            $this->db->select('*');
            $this->db->from('user u');
            $this->db->join('user_level ul', 'ul.id = u.user_level');
            $this->db->join('branch_details b', 'b.branch_id = u.branch');
            $this->db->join('gender g', 'g.idgender = u.gender');
            $this->db->join('civil_status c', 'c.cs_id = u.civil_status');
            $this->db->where('u.user_id', $id);
            $query = $this->db->get();
            return $query->result();
        }
    }


    function getDataOr($tablename = '', $columns_arr = array(), $where_arr = array(), $limit = 0, $offset = 0)
    {
        $limit = ($limit == 0) ? Null : $limit;

        if (!empty($columns_arr)) {
            $this->db->select(implode(',', $columns_arr), FALSE);
        }

        if ($tablename == '') {
            return array();
        } else {
            $this->db->from($tablename);

            if (!empty($where_arr)) {
                $this->db->or_where($where_arr); //Or operator added here
            }

            if ($limit > 0 AND $offset > 0) {
                $this->db->limit($limit, $offset);
            } elseif ($limit > 0 AND $offset == 0) {
                $this->db->limit($limit);
            } elseif ($limit == 0 AND $offset > 0) {
                $this->db->limit(0, $offset);
            }

            $query = $this->db->get();

            return $query->result();
        }
    }

    function getSetting($settingCode = '')
    {
        $settingValue = '';
        $retData = array();
        if ($settingCode == '') {
            $settingValue = '';
        } else {
            $retData = $this->getData('TBL_SETTINGS', array('setting_value'), array('setting_code' => $settingCode), 1);
            if (count($retData) > 0) {
                $settingValue = $retData[0]->setting_value;
            } else {
                $settingValue = '';
            }
        }
        return $settingValue;
    }

    function insertData($tablename, $data_arr = array())
    {
        //SET IDENTITY_INSERT $tablename ON

        //$trno = $this->getNextSerialNumber('logtrno');
        $ret = 0;
        //$userdata = $this->current_user->id;
        //$data_arr['created_user'] = $userdata;
        $action = "Insert";
        try {
            //$data_arr['CREATED_USER'] = $userdata->id;
            // $this->db->insert($tablename, $data_arr);
            //$ret = $this->db->insert_id() + 0;
            // write($tablename, $data_arr, $action) {

            //$this->Log_model->write($tablename, $data_arr, $action, '');  // user back log
            //$this->Log_model->write($tablename, $data_arr, $action, $trno);
            //$this->Generic_model->increaseSerialNumber('logtrno');

            $this->db->insert($tablename, $data_arr);
            return $ret;
        } catch (Exception $err) {

            $this->Log_model->ErrorLogNew($tablename, $err->getMessage(), $action);   // ERROR LOG NEW FUNCTION
            //$this->Generic_model->increaseSerialNumber('logtrno');
            return $err->getMessage();
        }
    }

    function insertDataWS($tablename, $data_arr = array())
    {
        //SET IDENTITY_INSERT $tablename ON

        $ret = 0;
        $userdata = $this->current_user->id;
        $data_arr['created_user'] = $userdata;
        $action = "Insert";
        try {
            //$data_arr['CREATED_USER'] = $userdata->id;
            $this->db->insert($tablename, $data_arr);
            $ret = $this->db->insert_id() + 0;
            // write($tablename, $data_arr, $action) {

            return $ret;
        } catch (Exception $err) {

            return $err->getMessage();
        }
    }

    function updateData($tablename, $data_arr, $where_arr)
    {
        //SET IDENTITY_INSERT $tablename ON
        //  $trno = $this->getNextSerialNumber('logtrno');
        $action = "Update";
        try {
            $result = $this->db->update($tablename, $data_arr, $where_arr);
            //$this->Log_model->write($tablename, $data_arr, $action, $where_arr);

            $report = array();
            $report['error'] = $this->db->error();
            $report['message'] = $this->db->error();
            return $result;

        } catch (Exception $err) {
            $this->Log_model->ErrorLogNew($tablename, $err->getMessage(), $action);  // ERROR LOG NEW FUNCTION
            return $err->getMessage();
        }
    }

    function updateDataWS($tablename, $data_arr, $where_arr)
    {
        //SET IDENTITY_INSERT $tablename ON
        $action = "Update";
        try {
            $result = $this->db->update($tablename, $data_arr, $where_arr);

            $report = array();
            $report['error'] = $this->db->error();
            $report['message'] = $this->db->error();
            return $result;
        } catch (Exception $err) {

            return $err->getMessage();
        }
    }

    function updateDataWithoutlog($tablename, $data_arr, $where_arr)
    {
        //SET IDENTITY_INSERT $tablename ON

        $action = "Update";
        try {
            $result = $this->db->update($tablename, $data_arr, $where_arr);

            $report['error'] = $this->db->error();
            $report['message'] = $this->db->error();
            return $result;
        } catch (Exception $err) {

            return $err->getMessage();
        }
    }

    function updateMultipleData($tablename, $data_arr, $keyColumn, $trno = Null)
    {
        $action = "M Update";
        try {
            // write($tablename, $data_arr, $action) {
            if (isset($trnno)) {
                $this->Log_model->write($tablename, $data_arr, $action, $trno);
            }
            return $this->db->update_batch($tablename, $data_arr, $keyColumn);
        } catch (Exception $err) {
            if (isset($trnno)) {
                $this->Log_model->write($tablename, $data_arr, $action, $trno);
            }
            return $err->getMessage();
        }
    }

    function deleteData($tablename, $where_arr)
    {
        try {
            $this->db->where($where_arr, NULL, FALSE);
            $result = $this->db->delete($tablename);
        } catch (Exception $err) {
            $result = $err->getMessage();
        }
        return $result;
    }

    function deleteMultipleData($tablename, $value_arr, $keyColumn, $trno = Null)
    {
        $action = "M Delete";
        try {
            // write($tablename, $data_arr, $action) {
            if (isset($trnno)) {
                $this->Log_model->write($tablename, $value_arr, $action, $trno);
            }
            $this->db->where_in($keyColumn, $value_arr);
            $result = $this->db->delete($tablename);
        } catch (Exception $err) {

            // write($tablename, $data_arr, $action) {
            if (isset($trnno)) {
                $this->Log_model->write($tablename, $value_arr, $action, $trno);
            }
            $result = $err->getMessage();
        }
        return $result;
    }

    /*
     * *************Table row count.getrowcount()*****************
     */

    function getrowcount($tableName, $where_arr = '')
    {
        /*
         *  echo $this->db->count_all_results('my_table');
          // Produces an integer, like 25

          $this->db->like('title', 'match');
          $this->db->from('my_table');
          echo $this->db->count_all_results();
          // Produces an integer, like 17
         */

        if (!empty($where_arr)) {
            $this->db->where($where_arr);
        }
        $count = $this->db->count_all_results($tableName);

        return $count;
    }

    /*     * ****** Grid Functions ********* */

    function getcount($tablename, $where_arr = '')
    {
        $count = 0;

        if (count($where_arr) > 0) {

            $this->db->where($where_arr, NULL, FALSE);
        }
        if (isset($tablename)) {
            $count = $this->db->count_all($tablename);
        }
        return $count;
    }

    function getgriddata($tablename, $columns_arr, $where_arr, $like_arr, $sidx, $sord, $limit, $start)
    {
        if (!empty($where_arr)) {
            $this->db->where($where_arr, NULL, FALSE);
        }
        if (!empty($columns_arr)) {
            $this->db->select(implode(',', $columns_arr));
        }

        if (!empty($like_arr)) {
            foreach ($like_arr as $fld => $searchString) {
                $this->db->like($fld, $searchString, 'after');
            }
        }

        $this->db->order_by($sidx, $sord);
        $query = $this->db->get($tablename, $limit, $start);
        return $query->result();
    }

    //Return the field names of the selected table
    function getColumnNames($tableName)
    {
        $fields = $this->db->list_fields($tableName);

        return $fields;
    }

    function dbprefix($tableName)
    {
        $prefix = $this->db->dbprefix($tableName);

        return $prefix;
    }

    function genericQuery($strSQL)
    {
        if (!empty($strSQL)) {
            try {
                $query = $this->db->query($strSQL);
                if (!$query) {
                    throw new Exception($this->db->_error_message(), $this->db->_error_number());
                    return FALSE;
                } else {
                    return $query->result();
                }
            } catch (Exception $e) {
                return;
            }
        } else {
            return FALSE;
        }
    }

    function getFirstValue($strSQL)
    {
        $ret = Null;
        if (!empty($strSQL)) {
            try {
                $query = $this->db->query($strSQL);
                if ($query) {
                    $result = $query->result();
                    if (count($result) > 0) {
                        $resultArray = (array)$result[0];
                        foreach ($result[0] as $key => $value) {
                            $ret = $value;
                            break;
                        }
                    } else {
                        $ret = Null;
                    }
                } else {
                    $ret = Null;
                }
                //
            } catch (Exception $ex) {
                $ret = Null;
            }
        } else {
            $ret = Null;
        }
        return $ret;
    }

    function actionQuery($strSQL)
    {
        if (!empty($strSQL)) {
            try {
                $query = $this->db->query($strSQL);
                if (!$query) {
                    throw new Exception($this->db->_error_message(), $this->db->_error_number());
                    return FALSE;
                } else {
                    return TRUE;
                }
            } catch (Exception $e) {
                return;
            }
        } else {
            return FALSE;
        }
    }

    function getNextSerialNumber($Code)
    {
        try {
            $strSQL = "SELECT snumber from fm_serials where code = '" . $Code . "'";
            $query = $this->db->query($strSQL);
            $currentSN = $query->result();
            if ($currentSN) {
                $serailno = ((int)$currentSN[0]->snumber) + 1;
            } else {
                $serailno = 99999;
            }
        } catch (Exception $ex) {

            $serailno = 900000;
        }
        //$serailno = 100;
        return $serailno;
    }

    function getKeyofTable($Code)
    {
        try {
            $strSQL = "SELECT REPT_KEY from TBL_REPORT_KEY where REPT_TABLE = '" . $Code . "'";
            $query = $this->db->query($strSQL);
            $currentSN = $query->result();
            if ($currentSN) {
                $serailno = ($currentSN[0]->REPT_KEY);
            } else {
                $serailno = NULL;
            }
        } catch (Exception $ex) {

            $serailno = 900000;
        }
        //$serailno = 100;
        return $serailno;
    }

    function increaseSerialNumber($Code)
    {
        try {
            $strSQL = "UPDATE fm_serials SET snumber = snumber + 1 WHERE code = '" . $Code . "'";
            $query = $this->db->query($strSQL);
            $rtn = TRUE;
        } catch (Exception $ex) {

            $rtn = FALSE;
        }
        return $rtn;
    }

    //2 master with 1 trsnasction join
    function getStructuredData($masterbase, $columns_arr = array(), $where_arr = array(), $joinfirst, $joinsecond, $keyfirst, $keysecond, $limit = 0)
    {
        $limit = ($limit == 0) ? Null : $limit;
        if (!empty($columns_arr)) {
            $this->db->select(implode(',', $columns_arr), FALSE);
        } else {
            $this->db->select('*');
        }

        $this->db->from($masterbase);
        $this->db->join($joinfirst, $joinfirst . '.id= ' . $masterbase . '.' . $keyfirst, 'left');
        $this->db->join($joinsecond, $joinsecond . '.id=' . $masterbase . '.' . $keysecond, 'left');

        if (!empty($where_arr)) {
            $this->db->where($where_arr);
        }
        $this->db->limit($limit);

        $query = $this->db->get();
        return $query->result();
    }

    function getAdvancedData($masterbase, $columns_arr = array(), $where_arr = array(), $joinfirst, $joinsecond, $jointhird, $keyfirst, $keysecond, $keythird, $groupby = '', $orderby = 'id', $order = 'ASC')
    {
        if (!empty($columns_arr)) {
            $this->db->select(implode(',', $columns_arr), FALSE);
        } else {
            $this->db->select('*');
        }

        $this->db->from($masterbase);
        $this->db->join($joinfirst, $joinfirst . '.id= ' . $masterbase . '.' . $keyfirst, 'left');
        $this->db->join($joinsecond, $joinsecond . '.id=' . $masterbase . '.' . $keysecond, 'left');
        $this->db->join($jointhird, $jointhird . '.id=' . $masterbase . '.' . $keythird, 'left');

        if (!empty($where_arr)) {
            $this->db->where($where_arr);
        }
        if (isset($groupby)) {
            $this->db->group_by($groupby);
        }

        $this->db->order_by($orderby, $order); // or 'DESC'
        $query = $this->db->get();
        return $query->result();
    }

    function getJoin($tablename = "", $columns_arr = array(), $where_arr = array(), $jointable = "", $primaryjoinonkey = "", $basejoinkey = "", $limit = 0, $offset = 0)
    {
        if (!empty($columns_arr)) {
            $this->db->select(implode(',', $columns_arr), FALSE);
        }

        if ($tablename == '') {
            return array();
        } else {
            $this->db->from($tablename);
            $primKey = $tablename . '.' . $primaryjoinonkey;
            $basekey = $jointable . '.' . $basejoinkey;
            $this->db->join($jointable, $primKey . '=' . $basekey);
//            $this->db->join('loan_repayments', 'product_details.pd_id=loan_repayments.pd_id');

            if (!empty($where_arr)) {
                $this->db->where($where_arr);
            }

            if ($limit > 0 AND $offset > 0) {
                $this->db->limit($limit, $offset);
            } elseif ($limit > 0 AND $offset == 0) {
                $this->db->limit($limit);
            }
            $query = $this->db->get();
            return $query->result();
        }
    }

    function getAutoFillData($tablename, $fieldName, $value, $keyfield, $limit, $offset)
    {
        $this->db->select($keyfield . ', ' . $fieldName);
        $this->db->from($tablename);
        $this->db->like($fieldName, $value, 'after');
        $this->db->limit($limit);
        $query = $this->db->get();
        //$query = $this->db->get_where($tablename, $where_arr, $limit, $offset);
        return $query->result();
    }

    function getFilteredAutoFillData($tablename, $fieldName, $value, $keyfield, $whereArr, $limit, $offset)
    {
        $this->db->select($keyfield . ', ' . $fieldName);
        $this->db->from($tablename);
        $this->db->like($fieldName, $value, 'after');
        $this->db->where($whereArr);
        $this->db->limit($limit);
        $query = $this->db->get();
        //$query = $this->db->get_where($tablename, $where_arr, $limit, $offset);
        return $query->result();
    }

    function getMultiAutoFillData($tablename, $fieldName, $value, $keyfield, $fieldNext, $limit, $offset)
    {
        $this->db->select($keyfield . ', ' . $fieldName . ', ' . $fieldNext);
        $this->db->from($tablename);
        $this->db->like($fieldName, $value, 'after');
        $this->db->limit($limit);
        $query = $this->db->get();
        //$query = $this->db->get_where($tablename, $where_arr, $limit, $offset);
        return $query->result();
    }

    function getAccountData($tablename, $fieldName, $value, $keyfield, $field1, $field2, $field3, $limit, $offset)
    {
        $this->db->select($keyfield . ', ' . $fieldName . ', ' . $field1 . ', ' . $field2 . ', ' . $field3);
        $this->db->from($tablename);
        $this->db->like($fieldName, $value, 'after');
        $this->db->limit($limit);
        $query = $this->db->get();
        //$query = $this->db->get_where($tablename, $where_arr, $limit, $offset);
        return $query->result();
    }

    function getConfigValue($configname)
    {
        return $this->config->item($configname);
    }

    function insert_batch($table, $data_arr = array())
    {
        if ($table) {
            try {
                if (!empty($data_arr)) {
                    $this->db->insert_batch($table, $data_arr);
                }
            } catch (Exception $e) {
                return;
            }
        } else {
            $erro_message = "No table selected";
            return $erro_message;
        }

    }


    function getJoinNew($distinct, $table, $select_arr = array(), $join_arr = array(), $where_arr = array())
    {

        if ($distinct == 'yes') {

            $this->db->distinct();
        }

        if (!empty($select_arr)) {

            $this->db->select(implode(',', $select_arr), FALSE);
        } else {

            $this->db->select('*');
        }

        $this->db->from($table);


        if (!empty($join_arr)) {

            foreach ($join_arr as $join_table) {

                $this->db->join($join_table['table'], $join_table['field1'] . '=' . $join_table['field2']);
            }
        }

        if (!empty($where_arr)) {
            $this->db->where($where_arr);
        }

        $query = $this->db->get();

        return $query->result();

    }

    function getJoinLimit($table, $select_arr = array(), $join_arr = array(), $where_arr = array(), $like_arr = array(), $limit = 0, $offset = 0)
    {
        if (!empty($select_arr)) {

            $this->db->select(implode(',', $select_arr), FALSE);
        } else {

            $this->db->select('*');
        }

        $this->db->from($table);


        if (!empty($join_arr)) {

            foreach ($join_arr as $join_table) {

                $this->db->join($join_table['table'], $join_table['field1'] . '=' . $join_table['field2']);
            }
        }

        if (!empty($where_arr)) {
            $this->db->where($where_arr);
        }

        if (!empty($like_arr)) {
            foreach ($like_arr as $fld => $searchString) {
                $this->db->like($fld, $searchString, 'after');
            }
        }

        if ($limit > 0 AND $offset > 0) {
            $this->db->limit($limit, $offset);
        } elseif ($limit > 0 AND $offset == 0) {
            $this->db->limit($limit);
        }

        $query = $this->db->get();
        return $query->result();

    }

    function getJoinTotCount($distinct, $table, $select_arr = array(), $join_arr = array(), $where_arr = array())
    {
        if ($distinct == 'yes') {

            $this->db->distinct();
        }

        if (!empty($select_arr)) {

            $this->db->select(implode(',', $select_arr), FALSE);
        } else {

            $this->db->select('*');
        }

        $this->db->from($table);


        if (!empty($join_arr)) {

            foreach ($join_arr as $join_table) {

                $this->db->join($join_table['table'], $join_table['field1'] . '=' . $join_table['field2']);
            }
        }

        if (!empty($where_arr)) {
            $this->db->where($where_arr);
        }

        $query = $this->db->get();

        return $query->num_rows();

    }

    function getJoinFilterCount($table, $select_arr = array(), $join_arr = array(), $where_arr = array(), $like_arr = array())
    {
        if (!empty($select_arr)) {

            $this->db->select(implode(',', $select_arr), FALSE);
        } else {

            $this->db->select('*');
        }

        $this->db->from($table);


        if (!empty($join_arr)) {

            foreach ($join_arr as $join_table) {

                $this->db->join($join_table['table'], $join_table['field1'] . '=' . $join_table['field2']);
            }
        }

        if (!empty($where_arr)) {
            $this->db->where($where_arr);
        }

        if (!empty($like_arr)) {
            foreach ($like_arr as $fld => $searchString) {
                $this->db->like($fld, $searchString, 'after');
            }
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    // USER WISE LOAD BRANCH
    function getBranch()
    {
        if (!empty($_SESSION["userId"])) {
            $user = $_SESSION["userId"];

            $this->db->select('usmd,brch');
            $this->db->from('user_mas');
            $this->db->where('auid=' . $user);
            $query = $this->db->get();
            $user_data = $query->result();

            $data = $this->getSpecStting('albr');
            $spbr = $this->getSpecStting('spbr');   // IF SPECIAL BRANCH ACCESS PERMISSION
            //echo 'A ' . $data . ' -- ' . $spbr;

            // IF USER MODE AND SPECIAL PERMISSION CHECK
            if ($user_data[0]->usmd == 1 || $user_data[0]->usmd == 2 || $user_data[0]->usmd == $data) {

                $this->db->select(array('brid', 'brnm', 'brcd'));
                $this->db->from('brch_mas');
                $this->db->where(array('stat' => '1'));
                $this->db->order_by("brnm", "asc");
                $query = $this->db->get();

                $result[0] = array('brch_id' => '0', 'brch_name' => '-- Select Branch --');
                $result[1] = array('brch_id' => 'all', 'brch_name' => 'All Branches');
                $i = 2;
                foreach ($query->result() as $branch) {
                    $result[$i] = array('brch_id' => $branch->brid, 'brch_name' => $branch->brnm, 'brch_code' => $branch->brcd);
                    $i = $i + 1;
                }
                return $result;
            } elseif ($user_data[0]->usmd == $spbr) {
                // SPECIAL BRANCH
                $usdt = $this->getData('user_mas', array('prmd'), array('stat' => 1, 'auid' => $user));

                // GET USER SPECIAL BRANCH
                $this->db->select('brch_mas.brid, brnm, brcd');
                $this->db->from('user_spec_brn');
                $this->db->join('brch_mas', 'brch_mas.brid = user_spec_brn.brid');
                $this->db->where(array('user_spec_brn.stat' => '1'));
                // IF DEFAULT PERMISSION
                if ($usdt[0]->prmd == 0) {
                    $this->db->where(array('prtp' => '0'));
                    $this->db->where(array('lvid' => $_SESSION['role']));
                } else {
                    $this->db->where(array('prtp' => '1'));
                    $this->db->where(array('lvid' => $_SESSION['role']));
                    $this->db->where(array('usid' => $user));
                }
                $query2 = $this->db->get();

                // GET USER DEFAULT BRANCH
                $this->db->select('brid,brnm,brcd');
                $this->db->from('brch_mas');
                $this->db->where(array('brid' => $user_data[0]->brch, 'stat' => '1'));
                $this->db->order_by("brnm", "asc");
                $query = $this->db->get();
                $this->db->close();

                // SET START FILTER
                $result[0] = array('brch_id' => '0', 'brch_name' => '--Select Branch--');
                //$result[1] = array('brch_id' => 'all', 'brch_name' => 'All Branches');
                $i = 1;
                // DEFAULT BRANCH
                foreach ($query->result() as $branch) {
                    $result[$i] = array('brch_id' => $branch->brid, 'brch_name' => $branch->brnm, 'brch_code' => $branch->brcd);
                    $i = $i + 1;
                }
                // SPECIAL BRANCH
                $i = $i;
                foreach ($query2->result() as $branch2) {
                    $result[$i] = array('brch_id' => $branch2->brid, 'brch_name' => $branch2->brnm, 'brch_code' => $branch2->brcd);
                    $i = $i + 1;
                }
                return $result;
                // END FILTER
            } else {
                $this->db->select(array('brid', 'brnm', 'brcd'));
                $this->db->from('brch_mas');
                $this->db->where(array('brid' => $user_data[0]->brch, 'stat' => '1'));
                $this->db->order_by("brnm", "asc");
                $query = $this->db->get();
                $this->db->close();

                $i = 1;
                foreach ($query->result() as $branch) {
                    $result[$i] = array('brch_id' => $branch->brid, 'brch_name' => $branch->brnm, 'brch_code' => $branch->brcd);
                    $i = $i + 1;
                }
                return $result;

                //}
            }
        } else {
            //redirect('welcome');
        }
    }

    // USER WISE LOAD OFFICER
    function getExe()
    {
        if ($_SESSION["userId"] != null) {
            $user = $_SESSION["userId"];

            $this->db->select('usmd,auid,brch,fnme,lnme');
            $this->db->from('user_mas');
            $this->db->where('auid=' . $user);
            $query = $this->db->get();
            $user_data = $query->result();

            $data = $this->getSpecStting('alof');   // ALL OFFICDER
            $spcBrn = $this->getSpecBrnc();     // SPECIAL BRANCH

            if ($user_data[0]->usmd == 1 || $user_data[0]->usmd == 2) {     // SUPER ADMIN || ADMIN

                $result[0] = array('exe_id' => '0', 'exe_name' => '--Select Officer--');

                $this->db->select(array('auid', 'fnme', 'lnme'));
                $this->db->from('user_mas');
                $this->db->where(array('stat' => '1'));
                // $this->db->where(array('user_mas.brch' => $user_data[0]->brch));
                $this->db->where_in('user_mas.usmd', array('3', '4', '5', '7', '9', '13'));  // 3-CRO | 4-BM | 5-OFFICER | 7-J OFFICER | 9 - ASSISTANT MANGER | 13-S OFFICER
                $this->db->order_by("fnme", "asc");
                $query = $this->db->get();
                $this->db->close();

                $result[1] = array('exe_id' => 'all', 'exe_name' => 'All Officer');
                $i = 2;
                foreach ($query->result() as $exe) {
                    $result[$i] = array('exe_id' => $exe->auid, 'exe_name' => $exe->fnme . ' ' . $exe->lnme);
                    $i = $i + 1;
                }
                return $result;

            } else if ($user_data[0]->usmd == $data) {                // SPECIAL ALL OFFICER
                $this->db->select(array('auid', 'fnme', 'lnme'));
                $this->db->from('user_mas');
                $this->db->where(array('stat' => '1'));
                //$this->db->where(array('user_mas.brch' => $user_data[0]->brch));
                $this->db->where("user_mas.brch IN($spcBrn)");
                $this->db->where_in('user_mas.usmd', array('3', '4', '5', '6', '7', '13'));  // 3-CRO | 4-BM | 5-OFFICER | 7-J OFFICER | 13-S OFFICER
                $this->db->order_by("fnme", "asc");
                $query = $this->db->get();
                $this->db->close();
                //$result[0] = array('exe_id' => '0', 'exe_name' => '--Select Officer--');
                $result[1] = array('exe_id' => 'all', 'exe_name' => 'All Officers');
                $i = 2;
                foreach ($query->result() as $exe) {
                    $result[$i] = array('exe_id' => $exe->auid, 'exe_name' => $exe->fnme . ' ' . $exe->lnme);
                    $i = $i + 1;
                }
                return $result;
                // $spcBrn = $this->Generic_model->getSpecBrnc();
                // AND brid IN($spcBrn)
            } else if ($user_data[0]->usmd == 4 || $user_data[0]->usmd == 9) {   // BM || ASS: MANAGER
                $this->db->select(array('auid', 'fnme', 'lnme'));
                $this->db->from('user_mas');
                $this->db->where(array('stat' => '1'));
                $this->db->where(array('user_mas.brch' => $user_data[0]->brch));
                $this->db->where_in('user_mas.usmd', array('3', '4', '5', '7', '9', '13'));  // 3-CRO | 4-BM | 5-OFFICER | 7-J OFFICER | 9 - ASSISTANT MANGER | 13-S OFFICER
                $this->db->order_by("fnme", "asc");
                $query = $this->db->get();
                $this->db->close();
                //$result[0] = array('exe_id' => '0', 'exe_name' => '--Select Officer--');
                $result[1] = array('exe_id' => 'all', 'exe_name' => 'All Officers');
                $i = 2;
                foreach ($query->result() as $exe) {
                    $result[$i] = array('exe_id' => $exe->auid, 'exe_name' => $exe->fnme . ' ' . $exe->lnme);
                    $i = $i + 1;
                }
                return $result;

            } else if ($user_data[0]->usmd == 3 || $user_data[0]->usmd == 6) {                // CRO || CASHIER
                $this->db->select(array('auid', 'fnme', 'lnme'));
                $this->db->from('user_mas');
                $this->db->where(array('stat' => '1'));
                $this->db->where(array('user_mas.brch' => $user_data[0]->brch));
                $this->db->where_in('user_mas.usmd', array('3', '4', '5', '6', '7', '13'));  // 3-CRO | 4-BM | 5-OFFICER | 7-J OFFICER | 13-S OFFICER
                $this->db->order_by("fnme", "asc");
                $query = $this->db->get();
                $this->db->close();
                //$result[0] = array('exe_id' => '0', 'exe_name' => '--Select Officer--');
                $result[1] = array('exe_id' => 'all', 'exe_name' => 'All Officers');
                $i = 2;
                foreach ($query->result() as $exe) {
                    $result[$i] = array('exe_id' => $exe->auid, 'exe_name' => $exe->fnme . ' ' . $exe->lnme);
                    $i = $i + 1;
                }
                return $result;

            } else if ($user_data[0]->usmd == 5 || $user_data[0]->usmd == 7 || $user_data[0]->usmd == 13) {       // OFFICER | J OFFICER | S OFFICER
                $result[0] = array('exe_id' => $user_data[0]->auid, 'exe_name' => $user_data[0]->fnme . ' ' . $user_data[0]->lnme);
                return $result;
            } else {        // OFFICER >
                /*$this->db->select(array('auid', 'fnme', 'lnme'));
                $this->db->from('user_mas');
                $this->db->where(array('stat' => '1'));
                $this->db->where(array('user_mas.brch' => $user_data[0]->brch));
                $this->db->where_in('user_mas.usmd', array('4','5'));
                $this->db->order_by("fnme", "asc");
                $query = $this->db->get();
                $this->db->close();

                //$result[0] = array('exe_id' => '0', 'exe_name' => '--Select Officer--');
                $result[1] = array('exe_id' => 'all', 'exe_name' => 'All Officers');

                $i = 2;
                foreach ($query->result() as $exe) {
                    $result[$i] = array('exe_id' => $exe->auid, 'exe_name' => $exe->fnme . ' ' . $exe->lnme);
                    $i = $i + 1;
                }
                return $result;*/

                $result[0] = array('exe_id' => $user_data[0]->auid, 'exe_name' => $user_data[0]->fnme . ' ' . $user_data[0]->lnme);
                return $result;

            }
        } else {
            //redirect('welcome');
        }
    }

    // USER LEVEL LOAD
    function getUserLvl()
    {
        $this->db->select("");
        $this->db->from("user_level");
        $this->db->where("stat = 1 AND id != 1");
        $this->db->order_by('user_level.lvnm', 'asc');
        $query = $this->db->get();
        return $query->result();
        // echo json_encode($query->result());
    }

    // USER WISE LOAD CENTER
    function getCen()
    {
        if ($_SESSION["userId"] != null) {
            $user = $_SESSION["userId"];

            $this->db->select('usmd,auid,fnme,lnme,brch');
            $this->db->from('user_mas');
            $this->db->where('auid=' . $user);
            $query = $this->db->get();
            //$this->db->close();

            $user_data = $query->result();
            //var_dump($user_data[0]);die;
            if ($user_data[0]->usmd == 1 || $user_data[0]->usmd == 2) {

                $result[0] = array('cen_id' => '0', 'cen_name' => '--Select Center--');

                return $result;
            } else if ($user_data[0]->usmd == 5) {

                $this->db->select(array('caid', 'cnnm'));
                $this->db->from('cen_mas');
                $this->db->where(array('cen_mas.usid' => $user_data[0]->auid));
                $this->db->where(array('cen_mas.stat' => '1'));
                $this->db->order_by("cnnm", "asc");
                $query = $this->db->get();
                $this->db->close();

                $result[0] = array('cen_id' => 'all', 'cen_name' => 'All Centers');

                $i = 1;
                foreach ($query->result() as $cen) {

                    $result[$i] = array('cen_id' => $cen->caid, 'cen_name' => $cen->cnnm);
                    $i = $i + 1;
                }

                return $result;
            } else {

                $this->db->select(array('caid', 'cnnm'));
                $this->db->from('cen_mas');
                $this->db->where(array('cen_mas.brco' => $user_data[0]->brch));
                $this->db->where(array('cen_mas.stat' => '1'));
                $this->db->order_by("cnnm", "asc");
                $query = $this->db->get();
                $this->db->close();

//			$result[0] = array('cen_id'=>'0','cen_name'=>'--Select Center--');
                $result[1] = array('cen_id' => 'all', 'cen_name' => 'All Centers');

                $i = 2;
                foreach ($query->result() as $cen) {

                    $result[$i] = array('cen_id' => $cen->caid, 'cen_name' => $cen->cnnm);

                    $i = $i + 1;
                }

                return $result;
            }
        } else {
            redirect('welcome');
        }
    }

    // LOAD USER WISE PAGE ACCESS PERMISSION
    function getPermision()
    {
        if (!empty($_SESSION["userId"])) {
            $user = $_SESSION["userId"];

            $this->db->select('usmd,brch,prmd');
            $this->db->from('user_mas');
            $this->db->where('auid=' . $user);
            $query = $this->db->get();
            $user_data = $query->result();

            if ($user_data[0]->usmd == 1) {     // super admin
                $this->db->select('*');
                $this->db->from('user_page');
                $this->db->where(array('stst' => '1'));
                $query = $this->db->get();

                $i = 0;
                foreach ($query->result() as $perm) {
                    $result[$i] = array('id' => $perm->aid, 'pgcd' => $perm->pgcd);
                    $i = $i + 1;
                }
                $last_names = array_column($result, 'pgcd', 'id');

                return $last_names;
            } else {
                // DEFAULT PERMISSION
                if ($user_data[0]->prmd == 0) {
                    $this->db->select('user_prmis.pgid,user_page.pgcd');
                    $this->db->from('user_prmis');
                    $this->db->join('user_page', 'user_page.aid = user_prmis.pgid');
                    $this->db->where(array('user_prmis.stat' => '1'));
                    $this->db->where(array('user_page.stst' => '1'));
                    $this->db->where(array('prtp' => '0'));  // default permission
                    $this->db->where(array('pgac' => '1'));
                    $this->db->where(array('ulid' => $user_data[0]->usmd));
                    $query = $this->db->get();

                    $i = 0;
                    foreach ($query->result() as $perm) {
                        $result[$i] = array('id' => $perm->pgid, 'pgcd' => $perm->pgcd);
                        $i = $i + 1;
                    }
                    if (!empty($result)) {
                        $last_names = array_column($result, 'pgcd', 'id');
                        return $last_names;
                    } else {
                        $last_names = array('id' => 0, 'pgcd' => '/');
                        return $last_names;
                    }
                } else {

                    $this->db->select('user_prmis.pgid,user_page.pgcd');
                    $this->db->from('user_prmis');
                    $this->db->join('user_page', 'user_page.aid = user_prmis.pgid');
                    $this->db->where(array('user_prmis.stat' => '1'));
                    $this->db->where(array('user_page.stst' => '1'));
                    $this->db->where(array('prtp' => '1')); // manuel permission
                    $this->db->where(array('pgac' => '1'));
                    $this->db->where(array('usid' => $user));
                    $query = $this->db->get();

                    $i = 0;
                    foreach ($query->result() as $perm) {
                        $result[$i] = array('id' => $perm->pgid, 'pgcd' => $perm->pgcd);
                        $i = $i + 1;
                    }

                    if (!empty($result)) {
                        $last_names = array_column($result, 'pgcd', 'id');
                        return $last_names;
                    } else {
                        $last_names = array('id' => 0, 'pgcd' => '/');
                        return $last_names;
                    }
                    // echo json_encode($result);
                }
            }
            // var_dump($last_names);
            //echo $last_names;

        } else {
            //redirect('welcome');
        }
    }

    // LOAD USER WISE PAGE MAIN MODULE PERMISSION
    function getPermisionModule()
    {
        if (!empty($_SESSION["userId"])) {
            $user = $_SESSION["userId"];

            $this->db->select('usmd,brch,prmd');
            $this->db->from('user_mas');
            $this->db->where('auid=' . $user);
            $query = $this->db->get();
            $user_data = $query->result();

            if ($user_data[0]->usmd == 1) {     // super admin

                // USER MODULE
                $this->db->select('user_page.aid,user_page_mdl.mdcd');
                $this->db->from('user_page');
                $this->db->join('user_page_mdl', 'user_page_mdl.aid = user_page.modu', 'left');
                $this->db->where(array('user_page.stst' => '1'));
                //$this->db->where('user_page_mdl.stat',1); // ACTIVE MODULE ONLY
                $this->db->group_by('user_page.modu');
                $query2 = $this->db->get();

                $i = 0;
                foreach ($query2->result() as $modu) {
                    $result[$i] = array('id' => $modu->aid, 'pgcd' => $modu->mdcd);
                    $i = $i + 1;
                }
                $last_names = array_column($result, 'pgcd', 'id');

                return $last_names;
            } else {
                // DEFAULT PERMISSION
                if ($user_data[0]->prmd == 0) {

                    // USER MODULE
                    $this->db->select('user_prmis.pgid,user_page_mdl.mdcd');
                    $this->db->from('user_prmis');
                    $this->db->join('user_page', 'user_page.aid = user_prmis.pgid');
                    $this->db->join('user_page_mdl', 'user_page_mdl.aid = user_page.modu');
                    $this->db->where(array('user_prmis.stat' => '1'));
                    $this->db->where(array('user_page.stst' => '1'));
                    $this->db->where(array('prtp' => '0'));  // default permission
                    $this->db->where(array('pgac' => '1'));
                    $this->db->where(array('ulid' => $user_data[0]->usmd));
                    $this->db->where('user_page_mdl.stat', 1); // ACTIVE MODULE ONLY
                    $this->db->group_by('user_page.modu');
                    $query2 = $this->db->get();

                    $i = 0;
                    foreach ($query2->result() as $modu) {
                        $result[$i] = array('id' => $modu->pgid, 'pgcd' => $modu->mdcd);
                        $i = $i + 1;
                    }

                    if (!empty($result)) {
                        $last_names = array_column($result, 'pgcd', 'id');
                        return $last_names;
                    } else {
                        $last_names = array('id' => 0, 'pgcd' => '/');
                        return $last_names;
                    }

                } else {

                    $this->db->select('user_prmis.pgid,user_page_mdl.mdcd');
                    $this->db->from('user_prmis');
                    $this->db->join('user_page', 'user_page.aid = user_prmis.pgid');
                    $this->db->join('user_page_mdl', 'user_page_mdl.aid = user_page.modu');
                    $this->db->where(array('user_prmis.stat' => '1'));
                    $this->db->where(array('user_page.stst' => '1'));
                    $this->db->where(array('prtp' => '1')); // manuel permission
                    $this->db->where(array('pgac' => '1'));
                    $this->db->where(array('usid' => $user));
                    $this->db->where('user_page_mdl.stat',1); // ACTIVE MODULE ONLY
                    $query2 = $this->db->get();

                    $i = 0;
                    foreach ($query2->result() as $modu) {
                        $result[$i] = array('id' => $modu->pgid, 'pgcd' => $modu->mdcd);
                        $i = $i + 1;
                    }

                    if (!empty($result)) {
                        $last_names = array_column($result, 'pgcd', 'id');
                        return $last_names;
                    } else {
                        $last_names = array('id' => 0, 'pgcd' => '/');
                        return $last_names;
                    }
                    // echo json_encode($result);
                }
            }
        } else {
            //redirect('welcome');
        }
    }

    // LOAD USER WISE BUTTON ACTION PERMISSION
    function getFuncPermision($pgnm)
    {
        if (!empty($_SESSION["userId"])) {
            $user = $_SESSION["userId"];

            $this->db->select('usmd,brch,prmd');
            $this->db->from('user_mas');
            $this->db->where('auid=' . $user);
            $query = $this->db->get();
            $user_data = $query->result();

            $this->db->select('user_page.aid AS pgid');
            $this->db->from('user_page');
            $this->db->where(array('pgcd' => $pgnm));
            $query = $this->db->get();
            $pgdt = $query->result();

            if ($user_data[0]->usmd == 1) {         // super admin
                /* this is a some error..
                insert need to pgid  and but data tb load need to permission other details  */
                $this->db->select('user_prmis.*');
                $this->db->from('user_prmis');
                $this->db->where(array('stat' => '1'));
                // $this->db->where(array('prtp' => '0'));  // default permission
                $this->db->where(array('pgid' => $pgdt[0]->pgid));
                $query = $this->db->get();

                //return $query->result();
                $clasa = array(
                    0 => (object)array(
                        "pgid" => $pgdt[0]->pgid,
                        "pgac" => '1',
                        "view" => '1',
                        "inst" => '1',
                        "edit" => '1',
                        "apvl" => '1',
                        "rejt" => '1',
                        "dsbs" => '1',
                        "prnt" => '1',
                        "rpnt" => '1',
                        "reac" => '1',
                        "dact" => '1',
                        //   "inst" => '1',
                        //   "inst" => '1',
                    )
                );

                // array(1) { [0]=> object(stdClass)#27 (17) { ["prid"]=> string(2) "46" ["pgid"]=> string(2) "23"
                // ["prtp"]=> string(1) "0" ["ulid"]=> string(2) "12" ["usid"]=> string(1) "0" ["pgac"]=> string(1) "1"
                // ["view"]=> string(1) "1" ["inst"]=> string(1) "0" ["edit"]=> string(1) "1" ["apvl"]=> string(1) "1"
                // ["rejt"]=> string(1) "1" ["dsbs"]=> string(1) "0" ["vupn"]=> string(1) "0" ["cqpt"]=> string(1) "0"
                // ["cqrp"]=> string(1) "0" ["remk"]=> string(0) "" ["stat"]=> string(1) "1" } }

                return $clasa;
            } else {

                if ($user_data[0]->prmd == 0) {     // default permission
                    $this->db->select('user_prmis.*');
                    $this->db->from('user_prmis');
                    $this->db->where(array('stat' => '1'));
                    //$this->db->where(array('prtp' => '0'));  // default permission
                    $this->db->where(array('pgid' => $pgdt[0]->pgid));
                    $this->db->where(array('ulid' => $user_data[0]->usmd));
                    $query = $this->db->get();
                    return $query->result();

                    /* $i = 0;
                     foreach ($query->result() as $perm) {
                         $result[$i] = array('id' => $perm->prid, 'view' => $perm->view);
                         $i = $i + 1;
                     }
                     if (!empty($result)) {
                         $last_names = array_column($result, 'view', 'id');
                         return $last_names;
                     } else {
                         $last_names = array('id' => 0, 'view' => '/');
                         return $last_names;
                     }
                       echo json_encode($result);*/

                } else {        // manuel permission

                    $this->db->select('user_prmis.*,user_page.pgcd');
                    $this->db->from('user_prmis');
                    $this->db->join('user_page', 'user_page.aid = user_prmis.pgid');
                    $this->db->where(array('stat' => '1'));
                    $this->db->where(array('prtp' => '1')); // manuel permission
                    // $this->db->where(array('pgac' => '1'));
                    $this->db->where(array('usid' => $user));
                    $this->db->where(array('pgid' => $pgdt[0]->pgid));
                    $query = $this->db->get();

                    return $query->result();

                    //var_dump($query->result());
                    /* $i = 0;
                     foreach ($query->result() as $perm) {
                         $result[$i] = array('id' => $perm->pgid, 'pgcd' => $perm->pgcd);
                         $i = $i + 1;
                     }
                     if (!empty($result)) {
                         $last_names = array_column($result, 'pgcd', 'id');
                         return $last_names;
                     } else {
                         $last_names = array('id' => 0, 'pgcd' => '/');
                         return $last_names;
                     }*/
                    // echo json_encode($result);
                }
            }

        } else {
            //redirect('welcome');
        }
    }

    //IS RECONSILATED CHECK
    function isRecDate()
    {
        $usrbrn = $_SESSION['usrbrnc'];

        $this->db->select("date,prdt,stat");
        $this->db->from('dayend_process');
        $this->db->where("date='" . date('Y-m-d') . "' AND stat=1 AND brid = $usrbrn ");

        $query = $this->db->get()->result();
        if (sizeof($query) == 1) {
            return true;
        } else {
            return false;
        }
    }

    //IS DISBURSEMENT PAUSED
    function isDbmtPaused()
    {
        $this->db->select("pov1,pov2,poid,post");
        $this->db->from('sys_policy');
        $this->db->where("poid=23 AND post=1");

        $query = $this->db->get()->result();
        if (sizeof($query) == 1) {
            $fromTime = date_create_from_format('H:i:s', $query[0]->pov1 . "");
            $toTime = date_create_from_format('H:i:s', $query[0]->pov2 . "");
            if ((date_format($toTime, 'H:i:s') > date('H:i:s')) AND (date('H:i:s') > date_format($fromTime, 'H:i:s'))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //IS REPAYMENT PAUSE
    function isRpymtPause()
    {
        $this->db->select(" pov1, pov2");
        $this->db->from("sys_policy");
        $this->db->where(" pov3 = (SELECT  DAYOFWEEK(curdate())) AND 
        (SELECT DATE_FORMAT(NOW(), '%H:%i:%s')) > STR_TO_DATE(pov1,'%H:%i:%s') AND (SELECT DATE_FORMAT(NOW(), '%H:%i:%s')) <  STR_TO_DATE(pov2,'%H:%i:%s') AND post = 1 ");

        $query = $this->db->get()->result();
        if (sizeof($query) == 1) {
            return true;
        } else {
            return false;
        }
    }

    // GET SPRCIAL PERMISSION SETTING
    function getSpecStting($type)
    {
        $user = $_SESSION["userId"];    // user id
        $usdt = $this->getData('user_mas', array('prmd'), array('stat' => 1, 'auid' => $user));

        $this->db->select('lvid');
        $this->db->from('user_prmis_advance');
        $this->db->where(array('stat' => '1'));
        // IF DEFAULT PERMISSION
        if ($usdt[0]->prmd == 0) {
            $this->db->where(array('prtp' => '0'));
            $this->db->where(array('lvid' => $_SESSION['role']));
        } else {
            $this->db->where(array('prtp' => '1'));
            $this->db->where(array('lvid' => $_SESSION['role']));
            $this->db->where(array('usid' => $user));
        }
        $this->db->where($type, 1);
        $query = $this->db->get();
        $result = $query->result();

        if (sizeof($result) > 0) {
            return $result[0]->lvid;
        } else {
            return 0;
        }
    }

    // GET MODULE PERMISSION
    function getMdulPermis($type)
    {
        $user = $_SESSION["userId"];    // user id
        $usdt = $this->getData('user_mas', array('prmd'), array('stat' => 1, 'auid' => $user));

        $this->db->select('lvid');
        $this->db->from('user_prmis_modul');
        $this->db->where(array('stat' => '1'));

        // IF DEFAULT PERMISSION
        if ($usdt[0]->prmd == 0) {
            $this->db->where(array('prtp' => '0'));
            $this->db->where(array('lvid' => $_SESSION['role']));
        } else {
            $this->db->where(array('prtp' => '1'));
            $this->db->where(array('lvid' => $_SESSION['role']));
            $this->db->where(array('usid' => $user));
        }
        $this->db->where($type, 1);

        $query = $this->db->get();
        $result = $query->result();

        if (sizeof($result) > 0) {
            return $result[0]->lvid;
        } else {
            return 0;
        }
    }

    // CHECK VALIDE USER
    function chckVlidUsr()
    {
        $user = $_SESSION["userId"];    // user id
        $usdt = $this->getData('user_mas', array(''), array('stat' => 1, 'auid' => $user));

        //return sizeof($usdt);
        if (sizeof($usdt) > 0) {
            return sizeof($usdt);
        } else {
            return 0;
        }
    }

    // GET SPRCIAL BRANCH
    function getSpecBrnc()
    {
        $user = $_SESSION["userId"];    // user id
        // check user permision mode
        $usdt = $this->getData('user_mas', array('prmd'), array('stat' => 1, 'auid' => $user));

        // IF DEFAULT PERMISSION
        if ($usdt[0]->prmd == 0) {
            $aa = array(
                'stat' => 1,
                'lvid' => $_SESSION['role']
            );
        } else {
            $aa = array(
                'stat' => 1,
                'usid' => $user
            );
        }
        $spbract = $this->getData('user_prmis_advance', array('spbr'), $aa);

        // IF SPECIAL BRANCH ACTIVE
        //if ($spbract[0]->spbr == 1) {
        if (!empty($spbract)) {

            $this->db->select('brid');
            $this->db->from('user_spec_brn');
            $this->db->where(array('stat' => '1'));

            if ($usdt[0]->prmd == 0) {
                $this->db->where(array('prtp' => '0'));
                $this->db->where(array('lvid' => $_SESSION['role']));

            } else {
                $this->db->where(array('prtp' => '1'));
                $this->db->where(array('lvid' => $_SESSION['role']));
                $this->db->where(array('usid' => $user));
            }
            $query = $this->db->get();
            $result2 = $query->result();

            if (sizeof($result2) > 0) {

                $result = array($_SESSION['usrbrnc']);    // SET DEFAULT BRANCH
                foreach ($result2 as $branch) {
                    array_push($result, $branch->brid);      // SET DPECIAL BRANVH
                }
                $spbrn = '';
                $xx = 1;
                foreach ($result as $brn) {
                    $spbrn = $spbrn . $brn;
                    if (sizeof($result) == $xx) {
                        $spbrn = $spbrn;
                    } else {
                        $spbrn = $spbrn . ',';
                    }
                    $xx++;
                }
                return $spbrn;
            } else {
                return 0;
            }
        }
    }
}

?>
