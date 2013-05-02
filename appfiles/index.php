<?php

  require_once('app/_config.php');

  // INCLUDE LIBRARIES
  include_once('app/libs/eden/eden.php');
  include_once('app/libs/phpQuery/phpQuery.php');
  require_once('app/libs/markdown/markdown.php');


  // INCLUDE HELPER LIBS
  require_once('app/_helpers.php');
  require_once('app/_articles.php');


  // include_once('app/articles.php');
  include_once('app/template.php');
  include_once('app/libs/markdown/markdown.php');


  $APP_CONFIG = json_decode(readFileContents('config.json'));



// ===================================
//  RUN INSTALL IF WE HAVEN'T ALREADY
// ===================================

  $installScript        = __DIR__ . '/install.php';
  $installScriptBackup  = __DIR__ . '/app/install.php';

  if (file_exists($installScript) && is_readable($installScript)) {


    if (isset($_POST['hiddenInstallID']) && ($_POST['hiddenInstallID'] === 'installing')) {

      foreach ($_POST as $key=>$value) {
        if (!preg_match('/hidden/', $key)) {
          $APP_CONFIG->$key = $value;
        }
      }

      overwriteFile('config.json', json_encode($APP_CONFIG));
      $_POST['hiddenInstallID'] = "nullified";
    }


    // If the install script was backed up after install
    //   remove the install.php script from __DIR__
    if (file_exists($installScriptBackup)) {
      unlink($installScript);

    // Else if the install script was run and the
    //   install flag is set move install.php to /app
    } elseif (file_exists($installScript) && isset($APP_CONFIG->installed)) {
      rename($installScript, $installScriptBackup);

    // Else - run the install just like the first time
    } else {
      include_once($installScript);
      exit; // cancel the rest of the party

    } // if (file_exists() && is_readable()) { ... }
  }



// ===================================
//  BEGIN BLOG APP
// ===================================



  // if ($_GET) {
  //   print_r($_GET);
  // }


  if (isset($_GET['article'])) {
    $articleName  = $_GET['article'];
    $fileData     = getArticle($articleName);
    $fileContents = readFileContents($fileData->location);

    echo Markdown($fileContents);
    // print_r($fileData);
  }


  // // read in the template contents
  // $templateContents = readFileContents('template/template.html');

  // // run our template contents through our template parser
  // $templateContents = processTemplate($templateContents);




  // if (count($_GET) > 0) {
  //   // Figure out what to do
  //   print_r($_GET);

  // } else {
  //   // display the normal template


  // }



  // echo $templateContents;
