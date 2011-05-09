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
	
});