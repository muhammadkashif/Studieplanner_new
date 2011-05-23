<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}	
	
	public function check_email($email)
	{
		$query = $this->db->query("
									SELECT * FROM (
									SELECT s.id AS id, s.email AS email, s.password AS password, s.role AS role FROM tblStudents s
									UNION
									SELECT a.id AS id, a.email AS email, a.password AS password, a.role AS role FROM tblAdmin a
									UNION
									SELECT t.id AS id, t.email AS email, t.password AS password, t.role AS role FROM tblTeachers t
									) AS users WHERE email = '" . $email . "'
							 	");
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
		$query = $this->db->query("
									SELECT * FROM (
									SELECT s.id AS id, s.email AS email, s.password AS password, s.role AS role FROM tblStudents s
									UNION
									SELECT a.id AS id, a.email AS email, a.password AS password, a.role AS role FROM tblAdmin a
									UNION
									SELECT t.id AS id, t.email AS email, t.password AS password, t.role AS role FROM tblTeachers t
									) AS users WHERE email = '" . $this->input->post("email") . "' AND password = '" . md5($pass) . "'
							 	");
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
	
	public function get_role($email)
	{
		$query = $this->db->query("
									SELECT email, role FROM (
									SELECT s.email AS email, s.role AS role FROM tblStudents s
									UNION
									SELECT a.email AS email, a.role AS role FROM tblAdmin a
									UNION
									SELECT t.email AS email, t.role AS role FROM tblTeachers t
									) AS users WHERE email = '" . $email . "'
							 	")
							->result_array();
		$data = $query[0]['role'];
		return $data;
	}
	
	public function get_unique_id($email, $role)
	{
		if($role == 1)
		{
			$query = $this->db->where('email', $email)
							  ->get('tblStudents')
							  ->result_array();
			
		}
		else if($role == 2)
		{
			$query = $this->db->where('email', $email)
							  ->get('tblTeachers')
							  ->result_array();
			
		}

		$data = $query[0]['unique_id'];
		return $data;
	}
	
	public function get_teacher_school_id($email)
	{
		$query = $this->db->where('email', $email)
						  ->get('tblTeachers')
						  ->result_array();
		$data = $query[0]['school_id'];
		return $data;
	}
}
