<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <title><?=$title?> | Tournament Management System</title>
        <link rel="icon" type="image/png" href="/img/favicon/tms.png" />
        <link rel="stylesheet" type="text/css" href="/css/client/main.css">
        <link rel="stylesheet" type="text/css" href="/css/client/tms.css">
        <link rel="stylesheet" type="text/css" href="/css/vendor/normalize/normalize.min.css">
		<link rel='stylesheet' type="text/css" href='/css/vendor/jquery-ui/jquery-ui-1.10.0.custom.min.css'>
		<link rel='stylesheet' type="text/css" href='/css/vendor/datatables/jquery.dataTables.css'>		
		<link rel='stylesheet' type="text/css" href='/css/vendor/datatables/dataTables.tabletools.css'>		
		<link rel='stylesheet' type="text/css" href='/css/vendor/datatables/dataTables.editor.css'>		
		<link rel='stylesheet' type="text/css" href='/css/vendor/datatables/dataTables.ColVis.css'>
		<link rel="stylesheet" type="text/css" media="screen" href="/css/vendor/colorpicker/colorpicker.css" />
		<script charset="utf-8" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
		<script charset="utf-8" src="//maps.googleapis.com/maps/api/js?sensor=true"></script>
		<script charset="utf-8" src="/js/vendor/jquery/jquery-ui-1.10.0.custom.min.js"></script>
		<script charset="utf-8" src="/js/vendor/jquery/jquery-ui-timepicker-addon.js"></script>
		<script charset="utf-8" src="/js/vendor/datatables/jquery.dataTables.min.js"></script>
		<script charset="utf-8" src="/js/vendor/datatables/dataTables.tabletools.min.js"></script>
		<script charset="utf-8" src="/js/vendor/datatables/dataTables.editor.min.js"></script>
		<script charset="utf-8" src="/js/vendor/datatables/dataTables.ColReorderWithResize.js"></script>
		<script charset="utf-8" src="/js/vendor/datatables/dataTables.ColVis.js"></script>
		<script charset="utf-8" src="/js/vendor/colorpicker/colorpicker.js"></script>
    </head>
    <!--[if lt IE 7]>      <body class="page-<?=$page?> lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
    <!--[if IE 7]>         <body class="page-<?=$page?> lt-ie9 lt-ie8"> <![endif]-->
    <!--[if IE 8]>         <body class="page-<?=$page?> lt-ie9"> <![endif]-->
    <!--[if gt IE 8]><!--> <body class="page-<?=$page?>"> <!--<![endif]-->
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
    <![endif]-->
        <div id="container">
            <div id="header">
    			<a href="/tms" id="title-bar" class="left">
                    <div class="logo"></div>
                    <div class="name"><?=$centre['shortName']?></div>
                    <div class="system">Sports Management</div>
                </a>
                <div id="user-bar" class="right">
                    <span class="username"><?=$currentUser->firstName.' '.$currentUser->lastName?></span>
                    <span class="sep">|</span>
                    <a href="/"><span class="role">Customer Homepage</span></a>
                    <span class="sep">|</span>
                    <a href="/auth/logout"><span class="logout">Logout</span></a>
                </div>
            </div>
            <div id="menu">
                <ul>
                    <a href="/tms"><li class="last-child home <?=($page=="tmshome" ? 'selected' : '')?>">Dashboard</li></a>
                </ul>
                <ul>
                    <a href="/tms/calendar"><li class="calendar <?=($page=="calendar" ? 'selected' : '')?>">Calendar</li></a>
                    <a href="/tms/tournaments"><li class="tournaments <?=($page=="tournaments" ? 'selected' : '')?>">Tournaments</li></a>
                    <a href="/tms/matches"><li class="matches <?=($page=="matches" ? 'selected' : '')?>">Matches</li></a>
                    <a href="/tms/venues"><li class="venues <?=($page=="venues" ? 'selected' : '')?>">Venues</li></a>
                    <a href="/tms/sports"><li class="sports <?=($page=="sports" ? 'selected' : '')?>">Sports</li></a>
                    <a href="/tms/news"><li class="news <?=($page=="news" ? 'selected' : '')?>">News</li></a>
                    <a href="/tms/tickets"><li class="tickets <?=($page=="tickets" ? 'selected' : '')?>">Tickets</li></a>
                    <a href="/tms/reports"><li class="last-child reports <?=($page=="reports" ? 'selected' : '')?>">Reports</li></a>
                </ul>
                <ul>
                    <a href="/tms/groups"><li class="groups <?=($page=="groups" ? 'selected' : '')?>">Groups</li></a>
                    <a href="/tms/users"><li class="last-child users <?=($page=="users" ? 'selected' : '')?>">Users</li></a>
                </ul>
                <ul>
                    <!--<a href="/tms/appearance"><li class="appearance <?=($page=="appearance" ? 'selected' : '')?>">Appearance</li></a>-->
                    <a href="/tms/settings"><li class="last-child settings <?=($page=="settings" ? 'selected' : '')?>">Settings</li></a>
                </ul>
            </div>
            <div id="content">