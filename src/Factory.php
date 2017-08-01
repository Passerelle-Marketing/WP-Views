<?php

namespace DaveJToews\WPViews;

class Factory {

  protected static function get_namespaced_classname(string $classname, string $namespace) {
    if ($namespace && class_exists($namespace . '\\' . $classname)) {
      return '\\' . $namespace . '\\' . $classname;
    } else {
      return __NAMESPACE__ . '\\' . $classname;
    }
  }

}
