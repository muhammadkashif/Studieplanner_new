<div data-role="page" data-theme="a">
	<script type="text/javascript">
	// AFTER loading jQM
	jQuery.extend(jQuery.mobile.datebox.prototype.options, {
	    'dateFormat': 'DD/MM/YYYY',
	    'headerFormat': 'DD/MM/YYYY',
		'monthsOfYear': ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December"],
		'daysOfWeekShort': ["Zon", "Ma", "Di", "Woe", "Do", "Vrij", "Zat"],
		'noAnimation': true,
		'minuteStep': 15
		});
		
	
		$(document).ready(function()	{
			$("#toevoegen").click(function(e)	{
				
				var base = '<?= base_url(); ?>' + "mobile";
				var title = $("#mo_title").val();
				var description = $("#mo_descr").val();
				var temp_date = $("#mo_date").val();
				var date = temp_date.split('/').reverse().join('-');
				var start_time = $("#mo_start_time_hrs").val() + ":" + "00" + ":" + "00";
				var end_time = $("#mo_end_time_hrs").val() + ":" + "00" + ":" + "00";
				var event_type = $("#mo_event_type").val();
				var cct = $.cookie('ci_csrf_token');
				
				$.ajax({
					type: "POST",
					url: "/mobile/add_event",
					data: { title: title, description: description, date: date, start_time: start_time, end_time: end_time, event_type: event_type, ci_csrf_token: cct },
					success: function(data)
					{
						if( ! data['status'])
						{
							$("p.feedback").html(data['error']);
							$("p.feedback").slideDown("fast");
						}
						else
						{
							$("p.feedback").html("<p>" + data['message'] + "</p>").slideDown();
							setTimeout(function(){
							        $('p.feedback').slideDown(1000,function(){
										window.location = base;
							        });
							    },1500);
						}
					}	
				});
				
				e.preventDefault();
			});		
		});
	</script>
	<div data-role="header" data-theme="e">
		<h1><span style="font-size: 12px;">Studieplanner Mobile</span></h1>
	</div>
	
	<div data-role="content">
		<h3>Nieuwe taak toevoegen</h3>
		<p class="feedback">
			Feedback komt hier
		</p>
		<form action="mobile/add_event" method="post">	
			<div data-role="fieldcontain">
				<label for="mo_event_type" class="select">Kies type taak</label>
				<select name="mo_event_type" id="mo_event_type" data-native-menu="false">
					<option data-placeholder="true">Taaktype</option>
					<option value="huiswerk">Huiswerk</option>
					<option value="deadline">Deadline</option>
					<option value="vrijetijd">Vrije tijd</option>
				</select>
			</div>
			<div data-role="fieldcontain">
				<label for="mo_title">Titel</label>
				<input type="text" name="mo_title" value="" id="mo_title" data-theme="b"/>
				<br />
				<label for="mo_descr">Beschrijving</label>
				<textarea cols="20" rows="8" name="mo_descr" id="mo_descr" data-theme="b"></textarea>
			</div>
			<div data-role="fieldcontain">
				<label for="mo_date">Datum</label>
				<input value="" name="mo_date" type="date" data-role="datebox" id="mo_date" data-options='{"mode": "calbox", "noButtonFocusMode": "true"}' readonly="true" />
				<br />
			</div>
			<div data-role="fieldcontain">
				<label for="mo_start_time_hrs">Van:</label>
				<select name="mo_start_time_hrs" id="mo_start_time_hrs" >
					<option data-placeholder="true">Start Uur</li>
					<?
						for($i = 8; $i <= 23; $i++)
						{
							echo "<option value='" . $i . "'>" . $i . "</option>";
						}
					?>
				</select>
				<br />
				<label for="mo_end_time_hrs">Tot:</label>
				<select name="mo_end_time_hrs" id="mo_end_time_hrs" >
					<option data-placeholder="true">Eind uur</li>
					<?
						for($i = 9; $i <= 24; $i++)
						{
							if($i == 24)
							{
								echo "<option value='" . $i . "'>" . "00" . "</option>";
							}
							else
							{
								echo "<option value='" . $i . "'>" . $i . "</option>";
							}
						}
					?>
				</select>
			</div>
			<div data-role="fieldcontain">
				<input data-theme="b" type="submit" id="toevoegen" value="Taak toevoegen" />
			</div>
		</form>
	</div>

</div>

