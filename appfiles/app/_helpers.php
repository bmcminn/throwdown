<?php

  require_once('_config.php');
  require_once('data/languages.php');


  function checkYoConfig($option_name) {

    echo  "<p class=\"td-notice\">"
        . "Hey Partner!,<br>you need to set $option_name in your <code>config.json</code> file."
        . "</p><!-- .td-notice -->"
        ;

    return false;

    exit;
  }



  function languagePref($pref) {
    global $languages;

    $longLang = $lang = '';

    foreach ($languages as $language) {
      $longLang = $language[0];
      $lang     = $language[1];
      $selected = '';

      if ($pref === $lang) {
        $selected = " selected";
      }

      echo "<option value=\"$lang\"$selected>$longLang</option>\r\n";
    }

  } // languagePref()



// ========================================
//   OBJECT HELPER FUNCTIONS
// ========================================

  /**
   * [objectToArray | returns an array containing the objects properties]
   * @param object $obj [description]
   */
  function objectToArray($result) {

    $array = array();

    foreach ($result as $key=>$value) {
      if (is_object($value)) {
        $array[$key]=ObjectToArray($value);

      } elseif (is_array($value)) {
        $array[$key]=ObjectToArray($value);

      } else {
        $array[$key]=$value;
      }
    }
    return $array;
  }


  /**
   * [debug | outputs a debug message to the console via embedded JS script]
   * @param  [type] $message [description]
   */
  function debug($message) {
    echo "<script>console.debug('[flapjack] $message')</script>";
  }

