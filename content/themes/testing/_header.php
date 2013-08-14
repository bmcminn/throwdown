<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="<?php echo SITE_LANG; ?>" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="<?php echo SITE_LANG; ?>" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="<?php echo SITE_LANG; ?>" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="<?php echo SITE_LANG; ?>" class="no-js"> <!--<![endif]-->

<head>
  <meta charset="<?php echo SITE_CHARSET; ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php echo page_title(); ?></title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php page_meta('author'); ?>
  <?php page_meta('description'); ?>
  <?php // page_meta('keywords'); ?>

  <?php page_link('canonical', SITE_URL); ?>

  <link rel="stylesheet" href="<?php echo template_css('main.css'); ?>">

  <?php // page_favicons('favicon.ico', 'mobile-icon.png'); ?>

  <?php // page_fb_open_graph(); ?>

</head>


<body class="<?php page_body_classes(); ?>">

  <div class="container">

    <section class="page-sidebar-block">

      <a class="header-logo" href="<?php echo URL_HOME; ?>">
      </a>




    </section>




    <section id="page-body" class="page-content-block" role="main">
