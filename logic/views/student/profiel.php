<div id="info_content">
	<div id="profile_container">
		<img src="<?= base_url(); ?>assets/images/header_profiel.png" />
		<p class="clearfix"></p>
		<div id="profile_left">
			<ul class="profile_links">
				<li><a href="#" name="personal">Persoonlijke gegevens</a></li>
				<li><a href="#" name="school">School en studierichting</a></li>
				<li><a href="#" name="pass">Wachtwoord wijzigen</a></li>
			</ul>
		</div>
		
		<div id="profile_right">
			<div class="form_profile">
				<img src="<?= base_url(); ?>assets/images/edit_personal.png" />
				<?= form_open('profiel/save_personal')?>
					<p>
						<label for="firstname">Voornaam:</label>
						<input type="text" id="firstname" name="firstname" value="<?= ucfirst($user['firstname']); ?>"/>
					</p>
					<p>
						<label for="lastname">Achternaam:</label>
						<input type="text" id="lastname" name="lastname" value="<?= ucfirst($user['lastname']); ?>" />
					</p>
					<p><!-- date start -->
						<label for="date">Geboortedatum:</label> 
						<?php
							$data = array(
											'name'			=>		'date',
											'class'			=>		'date',
											'id'			=>		'date',
											'placeholder'	=>		'Klik hier',
											'value'			=>		set_value('date')
										 );

							echo form_input($data);
						?>
						<input type="hidden" name="output_date" class="output_date" value="<?= $user['birthdate'] ?>"/>

					</p><!-- date end -->
					<p>
						<label for="town">Woonplaats:</label>
						<input type="text" id="town" name="town" value="<?= ucfirst($user['town']); ?>"/>
					</p>
					<p>
						<label for="email">E-mailadres:</label>
						<input type="text" id="email" name="email" value="<?= $user['email']; ?>"/>
					</p>
					<p class="buttons">
						<input type="submit" id="saveProfile" name="saveProfile" value="Opslaan" />
					</p>
				</form>
			</div>
			<div class="form_school">
				<img src="<?= base_url(); ?>assets/images/edit_school.png" />
				<?= form_open('profiel/save_school')?>
					<p>
						<label for="school">School:</label>
						<input type="text" name="school" id="school" value="<?= $school['naam'] ?>" />
						<input type="hidden" name="school_id" id="school_id" value="<?= $school['id'] ?>" />
					</p>
					<p>
						<label for="richting">Studierichting:</label>
						<input type="text" name="richting" id="richting" value="<?= $richting['naam'] ?>"/>
						<input type="hidden" name="richting_id" id="richting_id" value="<?= $richting['id'] ?>"/>
					</p>
					<p>
						<label for="leerkracht">Coach:</label>
						<input type="text" name="leerkracht" id="leerkracht" disabled="disabled" value="<?= ucfirst($leerkracht['firstname']) . ' ' . ucfirst($leerkracht['lastname']); ?>"/>
					</p>
					<p class="buttons">
						<input type="submit" id="saveSchool" name="saveSchool" value="Opslaan" />
					</p>
				</form>
			</div>
			<div class="form_pass">
				<img src="<?= base_url(); ?>assets/images/edit_pass.png">
				<?= form_open('profiel/edit_pass')?>
					<p>
						<label for="huidig">Huidig wachtwoord:</label>
						<input type="password" name="huidig" id="huidig" />
					</p>
					<p>
						<label for="nieuw">Nieuw wachtwoord:</label>
						<input type="password" name="nieuw" id="nieuw" />
					</p>
					<p>
						<label for="bevestigen">Wachtwoord bevestigen:</label>
						<input type="password" name="bevestigen" id="bevestigen" />
					</p>
					<p class="pass_feedback">
						Wachtwoord niet gelijk
					</p>
					<p class="clearfix"></p>
					<p class="buttons">
						<input type="submit" id="savePass" name="savePass" value="Wijzigen" />
					</p>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function()	{
		// datum voor datepicker input veld
		var fix_date = <?= json_encode($user['birthdate']) ?>;
		fix_date = fix_date.split('-').reverse().join('-');
		$(".date").val(fix_date);

		// datepicker
		$(".date").datepicker({ 
								showAnim: 'fadeIn', 
								dateFormat: 'dd-mm-yy',
								dayNamesShort: ['Zon', 'Maa', 'Din', 'Woe', 'Don', 'Vrij', 'Zat'],
								dayNamesMin:  ['Zon', 'Maa', 'Din', 'Woe', 'Don', 'Vrij', 'Zat'],
								dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
								monthNames: ['Januari','Februari','Maart','April','Mei','Juni','Juli','Augustus','September','Oktober','November','December'],
								monthNamesShort: ['Jan','Feb','Maa','Apr','Mei','Jun','Jul','Aug','Sep','Okt','Nov','Dec'],
								// altField outputs date in mySQL date format yy-m-d. datum hieruit halen, ipv .datepicker('getDate');
								altField: '.output_date',
								altFormat: 'yy-m-d',
								changeYear: true,
								changeMonth: true,
								yearRange: '1950:2012'
		});
		
		$("#school").blur(function()	{
			school_id = $("#school_id").val();
		});
		
		// zoekfunctie
		var scholen = {
			script:"/profiel/search_school?json=true&limit=6&",
			varname:"input",
			json:true,
			shownoresults:true,
			noresults: "Geen resultaten",
			maxresults:6,
			callback: function (obj) { document.getElementById('school_id').value = obj.id; }
		};
		var as_json = new bsn.AutoSuggest('school', scholen);
		
		var richtingen = {
		  	script:  "/profiel/search_richting?json=true&limit=6&",
		   	varname:"input",
			json:true,
			shownoresults:true,
			noresults: "Geen resultaten",
			maxresults:6,
			callback: function (obj) { document.getElementById('richting_id').value = obj.id; }
		
		};
		var as_json2 = new bsn.AutoSuggest('richting', richtingen);

	});

</script>