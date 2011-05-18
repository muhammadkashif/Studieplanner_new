<?php

class School extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('school_model');
	}
	
	public function index()
	{
		$this->loadView('school/index');
	}
		
	public function show_school()
	{
		$id = $this->input->post('id');
		
		$data = $this->school_model->get_single_school($id);
		header('Content-type: application/json');
		echo json_encode($data);
	}
	
	public function save_changes()
	{	
		$data = $this->input->post();
		$rules = array(
	// 	data: { id: school_id, naam: naam, straat: straat, nummer: nummer, plaats: plaats, telefoon: telefoon, fax: fax, email: email, website: website, 
	//			verantwoordelijke: verantwoordelijke, ci_csrf_token: cct },
					array(
							'field'		=>		'naam',
							'label'		=>		'naam',
							'rules'		=>		'required'
					),
					array(
							'field'		=>		'straat',
							'label'		=>		'straat',
							'rules'		=>		'required'
					),
					array(
							'field'		=>		'nummer',
							'label'		=>		'huisnummer',
							'rules'		=>		'required|numeric'
					),
					array(
							'field'		=>		'plaats',
							'label'		=>		'plaats',
							'rules'		=>		'required|alpha_dash'
					),
					array(
							'field'		=>		'telefoon',
							'label'		=>		'telefoon',
							'rules'		=>		'required'
					),
					array(
							'field'		=>		'fax',
							'label'		=>		'fax',
							'rules'		=>		'required'
					),
					array(
							'field'		=>		'email',
							'label'		=>		'e-mail',
							'rules'		=>		'required|valid_email'
					),
					array(
							'field'		=>		'website',
							'label'		=>		'website',
							'rules'		=>		'required'
					),
					array(
							'field'		=>		'verantwoordelijke',
							'label'		=>		'verantwoordelijke',
							'rules'		=>		'required|valid_email'
					)
				);
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE)
		{
			$feedback = array(
							'status'		=>		FALSE,
							'message'		=>		'Formulier niet volledig ingevuld.',
							'errors'		=>		validation_errors()
						);

			header('Content-type: application/json');
			echo json_encode($feedback);
		}
		else
		{
			if($data['id'] != 0)
			{
				if($this->school_model->update_school_data($data))
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

				header('Content-type: application/json');
				echo json_encode($feedback);
			}
			else
			{
				if($this->school_model->add_school_data($data))
				{
					$feedback = array(
									'status'		=>		TRUE,
									'message'		=>		'School toegevoegd aan databank.'
									);
				}
				else
				{
					$feedback = array(
									'status'		=>		FALSE,
									'message'		=>		'Formulier niet volledig ingevuld.'
								);
				}
				
				header('Content-type: application/json');
				echo json_encode($feedback);
			}
		}				
	}
}