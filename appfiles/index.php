<?php

  require_once('app/_config.php');

  // INCLUDE LIBRARIES
  include_once('app/libs/eden/eden.php');
  include_once('app/libs/phpQuery/phpQuery.php');


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

  $newstart           = __DIR__ . '/install.php';
  $newstartDuplicate  = __DIR__ . '/app/install.php';

  if (file_exists($newstart) && is_readable($newstart)) {
    if (file_exists($newstartDuplicate)) {
      unlink($newstart);

    } else {
      include_once($newstart);
      exit; // cancel the party

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
