<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_model extends CI_Model
{
	
	public function get_school_names()
	{
		$qry = $this->db->get('tblSchool');
		
		foreach($qry->result_array() as $row)
		{
			$data[] = $row['naam'];
		}
		
		return $data;
	}
	
	public function get_school_info()
	{
		$qry = $this->db->get('tblSchool');
		
		foreach($qry->result_array() as $row)
		{
			$data[] = $row['plaats'];
		}
		
		return $data;
	}
	
	public function get_richtingen()
	{
		$qry = $this->db->query("
								SELECT * FROM tblStudierichting
							");
		$data = array();
		if($qry->num_rows == 0)
		{
			$data['richtingen'][0] = "";
			$data['school'][0] = "";
		}
		else
		{
			foreach($qry->result_array() as $row)
			{
				$data['richtingen'][] = $row['naam'];
			}
		}

		return $data;
	}
	


	public function get_single_school($id)
	{
		$data['school'] = $this->db->where('id', $id)
						 		   ->get('tblSchool')
						 		   ->result_array();
		
		$data['richting'] = $this->db->query("select r.naam from tblSchoolHeeftRichting sr INNER JOIN tblStudierichting r ON (sr.richting_id = r.id) WHERE sr.school_id = '" . $id . "'")
									 ->result_array();
		
		return $data;
	}

	public function get_school_data()
	{
		$data = $this->db->get('tblSchool')
						 			->result_array();
		
		$i = 0;		
		$j = 1;	
		while($i < count($data))
		{
			$data[$i]['richtingen'] = $this->db->query("select r.naam from tblSchoolHeeftRichting sr 
																	inner join tblStudierichting r on (sr.richting_id = r.id) where sr.school_id = '" . $j ."'")->result_array();
			$i++;
			$j++;
		}
		return $data;
	}
	
	public function update_school_data($data)
	{
		$result = $this->db->where('id', $data['id'])
						   ->update('tblSchool', $data);
						
		return $result;
	}
	
	public function add_school_data($data)
	{
		$result = $this->db->insert('tblSchool', $data); 
		return $result;
	}
	
	public function get_users_per_school($id)
	{
		$data['studenten'] = $this->db->query("SELECT u.lastname AS achternaam, u.firstname AS voornaam, u.email, r.naam AS richting
											   FROM tblStudents u 
											   INNER JOIN tblStudierichting r ON (u.richting_id = r.id)
											   WHERE u.school_id = '" . $id . "' 
											   ORDER BY u.lastname, u.firstname, r.naam 
											")
									   ->result_array();
					
		$data['leerkrachten'] = $this->db->where('school_id', $id)
										 ->order_by('lastname asc')
										 ->get('tblTeachers')
										 ->result_array();
		return $data;
	}
	
	public function check_school_has_richting($data)
	{
		$qry = $this->db->where('school_id', $data['school_id'])
				 		->where('richting_id', $data['richting_id'])
				 		->get('tblSchoolHeeftRichting');
		if($qry->num_rows == 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function get_school_by_teacher_uid($unique_id)
	{
		$query = $this->db->query("
									SELECT t.school_id, s.* 
									FROM tblTeachers t 
									INNER JOIN tblSchool s ON (t.school_id = s.id) 
									WHERE t.unique_id = '" . $unique_id . "'
								")
							->result_array();
		$data = $query[0];
		return $data;
	}
	
	public function get_richtingen_by_teacher_uid($unique_id)
	{
		$query = $this->db->query("
									SELECT t.school_id, shr.richting_id, r.naam 
									FROM tblTeachers t 
									INNER JOIN tblSchoolHeeftRichting shr ON(t.school_id = shr.school_id) 
									INNER JOIN tblStudierichting r ON (shr.richting_id = r.id)
									WHERE t.unique_id = '" . $unique_id . "'
								");
							
		if($query->num_rows() == 0)
		{
			$data[0]['naam'] = "nog geen richtingen toegevoegd";
		}
		else
		{
		foreach($query->result_array() as $richting)
		{
			$data[]['naam'] = $richting['naam'];
		}
		}
		return $data;
	}	
	
	public function add_studierichting($school_id, $data)
	{
		$this->db->insert('tblStudierichting', $data);
		$richting_id = $this->db->insert_id();
		
		$this->db->query("INSERT INTO tblSchoolHeeftRichting (school_id, richting_id) VALUES ('" . $school_id . "', '" . $richting_id . "')");
		
		return TRUE;
	}
	
}