<?php

  // home route
  map('/', function() {
    echo "homepage";
  });


  // pages route
  map('/{page}', function($args) {
    echo 'page ' . $args['page'];
  });


  // Load all Plugin routes
  $pluginRoutes = glob_recursive(DIR_PLUGINS . DS . '*_routes.php');

  foreach ($pluginRoutes as $plugin => $file) {
    require_once($file);
  }

