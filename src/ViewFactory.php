<?php

namespace DaveJToews\WPViews;

class ViewFactory extends Factory {

  public static function create($namespace = null) {

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
          return ArchiveFactory::create($queried_object, $namespace);
        case 'WP_Term' :
          return TermFactory::create($queried_object, $namespace);
        case 'WP_User' :
          return AuthorFactory::create($queried_object, $namespace);
        default :
          return false;
      }
    }

    if (is_search()) {
      $view_class = self::get_namespaced_classname('Search', $namespace);
      return new $view_class;
    }

    if (is_404()) {
      $view_class = self::get_namespaced_classname('Error404', $namespace);
      return new $view_class;
    }

    if (is_date()) {
      $view_class = self::get_namespaced_classname('Date', $namespace);
      return new $view_class;
    }

    return false;

  }

}
