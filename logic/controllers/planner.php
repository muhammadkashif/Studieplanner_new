<?php

class Planner extends MY_Controller
{
	public function __construct()
	{
		
		parent::__construct();
		$this->load->model('planner_model');
		
		
	}
	
	public function index($month = '', $year = '')
	{
		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav');
		
		if( ! empty($month) && ! empty($year))
		{
			$dates = $this->planner_model->create_date_list($month, $year);
		}
		else
		{
			$dates = $this->planner_model->create_date_list();
		}
		$this->load->view('planner/days', $dates);
	}

}
