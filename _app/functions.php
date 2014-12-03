<?php

  /**
   * Gets the proper environment configs based on the parameters defined in
   * environments.php
   * @return [type] [description]
   */
  function get_environment() {

    $host   = $_SERVER['HTTP_HOST'];
    $env    = DIR_ENV . DS . 'environments.php';

    if (!file_exists($env)) {
      trigger_error("$env does not exist.");
      return;
    }

    $environment = require DIR_ENV . DS . 'environments.php';

    foreach ($environment as $env => $regex) {
      if (preg_match('/' . $regex . '/', $host)) {
        return $env;
      }
    }

    return 'dev';
  }



  /**
   * Gets the users preferred language provided by the browser
   * @param  string $default default language used by Throwdown
   * @return array           array of language prefs in priority order
   */
  function get_language($default) {
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
      $temp = explode(',', filter_var($_SERVER['HTTP_ACCEPT_LANGUAGE'], FILTER_SANITIZE_STRING));
    } else {
      return [$default];
    }

    return _each($temp, function($val, $index) {
      $test = preg_replace('/;q.+/', '', $val);
      return $test;
    });
  }



  function set_sitemap_index($path, $name) {

  }



  /**
   * Generates a collection of URLs based on the global routes defined by Dispatch
   * @return [type] [description]
   */
  function get_url_paths() {
    $pages = $GLOBALS['noodlehaus\dispatch']['routes']['any'];

    $pages = array_unique(
      _each($pages, function($value, $index) {
        return $value[0];
      })
    );

    return $pages;
  }


