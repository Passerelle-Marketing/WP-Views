<?php

namespace DaveJToews\WPViews\Classes;
use DaveJToews\WPViews\Helpers;

class PostFactory extends BaseFactory {

	public static function create($post) {
		if ($post) {
			$view_class = self::get_view_class($post);
			return new $view_class($post);
		}
		return false;
	}

	private static function get_view_class($post) {
		$post_type = get_post_type($post);
		$type_label = ($post_type === 'post') ? 'Blog' : self::get_label_string($post_type);
		$template_label = self::get_template_label( $post->ID );
		$post_string = "Post" . $type_label . $template_label;

		return $this->get_namespaced_classname($namespace, $post_string);
	}

	private static function get_label_string($slug) {
		$word_array = preg_split( "/[^a-zA-Z\d\s:]/", $slug );

		$cap_array = array_map(function($word) {
			return ucfirst($word);
		}, $word_array);
		return implode('', $cap_array);
	}

	private static function get_template_label($post_id) {

		$template_slug = get_page_template_slug( $post_id );
		$template_string = Helpers\get_string_between($template_slug, "template-", ".php");
		$template_label = self::get_label_string($template_string);

		if ($post_id === intval(get_option( 'page_on_front' ))) {
			$template_label = "Front";
		}

		return $template_label;
	}
}
