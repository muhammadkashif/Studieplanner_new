<?php

class Informatie extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('informatie_model');
	}
	
	/* crud */
	
	// create
	public function add_content()
	{
		$rules = array(
						array(
							'field'		=>		'title', 
		                    'label'		=> 		'titel', 
		                    'rules'		=> 		'required|xss_clean'
						),
		               	array(
		                    'field'		=> 		'content', 
		                    'label'		=>	 	'inhoud', 
		                    'rules'		=>		'required|xss_clean'
		               	),
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
						'title' 		=> 	 $this->input->post('title'),
						'content' 		=>	 $this->input->post('content')
					);
		
			$result = $this->informatie_model->insert_content($data);
			$feedback = array(
							'status'		=>		TRUE,
							'message'		=>		'Nieuwe tip opgeslagen'
					);
			
			header('Content-type: application/json');
			echo json_encode($feedback);		
		}
	}
	
	// read
	public function print_item()
	{
		$id = $this->input->post('id');
		$data = $this->informatie_model->get_item($id);
		
		header('Content-type: application/json');
		echo json_encode($data);
	}
	
	// update
	
	
	// delete
	public function del_content($id)
	{
		
	}
}
