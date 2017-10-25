<?php

namespace DaveJToews\WPViews;

class TermFactory extends Factory {

    public static function create(\WP_Term $post, $namespace = null) {
        $view_class = self::get_namespaced_classname('Term', $namespace);
        return new $view_class($user);
    }

}
