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



  function dev($message=null) {

    $messages = stash('messages') ? stash('messages') : stash('messages', []);

    // print_r($messages);

    if (settings('server.env') === 'dev') {
      if (is_string($message)) {
        $messages[] = $message;
        stash('messages', $messages);

      } else {
        echo "<script>window.messages=\"" . json_encode($messages) . "\"; console.log(window.messages);</script>";
      }
    }
  }

