<div id="detail_content">	
	<div class="base">
		<?php
		foreach($details as $key => $detail)
		{
			echo "<div class='grid'>";
			$header = "<p class='detail_header'>";
			// . ucfirst($dates[0][$key]['name']) . ", " . $key . " " . $init['curr_month_name'];
			$header .= ucfirst($dates[0][$key]['name']) . ", " . $key . " " . $init['curr_month_name'];
			$header .= "<img src='" . base_url() . "assets/images/create_event.png' alt='Plan iets'></p>";
			
			echo $header;
		
			for($i = 1; $i <= $details[$key]['event_count']; $i++)
			{
				echo "<div class='event " . $details[$key][$i]['type'] . "'>";
					echo "<p class='event_title'>" . $details[$key][$i]['title'] . "</p>";
					echo $details[$key][$i]['description'];
				echo "</div>";
			}
			echo "</div>";	
		
		}
		?>
	</div>

	<script type="text/javascript">
	$(document).ready(function()	{
		
		$("p.detail_header img").click(function()	{
			$("#create_event").fadeIn();
		});
	
	   $("#date").datepicker({ 
								showAnim: 'fadeIn', 
								dateFormat: 'dd-mm-yy',
								dayNamesShort: ['Zon', 'Maa', 'Din', 'Woe', 'Don', 'Vrij', 'Zat'],
								dayNamesMin:  ['Zon', 'Maa', 'Din', 'Woe', 'Don', 'Vrij', 'Zat'],
								dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
								monthNames: ['Januari','Februari','Maart','April','Mei','Juni','Juli','Augustus','September','Oktober','November','December'],
								monthNamesShort: ['Jan','Feb','Maa','Apr','Mei','Jun','Jul','Aug','Sep','Okt','Nov','Dec'],
								minDate: 0,
								// altField outputs date in mySQL date format yy-m-d. datum hieruit halen, ipv .datepicker('getDate');
								altField: '#output_date',
								altFormat: 'yy-m-d'
							});
		
		$("#btnSubmit").click(function(e)	{
			$("div.feedback").slideUp();
			$("div.feedback").html('');
			$("p.warning").slideUp();
			
			
			var title = $("#title").val();
			var description = $("#description").val();
			var output_date = $("#output_date").val();
			var start_time = $("#start_time_hrs").val() + ":" + $("#start_time_min").val() + ":" + "00";
			var end_time = $("#end_time_hrs").val() + ":" + $("#end_time_min").val() + ":" + "00";
			var event_type = $("#drop_event_type").val();
			
			
			$.ajax({
				type: "POST",
				url: "/planner/create_event",
				data: { title: title, description: description, date: output_date, start_time: start_time, end_time: end_time, event_type: event_type },
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
						$("#create_event").fadeOut();
						$("#feedback_top").html("<p>" + data['message'] + "</p>").slideDown('slow').delay(2000).slideUp();
					}
				}
			});
			
			// prevent submit
			e.preventDefault();			
		});
		
	});
	</script>
	<div id="create_event">
		<img src="<?= base_url(); ?>assets/images/header_create_event.png" alt="Nieuwe taak plannen" />
		
		<p class="clearfix warning">Let op:</p>
		<div class="feedback clearfix">
				
		</div> <!-- feedback -->
		<p class="clearfix"></p>
		<?php
			echo form_open('planner/create_event');
		?>
		<p class='drop_event_type'>
			<label for="drop_event_type">Type</label>
			<?
				$options = array(
									'huiswerk'		=>		'Huiswerk',
									'deadline'		=>		'Deadline',
									'vrijetijd'		=>		'Vrije Tijd'
							);
				$id = "id='drop_event_type'";
				echo form_dropdown('event_type', $options, '', $id);
			?>
		</p>
		<p class="clearfix"></p>
		<p><!-- title start -->
			<label for="title">Titel</label>
			<?php
				$data = array(
								'name'			=>		'title',
								'id'	 		=>		'title',
								'placeholder'	=>		'',
								'value'			=>		set_value('title')
							);

				echo form_input($data);
			?>
		</p><!-- title end -->			
		<p class='p_descr'><!-- description start -->
			<label for="description">Omschrijving</label>
			<?php
				$data = array(
								'name'			=>		'description',
								'id'			=>		'description',
								'placeholder'	=>		'',
								'value'			=>		set_value('description')
							);

				echo form_textarea($data);
			?>
		</p><!-- description end -->
		<p><!-- date start -->
			<label for="date">Datum:</label> 
			<?php
				$data = array(
								'name'			=>		'date',
								'id'			=>		'date',
								'placeholder'	=>		'',
								'value'			=>		set_value('date')
							 );
				
				echo form_input($data);
			?>
			<input type="hidden" name="output_date" id="output_date" />
			
		</p><!-- date end -->
		<p class='times'><!-- times start -->
			<?php
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
				
				$id = "id='start_time_hrs'";
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
				$id = "id='start_time_min'";
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
				$id = "id='end_time_hrs'";
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
				$id = "id='end_time_min'";
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
				
				$js = 'onClick=$("#create_event").hide()';
				$data = array(
								'name'			=>		'btnCancel',
								'id'			=>		'btnCancel',
								'content'		=>		'Annuleren'
							);
				echo form_button($data, '', $js);
			?>
		</p><!-- buttons end -->
		<p class="clearfix"></p>
		<?php
			echo form_close();
		?>
	</div>		
</div>

<p class='clearfix'></p>
<div class='event_type'></div>