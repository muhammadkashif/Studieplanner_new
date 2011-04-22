<?php

class Student extends MY_Controller
{
	public function __construct()
	{
		
		parent::__construct();
	
	}
	
	public function index()
	{
		
		$this->loadView('student/index');
		
	}
	
}
