<?php

namespace DaveJToews\WPViews\Classes;

class BaseFactory {

  protected function get_namespaced_classname($namespace, $classname) {
    if ($namespace && class_exists($namespace . '\\' . $classname)) {
      return '\\' . $namespace . '\\' . $classname;
    } else {
      return __NAMESPACE__ . '\\' . $classname;
    }
  }

}
