<?php

  // home route
  map('/', function() {
    echo "homepage";
  });



  // Load all Plugin routes
  $pluginRoutes = glob_recursive(DIR_PLUGINS . DS . '*_routes.php');

  foreach ($pluginRoutes as $plugin => $file) {
    require_once($file);
  }



  // pages route
  map('/{page}', function($args) {
    echo 'page ' . $args['page'];
  });

