<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <title>Infusion Sports</title>
        <link href="/css/<?=$this->session->userdata('slug')?>/normalize.min.css" rel="stylesheet" type="text/css">
        <link href="/css/<?=$this->session->userdata('slug')?>/main.css" rel="stylesheet" type="text/css">
        <link href="/css/<?=$this->session->userdata('slug')?>/sis.css" rel="stylesheet" type="text/css">
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
                    <a href=""><li><img src="/img/<?=$this->session->userdata('slug')?>/icons/home.14.png"/>Homepage</li></a>
                    <a href=""><li><img src="/img/<?=$this->session->userdata('slug')?>/icons/appearence.14.png"/>Screenshots</li></a>
                    <a href=""><li><img src="/img/<?=$this->session->userdata('slug')?>/icons/star.14.png"/>Signup</li></a>
                </ul>
            </div>
            <div id="content">