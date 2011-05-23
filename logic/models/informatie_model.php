<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Informatie_model extends CI_Model
{
	
	public function handle_upload($data)
	{
		$insert['title'] = $data['title'];
		$insert['content'] = $data['file_name'];
		
		if($this->db->insert('tblContent', $insert))
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

	

	
}