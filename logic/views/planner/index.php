<div id="dates_content">
	<script type="text/javascript">
	
		$(document).ready(function()	{

			$("#day_list").fadeIn(600);

			// init
			var current_month = <?= $init['current_month']; ?>;
			var current_year = <?= $init['current_year'] ?>;
			
			// previous, next month ajax call
			$(".previous, .next").click(function(event)	{
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
					data: { month: current_month, year: current_year },
					success: function(data)
					{
						$("#dates_content").html(data);
					}
				});
			});
			
			$("#day_list li").live("click", function()	{
				$(".selected").removeClass("selected");
				var day = $(this).attr('value');
				$(this).addClass('selected');
			});
		});

	</script>
	<div id="overview_days">
		<p class="month"><?= ucfirst($init['curr_month_name']) . " " . $init['current_year']; ?></p>
		
		<img src="http://www.obscura-design.be/images/days_loader.gif" id="days_loader"/> 
		
		<div class="clearfix"></div> 
		
		<div class="month_selector previous"><img src="http://www.obscura-design.be/images/arrow_l.png" id="previous" /></div>
		
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
			<?php foreach($dates as $day => $date): ?>
				<li class="<?php echo $date['type']; if($date['event_count'] > 0){ echo " has_event";}?>" value="<?= $day ?>"><?= $day; ?></li>
			<?php endforeach; ?>
		</ul>
		
		<div class="month_selector next"><img src="http://www.obscura-design.be/images/arrow_r.png" id="next" /></div> 
		
	</div>
</div>
<div id="detail_content">
	<div class="base">
		<div class='grid'> 
			<p>150px</p> 
		</div>
		<div class='grid'> 
			<p>150px</p> 
		</div>
		<div class='grid'> 
			<p>150px</p> 
		</div>
		<div class='grid'> 
			<p>150px</p> 
		</div>
		<div class='grid'> 
			<p>150px</p> 
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	
</div>

