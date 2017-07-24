<?php

namespace DaveJToews\WPViews\Classes;

class PostPage extends Post {

	protected function get_parent() {
		$parent_id = wp_get_post_parent_id( $this->id );

		if($parent_id) {
			$parent_query = get_post($parent_id);
			return PostFactory::create($parent_query);
		}
		
		return false;
	}

}
