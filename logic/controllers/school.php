<?php

class School extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('school_model');
	}
	
	public function index()
	{
		$this->loadView('school/index');
	}
}