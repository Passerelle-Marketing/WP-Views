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

    protected static function get_label_string($slug) {
        $word_array = preg_split( "/[^a-zA-Z\d\s:]/", $slug );

        $cap_array = array_map(function($word) {
            return ucfirst($word);
        }, $word_array);
        return implode('', $cap_array);
    }
}
