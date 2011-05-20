<?php

class User_model extends CI_Model
{
	
	public function get_users($per_page, $segment)
	{
		$this->db->where('role', 1)
				 ->order_by('lastname', 'asc');
				
		$data = $this->db->get('tblUsers', $per_page, $segment);	
		
		return $data;
	}

	public function get_total_rows()
	{
		$data = $this->db->query("select count(*) as cnt from tblusers where role = '1'")
						 ->result_array();
		return $data;
	}
	
	public function check_current_pass($current)
	{
		$current = md5($current);
		
		$qry = $this->db->where('unique_id', $this->session->userdata('unique_id'))
						->where('password', $current)
						->get('tblStudents');
		
		if($qry->num_rows == 1)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('current_check', "Het ingegeven wachtwoord is ongeldig.");
			return FALSE;
		}
	}
	
	public function change_pass($pass, $unique_id)
	{
		$data['password'] = md5($pass);
		
 		$this->db->where('unique_id', $unique_id);
		$result = $this->db->update('tblStudents', $data);
	
		return $result;
	}
	
	public function update_profile($data)
	{
		$result = $this->db->where('unique_id', $this->session->userdata('unique_id'))
				 		   ->update('tblStudents', $data);
		
		return $result;
	}
	
	public function update_school_info($data)
	{
		
		$result = $this->db->where('unique_id', $this->session->userdata('unique_id'))
						   ->update('tblStudents', $data);
						
		return $result;
	}
	
	public function student_get_profile_data()
	{
		$qry = $this->db->where('unique_id', $this->session->userdata('unique_id'))
						->get('tblStudents');
		
		$row = $qry->result_array();
		$data['user'] = $row[0];
		
		$qry = $this->db->query("SELECT s.unique_id, s.email, tcs.teacher_id, t.firstname, t.lastname 
			 					 FROM tblStudents s INNER JOIN tblTeacherCoachesStudent tcs ON (s.id = tcs.student_id) 
								 INNER JOIN tblTeachers t ON (tcs.teacher_id = t.id) 
								 WHERE s.unique_id = '" . $this->session->userdata('unique_id') . "'");
				
		$row = $qry->result_array();
		$data['leerkracht'] = $row[0];
		// SELECT u.id, u.school_id, s.naam, s.straat, s.nummer, s.plaats, s.email, s.telefoon
		// FROM tblUsers u
		// INNER JOIN tblSchool s
		// ON( u.school_id = s.id )
		// WHERE u.id = 2;
		$qry = $this->db->query("SELECT s.id, s.naam 
								 FROM tblStudents u 
								 INNER JOIN tblSchool s ON( u.school_id = s.id ) 
								 WHERE u.unique_id = '" . $this->session->userdata('unique_id') . "'");
		$row = $qry->result_array();
		$data['school'] = $row;
		
		/* select r.naam from tblStudierichting r INNER JOIN tblUsers u ON (r.id = u.richting_id) where u.id = 1 */
		$qry = $this->db->query("SELECT s.unique_id, s.email, s.richting_id, r.id, r.naam 
								 FROM tblStudierichting r 
								 INNER JOIN tblStudents s ON (r.id = s.richting_id)
								 WHERE s.unique_id = '" . $this->session->userdata('unique_id') . "'");
		$row = $qry->result_array();
		$data['richting'] = $row[0];
		
		return $data;
	}
	
	public function get_functie_data()
	{
		$data = $this->db->order_by('rol asc')
						 ->get('tblRole')
						 ->result_array();
		return $data;
	}
	
	public function get_users_per_functie($id)
	{
		$this->db->select('firstname, lastname, email');
		switch($id)
		{
			case '1':
				$data = $this->db->get('tblStudents')->result_array();
				break;
			case '2':
				$data = $this->db->get('tblTeachers')->result_array();
				break;
			case '3':
				$data = $this->db->get('tblAdmin')->result_array();
				break;
		}

		return $data;	
	}
	
	public function add_leerkracht($data)
	{
		if($this->db->insert('tblTeachers', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}		
	}
}