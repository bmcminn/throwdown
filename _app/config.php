<?php

  define("DS",            DIRECTORY_SEPARATOR);
  define("EOL",           PHP_EOL);

  define("DIR_ROOT",      __DIR__ . DS . '..');
  define("DIR_APP",       __DIR__ . DS . '..'  . DS . '_app');
  define("DIR_ERROR",     __DIR__ . DS . '..'  . DS . '_app' . DS . 'error_logs');
  define("DIR_MODELS",    __DIR__ . DS . '..'  . DS . '_data');
  define("DIR_ENV",       __DIR__ . DS . '..'  . DS . '_environments');
  define("DIR_PLUGINS",   __DIR__ . DS . '..'  . DS . '_plugins');
  define("DIR_PUBLIC",    __DIR__ . DS . '..'  . DS . '_public');
  define("DIR_DIST",      __DIR__ . DS . '..'  . DS . '_public' . DS . '_dist');
  define("DIR_VENDOR",    __DIR__ . DS . '..'  . DS . 'vendor');
