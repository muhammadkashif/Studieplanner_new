<?php

class Planner extends MY_Controller
{
	public function __construct()
	{
		
		parent::__construct();
		$this->load->model('planner_model');
		
	}
	
	public function index()
	{
		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav');
		
		$dates = $this->planner_model->create_date_list();

	}

}
