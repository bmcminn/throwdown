<?php



  /**
   * Collects the contents of the config.json file and parses it
   * into a PHP array object
   * ---
   *
   * @uses   json_minify()                  [description]
   * @return object                         A PHP object array of the processed JSON data.
   */
  function get_config() {
    $data = file_get_contents(SYSTEM_CONFIG_JSON);
    $data = json_minify($data);
    return json_decode($data);

  }








  // TEMPLATE <head/> LEVEL CONTENT GENERATION FUNCTIONS
  //===========================================================================

  /**
   * Generates a <title/> string to be dumped into the template that
   * leverages SEO benefits.
   * ---
   *
   * @param  array    $params               OPTIONAL: Override array for $default_params
   * @return string                         returns the page title string based on the given formatting options
   */
  function page_title($params = []) {

    global $page_data, $page_title_override;

    $default_params = [
      'sitename'  => SITE_NAME
    , 'page_name' => false
    , 'return'    => false
    , 'seperator' => '|'
    , 'invert'    => false
    ];

    // Merge our array with the updated values passed via $params[]
    $params = array_merge($default_params, $params);

    // Establish default variables
    $page_name = '';

    // if the Markdown file provides a 'title' attribute
    if ($page_data && $page_data->keyExists('title')) {

      $params['page_name'] = $page_data->fetch('title');

      // if we're inverting the page title format
      // put the site name before the page name
      if ($params['invert']) {
        $page_name  = "$params[sitename] $params[seperator] $params[page_name]";

      // put the page name before the site name
      } else {
        $page_name  = "$params[page_name] $params[seperator] $params[sitename]";
      }

    } else {
      $page_name = $params['sitename'];
    }

    return $page_name;
  }



  /**
   * Generates a <meta> tag for a given key value passed as an argument.
   * ---
   *
   * @param  string   $data_key             REQUIRED: Determines if a FrontMatter key exists and echoes the correlating meta tag if it does.
   * @param  string   $attr_type            OPTIONAL: Defines what type of meta tag it should be defined as
   * @return null
   */
  function page_meta($data_key, $attr_type="name") {

    global $page_data;

    $content = '';

    // If it's a FrontMatter property
    if ($page_data && $page_data->keyExists($data_key)) {
      $content = $page_data->fetch($data_key);
      echo "<meta $attr_type=\"$data_key\" content=\"$content\">\r\n";
    }

    return null;
  }



  /**
   * Helper function to generate <link> tags
   * ---
   *
   * @return [type]                         [description]
   */
  function page_link($link_rel, $link_value, $val_type = "href") {
    echo "<link rel=\"$link_rel\" href=\"$link_value\">\r\n";
  }



  /**
   * Generates favicon links for general .ico and apple/iOS
   * specific favicon <link> tags.
   * ---
   *
   * @uses   page_link()                    [description]
   * @param  string   $favicon              REQUIRED: this generates the favicon targeting the given file location string
   * @param  string   $mobile               OPTIONAL: this generates an apple/iOS specific link to the respective favicon, provided it's been defined as an argument
   * @return null
   */
  function page_favicons($favicon, $mobile = false) {

    // Generate our favicon link
    $icon_rel = 'shortcut icon';
    $icon_file = $favicon;
    page_link($icon_rel, $icon_file);

    // If we defined a mobile icon
    if ($mobile) {
      $icon_rel = 'apple-touch-icon';
      $icon_file = $mobile;
      page_link($icon_rel, $icon_file);
    }

    return null;
  }








  // PAGE CONTENT GENERATOR FUNCTIONS
  //===========================================================================

  /**
   * Generates a concatenated string of space delimited classes
   * for the <body/> tag.
   * ---
   *
   * @param  array    $classes              OPTIONAL: a comma delimited array of strings which are added to collective output
   * @return string
   */
  function page_body_classes($classes = []) {

    global $page, $page_data, $requestURL;

    // print_r($page);

    // Default variables
    $content = $template = "";

    if ($page_data && $page_data->fetch('template')) {
      $template = $page_data->fetch('template');

    } elseif ($page === preg_replace("/\//", '', URL_ARTICLES)) {
      $template = preg_replace("/\//", '', URL_ARTICLES);

    } else {
      $template = 'default';
    }

    $default_classes = [
      'page-' .$requestURL[1]
    , 'template-' . $template
    ];

    // Merge custom classes with default classes
    $classes = array_merge($default_classes, $classes);

    // Generate content as space delimited string
    foreach ($classes as $class) {
      $content .= "$class ";
    }

    echo preg_replace('/\s$/', '', $content);

  }



  /**
   * Generates a copyright year that is output to the footer;
   * Based on whether you supply a yearEstablish value, it will
   * generate a "$yearEstablished - $currentYear" string combination.
   * ---
   *
   * @param  int      $yearEstablished      OPTIONAL: Provide a year value to be interpreted as a copyright duration
   * @param  string   $sep                  OPTIONAL: A separater string, defined as a pipe "|" character
   * @return string                         Fully formatted output string
   */
  function copyright_year($yearEstablished = false, $sep = "&ndash;") {

    $output = "&copy; ";

    if (!$yearEstablished) {
      $output .= Date('Y');
    } else {
      $output .= $yearEstablished . " $sep " . Date('Y');
    }

    return $output;
  }








  // TEMPLATE GENERATOR FUNCTIONS
  //===========================================================================

  /**
   * [load_resource description]
   * ---
   *
   * @param  string   $resource_location    [description]
   * @return string   ERROR_TEMPLATE        System constant detailing an error message was returned
   */
  function load_resource($resource_location) {

    include($resource_location);

    // if (is_file($resource_location)) {
    //   include($resource_location);
    // } else {
    //   return ERROR_TEMPLATE;
    // }
  }



  /**
   * [load_plugin description]
   * ---
   *
   * @uses   load_resource()                [description]
   * @param  string $asset_name             [description]
   * @return load_resource()
   */
  function load_plugin($asset_name) {
    return load_resource(DIR_PLUGINS . $asset_name . '/plugin.php');
  }



  /**
   * Generates a template include based on the file name passed as an argument.
   * ---
   *
   * @uses   load_resource()                [description]
   * @param  string      $template_name     name of the template file to be included
   * @return load_resource()
   */
  function load_template($asset_name) {
    return load_resource(DIR_TEMPLATES . $asset_name);
  }



  /**
   * Helper function that generates the header template include statement.
   * ---
   *
   * @uses   load_template()                [description]
   * @return load_template()
   */
  function page_header() {
    return load_template(TEMPLATE_HEADER);
  }



  /**
   * Helper function that generates the footer template include statement.
   * ---
   *
   * @uses   load_template()                [description]
   * @return load_template()
   */
  function page_footer() {
    return load_template(TEMPLATE_FOOTER);
  }



  /**
   * This function simply redirects the browser to the 404 page
   * ---
   *
   * @return null
   */
  function page_404($justContent = false) {
    header('Location:/404');
    return null;
  }








  //===========================================================================

  /**
   * [template_js description]
   * ---
   *
   * @uses   load_asset()                   [description]
   * @param  string  $filename              [description]
   * @param  boolean $echo                  [description]
   * @return string                         [description]
   */
  function template_js($filename, $minified=THEME_MINIFY_JS) {

    $file = THEME_JS . $filename;

    if ($minified) {
      $file = THEME_MINIFY_JS_PATH . preg_replace('/\.js/', THEME_MINIFY_JS_SUFFIX, $filename);
    }

    return $file;
  }



  /**
   * [template_js description]
   * ---
   *
   * @param  string  $filename              [description]
   * @param  boolean $echo                  [description]
   * @return string                         [description]
   */
  function template_css($filename) {
    $file = THEME_CSS . $filename;
    return $file;
  }



  /**
   * [template_less description]
   * ---
   *
   * @param  string  $filename              [description]
   * @param  boolean $echo                  [description]
   * @return string                         [description]
   */
  function template_less($filename) {
    $file = THEME_LESS . $filename;
    return $file;
  }



  /**
   * [template_img description]
   * ---
   *
   * @param  string  $filename              [description]
   * @param  boolean $echo                  [description]
   * @return string                         [description]
   */
  function template_img($filename) {
    $file = THEME_IMG . $filename;
    return $file;
  }



  /**
   * [plugin_svg description]
   * ---
   *
   * @param  string  $filename              [description]
   * @param  boolean $echo                  [description]
   * @return string                         [description]
   */
  function template_svg($filename) {
    $file    = ROOT_DIR . THEME_IMG . $filename;
    $content = file_get_contents($file);
    return $content;
  }








  //===========================================================================

  /**
   * [queue_script description]
   * ---
   *
   * @param  [type] $script                 [description]
   * @param  [type] $minified               [description]
   * @param  [type] $location               [description]
   * @return null
   */
  function queue_script($script, $minified=THEME_MINIFY_JS, $location) {

    global $page_header_scripts, $page_footer_scripts;

    switch($location) {
      case 'header':
        $page_header_scripts[] = template_js($script, $minified);
        break;

      case 'footer':
        $page_footer_scripts[] = template_js($script, $minified);
        break;
    }

    return null;
  }



  /**
   * [queue_header_script description]
   * ---
   *
   * @uses   queue_script()                 [description]
   * @param  [type] $script                 [description]
   * @param  [type] $minified               [description]
   * @return null
   */
  function queue_header_script($script, $minified=THEME_MINIFY_JS) {
    queue_script($script, $minified, 'header');
    return null;
  }



  /**
   * [queue_header_script description]
   * ---
   *
   * @uses   queue_script()                 [description]
   * @param  [type] $script                 [description]
   * @param  [type] $minified               [description]
   * @return null
   */
  function queue_footer_script($script, $minified=THEME_MINIFY_JS) {
    queue_script($script, $minified, 'footer');
    return null;
  }



  /**
   * Gererates a series of scripts to be loaded at a given point in a template.
   * ---
   *
   * @param  array    $array                REQUIRED: comma delimited array of strings designating what scripts should be loaded on this view
   * @return null
   */
  function page_scripts($array) {

    if (is_array($array)) {
      foreach($array as $script => $value) {
        echo "<script src=\"$value\"></script>\r\n";
      }
    }

    return null;
  }



  /**
   * Helper wrapper function for "page_scripts()" to specify <head> level JS files.
   * ---
   *
   * @param  array    $array                REQUIRED: comma delimited array of strings designating what scripts should be loaded on this view
   * @return null
   */
  function page_header_scripts() {
    global $header_scripts;

    page_scripts($header_scripts);
    return null;
  }



  /**
   * Helper wrapper function for "page_scripts()" to specify </body> level JS files.
   * ---
   *
   * @param  array    $array                REQUIRED: comma delimited array of strings designating what scripts should be loaded on this view
   * @return null
   */
  function page_footer_scripts() {
    global $footer_scripts;

    page_scripts($footer_scripts);
    return null;
  }








  //===========================================================================

  /**
   * [main_nav description]
   * ---
   *
   * @param  [type] $params                 [description]
   * @return null
   */
  function main_nav($params = []) {

    global $page_data, $page, $requestURL;

    // Define default settings
    $default_params = [
        //   'sitename'  => SITE_NAME
        // , 'page_name' => false
        // , 'return'    => false
    ];

    // Merge our array with the updated values passed via $params[]
    $params  = array_merge($default_params, $params);

    $data    = get_config();  // Collect menu data
    $content = $class = "";   // Generate our links

    foreach ($data->main_navigation as $link => $value) {

      // Determine the active page link and give it an active class
      if (preg_match("/$value/", $requestURL[1])) {
        $class = "class=\"active\"";
      } else {
        $class = "";
      }

      $title_text =   preg_replace('/[-_]/', ' ', $value);
      $content    .=  "<li $class><a href=\"/$value\">$title_text</a></li>\r\n";
    }

    // Concatenate markup into main-nav block
    echo  "<nav class=\"main-nav\" role=\"navigation\">\r\n"
        ,   "<ul>\r\n"
        ,     $content
        ,   "</ul>\r\n"
        , "</nav>\r\n"
        ;

    return null;
  }



  /**
   * Helper function that aliases the global $markdown object to transform
   * the page content and echoes out to the view
   * ---
   *
   * @param  boolean    $echo               Boolean that determines if the function should echo or return the transformed markdown data
   * @return string                         Conditionally returns the transformed markdown data
   */
  function page_content($echo = true) {

    global $markdown, $page_data;

    $content = $markdown->transform($page_data->fetch('content'));

    if ($echo) {
      echo $content;
    } else {
      return $content;
    }
  }



  /**
   * Helper function that aliases the global $markdown object to transform a string
   * passed as an argument parameter
   * ---
   *
   * @param  string     $string Markdown content string that should be converted
   * @param  boolean    $echo   Boolean that determines if the function should echo or return the transformed markdown data
   * @return string             Conditionally returns the transformed markdown data
   */
  function markdown($string, $echo = true) {

    global $markdown;

    $content = $markdown->transform($string);

    if ($echo) {
      echo $content;
    } else {
      return $content;
    }
  }








  // SOCIAL MEDIA CONTENT GENERATION FUNCTIONS
  //===========================================================================

  /**
   * Generates template level Facebook Open Graph data.
   * - Courtesy of http://davidwalsh.name/facebook-meta-tags
   * @param  array    $meta_data        An array of meta data types that you may customize as needed.
   * @return null
   */
  function page_fb_open_graph($meta_data = []) {

    global $page_data;

    $error_message =  ERROR_FB_OPENGRAPH;

    $standard_data  = [
      'image'       => 'http://davidwalsh.name/wp-content/themes/klass/img/facebooklogo.png'
    , 'title'       => 'Facebook Open Graph META Tags'
    , 'url'         => SITE_URL
    , 'site_name'   => SITE_NAME
    , 'type'        => SITE_TYPE
    ];

    if (defined("FB_OPEN_GRAPH_ID")) {
      if (FB_OPEN_GRAPH_ID !== '') {

        foreach ($standard_data as $data => $value) {
          if ($data) {
            page_meta($data, 'property');
          }
        }

      } else {
        throw new RuntimeException($error_message);
      }

    } else {
      throw new RuntimeException($error_message);
    }

    return null;
  }



  /**
   * Generates an html5boilerplate compliant Google Analytics tracking script using only the tracking ID code.
   * @param  string   $analytics_ID     REQUIRED: the tracking ID provided by Google Analytics
   * @return null
   */
  function page_ga_tracking($analytics_ID = '') {

    $error_message =  ERROR_GOOGLE_ANALYTICS;

    if ($analytics_ID === '') {
      echo $error_message;
      return false;
    }

    echo  "<script>"
        , "(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]="
        , "function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;"
        , "e=o.createElement(i);r=o.getElementsByTagName(i)[0];"
        , "e.src='//www.google-analytics.com/analytics.js';"
        , "r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));"
        , "ga('create','$analytics_ID');ga('send','pageview');"
        , "</script>"
        ;

    return null;
  }
