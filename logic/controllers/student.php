<?php

class Student extends MY_Controller
{
	public function __construct()
	{
		
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('informatie_model');
		$this->load->model('user_model');
		
		if($this->session->userdata('role') != 1)
		{
			redirect('/site');
		}
	
	}
	
	public function index()
	{
		
		redirect('/planner');
		
	}
	
	public function tips()
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
	
	public function profiel()
	{
		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav');
		
		$data = $this->user_model->get_profile_data();
		$this->load->view('student/profiel', $data);
		
		$this->load->view('include/footer');
	}
	
	
}
