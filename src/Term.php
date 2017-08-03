<?php

namespace DaveJToews\WPViews;
class Term extends Base {

  public $name;

  public function __construct(\WP_Term $queried) {
    $this->name = $queried->name;
  }

  public function get_title() {
    return $this->name;
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
