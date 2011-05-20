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
						<input type="text" id="naam" name="naam" value="<?= $school['naam']; ?>" />
					</p>
					<p>
						<label for="straat">Straat:</label>
						<input type="text" id="straat" name="straat" value="<?= $school['straat']; ?>" />
					</p>
					<p>
						<label for="nummer">Huisnummer:</label>
						<input type="text" id="nummer" name="nummer" value="<?= $school['nummer']; ?>" />
					</p>
					<p>
						<label for="plaats">Plaats</label>
						<input type="text" id="plaats" name="plaats" value="<?= $school['plaats']; ?>" />
					</p>
					<p>
						<label for="email">E-mailadres:</label>
						<input type="text" id="email" name="email" value="<?= $school['email']; ?>" />
					</p>
					<p>
						<label for="website">Website</label>
						<input type="text" id="website" name="website" value="<?= $school['website']; ?>" />
					</p>
					<p>
						<label for="telefoon">Telefoon:</label>
						<input type="text" id="telefoon" name="telefoon" value="<?= $school['telefoon']; ?>" />
					</p>
					<p>
						<label for="fax">Fax:</label>
						<input type="text" id="fax" name="fax" value="<?= $school['fax']; ?>"/>
					</p>
					<p>
						<label for="verantwoordelijke">Verantwoordelijke:</label>
						<input type="text" id="verantwoordelijke" name="verantwoordelijke" value="<?= $school['verantwoordelijke']; ?>"/>
					</p>
					<input type="hidden" id="school_id" name="id" value="<?= $school['school_id']; ?>" />
					
					<p class="buttons">
						<input type="submit" id="lkrEditSchool" value="Opslaan" />
					</p>
				</form>
			</div>
		</div>
	</div>
</div>