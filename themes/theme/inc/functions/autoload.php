<?php

namespace theme;

class WP_autoload {

    public static function run() {
	    session_start();
	    spl_autoload_register(array(__CLASS__, 'classes'));
    }

    public static function classes($class) {
        $class = explode('\\', $class);
        if($class[0] === 'theme') {
	        array_shift($class);
        	include get_template_directory() . '/inc/functions/' . implode('/', $class) . '.class.php';
        }
    }

}