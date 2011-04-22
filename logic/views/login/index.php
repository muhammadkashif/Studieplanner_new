<header id="login_header">
	<div id="yellow"></div>
	<div id="logo">
		<a href="login">
			<?php
			
				$img_logo = array(
								'src'	=>		'assets/images/login_logo.png',
								'alt'	=>		'Het logo van Studieplanner.be',
								'title'	=>		'Plannen op je best!'
							);
				echo img($img_logo);
				
			?>
		</a>
	</div>
</header>
<div id="login_form">
	
	<?php
	
		echo form_open('login/go');
	
	?>

	<p><!-- email start -->
		<label for="email">E-mailadres</label>

		<?php

			$data = array(
							'name'		=>		'email',
							'id'		=>		'email',
							'placeholder' =>	'login@studieplanner.be',
							'value'		=>		set_value('email'),
							'autocomplete'	=>	'off'
						);
					
			echo form_input($data);
			echo form_error('email'); 
		
		?>
	</p><!-- email end -->
	
	<p><!-- password start -->
		<label for="password">Wachtwoord</label>

		<?php	
	
			$data = array(
							'name'		=>		'password',
							'id'		=>		'password',
							'placeholder' =>	'abc123',
							'value'		=>		set_value('password')
						);
					
			echo form_password($data);
			echo form_error('password'); 
		
		?>
	
	</p><!-- password end-->
	
	<p class="error"><!-- error start -->

	</p><!-- error end -->
	
	<p><!-- submit start -->

		<?php
	
			$data = array(
							'name'		=>		'btnLogin',
							'id'		=>		'btnLogin',
							'value'		=>		'Login'
						);
					
			echo form_submit($data);
		
		?>
		<?php
		
			$img_loader = array(
							'src'	=>		'assets/images/loader.gif',
							'alt'	=>		'AJAX Loader',
							'class'	=>		'loader'
						);
			echo img($img_loader);
			
		?>
	</p><!-- submit end -->
	
	<div style="clear: both">&nbsp;</div>
	
	<?php
		echo form_close();
	?>
	
</div>

<!-- ajax -->
<script type="text/javascript">
	$(document).ready(function(){
		
		$("#btnLogin").click(function(e)	{
			
			// init vars
			var email = $("#email").val();
			var password = $("#password").val();
			
			
			$("p.error").hide();
			$(".loader").show();
			
			
			$.ajax({
				type: "POST",
				url: "/login/go",
				data: ({email: email, password: password}),
				success: function(data){
					$(".loader").hide();
					
					if( ! data['status'])
					{
						$("p.error").html(data['error']);
						$("p.error").slideDown("fast");
					}
					else
					{
						window.location = data['redirect'];
					}
				}
			});
			
			// prevent submit
			e.preventDefault();
		});
	});
</script>