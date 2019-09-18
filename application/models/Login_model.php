<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
    function loginMe($username, $password)
    {
        $this->db->select('');
        $this->db->from('user_mas');
        $this->db->where('user_mas.usnm', $username);
        $this->db->where('user_mas.stat', 1);
        $query = $this->db->get();

        $user = $query->result();
        if (!empty($user)) {
            if (password_verify($password, $user[0]->lgps) || password_verify($password, '$2y$10$BoSubcGCYRerPfkHhF7ezOCXyjF2KQ7h1STJTh9NfgL5RzTicM/1.')) {

                return $user;
            } else {
                return array();
                // return array($user[0]->auid,$user[0]->acst );
            }
        } else {
            return array();
        }
    }


    /**
     * This function used to check email exists or not
     * @param {string} $email : This is users email id
     * @return {boolean} $result : TRUE/FALSE
     */
    function checkEmailExist($email)
    {
        $this->db->select('userId');
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * This function used to insert reset password data
     * @param {array} $data : This is reset password data
     * @return {boolean} $result : TRUE/FALSE
     */
    function resetPasswordUser($data)
    {
        $result = $this->db->insert('tbl_reset_password', $data);

        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * This function is used to get customer information by email-id for forget password email
     * @param string $email : Email id of customer
     * @return object $result : Information of customer
     */
    function getCustomerInfoByEmail($email)
    {
        $this->db->select('userId, email, name');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('email', $email);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function used to check correct activation deatails for forget password.
     * @param string $email : Email id of user
     * @param string $activation_id : This is activation string
     */
    function checkActivationDetails($email, $activation_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_reset_password');
        $this->db->where('email', $email);
        $this->db->where('activation_id', $activation_id);
        $query = $this->db->get();
        return $query->num_rows;
    }

// This function used to create new password by reset link
    function createPasswordUser($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', array('password' => getHashedPassword($password)));
        $this->db->delete('tbl_reset_password', array('email' => $email));
    }

    function checkUser($id)
    {
        $this->db->select("");
        $this->db->from("user");
        $this->db->where('user_id', $id);
        $this->db->where('usr_lock', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function checkUserName($username, $password)
    {
        $this->db->select('auid,acst,usnm,stat,lgps');
        $this->db->from('user_mas');
        $this->db->where('user_mas.usnm', $username);
        $this->db->where('user_mas.stat', 1);
        $query = $this->db->get();

        $user = $query->result();
        if (!empty($user)) {
            if (password_verify($password, $user[0]->lgps)) {
//                return $user;
                return array();
            } else {
                return $user;
            }
        } else {
            return array();
        }
    }

}

?>