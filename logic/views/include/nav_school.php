<header>
	<div id="yellow"></div>
	<div id="feedback_top"></div>
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
				<li <? if($page_title == "School") {?>class="active"<? } ?>>
					<a href="<?= $base_url; ?>school/school">School</a>
				</li>	
				<li <? if($page_title == "Leerlingen") {?>class="active"<? } ?>>
					<a href="<?= $base_url; ?>school/leerlingen">Leerlingen</a>
				</li>
				<li <? if($page_title == "Tips") {?>class="active"<? } ?>>
					<a href="<?= $base_url; ?>school/tips">Tips</a>
				</li>
				<li>
					<a href="<?= $base_url; ?>logout">Log uit</a>
				</li>
			</ul>
		</nav>
	</div>
</header>