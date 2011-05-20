<?php

class School extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('school_model');
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		$this->school();
	}
	
	public function school()
	{
		$init = $this->init->set();		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav_school');

		$data = $this->school_model->get_school_by_teacher_uid($this->session->userdata('unique_id'));
		$this->load->view('school/school', $data);

		$this->load->view('include/footer');
	}
	
	public function leerlingen()
	{
		$this->loadView("school/leerlingen");
	}
	
	public function tips()
	{
		$this->loadView("school/tips");
	}
	
	public function save_school_data()
	{
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
			$data = $this->input->post();
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
	}
}