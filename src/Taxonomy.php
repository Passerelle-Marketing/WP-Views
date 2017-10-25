<?php

namespace DaveJToews\WPViews;
class Taxonomy extends Base {

  public $name;
  public $label;

  public function __construct(\WP_Taxonomy $taxonomy) {
    $this->name = $taxonomy->name;
    $this->label = $taxonomy->label;
  }

  public function get_title() {
    return $this->label;
  }

  protected function get_set_terms($args, $object) {
    $wp_terms = get_terms($this->name);

    return array_map(function($term) use ($object) {
      $namespace = null;
      if ($object) {
        $namespace = self::get_namespace($object);
      }
      return TermFactory::create($term, $object);
    }, $wp_terms);
  }

}
