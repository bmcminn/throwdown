<?php

  // TEMPLATE HEADER
  page_header();


  // PAGE CONTENT
  echo Markdown($page_data->fetch('content'));


  // TEMPLATE FOOTER
  page_footer();
