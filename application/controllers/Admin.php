<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		//$this->load->view('blank');
		$this->load->view('common/tmpHeader');
        $this->load->view('admin/common/adminHeader');

        $this->load->view('admin/adminDash');

        $this->load->view('common/tmpFooter');

	}
	public function a1()
	{
		//$this->load->view('blank');
		$this->load->view('common/tmpHeader');
        $this->load->view('user/common/userHeader');

        $this->load->view('user/userBody2');

        $this->load->view('common/tmpFooter');
	}


}
