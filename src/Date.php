<?php

namespace DaveJToews\WPViews;

class Date extends Base {
	protected function get_title() {
		return get_the_archive_title();
	}
}
