<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
	    //Active Page Id
        $data['acm'] = ''; //Module
        $data['acp'] = 'dashbrd'; //Page
		$this->load->view('common/tmpHeader');
        $this->load->view('user/common/userHeader');

        $this->load->view('user/dashboard');

        $this->load->view('common/tmpFooter',$data);

	}
}
