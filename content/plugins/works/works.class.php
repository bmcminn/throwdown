<?php

  global $requestURL;

  define("DIR_PROJECTS",  __DIR__ . '/../../../projects/');

  $project_name         = '';
  $project_meta_file    = 'project.meta';
  $project_contents     = [];
  $current_project_dir  = '';


  // Get resource directory to load slideshows from
  if (isset($requestURL[2])) {

    $project_name         = $requestURL[2];
    $current_project_dir  = DIR_PROJECTS . $project_name;


    if (!is_dir($current_project_dir)) {
      page_404();

    } else {
      $project_contents = glob($current_project_dir . '/' . $project_meta_file);

    }

  }


  /**
   * [works_get_project description]
   * @param  [type] $dir_name [description]
   * @return [type]           [description]
   */
  function works_get_project($dir_name) {

    echo $dir_name;

  }







  /**
   * [works_generate_slideshow description]
   * @return [type] [description]
   */
  function works_generate_slideshow() {

    global  $requestURL
          , $project_name
          , $project_meta_file
          , $project_contents
          , $current_project_dir
          ;

    works_get_project($requestURL[2]);

    // print_r($current_project_dir);
  }