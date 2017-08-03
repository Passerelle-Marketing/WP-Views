<?php

namespace DaveJToews\WPViews;

class Date extends Base {
	protected function get_title() {
		return get_the_archive_title();
	}

  protected function get_set_articles($args, $object) {
    global $wp_query;

    return array_map(function($post) use ($object) {
      $namespace = null;
      if ($object) {
        $namespace = self::get_namespace($object);
      }
      return PostFactory::create($post, $namespace);
    }, $wp_query->posts);
  }

}
