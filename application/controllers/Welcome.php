<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//$this->load->view('blank');
		$this->load->view('common/tmpHeader');
        $this->load->view('user/common/userHeder');

        $this->load->view('user/userBody');

        $this->load->view('common/tmpFooter');

	}
	public function a1()
	{
		//$this->load->view('blank');
		$this->load->view('common/tmpHeader');
        $this->load->view('user/common/userHeder');

        $this->load->view('user/userBody2');

        $this->load->view('common/tmpFooter');
        //Janaka Udayanaga 2019-09-16
        // gemunu udaya git change
        // Newww 123
        //New 456
	}


}
