<?php

namespace DaveJToews\WPViews;

class Post extends View {

	public $id;

	public function __construct($post) {
		$this->id = $post->ID;
	}

	protected function get_slug() {
		return get_post_field( 'post_name', $this->id );
	}

	protected function get_title() {
		return get_the_title($this->id);
	}

	protected function get_template() {
		$slug = get_page_template_slug($this->id);
		$slug = preg_replace('/^template-/', '', $slug);
		$slug = preg_replace('/.php$/', '', $slug);
		return $slug;
	}

	protected function get_url() {
		return get_permalink($this->id);
	}

	protected function get_parent($args, $object ) {
		$post_type = $this->get_post_type();
		$post_type_object = get_post_type_object($post_type);

		$namespace = '';

		if ($object) {
			$namespace = self::get_namespace($object) . '\\';
		}

		$classname = $namespace . 'Archive';

		return new $classname($post_type_object);
	}

	protected function get_image_featured($args) {
		$imageId = get_post_thumbnail_id($this->id);
		if ($imageId) {
			return $this->get_image_markup($imageId, $args);
		} else {
			throw new \Exception('Post does not have featured image.');
		}
	}

	protected function get_body() {
		return apply_filters('the_content', get_post_field('post_content', $this->id));
	}

	protected function get_excerpt() {
	    $the_post = get_post($this->id);
	    $the_excerpt = $the_post->post_content;
	    $excerpt_length = apply_filters( 'excerpt_length', 55 );
	    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt));
	    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

	    if(count($words) > $excerpt_length) :
	        array_pop($words);
	        array_push($words, '…');
	        $the_excerpt = implode(' ', $words);
	    endif;

	    $the_excerpt = '<p class="excerpt">' . $the_excerpt . '</p>';

	    return $the_excerpt;
	}

	protected function get_date() {
		return get_the_date(null, $this->id);
	}

	protected function get_iso_date() {
		return get_the_date('c', $this->id);
	}

	protected function get_post_type() {
		return get_post_type($this->id);
	}

	protected function get_post_type_name() {
		$post_type = get_post_type($this->id);
		$object = get_post_type_object( $post_type )->labels;

		return $object->name;
	}

	protected function get_author() {
		return get_post_field( 'post_author', $this->id );
	}

}
