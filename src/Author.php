<?php

namespace DaveJToews\WPViews;

class Author extends Base {

	public $id;

  	public function __construct(\WP_User $user) {
  		write_log($user);
    }

}
