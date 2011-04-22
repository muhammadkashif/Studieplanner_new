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
			
			header('Content-type: application/json');
			echo json_encode($feedback);
		}
		else
		{
			// succesvol: session data in session gooien en redirect naar site controller
			$session_data = array(
									'email'			=>		$this->input->post('email'),
									'is_logged_in'	=>		TRUE,
									'role'			=>		$this->db->get_where('tblUsers', array('email'=>$this->input->post('email')))->row()->role,
									'id'			=> 		$this->db->get_where('tblUsers', array('email'=>$this->input->post('email')))->row()->id
							);
			$this->session->set_userdata($session_data);
			
			$feedback = array(
							'status'		=>		TRUE,
							'redirect'		=>		'site/index'
						);
			
			header('Content-type: application/json');
			echo json_encode($feedback);
			
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
