<?php

  /**
   * WELCOME TO THROWDOWN :D
   *
   * ==============================
   *
   * To get started, ensure you have a local server installed on your machine or
   * if PHP is setup on your local system PATH, type the following into
   * a terminal of your choice:
   *
   *  > php -S localhost:1234 index.php
   *
   * @sauce: http://php.net/manual/en/features.commandline.webserver.php
   *
   * ==============================
   *
   * If you have any questions about getting started with the basics, you can
   * refer to most any feature of the Dispatch framework which Throwdown uses
   * liberally to handle a lot of low-level features such as routing and configurations
   *
   * @sauce: https://github.com/noodlehaus/dispatch
   */


  // Define directory constants
  require_once __DIR__ . "/_app/config.php";

  // Autoload all the things
  require_once DIR_VENDOR . DS . 'autoload.php';


  // Register Whoops!
  $whoops = new \Whoops\Run;
  $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
  $whoops->register();


  // Load our settings
  settings('@' . DIR_ENV . DS . 'config.' . get_environment() . '.php');


  // Define our apps timezone
  date_default_timezone_set(settings('server.timezone'));


  // Load our default routes
  require DIR_APP . DS . "routes.php";


  // Dispatch Throwdown!
  dispatch();
