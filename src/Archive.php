<?php

namespace DaveJToews\WPViews\Classes;

class Archive extends Base {

  public $type;
  public $page;

  public function __construct($queried) {
    $this->type = $queried->name;
    $this->page = (get_query_var('paged')) ? get_query_var('paged') : 1;
  }

  protected function get_feed() {
    return new ArchiveFeed();
  }
}

class ArchiveFeed extends Subsection {

  protected function get_set_articles() {
    global $wp_query;

    return array_map(array('DaveJToews\WPViews\Classes\PostFactory', 'create'), $wp_query->posts);
  }

}
