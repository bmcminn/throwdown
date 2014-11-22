<?php

  return function() {

    $common   = require_once 'common.php';

    $settings = array_merge_recursive($common, [
        'app.hostname'    => 'localhost'
      , 'server.env'      => explode('.', basename(__FILE__, '.php'))[1]
      ]);

    return $settings;
  };
