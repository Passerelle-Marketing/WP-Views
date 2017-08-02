<?php

namespace DaveJToews\WPViews;

class Search extends Base {

	protected function get_title() {
		return sprintf(__('Search Results for %s', 'wp-views'), get_search_query());
	}
}
