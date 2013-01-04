<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <title><?=$title?> | <?=$centreShortName?> Sports</title>
        <link href="/css/<?=$slug?>/normalize.min.css" rel="stylesheet" type="text/css">
        <link href="/css/<?=$slug?>/main.css" rel="stylesheet" type="text/css">
        <link href="/css/<?=$slug?>/sis.css" rel="stylesheet" type="text/css">
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
                <ul>
                    <a href="/"><li class="homepage <? if($page=="home"){ ?>selected<? } ?>">Homepage</li></a>
                    <a href="/sis/whatson"><li class="whatson <? if($page=="whatson"){ ?>selected<? } ?>">What's On</li></a>
                    <a href="/sis/calendar"><li class="calendar <? if($page=="calendar"){ ?>selected<? } ?>">Calendar</li></a>
                    <a href="/sis/tournaments"><li class="tournament <? if($page=="tournaments"){ ?>selected<? } ?>">Tournaments</li></a>
                    <a href="/auth/register"><li class="register special <? if($page=="register"){ ?>selected<? } ?>">Registration</li></a>
                    <? if($this->ion_auth->logged_in()){ ?>
                        <a href="/auth/logout"><li class="logout">Logout</li></a>
                    <? } else { ?>
                        <a href="/auth/login"><li class="login <? if($page=="login"){ ?>selected<? } ?>">Login</li></a>
                    <? } ?>
					<? if($this->ion_auth->in_group('admin') || $this->ion_auth->in_group('centreadmin')){ ?>
                        <a href="/tms"><li class="management">Management</li></a>
                    <? } ?>
                    <a href="/sis/help"><li class="help <? if($page=="help"){ ?>selected<? } ?>">Help</li></a>
                </ul>
            </div>
            <div id="content">