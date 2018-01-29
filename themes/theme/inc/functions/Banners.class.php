<?php

namespace theme;

class Banners {

	const SINGLE_BANNER_POSITION    = 200;
	const SINGLE_BANNER_WORDS_COUNT = 5;
	const FLASHCARDS_POST           = 3;
    static private $i;

    static public function addToSingle(){
        add_filter('the_content',   array(__CLASS__, 'single_order_banner'));
    }

    static public function addToArchive() {
        add_filter('the_post',      array(__CLASS__, 'category_order_banner'));
    }

    static public function addToSearch() {
        add_filter('the_post',      array(__CLASS__, 'search_order_banner'));
    }

    static public function single_order_banner($content) {
	    if (is_single() && in_the_loop()) {

		    $isFlashcards = in_array(true, array_map(function($arr) {
			    return $arr->name === 'Flashcards';
		    }, get_the_category()));

		    $url = 'http://essays.businessays.net/order?utm_source=businessays.net&utm_campaign=sample_page&utm_medium=R&utm_term=hire_writer&utm_content=order';
		    if ($isFlashcards) {
			    $url = 'http://essays.businessays.net/order?utm_source=businessays.net&utm_campaign=flashcard&utm_medium=R&utm_term=proceed&utm_content=order';
		    }

		    $ctaTitle = !ClientCountry::checkBan() ? 'on <em>"' . get_the_title() . '"</em>' : '';
		    $banner = strtr(file_get_contents(__DIR__ . '/../parts/single/single-order.html'), [
				    '#text#'      => 'Need essay sample ' . $ctaTitle . '? We will write a custom essay sample specifically for you for only <b> &#36 13.90/page</b>',
				    '#url#'       => $url,
				    '#link_text#' => 'Hire Writer'
			    ]);

		    $contentArray = strip_tags($content, '<ul>');
		    $contentArray = explode(' ', $contentArray);
		    if (count($contentArray) > self::SINGLE_BANNER_POSITION) {
			    // Method in Helper
			    $searchedString = self::_getSearchedString($contentArray);
			    // Check if searched sting in <ul> tags or not

			    $checkUl = preg_match("~\<[^p]*\>.+({$searchedString}).+\<\/[^p]*\>~s", $content, $match);
			    if ($checkUl) { // in in <ul> tag
				    $content = preg_replace("~\<[^p]*\>.+({$searchedString}).+\<\/[^p]*\>~s", "$0" . $banner, $content);
			    } else { // If searched string not in <ul> tag
				    $searchedString = stripslashes($searchedString);
				    $newContent   = $searchedString . $banner;
				    $content      = str_replace($searchedString, $newContent, $content);
			    }
		    }
	    }

	    return $content;
    }

    static public function category_order_banner($post) {
        if(!in_the_loop() || !is_archive() || self::$i++ !== 2) return $post;
        do_action('category_order');
    }

    static public function search_order_banner($post) {
        if(!in_the_loop() || !is_search() || self::$i++ !== 2) return $post;
        do_action('search_order');
    }

	static private function stringInsert($str, $insertstr, $pos) {
	    $str = mb_substr($str, 0, $pos, 'UTF-8') . '...' . $insertstr . '...' . mb_substr($str, $pos, null, 'UTF-8');
	    return $str;
	}

	static private function afterCard($content, $banner, $pos) {
		$content = explode('<div class="business__row-flex">', $content);
		if (count($content > $pos)) $content[$pos] .= $banner;
		$content = implode('<div class="business__row-flex">', $content);

		return $content;
	}


	/**
	 * Method for get searched string for blog single
	 * @param $contentArray
	 * @return string
	 */
	static private function _getSearchedString($contentArray) {
		// Get array 195-200 item
		$contentArraySliced = array_slice($contentArray, Banners::SINGLE_BANNER_POSITION - Banners::SINGLE_BANNER_WORDS_COUNT, Banners::SINGLE_BANNER_WORDS_COUNT);
		// Find \r or \n in Array
		$breakInSearchedString = preg_grep("#\r|\n#", $contentArraySliced);

		// Loop for make little array to search if we have \r or \n in searched string
		$i = Banners::SINGLE_BANNER_WORDS_COUNT;
		while (!empty($breakInSearchedString)) {
			$i--;
			$contentArraySliced = array_slice($contentArray, Banners::SINGLE_BANNER_POSITION - $i, $i);
			$breakInSearchedString = preg_grep("#\r|\n#", $contentArraySliced);
		}

		// Get new array (200 - $i) - 200 item
		$searchedStringArray = array_slice($contentArray, Banners::SINGLE_BANNER_POSITION - $i, $i);
		// Make string from array
		$searchedString = implode(' ', $searchedStringArray);
		// AddSlashes to symbols
		$searchedString = quotemeta($searchedString);

		return $searchedString;
	}


}