<?php

  require_once('_config.php');

  require_once('libs/frontmatter/frontmatter.php');
  require_once('libs/markdown/markdown.php');

  require_once('_articles.php');
  require_once('_helpers.php');


  $APP_CONFIG = json_decode(readFileContents('../config.json'));



  //========================================
  // REFORMAT TAGS AS AN ARRAY OF TAGS
  //========================================
  $articlesList   = getArticles('../articles');


  // Reference our article cache resources
  $articlesCache  = '../' . ARTICLES_CACHE_FILE;
  $cacheContents  = [];

  $categoriesList = [];
  $tagsList       = [];


  $i = 0;

  foreach ($articlesList as $key => $value) {

    // Get the file location for our article
    $fileLocation = $articlesList[$key];

    // Read article contents into variable
    $fileContents = readFileContents($fileLocation);

    // Extract article meta data
    $fileExtract  = new FrontMatter($fileLocation);
    $metaKeys     = $fileExtract->fetchKeys();


    // Parse article title from file name
    $fileName     = parseArticleTitle($fileLocation);

    // Append article title to file contents
    $fileContents = markdownTheTitle($fileName) . $fileContents;

    // Parse Markdown contents
    $fileContents = Markdown($fileContents);




    //========================================
    // BUILD ARTICLES ARRAY
    //========================================
    $tempName     = strToLower(preg_replace('/\s/', '-', $fileName));

    $fileLocation = preg_replace('/[\s\S]*(articles\/[\s\S]*)/', '$1', $fileLocation);

    $articleData  = [
                      'name'      => $fileName
                    , 'location'  => $fileLocation
                    , 'permalink' => $APP_CONFIG->remotesite . $fileLocation
                    ];

    // Get article categories
    $categories = explode('/', $articleData['location']);
    unset($categories[0]);  // remove first empty index
    array_pop($categories); // remove filename from cats array
    // print_r($categories);

    foreach ($categories as $key => $value) {
      $articleData['categories'][] = $value;
      $categoriesList[$value][] = $tempName;
    }


    //========================================
    // REFORMAT TAGS AS AN ARRAY OF TAGS
    //========================================
    $tags             = explode(', ', $metaKeys['tags']);
    $metaKeys['tags'] = $tags;

    foreach ($tags as $key => $value) {
      $tagsList[$value][] = $tempName;
    }

    // Append metakeys to
    foreach ($metaKeys as $key => $value) {
      $articleData[$key] = $value;
    }

    $cacheContents['articles'][$tempName]  = $articleData;

    $i += 1;
  }


  //========================================
  // Collect ALL 'categories' into one list
  //========================================
  $cacheContents['categories']  = $categoriesList;


  //========================================
  // Collect ALL 'tags' into one list
  //========================================
  $cacheContents['tags'] = $tagsList;



  //========================================
  // JSON ENCODE CACHE CONTENTS
  //========================================
  $cacheContents  = json_encode($cacheContents);

  print_r(json_decode($cacheContents));

  // Write our cache data to the /articles/articles.json cache file
  overwriteFile($articlesCache, $cacheContents);



/////////////////////
// EXTRANIOUS DATA //
/////////////////////

  // // Return article content
  // $fileContents     = $fileExtract->fetch('content');
