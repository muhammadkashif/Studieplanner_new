<?php

 class MY_Controller extends CI_Controller {

    function __construct() {
        
		parent::__construct();
		$this->load->library('user_agent');
		date_default_timezone_set('Europe/Brussels');
		if($this->agent->is_mobile())
		{
			redirect('http://m.frenchyimfaking.com/mobile');
		}
		
		if( ! ($this->uri->segment(1) == "login"))
		{
			if( ! $this->session->userdata('is_logged_in'))
			{
				redirect("login");
			}
		}
		
    }

    public function loadView($view) {
        
		$data = $this->init->set();
		
		$this->load->view('include/header', $data);
		
		if( ! ($this->uri->segment(1) == "login"))
		{
			if($this->session->userdata('role') == 1)
			{
				$this->load->view('include/nav');
			}
			else if($this->session->userdata('role') == 3)
			{
				$this->load->view('include/nav_admin.php');
			}
			else if($this->session->userdata('role') == 2)
			{
				$this->load->view('include/nav_school.php');
			}
		}

		$this->load->view($view, $data);

        $this->load->view('include/footer');
    }
}

