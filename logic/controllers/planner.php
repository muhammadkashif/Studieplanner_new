<?php

class Planner extends MY_Controller
{
	public function __construct()
	{	
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('text');
		$this->load->library('form_validation');
		$this->load->model('planner_model');
	
	}
	
	public function index()
	{
		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav');
		
		// lijst met dagen inladen
		$dates = $this->planner_model->create_date_list();
		$this->load->view('planner/dates_content', $dates);		
		$this->load->view('planner/detail_content', $dates);
		
		$this->load->view('planner/event_type');
		$this->load->view('include/footer', $dates);
	}


	// handle ajax dates_content
	public function change_dates()
	{
		$day = '';
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		
		$dates = $this->planner_model->create_date_list($day, $month, $year);
		$this->load->view('planner/dates_content', $dates);
	}
	
	// handle ajax detail_content
	public function change_detail()
	{
		$day = $this->input->post('day');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		
		$dates = $this->planner_model->create_date_list($day, $month, $year);
		$this->load->view('planner/detail_content', $dates);
	}
	
	public function create_event()
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
			// valideren mislukt: feedback array -> json
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
						'title' 				=> $this->input->post('title'),
						'description' 			=> $this->input->post('description'),
						'date' 					=> $this->input->post('date'),
						'time_start'			=> $this->input->post('start_time'),
						'time_end'				=> $this->input->post('end_time'),
						'type'					=> $this->input->post('event_type'),
						'user_unique_id'		=> $this->session->userdata('unique_id')
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
	
	public function get_edit_content()
	{
		$id = $this->input->post('id');
		$data = $this->planner_model->get_single_event_by_id($id);

		header('Content-type: application/json');
		echo json_encode($data[0]);
	}
	
	public function delete_event()
	{
		$id = $this->input->post('id');
		$user_id = $this->session->userdata('unique_id');
		$data = $this->planner_model->delete_event($id, $user_id);
		
		if( ! $data)
		{
			$feedback = array(
							'status'		=>		FALSE,
							'message'		=>		'Fout bij verwijderen'
			);
		}
		else
		{
			$feedback = array(
							'status'		=>		TRUE,
							'message'		=>		'Taak verwijderd'
			);
		}
		
		header('Content-type: application/json');
		echo json_encode($feedback);
	}

	public function create_student_event()
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
		$this->form_validation->set_rules($rules);
	
		if ($this->form_validation->run() == FALSE)
		{
			// valideren mislukt: feedback array -> json
			$feedback = array(
							'status'		=>		FALSE,
							'error'			=>		validation_errors()
						);

			header('Content-type: application/json');
			echo json_encode($feedback);
		}
		else
		{
			// titel starttijd eindtijd datum description
			$data = $this->input->post();
			$data['type'] = "coach";
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
				$t_uid = $this->session->userdata('unique_id');
				if($this->planner_model->create_student_task($data, $t_uid))
				{
					$feedback = array(
									'status'		=>		TRUE,
									'message'		=>		'Taak gepland'
					);
				}
				else
				{
					$feedback = array(
									'status'		=>		FALSE,
									'message'		=>		'U begeleidt momenteel nog geen studenten.'
					);
				}
				
				// role // user_unique_id
				header('Content-type: application/json');
				echo json_encode($feedback);
			}
		}
	}
}
