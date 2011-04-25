<div id="detail_content">
	<div class="base">
		<?php

		foreach($details as $key => $detail)
		{
			$header = "<p class='detail_header'>" . ucfirst($dates[$key]['name']) . ", " . $key . " " . $init['curr_month_name'] . "</p>";
			echo "<div class='grid'>";
			echo $header;
			for($i = 1; $i <= $details[$key]['event_count']; $i++)
			{
				echo "<div class='event'>";
					echo "<p class='event_title'>" . $details[$key][$i]['title'] . "</p>";
					echo $details[$key][$i]['description'];
				echo "</div>";
			}
			echo "</div>";
			
		}
		

		?>
	</div>
</div>