<?php
namespace Passerelle\Karoleena\Classes;

class SubSection extends Base {
	public $parent_id;
	public $fields;

	public function __construct($parent_id = false, $fields = []) {
		$this->parent_id = $parent_id;
		$this->fields = $fields;
	}
}
