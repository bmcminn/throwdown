<?php

  global $requestURL;

  define("DIR_IMAGES_ABOUT",  ROOT_DIR . '/content/images/about/');


  /**
   * Returns an array of image file names and locations based on a given folder
   * @param  string $dir The directory you wish to pull images from
   * @return array       The array of images from the directory you requested
   */
  function get_images($dir, $sort = false) {
    $images = glob($dir . "*.{jpg,png,jpeg,gif}", GLOB_BRACE);

    if ($sort) {
      sort($images, SORT_STRING);
    }

    return $images;
  }




  /**
   * [about_past_works description]
   * @param  [type] $dir [description]
   * @return [type]      [description]
   */
  function about_past_works($dir = DIR_IMAGES_ABOUT) {

    global $requestURL;

    $images = get_images($dir);
    $string = '';

    foreach ($images as $image) {
      $string = preg_replace('/[\S]*\.\.(\S*)/i', '$1', $image);
      echo "<img class=\"about-related-project-image\" src=\"$string\">\r\n";
    }
  }


