<?php

namespace DaveJToews\WPViews;

class Error404 extends Base {
	protected function get_title() {
		return get_the_archive_title();
	}
}
