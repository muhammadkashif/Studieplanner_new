<div id="info_content">
	<!-- ajax div -->
	<div id="add_content">
		<img src="<?= base_url(); ?>assets/images/header_add_content.png" alt="Nieuwe inhoud toevoegen" />
		<p class="clearfix warning" style="margin-left: 10px">Let op</p>
		<div class="feedback clearfix" style="float: left; margin-left: 190px">

		</div> <!-- feedback -->
		<p class="clearfix"></p>
		<?php
			echo form_open('/informatie/add_content');
		?>

		<p><!-- title start -->
			<label for="title">Titel</label>
			<?php
				$data = array(
								'name'			=>		'title',
								'id'	 		=>		'title',
								'placeholder'	=>		'',
								'value'			=>		set_value('title')
							);

				echo form_input($data);
			?>
		</p><!-- title end -->			
		<p class='p_descr'><!-- description start -->
			<label for="description" class="fix">Inhoud</label>
			<p class="clearfix"></p>
			<?php
				$data = array(
								'name'			=>		'content',
								'id'			=>		'content',
								'placeholder'	=>		'',
								'value'			=>		set_value('content')
							);

				echo form_textarea($data);
			?>
		</p><!-- description end -->

		<p class="clearfix"></p>

		<p class="buttons" style="margin-top: 20px"><!-- buttons start -->
			<?php
				$data = array(
								'name'			=>		'submitContent',
								'id'			=>		'submitContent',
								'value'			=>		'Opslaan'
							);

				echo form_submit($data);

				$js = 'onClick=$("#add_content").hide()';
				$data = array(
								'name'			=>		'cancelContent',
								'id'			=>		'cancelContent',
								'content'		=>		'Annuleren'
							);
				echo form_button($data, '', $js);
			?>
		</p><!-- buttons end -->
		<p class="clearfix"></p>
		<?php
			echo form_close();
		?>
	</div>
	<div id="info_content_wrapper">
		<div id="tips_list">
			
			<img src="<?= base_url(); ?>assets/images/header_tips.png" alt="Tips en technieken" />
			<p>Hier kan u gemakkelijk informatie, tips en technieken toevoegen, bewerken en verwijderen. </p>
			<ul>
				<?
					if(isset($content))
					{
						$i = 1;
						foreach($content as $item)
						{
							echo "<li><a href='#' name='" . $item['id'] . "'>" . $item['title'] . "</a><span>bewerk | verwijder</span></li>";
							$i++;
						}
					}
				?>
			</ul>
			<a href="/admin/add_content" id="voegtoe">nieuwe tip toevoegen</a>
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
		
		$("#submitContent").click(function(e)	{
			
			var title = $("#title").val();
		    var content_temp = tinyMCE.get('content');
			var content = content_temp.getContent();
			$(".feedback").html("");
			
			$.ajax({
				type: "POST",
				url: "/informatie/add_content",
				data: { title: title, content: content },
				success: function(data)
				{
					if(! data['status'])
					{
						$("div.feedback").append("<p class='error'>" + data['error'] + "</p>");
						$("p.warning").slideDown("fast");
						$("div.feedback").slideDown("fast");
					}
					else
					{
						$("#title").val("");
						tinyMCE.activeEditor.setContent('');
						$("#add_content").hide();
						$("#feedback_top").html("<p>" + data['message'] + "</p>").slideDown('slow').delay(2000).slideUp();				
					}
					
				}
			});
			
			// prevent submit
			e.preventDefault();
		});
		
		$("#tips_list ul li a").click(function(e)	{
			var id = $(this).attr('name');
			
			$.ajax({
				type: "POST",
				url: "/informatie/print_item",
				data: { id: id },
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
