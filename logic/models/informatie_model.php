<?php

class Informatie_model extends CI_Model
{
	
	public function insert_content($data)
	{
		if($this->db->insert('tblContent', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_content()
	{
		$query = $this->db->get('tblContent');
		$i = 0;
		
		if($query->num_rows() == 0)
		{
			$data = FALSE;
		}
		else
		{
			foreach ($query->result() as $row)
			{
				$data['content'][$i]['id'] = $row->id;
				$data['content'][$i]['title'] = $row->title;
				$data['content'][$i]['content'] = $row->content;
				$i++;
			}
		}

		return $data;
	}

	public function get_item($unique_id)
	{
		$this->db->where('unique_id', $unique_id);
		$query = $this->db->get('tblContent');
		
		if($query->num_rows() == 0)
		{
			$data = FALSE;
		}
		else
		{
			$row = $query->row();
			$data['id'] = $row->id;
			$data['title'] = $row->title;
			$data['content'] = $row->content;
		}
		
		return $data;
	}
	
	public function del_content($id)
	{
		$this->db->where('id', $id);
		
		if($this->db->delete('tblContent'))
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
	
}