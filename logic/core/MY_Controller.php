<?php

 class MY_Controller extends CI_Controller {

    function __construct() {
        
		parent::__construct();
		
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
			$this->load->view('include/nav');
		}
        
		$this->load->view($view, $data);
        $this->load->view('include/footer');
    }
}

