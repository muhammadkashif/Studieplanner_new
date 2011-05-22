<?php

class Informatie extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form', 'url');
		$this->load->library('form_validation');
		$this->load->model('informatie_model');
	}

	public function upload_file()
	{
		$rules = array(
						array(
								'field'		=>		'title',
								'label'		=>		'titel',
								'rules'		=>		'required'
						)
				);
		
		$this->form_validation->set_rules($rules);
		
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('upload', 'Upload mislukt.');
		}
		else
		{
			$config['upload_path'] = './files/';
			$config['allowed_types'] = 'pdf';
			$config['max_size']	= '';
			$config['remove_spaces'] = TRUE;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{
				$this->session->set_flashdata('upload', 'Upload mislukt.');
			}
			else
			{
				$data = $this->upload->data();
				$data['title'] = $this->input->post('title');
				$this->informatie_model->handle_upload($data);
				$this->session->set_flashdata('upload', 'Upload geslaagd.');
			}
		}
	
		
		redirect('admin/informatie');
	}
}