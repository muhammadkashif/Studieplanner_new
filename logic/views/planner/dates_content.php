<div id="dates_content">
	<script type="text/javascript">
		var current_month;
		var current_year;
		$(document).ready(function()	{

			$("#day_list").fadeIn(600);

			// init
		    current_month = <?= $init['current_month']; ?>;
		    current_year = <?= $init['current_year'] ?>;
		
			// previous, next month ajax call
			$(".previous, .next").click(function(event)	{
				
				var cct = $.cookie('ci_csrf_token');
				$("#days_loader").show();
				if(event.target.id == "previous")
				{
					if(current_month == 1)
					{
						current_month = 12;
						current_year--;
					}
					else
					{
						current_month--;				
					}
				}
				
				if(event.target.id == "next")
				{
					if(current_month == 12)
					{
						current_month = 1;
						current_year++;
					}
					else
					{
						current_month++;
					}
				}
				$.ajax({
					type: "POST",
					url: "/planner/change_dates",
					data: { month: current_month, year: current_year, ci_csrf_token: cct },
					success: function(data)
					{
						$("#dates_content").html(data);
					}
				});
			});
		});

	</script>
	<div id="overview_days">
		<p class="month"><?= ucfirst($init['curr_month_name']) . " " . $init['current_year']; ?></p>
	
		<img src="<?= base_url(); ?>assets/images/days_loader.gif" id="days_loader" alt="ajaxloader"/> 
	
		<div class="clearfix"></div> 
	
		<div class="month_selector previous"><img src="<?= base_url(); ?>assets/images/arrow_l.png" id="previous" alt="Vorige maand" /></div>
	
		<ul id="day_list" class="<?php
				switch($init['days_in_curr_month'])
				{
					case 28:
						echo 'twentyeight';
						break;
					case 29:
						echo 'twentynine';
						break;
					case 30:
						echo 'thirty';
						break;
					case 31:
						echo 'thirtyone';
						break;
				}
				?>">
			<?php foreach($dates[0] as $day => $date): ?>
				<li class="<?php 
								echo $date['type']; 
								if($date['event_count'] > 0) { echo " has_event"; }
								if($date['selected'] == true) { echo " selected "; }
								echo " " . $date['frame'];
							?>"><?= "<p>" . $day . "</p>"; ?></li>
			<?php endforeach; ?>
		</ul>
	
		<div class="month_selector next"><img src="<?= base_url(); ?>assets/images/arrow_r.png" id="next" alt="Volgende maand" /></div> 
	
	</div>
</div>