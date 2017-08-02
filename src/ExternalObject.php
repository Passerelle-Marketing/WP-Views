<?php 

namespace DaveJToews\WPViews;

class ExternalObject {
  public $wp_views_object;

  function __construct() {
    $args = func_get_args();
    $this->wp_views_object = $this->get_mirrored_object($args);
    $this->populate_props();
  }

  function __call($method, $args) {
    if(method_exists($this, $method)) {
      return $this->$method(...$args);
    } else {

      $new_args = $this->get_method_args_with_object($method, $args);
      return $this->wp_views_object->$method(...$new_args);
    }
  }

  private function get_method_args_with_object($method, $args) {
    $class = get_class($this->wp_views_object);
    $r_method = new \ReflectionMethod($class, $method);
    $params = $r_method->getParameters();

    $param_count = count($params);
    $args_count = count($args);

    $count = ( $param_count >= $args_count ) ? $param_count : $args_count;
    $new_args = [];
    for ( $i = 0; $i < $count; $i++) {
      if (isset($args[$i])) {
        array_push($new_args, $args[$i]);
      } else {
        if ($params[$i]->name === 'args') {
          array_push($new_args, []);
        } elseif ($params[$i]->name === 'object') {
          array_push($new_args, $this);
        } else {
          throw new \Exception("Improper arguments provided to WPViews object method.");
        }

      }
    }
    return $new_args;
  }

  private function populate_props() {
    $props = get_object_vars($this->wp_views_object);

    foreach ($props as $key => $value) {
      $this->$key = $value;
    }
  }

  private function get_mirrored_object($args) {

    $class_tree = $this->get_class_tree();

    foreach($class_tree as $classname) {
      $mirrored_class = $this->get_mirrored_class($classname);
      if (class_exists($mirrored_class)) {
        return new $mirrored_class(...$args);
      }
    }

    return new \stdClass();

  }

  private function get_class_tree() {
    $class_parents = class_parents($this);

    $class_tree = [get_class($this)];

    foreach ($class_parents as $parent)  {
      array_push($class_tree, $parent);
    }

    return $class_tree;
  }

  private static function get_mirrored_class($classname) {
    $reflect = new \ReflectionClass($classname);
    $classname = $reflect->getShortName();
    return '\\DaveJToews\\WPViews\\' . $classname;
  }
}


