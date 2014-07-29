<?php

  ini_set('error_reporting', E_ALL);

  define("ROOT_DIR",      __DIR__);
  define("APP_DIR",       __DIR__.'/app');
  define("ERROR_DIR",     __DIR__.'/error_logs');
  define("PUBLIC_DIR",    __DIR__.'/public');
  define("MODELS_DIR",    __DIR__.'/public/models');
  define("IMAGES_DIR",    __DIR__.'/public/images');
  define("LANG_DIR",      __DIR__.'/public/i18n');
  define("LOCALE_DIR",    __DIR__.'/public/l20n');
  define("TEMPLATES_DIR", __DIR__.'/public/templates');


  require "vendor/autoload.php";


  //
  // COMPILE MODEL
  //

  use Throwdown\Throwdown as Throwdown;

  $throwdown = new Throwdown();

  $throwdown->init_model(MODELS_DIR);
  $throwdown->get_lang(LANG_DIR, $throwdown->model['config']['siteLang']);

  $model = $throwdown->get_model();



  //
  // CONFIGURE DISPATCH
  //

  config([
    'dispatch.url'                => $model['config']['siteURL']
  , 'dispatch.imageUrl'           => IMAGES_DIR
  , 'dispatch.extras.debug_log'   => ERROR_DIR . '/dispatch_debug.txt'
  ]);



  //
  // CONFIGURE THROWDOWN
  //

  config([
    'throwdown.timezone'          => $throwdown->model['config']['timezone']
  ]);



  //
  // CONFIGURE HANDLEBARS
  //

  config([
    'handlebars.views'            => TEMPLATES_DIR
  , 'handlebars.layout'           => 'layout'
  , 'handlebars.partial_prefix'   => '_'
  , 'handlebars.cache'            => new Handlebars\Cache\Disk(TEMPLATES_DIR . '/cache/disk')
  , 'handlebars.minify'           => $model['config']['compress']
  ]);



  //
  // EXTEND HANDLEBARS
  //

  config([
    'handlebars.helpers' => [
      'image'   => 'handlebars_image'
    , 'public'  => 'handlebars_public'
    , 'lang'    => 'handlebars_lang'
    ]
  ]);


  function handlebars_image($template, $context, $args, $source) {
    return config('dispatch.url').'/public/images/'.$context->get($args);
  }

  function handlebars_public($template, $context, $args, $source) {
    return config('dispatch.url')."/public/".$args;
  }

  function handlebars_lang($template, $context, $args, $source) {
    global $model;
    return $context->get($args)[$model['config']['siteLang']];
  }



  //
  // GET HANDLEBARS TEMPLATES
  //

  if ($model['config']['compress']) {
    $model['templates'] = handlebars_templates();
  }



  //
  // ROUTES
  //

  // index page
  on('GET', '/', function () {
      global $model, $throwdown;

      $pageName = 'homepage';

      handlebars($pageName, $model);
      $throwdown->dumpJSON($model, $pageName);
    });




  // $throwdown->dumpJSON($model);




  dispatch();


