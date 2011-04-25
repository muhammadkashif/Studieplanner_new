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
		// http://stackoverflow.com/questions/5770419/codeigniter-this-load-vars
		$dates = $this->planner_model->create_date_list();

		$this->load->view('planner/dates_content', $dates);		
		$this->load->view('planner/detail_content', $dates);

		$this->load->view('include/footer', $dates);

	}

	public function change_dates()
	{
		$day = '';
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$dates = $this->planner_model->create_date_list($day, $month, $year);
		
		$this->load->view('planner/dates_content', $dates);
	}
	
	public function change_detail()
	{
		$day = $this->input->post('day');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		
		$dates = $this->planner_model->create_date_list($day, $month, $year);

		$this->load->view('planner/detail_content', $dates);

	}
}
