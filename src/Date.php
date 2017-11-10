<?php

namespace DaveJToews\WPViews;

class Date extends View {

  public $year;
  public $month;
  public $day;

  public function __construct(\WP_Query $query) {
    if (isset($query->query['year'])) {
      $this->year = $query->query['year'];
    }
    if (isset($query->query['monthnum'])) {
      $this->month = $query->query['monthnum'];
    }
    if (isset($query->query['day'])) {
      $this->day = $query->query['day'];
    }
  }

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
