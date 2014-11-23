<?php

  /**
   * This file is setup for your common configuration parameters shared across
   * environments. Usually these will be parameters involving language prefs,
   */

  $temp = "";


  //
  // Simple model definitions can go here
  //

  $model = [
    'server.timezone' => 'America/Chicago'
  ];


  //
  // User-Agent language stack
  //

  if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $temp = explode(',', filter_var($_SERVER['HTTP_ACCEPT_LANGUAGE'], FILTER_SANITIZE_STRING));
  }

  $lang = _each($temp, function($val, $index) {
    $test = preg_replace('/;q.+/', '', $val);
    return $test;
  });

  $model['user.language'] = $lang;



  //
  // Return our model
  //

  return $model;
