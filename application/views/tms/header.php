<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <title><?=$title?> | Tournament Management System</title>
        <link rel="icon" type="image/png" href="/img/<?=$this->session->userdata('slug')?>/logo/tms.fav.16.png" />
        <link href="/css/<?=$this->session->userdata('slug')?>/normalize.min.css" rel="stylesheet" type="text/css">
        <link href="/css/<?=$this->session->userdata('slug')?>/main.css" rel="stylesheet" type="text/css">
        <link href="/css/<?=$this->session->userdata('slug')?>/tms.css" rel="stylesheet" type="text/css">
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
                <a href="/auth/logout"><span class="logout">Logout</span></a>
            </div>
        </div>
        <div id="menu">
            <ul>
                <a href="/tms"><li class="home <?=($page=="home" ? 'selected' : '')?>">Dashboard</li></a>
            </ul>
            <ul>
                <a href="/tms/tournaments"><li class="tournaments <?=($page=="tournaments" ? 'selected' : '')?>">Tournaments</li></a>
                <a href="/tms/venues"><li class="venues <?=($page=="venues" ? 'selected' : '')?>">Venues</li></a>
                <a href="/tms/sports"><li class="sports <?=($page=="sports" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/sport.14.png"/>Sports</li></a>
                <a href="/tms/matches"><li class="matches <?=($page=="matches" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/match.14.png"/>Matches</li></a>
                <a href="/tms/groups"><li class="groups <?=($page=="groups" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/group.14.png"/>Groups</li></a>
                <a href="/tms/users"><li class="users <?=($page=="users" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/user.14.png"/>Users</li></a>
                <a href="/tms/news"><li class="news <?=($page=="news" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/news.14.png"/>News</li></a>
                <a href="/tms/tickets"><li class="tickets <?=($page=="tickets" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/tickets.14.png"/>Tickets</li></a>
                <a href="/tms/reports"><li class="reports <?=($page=="reports" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/report.14.png"/>Reports</li></a>
            </ul>
            <ul>
                <a href="/tms/appearance"><li class="appearance <?=($page=="appearance" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/appearance.14.png"/>Appearance</li></a>
                <a href="/tms/settings"><li class="settings <?=($page=="settings" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/settings.14.png"/>Settings</li></a>
                <a href="/************/"><li class="personal-settings"><img src="/img/<?=$this->session->userdata('slug')?>/icons/settings.14.png"/>Personal Settings</li></a>
            </ul>
        </div>
        <div id="content">