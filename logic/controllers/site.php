<?php

class Site extends CI_Controller
{
	public function index()	
	{	
		$role = $this->session->userdata('role');
		
		switch($role)
		{
			case '1':
				redirect('student/');
				break;

			case '2':
				redirect('admin/');
				break;

			default:
				redirect("login/");
		}
	}
}
