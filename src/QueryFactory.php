<?php

namespace DaveJToews\WPViews;

class QueryFactory extends Factory {

    public static function create(\WP_Query $query, $namespace = null) {
        
        $classname = '';

        if ($query->is_search) {
            $classname = 'Search';
        } elseif ($query->is_date) {
            $classname = 'Date';
        } elseif ($query->is_404) {
            $classname = 'Error404';
        } else {
            return false;
        }

        $view_class = self::get_namespaced_classname($classname, $namespace);

        return new $view_class($query);
    }

}
