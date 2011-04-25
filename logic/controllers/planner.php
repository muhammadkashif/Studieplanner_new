<?php

class Planner extends MY_Controller
{
	public function __construct()
	{
		
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('planner_model');

	}
	
	public function index()
	{

		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav');
		
		
		$dates = $this->planner_model->create_date_list();

		$this->load->view('planner/dates_content', $dates);		
		$this->load->view('planner/detail_content', $dates);
		
		$this->load->view('include/footer', $dates);

	}


	// handle ajax dates_content
	public function change_dates()
	{
		$day = '';
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		
		$dates = $this->planner_model->create_date_list($day, $month, $year);
		
		$this->load->view('planner/dates_content', $dates);
	}
	
	// handle ajax detail_content
	public function change_detail()
	{
		$day = $this->input->post('day');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		
		$dates = $this->planner_model->create_date_list($day, $month, $year);

		$this->load->view('planner/detail_content', $dates);
	}
}
