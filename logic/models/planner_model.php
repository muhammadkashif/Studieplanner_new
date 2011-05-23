<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Planner_model extends CI_Model
{
	
	public function create_date_list($day = '', $month = '', $year = '')
	{
		// als er argumenten aan functie zijn meegegeven: deze gebruiken 
		if( ! empty($month) && ! empty($year))
		{
			$data['init'] = array(
							'today'					=>		$day,
							'current_month'			=>		$month,
							'current_year'	 		=>		$year,
							'days_in_curr_month'	=>		cal_days_in_month(CAL_GREGORIAN, $month, $year),
							'next_month'			=>		$month + 1,
							'next_year'				=>		$year + 1
							
					);
		}
		else
		{
			$data['init'] = array(
							'today'					=>		date('j'),
							'current_month'			=>		date('n'),
							'current_year'	 		=>		date('Y'),
							'days_in_curr_month'	=>		cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y')),
							'next_month'			=>		date('n') + 1,
							'next_year'				=>		date('Y') + 1
					);
		}
	
		// naam vd huidige maand in $init steken
		$data['init']['curr_month_name'] = $this->get_month_info($data['init']['current_month']);
		$data['init']['next_month_name'] = $this->get_month_info($data['init']['next_month']);
		// for loop: van 1 tot einde van de maand: array maken
		for($i = 1; $i <= $data['init']['days_in_curr_month']; $i++)
		{
			// day info ophalen vanuit get_day_info($day, $month, $year);
			$day_info = $this->get_day_info($i, $data['init']['current_month'], $data['init']['current_year']);
			
			// naam vd dag (zon, ma, ..)
			$data['dates'][0][$i]['name'] = $day_info['day_name'];
			
			// past or future?
			if($data['init']['current_year'] > date('Y'))
			{
				$data['dates'][0][$i]['frame'] = 'future';
			}
			if($data['init']['current_year'] < date('Y'))
			{
				$data['dates'][0][$i]['frame'] = 'past';
			}
			if($data['init']['current_year'] == date('Y'))
			{
				if($data['init']['current_month'] < date('n'))
				{
					$data['dates'][0][$i]['frame'] = 'past';
				}
				if($data['init']['current_month'] > date('n'))
				{
					$data['dates'][0][$i]['frame'] = 'future';
				}
				if($data['init']['current_month'] == date('n'))
				{
					if($i < date('j'))
					{
						$data['dates'][0][$i]['frame'] = 'past';
					}
					if($i > date('j'))
					{
						$data['dates'][0][$i]['frame'] = 'future';
					}
					if($i == date('j'))
					{
						$data['dates'][0][$i]['frame'] = 'today';
					}
				}
			}
			
			// today type uitzondering
			if( ! empty($data['init']['today']) && $i == $data['init']['today'])
			{
				$data['dates'][0][$i]['type'] = 'today';
			}
			else
			{
				$data['dates'][0][$i]['type'] = $day_info['day_type'];
			}

			// event info ophalen vanuit get_event_info($day, $month, $year);
			$event_info = $this->get_event_info($i, $data['init']['current_month'], $data['init']['current_year']);
			
			$data['dates'][0][$i]['events'] = $event_info;
			// aantal events
			$data['dates'][0][$i]['event_count'] = count($event_info);
			
			// selected logic
			if($i == $data['init']['today'])
			{
				$data['dates'][0][$i]['selected'] = true;
				$data['init']['selected'] = $i;
			}
			else
			{
				$data['dates'][0][$i]['selected'] = false;
			}
			
		}
		
		// eerste dagen vd volgende maand toevoegen aan array
		for($i = 1; $i <= 4; $i++)
		{
			$push[$i] = array();
			if($data['init']['current_month'] == 12)
			{
				$day_info = $this->get_day_info($i, 1, $data['init']['next_year']);
				$event_info = $this->get_event_info($i, 1, $data['init']['next_year']);
			}
			else
			{
				$day_info = $this->get_day_info($i, $data['init']['next_month'], $data['init']['current_year']);
				$event_info = $this->get_event_info($i, $data['init']['next_month'], $data['init']['current_year']);
			}
			$push[$i]['name'] = $day_info['day_name'];
			$push[$i]['frame'] = 'future';
			$push[$i]['type'] = $day_info['day_type'];
			$push[$i]['events'] = $event_info;
			$push[$i]['event_count'] = count($event_info);
			$push[$i]['selected'] = false;
		}	
		$data['dates'][1] = $push;
		
		// detail data voor selected dag
		if(isset($data['init']['selected']))
		{
			$detail_info = $this->get_detail_info($data['init']['selected'], $data['init']['current_month'], $data['init']['current_year'], $data['init']['days_in_curr_month']);
			$data['details'] = $detail_info;
		}
		$data['type'] = $this->populate_type();
		
		return $data;
	}
	

	public function insert_event($data)
	{
		if($this->db->insert('tblEvents', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_single_event_by_id($id)
	{		
		$data = $this->db->where('id', $id)
			 	 		 ->get('tblEvents')
						 ->result_array();
		
		return $data;
	}
	
	public function update_event($data)
	{
		if($this->db->where('id', $data['id'])
				 	->update('tblEvents', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}		
	}
	
	public function delete_event($id, $user_unique_id)
	{
		$row = $this->db->where('id', $id)
			    	    ->get('tblEvents')
						->result_array();
		if($user_unique_id == $row[0]['user_unique_id'])
		{
			$this->db->where('id', $id)
					 ->delete('tblEvents');
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function create_student_task($data, $teacher)
	{
		$query = $this->db->query("
									SELECT s.unique_id
									FROM tblStudents s
									INNER JOIN tblTeacherCoachesStudent tcs
										ON (s.id = tcs.student_id)
									INNER JOIN tblTeachers t
										ON (tcs.teacher_id = t.id)
									WHERE t.unique_id = '" . $teacher . "';
						");
		
		if($query->num_rows == 0)
		{
			return FALSE;
		}
		else
		{
			$students = $query->result_array();
			foreach($students as $student)
			{
				$data['user_unique_id'] = $student['unique_id'];
				$this->db->insert('tblEvents', $data); 
			}

			return TRUE;	
		}
	}
	
	public function get_week_for_user($unique_id)
	{
		$day = date('j');
		$month = date('n');
		$year = date('Y');
		$days_in_curr_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		
		for($i = 1; $i <= 5; $i++)
		{
			$data['week'][$day] = $this->get_event_info($day, $month, $year, $unique_id);
			$day++;
			if($day > $days_in_curr_month)
			{
				$day = 1;
				if($month == 12)
				{
					$month = 1;
				}
				else
				{
					$month++;
				}
			}
		}		
		return $data;	
	}
	
	
	
/* mobile */
	public function get_today()
	{
		$day = date('j');
		$month = date('n');
		$year = date('Y');
		
		$data['today'] = $this->get_event_info($day, $month, $year);
		return $data;
	}
	
	public function get_week()
	{
		$day = date('j');
		$month = date('n');
		$year = date('Y');
		$days_in_curr_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		
		for($i = 1; $i <= 5; $i++)
		{
			$data['week'][$day] = $this->get_event_info($day, $month, $year);
			$day++;
			if($day > $days_in_curr_month)
			{
				$day = 1;
				if($month == 12)
				{
					$month = 1;
				}
				else
				{
					$month++;
				}
			}
		}		
		return $data;
	}
/* private functions */
	
	private function get_detail_info($day, $month, $year, $end_of_month)
	{
		$start_day = $day;
		if($day + 4 > $end_of_month)
		{
			$end_day = $end_of_month;
		}
		else
		{
			$end_day = $day + 4;
		}
		
		for($i = $day; $i <= $end_day; $i++)
		{
			$detail_info[0][$day] = $this->get_event_info($day, $month, $year);
			$detail_info[0][$day]['event_count'] = count($detail_info[0][$day]);
			$day++;	
		}
		if($end_day == $end_of_month)
		{
			$a = $end_of_month - $start_day;
			$add = 4 - $a;
			
			for($i = 1; $i <= $add; $i++)
			{
				$detail_info[1][$i] = $this->get_event_info($i, $month + 1, $year);
				$detail_info[1][$i]['event_count'] = count($detail_info[1][$i]);		
			}
		}
		return $detail_info;
		
	}
	
	private function get_day_info($day, $month, $year)
	{
		$day_name_num = date("w", mktime(0,0,0, $month, $day, $year));
		
		switch($day_name_num)
		{	
			case '0': $day_name = "zon"; $day_type = 'weekend'; break;
			case '1': $day_name = "maa"; $day_type = 'weekdag'; break;
			case '2': $day_name = "din"; $day_type = 'weekdag'; break;
			case '3'; $day_name = "woe"; $day_type = 'weekdag'; break;
			case '4'; $day_name = "don"; $day_type = 'weekdag'; break;
			case '5'; $day_name = "vrij"; $day_type = 'weekdag'; break;
			case '6'; $day_name = "zat"; $day_type = 'weekend'; break;
		}
		
		$day_info = array(
							'day_name'		=>		$day_name,
							'day_type'		=>		$day_type
					);			
		return $day_info;
	}
	
	
	private function get_event_info($day, $month, $year, $id = '')
	{
		// dag maand jaar samenvoegen naar mysql date formaat
		$date = $year . "-" . $month . "-" . $day;
		$this->db->where('date', $date);
		if(empty($id))
		{
			$this->db->where('user_unique_id', $this->session->userdata('unique_id'));	
		}
		else
		{
			$this->db->where('user_unique_id', $id);
		}
		$this->db->order_by('time_start', 'asc');
		$query = $this->db->get('tblEvents');
	
	/*	$query = $this->db->query("
							SELECT e.*, ty.key as type 
							FROM tblEvents e 
							INNER JOIN tblType ty ON (e.type_id = ty.id) WHERE 
							e.date = '" . $date . "' AND e.user_unique_id = '" . $this->session->userdata('unique_id') . "' ORDER BY time_start ASC
						");
	*/
		$event_info = array();	
		$i = 1;
		foreach($query->result() as $row)
		{
			$event_info[$i]['title'] = $row->title;
			$event_info[$i]['description'] = $row->description;
			$event_info[$i]['time_start'] = $row->time_start;
			$event_info[$i]['time_end'] = $row->time_end;
			$event_info[$i]['id'] = $row->id;
			$event_info[$i]['type'] = $row->type;
			$i++;
		}
		
		return $event_info;		
	}
	
	private function get_month_info($month)
	{
		switch($month)
		{
			case '1': $month_name = "januari"; break;
			case '2': $month_name = "februari"; break;
			case '3': $month_name = "maart"; break;
			case '4': $month_name = "april"; break;
			case '5': $month_name = "mei"; break;
			case '6': $month_name = "juni"; break;
			case '7': $month_name = "juli"; break;
			case '8': $month_name = "augustus"; break;
			case '9': $month_name = "september"; break;
			case '10': $month_name = "oktober"; break;
			case '11': $month_name = "november"; break;
			case '12': $month_name = "december"; break;
			default: $month_name = 'januari'; break;
		}		
		return $month_name;
	}
	
	private function populate_type()
	{
		$qry = $this->db->get('tblType', 3);
		foreach($qry->result_array() as $type)
		{
			$data[$type['key']] = $type['naam'];
		}
		
		return $data;
	}
}