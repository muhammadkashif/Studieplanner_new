<?php

class Informatie extends MY_Controller
{
	public function __construct()
	{
		
		parent::__construct();
	
	}
	
	public function index()
	{
		
		$this->loadView('informatie/index');
		
	}
}
