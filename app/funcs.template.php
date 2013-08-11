<?php



// TEMPLATE <head/> LEVEL CONTENT GENERATION FUNCTIONS
//===========================================================================

  /**
   * Generates a <title/> string to be dumped into the template that leverages SEO benefits.
   * @param  array    $settings        OPTIONAL: Override array for $page_title_settings
   * @return string                    returns the page title string based on the given formatting options
   */
  function page_title($settings = []) {
    global $page_data, $page_title_override;

    $page_title_settings = [
      'sitename'  => SITE_NAME
    , 'page_name' => false
    , 'return'    => false
    , 'seperator' => '|'
    , 'invert'    => false
    ];

    // Merge our array with the updated values passed via $settings[]
    $settings = array_merge($page_title_settings, $settings);

    // Establish default variables
    $page_name = '';

    // if the Markdown file provides a 'title' attribute
    if ($page_data->keyExists('title')) {
      $settings['page_name'] = $page_data->fetch('title');

      // if we're inverting the page title format
      // put the site name before the page name
      if ($settings['invert']) {
        $page_name  = "$settings[sitename] $settings[seperator] $settings[page_name]";

      // put the page name before the site name
      } else {
        $page_name  = "$settings[page_name] $settings[seperator] $settings[sitename]";

      }

    } else {
      $page_name = $settings['sitename'];
    }

    return $page_name;
  } // page_title()





  /**
   * Helper function to generate <link> tags
   * @return [type] [description]
   */
  function page_link($link_rel, $link_value, $val_type = "href") {
    echo "<link rel=\"$link_rel\" href=\"$link_value\">\r\n";
  }





  /**
   * Generates favicon links for general .ico and apple/iOS specific favicon <link> tags.
   * @param  str   $favicon            REQUIRED: this generates the favicon targeting the given file location string
   * @param  str   $mobile             OPTIONAL: this generates an apple/iOS specific link to the respective favicon, provided it's been defined as an argument
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

    return;
  }





  /**
   * Generates a <meta> tag for a given key value passed as an argument.
   * @param  str      $data_key        REQUIRED: Determines if a FrontMatter key exists and echoes the correlating meta tag if it does.
   * @return null
   */
  function page_meta($data_key, $type="name") {
    global $page_data;

    $content = '';

    // If it's a FrontMatter property
    if ($page_data->keyExists($data_key)) {
      $content = $page_data->fetch($data_key);
    }

    echo "<meta $type=\"$data_key\" content=\"$content\">\r\n";

    return;
  } // page_meta()






