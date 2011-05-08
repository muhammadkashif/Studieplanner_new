<div id="info_wrapper">
	<div id="info_content">
		<h1>Tips en technieken</h1>
		<h2>toevoegen</h2>
		
		<div id="add_form">
		<script type="text/javascript">
		tinyMCE.init({
		        mode : "textareas",
		        
		});
		</script>
		<?
		echo form_open('email/send');
		?>
		<p>
			<label for="titel">Titel</label>
			<?
				$data = array(
								'name'		=>		'title',
								'id'		=>		'title',
								'placeholder' =>	'',
								'value'		=>		set_value('title'),
								'autocomplete'	=>	'on'
							);

				echo form_input($data);
			?>
		</p>
		<p>
			<label for="content">Inhoud</label>
			<?
				$data = array(
								'name'			=>		'content',
								'id'			=>		'content',
								'placeholder'	=>		'',
								'value'			=>		set_value('content')
							);

				echo form_textarea($data);
			?>
		</p>
		<?
		echo form_close();
		?>
		</div>
	</div>
</div>
