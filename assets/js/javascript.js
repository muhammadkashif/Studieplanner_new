$(document).ready(function()	{
	
	$("#day_list li").live("click", function()	{
		$(".selected").removeClass("selected");
		var day = $(this).text();
		var cct = $.cookie('ci_csrf_token');
	
		$(this).addClass('selected');

		$.ajax({
			type: "POST",
			url: "/planner/change_detail",
			data: { day: day, month: current_month, year: current_year, ci_csrf_token: cct },
			success: function(data)
			{
				$("#detail_content").html(data);
			}
		})
	});
	
	/* pluskes */
	$("#voegtoe").click(function(e)	{
		
		// show add_content div
		
		$("#add_content").fadeIn();
		
		// tinyMCE 
		tinyMCE.init({
		        mode : "textareas",
				theme: 'advanced',
				plugins: 'table',
				theme_advanced_buttons1: "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,outdent, indent, blockquote, |, formatselect",
				theme_advanced_buttons2: "bullist, numlist, |, link, unlink, |, tablecontrols",
				theme_advanced_buttons3: "",
				theme_advanced_resizing : true,
		});
		
		// prevent link behaviour
		e.preventDefault();
	});
	
	
	/* profiel links */	
	$(".profile_links li a").click(function(e)	{
		e.preventDefault();
		
		var id = $(this).attr("name");
		
		switch(id)
		{
			case "personal":
				if($(".form_school").css('display') != 'none')
				{
					$(".form_school").fadeOut('fast', function()	{
						$(".form_profile").fadeIn();
					});
				}
				else
				{
					$(".form_pass").fadeOut('fast', function()	{
						$(".form_profile").fadeIn();
					});
				}
				break;
			case "school":
				if($(".form_profile").css('display') != 'none')
				{
					$(".form_profile").fadeOut('fast', function()	{
						$(".form_school").fadeIn();
					});
				}
				else
				{
					$(".form_pass").fadeOut('fast', function()	{
						$(".form_school").fadeIn();
					});
				}
				break;
			case "pass":
				if($(".form_profile").css('display') != 'none')
				{
					$(".form_profile").fadeOut('fast', function()	{
						$(".form_pass").fadeIn();
					});
				}
				else
				{
					$(".form_school").fadeOut('fast', function()	{
						$(".form_pass").fadeIn();
					});
				}
				break;
		}
		
	});
	
	
	/* wachtwoord wijzigen: check of nieuw en bevestigen zelfde zijn */
	$("#bevestigen").blur(function()
	{
		var nieuw = $("#nieuw").val();
		var bevestig = $("#bevestigen").val();
		
		if( ! (nieuw == bevestig))
		{
			$(".pass_feedback").fadeIn();
		}
		else
		{
			$(".pass_feedback").fadeOut();
		}
	});
	
	/* profiel.php wachtwoord wijzigen button */
	$("#savePass").click(function(e)	{
		var huidig = $("#huidig").val();
		var nieuw = $("#nieuw").val();
		var bevestigen = $("#bevestigen").val();
		var cct = $.cookie('ci_csrf_token');
		
		$.ajax({
		   type: "POST",
		   url: "/profiel/edit_pass",
		   data: { huidig: huidig, nieuw: nieuw, bevestigen: bevestigen, ci_csrf_token: cct},
		   success: function(data)
		   {
				$("#feedback_top").html("<p>" + data['message'] + "</p>").slideDown('slow').delay(2000).slideUp();
				$("#huidig, #nieuw, #bevestigen").val("");
		   }
		});

		// prevent submit;
		e.preventDefault();
	});
	
	$("#saveProfile").click(function(e)	{
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		var date = $(".output_date").val();
		var town = $("#town").val();
		var email = $("#email").val();
		var cct = $.cookie('ci_csrf_token');
		
		$.ajax({
		   type: "POST",
		   url: "/profiel/save_personal",
		   data: { firstname: firstname, lastname: lastname, date: date, town: town, email: email, ci_csrf_token: cct},
		   success: function(data)
		   {
				$("#feedback_top").html("<p>" + data['message'] + "</p>").slideDown('slow').delay(2000).slideUp();
			}
		});
		
		e.preventDefault();
	});

	$("#saveSchool").click(function(e)	{
		var school_id = $("#school_id").val();
		var richting_id = $("#richting_id").val();
		var cct = $.cookie('ci_csrf_token');
		
		$.ajax({
			type: "POST",
			url: "/profiel/save_school",
			data: { school_id: school_id, richting_id: richting_id, ci_csrf_token: cct },
			success: function(data)
			{
				$("#feedback_top").html("<p>" + data['message'] + "</p>").slideDown('slow').delay(2000).slideUp();
			}
		});
		
		e.preventDefault();
	});
	
	/* admin scholen pagina */
	
	$("#bewerken").click(function(e)	{
		$("input:disabled").removeAttr('disabled');
	});
	
	$("#save_school_changes").click(function(e)	{
		var school_id = $("#school_id").val();
		var naam = $("#naam").val();
		var straat = $("#straat").val();
		var nummer = $("#nummer").val();
		var plaats = $("#plaats").val();
		var telefoon = $("#telefoon").val();
		var fax = $("#fax").val();
		var email = $("#email").val();
		var website = $("#website").val();
		var verantwoordelijke = $("#verantwoordelijke").val();
		var cct = $.cookie('ci_csrf_token');
		
		$.ajax({
			type: "POST",
			url: "/school/save_changes",
			data: { id: school_id, naam: naam, straat: straat, nummer: nummer, plaats: plaats, telefoon: telefoon, fax: fax, email: email, website: website, 
					verantwoordelijke: verantwoordelijke, ci_csrf_token: cct },
			success: function(data)
			{
				$("#feedback_top").html("<p>" + data['message'] + "</p>").slideDown('slow').delay(2000).slideUp();
				$("input:text").attr("disabled", "disabled");							
			}
		});
		
		e.preventDefault();
	});
	
	$("#select_school").change(function()	{
		var school_id = $(this).val();
		var cct = $.cookie('ci_csrf_token');
		
		$.ajax({
			type: "POST",
			url: "/school/show_school",
			data: { id: school_id, ci_csrf_token: cct },
			success: function(data)
			{
				$(".edit_school").fadeOut('fast', function()	{
						$("#school_id").val(school_id);
						$("#naam").val(data['school'][0]['naam']);
						$("#straat").val(data['school'][0]['straat']);
						$("#nummer").val(data['school'][0]['nummer']);
						$("#plaats").val(data['school'][0]['plaats']);
						$("#telefoon").val(data['school'][0]['telefoon']);
						$("#fax").val(data['school'][0]['fax']);
						$("#email").val(data['school'][0]['email']);
						$("#website").val(data['school'][0]['website']);
						$("#verantwoordelijke").val(data['school'][0]['verantwoordelijke']);
						$(".richtingen").html("");
						if(data['richting'].length === 0)
						{
							$(".richtingen").append("<p class='richting_overzicht'>Nog geen studierichtingen toegevoegd.</p>");
						}
						else
						{
							$.each(data['richting'], function(key, value)	{
								$(".richtingen").append("<p class='richting_overzicht'>" + data['richting'][key]['naam'] + "</p>");
							});
						}
				});
				$(".edit_school").fadeIn();
			}
		});
	});
	
	$("#add_school").click(function(e)	{
		$(".edit_school").fadeOut('fast', function()	{
			$("#school_id").val("0");
			$("#naam, #straat, #nummer, #plaats, #telefoon, #fax, #email, #website, #verantwoordelijke").val("").attr("disabled", "");
		$(".edit_school").fadeIn();
		});
		e.preventDefault();
	});

});
