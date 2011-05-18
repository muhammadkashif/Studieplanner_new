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
		
		$qry = $this->db->where('id', $this->session->userdata('id'))
						->where('password', $current)
						->get('tblUsers');
		
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
	
	public function change_pass($pass, $id)
	{
		$data['password'] = md5($pass);
		
 		$this->db->where('id', $id);
		$result = $this->db->update('tblUsers', $data);
	
		return $result;
	}
	
	public function update_profile($data)
	{
		$result = $this->db->where('id', $this->session->userdata('id'))
				 		   ->update('tblUsers', $data);
		
		return $result;
	}
	
	public function update_school_info($data)
	{
		$result = $this->db->where('id', $this->session->userdata('id'))
						   ->update('tblUsers', $data);
						
		return $result;
	}
	
	public function get_profile_data()
	{
		$qry = $this->db->where('id', $this->session->userdata('id'))
						->get('tblUsers');
		
		$row = $qry->result_array();
		$data['user'] = $row[0];
		
		$qry = $this->db->where('id', $data['user']['teacher_id'])
				 		->get('tblUsers');
				
		$row = $qry->result_array();
		$data['leerkracht'] = $row[0];
		// SELECT u.id, u.school_id, s.naam, s.straat, s.nummer, s.plaats, s.email, s.telefoon
		// FROM tblUsers u
		// INNER JOIN tblSchool s
		// ON( u.school_id = s.id )
		// WHERE u.id = 2;
		$qry = $this->db->query("SELECT s.id, s.naam FROM tblUsers u INNER JOIN tblSchool s ON( u.school_id = s.id ) WHERE u.id = '" . $this->session->userdata('id') . "'");
		$row = $qry->result_array();
		$data['school'] = $row[0];
		
		/* select r.naam from tblStudierichting r INNER JOIN tblUsers u ON (r.id = u.richting_id) where u.id = 1 */
		$qry = $this->db->query("SELECT r.id, r.naam FROM tblStudierichting r INNER JOIN tblUsers u ON (r.id = u.richting_id) where u.id = '" . $this->session->userdata('id') . "'");
		$row = $qry->result_array();
		$data['richting'] = $row[0];
		
		return $data;
	}
}