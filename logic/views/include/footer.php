	</body>
	<script type="text/javascript">
	$(document).ready(function()	{
		$("#day_list li").live("click", function()	{
			$(".selected").removeClass("selected");
			var day = $(this).attr('value');
			$(this).addClass('selected');

			$.ajax({
				type: "POST",
				url: "/planner/change_detail",
				data: { day: day, month: current_month, year: current_year },
				success: function(data)
				{
					$("#detail_content").html(data);
				}
			})
		});
	});
	</script>
</html>