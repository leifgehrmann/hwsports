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
                <div class="system">Sports Management</div>
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
                <li class="<?=($page=="home" ? 'selected' : '')?>"><a href="/tms"><img src="/img/<?=$slug?>/icons/home.14.png"/>Dashboard</a></li>
            </ul>
            <ul>
                <li class="<?=($page=="tournaments" ? 'selected' : '')?>"><a href="/tms/tournaments"><img src="/img/<?=$slug?>/icons/tournament.14.png"/>Tournaments</a></li>
                <li class="<?=($page=="venues" ? 'selected' : '')?>"><a href="/tms/venues"><img src="/img/<?=$slug?>/icons/jellyfish.14.png"/>Venues</a></li>
                <li class="<?=($page=="sports" ? 'selected' : '')?>"><a href="/tms/sports"><img src="/img/<?=$slug?>/icons/sport.14.png"/>Sports</a></li>
                <li class="<?=($page=="matches" ? 'selected' : '')?>"><a href="/tms/matches"><img src="/img/<?=$slug?>/icons/match.14.png"/>Matches</a></li>
                <li class="<?=($page=="groups" ? 'selected' : '')?>"><a href="/tms/groups"><img src="/img/<?=$slug?>/icons/group.14.png"/>Groups</a></li>
                <li class="<?=($page=="users" ? 'selected' : '')?>"><a href="/tms/users"><img src="/img/<?=$slug?>/icons/user.14.png"/>Users</a></li>
                <li class="<?=($page=="news" ? 'selected' : '')?>"><a href="/tms/news"><img src="/img/<?=$slug?>/icons/news.14.png"/>News</a></li>
                <li class="<?=($page=="tickets" ? 'selected' : '')?>"><a href="/tms/tickets"><img src="/img/<?=$slug?>/icons/money.14.png"/>Tickets</a></li>
                <li class="<?=($page=="reports" ? 'selected' : '')?>"><a href="/tms/reports"><img src="/img/<?=$slug?>/icons/report.14.png"/>Reports</a></li>
            </ul>
            <ul>
                <li><img src="/img/<?=$slug?>/icons/appearence.14.png"/>Appearence</li>
                <li><img src="/img/<?=$slug?>/icons/cogwheel.14.png"/>Settings</li>
                <li><img src="/img/<?=$slug?>/icons/cogwheel.14.png"/>Personal Settings</li>
            </ul>
        </div>
        <div id="content">