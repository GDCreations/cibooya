<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		//$this->load->view('blank');
		$this->load->view('common/tmpHeader');
        $this->load->view('user/common/userHeader');

        $this->load->view('user/dashboard');

        $this->load->view('common/tmpFooter');

	}
}
