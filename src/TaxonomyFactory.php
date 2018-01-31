<?php

namespace Passerelle\WPViews;

class TaxonomyFactory extends Factory {

    public static function create(\WP_Taxonomy $taxonomy, $namespace = null) {
        $view_class = self::get_namespaced_classname('Taxonomy', $namespace);
        return new $view_class($taxonomy);
    }

}
