<?php

  $pages = $GLOBALS['noodlehaus\dispatch']['routes']['any'];

  $pages = array_unique(_each($pages, function($value, $index) {
    return $value[0];
  }));

  print_r($pages);
