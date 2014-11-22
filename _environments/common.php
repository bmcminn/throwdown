<?php


  $model = [
    'server.timezone' => 'America/Chicago'
  , 'user.language'   => explode(',', filter_var($_SERVER['HTTP_ACCEPT_LANGUAGE'], FILTER_SANITIZE_STRING))
  ];


  //
  // User-Agent language stack
  //

  $lang = _each($model['user.language'], function($val, $index) {
    $test = preg_replace('/;q.+/', '', $val);
    return $test;
  });


  $model['user.language'] = $lang;





  return $model;
