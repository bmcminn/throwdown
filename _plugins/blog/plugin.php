<?php

  /**
   * Throwdown Blog
   * @author Brandtley McMinn <labs@giggleboxstudios.net>
   */

  namespace Throwdown\Plugins;

  class Blog {

    private static $_props = [];



    public static function set($prop=null, $value=null) {
      $argv = func_get_args();
      $argc = func_num_args();

      switch ($argc) {
        case 1:
          if (is_array($argv[0])) {
            self::$_props = array_replace_recursive(self::$_props, $prop);

          } elseif (is_string($argv[0])) {
            throw new \InvalidArgumentException('set(): requires a second argument to assign value to `' . $prop . '`');

          } else {
            throw new \InvalidArgumentException('set(): the first argument must be an array');

          }
          break;

        case 2:
          if ($argv[1]) {
            self::$_props[$prop] = $value;

          } else {
            throw new \InvalidArgumentException('set(): second argument');

          }
          break;

        default:
          throw new \InvalidArgumentException('set(): requires at least one argument');
          break;
      }

    }

    public static function get($prop=null) {

      if ($prop) {
        return self::$_props[$prop] ? self::$_props[$prop] : 'no property found';

      } else {
        return self::$_props;

      }
    }



  }