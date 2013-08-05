<?php

  load_plugin('works');





  // PAGE CONTENT
  // echo Markdown($page_data->fetch('content'));


//===========================================================================





//===========================================================================

  page_header();





  echo Markdown($page_data->fetch('content'));



  // Override default scripts object
  $footer_scripts = [
    '//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js'
  , template_js('funslider.js')
  ];



  // TEMPLATE FOOTER
  page_footer();
