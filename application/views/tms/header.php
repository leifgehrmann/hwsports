<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <title><?=$title?> | Tournament Management System</title>
        <link rel="icon" type="image/png" href="/img/<?=$this->session->userdata('slug')?>/logo/tms.fav.png" />
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
                <a href="/tms"><li class="<?=($page=="home" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/home.14.png"/>Dashboard</li></a>
            </ul>
            <ul>
                <a href="/tms/tournaments"><li class="<?=($page=="tournaments" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/tournament.14.png"/>Tournaments</li></a>
                <a href="/tms/venues"><li class="<?=($page=="venues" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/jellyfish.14.png"/>Venues</li></a>
                <a href="/tms/sports"><li class="<?=($page=="sports" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/sport.14.png"/>Sports</li></a>
                <a href="/tms/matches"><li class="<?=($page=="matches" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/match.14.png"/>Matches</li></a>
                <a href="/tms/groups"><li class="<?=($page=="groups" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/group.14.png"/>Groups</li></a>
                <a href="/tms/users"><li class="<?=($page=="users" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/user.14.png"/>Users</li></a>
                <a href="/tms/news"><li class="<?=($page=="news" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/news.14.png"/>News</li></a>
                <a href="/tms/tickets"><li class="<?=($page=="tickets" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/money.14.png"/>Tickets</li></a>
                <a href="/tms/reports"><li class="<?=($page=="reports" ? 'selected' : '')?>"><img src="/img/<?=$this->session->userdata('slug')?>/icons/report.14.png"/>Reports</li></a>
            </ul>
            <ul>
                <li><img src="/img/<?=$this->session->userdata('slug')?>/icons/appearence.14.png"/>Appearence</li>
                <li><img src="/img/<?=$this->session->userdata('slug')?>/icons/cogwheel.14.png"/>Settings</li>
                <li><img src="/img/<?=$this->session->userdata('slug')?>/icons/cogwheel.14.png"/>Personal Settings</li>
            </ul>
        </div>
        <div id="content">