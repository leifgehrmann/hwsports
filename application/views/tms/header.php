<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <title><?=$title?> | Tournament Management System</title>
        <link rel="icon" type="image/png" href="/img/<?=$slug?>/logo/tms.fav.png" />
        <link href="/css/<?=$slug?>/normalize.min.css" rel="stylesheet" type="text/css">
        <link href="/css/<?=$slug?>/main.css" rel="stylesheet" type="text/css">
        <link href="/css/<?=$slug?>/tms.css" rel="stylesheet" type="text/css">
    </head>
    <!--[if lt IE 7]>      <body class="page-<?=$_ci_view?> lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
    <!--[if IE 7]>         <body class="page-<?=$_ci_view?> lt-ie9 lt-ie8"> <![endif]-->
    <!--[if IE 8]>         <body class="page-<?=$_ci_view?> lt-ie9"> <![endif]-->
    <!--[if gt IE 8]><!--> <body class="page-<?=$_ci_view?>"> <!--<![endif]-->
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
    <![endif]-->
        <div id="header">
			<a href="/tms" id="title-bar" class="left">
                <div class="logo"></div>
                <div class="name"><?=$this->session->userdata('centreShortName')?></div>
                <div class="system">Tournaments System</div>
            </a>
            <div id="user-bar" class="right">
                <span class="username"><?=$currentUser->firstName.' '.$currentUser->lastName?></span>
                <span class="sep">|</span>
                <a href="/"><span class="role">Customer Homepage</span></a>
                <span class="sep">|</span>
                <a href="auth/logout"><span class="logout">Logout</span></a>
            </div>
        </div>
        <div id="menu">
            <ul>
                <li class="selected"><a href="/tms"><img src="/img/icons/home.14.png"/>Dashboard</a></li>
            </ul>
            <ul>
                <li><a href=""><img src="/img/icons/tournament.14.png"/>Tournaments</a></li>
                <li><img src="/img/<?=$slug?>/icons/jellyfish.14.png"/>Venues</li>
                <li><img src="/img/<?=$slug?>/icons/sport.14.png"/>Sports</li>
                <li><img src="/img/<?=$slug?>/icons/match.14.png"/>Matches</li>
                <li ><img src="/img/<?=$slug?>/icons/group.14.png"/>Groups</li>
                <li><img src="/img/<?=$slug?>/icons/user.14.png"/>Users</li>
                <li><img src="/img/<?=$slug?>/icons/news.14.png"/>News</li>
                <li><img src="/img/<?=$slug?>/icons/money.14.png"/>Tickets</li>
                <li><img src="/img/<?=$slug?>/icons/report.14.png"/>Reports</li>
            </ul>
            <ul>
                <li><img src="/img/<?=$slug?>/icons/appearence.14.png"/>Appearence</li>
                <li><img src="/img/<?=$slug?>/icons/cogwheel.14.png"/>Settings</li>
                <li><img src="/img/<?=$slug?>/icons/cogwheel.14.png"/>Personal Settings</li>
            </ul>
        </div>
        <div id="content">