<?php

  // Load plugin
  require __DIR__ . DS . "plugin.php";

  use Throwdown\Plugins\Blog as Blog;


  // blog root
  map('/blog', function() {
    echo "blog index";

  });


  // blog post
  map('/blog/{post}', function($args) {
    echo "blog post $args[post]";
  });


  // blog archive
  map('/blog/archive', function() {
    echo "blog archive root";
  });


  // blog archive paging
  map('/blog/archive/page/{page}', function($args) {
    echo "blog archive page $args";
  });
