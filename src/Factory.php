<?php

namespace DaveJToews\WPViews;

class Factory {

  protected static function get_namespaced_classname($classname, $namespace) {
    if ($namespace && class_exists($namespace . '\\' . $classname)) {
      return '\\' . $namespace . '\\' . $classname;
    } else {
      return __NAMESPACE__ . '\\' . $classname;
    }
  }

}
