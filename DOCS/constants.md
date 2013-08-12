
# Global Definitions Reference

These are the default system level constansts defined system wide. They cover numerous aspects of the software including

```php
<?php
  // File: '/app/config.php'

  // System Level config
  //===========================================================================
  define("ROOT_DIR",                __DIR__  . '/..');
  define("SYSTEM_CONFIG_JSON",      ROOT_DIR . '/config.json');


  // Template meta data defuaults
  //===========================================================================
  define("SITE_LANG",               "en-US");
  define("SITE_CHARSET",            "UTF-8");


  // Template constants
  //===========================================================================
  define("DEFAULT_TEMPLATE",        config.json->default_template);
  define("DEFAULT_HOMEPAGE",        config.json->default_homepage);

  define("TEMPLATE_HEADER",         '_header.php');
  define("TEMPLATE_FOOTER",         '_footer.php');

  define("CURRENT_THEME",           config.json->current_theme);
  define("THEME_JS",                '/themes/' . CURRENT_THEME . '/js/');
  define("THEME_CSS",               '/themes/' . CURRENT_THEME . '/css/');
  define("THEME_LESS",              '/themes/' . CURRENT_THEME . '/less/');
  define("THEME_IMG",               '/themes/' . CURRENT_THEME . '/img/');


  // System Directory defaults
  //===========================================================================
  define("DIR_TEMPLATES",           ROOT_DIR . "/themes/" . CURRENT_THEME . "/");
  define("DIR_PAGES",               ROOT_DIR . "/pages/");
  define("DIR_ARTICLES",            ROOT_DIR . "/articles/");
  define("DIR_PLUGINS",             ROOT_DIR . "/app/plugins/");


  // Site name defaults
  //===========================================================================
  define("SITE_NAME",               config.json->site_name);
  define("SITE_NAME_LEGAL",         config.json->site_name_legal);

  define("SITE_FOOTER_COPYRIGHT",   config.json->site_footer_copyright);
  // define('SITE_LOCATION',             'http://test.dev');



  // Site URL structure
  //===========================================================================

  // {
  //    Some logic to determine
  //   - Determination of HTTP:// or HTTPS:// URL structure.
  //   - $site_url is defined as the current URL
  // }

  define("SITE_URL",                    $site_url);
  define("URL_HOME",                    SITE_URL);



  // Default system error messages
  //===========================================================================
  $message_begin  = "[ERROR NOTICE:";
  $message_end    = "]";

  define("ERROR_FB_OPENGRAPH",     "$message_begin You need to configure your Facebook open graph ID (FB_OPEN_GRAPH_ID) in config.php $message_end");
  define("ERROR_GOOGLE_ANALYTICS",       "$message_begin You need to pass a Google Analytics tracking code to this function call. $message_end");
  define("ERROR_TEMPLATE", "$message_begin The template you requested is not avialable. $message_end");
  define("ERROR_FUNC_PARAM",    "$message_begin This function requires at least 1 argument. $message_end");


  // Social integration options
  //===========================================================================
  define("FB_OPEN_GRAPH_ID",            "");
  // define("SITE_TYPE",                   config.json->site_type);

  ```
