<?php

namespace DaveJToews\WPViews;

class Archive extends View {

  public $type;
  public $page;
  public $title;

  public function __construct(WP_Post_Type $queried) {
    $this->type = $queried->name;
    $this->title = $queried->labels->name;
    $this->page = (get_query_var('paged')) ? get_query_var('paged') : 1;
  }

  protected function get_title() {
    return $this->title;
  }

  protected function get_set_articles() {
    global $wp_query;

    return array_map(array('DaveJToews\WPViews\PostFactory', 'create'), $wp_query->posts);
  }
}
