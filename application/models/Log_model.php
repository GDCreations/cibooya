<?php

class Log_model extends CI_Model
{

    function userLogXX($func)
    {
        $username = $this->session->userdata('fname');
        $userid = $this->session->userdata('userId');

        $pgdt = $this->Generic_model->getData('user_page', array('aid', 'pgnm'), array('pgcd' => $func));

        try {
            //History controler for DB
            // $dataset = serialize($data_arr);

            $logdata_arr = array(
                'usid' => $userid,
                'usnm' => $username,
                'pid' => $pgdt[0]->aid,
                'pcd' => $func,
                'pnm' => $pgdt[0]->pgnm,
                'stat' => 1,
                'lgdt' => date('Y-m-d H:i:s'),
                'lgip' => $_SERVER['REMOTE_ADDR'],
            );
            $this->db->insert('user_log', $logdata_arr);

        } catch (Exception $err) {
            $logdata_arr = array(
                'usid' => $userid,
                'usnm' => $username,
                //'pid' => $lst_id,
                'pnm' => $func,
                //'remarks' => json_encode($dataset),
                'stat' => 1,
                'lgdt' => date('Y-m-d H:i:s'),
                'lgip' => $_SERVER['REMOTE_ADDR'],
            );

            $this->db->insert('user_log', $logdata_arr);
            return $err->getMessage();
        }

        /*try {

            $space = "\r\n"; // For NewLine
            $userdata = $this->session->userdata();
            $userid = $this->session->userdata('user_id');
            $fileuserdata = $userdata;
            $fileusername = $this->session->userdata('username');
            $filedataset = serialize($data_arr);

            $dataToBeWritten = array($space,
                "DATE" => date('Y-m-d H:i:s'),
                "USER" => $fileusername,
                "ACTION" => $action,
                "OBJECT NAME" => $tablename,
                "OPERATION RESULT" => $filedataset,
                "STATUS" => 'Success',
                "ERROR MESSAGE" => 'NO Error' . $space
            );

            file_put_contents($filename, json_encode($dataToBeWritten) . $space, FILE_APPEND);
        } catch (Exception $fileError) {
            $space = "\r\n"; // For NewLine
            $fileuserdata = $this->session->userdata();
            $fileusername = $fileuserdata->username;
            $filedataset = serialize($data_arr);

            $dataToBeWritten = array($space,
                "DATE" => date('Y-m-d H:i:s'),
                "USER" => $fileusername,
                "ACTION" => $action,
                "OBJECT NAME" => $tablename,
                "OPERATION RESULT" => $filedataset,
                "STATUS" => 'Failure',
                "ERROR MESSAGE" => $fileError . $space
            );

            $this->db->insert('history', $dataToBeWritten);

            return $fileError->getMessage();
        }*/
    }

    // USER FUNCTION LOG
    function userFuncLog($pgid, $func)
    {
        $username = $this->session->userdata('fname');
        $userid = $this->session->userdata('userId');

        if ($pgid == 0) {
            $pcd = '';
            $pgnm = '';
        } else {
            $pgdt = $this->Generic_model->getData('user_page', array('aid', 'pgcd', 'pgnm'), array('aid' => $pgid));
            $pcd = $pgdt[0]->pgcd;
            $pgnm = $pgdt[0]->pgnm;
        }

        //MAC Accress Code for PHP
        ob_start(); // Turn on output buffering
        system('ipconfig /all'); //Execute external program to display output
        $mycom = ob_get_contents(); // Capture the output into a variable
        ob_clean(); // Clean (erase) the output buffer
        $findme = "Physical";
        $pmac = strpos($mycom, $findme); // Find the position of Physical text
        $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
       // echo $mac;
        $logdata_arr = array(
            'usid' => $userid,
            'usnm' => $username,
            'pid' => $pgid,
            'pcd' => $pcd,
            'pnm' => $pgnm,
            'func' => $func,
            'stat' => 1,
            'lgdt' => date('Y-m-d H:i:s'),
            'lgip' => $_SERVER['REMOTE_ADDR'],
            'mcid' => $mac,
        );
        $this->db->insert('user_log', $logdata_arr);
    }

    // ERROR LOG
    function ErrorLog($url, $func, $rgno, $erno)
    {
        $data_arr = array(
            'eurl' => $_SERVER['REQUEST_URI'],  // error url
            'arac' => $func,                    // error function
            'ertb' => $rgno,                    // correct value
            'ermg' => $erno,                    // error value
            'erdt' => date('Y-m-d H:i:s'),
            'erby' => $_SESSION['userId'],
            'stat' => 0,
            'lgip' => $_SERVER['REMOTE_ADDR'],
        );
        $this->db->insert('err_log', $data_arr);
    }

    // ERROR LOG NEW
    function ErrorLogNew($tbnm, $ermsg, $acti)
    {
        $data_arr = array(
            'eurl' => $_SERVER['REQUEST_URI'],  // error url
            'arac' => $acti,                    // error function
            'ertb' => $tbnm,                    // correct value
            'ermg' => $ermsg,                   // error value

            'erdt' => date('Y-m-d H:i:s'),
            'erby' => $_SESSION['userId'],
            'stat' => 0,
        );
        $this->db->insert('err_log', $data_arr);
    }

}

?>
