<?php

namespace theme;

class Core {

    static public function convertTitle($title) {
        return str_replace(array('[',']'), array('<span>','</span>'), $title);
    }

    static public function convertLevelTitle($title) {
        $title = explode(' ', $title);
        if(count($title) <= 1) return $title;
        foreach($title as $key => $value) $title[$key] = "<span>{$value}</span>";
        return implode('', $title);
    }

    static public function spannedPrice($price, $round = false, $mo = true) {
        if ($round == 'round') {
            $price = round($price, 1);
        }
        $price = explode('.', $price);
        if ($mo === false) {
            for($i = 0; $i < count($price); $i++) $price[$i] = "<span>{$price[$i]}</span>";
            return '<span>$</span>' . implode('.',$price);
        } else {
            for($i = 0; $i < count($price); $i++) $price[$i] = "<span>{$price[$i]}</span>";
            return '<span>$</span>' . implode('.',$price) . '<span>/mo</span>';
        }

    }

    static public function postsSearch() {
        add_filter('pre_get_posts', array(__CLASS__, 'set_filter'));
    }

    static public function set_filter($query) {
        if ($query->is_search) $query->set('post_type', 'post');
        return $query;
    }

    static public function addBlureToSingle() {
	    add_filter('the_content',   array(__CLASS__, 'add_blure_to_single'));
    }

	static public function add_blure_to_single($content) {
		if (!is_single() && in_the_loop()) return $content; // If is not single - function not work
		$content = explode('<p>', $content);
		if (count($content) >= 3) { // include html banner
			$content[4] = '<div class="single__content--blur">' . $content[4];
			$content[key($content)] .= '</div>';
		}
		$content = implode('<p>', $content);
		return $content;
	}

}