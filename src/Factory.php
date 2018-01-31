<?php

namespace Passerelle\WPViews;

class Factory {

    protected static function get_namespaced_classname($classname, $namespace) {
        if ($namespace && class_exists($namespace . '\\' . $classname)) {
            return '\\' . $namespace . '\\' . $classname;
        } elseif ( class_exists(__NAMESPACE__ . '\\' . $classname)) {
            return __NAMESPACE__ . '\\' . $classname;
        } else {
            $or_in_namespace = ($namespace) ? "or in $namespace" : '';
            $this_namespce = __NAMESPACE__;
            throw new \Exception("Class $classname not found in $this_namespce $or_in_namespace");
        }
    }
    
    protected static function get_label_string($slug) {
        $word_array = preg_split( "/[^a-zA-Z\d\s:]/", $slug );

        $cap_array = array_map(function($word) {
            return ucfirst($word);
        }, $word_array);
        return implode('', $cap_array);
    }
}
