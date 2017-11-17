<?php

namespace DaveJToews\WPViews;

class State extends Base {

    protected function get_body() {
        global $page, $post;

        $content = $post->post_content;

        if (Helpers\is_body_paginated($content)) {
            $pages = Helpers\get_body_pages($content);
            $page = ($page) ? $page : 1;
            $body = $pages[$page - 1];
        } else {
            $body = $content;
        }

        if ($body) {
            return apply_filters('the_content', $body);
        }
        return '';
    }

    protected function get_body_pagination() {
        global $post, $page, $numpages, $multipage;

        $content = $post->post_content;

        if (Helpers\is_body_paginated($content)) {
            $pages = Helpers\get_body_pages($content);
            $multipage = true;
            $page = ($page) ? $page : 1;
            $body = $pages[$page - 1];
            $numpages = count($pages);
        }

        return wp_link_pages(['echo' => false]);
    }

    protected function get_post_navigation() {
        return get_the_post_navigation();
    }

    protected function get_archive_navigation() {
        return get_the_posts_navigation();
    }

    protected function get_archive_pagination() {
        return get_the_posts_pagination();
    }
}
