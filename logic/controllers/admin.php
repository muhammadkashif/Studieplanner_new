<?php

class Admin extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('informatie_model');
		if($this->session->userdata('role') != 2)
		{
			redirect('/site');
		}
	}
	
	public function index()
	{
		$this->loadView('admin/index');
	}
	
	public function informatie()
	{
		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav_admin');
		
		$data = $this->informatie_model->get_content();
		if( ! $data)
		{
			$this->load->view('admin/informatie');
		}
		else
		{
			$this->load->view('admin/informatie', $data);
		}

		$this->load->view('include/footer');
		
	}
	
	public function add_content()
	{
	
		$this->loadView('admin/add_content');
	
	}
		
}