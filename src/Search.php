<?php

namespace Passerelle\WPViews;

class Search extends View {

	public $search;

	public function __construct(\WP_Query $query) {
		$this->search = $query->query['s'];
	}

	protected function get_title() {
		return sprintf(__('Search Results for %s', 'wp-views'), get_search_query());
	}

	protected function get_set_articles($args, $object) {
		global $wp_query;

		return array_map(function($post) use ($object) {
			$namespace = null;
			if ($object) {
				$namespace = self::get_namespace($object);
			}
			return PostFactory::create($post, $namespace);
		}, $wp_query->posts);
	}
}
