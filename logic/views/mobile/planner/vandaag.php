<div data-role="page" data-theme="a">
	
	<div data-role="header" data-theme="e" data-position="fixed">
		<h1><span style="font-size: 12px;">Studieplanner Mobile</span></h1>
	</div>
	
	<div data-role="content">
				
		<h3>Vandaag, <?= date('j') . "/" . date('m') . "/" . date('Y'); ?></h3>
		<? foreach($today as $event): ?>
			<div data-role="collapsible" data-collapsed="true" data-theme="c">
				<h3><?= $event['title']; ?> 
					<span style="float: right">
						<?= substr($event['time_start'], 0, 5); ?> tot <?= substr($event['time_end'], 0, 5); ?>
					</span>
				</h3>
				<p><strong>Beschrijving:</strong></p>
				<p><?= $event['description']; ?></p>
				<p><strong>Type:</strong></p>
				<p><?= ucfirst($event['type']); ?></p>
			</div>
		<? endforeach; ?>
		<?
		if(empty($today))
		{
			echo "<p>Er zijn vandaag nog geen taken gepland.</p>";
		}
		?>
		
	</div>
	
	<div data-role="footer" data-position="fixed" data-theme="a" data-id="sticky">
		<h4><span style="font-size:12px;">Plannen op je best!</span></h4>
	</div>
</div>

