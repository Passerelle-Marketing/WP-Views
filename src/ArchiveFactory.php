<?php

namespace DaveJToews\WPViews;

class ArchiveFactory extends Factory {

    public static function create(\WP_Post_Type $archive, $namespace = null) {
        $view_class = self::get_view_class($archive, $namespace);
        return new $view_class($archive);
    }

    private static function get_view_class(\WP_Post_Type $archive, $namespace) {
        $type_label = ($archive->name === 'post') ? 'Blog' : self::get_label_string($archive->name);
        $archive_string = "Archive" . $type_label;

        return self::get_namespaced_classname($archive_string, $namespace);
    }

}
