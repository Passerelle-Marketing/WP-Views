<?php

namespace DaveJToews\WPViews;

class Site extends Base {

	protected function get_home_url() {
		return get_home_url();
	}

	protected function get_current_url() {
		global $wp;
		return home_url(add_query_arg(array(),$wp->request));
	}
}
