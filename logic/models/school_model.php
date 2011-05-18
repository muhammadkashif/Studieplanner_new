<?php

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
	
	public function get_richtingen($id)
	{
		/*
		select sr.id, r.naam, s.naam
		from (tblSchoolHeeftRichting sr INNER JOIN tblStudieRichting r
		ON (sr.id = r.id))
		INNER JOIN tblSchool s ON(sr.school_id = s.id)
		
		WHERE sr.school_id = 4
		*/
		
		$qry = $this->db->query("
								SELECT sr.id, r.naam as studierichting, s.naam as school
								FROM (tblSchoolHeeftRichting sr INNER JOIN tblStudieRichting r ON (sr.id = r.id)) 
								INNER JOIN tblSchool s ON (sr.school_id = s. id)
								WHERE sr.school_id = '" . $id . "'
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
				$data['richtingen'][] = $row['studierichting'];
				$data['school'][] = $row['school'];
			}
		}

		return $data;
	}

	public function get_single_school($id)
	{
		$data['school'] = $this->db->where('id', $id)
						 		   ->get('tblSchool')
						 		   ->result_array();
		
		$data['richting'] = $this->db->query("select r.naam from tblSchoolheeftRichting sr INNER JOIN tblstudierichting r ON (sr.richting_id = r.id) WHERE sr.school_id = '" . $id . "'")
									 ->result_array();
		
		return $data;
	}

	public function get_school_data()
	{
		$data['scholen'] = $this->db->get('tblSchool')
						 			->result_array();
		
		$i = 0;		
		$j = 1;	
		while($i < count($data['scholen']))
		{
			$data['scholen'][$i]['richtingen'] = $this->db->query("select r.naam from tblschoolheeftrichting sr 
																	inner join tblstudierichting r on (sr.richting_id = r.id) where sr.school_id = '" . $j ."'")->result_array();
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
	
	
}