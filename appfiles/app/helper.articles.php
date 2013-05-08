<?php

// ========================================
//   FILE REGEX STRINGS
// ========================================
  $regex  = array(
              'url_hostName'          => '/https?:\/\/([\w\d-_\.]+)\/[\/a-zA-Z0-9-_\.]+/'
            , 'file_extractTitle'     => '/[\s\S]+\/([\w\d-]+).md$/'
            , 'file_metaHeader'       => '/META[\r\n]+([\s\S]+)\/META[\s\S]+/'
            , 'file_removeMetaHeader' => '/META[\r\n]+[\s\S]+\/META([\s\S]+)/'
            );


  /**
   * [getArticle description]
   * @param  [type] $name [description]
   * @return [type]       [description]
   */
  function getArticle($name) {

    $articleMeta = readFileContents(ARTICLES_CACHE_FILE);
    $article = json_decode($articleMeta);

    return $article->articles->$name;
  }


  /**
   * [getArticles | Collects all files within a given directory]
   * @param  [string] $path [description]
   * @return [array]        [description]
   */
  function getArticles($location) {

    $path = realpath($location);
    $articles = [];

    foreach (new RecursiveIteratorIterator (new RecursiveDirectoryIterator($path)) as $filename) {

      $tempPath = $filename->getRealPath();

      if (preg_match('/\.md/', $tempPath)) {

        // normalize path to unix style path
        $tempPath = preg_replace('/\\\/', '/', $tempPath);
        $tempPath = preg_replace('/^\w\:/', '', $tempPath);

        $articles[] = $tempPath;
      }
    }

    return $articles;
  }




// ========================================
//   FILE READ/WRITE HELPER FUNCTIONS
// ========================================

  /**
   * [readFileContents]
   * @param [string] $fileName [description]
   */
  function readFileContents($fileName) {
    $fileHandle   = fopen($fileName, 'r') or die("can't open file: " . $fileName);
    $fileContents = fread($fileHandle, filesize($fileName));
    fclose($fileHandle);

    return $fileContents;
  }


  /**
   * [overwriteFile]
   * @param [string] $fileName     [description]
   * @param [array]  $fileContents [description]
   */
  function overwriteFile($fileName, $fileContents) {
    $fileHandle = fopen($fileName, 'w+') or die("can't open file: " . $fileName);
    fwrite($fileHandle, $fileContents);
    fclose($fileHandle);

    return null;
  }


  /**
   * [appendToFile]
   * @param [string] $fileName     [description]
   * @param [array]  $fileContents [description]
   */
  function appendToFile($fileName, $fileContents) {
    $fileHandle = fopen($fileName, 'a+') or die("can't open file: " . $fileName);
    fwrite($fileHandle, $fileContents);
    fclose($fileHandle);

    return null;
  }


  /**
   * [prependToFile]
   * @param [string] $fileName     [description]
   * @param array  $fileContents [description]
   */
  function prependToFile($fileName, $fileContents) {
    $fileHandle = fopen($fileName, 'r+') or die("can't open file: " . $fileName);
    fwrite($fileHandle, $fileContents);
    fclose($fileHandle);

    return null;
  }

  /**
   * [parseArticleTitle]
   * @param  [string]  $fileName  [description]
   * @param  [boolean] $caps      [description]
   * @return [string]             [description]
   */
  function parseArticleTitle($fileName, $caps = true) {

    global $regex;

    $fileName = preg_replace($regex['file_extractTitle'], '$1', $fileName);
    $fileName = preg_replace('/-/', ' ', $fileName);

    // Capitalize the type if necessary
    if ($caps) {
      $fileName = ucwords($fileName);
    }

    return $fileName;
  }



// ========================================
//   MARKDOWN HELPER FUNCTIONS
// ========================================

  /**
   * [markdownTheTitle]
   * @param  [string] $titleString [description]
   * @return [string]              [description]
   */
  function markdownTheTitle($titleString) {
    return $titleString . "\r\n===\r\n";
  }
