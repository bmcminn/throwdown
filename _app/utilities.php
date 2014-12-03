<?php

  /**
   * Iterates recursively over a given directory pattern, returning a collection
   * of matching files
   * @param  string  $pattern directory pattern
   * @param  integer $flags   flags
   * @return array            collection of
   */
  function glob_recursive($pattern, $flags = 0) {
    $files = glob($pattern, $flags);

    foreach (glob(dirname($pattern) . DS . '*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
      $files = array_merge($files, glob_recursive($dir . DS . basename($pattern), $flags));
    }

    return $files;
  }



  /**
   * Iterates and filters over a collection
   * @param  array  $stack    collection to be filtered
   * @param  func   $callback callback with value and index of collection as args
   * @return array            filtered collection
   */
  function _each($stack, $callback=null) {

    $argc = func_num_args();

    // Error messaging
    $errs = [
      'noArgs'    => 'function: _each(): requires two arguments'
    , 'firstArg'  => 'function: _each(): required: first argument must be an array'
    , 'secondArg' => 'function: _each(): required: second argument must be a callback function'
    ];

    // Error checking
    if (count($argc) === 0) { throw new InvalidArgumentException($errs['noArgs']); }
    if (!is_array($stack))  { throw new InvalidArgumentException($errs['firstArg']); }
    if (!$callback)         { throw new InvalidArgumentException($errs['secondArg']); }

    // Field defs
    $i = 0;
    $c = count($stack)-1;

    // Operations
    for($i;$i<=$c;$i++) {
      $stack[$i] = $callback($stack[$i], $i);
    }

    return $stack;
  }



  /**
   * [dev description]
   * @param  [type] $message [description]
   * @return [type]          [description]
   */
  function dev($message=null) {

    $messages = stash('messages') ? stash('messages') : stash('messages', []);

    // var_dump($messages);

    if (settings('server.env') === 'dev') {
      if (is_string($message)) {
        $messages[] = $message;
        stash('messages', $messages);

      } else {
        echo "<script>window.messages=\"" . json_encode($messages) . "\"; console.log(window.messages);</script>";
      }
    }
  }


