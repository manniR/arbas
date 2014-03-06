<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!-->
<html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- media-queries.js (fallback) -->
  <!--[if lt IE 9]>
  <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <![endif]-->

  <!-- html5.js -->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

  <!-- wordpress head functions -->
  <?php wp_head(); ?>
  <!-- end of wordpress head -->

  <style>
    body {
      /*padding-top: 50px;
      padding-bottom: 20px;*/
    }
  </style>

</head>
<body <?php body_class(); ?>>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
  your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to
  improve your experience.</p>
<![endif]-->

<header>
  <div class="container header-feature">
    <img class="header-image img-responsive" src="img/herbert-pixner-header.jpg" alt=""/>

    <img id="logo" src="img/herbert-pixner-logo.svg" alt=""/>

  </div>

  <div class="navbar navbar-default">
    <div class="container">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!--<a class="navbar-brand" href="#">Project name</a>-->

      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav center-block">
          <li class="active"><a href="#">project</a></li>
          <li><a href="#about">offroad</a></li>
          <li><a href="#contact">three saints records</a></li>
          <li><a href="#contact">shop</a></li>
        </ul>
      </div>
      <!--/.navbar-collapse -->
    </div>
  </div>
</header>