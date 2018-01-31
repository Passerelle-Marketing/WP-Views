<?php

namespace Passerelle\WPViews;

class PostNavMenuItem extends Post {

	public $classes;
	public $title;

	public function __construct(\WP_Post $post) {
		$this->id = $post->ID;
		$this->classes = empty( $post->classes ) ? [] : $post->classes;
		$this->title = $post->title;
	}

	protected function get_classes() {
		return $this->classes;
	}

	protected function get_title() {
		return $this->title;
	}

}
