<script type="text/javascript">
	
</script>
<div id="content">
	<div id="overview_days">
		<p class="month"><?= ucfirst($init['curr_month_name']) . " " . $init['current_year']; ?></p>
		
		<img src="http://www.obscura-design.be/images/days_loader.gif" id="days_loader"/> 
		
		<div class="clearfix"></div> 
		
		<div class="month_selector previous"><img src="http://www.obscura-design.be/images/arrow_l.png" /></div>
		
		<ul class="<?php
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
				<li class="<?= $date['type']; ?>"><?= $day; ?></li>
			<?php endforeach; ?>
		</ul>
		
		<div class="month_selector next"><img src="http://www.obscura-design.be/images/arrow_r.png"></div> 
		
	</div>
</div>
