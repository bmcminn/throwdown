<?php

  /**
   * Contains all custom functions and variables for template modifications
   */


  /**
   * [processTemplate]
   * @param  [type] $contents [description]
   * @return [type]           [description]
   */
  function processTemplate($contents) {

    // $contents = preg_replace();
    return $contents;

  }



  /**
   * [meta_lang description]
   * @param  string $prefLang [description]
   * @return [type]           [description]
   */
  function meta_lang($prefLang = 'en') {
    global $APP_CONFIG;

    if ($prefLang !== 'en') {
      return $APP_CONFIG->preferredLanguage;
    } else {
      return 'en';
    }
  }



  /**
   * Accepts a preferred langauge ISO code and assigns it as
   * the default "selected" option within a <select> field.
   * @param  string $pref ex: 'en'
   * @return echo
   */
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



  /**
   * Echoes a properly formatted copyright date string based on the input year.
   * @param  string $startDate ex: '2012'
   * @return echo
   */
  function copyrightDate($startDate, $echo = false) {
    $currentYear = date('Y');

    // NO FUTURE DATES!!!
    if ($startDate > $currentYear) {
      $startDate = $currentYear;
    }

    if ($startDate === $currentYear) {
      echo $startDate;
    } else {
      echo $startDate . '-' . $currentYear;
    }
  }



  function the_template() {

    global $mustache, $APP_CONFIG;

    // Load template
    $template = readFileContents(TEMPLATE_INDEX_HTML);

    $template_contents = [
      "PAGE_NAME"           =>  $APP_CONFIG->blogName
    , "SITE_NAME"           =>  $APP_CONFIG->blogName
    , "PREFERRED_LANGUAGE"  =>  $APP_CONFIG->preferredLanguage
    // , 'PAGE_DESCRIPTION'    =>  $APP_CONFIG->
    // , 'PAGE_KEYWORDS'       =>  $APP_CONFIG->
    , "PAGE_AUTHOR"         =>  $APP_CONFIG->userName
    , "navigation_main"     =>
      [
        "nav_links" =>
        [
          ["LINK_HREF" => '/articles/',   "LINK_NAME" => "Archives"]
        , ["LINK_HREF" => '/categories/', "LINK_NAME" => "Categories"]
        , ["LINK_HREF" => '/tags/',       "LINK_NAME" => "Tags"]
        ]
      ]
    ];

    echo $mustache->render($template, $template_contents);

  } // the_template()



//   <!doctype html>
// <html class="no-js" lang="{{PREFERRED_LANGUAGE}}">
// <head>
//   <meta charset="utf-8">

//   <title>{{TEMPLATE_NAME}}</title>

//   <meta name="description" content="{{PAGE_DESCRIPTION}}">
//   <meta name="keywords"    content="{{PAGE_KEYWORDS}}">
//   <meta name="author"      content="{{PAGE_AUTHOR}}">

//   <meta name="viewport" content="width=device-width">

//   <link rel="author" href="humans.txt">
//   <link rel="stylesheet" href="css/style.css">

//   <script src="js/libs/modernizr.min.js"></script>

// </head>


// <body role="main">

//   <section></section>



//   <script src="js/libs/fitvids.min.js"></script>
//   <script src="js/plugins.js"></script>

//   <script>
//     // Google Analytics
//     var _gaq=[['_setAccount','{{GOOGLEANALYTICS}}'],['_trackPageview']];
//     (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
//     g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
//     s.parentNode.insertBefore(g,s)}(document,'script'));
//   </script>

// </body>
// </html>
