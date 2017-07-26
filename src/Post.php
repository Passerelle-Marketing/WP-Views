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

	protected function get_parent() {
		$post_type = $this->get_post_type();
		$post_type_object = get_post_type_object($post_type);
		return new Archive($post_type_object);
	}

	protected function get_image_featured($args) {
		$imageId = get_post_thumbnail_id($this->id);
		if ($imageId) {
			return $this->get_image_markup($imageId, $args);
		} else {
			return false;
		}
	}

	protected function get_body() {
		return apply_filters('the_content', get_post_field('post_content', $this->id));
	}

	protected function get_excerpt() {
	    $the_post = get_post($this->id); //Gets post ID
	    $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
	    $excerpt_length = 20; //Sets excerpt length by word count
	    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
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
		return get_the_date('F j, Y', $this->id);
	}

	protected function get_post_type() {
		return get_post_type($this->id);
	}

	protected function get_post_type_name() {
		$post_type = get_post_type($this->id);
		$object = get_post_type_object( $post_type )->labels;

		return $object->name;
	}

}
