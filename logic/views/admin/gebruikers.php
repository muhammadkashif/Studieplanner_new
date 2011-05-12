<div id="info_content">
	<div id="user_container">
		<h1>Users</h1>	
		<? foreach($user_query->result_array() as $row): ?>
			<div class="<?= $row['id']; ?> user_info">
				<p>naam: <?= $row['firstname'] . " " . $row['lastname'];?></p>
				<p>woonplaats: <?= $row['town']; ?></p>
				<p>studierichting: <?= $row['course']; ?></p>
				<p>geboortedatum: <?= $row['age']; ?></p>
			</div>		
			<? endforeach ?>
		<div class="user_detail">
			<ul>
			<? foreach($user_query->result_array() as $row): ?>
				<li>
					<?
						echo "<a href='#' class=" . $row['id'] . ">" . 
									ucfirst($row['lastname']) . " " . ucfirst($row['firstname'])  . 
							 "</a>";
					?>
				</li>
			<? endforeach ?>
			</ul>
		</div>
		
		<div id="pagination"><?=$pagination_links?></div>	
		
	
	</div>
</div>

<script type="text/javascript">
	$(".user_detail ul li a").click(function(e)	{
		var id = $(this).attr('class');
		
		$(".user_detail").fadeOut();
		$("#pagination").fadeOut();
	 	$(".user_info." + id).slideDown();
	});

</script>