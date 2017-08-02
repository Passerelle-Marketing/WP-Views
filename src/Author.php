<?php

namespace DaveJToews\WPViews;

class Author extends Base {

	public $id;

  	public function __construct(\WP_User $user) {
  		$this->id = $user->ID;
    }

    protected function get_name() {
      return get_the_author_meta('display_name', $this->id);
    }

    protected function get_title() {
    	return $this->get_name();
    }

    protected function get_url() {
      return get_author_posts_url($this->id);
    }

}
