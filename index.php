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
   *    > php -S localhost:1234 index.php`
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
  define("DS",            DIRECTORY_SEPARATOR);
  define("EOL",           PHP_EOL);

  define("DIR_ROOT",      __DIR__);
  define("DIR_APP",       __DIR__ . DS . '_app');
  define("DIR_ERROR",     __DIR__ . DS . '_app' . DS . 'error_logs');
  define("DIR_MODELS",    __DIR__ . DS . '_data');
  define("DIR_ENV",       __DIR__ . DS . '_environments');
  define("DIR_PLUGINS",   __DIR__ . DS . '_plugins');
  define("DIR_PUBLIC",    __DIR__ . DS . '_public');
  define("DIR_DIST",      __DIR__ . DS . '_public' . DS . '_dist');
  define("DIR_VENDOR",    __DIR__ . DS . 'vendor');


  // Autoload all the things
  require_once DIR_VENDOR . DS . 'autoload.php';


  // Register Whoops!
  $whoops = new \Whoops\Run;
  $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
  $whoops->register();


  // Settings configuration
  settings('@' . DIR_ENV . DS . 'config.' . get_environment() . '.php');


  if (settings('server.env') === 'dev') {
    echo "I'm a sassy princess!!!";
  }

  echo date_default_timezone_get();


  require DIR_APP . DS . "routes.php";



  dispatch();
