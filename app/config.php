<?php

  require "json-minify.php";

  $config   = file_get_contents(__DIR__ . '/../config.json');

  $config   = json_minify($config);
  $settings = json_decode($config);



  // Template constants
  //===========================================================================
  define("DEFAULT_TEMPLATE",            $settings->default_template);
  define("DEFAULT_HOMEPAGE",            $settings->default_homepage);

  define("TEMPLATE_HEADER",             '_header.php');
  define("TEMPLATE_FOOTER",             '_footer.php');

  define("CURRENT_THEME",               $settings->current_theme);
  define("TEMPLATE_JS",                 '/templates/' . CURRENT_THEME . '/js/');
  define("TEMPLATE_CSS",                '/templates/' . CURRENT_THEME . '/css/');
  define("TEMPLATE_LESS",               '/templates/' . CURRENT_THEME . '/less/');
  define("TEMPLATE_IMG",                '/templates/' . CURRENT_THEME . '/img/');


  // System Directory defaults
  //===========================================================================
  define("DIR_TEMPLATES",               __DIR__ . "/../templates/" . CURRENT_THEME . "/");
  define("DIR_PAGES",                   __DIR__ . "/../pages/");
  define("DIR_ARTICLES",                __DIR__ . "/../articles/");
  define("DIR_PROJECTS",                __DIR__ . "/../projects/");
  define("DIR_PLUGINS",                 __DIR__ . "/../app/plugins/");


  // Site name defaults
  //===========================================================================
  define("SITE_NAME",                   $settings->site_name);
  define("SITE_NAME_LEGAL",             $settings->site_name_legal);

  define("SITE_FOOTER_COPYRIGHT",       $settings->site_footer_copyright);
  // define('SITE_LOCATION',             'http://test.dev');



  // Site URL structure
  //===========================================================================
  $site_url = 'http';

  if (isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == "on") {
    $site_url .= 's';
  }

  $site_url .= '://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

  define("SITE_URL",                    $site_url);

  define("URL_HOME",                    SITE_URL);


  // Template meta data defuaults
  //===========================================================================
  define("SITE_LANG",                   "en-US");
  define("SITE_CHARSET",                "UTF-8");







  // Default system error messages
  //===========================================================================
  $message_begin  = "<!-- ERROR NOTICE:";
  $message_end    = "-->\r\n";

  define("PAGE_FBOG_ERROR_MESSAGE",     "$message_begin You need to configure your Facebook open graph ID (FB_OPEN_GRAPH_ID) in config.php $message_end");
  define("PAGE_GA_ERROR_MESSAGE",       "$message_begin You need to pass a Google Analytics tracking code to this function call. $message_end");
  define("PAGE_TEMPLATE_ERROR_MESSAGE", "$message_begin The template you requested is not avialable. $message_end");
  define("PAGE_EMPTY_PARAM_MESSAGE",    "$message_begin This function requires at least 1 argument. $message_end");


  // Social integration options
  //===========================================================================
  define("FB_OPEN_GRAPH_ID",            "");

  // define("SITE_TYPE",                   $settings->site_type);
