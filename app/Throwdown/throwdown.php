<?php

  namespace Throwdown;


  class Throwdown {

    //
    // Fields
    //

    var $model = [];


    //
    // Constructor
    //

    function __construct() {

    }



    //
    // Methods
    //

    /**
     * [model description]
     * @param  [type] $path [description]
     * @return [type]       [description]
     */
    public function init_model($path) {

      $configJSON = ROOT_DIR.'/config.json';

      if (!file_exists($configJSON)) {
        die("File does not exist: " . $configJSON);
      }

      $files = array_merge([$configJSON], glob($path.'/*.json'));

      foreach($files as $index => $filePath) {
        $fileModel    = json_decode(json_minify(file_get_contents($filePath)), 1);
        $this->model  = array_merge_recursive($this->model, $fileModel);
      }


      // purge some data from the model
      $purgeList = [
        'grunt-ftp',
        'configRemote'
      ];

      foreach ($purgeList as $index => $purge) {
        unset($this->model[$purge]);
      }

      return $this->model;
    }


    /**
     * [update_model description]
     * @param  [type] $newModelData [description]
     * @return [type]               [description]
     */
    public function update_model($newModelData) {
      return $this->model = array_merge_recursive($this->model, $newModelData);
    }



    /**
     * [get_lang description]
     * @param  [type] $path        [description]
     * @param  [type] $defaultLant [description]
     * @return [type]              [description]
     */
    function get_lang($langLoc, $defaultLang) {

      $langFile = strtolower($defaultLang);
      $langTemp = filter_input(INPUT_SERVER, 'HTTP_ACCEPT_LANGUAGE', FILTER_SANITIZE_STRING);

      // TODO: add cookie/cache lookup for existing language preference to avoid looking up filesystem each page load
      // if ($langTemp && !cookie()) {

      if ($langTemp) {
        $browserLangArray = explode(',', strtolower($langTemp));

        foreach ($browserLangArray as $index => $lang) {
          $lang = preg_replace('/;.+/', '', $lang);

          if (file_exists("$langLoc/$lang.json")) {
            $langFile = $lang;
            break;
          }
        }
      }

      $langModel = $this->getJSON("$langLoc/$langFile.json");

      if (!$langModel) {
        $this->fault("error processing file $lang.json");
      }

      $this->model['labels'] = $langModel;

      return $this;
    }


    /**
     * [get_model description]
     * @return [type] [description]
     */
    public function get_model() {
      return $this->model;
    }



    /**
     * @param   $fileLoc    String of the file location where the JSON file is located
     * @return  $fileData   JSON decoded fileData ready for consumption by PHP
     */
    public function getJSON($fileLoc) {
      if (!file_exists($fileLoc)) {
        fault("Can't find '$fileLoc'...");
      }
      return json_decode(json_minify(file_get_contents($fileLoc)), 1);
    }


    /**
     * [putJSON description]
     * @param  [type] $fileLoc [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     */
    public function putJSON($fileLoc, $data) {
      return file_put_contents($fileLoc, json_encode($data));
    }


    /**
     * [dumpJSON description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function dumpJSON($modelData, $name="model") {
      $modelData = json_encode($modelData);
      echo "<script>window.$name=$modelData</script>";
      echo "<script>console.log('$name:', $modelData);</script>";
    }



    /**
     * [fault description]
     * @param  [type] $message [description]
     * @return [type]          [description]
     */
    public function fault($message) {
      trigger_error($message, E_USER_NOTICE);
      exit;
    }


  }
