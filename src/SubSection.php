<?php
namespace DaveJToews\WPViews\Classes;

class SubSection extends Base {
	public $parent_id;
	public $fields;
	public $field_prefix;

	public function __construct($parent_id = false, $fields = [], $field_prefix = '') {
		$this->parent_id = $parent_id;
		$this->fields = $fields;
		$this->field_prefix = $field_prefix;
	}
}
