<?php

namespace DaveJToews\WPViews;

class View extends Base {

  protected function get_parent($args, $object) {
    return false;
  }

  protected function get_ancestors() {
    $parent = $this->get_parent();
    $ancestors = [];
    if($parent) {
      $parent_ancestors = $parent->get_ancestors();
      if ($parent_ancestors) {
        $ancestors = array_merge($ancestors, $parent_ancestors);
      }
      array_push($ancestors, $parent);
      return $ancestors;
    }
    return array();
  }

}
