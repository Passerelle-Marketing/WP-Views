<?php

namespace DaveJToews\WPViews;

class Error404 extends View {

    public $query;

    public function __construct(\WP_Query $query) {
        $this->query = $query;
    } 

	protected function get_title() {
		return 'Error 404';
	}
}
