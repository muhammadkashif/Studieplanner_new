<?php

class Init extends CI_Model
{
	public function set()
	{
		$data = array(
					'page_title'		=>		ucfirst($this->uri->segment(2, $this->uri->segment(1))),
					'base_url'			=>		base_url(),
					'upl_error'			=>		''
				);		
		
		return $data;
	}
	
}
