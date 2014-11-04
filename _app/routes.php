<?php


  map('/', function() {
    echo "homepage";
  });


  map('/blog', function() {
    echo "blog index";
  });


  map('/blog/{post}', function($args) {
    echo "blog post $args[post]";

  });


  map('/{page}', function($args) {
    echo $args['page'];
  });