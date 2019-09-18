<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();

        // Deletes cache for the currently requested URI
        $this->output->delete_cache();

        $this->load->model('login_model');
        $this->load->model('Generic_model', '', TRUE);
        date_default_timezone_set('Asia/Colombo');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            $this->load->view('login');
        } else {
            redirect('/dashboard');
        }
    }


    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $username = $this->input->post('lognm');
        $password = $this->input->post('logps');
        $digeye = $this->input->post('logcd');

        $result = $this->login_model->loginMe($username, $password);

        $ipp = $_SERVER['REMOTE_ADDR'];
        //MAC Accress Code for PHP
        ob_start(); // Turn on output buffering
        system('ipconfig /all'); //Execute external program to display output
        $mycom = ob_get_contents(); // Capture the output into a variable
        ob_clean(); // Clean (erase) the output buffer
        $findme = "Physical";
        $pmac = strpos($mycom, $findme); // Find the position of Physical text
        $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
        function getBrowser()
        {
            $u_agent = $_SERVER['HTTP_USER_AGENT'];
            $bname = 'Unknown';
            $platform = 'Unknown';
            $version = "";
            //First get the platform?
            if (preg_match('/linux/i', $u_agent)) {
                $platform = 'linux';
            } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
                $platform = 'mac';
            } elseif (preg_match('/windows|win32/i', $u_agent)) {
                $platform = 'windows';
            }
            // Next get the name of the useragent yes seperately and for good reason
            if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
                $bname = 'Internet Explorer';
                $ub = "MSIE";
            } elseif (preg_match('/Firefox/i', $u_agent)) {
                $bname = 'Mozilla Firefox';
                $ub = "Firefox";
            } elseif (preg_match('/OPR/i', $u_agent)) {
                $bname = 'Opera';
                $ub = "Opera";
            } elseif (preg_match('/Chrome/i', $u_agent)) {
                $bname = 'Google Chrome';
                $ub = "Chrome";
            } elseif (preg_match('/Safari/i', $u_agent)) {
                $bname = 'Apple Safari';
                $ub = "Safari";
            } elseif (preg_match('/Netscape/i', $u_agent)) {
                $bname = 'Netscape';
                $ub = "Netscape";
            }
            // finally get the correct version number
            $known = array('Version', $ub, 'other');
            $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
            if (!preg_match_all($pattern, $u_agent, $matches)) {
                // we have no matching number just continue
            }
            // see how many we have
            $i = count($matches['browser']);
            if ($i != 1) {
                //we will have two since we are not using 'other' argument yet
                //see if version is before or after the name
                if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                    $version = $matches['version'][0];
                } else {
                    $version = $matches['version'][1];
                }
            } else {
                $version = $matches['version'][0];
            }
            // check if we have a number
            if ($version == null || $version == "") {
                $version = "?";
            }
            return array(
                'name' => $bname,
                'version' => $version,

            );
        }

        $ua = getBrowser();
        $yourbrowser = $ua['name'] . " " . $ua['version'];
        // end 18-11-2018

        $nowtime = date('H');
        // IF CHECK USER LOGIN TIME AND USER MODE
        if ($nowtime < 23 & 1 < $nowtime || $result[0]->usmd == 1) {
            if (count($result) > 0) {
                if ($result[0]->acst == '3') {

                    if ($result[0]->usmd == 1) {
                        foreach ($result as $res) {
                            $sessionArray = array('userId' => $res->auid,
                                'username' => $res->usnm,
                                'role' => $res->usmd,
                                'roleText' => $res->desg,
                                'fname' => $res->fnme,
                                'lname' => $res->lnme,
                                'uimg' => $res->uimg,
                                'lsip' => $res->llip,
                                'lsdt' => $res->lldt,
                                'usrbrnc' => $res->brch,
                                'isLoggedIn' => TRUE
                            );
                            $ip = $_SERVER['REMOTE_ADDR'];
                            //MAC Accress Code for PHP
                            ob_start(); // Turn on output buffering
                            system('ipconfig /all'); //Execute external program to display output
                            $mycom = ob_get_contents(); // Capture the output into a variable
                            ob_clean(); // Clean (erase) the output buffer
                            $findme = "Physical";
                            $pmac = strpos($mycom, $findme); // Find the position of Physical text
                            $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
                            //echo $mac;

                            $this->Generic_model->updateDataWithoutlog('user_mas', array('acst' => 0, 'lgcd' => null, 'llip' => $ip, 'lldt' => date('Y-m-d H:i:s'), 'islg' => 1), array('auid' => $res->auid));
                            $logdata_arr = array(
                                'usid' => $res->auid,
                                'usnm' => $res->usnm,
                                'func' => 'User Login --> ' . $res->usnm,
                                'stat' => 1,
                                'lgdt' => date('Y-m-d H:i:s'),
                                'lgip' => $_SERVER['REMOTE_ADDR'],
                                'mcid' => $mac,
                            );
                            $this->db->insert('user_log', $logdata_arr);

                            $this->session->set_userdata($sessionArray);
                            redirect('/user?message=success');
                        }

                    } else {
                        $badlog_arr = array(
                            'usnm' => $username,
                            'pswd' => $password,
                            'eycd' => $digeye,
                            'lgip' => $ipp,
                            'lgdt' => date('Y-m-d H:i:s'),
                            'brdt' => $yourbrowser,
                            'macd' => $mac,
                        );
                        $this->Generic_model->insertData('user_bad_log', $badlog_arr);
                        redirect('?message=userlock'); // User lock 3 times use wrong password
                    }

                } else {
                    if ($result[0]->lgcd == $digeye) {
                        //restric day end locked users 2018-11-13
                        if ($result[0]->delc == 1) {
                            redirect('?message=Delock');
                        } else {
                            foreach ($result as $res) {
                                $sessionArray = array('userId' => $res->auid,
                                    'username' => $res->usnm,
                                    'role' => $res->usmd,
                                    'roleText' => $res->desg,
                                    'fname' => $res->fnme,
                                    'lname' => $res->lnme,
                                    'uimg' => $res->uimg,
                                    'lsip' => $res->llip,
                                    'lsdt' => $res->lldt,
                                    'usrbrnc' => $res->brch,
                                    'isLoggedIn' => TRUE
                                );
                                $ip = $_SERVER['REMOTE_ADDR'];
                                //MAC Accress Code for PHP
                                ob_start(); // Turn on output buffering
                                system('ipconfig /all'); //Execute external program to display output
                                $mycom = ob_get_contents(); // Capture the output into a variable
                                ob_clean(); // Clean (erase) the output buffer
                                $findme = "Physical";
                                $pmac = strpos($mycom, $findme); // Find the position of Physical text
                                $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address
                                //echo $mac;

                                $this->Generic_model->updateDataWithoutlog('user_mas', array('acst' => 0, 'lgcd' => null, 'llip' => $ip, 'lldt' => date('Y-m-d H:i:s'), 'islg' => 1), array('auid' => $res->auid));
                                $logdata_arr = array(
                                    'usid' => $res->auid,
                                    'usnm' => $res->usnm,
                                    'func' => 'User Login --> ' . $res->usnm,
                                    'stat' => 1,
                                    'lgdt' => date('Y-m-d H:i:s'),
                                    'lgip' => $_SERVER['REMOTE_ADDR'],
                                    'mcid' => $mac,
                                );
                                $this->db->insert('user_log', $logdata_arr);

//                    if ($res->usmd == 1) {
//                        $this->session->set_userdata($sessionArray);
//                        redirect('/admin?message=success');
//                    } elseif ($res->usmd == 5) {
//                        $this->session->set_userdata($sessionArray);
//                        redirect('/user');
//                    }  else {
//                        redirect('/');
//                    }
                                $this->session->set_userdata($sessionArray);
                                redirect('/user?message=success');
                            }
                        }
                    } else {

                        $badlog_arr = array(
                            'usnm' => $username,
                            'pswd' => $password,
                            'eycd' => $digeye,
                            'lgip' => $ipp,
                            'lgdt' => date('Y-m-d H:i:s'),
                            'brdt' => $yourbrowser,
                            'macd' => $mac,
                        );
                        $this->Generic_model->insertData('user_bad_log', $badlog_arr);
                        redirect('?message=wrngLgcd'); // wrong login code
                    }
                }
            } else {
                $result2 = $this->login_model->checkUserName($username, $password);
                if (count($result2) > 0) {
                    if ($result2[0]->acst == '3') {
                        redirect('?message=userlock'); // User lock 3 times use wrong password
                    } else {
                        $chnc = $result2[0]->acst + 1;
                        $this->Generic_model->updateDataWithoutlog('user_mas', array('acst' => $chnc), array('auid' => $result2[0]->auid));

                        $badlog_arr = array(
                            'usnm' => $username,
                            'pswd' => $password,
                            'eycd' => $digeye,
                            'lgip' => $ipp,
                            'lgdt' => date('Y-m-d H:i:s'),
                            'brdt' => $yourbrowser,
                            'macd' => $mac,
                        );
                        $this->Generic_model->insertData('user_bad_log', $badlog_arr);
                        redirect('?message=wrngTry' . $chnc);
                    }
                } else {

                    $badlog_arr = array(
                        'usnm' => $username,
                        'pswd' => $password,
                        'eycd' => $digeye,
                        'lgip' => $ipp,
                        'lgdt' => date('Y-m-d H:i:s'),
                        'brdt' => $yourbrowser,
                        'macd' => $mac,
                    );
                    $this->Generic_model->insertData('user_bad_log', $badlog_arr);
                    redirect('?message=fail');
                }
                // redirect('/');
            }
        } else {
            //redirect('?message=wrongtime');

            $badlog_arr = array(
                'usnm' => $username,
                'pswd' => $password,
                'eycd' => $digeye,
                'lgip' => $ipp,
                'lgdt' => date('Y-m-d H:i:s'),
                'brdt' => $yourbrowser,
                'macd' => $mac,
            );
            $this->Generic_model->insertData('user_bad_log', $badlog_arr);
            redirect('?message=sys_update');
        }

    }

    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';

        $this->load->library('form_validation');

        $this->form_validation->set_rules('login_email', 'Email', 'trim|required|valid_email|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->forgotPassword();
        } else {
            $email = $this->input->post('login_email');

            if ($this->login_model->checkEmailExist($email)) {
                $encoded_email = urlencode($email);

                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum', 15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();

                $save = $this->login_model->resetPasswordUser($data);

                if ($save) {
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if (!empty($userInfo)) {
                        $data1["name"] = $userInfo[0]->name;
                        $data1["email"] = $userInfo[0]->email;
                        $data1["message"] = "Reset Your Password";
                    }

                    $sendStatus = resetPasswordEmail($data1);

                    if ($sendStatus) {
                        $status = "send";
                        setFlashData($status, "Reset password link sent successfully, please check mails.");
                    } else {
                        $status = "notsend";
                        setFlashData($status, "Email has been failed, try again.");
                    }
                } else {
                    $status = 'unable';
                    setFlashData($status, "It seems an error while sending your details, try again.");
                }
            } else {
                $status = 'invalid';
                setFlashData($status, "This email is not registered with us.");
            }
            redirect('/forgotPassword');
        }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $data['sysinfofo'] = $this->Generic_model->getData('com_det', array('cmne', 'synm', 'cplg'), array('stat' => 1));
        $this->load->view('modules/common/forgot_password', $data);
    }

    // This function used to reset the password
    function pwrest()
    {
        ob_start();
        //get the random password
        function generateRandomString($length = 6)
        {
            $characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

        $nwps = generateRandomString();
        $newpassword = password_hash($nwps, PASSWORD_DEFAULT);

        //get the random digitaleye
        function generateRandomNumber($length = 6)
        {
            $characters = '123456789';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

        $dicd = generateRandomNumber();

        $usnm = $this->input->post('usnm');
        $rcml = $this->input->post('email');
        $user = $this->Generic_model->getData('user_mas', array('auid', 'usnm', 'fnme', 'lnme'), array('usnm' => $usnm));
        //check user name is exsist
        if (!empty($user)) {
            $usid = $user[0]->auid;
            $dbus = $user[0]->usnm;
            $fnme = $user[0]->fnme;
            $lnme = $user[0]->lnme;
            $flus = $fnme . " " . $lnme;
            $lgip = $_SERVER['REMOTE_ADDR'];
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
            $comdt = $this->Generic_model->getData('com_det', array('cmne', 'syln'), array('stat' => 1));
            $systnm = $comdt[0]->cmne;
            $sysLink = $comdt[0]->syln;
            // SEND MAIL MESSAGE
            $message = "<tbody>
                <tr><td bgcolor='#F6F8FA' style='background-color:#F6F8FA; padding:12px; border-bottom:1px solid #ECECEC'></td></tr>
                <tr><td style=''><table border='0' cellspacing='0' cellpadding='0' width='100%' style=''><tbody>
                <tr><td style='padding:24px 0 48px'><table border='0' cellspacing='0' cellpadding='0' width='100%' style=''>
                <tbody> <tr><td align='center' style='padding:0 2.2% 32px; text-align:center'><h2 style='margin:0; word-wrap:break-word; color:#262626; word-break:; font-weight:700; font-size:20px; line-height:1.2'></h2><h2 style='margin:0; color:#262626; font-weight:200; font-size:20px; line-height:1.2'> Account Password Reset </h2></td></tr>
                <tr><td align='center' style=''><table border='0' class='x_face-grid x_small' cellspacing='0' cellpadding='0' width='100%' style='table-layout:fixed'><tbody>Hi, $flus <br><br>You recently requested to reset your account password. .<br><br>Username: " . $usnm . "<br>Password:  $nwps  <br>Digital Eye :  $dicd  <br><br></tbody></table></td></tr>
                <tr><td align='center' style='text-align:center'><h2 style='margin:0; color:#262626; font-weight:200; font-size:20px; line-height:1.2'> <a href=' " . $sysLink . "'  style='color:#008CC9; display:inline-block; text-decoration:none'>Login to System</a></h2></td></tr></tbody></table></td></tr></tbody></table></td></tr>
                <tr><td style=''><table border='0' cellspacing='0' cellpadding='0' width='100%' bgcolor='#EDF0F3' align='center' style='background-color:#EDF0F3; padding:0 24px; color:#999999; text-align:center'><tbody>
                <tr><td style=''><table align='center' border='0' cellspacing='0' cellpadding='0' width='100%' style=''><tbody><tr><td valign='middle' align='center' style='padding:0 0 16px 0; vertical-align:middle; text-align:center'></td></tr></tbody></table><table border='0' cellspacing='0' cellpadding='0' width='100%' style=''><tbody><tr><td align='center' style='padding:0 0 12px 0; text-align:center'><p style='margin:0; color:#737373; font-weight:400; font-size:12px; line-height:1.333'>This is a system generated email to help you to get Login Details.</p></td></tr>
                <tr><td align='center' style='padding:0 0 12px 0; text-align:center'><p style='margin:0; word-wrap:break-word; color:#737373; word-break:break-word; font-weight:400; font-size:12px; line-height:1.333'>If you have any questions or if you are encountering problems, our support team at support@gdcreations.com is happy to assist you. Alternatively, you can visit our Support Desk.</p></td></tr>
                <tr><td align='center' style='padding:0 0 8px 0; text-align:center'></td></tr>
                </tbody></table></td></tr></tbody></table></td></tr></tbody>";

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('noreply@northpony.com', $systnm);   // change it to yours
            $this->email->to($rcml);                               // change it to yours    'gamunu@gdcreations.com'
            $this->email->subject('Password reset for Your ' . $systnm . ' Account.');
            $this->email->message($message);
            if ($this->email->send()) {

                $data_arr1 = array(
                    'usid' => $usid, // customer id
                    'usnm' => $usnm,
                    'rcml' => $rcml,
                    'nwps' => $nwps,
                    'dicd' => $dicd,
                    'lgip' => $lgip,
                    'rcdt' => date('Y-m-d H:i:s'),
                );
                $result2 = $this->Generic_model->insertData('user_pass_reset', $data_arr1);
                $data_arr2 = array(
                    'lgps' => $newpassword,
                    'lgcd' => $dicd,
                );
                $where_arr = array(
                    'auid' => $usid
                );
                $result = $this->Generic_model->updateData('user_mas', $data_arr2, $where_arr);
                if (count($result) > 0) {
                    echo json_encode(true);
                    //  redirect('Login/forgotPassword/?message=sucess');
                } else {
                    echo json_encode(false);
                    //redirect('Login/forgotPassword/?message=false');
                }
            } else {
                show_error($this->email->print_debugger());
                echo json_encode(false);
                //redirect('Login/forgotPassword/?message=notsent');
            }
        } else {
            echo json_encode('nouser');
        }
        // $funcPerm = $this->Generic_model->getFuncPermision('userMng');
        // $this->Log_model->userFuncLog($funcPerm[0]->pgid, 'Add New User : ' . $this->input->post('usnm'));
    }


    // This function used to reset the password
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = $this->input->post("email");
        $activation_id = $this->input->post("activation_code");

        $this->load->library('form_validation');

        $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]|max_length[20]');

        if ($this->form_validation->run() == FALSE) {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        } else {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');

            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);

            if ($is_correct == 1) {
                $this->login_model->createPasswordUser($email, $password);

                $status = 'success';
                $message = 'Password changed successfully';
            } else {
                $status = 'error';
                $message = 'Password changed failed';
            }

            setFlashData($status, $message);

            redirect("/login");
        }
    }

    // This function used to create new password

    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);

        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);

        $data['email'] = $email;
        $data['activation_code'] = $activation_id;

        if ($is_correct == 1) {
            $this->load->view('newPassword', $data);
        } else {
            redirect('/login');
        }
    }

}

?>
