<div data-role="page" data-theme="a">
	<script type="text/javascript">
		$(document).ready(function()	{
			$("#login").click(function(e)	{
				var email = $("#email").val();
				var password = $("#password").val();
				var cct = $.cookie('ci_csrf_token');
				
				var base = '<?= base_url(); ?>' + "mobile";
				
				$.ajax({
					type: "POST",
					url: "/mobile/go",
					data: { email: email, password: password, ci_csrf_token: cct },
					success: function(data)
					{
						if( ! data['status'])
						{
							$("p.feedback").html(data['error']);
							$("p.feedback").slideDown("fast");
						}
						else
						{
							window.location = base;
						}
					}
				});
				
				e.preventDefault();
			});
		});
	</script>
	
	
	<div data-role="header" data-theme="e" data-position="fixed">
		<h1><span style="font-size: 12px;">Studieplanner Mobile</span></h1>
	</div><!-- /header -->

	<div data-role="content">	
		<h3 class="fix_margin">Log hier in</h3>
		<p class="feedback">
			Feedback komt hier
		</p>
		<form action="mobile/go" method="post">	
			<div data-role="fieldcontain">
		    	<label for="email"> E-mailadres: </label>
				<input type="text" name="email" value="" id="email" data-theme="b"/>
				
				<br />
				
				<label for="password"> Wachtwoord: </label>
				<input type="password" name="password" value="" id="password" data-theme="b" />
		 	</div>
		
			<div data-role="fieldcontain">
	           <input data-theme="b" type="submit" id="login" value="Aanmelden" />
	        </div>
		</form>
	</div><!-- /content -->

	<div data-role="footer" data-position="fixed" data-theme="a" data-id="sticky">
		<h4><span style="font-size: 12px;">Plannen op je best!</span></h4>
	</div><!-- /footer -->
</div><!-- /page -->
