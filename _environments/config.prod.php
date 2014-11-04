<?php

return function() {
  $settings = [
    // app config data
    'app.hostname'    => 'localhost'

    // server config data
  , 'server.env'      => 'production'
  , 'server.timezone' => 'America/Chicago'
  ];


  // set default timezone at config level, so the app has less to do
  date_default_timezone_set($settings['server.timezone']);


  return $settings;
};