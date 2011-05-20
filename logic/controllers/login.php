<?php

class Login extends MY_Controller
{
	function __construct()
	{
	
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('login_model');
	
	}
	
	function index()
	{
		
		$this->loadView('login/index');
	
	}
	
	public function go()
	{
		$rules = array(
		               array(
		                     'field'   => 'email', 
		                     'label'   => 'e-mailadres', 
		                     'rules'   => 'trim|required|valid_email|callback_check_email'
		                  ),
		               array(
		                     'field'   => 'password', 
		                     'label'   => 'wachtwoord', 
		                     'rules'   => 'trim|required|alpha_dash|callback_check_pass'
		                  ),
		            );

		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run() == FALSE)
		{
			// valideren mislulkt: feedback array -> json
			$feedback = array(
							'status'		=>		FALSE,
							'error'			=>		validation_errors()
						);
			
			if($this->input->is_ajax_request())
			{
				header('Content-type: application/json');
				echo json_encode($feedback);
			}
			else
			{
				$this->loadView('login/index', $feedback);
			}
		}
		else
		{
			// succesvol: session data in session gooien en redirect naar site controller
			$session_data['email'] = $this->input->post('email');
			$session_data['is_logged_in'] = TRUE;
			$session_data['role'] = $this->login_model->get_role($this->input->post('email'));
			if($session_data['role'] == 1)
			{
				$session_data['unique_id'] = $this->login_model->get_unique_id($this->input->post('email'), $session_data['role']);
			}
			if($session_data['role'] == 2)
			{
				$session_data['unique_id'] = $this->login_model->get_unique_id($this->input->post('email'), $session_data['role']);
				$session_data['school_id'] = $this->login_model->get_teacher_school_id($this->input->post('email'), $session_data['role']);
			}
						
			$this->session->set_userdata($session_data);
			
			$feedback = array(
							'status'		=>		TRUE,
							'redirect'		=>		'site/index'
						);
			
			if($this->input->is_ajax_request())
			{
				header('Content-type: application/json');
				echo json_encode($feedback);
			}
			else
			{
				redirect('site/index');
			}
			
		}
	}
	
	public function check_email($email)
	{
		$result = $this->login_model->check_email($email);
		return $result;
	}
	
	public function check_pass($pass)
	{
		$result = $this->login_model->check_pass($pass);
		return $result;
	}
	
}
