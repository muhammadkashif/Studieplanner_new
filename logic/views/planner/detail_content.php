<div id="detail_content">	
	<div class="base">
		<?php

		foreach($details as $key => $detail)
		{
			$header = "<p class='detail_header'>" . ucfirst($dates[$key]['name']) . ", " . $key . " " . $init['curr_month_name'];
			$header .= "<img src='" . base_url() . "assets/images/create_event.png' alt='Plan iets'>";

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
	<script type="text/javascript">
	$(document).ready(function()	{
		
		$("p.detail_header img").click(function()	{
			$("#create_event").show();
		});
	
	   $("#date").datepicker({ showAnim: 'fadeIn'});
		
	});
	</script>
	<div id="create_event">
		<?php
			echo form_open('planner/create_event');
		?>

		<p><!-- title start -->
			<label for="title">Titel</label>
			<?php
				$data = array(
								'name'			=>		'title',
								'id'	 		=>		'title',
								'placeholder'	=>		'',
								'value'			=>		set_value('title')
							);

				echo form_input($data);
			?>
		</p><!-- title end -->			
		<p class='p_descr'><!-- description start -->
			<label for="description">Omschrijving</label>
			<?php
				$data = array(
								'name'			=>		'description',
								'id'			=>		'description',
								'placeholder'	=>		'',
								'value'			=>		set_value('description')
							);

				echo form_textarea($data);
			?>
		</p><!-- description end -->
		<p><!-- date start -->
			<label for="date">Datum:</label> 
			<?php
				$data = array(
								'name'			=>		'date',
								'id'			=>		'date',
								'placeholder'	=>		'',
								'value'			=>		set_value('date')
				);
				
				echo form_input($data);
			?>
		</p><!-- date end -->
		
		<?php
			echo form_close();
		?>
	</div>
</div>