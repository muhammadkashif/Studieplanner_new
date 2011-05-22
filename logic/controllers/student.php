<?php

class Student extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('informatie_model');
		$this->load->model('user_model');
		$this->load->model('school_model');
		
		if($this->session->userdata('role') != 1)
		{
			redirect('/site');
		}
	}
	
	public function index()
	{
		redirect('/planner');	
	}
	
	public function tips()
	{
		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav');
		
		$data = $this->informatie_model->get_content();
		if( ! $data)
		{
			$this->load->view('student/informatie');
		}
		else
		{
			$this->load->view('student/informatie', $data);
		}

		$this->load->view('include/footer');
		
	}
	
	public function profiel()
	{
		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav');
		
		$data = $this->user_model->student_get_profile_data();
		$this->load->view('student/profiel', $data);
		
		$this->load->view('include/footer');
	}
	
	
	// informatie: read
	public function print_info_item()
	{
		$id = $this->input->post('id');
		$data = $this->informatie_model->get_item($id);
		
		header('Content-type: application/json');
		echo json_encode($data);
	}
	
	/* PROFIEL */
	public function save_personal()
	{
		// al in $data array zetten want moet naar update() statement en dat ding heeft een voorliefde voor arrays
		$data = array(
						'firstname'		=>		$this->input->post('firstname'),
						'lastname'		=>		$this->input->post('lastname'),
						'birthdate'		=>		$this->input->post('date'),
						'town'			=>		$this->input->post('town'),
						'email'			=>		$this->input->post('email')
				);

		// set rules
		$rules = array(
					array(
							'field'		=>		'firstname',
							'label'		=>		'voornaam',
							'rules'		=>		'required|alpha_dash|xss_clean',
					),
					array(
							'field'		=>		'lastname',
							'label'		=>		'achternaam',
							'rules'		=>		'required|alpha_dash|xss_clean'
					),
					array(
							'field'		=>		'date',
							'label'		=>		'datum',
							'rules'		=>		'required|xss_clean'
					),
					array(
							'field'		=>		'town',
							'label'		=>		'woonplaats',
							'rules'		=>		'required|alpha_dash|xss_clean'
					),
					array(
							'field'		=>		'email',
							'label'		=>		'e-mail',
							'rules'		=>		'required|trim|valid_email|xss_clean|trim'
					)
				);
				
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run() == FALSE)
		{
			$feedback = array(
							'status'		=>		FALSE,
							'message'		=>		'Het formulier is niet volledig.'
						);
						
			header('Content-type: application/json');
			echo json_encode($feedback);			
		}
		else
		{
			if($this->user_model->update_profile($data))
			{	
				$feedback = array(
								'status'		=>		TRUE,
								'message'		=>		'Gegevens gewijzigd.'
							);
			}
			else
			{
				$feedback = array(
								'status'		=>		FALSE,
								'message'		=>		'Kon gegevens niet wijzigen.'
							);
			}
						
			header('Content-type: application/json');
			echo json_encode($feedback);
		}
	}
	
	public function save_school()
	{
		$data = array(
						'richting_id'	=>		$this->input->post('richting_id'),
						'school_id'		=>		$this->input->post('school_id')			
				);
	
		$rules = array(
					array(
							'field'		=>		'richting_id',
							'label'		=>		'studierichting',
							'rules'		=>		'required'
					),
					array(
							'field'		=>		'school_id',
							'label'		=>		'school',
							'rules'		=>		'required'
					)
				);
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE)
		{
			$feedback = array(
							'status'		=>		FALSE,
							'message'		=>		'Formulier niet volledig ingevuld.'
						);

			header('Content-type: application/json');
			echo json_encode($feedback);
		}
		else
		{
			if($this->school_model->check_school_has_richting($data))
			{
				if($this->user_model->update_school_info($data))
				{	
					$feedback = array(
									'status'		=>		TRUE,
									'message'		=>		'Schoolgegevens aangepast.'
								);
				}
				else
				{
					$feedback = array(
									'status'		=>		FALSE,
									'message'		=>		'Formulier niet volledig ingevuld.'
								);
				}
			}
			else
			{
				$feedback = array(
									'status'		=>		FALSE,
									'message'		=>		'Deze school biedt deze richting niet aan.'
							);
			}

			header('Content-type: application/json');
			echo json_encode($feedback);
		}
	}
	
	public function edit_pass()
	{
		$current = $this->input->post('huidig');
		$new = $this->input->post('nieuw');
		$confirm = $this->input->post('bevestigen');
		$unique_id = $this->session->userdata('unique_id');
		
		$rules = array(
					array(
							'field'		=>		'huidig',
							'label'		=>		'huidig wachtwoord',
							'rules'		=>		'required|callback_current_check'
					),
					
					array(
							'field'		=>		'nieuw',
							'label'		=>		'nieuw wachtwoord',
							'rules'		=>		'required'
					),
					
					array(
							'field'		=>		'bevestigen',
							'label'		=>		'bevestig wachtwoord',
							'rules'		=>		'required|callback_confirm_check'
					)
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run() == FALSE)
		{
			$feedback = array(
							'status'		=>		FALSE,
							'message'		=>		'Kan wachtwoord niet wijzigen.'
						);
			
			header('Content-type: application/json');
			echo json_encode($feedback);
		}
		else
		{
			if($this->user_model->change_pass($confirm, $unique_id))
			{	
				$feedback = array(
								'status'		=>		TRUE,
								'message'		=>		'Wachtwoord gewijzigd.'
							);
			}
			else
			{
				$feedback = array(
								'status'		=>		FALSE,
								'message'		=>		'Kan wachtwoord niet wijzigen.'
							);
			}
						
			header('Content-type: application/json');
			echo json_encode($feedback);
		}
	}

	public function search_school()
	{	
		$input = strtolower( $_GET['input'] );
		$len = strlen($input);
		$limit = 5;
		
		$aNames = $this->school_model->get_school_names();
		$aInfo = $this->school_model->get_school_info();
		
		$aResults = array();
		$count = 0;

		if ($len)
		{
			for ($i=0;$i<count($aNames);$i++)
			{
				if (strtolower(substr(utf8_decode($aNames[$i]),0,$len)) == $input)
				{
					$count++;
					$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($aNames[$i]), "info"=>htmlspecialchars($aInfo[$i]) );
				}

				if ($limit && $count==$limit)
					break;
			}
		}

		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
		header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header ("Pragma: no-cache"); // HTTP/1.0


			header("Content-Type: application/json");

			echo "{\"results\": [";
			$arr = array();
			for ($i=0;$i<count($aResults);$i++)
			{
				$arr[] = "{\"id\": \"".$aResults[$i]['id']."\", \"value\": \"".$aResults[$i]['value']."\", \"info\": \"" . $aResults[$i]['info'] . "\"}";
			}
			echo implode(", ", $arr);
			echo "]}";
	}

	public function search_richting()
	{
		$input= strtolower( $_GET['input'] );
		$len = strlen($input);
		$limit = 5;
		$school_id = $_GET['id'];
		
		$data = $this->school_model->get_richtingen();
		$aRichtingen = $data['richtingen'];
		$aResults = array();
		$count = 0;
		
		if ($len)
		{
			for ($i=0;$i<count($aRichtingen);$i++)
			{
				if (strtolower(substr(utf8_decode($aRichtingen[$i]),0,$len)) == $input)
				{
					$count++;
					$aResults[] = array( 
											"id"=>($i+1),
											"value"=>htmlspecialchars($aRichtingen[$i])
										);
				}

				if ($limit && $count==$limit)
					break;
			}
		}

		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
		header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header ("Pragma: no-cache"); // HTTP/1.0
		header("Content-Type: application/json");

		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<count($aResults);$i++)
		{
			$arr[] = "{\"id\": \"".$aResults[$i]['id']."\", \"value\": \"".$aResults[$i]['value']."\"}";
		}
		echo implode(", ", $arr);
		echo "]}";	
	}

	/* callback methods */
	public function current_check($current)
	{
		$result = $this->user_model->check_current_pass($current);
		return $result;
	}
	
	public function confirm_check($confirm)
	{
		if($this->input->post('nieuw') == $confirm)
		{
			return TRUE;
		}
		else
		{	
			$this->form_validation->set_message('confirm_check', "Wachtwoorden niet gelijk.");
			return FALSE;
		}
	}
	
	
}
