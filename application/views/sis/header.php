<!DOCTYPE html>
<html class="no-js">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="description" content="">
		<title><?=$title?> | <?=$centre['publicTitle']?></title>
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
				// console.log("This works");
				$('img').load(function(){
					// console.log("resizing image");
					// console.log($(this).outerHeight(true)+'px');
					$(this).css('margin-bottom',(20-($(this).outerHeight(true)%20))+'px');
					// console.log($(this).outerHeight(true)+'px');
					// console.log((20-($(this).outerHeight(true)%20))+'px');
				});
				$('.widget').each(function(){
					//console.log("resizing widget title");
					$(this).height(Math.round($(this).height()/20)*20);
				});
				$('.widget-title').each(function(){
					//console.log("resizing widget title");
					$(this).height(Math.round($(this).height()/20)*20);
				});
				$('.fc-header').each(function(){
					//console.log("resizing fullcalendar element");
					$(this).css('margin-bottom',(20-($(this).height()%20))+'px');
				});
				$('.fc-content').each(function(){
					//console.log("resizing fullcalendar element");
					$(this).css('margin-bottom',(20-($(this).height()%20))+'px');
				});
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
			You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.
		</p>
	<![endif]-->
	<body>
		<div id="container">
			<a id="header" href="/" alt="Return to Homepage" title="Return to Homepage">
				<div id="header-block">
					<div id="header-title"><?=$centre['publicTitle']?></div>
					<div id="header-subtitle"><?=$centre['publicSubtitle']?></div>
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
								title="Log into an account"
								class="login <?=($page=="login" ? 'selected' : '')?>"
							>
								<li><div class="icon"></div>Log In</li>
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
								title="Log out of this account"
								class="logout <?=($page=="login" ? 'selected' : '')?>"
							>
								<li><div class="icon"></div>Log Out</li>
							</a>
						</ul>
						<? } ?>
					</div>
					<div id="content">
						<? if(!empty($message)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message;?></p></div><? } ?>
						<? if(!empty($message_information)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message_information;?></p></div><? } ?>
						<? if(!empty($message_success)){ ?><div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3><p><?php echo $message_success;?></p></div><? } ?>
						<? if(!empty($message_error)){ ?><div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p><?php echo $message_error;?></p></div><? } ?>
						<? if(!empty($message_warning)){ ?><div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p><?php echo $message_warning;?></p></div><? } ?>