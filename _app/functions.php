<?php

  function get_environment() {

    $host   = $_SERVER['HTTP_HOST'];
    $env    = DIR_ENV . DS . 'environments.php';

    if (!file_exists($env)) {
      trigger_error("$env does not exist.");
      return;
    }

    $environment = require DIR_ENV . DS . 'environments.php';

    foreach ($environment as $env => $regex) {
      if (preg_match('/' . $regex . '/', $host)) {
        return $env;
      }
    }

    return 'dev';
  }



  function glob_recursive($pattern, $flags = 0) {
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern) . DS . '*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
      $files = array_merge($files, glob_recursive($dir . DS . basename($pattern), $flags));
    }
    return $files;
  }



  function dev($message=null) {

    $messages = stash('messages') ? stash('messages') : stash('messages', []);

    if (settings('server.env') === 'dev') {
      if (is_string($message)) {
        $messages[] = $message;
        stash('messages', $messages);

      } else {
        echo "<script>window.messages=\"" . json_encode($messages) . "\"; console.log(window.messages);</script>";
      }
    }
  }



  /**
   * Iterates and filters over a collection
   * @param  array  $stack    collection to be filtered
   * @param  func   $callback callback with value and index of collection as args
   * @return array            filtered collection
   */
  function _each($stack, $callback=null) {
    $argc = func_num_args();

    if (count($argc) === 0) {
      throw new InvalidArgumentException('function: _each(): requires two arguments');
    }
    if (!is_array($stack)) {
      throw new InvalidArgumentException('function: _each(): required: first argument must be an array');
    }
    if (!$callback) {
      throw new InvalidArgumentException('function: _each(): required: second argument must be a callback function');
    }

    $i = 0;
    $c = count($stack)-1;

    for($i;$i<=$c;$i++) {
      $stack[$i] = $callback($stack[$i], $i);
    }

    return $stack;
  }
