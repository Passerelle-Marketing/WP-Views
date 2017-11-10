<?php

namespace DaveJToews\WPViews;

class TermFactory extends Factory {

    public static function create(\WP_Term $term, $namespace = null) {
        $taxonomy = self::get_label_string($term->taxonomy);
        $view_class = self::get_namespaced_classname('Term' . $taxonomy, $namespace);
        return new $view_class($term);
    }

}
