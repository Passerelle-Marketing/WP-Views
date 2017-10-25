<?php

namespace DaveJToews\WPViews;

class ArchiveFactory extends Factory {

    public static function create(\WP_Post_Type $archive, $namespace = null) {
        $view_class = self::get_namespaced_classname('Archive', $namespace);
        return new $view_class($archive);
    }

}
