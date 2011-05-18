<?php

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
		if($this->session->userdata('role') != 2)
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
		
		$data = $this->school_model->get_school_data();
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
		// pagination for users
		$config['base_url'] = base_url() . 'admin/users/';
		$get_total_rows = $this->user_model->get_total_rows();
		$qry = $this->db->query("select count(*) as cnt from tblusers where role = '1'")->result_array();
		$config['total_rows'] = $qry[0]['cnt'];
		$config['per_page'] = 15;
		
		$this->pagination->initialize($config);
		
		
		$init = $this->init->set();
		
		$this->load->view('include/header', $init);
		$this->load->view('include/nav_admin');
		
		$data['user_query'] = $this->user_model->get_users($config['per_page'], $this->uri->segment(3));
		$data['pagination_links'] = $this->pagination->create_links();
		
		if( ! $data)
		{
			$this->load->view('admin/gebruikers');
		}
		else
		{
			$this->load->view('admin/gebruikers', $data);
		}
		
		$this->load->view('include/footer');
	}
	
	
	public function add_content()
	{
	
		$this->loadView('admin/add_content');
	
	}
		
}