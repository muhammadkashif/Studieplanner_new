<header>
	<div id="yellow"></div>
	<div id="feedback_top"><p>Taak opgeslagen</p></div>
	<div id="container_h">
		<a href="/site">
			<?php
			
				$img_logo = array(
								'src'	=>		'assets/images/header_logo.png',
								'alt'	=>		'Het logo van Studieplanner.be',
								'title'	=>		'Plannen op je best!',
								'id'	=>		'logo'
							);
				echo img($img_logo);
				
			?>
		</a>
		<nav>
			<ul>
				<li <? if($page_title == "Student") {?>class="active"<? } ?>>
					<a href="<?= $base_url; ?>student/">Home</a>
				</li>
				<li <? if($page_title == "Planner") {?>class="active"<? } ?>>
					<a href="<?= $base_url; ?>planner/">Planner</a>
				</li>
				<li <? if($page_title == "Informatie") {?>class="active"<? } ?>>
					<a href="<?= $base_url; ?>student/informatie">Informatie</a>
				</li>
				<li>
					<a href="<?= $base_url; ?>logout">Logout</a>
				</li>
			</ul>
		</nav>
	</div>
</header>
