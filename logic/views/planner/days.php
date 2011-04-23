<div id="content">
	<div id="overview_days">
		<ul>
			<?php				// 
							// $i = 1;
							// foreach($dates as $date)
							// {	
							// 	echo "<li>$i</li>";
							// 	echo $i;
							// 	print_r($dates[$i]);
							// 	$i++;
							// }
			?>
			<?php foreach($dates as $date): ?>
				<?php echo key($dates); ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>