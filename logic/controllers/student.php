<?php

class Student extends MY_Controller
{
	public function __construct()
	{
		
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('informatie_model');
		if($this->session->userdata('role') != 1)
		{
			redirect('/site');
		}
	
	}
	
	public function index()
	{
		
		$this->loadView('student/index');
		
	}
	
	public function informatie()
	{
		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav');
		
		$data = $this->informatie_model->get_content();
		if( ! $data)
		{
			$this->load->view('student/informatie');
		}
		else
		{
			$this->load->view('student/informatie', $data);
		}

		$this->load->view('include/footer');
		
	}
	
	
}
