<?php
namespace DaveJToews\WPViews;

class SubSection extends Base {
	public $parent_id;
	public $fields;
	public $field_prefix;

	public function __construct(int $parent_id = false, array $fields = [], string $field_prefix = '') {
		$this->parent_id = $parent_id;
		$this->fields = $fields;
		$this->field_prefix = $field_prefix;
	}

	protected function get_field(string $field, int $id = null) {
		return get_field($this->field_prefix . $field, $id);
	}
}
