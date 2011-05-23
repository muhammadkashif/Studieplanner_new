<div id="info_content">
	<div id="school_container">
		<img src="<?= base_url(); ?>assets/images/header_scholen.png" alt="Bewerk scholen" />
		<p class="clearfix"></p>
		<div id="profile_left">
				<p>Selecteer een school:
					<?
					foreach($scholen as $school)
					{
						$options[$school['id']] = $school['naam'];
					}
					
					$id = "id='select_school'";
					echo form_dropdown('select_school', $options, '', $id);
					
					?>
				</p>
				<p class="p_leftfix"><a href="#" id="add_school" title="Voeg school toe">School toevoegen</a></p>
		</div>
		<div id="profile_right">
			<div class="edit_school">
				<h2><img src="<?= base_url(); ?>assets/images/school_informatie.png" alt="Informatie scholen" /></h2>
				<?= form_open('school/edit_school'); ?>
					<input type="hidden" id="school_id" name="school_id" value="1" />
					<p>
						<label for="naam">Naam:</label>
						<input type="text" id="naam" name="naam" disabled="disabled" value="<?= $scholen[0]['naam']; ?>" />
					</p>
					<p>
						<label for="straat">Straat:</label>
						<input type="text" id="straat" name="straat" disabled="disabled" value="<?= $scholen[0]['straat'] ?>" />
					</p>
					<p>
						<label for="nummer">Huisnummer:</label>
						<input type="text" id="nummer" name="nummer" disabled="disabled" value="<?= $scholen[0]['nummer'] ?>" />
					</p>
					<p>
						<label for="plaats">Plaats:</label>
						<input type="text" id="plaats" name="plaats" disabled="disabled" value="<?= $scholen[0]['plaats'] ?>" />
					</p>
					<p>
						<label for="telefoon">Tel.:</label>
						<input type="text" id="telefoon" name="telefoon" disabled="disabled" value="<?= $scholen[0]['telefoon'] ?>" />
					</p>
					<p>
						<label for="fax">Fax:</label>
						<input type="text" id="fax" name="fax" disabled="disabled" value="<?= $scholen[0]['fax'] ?>" />
					</p>
					<p>
						<label for="email">E-mail:</label>
						<input type="text" id="email" name="email" disabled="disabled" value="<?= $scholen[0]['email'] ?>" />
					</p>
					<p>
						<label for="website">Website:</label>
						<input type="text" id="website" name="website" disabled="disabled" value="<?= $scholen[0]['website'] ?>" />
					</p>
					<p>
						<label for="verantwoordelijke">Contactpersoon:</label>
						<input type="text" id="verantwoordelijke" name="verantwoordelijke" disabled="disabled" value="<?= $scholen[0]['verantwoordelijke'] ?>" />
					</p>
					<p class="buttons" style="margin-right: 5px;">
						<br />
						<input type="button" value="Bewerken" id="bewerken" />
						<input type="submit" value="Opslaan" id="save_school_changes">
					</p>
					<p class="clearfix add_school_feedback" style="display: none; font-size: 1.2em; line-height: 1.4em">Vergeet niet een verantwoordelijke toe te voegen voor deze school onder menu-item 'Gebruikers'.</p>
					
					<div>
					<h2 class="richting"><img src="<?= base_url(); ?>assets/images/school_richtingen.png" alt="Studierichtingen"></h2>
						 <div class="richtingen">
								<?
									if( ! empty($scholen[0]['richtingen'][0]))
									{
										foreach($scholen[0]['richtingen'] as $richting)
										{
											echo "<p class='richting_overzicht'>" . $richting['naam'] . "</p>";
										}
									}
									else
									{
										echo "<p class='richting_overzicht'>Nog geen studierichtingen toegevoegd.</p>";
									}
								?>
						</div>
					</div>
					<p class="clearfix"></p>

				<?= form_close(); ?>
			</div>
		</div>
		<p class="clearfix"></p>
		
	</div>
</div>