<div data-role="page" data-theme="a">
	<script type="text/javascript">
		$(document).ready(function(){
			$("#logout").click(function(e)	{
				
				$.ajax({
					type: "POST",
					url: "/mobile/logout",
					success: function(data)
					{
						window.location = "<?= base_url(); ?>mobile";
					}
				});
				return(false);
			});
			
		});
	</script>
	<div data-role="header" data-theme="e" data-position="fixed">
		<h1><span style="font-size: 12px;">Studieplanner Mobile</span></h1>
	</div><!-- /header -->

	<div data-role="content">	
		<?
		if( ! $this->session->userdata("is_logged_in"))	
		{
			echo "<p><strong>Welkom</strong> bij de mobiele versie van <strong>Studieplanner!</strong></p>";
		}
		else 
		{
			echo "<p>Welkom terug, " . ucfirst($this->session->userdata('firstname')) . "</p>";
		}
		?>
		<ul data-role="listview" data-inset="true">
		<?
		if( ! $this->session->userdata("is_logged_in")) 
		{
			echo "<li> <a href='mobile/login'>Aanmelden</a> </li>";
		}
		else
		{
			echo "<li> <a href='mobile/planner'>Mijn planner</a> </li>";
		}
		?>	
			<li> <a href="mobile/about" data-transition="pop">Over studieplanner</a> </li>
		</ul>
		<?
		if($this->session->userdata("is_logged_in"))
		{
			echo "<ul data-role='listview' data-inset='true'>";
			echo "<li><a href='#' id='logout'>Afmelden</a></li>";
			echo "</ul>";
		}
		?>
	</div><!-- /content -->

	<div data-role="footer" data-position="fixed" data-theme="a" data-id="sticky">
		<h4><span style="font-size: 12px;">Plannen op je best!</span></h4>
	</div><!-- /footer -->
	
</div><!-- /page -->


