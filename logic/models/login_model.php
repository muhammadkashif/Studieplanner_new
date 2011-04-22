<?php

class Login_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}	
	
	public function check_email($email)
	{
		$this->db->where('email', $email);
		$query = $this->db->get('tblUsers');
		if($query->num_rows == 1)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_email', "$email is een onbekend e-mailadres.");
			return FALSE;
		}
	}
	
	public function check_pass($pass)
	{
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', md5($pass));
		$query = $this->db->get('tblUsers');
		if($query->num_rows == 1)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_pass', "Het ingegeven wachtwoord is ongeldig.");
			return FALSE;
		}
	}
}
