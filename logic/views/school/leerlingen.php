<!-- validates -->
<div id="info_content">
	<div id="add_student">
		<img src="<?= base_url(); ?>assets/images/header_add_student.png" alt="Nieuwe student toevoegen" />
		<p class="clearfix uitleg" style="margin-left: 25px; line-height: 1.3em">
			Studenten die u hier toevoegt,  worden automatisch aan uw account gelinkt.<br />
			Zij zullen een e-mail ontvangen met hun voorlopige wachtwoord.
		</p>
		<br />
		<?php
			echo form_open('/school/add_student', array('id' => 'formLkrAddStudent'));
		?>
		<p>
			<label for="firstname">Voornaam:</label>
			<input type="text" id="firstname" name="firstname" />
		</p>
		<p>
			<label for="lastname">Achternaam</label>
			<input type="text" id="lastname" name="lastname" />
		</p>
		<p>
			<label for="email">E-mailadres</label>
			<input type="text" id="email" name="email" />
		</p>
		<p class="buttons">
			<input type="submit" value="Opslaan" id="submit_add_student">
			<?
				$js = 'onClick=$("#add_student").hide()';
				$data = array(
								'name'			=>		'cancelContent',
								'id'			=>		'cancelContent',
								'content'		=>		'Annuleren'
							);
				echo form_button($data, '', $js);
			?>
		</p> 
		<?php
			echo form_close();
		?>
	</div>
	<div id="profile_container">
		<img src="<?= base_url(); ?>assets/images/lln_beheer.png" alt="Leerlingen beheer" />
		<p class="clearfix"></p>
		<div id="profile_left">
			<ul class="profile_links">
				<li><a href="#" name="leerlingen">Mijn leerlingen</a></li>
				<li><a href="#" name="taak_plannen">Taak plannen</a></li>
			</ul>
		</div>
		
		<div id="profile_right">
			<div class="users_per_school" style="display: none">
				<img src="<?= base_url(); ?>assets/images/mijn_lln.png" alt="Mijn leerlingen" />
				<p class="uitleg">Hier vindt u een overzicht van alle studenten die u begeleidt.</p>
				<table class="tbl_students">
					<tr>
						<th>Achternaam</th>
						<th>Voornaam</th>
						<th>E-mail</th>
						<th>Studierichting</th>
					</tr>
					<? foreach($leerlingen as $leerling): ?>
						<tr>
							<td><?= $leerling['achternaam']; ?></td>
							<td><?= $leerling['voornaam']; ?></td>
							<td><?= $leerling['email']; ?></td>
							<td><?= $leerling['studierichting']; ?></td>
						</tr>
					<? endforeach;?>
				</table>
				<p class="clearfix"></p>
				<p id="add_student_link">
					<a href="#" id="add_student_click"><img src="<?= base_url(); ?>assets/images/create_event.png" alt="Student toevoegen"/>Student toevoegen</a>
				</p>
			</div>

			<div class="taak_plannen" style="display: block">
				<img src="<?= base_url(); ?>assets/images/plan_taak.png" alt="Taak plannen" />
				<p class="uitleg">Hier kan u een taak plannen voor alle studenten die u begeleidt.</p>
				<div id="plan_student_task">
				<?= form_open('school/plan_student_task', array('id' => 'formPlanStudentTask')); ?>
					<p>
						<label for="title">Titel:</label>
						<input type="text" id="title" name="title" />
					</p>
					<p>
						<label for="description">Beschrijving:</label>
						<?php
							$data = array(
											'name'			=>		'description',
											'id'			=>		'description',
											'placeholder'	=>		'',
											'value'			=>		set_value('description')
										);

							echo form_textarea($data);
						?>
					</p>
					<p><!-- date start -->
						<label for="ed_date">Datum:</label> 
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
						<input type="hidden" name="output_date" class="output_date" />

					</p><!-- date end -->
					<p class='times' style="float: right; margin-top: 10px; font-size: 1.2em"><!-- times start -->
						<?php
							$options = array();
							for($i = 8; $i <= 23; $i++)
							{
								$options[$i] = $i;
							}

							$id = "id='cr_start_time_hrs'";
							echo "Van " . form_dropdown('start_time_hrs', $options, '', $id);

							$options = array();
							for($i = 0; $i <= 45; $i+=15)
							{
								if($i == 0)
								{
									$options['00'] = '00';
								}
								else
								{
									$options[$i] = $i;
								}
							}
							$id = "id='cr_start_time_min'";
							echo " : " . form_dropdown('start_time_min', $options, '', $id);

							$options = array();
							for($i = 8; $i <= 24; $i++)
							{
								if($i == 24)
								{
									$options[$i] = '00';
								}
								else
								{
									$options[$i] = $i;
								}
							}
							$id = "id='cr_end_time_hrs'";
							echo " tot " . form_dropdown('end_time_hrs', $options, '9', $id);

							$options = array();
							for($i = 0; $i <= 45; $i+=15)
							{
								if($i == 0)
								{
									$options['00'] = '00';
								}
								else
								{
									$options[$i] = $i;
								}
							}
							$id = "id='cr_end_time_min'";
							echo " : " . form_dropdown('end_time_min', $options, '', $id);
						?>
					</p><!-- times end -->
					<p class="clearfix"></p>

					<p class="buttons" style="margin-right: 0px"><!-- buttons start -->
						<?php
							$data = array(
											'name'			=>		'btnPlanStudent',
											'id'			=>		'btnPlanStudent',
											'value'			=>		'Opslaan'
										);

							echo form_submit($data);
						?>
					</p><!-- buttons end -->
					<p class="clearfix"></p>
				<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function()	{
		 $(".date").datepicker({ 
									showAnim: 'fadeIn', 
									dateFormat: 'dd-mm-yy',
									dayNamesShort: ['Zon', 'Maa', 'Din', 'Woe', 'Don', 'Vrij', 'Zat'],
									dayNamesMin:  ['Zon', 'Maa', 'Din', 'Woe', 'Don', 'Vrij', 'Zat'],
									dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
									monthNames: ['Januari','Februari','Maart','April','Mei','Juni','Juli','Augustus','September','Oktober','November','December'],
									monthNamesShort: ['Jan','Feb','Maa','Apr','Mei','Jun','Jul','Aug','Sep','Okt','Nov','Dec'],
									minDate: 0,
									// altField outputs date in mySQL date format yy-m-d. datum hieruit halen, ipv .datepicker('getDate');
									altField: '.output_date',
									altFormat: 'yy-m-d'
								});
	
		$("#btnPlanStudent").click(function(e)	{
			var title = $("#title").val();
			var description = $("#description").val();
			var output_date = $(".output_date").val();
			var start_time = $("#cr_start_time_hrs").val() + ":" + $("#cr_start_time_min").val() + ":" + "00";
			var end_time = $("#cr_end_time_hrs").val() + ":" + $("#cr_end_time_min").val() + ":" + "00";
			var cct = $.cookie('ci_csrf_token');
			
			$.ajax({
				type: "POST",
				url: "/planner/create_student_event",
				data: { title: title, description: description, date: output_date, time_start: start_time, time_end: end_time, ci_csrf_token: cct },
				success: function(data)
				{
					console.log(data);
				}	
			});
		
			e.preventDefault();
		});
	});
	
</script>