<div id="info_content">
	<div id="school_container">
		<img src="<?= base_url(); ?>assets/images/header_users.png" alt="Bewerk scholen" />
		<p class="clearfix"></p>
		<div id="profile_left">
			<p class="p_leftfix"><a href="#" id="per_school" title="Per school">Per school</a></p>
			<p class="p_leftfix"><a href="#" id="per_rol" title="Per functie">Per functie</a></p>
			<p class="p_leftfix"><a href="#" id="add_user" title="Verantwoordelijke toevoegen">Voeg verantwoordelijke toe</a></p>
		</div>

		<div id="profile_right">
			<div class="users_per_school" style="display:none" >
				<h2><img src="<?= base_url(); ?>assets/images/users_per_school.png" alt="Informatie scholen" /></h2>
				<p class="label_select_school">Selecteer een school:</p>
				<p class="select_school">
				<?
					$options = array();
					foreach($scholen as $school)
					{
						$options[$school['id']] = $school['naam'];
					}
					
					$id = "id='select_school_users'";
					echo form_dropdown('select_school_users', $options, '', $id);
				?>
				<input type="hidden" name="school_id" id="school_id" value="1" />
				<p class="clearfix"></p>
				<table class="tbl_students">
					<caption>Studenten</caption>
					<tr>
						<th>Achternaam</th>
						<th>Voornaam</th>
						<th>E-mail</th>
						<th>Studierichting</th>
					</tr>
					<tr class="no_selection">
						<td colspan="4">Nog geen school geselecteerd.</td>
					</tr>
				</table>
				<table id="tbl_leerkrachten">
					<caption>Leerkrachten</caption>
					<tr>
						<th>Achternaam</th>
						<th>Voornaam</th>
						<th>E-mail</th>
					</tr>
					<tr class="no_selection">
						<td colspan="4">Nog geen school geselecteerd.</td>
					</tr>
				</table>
			</div>
			<div class="users_per_functie" style="display:none" >
				<img src="<?= base_url(); ?>assets/images/users_per_functie.png" alt="Gebruikers per functie" />
				<p class="clearfix"></p>
				<p class="label_select_functie">Selecteer een functie:</p>
				<p class="select_functie">
				<?
					$options = array();
					foreach($functies as $functie)
					{
						$options[$functie['id']] = $functie['rol'];
					}

					$id = "id='select_functie_users'";
					echo form_dropdown('select_functie_users', $options, '', $id);
				?>
				<input type="hidden" name="functie_id" id="functie_id" value="1" />
				<p class="clearfix"></p>
				<table class="tbl_functies">
					<caption></caption>
					<tr class="tr_header">
						<th>Achternaam</th>
						<th>Voornaam</th>
						<th>E-mail</th>
					</tr>
					<tr class="no_selection">
						<td colspan="4">Nog geen functie geselecteerd.</td>
					</tr>
				</table>
			</div>
			<div class="add_users">
				<img src="<?=base_url(); ?>assets/images/add_users.png" alt="Gebruiker toevoegen" style="margin-bottom: 20px"/>
					<?= form_open('admin/add_verantwoordelijke'); ?>
						<p>
							<label for="voornaam">Voornaam:</label>
							<input type="text" id="voornaam" name="voornaam" />
						</p>
						<p>
							<label for="achternaam">Achternaam:</label>
							<input type="text" id="achternaam" name="achternaam" />
						</p>
						<p>
							<label for="email">E-mail</label>
							<input type="text" id="email" name="email" />
						</p>			
						<p>
							<label for="add_user_select_school">School:</label>
								<?
									$options = array();
									foreach($scholen as $school)
									{
										$options[$school['id']] = $school['naam'];
									}

									$id = "id='add_user_select_school'";
									echo form_dropdown('add_user_select_school', $options, '', $id);
								?>
						</p>
						<p class="buttons" style="margin-right: 3px;">
							<br />
							<input type="submit" value="Opslaan" id="add_verantwoordelijke">
						</p>									
						<p class="clearfix"></p>
					<?= form_close(); ?>
			</div>
		</div>		
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function()	{
		$("#add_verantwoordelijke").click(function(e)	{
			var firstname = $("#voornaam").val();
			var lastname = 	$("#achternaam").val();
			var email = $("#email").val();
			var school_id = $("#add_user_select_school").val();
			var cct = $.cookie('ci_csrf_token');
			
			$.ajax({
				type: "POST",
				url: "/admin/add_verantwoordelijke",
				data: { firstname: firstname, lastname: lastname, email: email, school_id: school_id , ci_csrf_token: cct },
				success: function(data)
				{
					
				}
				
			});
			
			e.preventDefault();
		})
	});
</script>