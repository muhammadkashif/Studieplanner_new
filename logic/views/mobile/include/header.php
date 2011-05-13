<!DOCTYPE html>
<html lang="nl" xml:lang="nl">
	<head>
		
		<meta charset="UTF-8">
		<meta name="title" content="Studieplanner | Plannen op je best!" />
		<meta name="description" content="Studieplanner.be is een applicatie om je leerstof én vrije tijd grondig te plannen!" />
		<meta name="keywords" content="studeren, student, studie, planning, planner, kalender, leerstof, leerkracht, middelbaar, vrije, tijd, leren, werken, diploma" />
		<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	
		<link rel="apple-touch-icon" href="apple-touch-icon-57x57.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png" />
		<link rel="apple-touch-startup-image" href="apple-touch-startup-image-320x460.png" />
		<link rel="apple-touch-startup-image" sizes="768x1004" href="apple-touch-startup-image-768x1004.png" />
		<title>Studieplanner Mobile</title>

		<!--[if IE]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/mobile.css" />
		<link rel="stylesheet" type="text/css" href="http://dev.jtsage.com/cdn/datebox/latest/jquery.mobile.datebox.css" /> 
		<link rel="stylesheet" type="text/css" href="http://code.jquery.com/mobile/1.0a4.1/jquery.mobile-1.0a4.1.min.css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.2.min.js"></script>
		<script>
		// BEFORE loading jQM
			$( document ).bind( "mobileinit", function(){
		    	$.mobile.page.prototype.options.degradeInputs.date = 'text';
			});
		</script>
		<script type="text/javascript" src="http://code.jquery.com/mobile/1.0a4.1/jquery.mobile-1.0a4.1.min.js"></script>
		<script type="text/javascript" src="http://dev.jtsage.com/cdn/datebox/latest/jquery.mobile.datebox.js"></script>
		<script type="text/javascript" src="<?= base_url(); ?>assets/js/cookie.js"></script>
		
	</head>
	<body>

