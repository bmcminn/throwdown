<?php

  return function() {

    $common   = require_once 'common.php';
    $settings = array_merge_recursive([
        // app config data
        'app.hostname'    => 'localhost'

        // server config data
      , 'server.env'      => explode('.', basename(__FILE__, '.php'))[1]

      ], $common
    );

    // set default timezone at config level, so the app has less to do
    date_default_timezone_set($settings['server.timezone']);

    return $settings;
  };