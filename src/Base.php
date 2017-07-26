<?php

namespace DaveJToews\WPViews;

Use DaveJToews\WPViews\Helpers;

class Base {
	public function get($field, $object = null) {
		$method_name = "get_$field";

		if ($object && method_exists($object, $method_name)) {
			return $object->$method_name();
		}

		return $this->$method_name();
	}

	public function has($field, $object = null) {
		$method_name = "has_$field";

		if ($object && method_exists($object, $method_name)) {
			return $object->$method_name();
		} elseif (method_exists($this, $method_name)) {
			return $this->$method_name();
		}

		return false;
	}

	public function put($field, $object = null) {
		$output = $this->get($field, $object);

		if (Helpers\can_be_string($output)) {
			echo $this->get($field, $object);
		} else {
			echo "<pre>Cannot put $field, use get instead.</pre>";
		}
	}

	public function get_image( $field, $args = [], $object = null ) {
		$method_name = "get_image_$field";
		$sizes = (!empty($args['sizes'])) ? $args['sizes'] : '';
		$class = (!empty($args['class'])) ? $args['class'] : '';
		$wp_size = (!empty($args['wp_size'])) ? $args['wp_size'] : '';

		if ($object && method_exists($object, $method_name)) {
			return $object->$method_name(
				array(
					'sizes'	=> $sizes,
					'class' => $class,
					'wp_size' => $wp_size
				)
			);
		}		

		return $this->$method_name(
			array(
				'sizes'	=> $sizes,
				'class' => $class,
				'wp_size' => $wp_size
			)
		);
	}

	public function put_image($field, $args ) {
		echo $this->get_image($field, $args);
	}

	public function get_set($field, $args = []) {
		$method_name = "get_set_$field";
	    $array = $this->$method_name($args);
	    if ($array) {
	      return array_filter($array);
	    }
		return array();
	}

	protected static function get_image_markup($id, $args) {
		$sizes = $args['sizes'];
		$class = $args['class'];
		$wp_size = $args['wp_size'];

		$output = '<img ';
		$output .= 'srcset="' . wp_get_attachment_image_srcset($id, $wp_size) . '" ';
		$output .= 'src="' . wp_get_attachment_image_url($id, $wp_size) . '" ';
		$output .= 'sizes="' . $sizes . '" ';
		$output .= 'class="' . $class . '" ';
		$output .= 'alt="' . get_post_meta($id, '_wp_attachment_image_alt', true) . '" ';
		$output .= '/>';
		return $output;
	}

	protected static function get_subsections_from_acf_repeater($field, $view_id, $class_name) {
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
