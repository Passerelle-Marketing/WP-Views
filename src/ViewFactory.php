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
      return new Search();
    }

    if (is_404()) {
      return new Error404();
    }

    if (is_date()) {
      return new Date();
    }

    return false;

  }

}
