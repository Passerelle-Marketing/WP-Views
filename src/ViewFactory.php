<?php

namespace DaveJToews\WPViews;

class ViewFactory extends Factory {

  public static function create(string $namespace = null) {

    if (is_home()) {
      $queried_object = get_post_type_object('post');
    } else {
      $queried_object = get_queried_object();
    }

    if ($queried_object) {
      switch (get_class($queried_object)) {
        case 'WP_Post' :
          return PostFactory::create($queried_object, $namespace);
        case 'WP_Post_Type' :
          $archive_class = self::get_namespaced_classname('Archive', $namespace);
          return new $archive_class($queried_object);
        case 'WP_Term' :
          $term_class = self::get_namespaced_classname('Term', $namespace);
          return new $term_class($queried_object);
        case 'WP_User' :
          $author_class = self::get_namespaced_classname('Author', $namespace);
          return new $author_class($queried_object);
        default :
          return false;
      }
    }

    if (is_search()) {
      return new Search();
    }

    if (is_404()) {
      return new Error404();
    }

    return false;

  }

}
