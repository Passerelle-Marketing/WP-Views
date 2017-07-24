<?php

namespace DaveJToews\WPViews\Classes;

Use DaveJToews\WPViews\Helpers;

class Base {
	public function get($field) {
		$function_name = "get_$field";

		return $this->$function_name();
	}

	public function has($field) {
		$function_name = "has_$field";
		if (method_exists($this, "has_$field")) {
			return $this->$function_name();
		}
		return false;
	}

	public function put($field) {
		$output = $this->get($field);
		if (Helpers\canBeString($output)) {
			echo $this->get($field);
		} else {
			echo "<pre>Cannot put $field, use get instead.</pre>";
		}
	}

	public function get_image($field, $sizes = '', $class = '', $wp_size = '' ) {
		$function_name = "get_image_$field";

		return $this->$function_name($sizes, $class, $wp_size);
	}

	public function put_image($field, $sizes = '', $class = '', $wp_size = '' ) {
		echo $this->get_image($field, $sizes, $class, $wp_size);
	}

	public function get_markup($field) {
		$function_name = "get_markup_$field";
		return $this->$function_name();
	}

	public function put_markup($field) {
		echo $this->get_markup($field);
	}

	public function get_set($field, $args = []) {
		$function_name = "get_set_$field";
	    $array = $this->$function_name($args);
	    if ($array) {
	      return array_filter($array);
	    }
		return array();
	}

	protected function get_image_markup($id, $sizes = '', $class = '', $wp_size = '') {
		$output = '<img ';
		$output .= 'srcset="' . wp_get_attachment_image_srcset($id, $wp_size) . '" ';
		$output .= 'src="' . wp_get_attachment_image_url($id, $wp_size) . '" ';
		$output .= 'sizes="' . $sizes . '" ';
		$output .= 'class="' . $class . '" ';
		$output .= 'alt="' . get_post_meta($id, '_wp_attachment_image_alt', true) . '" ';
		$output .= '/>';
		return $output;
	}

	public static function get_subsections_from_acf_repeater($field, $view_id, $class_name) {
	    $acf_array = get_field($field, $view_id);
	    if($acf_array) {
	      $sections = array_map(function($section) {
	        return new $class_name($view_id, $section);
	      }, $acf_array);
	      return $sections;
	    }
	    return array();
	}
}
