<!-- validates -->
<div id="info_content">
	<div id="profile_container">
		<img src="<?= base_url(); ?>assets/images/header_schoolman.png" alt="Profiel" />
		<p class="clearfix"></p>
		<div id="profile_left">
			<ul class="profile_links">
				<li><a href="/school/index/data" name="personal">Schoolgegevens</a></li>
				<li><a href="/school/index/richting" name="school">Studierichtingen</a></li>
			</ul>
		</div>
		
		<div id="profile_right">
			<div class="form_profile">
				<img src="<?= base_url(); ?>assets/images/school_aanpassen.png" alt="Schoolgegevens aanpassen" />
				<?= form_open('school/save_school_data', array('id' => 'formLkrEditSchool'))?>
					<p>
						<label for="naam">Naam:</label>
						<input type="text" id="naam" name="naam" value="<?= $data['school']['naam']; ?>" />
					</p>
					<p>
						<label for="straat">Straat:</label>
						<input type="text" id="straat" name="straat" value="<?= $data['school']['straat']; ?>" />
					</p>
					<p>
						<label for="nummer">Huisnummer:</label>
						<input type="text" id="nummer" name="nummer" value="<?= $data['school']['nummer']; ?>" />
					</p>
					<p>
						<label for="plaats">Plaats</label>
						<input type="text" id="plaats" name="plaats" value="<?= $data['school']['plaats']; ?>" />
					</p>
					<p>
						<label for="email">E-mailadres:</label>
						<input type="text" id="email" name="email" value="<?= $data['school']['email']; ?>" />
					</p>
					<p>
						<label for="website">Website</label>
						<input type="text" id="website" name="website" value="<?= $data['school']['website']; ?>" />
					</p>
					<p>
						<label for="telefoon">Telefoon:</label>
						<input type="text" id="telefoon" name="telefoon" value="<?= $data['school']['telefoon']; ?>" />
					</p>
					<p>
						<label for="fax">Fax:</label>
						<input type="text" id="fax" name="fax" value="<?= $data['school']['fax']; ?>"/>
					</p>
					<p>
						<label for="verantwoordelijke">Verantwoordelijke:</label>
						<input type="text" id="verantwoordelijke" name="verantwoordelijke" value="<?= $data['school']['verantwoordelijke']; ?>"/>
					</p>
					<input type="hidden" id="school_id" name="id" value="<?= $data['school']['school_id']; ?>" />
					
					<p class="buttons">
						<input type="submit" id="lkrEditSchool" value="Opslaan" />
					</p>
				</form>
			</div>

			<div class="form_school">
				<img src="<?= base_url(); ?>assets/images/add_richting.png" alt="Schoolgegevens aanpassen" />
				<?= form_open('school/add_studierichting', array('id' => 'formLkrAddRichting')); ?>
					<p>
						<label for="naam">Studierichting:</label>
						<input type="text" name="naam" id="richting" />
					</p>
					<p class="buttons">
						<input type="submit" id="add_studierichting" value="Opslaan" />
					</p>
				</form>
				<p class="clearfix"></p>
				 <div>
					<h2 class="richting">
						<img src="<?= base_url(); ?>assets/images/school_richtingen.png" alt="Studierichtingen">
					</h2>
					<p style="padding-top: 10px; padding-bottom: 10px; font-size: 1.2em"><span style="font-size: 1.2em; font-weight: bold; border-bottom: 1px solid #888"><?= $data['school']['naam']; ?></span></p>
					
						<?
							if( ! empty($data['richting']))
							{
								echo "<ul class='lst_richtingen'>";
								foreach($data['richting'] as $richting)
								{
									echo "<li class='richting_overzicht'>" . $richting['naam'] . "</li>";
								}
								echo "</ul>";
							}
							else
							{
								echo "<p class='richting_overzicht'>Nog geen studierichtingen toegevoegd.</p>";
							}
						?>
					</div>
			</div>
		</div>
	</div>
</div>