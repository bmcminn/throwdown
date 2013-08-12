<?php

  require "json-minify.php";

  define("ROOT_DIR",                __DIR__ . '/..');
  define("SYSTEM_CONFIG_JSON",      ROOT_DIR . '/config.json');


  $config   = file_get_contents(SYSTEM_CONFIG_JSON);
  $config   = json_minify($config);
  $settings = json_decode($config);



  // Template meta data defuaults
  //===========================================================================
  define("SITE_LANG",               "en-US");
  define("SITE_CHARSET",            "UTF-8");



  // Template constants
  //===========================================================================

  // SET: Load minified assets system wide?
  if (!isset($settings->default_template)) {
    $settings->default_template = 'default.php';
  }

  // SET: Default homepage content to load when visiting "domain.com/"
  if (!isset($settings->default_homepage)) {
    $settings->default_homepage = 'home';
  }

  // SET: Default header template filename
  if (!isset($settings->template_header)) {
    $settings->template_header = '_header.php';
  }

  // SET: Default footer template filename
  if (!isset($settings->template_footer)) {
    $settings->template_footer = '_footer.php';
  }

  define("DEFAULT_TEMPLATE",        $settings->default_template);
  define("DEFAULT_HOMEPAGE",        $settings->default_homepage);
  define("TEMPLATE_HEADER",         $settings->template_header);
  define("TEMPLATE_FOOTER",         $settings->template_footer);



  // SET: Current theme is enabled ALWAYS
  if (!isset($settings->current_theme)) {
    $settings->current_theme = 'default';
  }

  define("CURRENT_THEME",           $settings->current_theme);
  define("THEME_JS",                '/themes/' . CURRENT_THEME . '/js/');
  define("THEME_CSS",               '/themes/' . CURRENT_THEME . '/css/');
  define("THEME_LESS",              '/themes/' . CURRENT_THEME . '/less/');
  define("THEME_IMG",               '/themes/' . CURRENT_THEME . '/img/');



  // SET: Load minified assets system wide?
  if (!isset($settings->minify_js)) {
    $settings->minify_js = false;
  }

  // SET: Minified JS suffix (eg: ".min.js")
  if (!isset($settings->minify_js_suffix)) {
    $settings->minify_js_suffix = ".min.js";
  }

  // SET: Minified JS asset path
  if (!isset($settings->minify_js_path)) {
    $settings->minify_js_path = 'min/';
  }

  define("THEME_MINIFY_JS",         $settings->minify_js);
  define("THEME_MINIFY_JS_SUFFIX",  $settings->minify_js_suffix);
  define("THEME_MINIFY_JS_PATH",    THEME_JS . $settings->minify_js_path);



  // System Directory defaults
  //===========================================================================
  define("DIR_TEMPLATES",           ROOT_DIR . "/themes/" . CURRENT_THEME . "/");
  define("DIR_PAGES",               ROOT_DIR . "/pages/");
  define("DIR_ARTICLES",            ROOT_DIR . "/articles/");
  define("DIR_PLUGINS",             ROOT_DIR . "/app/plugins/");



  // Site name defaults
  //===========================================================================
  define("SITE_NAME",               $settings->site_name);
  define("SITE_NAME_LEGAL",         $settings->site_name_legal);
  define("SITE_FOOTER_COPYRIGHT",   $settings->site_footer_copyright);



  // Site URL structure
  //===========================================================================
  $url_protocol = 'http';

  if (isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == "on") {
    $url_protocol .= 's';
  }

  $site_url     = $url_protocol.'://'.$_SERVER["SERVER_NAME"];
  $current_url  = $site_url.$_SERVER["REQUEST_URI"];

  define("SITE_URL",                    $site_url);
  define("CURRENT_URL",                 $current_url);
  define("URL_HOME",                    SITE_URL);



  // Default system error messages
  //===========================================================================
  $message_begin  = "[ERROR NOTICE:";
  $message_end    = "]\r\n";

  define("PAGE_EMPTY_PARAM_MESSAGE",    "$message_begin This function requires at least 1 argument. $message_end");
  define("PAGE_TEMPLATE_ERROR_MESSAGE", "$message_begin The template you requested is not avialable. $message_end");

  define("PAGE_GA_ERROR_MESSAGE",       "$message_begin You need to pass a Google Analytics tracking code to this function call. $message_end");
  define("PAGE_FBOG_ERROR_MESSAGE",     "$message_begin You need to configure your Facebook open graph ID (FB_OPEN_GRAPH_ID) in config.php $message_end");



  // Social integration options
  //===========================================================================
  // define("FB_OPEN_GRAPH_ID",            "");
  // define("SITE_TYPE",                   $settings->site_type);
