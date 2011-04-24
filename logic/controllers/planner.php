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
		$this->load->view('planner/dates_content', $dates);
		
		
		
		$this->load->view('include/footer');

	}

	public function change_dates()
	{

		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$dates = $this->planner_model->create_date_list($month, $year);
		
	    $this->load->view('planner/dates_content', $dates);

	}
}
