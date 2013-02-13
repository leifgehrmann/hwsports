<!DOCTYPE html>
<html class="no-js">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="description" content="">
		<title><?=$title?> | <?=$centre['shortName']?> Sports</title>
		<link rel='icon' type="image/png" href="/img/favicon/sis.png" />

		<!-- Vendor component styling -->
		<link rel="stylesheet" type="text/css" href="/css/vendor/normalize/normalize.min.css">
		<link rel="stylesheet" type="text/css" href="/css/vendor/jquery-ui/jquery-ui-1.10.0.custom.min.css">
		<link rel="stylesheet" type="text/css" href="/css/vendor/fancybox/jquery.fancybox.css">
		<link rel="stylesheet" type="text/css" href="/css/vendor/datatables/jquery.dataTables.css">		
		<link rel="stylesheet" type="text/css" href="/css/vendor/datatables/dataTables.tabletools.css">
		<link rel="stylesheet" type="text/css" href="/css/vendor/datatables/dataTables.ColVis.css">
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,700,300">

		<!-- Website styling -->
		<link rel="stylesheet" type="text/css" href="/css/main.css">
		<link rel="stylesheet" type="text/css" href="/css/sis.css">

		<!-- Vendor scripts -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
		<script src="//maps.googleapis.com/maps/api/js?sensor=true"></script>
		<script src="/js/vendor/jquery/jquery-ui-1.10.0.custom.min.js"></script>
		<script src="/js/vendor/jquery/jquery-ui-timepicker-addon.js"></script>
		<script src="/js/vendor/fancybox/jquery.fancybox.pack.js"></script>
		<script src="/js/vendor/datatables/jquery.dataTables.min.js"></script>
		<script src="/js/vendor/datatables/dataTables.tabletools.min.js"></script>
		<script src="/js/vendor/datatables/dataTables.ColReorderWithResize.js"></script>
		<script src="/js/vendor/datatables/dataTables.ColVis.js"></script>
		<script src='/js/vendor/fullcalendar/_loader.js'></script>

		<script>
			$(document).ready(function() {
				console.log("This works");
				$("html").on("load", "img", function(){
					// alert($(this).prop('tagName'));
					console.log("resizing image");
					console.log($(this).outerHeight(true)+'px');
					$(this).css('margin-bottom',(15-($(this).outerHeight(true)%20))+'px');
					console.log($(this).outerHeight(true)+'px');
					console.log((15-($(this).outerHeight(true)%20))+'px');
					// alert("margin:"+$(this).css('margin-bottom'));
				});
				$("html").on("ready", ".widget-title", function(){
					console.log("resizing widget title");
					$(this).height(Math.round($(this).height()/20)*20);
				});
				$("html").on("ready", ".fc .fc-header", function(){
					console.log("resizing fullcalendar element");
					$(this).css('margin-bottom',(20-($(this).height()%20))+'px');
				});
				$("html").on("ready", ".fc .fc-content", function(){
					console.log("resizing fullcalendar element");
					$(this).css('margin-bottom',(20-($(this).height()%20))+'px');
				});
				/*$( 'img' ).each(function() {
					$(this).load(function() {
						// alert($(this).prop('tagName'));
						$(this).css('margin-bottom',(15-($(this).outerHeight(true)%20))+'px');
						// alert("margin:"+$(this).css('margin-bottom'));
					});
					//alert((15-($(this).outerHeight(true)%20)));
					/*setTimeout( function() {
						alert("outer height "+$(this).prop('tagName'));
						alert("outer height "+x.outerHeight(true));
					}, 5000);
					//alert($(this));
				});*/
				/*$( '.fc .fc-header' ).each(function() {
					$(this).css('margin-bottom',20-$(this).height()%20+'px');
				});
				$( '.fc .fc-content' ).each(function() {
					$(this).css('margin-bottom',20-$(this).height()%20+'px');
				});*/
			});

			var b = false;
			$('html').keypress(function(event) {
				if (event.which == 8364) {
					if(!b){
						$('body').css('background-image',"url('/img/typography/baseline.png'), url('/img/typography/columns.png')");
						$('body').css('background-repeat',"repeat, repeat-y");
						$('body').css('background-position',"center top, center top");
						$('#container *').css('opacity',"0.90");
					} else {
						$('body').css('background-image',"none");
						$('#container *').css('opacity',"");
					}
					b=!b;
				}
			});
		</script>
	</head>
	<!--[if lt IE 7]>      <body class="page-<?=$page?> lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
	<!--[if IE 7]>         <body class="page-<?=$page?> lt-ie9 lt-ie8"> <![endif]-->
	<!--[if IE 8]>         <body class="page-<?=$page?> lt-ie9"> <![endif]-->
	<!--[if gt IE 8]><!--> <body class="page-<?=$page?>"> <!--<![endif]-->
	<!--[if lt IE 7]>
		<p class="chromeframe">
			You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
	<![endif]-->
	<body>
		<div id="container">
			<a id="header" href="/" alt="Return to Homepage" title="Return to Homepage">
				<div id="header-block">
					<div id="header-title">Riccarton Tournaments</div>
					<div id="header-subtitle">Centre for Sport &amp; Exercise</div>
				</div>
			</a>
			<div id="middle">
				<div id="middle-block">
					<div id="menu">
						<ul>
							<a 
								href="/" 
								title="Return to the Homepage" 
								class="homepage <?=($page=="sishome" ? 'selected' : '')?>"
							>
								<li><div class="icon"></div>Homepage</li>
							</a>
							<a
								href="/sis/calendar" 
								title="View upcoming tournaments and events on the calendar"
								class="calendar <?=($page=="calendar" ? 'selected' : '')?>"
							>
								<li><div class="icon"></div>Calendar</li>
							</a>
							<a 
								href="/sis/tournaments" 
								title="List of all tournaments"
								class="tournaments <?=($page=="tournaments" ? 'selected' : '')?>"
							>
								<li><div class="icon"></div>Tournaments</li>
							</a>
							<a 
								href="/sis/matches" 
								title="List of most recent matches"
								class="matches <?=($page=="matches" ? 'selected' : '')?>"
							>
								<li><div class="icon"></div>Matches</li>
							</a>
							<a 
								href="/sis/ticketsinfo" 
								title="Ticket information"
								class="tickets <?=($page=="ticketsinfo" ? 'selected' : '')?>"
							>
								<li><div class="icon"></div>Tickets</li>
							</a>
							<a 
								href="/sis/help"
								title="Help"
								class="help <?=($page=="help" ? 'selected' : '')?>"
							>
								<li><div class="icon"></div>Help</li>
							</a>
						</ul>
						<? if(!$this->ion_auth->logged_in()){ ?>
						<ul>
							<a 
								href="/auth/register" 
								title="Register an account"
								class="register <?=($page=="register" ? 'selected' : '')?>"
							>
								<li><div class="icon"></div>Register</li>
							</a>
							<a 
								href="/auth/login" 
								title="Sign into an account"
								class="signin <?=($page=="login" ? 'selected' : '')?>"
							>
								<li><div class="icon"></div>Sign In</li>
							</a>
						</ul>
						<? } else { ?>
						<ul class="menu-user">
	        				<a 
	        					href="/sis/account"
	        					title="View account details"
	        					class="account <?=($page=="account" ? 'selected' : '')?>"
	        				>
	        					<li><div class="icon"></div>Account</li>
	        				</a>
	        				<a 
	        					href="/auth/logout"
	        					class="signout <?=($page=="login" ? 'selected' : '')?>"
	        				>
	        					<li><div class="icon"></div>Sign Out</li>
	        				</a>
	        			</ul>
						<? } ?>
					</div>
					<div id="content">





        <!--<body>
        	<div id="container">
        		<a href="/"><div id="header"></div></a>
        		<div id="menu">
        			<ul class="menu-default">
        				<a href="/"><li class="home <?=($page=="sishome" ? 'selected' : '')?>">Homepage</li></a>
        				<a href="/sis/calendar"><li class="calendar <?=($page=="calendar" ? 'selected' : '')?>">Calendar</li></a>
        				<a href="/sis/matches"><li class="matches <?=($page=="matches" ? 'selected' : '')?>">Matches</li></a>
        				<a href="/sis/tournaments"><li class="tournaments <?=($page=="tournaments" ? 'selected' : '')?>">Tournaments</li></a>
        				<a href="/sis/ticketsinfo"><li class="ticketsinfo <?=($page=="ticketsinfo" ? 'selected' : '')?>">Tickets</li></a>
        				<a href="/sis/info"><li class="info <?=($page=="info" ? 'selected' : '')?>">About Us</li></a>
        				<a href="/sis/help"><li class="help <?=($page=="help" ? 'selected' : '')?>">Help</li></a>
        			</ul>
        			<? if(!$this->ion_auth->logged_in()){ ?>
        			<ul class="menu-user">
        				<a href="/auth/register"><li class="register <?=($page=="register" ? 'selected' : '')?>">Register</li></a>
        				<a href="/auth/login"><li class="login <?=($page=="login" ? 'selected' : '')?>">Login</li></a>
        			</ul>
        			<? } else { ?>
        			<ul class="menu-user">
        				<a href="/sis/account"><li class="account <?=($page=="account" ? 'selected' : '')?>">Account</li></a>
        				<a href="/auth/logout"><li class="logout">Logout</li></a>
        			</ul>
        			<? } ?>
        		</div>
        		<div id="content">-->