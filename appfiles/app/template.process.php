<?php

  require_once('_config.php');

  require_once('libs/frontmatter/frontmatter.php');
  require_once('libs/markdown/markdown.php');

  require_once('_articles.php');
  require_once('_helpers.php');



  $articlesList   = getArticles('../articles');


  foreach ($articlesList as $key => $value) {

    $article        = $articlesList[$key];

    // Read article contents into variable
    $fileContents   = readFileContents($article);

    // Extract article meta data
    $fileExtract    = new FrontMatter($article);

    // Return article content
    $fileContents   = $fileExtract->fetch('content');

    // Parse article title from file name
    $fileName       = parseArticleTitle($value);

    // Append article title to file contents
    $fileContents   = markdownTheTitle($fileName) . $fileContents;

    // Parse Markdown contents
    $fileContents   = Markdown($fileContents);

    print_r($fileContents);

    // echo $fileMeta;
    // print_r($fileMeta);

  }
