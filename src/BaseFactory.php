<?php

namespace DaveJToews\WPViews;

class BaseFactory {

  protected function get_namespaced_classname($namespace, $classname) {
    if ($namespace && class_exists($namespace . '\\' . $classname)) {
      return '\\' . $namespace . '\\' . $classname;
    } else {
      return __NAMESPACE__ . '\\' . $classname;
    }
  }

}
