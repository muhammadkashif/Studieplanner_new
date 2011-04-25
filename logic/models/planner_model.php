<?php

class Planner_model extends CI_Model
{
	
	public function create_date_list($day = '', $month = '', $year = '')
	{
		// als er argumenten aan functie zijn meegegeven: deze gebruiken tenzij we in DEZE MAAND zijn, dan naar else want TODAY nodig.
		if( ! empty($month) && ! empty($year) && ($month != date('n') || $year != date('Y')))
		{
			$data['init'] = array(
							'today'					=>		'',
							'current_month'			=>		$month,
							'current_year'	 		=>		$year,
							'days_in_curr_month'	=>		cal_days_in_month(CAL_GREGORIAN, $month, $year)
							
					);

		}
		// anders huidige maand/jaar/dag
		else
		{
			$data['init'] = array(
							'today'					=>		date('j'),
							'current_month'			=>		date('n'),
							'current_year'	 		=>		date('Y'),
							'days_in_curr_month'	=>		cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'))
					);
		}
		
		if( ! empty($day))
		{
			$data['init']['today'] = $day;
		}

		$data['init']['curr_month_name'] = $this->get_month_info($data['init']['current_month']);

		// for loop: van 1 tot einde van de maand: array maken
		for($i = 1; $i <= $data['init']['days_in_curr_month']; $i++)
		{
			// day info ophalen vanuit get_day_info($day, $month, $year);
			$day_info = $this->get_day_info($i, $data['init']['current_month'], $data['init']['current_year']);
			
			// naam vd dag (zon, ma, ..)
			$data['dates'][$i]['name'] = $day_info['day_name'];
			
			// today type uitzondering
			if( ! empty($data['init']['today']) && $i == $data['init']['today'])
			{
				$data['dates'][$i]['type'] = 'today';
			}
			else
			{
				$data['dates'][$i]['type'] = $day_info['day_type'];
			}
			
			// event info ophalen vanuit get_event_info($day, $month, $year);
			$event_info = $this->get_event_info($i, $data['init']['current_month'], $data['init']['current_year']);
			
			$data['dates'][$i]['events'] = $event_info;
			// aantal events
			$data['dates'][$i]['event_count'] = count($event_info);
			
			// selected logic
			if($i == $data['init']['today'])
			{
				$data['dates'][$i]['selected'] = true;
				$data['init']['selected'] = $i;
			}
			else
			{
				$data['dates'][$i]['selected'] = false;
			}
			
		}
		if(isset($data['init']['selected']))
		{
			$detail_info = $this->get_detail_info($data['init']['selected'], $data['init']['current_month'], $data['init']['current_year'], $data['init']['days_in_curr_month']);
			$data['details'] = $detail_info;
		}
		
		return $data;
	}
	
	private function get_detail_info($day, $month, $year, $end_of_month)
	{
	
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
			$detail_info[$day] = $this->get_event_info($day, $month, $year);
			$detail_info[$day]['event_count'] = count($detail_info[$day]);
			$day++;
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
	
	
	private function get_event_info($day, $month, $year)
	{
		// dag maand jaar samenvoegen naar mysql date formaat
		$date = $year . "-" . $month . "-" . $day;
		$this->db->where('date', $date);
		$this->db->where('user_id', $this->session->userdata('id'));	
		$query = $this->db->get('tblEvents');
		
		$event_info = array();
		
		$i = 1;
		foreach($query->result() as $row)
		{
			
			$event_info[$i]['title'] = $row->title;
			$event_info[$i]['description'] = $row->description;
			$event_info[$i]['time_start'] = $row->time_start;
			$event_info[$i]['time_end'] = $row->time_end;
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
		}
		
		return $month_name;	
	}
	
}
