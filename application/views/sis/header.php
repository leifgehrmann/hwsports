<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <title><?=$title?> | <?=$centre['shortName']?> Sports</title>
        <link rel="icon" type="image/png" href="/img/<?=$slug?>/logo/sis.fav.16.png" />
        <link href="/css/normalize.min.css" rel="stylesheet" type="text/css">
        <link href="/css/main.css" rel="stylesheet" type="text/css">
        <link href="/css/sis.css" rel="stylesheet" type="text/css">
		<link rel='stylesheet' href='/css/jquery-ui-1.10.0.custom.min.css'>
		<link rel='stylesheet' href='/css/jquery.fancybox.css'>
		<link rel='stylesheet' href='/css/jquery.dataTables.css'>		
		<link rel='stylesheet' href='/css/dataTables.tabletools.css'>		
		<link rel='stylesheet' href='/css/dataTables.ColVis.css'>
		<link rel='stylesheet' href='/css/dataTables.ColVis.css'>
		<script charset="utf-8" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
        <script charset="utf-8" src="//maps.googleapis.com/maps/api/js?sensor=true"></script>
		<script charset="utf-8" src="/scripts/jquery-ui-1.10.0.custom.min.js"></script>
		<script charset="utf-8" src="/scripts/fancybox/jquery.fancybox.pack.js"></script>
		<script charset="utf-8" src="/scripts/datatables/jquery-ui-timepicker-addon.js"></script>
		<script charset="utf-8" src="/scripts/datatables/jquery.dataTables.min.js"></script>
		<script charset="utf-8" src="/scripts/datatables/dataTables.tabletools.min.js"></script>
		<script charset="utf-8" src="/scripts/datatables/dataTables.ColReorderWithResize.js"></script>
		<script charset="utf-8" src="/scripts/datatables/dataTables.ColVis.js"></script>
    </head>
    <!--[if lt IE 7]>      <body class="page-<?=$page?> lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
    <!--[if IE 7]>         <body class="page-<?=$page?> lt-ie9 lt-ie8"> <![endif]-->
    <!--[if IE 8]>         <body class="page-<?=$page?> lt-ie9"> <![endif]-->
    <!--[if gt IE 8]><!--> <body class="page-<?=$page?>"> <!--<![endif]-->
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
    <![endif]-->
    <body>
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
            <div id="content">