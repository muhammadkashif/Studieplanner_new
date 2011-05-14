<?php

class Mobile extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('planner_model');
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
	
	public function vandaag()
	{
		$this->load->view('mobile/include/header');
		
		$data = $this->planner_model->get_today();	
		$this->load->view('mobile/planner/vandaag', $data);
		
		$this->load->view('mobile/include/footer');
	}
	
	public function week()
	{
		$this->load->view('mobile/include/header');
		
		$data = $this->planner_model->get_week();
		$this->load->view('mobile/planner/week', $data);
		
		$this->load->view('mobile/include/footer');
	}
	
	public function add()
	{
			$this->load->view('mobile/include/header');
			$this->load->view('mobile/planner/add');
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
	
	public function add_event()
	{
		$rules = array(
						array(
							'field'		=>		'title', 
		                    'label'		=> 		'titel', 
		                    'rules'		=> 		'required|xss_clean|strip_tags'
						),
		               	array(
		                    'field'		=> 		'description', 
		                    'label'		=>	 	'omschrijving', 
		                    'rules'		=>		'required|xss_clean|strip_tags'
		               	),
					  	array(
					   		'field'  	=>		'date',
							'label'		=>		'datum',
							'rules'		=>		'trim|required'
						)
		            );
		
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
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
			$data = array(
						'title' 		=> $this->input->post('title'),
						'description' 	=> $this->input->post('description'),
						'date' 			=> $this->input->post('date'),
						'time_start'	=> $this->input->post('start_time'),
						'time_end'		=> $this->input->post('end_time'),
						'type'			=> $this->input->post('event_type'),
						'user_id'		=> $this->session->userdata('id')
					);

			// http://stackoverflow.com/questions/5803856/php-comparing-time
			if(strtotime($data['time_start']) > strtotime($data['time_end']) || strtotime($data['time_start']) < strtotime("08:00:00")
			 																 || strtotime($data['time_start']) == strtotime($data['time_end']))
			{
				$feedback = array(
								'status'		=>		FALSE,
								'error'			=>		'Eind-tijd kan niet vroeger dan of gelijk zijn aan start-tijd'
							);

				header('Content-type: application/json');
				echo json_encode($feedback);
			}
			else
			{
				if( ! $this->input->post('update'))
				{
					$result = $this->planner_model->insert_event($data);
					$feedback = array(
									'status'		=>		TRUE,
									'message'		=>		'Taak opgeslagen'
							);

					header('Content-type: application/json');
					echo json_encode($feedback);
				}
				else
				{
					$data['id'] = $this->input->post('id');
					$result = $this->planner_model->update_event($data);
					$feedback = array(
									'status'		=>		TRUE,
									'message'		=>		'Taak gewijzigd'
							);
					
					header('Content-type: application/json');
					echo json_encode($feedback);
				}
			}
			
		}
	}


/*  form validation callbacks */

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
