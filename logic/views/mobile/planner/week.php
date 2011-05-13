<div data-role="page" data-theme="a">
	
	<div data-role="header" data-theme="e" data-position="fixed">
		<h1><span style="font-size: 12px;">Studieplanner Mobile</span></h1>
	</div>
	
	<div data-role="content">
		<h3>Deze week</h3>
		<br />
		<? foreach($week as $day_nr => $day): ?>
			<ul data-role="listview" data-dividertheme="a">
				<li data-role="list-divider"><?= $day_nr ?></li>
			</ul>
			<br />
			
			<? foreach($day as $event): ?>
				<div data-role="collapsible" data-collapsed="true" data-theme="c">
					<h3><?= $event['title']; ?></h3>
					<p><?= $event['description']; ?></p>
				</div>
			<? endforeach;?>			
			<br />

		<? endforeach; ?>
	</div>
	
	<div data-role="footer" data-position="fixed" data-theme="a" data-id="sticky">
		<h4><span style="font-size:12px;">Plannen op je best!</span></h4>
	</div>
</div>	