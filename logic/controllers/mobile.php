<?php

class Mobile extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->library('form_validation');
	}
	
/* loading the views.. old school way because I'm too lazy to set up the extended controller at the moment. Don't want to risk destroying the desktop app */
	public function index()
	{
		$this->load->view('mobile/include/header');
		
		$this->load->view('mobile/index');
		
		$this->load->view('mobile/include/footer');
	}
	
	public function about()
	{
		$this->load->view('mobile/include/header');
		
		$this->load->view('mobile/about');
		
		$this->load->view('mobile/include/footer');
	}
	
	public function login()
	{
		$this->load->view('mobile/include/header');
		
		$this->load->view('mobile/login');
		
		$this->load->view('mobile/include/footer');
	}
	
	public function planner()
	{
		$this->load->view('mobile/include/header');
		
		$this->load->view('mobile/planner');
		
		$this->load->view('mobile/include/footer');
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		return true;
	}
	
	
/* login go! */
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
				$this->load->view('mobile/include/header');
				$this->load->view('mobile/login', $feedback);
				$this->load->view('mobile/include/footer');
			}
		}
		else
		{
			// succesvol: session data in session gooien en redirect naar site controller
			$session_data = array(
									'email'			=>		$this->input->post('email'),
									'is_logged_in'	=>		TRUE,
									'role'			=>		$this->db->get_where('tblUsers', array('email'=>$this->input->post('email')))->row()->role,
									'id'			=> 		$this->db->get_where('tblUsers', array('email'=>$this->input->post('email')))->row()->id,
									'firstname'		=>		$this->db->get_where('tblUsers', array('email'=>$this->input->post('email')))->row()->firstname
							);
			$this->session->set_userdata($session_data);
		
			$feedback = array(
							'status'		=>		TRUE,
							'redirect'		=>		'mobile/index'
						);
		
			if($this->input->is_ajax_request())
			{
				header('Content-type: application/json');
				echo json_encode($feedback);
			}
			else
			{
				redirect('/index');
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
