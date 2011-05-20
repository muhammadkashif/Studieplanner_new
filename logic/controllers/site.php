<?php

class Site extends MY_Controller
{
	public function index()	
	{	
		$role = $this->session->userdata('role');
		
		switch($role)
		{
			case '1':
				redirect('student/');
				break;

			case '3':
				redirect('admin/');
				break;
			
			case '2':
				redirect('school/');
				break;
				
			default:
				redirect("login/");
		}
	}
}
