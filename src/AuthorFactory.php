<?php

namespace DaveJToews\WPViews;

class AuthorFactory extends Factory {

	public static function create(\WP_User $user, $namespace = null) {
		$view_class = self::get_namespaced_classname('Author', $namespace);
		return new $view_class($user);
	}

}
