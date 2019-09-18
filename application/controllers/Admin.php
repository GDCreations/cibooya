<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
        //Active Page Id
        $data['acm'] = '';
        $data['acp'] = 'dashbrd';
		$this->load->view('common/tmpHeader');
        $this->load->view('admin/common/adminHeader');

        $this->load->view('admin/adminDash');

        $this->load->view('common/tmpFooter',$data);

	}
}
