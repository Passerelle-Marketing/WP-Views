<?php

namespace DaveJToews\WPViews;
class Term extends Base {

  public $name;
  public $id;

  public function __construct(\WP_Term $term) {
    $this->name = $term->name;
    $this->id = $term->term_id;
  }

  public function get_title() {
    return $this->name;
  }

  public function get_url() {
    return get_term_link($this->id);
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

  protected function get_field($field, $id) {
    return get_field($field, 'term_' . $id);
  }
}
