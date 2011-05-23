<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('informatie_model');
		$this->load->model('user_model');
		$this->load->model('school_model');
		if($this->session->userdata('role') != 3)
		{
			redirect('/site');
		}
	}
	
	public function index()
	{
		redirect('admin/scholen');
	}
	
	public function scholen()
	{
		$init = $this->init->set();		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav_admin');
		
		$data['scholen'] = $this->school_model->get_school_data();
		$this->load->view('admin/scholen', $data);

		$this->load->view('include/footer');
	}
	
	public function informatie()
	{
		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav_admin');
		
		$data = $this->informatie_model->get_content();
		if( ! $data)
		{
			$this->load->view('admin/informatie');
		}
		else
		{
			$this->load->view('admin/informatie', $data);
		}

		$this->load->view('include/footer');
		
	}
	
	
	public function gebruikers()
	{		
		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav_admin');
		
		$data['scholen'] = $this->school_model->get_school_data();
		$data['functies'] = $this->user_model->get_functie_data();
		$this->load->view('admin/gebruikers', $data);

		$this->load->view('include/footer');
	}
	
	
	public function add_content()
	{
	
		$this->loadView('admin/add_content');
	
	}
	
	public function school_save_changes()
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
	
	public function get_users_per_school()
	{
		$id = $this->input->post('id');
		
		$data = $this->school_model->get_users_per_school($id);
		
		header('Content-type: application/json');
		echo json_encode($data);		
	}
	
	public function get_users_per_functie()
	{
		$id = $this->input->post('id');		
		$data = $this->user_model->get_users_per_functie($id);

		header('Content-type: application/json');
		echo json_encode($data);
	}
	
	public function show_school()
	{
		$id = $this->input->post('id');
		
		$data = $this->school_model->get_single_school($id);
		header('Content-type: application/json');
		echo json_encode($data);
	}
	
	public function add_leerkracht()
	{		
		$rules = array(
						array(
								'field'		=>		'firstname',
								'label'		=>		'voornaam',
								'rules'		=>		'required'
						),
						array(
								'field'		=>		'lastname',
								'label'		=>		'achternaam',
								'rules'		=>		'required'
						),
						array(
								'field'		=>		'email',
								'label'		=>		'e-mail',
								'rules'		=>		'required|valid_email'
						),
						array(
								'field'		=>		'password',
								'label'		=>		'wachtwoord',
								'rules'		=>		'required'
						)
					);
		
		$this->form_validation->set_rules($rules);
		
		
		if($this->form_validation->run() == FALSE)
		{
			$feedback = array(
							'status'		=>		FALSE,
							'message'		=>		'Formulier niet volledig ingevuld.',
							'errors'		=>		validation_errors()
						);
		}
		else
		{
			$data = $this->input->post();
			$data['password'] = md5($data['password']);
			$data['unique_id'] = md5($data['email']);
			if($this->user_model->add_leerkracht($data))
			{
				$feedback = array(
								'status'		=>		TRUE,
								'message'		=>		'Leerkracht toegevoegd aan databank.'
							);
			}
			else
			{
				$feedback = array(
								'status'		=>		FALSE,
								'message'		=>		'Toevoegen leerkracht mislukt.'
							);
			}
		}
		
		header('Content-type: application/json');
		echo json_encode($feedback);
	}	
}