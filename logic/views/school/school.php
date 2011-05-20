<!-- validates -->
<div id="info_content">
	<div id="profile_container">
		<img src="<?= base_url(); ?>assets/images/header_schoolman.png" alt="Profiel" />
		<p class="clearfix"></p>
		<div id="profile_left">
			<ul class="profile_links">
				<li><a href="#" name="personal">Schoolgegevens</a></li>
				<li><a href="#" name="school">Studierichtingen</a></li>
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
						<input type="submit" id="lkrEditSchool" name="lkrEditSchool" value="Opslaan" />
					</p>
				</form>
			</div>
			<script type="text/javascript">
				$(document).ready(function()	{
					$("#lkrEditSchool").click(function(e)	{
						var form_values = $("#formLkrEditSchool").serialize();
						$.post("school/save_school_data", form_values, function(data)	{
								$("#feedback_top").html("<p>" + data['message'] + "</p>").slideDown('slow').delay(2000).slideUp();
						});
						e.preventDefault();
					});
				});
			</script>
			<div class="form_school">
				<img src="<?= base_url(); ?>assets/images/edit_school.png" alt="Schoolgegevens aanpassen" />
				<?= form_open('student/save_school')?>
					<p>
						<label for="school">School:</label>
						<input type="text" name="school" id="school" />
						<input type="hidden" name="school_id" id="school_id"  />
					</p>
					<p>
						<label for="richting">Studierichting:</label>
						<input type="text" name="richting" id="richting" />
						<input type="hidden" name="richting_id" id="richting_id"/>
					</p>
					<p>
						<label for="leerkracht">Coach:</label>
						<input type="text" name="leerkracht" id="leerkracht" disabled="disabled"  />
					</p>
					<p class="buttons">
						<input type="submit" id="saveSchool" name="saveSchool" value="Opslaan" />
					</p>
				</form>
			</div>
		</div>
	</div>
</div>
<pre>
	<? print_r($school); ?>
</pre>