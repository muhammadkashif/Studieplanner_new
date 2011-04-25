<div id="detail_content">
	<div class="base">
		<?php

		foreach($details as $key => $detail)
		{
			echo "<div class='grid'>";
			echo $key . "<br />";
			for($i = 1; $i <= $details[$key]['event_count']; $i++)
			{
				echo "<div>";
				echo $details[$key][$i]['title'];
				echo $details[$key][$i]['description'];
				echo "</div>";
				echo "<br />";
			}
			echo "</div>";
			
		}
		
		?>
	</div>
</div>
