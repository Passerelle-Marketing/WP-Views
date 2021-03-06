<?php

namespace Passerelle\WPViews;

Use Passerelle\WPViews\Helpers;

class Base {
	public function get($field, ExternalObject $object = null) {
		$method_name = "get_$field";

		if ($object && method_exists($object, $method_name)) {
			return $object->$method_name();
		} elseif (method_exists($this, $method_name)) {
			return $this->$method_name();
		} else {
			$this_class = get_class($this);
			$or_in_object = ($object) ? 'or in ' . get_class($object) : '' ; 
			throw new \Exception("Method $method_name() not defined in $this_class $or_in_object");
		}
	}

	public function has($field, ExternalObject $object = null) {
		$method_name = "has_$field";

		if ($object && method_exists($object, $method_name)) {
			return $object->$method_name();
		} elseif (method_exists($this, $method_name)) {
			return $this->$method_name();
		}

		return false;
	}

	public function put($field, ExternalObject $object = null) {
		$output = $this->get($field, $object);

		if (Helpers\can_be_string($output)) {
			echo $this->get($field, $object);
		} else {
			throw new \Exception("Cannot put $field, use get instead.");
		}
	}

	public function get_with($field, array $args = [], ExternalObject $object = null ) {
		$method_name = "get_with_$field";

		if ($object && method_exists($object, $method_name)) {
			return $object->$method_name($args);
		} elseif (method_exists($this, $method_name)) {
			return $this->$method_name($args);
		} else {
			$this_class = get_class($this);
			$or_in_object = ($object) ? 'or in ' . get_class($object) : '' ; 
			throw new \Exception("Method $method_name() not defined in $this_class $or_in_object");
		}		
	}

	public function put_with($field, array $args = [], ExternalObject $object = null ) {
		echo $this->get_with($field, $args, $object);
	}

	public function get_image($field, array $args = [], ExternalObject $object = null ) {
		$method_name = "get_image_$field";
		$sizes = (!empty($args['sizes'])) ? $args['sizes'] : '';
		$class = (!empty($args['class'])) ? $args['class'] : '';
		$wp_size = (!empty($args['wp_size'])) ? $args['wp_size'] : '';
    	$inline_svg = (isset($args['inline_svg'])) ? $args['inline_svg'] : true;

		if ($object && method_exists($object, $method_name)) {
			return $object->$method_name(
				array(
					'sizes'	=> $sizes,
					'class' => $class,
					'wp_size' => $wp_size,
          			'inline_svg' => $inline_svg
				)
			);
		}

		return $this->$method_name(
			array(
				'sizes'	=> $sizes,
				'class' => $class,
				'wp_size' => $wp_size,
        		'inline_svg' => $inline_svg
			)
		);
	}

	public function put_image($field, array $args, ExternalObject $object = null ) {
		echo $this->get_image($field, $args, $object);
	}

	public function get_set($field, array $args = [], ExternalObject $object = null) {
		$method_name = "get_set_$field";

		if ($object && method_exists($object, $method_name)) {
			$array = $object->$method_name($args);
		} elseif (method_exists($this, $method_name)){
			$array = $this->$method_name($args, $object);
		} else {
			$this_class = get_class($this);
			$or_in_object = ($object) ? 'or in ' . get_class($object) : '' ; 
			throw new \Exception("Method $method_name() not defined in $this_class $or_in_object");
		}

	    if (is_array($array)) {
	      return $array;
	    }

		throw new \Exception("Set $field not found.");
	}

	public static function get_image_markup($id, array $args = []) {
		$sizes = (!empty($args['sizes'])) ? $args['sizes'] : '';
		$class = (!empty($args['class'])) ? $args['class'] : '';
		$wp_size = (!empty($args['wp_size'])) ? $args['wp_size'] : '';
	    $url = wp_get_attachment_image_url($id, $wp_size);
	    $info = new \SplFileInfo($url);

	    if (
	    	!empty($args['inline_svg']) && 
	    	$args['inline_svg'] && 
	    	$info->getExtension() === 'svg'
	    ) {
			$output = '<div ';
			$output .= 'class="inline-svg-wrapper ' . $class . '" >';
			$output .= file_get_contents(get_attached_file($id));
			$output .= '</div>';
			return $output;
	    }

		$output = '<img ';
		$output .= 'srcset="' . wp_get_attachment_image_srcset($id, $wp_size) . '" ';
		$output .= 'src="' . $url . '" ';
		$output .= 'sizes="' . $sizes . '" ';
		$output .= 'class="' . $class . '" ';
		$output .= 'alt="' . get_post_meta($id, '_wp_attachment_image_alt', true) . '" ';
		$output .= '/>';
		return $output;
	}

	public static function get_subsections_from_acf_repeater($field, $view_id, $class_name) {
	    $acf_array = get_field($field, $view_id);
	    if(is_array($acf_array)) {
	      $sections = array_map(function($section) use ($class_name, $view_id) {
	        return new $class_name($view_id, $section);
	      }, $acf_array);
	      return $sections;
	    }
	   return [];
	}

	protected static function get_namespace($object) {
		$class_name = get_class($object);
		$reflect = new \ReflectionClass($class_name);
		$short_name = $reflect->getShortName();

		return trim(str_replace($short_name, '', $class_name), '\\');
	}
}
