<?php

namespace Passerelle\WPViews;

class Archive extends View {

  public $type;
  public $page;
  public $title;

  public function __construct(\WP_Post_Type $queried) {
    $this->type = $queried->name;
    $this->title = $queried->labels->name;
    $this->page = (get_query_var('paged')) ? get_query_var('paged') : 1;
  }

  protected function get_title() {
    return $this->title;
  }

  protected function get_set_articles($args, $object) {
    $wp_query = new \WP_Query([
      'post_type' => $this->type,
      'posts_per_page' => -1
    ]);

    return array_map(function($post) use ($object) {
      $namespace = null;
      if ($object) {
        $namespace = self::get_namespace($object);
      }
      return PostFactory::create($post, $namespace);
    }, $wp_query->posts);
  }

  protected function get_set_taxonomies($args, $object) {
    return array_map(function($taxonomy) use ($object) {
      $namespace = null;
      if ($object) {
        $namespace = self::get_namespace($object);
      }
      return TaxonomyFactory::create($taxonomy, $namespace);
    }, get_object_taxonomies($this->type, 'objects'));
  }

  protected function get_url() {
    return get_post_type_archive_link($this->type);
  }
}
