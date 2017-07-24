<?php

namespace DaveJToews\WPViews\Classes;

class ViewFactory {

    public static function create() {

      if (is_home()) {
        $queried_object = get_post_type_object('post');
      } else {
        $queried_object = get_queried_object();
      }

      if ($queried_object) {
        switch (get_class($queried_object)) {
          case 'WP_Post' :
            return PostFactory::create($queried_object);
          case 'WP_Post_Type' :
            return new Archive($queried_object);
          case 'WP_Term' :
            return new Term($queried_object);
          case 'WP_User' :
            return new Author($queried_object);
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
