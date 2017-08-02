<?php

namespace DaveJToews\WPViews;

class PostPage extends Post {

	protected function get_parent($args, $object) {
		$parent_id = wp_get_post_parent_id( $this->id );

		if($parent_id) {
			$parent_query = get_post($parent_id);

			$namespace = null;
			if ($object) {
				$namespace = self::get_namespace($object);
			}

			return PostFactory::create($parent_query, $namespace);
		}
		
		return false;
	}

}