// SOCIAL MEDIA CONTENT GENERATION FUNCTIONS
//===========================================================================

  /**
   * Generates template level Open Graph data for Facebook.
   * @return null
   */
  function page_fb_open_graph($meta_data = []) {
    global $page_data;

    $error_message =  PAGE_FBOG_ERROR_MESSAGE;

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
        echo $error_message;
      }

    } else {
      echo $error_message;
    }

    return;
  } // page_fb_open_graph()





  /**
   * Generates an html5boilerplate compliant Google Analytics tracking script using only the tracking ID code.
   * @param  str      $analytics_ID    REQUIRED: the tracking ID provided by Google Analytics
   * @return null
   */
  function page_ga_tracking($analytics_ID = '') {

    $error_message =  PAGE_GA_ERROR_MESSAGE;

    if ($analytics_ID === '') {
      echo $error_message;
      return false;
    }

    echo<<<GA_SNIPPET
<script>
   (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
    function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
    e=o.createElement(i);r=o.getElementsByTagName(i)[0];
    e.src='//www.google-analytics.com/analytics.js';
    r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
    ga('create','$analytics_ID');ga('send','pageview');
  </script>
GA_SNIPPET;

    return;
  } // page_ga_tracking()






// PAGE CONTENT GENERATOR FUNCTIONS
//===========================================================================

  /**
   * Generates a concatenated string of space delimited classes for the <body/> tag.
   * @param  array    $classes            OPTIONAL: a comma delimited array of strings which are added to collective output
   * @return string
   */
  function page_body_classes($classes = []) {
    global $page, $page_data, $requestURL;


    // Default variables
    $content = $template = "";


    if ($page_data->fetch('template')) {
      $template = $page_data->fetch('template');
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
  } // page_body_classes()





  /**
   * Gererates a series of scripts to be loaded at a given point in a template.
   * @param  array    $array              REQUIRED: comma delimited array of strings designating what scripts should be loaded on this view
   * @return null
   */
  function page_scripts($array) {

    if (is_array($array)) {
      foreach($array as $script => $value) {
        echo "<script src=\"$value\"></script>\r\n";
      }
    }

    return;
  } // footer_scripts()





          /**
           * Helper wrapper function for "page_scripts()" to specify <head> level JS files.
           * @param  array    $array              REQUIRED: comma delimited array of strings designating what scripts should be loaded on this view
           * @return null
           */
          function page_header_scripts($array) {

            page_scripts($array);

            return;
          } // footer_scripts()



          /**
           * Helper wrapper function for "page_scripts()" to specify </body> level JS files.
           * @param  array    $array              REQUIRED: comma delimited array of strings designating what scripts should be loaded on this view
           * @return null
           */
          function page_footer_scripts($direct_override = []) {

            global $footer_scripts;

            page_scripts($footer_scripts);

            return;
          } // footer_scripts()





  /**
   * Generates a copyright year that is output to the footer
   * ---
   * Based on whether you supply a yearEstablish value, it will generate a "$yearEstablished - $currentYear" string combination.
   * @param  int      $yearEstablished    OPTIONAL: Provide a year value to be interpreted as a copyright duration
   * @param  str      $sep                OPTIONAL: A separater string, defined as a pipe "|" character
   * @return str                          Fully formatted output string
   */
  function copyright_year($yearEstablished = false, $sep = "&ndash;") {

    $output = "&copy; ";

    if (!$yearEstablished) {
      $output .= Date('Y');
    } else {
      $output .= $yearEstablished . " $sep " . Date('Y');
    }

    return $output;

  } // copyright_year()







// TEMPLATE GENERATOR FUNCTIONS
//===========================================================================

  /**
   * [load_resource description]
   * @param  [type] $resource_location [description]
   * @return string PAGE_TEMPLATE_ERROR_MESSAGE   system constant detailing an error message was returned
   */
  function load_resource($resource_location) {

    if (is_file($resource_location)) {
      include($resource_location);
    } else {
      return PAGE_TEMPLATE_ERROR_MESSAGE;
    }

  } // load_resource()



          /**
           * [load_plugin description]
           * @param  [type] $asset_name [description]
           * @return load_resource()
           */
          function load_plugin($asset_name) {
            return load_resource(DIR_PLUGINS . $asset_name . '/plugin.php');
          }



          /**
           * Generates a template include based on the file name passed as an argument.
           * @param  str      $template_name name of the template file to be included
           * @return load_resource()
           */
          function load_template($asset_name) {
            return load_resource(DIR_TEMPLATES . $asset_name);
          }

                  /**
                   * Helper function that generates the header template include statement.
                   * @return load_template()
                   */
                  function page_header() {
                    return load_template(TEMPLATE_HEADER);
                  }



                  /**
                   * Helper function that generates the footer template include statement.
                   * @return load_template()
                   */
                  function page_footer() {
                    return load_template(TEMPLATE_FOOTER);
                  } // page_footer



                  /**
                   * [page_404 description]
                   * @return [type] [description]
                   */
                  function page_404($justContent = false) {

                    if ($justContent) {
                      return load_template('404.php');

                    } else {
                      page_header();
                      load_template('404.php');
                      page_footer();
                      exit;
                    }

                    return;
                  }



  /**
   * [load_asset description]
   * @param  [type]  $location [description]
   * @param  boolean $echo     [description]
   * @return [type]            [description]
   */
  function load_asset($location) {
    if ($location) {
      return $location;
    } else {
      return PAGE_EMPTY_PARAM_MESSAGE;
    }
  }


          /**
           * [template_js description]
           * @param  [type]  $filename [description]
           * @param  boolean $echo     [description]
           * @return [type]            [description]
           */
          function template_js($filename) {
            $file = THEME_JS . $filename;
            return load_asset($file);
          } // template_js()


          /**
           * [template_js description]
           * @param  [type]  $filename [description]
           * @param  boolean $echo     [description]
           * @return [type]            [description]
           */
          function template_css($filename) {
            $file = THEME_CSS . $filename;
            return load_asset($file);
          } // template_css()


          /**
           * [template_less description]
           * @param  [type]  $filename [description]
           * @param  boolean $echo     [description]
           * @return [type]            [description]
           */
          function template_less($filename) {
            $file = THEME_LESS . $filename;
            return load_asset($file);
          } // template_less()


          /**
           * [template_img description]
           * @param  [type]  $filename [description]
           * @param  boolean $echo     [description]
           * @return [type]            [description]
           */
          function template_img($filename) {
            $file = THEME_IMG . $filename;
            return load_asset($file);
          } // template_js()



          /**
           * [plugin_svg description]
           * @param  [type]  $filename [description]
           * @param  boolean $echo     [description]
           * @return [type]            [description]
           */
          function template_svg($filename) {
            $file = __DIR__ . '/../' . THEME_IMG . $filename;
            $content = file_get_contents($file);
            return $content;
          }


  /**
   * [main_nav description]
   * @param  [type] $settings [description]
   * @return [type]           [description]
   */
  function main_nav($settings = []) {
    global $page_data, $page, $requestURL;

    // Determine the active page

    // Define default settings
    $default_settings = [
        //   'sitename'  => SITE_NAME
        // , 'page_name' => false
        // , 'return'    => false
    ];

    // Merge our array with the updated values passed via $settings[]
    $settings = array_merge($default_settings, $settings);


    // Collect menu data
    $data = file_get_contents(SYSTEM_CONFIG_JSON);
    $data = json_decode($data);


    // Generate our links
    $content = $class = "";

    foreach ($data->main_navigation as $link => $value) {

      // Determine the active page link and give it an active class
      if (preg_match("/$value/", $requestURL[1])) {
        $class = "class=\"active\"";
      } else {
        $class = "";
      }

      $title_text = preg_replace('/[-_]/', ' ', $value);

      $content .= "<li $class><a href=\"/$value\">$title_text</a></li>\r\n";
    }


    // Concatenate markup into main-nav block
    $output =   "<nav class=\"main-nav\" role=\"navigation\">"
            .     "<ul>"
            .       $content
            .     "</ul>"
            .   "</nav>"
            ;

    echo $output;

  } // main_nav()



  /**
   * Helper function that aliases the global $markdown object to transform the page
   * content and echoes out to the view
   * @param  boolean    $echo   Boolean that determines if the function should echo or return the transformed markdown data
   * @return string             Conditionally returns the transformed markdown data
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
