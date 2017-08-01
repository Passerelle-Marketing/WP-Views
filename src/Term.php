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

}
