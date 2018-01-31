<?php

namespace Passerelle\WPViews;

class ViewFactory extends Factory {

  public static function create($namespace = null) {

    global $wp_query;

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

    return QueryFactory::create($wp_query, $namespace);

  }
}
