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
}