<?php

namespace Passerelle\Karoleena\Classes;
class Term extends Base {

  public $name;

  public function __construct($queried) {
    $this->name = $queried->name;
  }

  public function get_title() {
    return $this->name;
  }

}
