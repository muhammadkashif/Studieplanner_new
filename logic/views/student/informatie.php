<div id="info_content">
	<div id="info_content_wrapper">
		<div id="tips_list">
			<img src="<?= base_url(); ?>assets/images/header_tips.png" alt="Tips en technieken" />
			<p style="line-height: 1.3em">Deze tips zijn overgenomen uit de werkmap '<em>Eerste hulp bij leerstoornissen en problemen bij het leren bij normaal begaafde kinderen</em>'. <br />
				Ze kunnen je helpen bij het organiseren van je leeromgeving en het studeren van leerstof. Veel succes!</p>
			<ul>
				<?
					if(isset($content))
					{
						$i = 1;
						foreach($content as $item)
						{
							echo "<li><a href='#' name='" . $item['id'] . "'>" . $item['title'] . "</a></li>";
							$i++;
						}
					}
				?>
			</ul>
		</div>
	</div>
	<div class='wysiwyg'>
	</div>
	<div id="back_to_main">
		<a href="#" id="back_link">Terug naar overzicht</a>
	</div>
	
	<div class="clearfix" style="padding-bottom: 15px;"></div>
</div>

<script type="text/javascript">
	$(document).ready(function()	{
		
		$("#tips_list ul li a").click(function(e)	{
			var id = $(this).attr('name');
			var cct = $.cookie('ci_csrf_token');
			
			$.ajax({
				type: "POST",
				url: "/student/print_info_item",
				data: { id: id, ci_csrf_token: cct },
				success: function(data)
				{
					$("#tips_list").hide();
					$(".wysiwyg").html("<h1>" + data['title'] + "</h1>" + data['content']).fadeIn();
					$("#back_to_main").fadeIn();
				}
			});
			
			// prevent submit
			e.preventDefault();
		});
		
		$("#back_link").click(function(e)	{
			$(".wysiwyg").html("").hide();
			$("#back_to_main").hide();
			$("#tips_list").fadeIn();
			
			e.preventDefault();
		})
	});
</script>