<?php

class Planner extends MY_Controller
{
	public function __construct()
	{
		
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('planner_model');

	}
	
	public function index()
	{

		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav');
		
		$dates = $this->planner_model->create_date_list();

		$this->load->view('planner/dates_content', $dates);		
		$this->load->view('planner/detail_content', $dates);
		
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
		                    'rules'		=> 		'required|xss_clean'
						),
		               	array(
		                    'field'		=> 		'description', 
		                    'label'		=>	 	'omschrijving', 
		                    'rules'		=>		'required|xss_clean'
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
				$result = $this->planner_model->insert_event($data);
				$feedback = array(
								'status'		=>		TRUE,
								'message'		=>		'Taak opgeslagen'
						);
				
				header('Content-type: application/json');
				echo json_encode($feedback);
			}
			
		}

	}
}
