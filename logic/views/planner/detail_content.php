<div id="detail_content">
	<div id="dialog" title="Gelieve te bevestigen">
		<p>Bent u zeker dat u deze taak wil verwijderen?</p>
	</div>	
	<div class="base">
		<?php
		
		foreach($details[0] as $key => $detail)
		{
			echo "<div class='grid'>";
			$header = "<p class='detail_header'>";
			$header .= ucfirst($dates[0][$key]['name']) . ", " . $key . " " . $init['curr_month_name'];
			$header .= "<img src='" . base_url() . "assets/images/create_event.png' alt='Plan nieuwe taak' title='Plan nieuwe taak' class='tipsy_new_event'></p>";
			
			echo $header;
		
			for($i = 1; $i <= $details[0][$key]['event_count']; $i++)
			{
				echo "<div title='Taak bewerken' id='" . $details[0][$key][$i]['id'] . "' class='event " . $details[0][$key][$i]['type'] . "'>";
				echo "<p class='uren'>" . substr($details[0][$key][$i]['time_start'], 0, 5) . " - "
				 		   . substr($details[0][$key][$i]['time_end'], 0, 5) . "</p>";
					echo "<p class='event_title'>" . $details[0][$key][$i]['title'] . "</p>";

					echo "<p style='line-height: 1.2em;'>" . ellipsize($details[0][$key][$i]['description'], 20, 1) . "</p>";
				echo "</div>";
			}
			echo "</div>";	
		
		}
		
		if( ! empty($details[1]))
		{
			foreach($details[1] as $key => $detail)
			{
				echo "<div class='grid'>";
				$header = "<p class='detail_header'>";
				$header .= ucfirst($dates[1][$key]['name']) . ", " . $key . " " . $init['next_month_name'];
				$header .= "<img src='" . base_url() . "assets/images/create_event.png' alt='Plan iets'></p>";

				echo $header;

				for($i = 1; $i <= $details[1][$key]['event_count']; $i++)
				{
					echo "<div id='" . $details[1][$key][$i]['id'] . "' class='event " . $details[1][$key][$i]['type'] . "'>";
						echo "<p class='uren'>" . substr($details[1][$key][$i]['time_start'], 0, 5) . " - "
						   . substr($details[1][$key][$i]['time_end'], 0, 5) . "</p>";
						echo "<p class='event_title'>" . character_limiter($details[1][$key][$i]['title'], 30) . "</p>";
						echo $details[1][$key][$i]['description'];
					echo "</div>";
				}
				echo "</div>";	

			}
		}
		?>
	</div>

	<script type="text/javascript">
	$(document).ready(function()	{
		
		$('.tipsy_new_event').tipsy({gravity: 's'});
		$('.event').tipsy({gravity: 'w'});
		
		$("p.detail_header img").click(function()	{
			
			$(".date").val("");
			$("#create_event").fadeIn();
		});
		
		$(".edit_close").click(function()	{
			$("#edit_event").hide();
		});
		
		$(".create_close").click(function()	{
			$("#create_event").hide();
		})
		
	    $("#dialog").dialog({
	      modal: true,
	            bgiframe: true,
	            width: 300,
	            height: 200,
	      autoOpen: false
	   });
	
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
		
		$("#btnSubmit").click(function(e)	{
			$("div.feedback").slideUp();
			$("div.feedback").html('');
			$("p.warning").slideUp();
			
			var title = $("#cr_title").val();
			var description = $("#cr_description").val();
			var output_date = $(".output_date").val();
			var start_time = $("#cr_start_time_hrs").val() + ":" + $("#cr_start_time_min").val() + ":" + "00";
			var end_time = $("#cr_end_time_hrs").val() + ":" + $("#cr_end_time_min").val() + ":" + "00";
			var event_type = $("#cr_drop_event_type").val();
			var cct = $.cookie('ci_csrf_token');
			
			$.ajax({
				type: "POST",
				url: "/planner/create_event",
				data: { title: title, description: description, date: output_date, start_time: start_time, end_time: end_time, event_type: event_type, ci_csrf_token: cct },
				success: function(data)
				{
					if( ! data['status'])
					{
						$("div.feedback").append("<p class='error'>" + data['error'] + "</p>");
						$("p.warning").slideDown("fast");
						$("div.feedback").slideDown("fast");
					}
					else
					{	
						$.ajax({
							type: "POST",
							url: "/planner/change_detail",
							//data: { month: current_month, year: current_year },
							success: function(data)
							{
								$("#detail_content").html(data);
							}
						});
						$("#create_event").fadeOut();
						$("#feedback_top").html("<p>" + data['message'] + "</p>").slideDown('slow').delay(2000).slideUp();
						
					}
				}	
			});
				
			
			// prevent submit
			e.preventDefault();			
		});
		
		$(".grid div").click(function()	{
			
			var id = $(this).attr("id");
			var cct = $.cookie('ci_csrf_token');
			
			
			$.ajax({
				type: "POST",
				url: "/planner/get_edit_content",
				data: { id: id, ci_csrf_token: cct },
				success: function(data)
				{
					$("#edit_event").fadeIn();
					$("#ed_title").val(data['title']);
					$("#ed_description").val(data['description']);
					$("#ed_drop_event_type option[value='" + data['type'] + "']").attr("selected", "selected");
					$("#edit_event .output_date").val(data['date']);
					
					$("#event_id").val(id);
					
					var date = data['date'].split('-').reverse().join('-');
					$(".date").val(date);
					
					var time_start_array = data['time_start'].split(":");
					var time_start_hrs = parseFloat(time_start_array[0]);
					var time_start_min = parseFloat(time_start_array[1]);
					if(time_start_min == 0)	{ time_start_min = "00"; }
					
					var time_end_array = data['time_end'].split(":");
					var time_end_hrs = parseFloat(time_end_array[0]);
					var time_end_min = parseFloat(time_end_array[1]);
					
					if(time_end_hrs == 24) { time_end_hrs = "00"; }
					if(time_end_min == 0)	{ time_end_min = "00"; }
					
					$("#ed_start_time_hrs option[value='" + time_start_hrs + "']").attr("selected", "selected");
					$("#ed_end_time_hrs option[value='" + time_end_hrs + "']").attr("selected", "selected");
					
					$("#ed_start_time_min option[value='" + time_start_min + "']").attr("selected", "selected");
					$("#ed_end_time_min option[value='" + time_end_min + "']").attr("selected", "selected");
				
				}
			});
			
		});
		
		$("#btnEdit").click(function(e)	{
			$("#edit_event div.feedback").slideUp();
			$("#edit_event div.feedback").html('');
			$("#edit_event p.warning").slideUp();

			var id = $("#event_id").val();
			var title = $("#ed_title").val();
			var description = $("#ed_description").val();
			var output_date = $("#edit_event .output_date").val();
			
			var fix_time = $("#ed_end_time_hrs").val();
			if(fix_time == "00")
			{
				fix_time = "24";
			}
			
			var start_time = $("#ed_start_time_hrs").val() + ":" + $("#ed_start_time_min").val() + ":" + "00";
			var end_time = fix_time + ":" + $("#ed_end_time_min").val() + ":" + "00";
			var event_type = $("#ed_drop_event_type").val();
			var update = $("#update").val();
			var cct = $.cookie('ci_csrf_token');
			
			$.ajax({
				type: "POST",
				url: "/planner/create_event",
				data: { title: title, description: description, date: output_date, start_time: start_time, 
						end_time: end_time, event_type: event_type, ci_csrf_token: cct, update: update, id: id },
				success: function(data)
				{
					if( ! data['status'])
					{
						$("div.feedback").append("<p class='error'>" + data['error'] + "</p>");
						$("p.warning").slideDown("fast");
						$("div.feedback").slideDown("fast");
					}
					else
					{	
						$.ajax({
							type: "POST",
							url: "/planner/change_detail",
							//data: { month: current_month, year: current_year },
							success: function(data)
							{
								$("#detail_content").html(data);
							}
						});
						$("#create_event").fadeOut();
						$("#feedback_top").html("<p>" + data['message'] + "</p>").slideDown('slow').delay(2000).slideUp();

					}
				}
			});
		
			e.preventDefault();
		});
		
		$("#btnDelete").click(function(e)	{
			e.preventDefault();
			
			var id = $("#event_id").val();
			var cct = $.cookie('ci_csrf_token');
			
			$("#dialog").dialog('option', 'buttons', {
	                "Verwijderen" : function() {
						$.ajax({
							type: "POST",
							url: "/planner/delete_event",
							data: { id: id, ci_csrf_token: cct },
							success: function(data)
							{
								$("#feedback_top").html("<p>" + data['message'] + "</p>").slideDown('slow').delay(2000).slideUp();
								if(data['status'])
								{
									$.ajax({
										type: "POST",
										url: "/planner/change_detail",
										//data: { month: current_month, year: current_year },
										success: function(data)
										{
											$("#detail_content").html(data);
										}
									});ﬂ
									$("#edit_event").hide();
								}
							}
						});
						$(this).dialog("close");
	        		},
	                "Annuleren" : function() {
	                    $(this).dialog("close");
	        		}
	     	});

	        $("#dialog").dialog("open");
		});
		
	});
	</script>
	
	<!-- create event div, hidden -->
	<div id="create_event">
		<img src="<?= base_url(); ?>assets/images/header_create_event.png" alt="Nieuwe taak plannen" />
		<img src="<?= base_url(); ?>assets/images/close_edit.png" alt="Sluiten" class="create_close"/>
		<p class="clearfix warning">Let op:</p>
		<div class="feedback clearfix">
				
		</div> <!-- feedback -->
		<p class="clearfix"></p>
		<?php
			echo form_open('planner/create_event');
		?>
		<p class='drop_event_type'>
			<label for="cr_drop_event_type">Type</label>
			<?
				$options = $type;
				$id = "id='cr_drop_event_type'";
				echo form_dropdown('event_type', $options, '', $id);
			?>
		</p>
		<p class="clearfix"></p>
		<p><!-- title start -->
			<label for="cr_title">Titel</label>
			<?php
				$data = array(
								'name'			=>		'title',
								'id'	 		=>		'cr_title',
								'placeholder'	=>		'',
								'value'			=>		set_value('title')
							);

				echo form_input($data);
			?>
		</p><!-- title end -->			
		<p class='p_descr'><!-- description start -->
			<label for="cr_description">Omschrijving</label>
			<?php
				$data = array(
								'name'			=>		'description',
								'id'			=>		'cr_description',
								'placeholder'	=>		'',
								'value'			=>		set_value('description')
							);

				echo form_textarea($data);
			?>
		</p><!-- description end -->
		<p><!-- date start -->
			<label for="cr_date">Datum:</label> 
			<?php
				$data = array(
								'name'			=>		'date',
								'class'			=>		'date',
								'id'			=>		'cr_date',
								'placeholder'	=>		'Klik hier',
								'value'			=>		set_value('date')
							 );
				
				echo form_input($data);
			?>
			<input type="hidden" name="output_date" class="output_date" />
			
		</p><!-- date end -->
		<p class='times'><!-- times start -->
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

		<p class="buttons"><!-- buttons start -->
			<?php
				$data = array(
								'name'			=>		'btnSubmit',
								'id'			=>		'btnSubmit',
								'value'			=>		'Opslaan'
							);
			
				echo form_submit($data);
			?>
			<button name="btnCancel" id="btnCancel" onclick="$('#create_event').hide();return(false);">Annuleren</button>
			
		</p><!-- buttons end -->
		<p class="clearfix"></p>
		<?php
			echo form_close();
		?>
	</div>
	<!-- edit event -->	
	<div id="edit_event">
		<img src="<?= base_url(); ?>assets/images/header_edit_event.png" alt="Taak bewerken" />
		<img src="<?= base_url(); ?>assets/images/close_edit.png" alt="Sluiten" class="edit_close"/>
		
		<p class="clearfix warning">Let op:</p>
		<div class="feedback clearfix">
				
		</div> <!-- feedback -->
		<p class="clearfix"></p>
		<?php
			echo form_open('planner/create_event');
		?>
		<p class='drop_event_type'>
			<label for="ed_drop_event_type">Type</label>
			<?
				$options = array(
									'huiswerk'		=>		'Huiswerk',
									'deadline'		=>		'Deadline',
									'vrijetijd'		=>		'Vrije Tijd'
							);
				$id = "id='ed_drop_event_type'";
				echo form_dropdown('event_type', $options, '', $id);
			?>
		</p>
		<p class="clearfix"></p>
		<p><!-- title start -->
			<label for="ed_title">Titel</label>
			<?php
				$data = array(
								'name'			=>		'title',
								'id'	 		=>		'ed_title',
								'placeholder'	=>		'',
								'value'			=>		set_value('title')
							);

				echo form_input($data);
			?>
		</p><!-- title end -->			
		<p class='p_descr'><!-- description start -->
			<label for="ed_description">Omschrijving</label>
			<?php
				$data = array(
								'name'			=>		'description',
								'id'			=>		'ed_description',
								'placeholder'	=>		'',
								'value'			=>		set_value('description')
							);

				echo form_textarea($data);
			?>
		</p><!-- description end -->
		<p><!-- date start -->
			<label for="ed_date">Datum:</label> 
			<?php
				$data = array(
								'name'			=>		'date',
								'class'			=>		'date',
								'id'			=>		'ed_date',
								'placeholder'	=>		'Klik hier',
								'value'			=>		set_value('date')
							 );
				
				echo form_input($data);
			?>
			<input type="hidden" name="output_date" class="output_date" />
			
		</p><!-- date end -->
		<p class='times'><!-- times start -->
			<?php
				$options = array();
				for($i = 8; $i <= 23; $i++)
				{
					$options[$i] = $i;
				}
				
				$id = "id='ed_start_time_hrs'";
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
				$id = "id='ed_start_time_min'";
				echo " : " . form_dropdown('start_time_min', $options, '', $id);
			
				$options = array();
				for($i = 8; $i <= 24; $i++)
				{
					if($i == 24)
					{
						$options['00'] = '00';
					}
					else
					{
						$options[$i] = $i;
					}
				}
				$id = "id='ed_end_time_hrs'";
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
				$id = "id='ed_end_time_min'";
				echo " : " . form_dropdown('end_time_min', $options, '', $id);
			?>
		</p><!-- times end -->
		<p class="clearfix"></p>

		<p class="buttons"><!-- buttons start -->
			<?php
				$data = array(
								'name'			=>		'btnDelete',
								'id'			=>		'btnDelete',
								'value'			=>		'Verwijderen'
							);
				echo form_submit($data);
				
				$data = array(
								'name'			=>		'btnEdit',
								'id'			=>		'btnEdit',
								'value'			=>		'Opslaan'
							);
			
				echo form_submit($data);

							
			?>
			<button name="btnCancelEdit" id="btnCancelEdit" onclick="$('#edit_event').hide();return(false);">Annuleren</button>
			<input type="hidden" name="update" id="update" value="true" />
			<input type="hidden" name="event_id" id="event_id" />
		</p><!-- buttons end -->
		<p class="clearfix"></p>
		<?php
			echo form_close();
		?>
	</div>
</div>

