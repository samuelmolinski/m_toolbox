<?php

	function catTagClasses() {

		$post_categories = getCatTagClasses();

		foreach ($post_categories as $c) {
			echo ' ' . $c;
		}
	}

	function getCatTagClasses() {
		global $post;
		$post_categories = wp_get_post_categories($post -> ID);
		$cats = array();

		foreach ($post_categories as $c) {
			$cat = get_category($c);
			array_push($cats, $cat -> slug);
		}
		return $cats;
	}

	function catTagNames() {
		global $post;
		$post_categories = wp_get_post_categories($post -> ID);
		$cats = array();

		if (is_array($post_categories)) {
			foreach ($post_categories as $c) {
				$cat = get_category($c);
				echo $cat -> name;
			}
		}
	}
	
	function get_catTagNames() {
		global $post;
		$post_categories = wp_get_post_categories($post -> ID);
		$cats = array();

		if (is_array($post_categories)) {
			foreach ($post_categories as $c) {
				$cat = get_category($c);
				echo $cat -> name;
			}
		}
	}
	
	function catCustomTagNames($taxonomy, $postID = NULL) {
		global $post;
		if (NULL == $postID) {
			$postID = $post -> ID;
		}
		//d($taxonomy);
		//d($postID);
		$post_categories = get_the_terms( $postID, $taxonomy);
		$cats = array();
		$count = 0;
		//d($post_categories);
		if (is_array($post_categories)) {
			foreach ($post_categories as $c) {
				if($count > 0) {echo ', ';}
				$cat = get_category($c);
				echo $cat -> name;
				$count ++;
			}
		}
	}

	function the_custom_excerpt($numOfChars, $removeNewLines = FALSE) {
		echo get_custom_excerpt($numOfChars, $removeNewLines);
	}
	
	function get_custom_excerpt($numOfChars, $removeNewLines = FALSE) {

		global $post;

		$text = get_the_content();
		// Remove custom code
		$text = preg_replace('#\[.*?\]#', '', $text);
		//$text = $text . " ";
		$text = strip_tags($text);
		//d($text);

		if ($removeNewLines) {
			$text = str_replace("\r\n", ' ', $text);
		}
		$text = trim($text);

		if (strlen($text) > $numOfChars) {
			$ellipsis = true;
		
			$text = substr($text, 0, $numOfChars);
			$text = substr($text, 0, strrpos($text, ' '));
		}

		if ($ellipsis == true)
			$text = $text . "...";

		return $text;
	}
	
	function the_custom_length( $text, $numOfChars, $removeNewLines = FALSE){
		echo get_custom_length( $text, $numOfChars, $removeNewLines);
	}
	
	function get_custom_length( $text, $numOfChars, $removeNewLines = FALSE) {

		if ($removeNewLines) {
			$text = str_replace("\r\n", ' ', $text);
		}
		
		if (strlen($text) > $numOfChars) {
			$ellipsis = true;
	
			$text = substr($text, 0, $numOfChars);
			$text = substr($text, 0, strrpos($text, ' '));
		}
	
		if ($ellipsis == true)
			$text = $text . "...";
	
		return $text;
	}
	
	function the_post_image_scr($post_id = NULL){
		echo get_post_image_src($post_id);
	}

	function get_post_image_src($post_id = NULL, $anyImage = TRUE) {
		
		if (NULL == $post_id) { global $post; $post_id = $post->ID;}
		//d(current_theme_supports('post-thumbnails'));
		//d(has_post_thumbnail());
		if (current_theme_supports('post-thumbnails') && has_post_thumbnail($post_id)) {
			$thumbURL = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), '');
			$imgSrc = $thumbURL[0];
			//d($thumbURL);
		} elseif ($anyImage) {
			$args = array(
				'order'          => 'DESC',
				'orderby'        => 'date',
				'post_type'      => 'attachment',
				'post_parent'    => $post_id,
				'post_mime_type' => 'image',
				'post_status'    => null,
				'numberposts'    => -1,
				);
				
			$attachments = get_posts($args);
			
		  	if ($attachments) {
				$imgSrc = wp_get_attachment_url($attachments[0]->ID, 'thumbnail', false);
			} 
		}
		
		//d($imgSrc);
		if (!$imgSrc) {return FALSE;}
		
		return $imgSrc;
	}

	function the_post_image($width = NULL, $height = NULL, $zc = NULL, $html = NULL) {
		
		global $post;
		
		if ($imgSrc = get_post_image_src()) {
			list($w, $h) = getimagesize($imgSrc);
		} else {
			return false;
		}
		$par = '';
		if ($width > 0) {$par .= '&amp;w=' . $width;} elseif (0 == $width) {} else {$par .= '&amp;w=' . CROP_WIDTH;}
		if ($height > 0) {$par .= '&amp;h=' . $height;} elseif (0 == $height) {} else {$par .= '&amp;h=' . CROP_HEIGHT;}
		//d($height);
		if ($zc) {$par .= '&amp;zc=' . $zc;} elseif (0 == $zc) {} else {$par .= '&amp;zc=' . CROP_ZC;} 

		the_crop_image($imgSrc, $par, 'post-img', get_the_title($post->ID), $html);
		return true;
		
	}
	function get_post_image($postID, $width = NULL, $height = NULL, $zc = NULL, $html = NULL, $anyImage = TRUE){
		//d($postID);
		if ($imgSrc = get_post_image_src($postID, $anyImage)) {
			list($w, $h) = getimagesize($imgSrc);
		} else {
			return false;
		}
		$par = '';
		if ($width > 0) {$par .= '&amp;w=' . $width;} elseif (0 == $width) {} else {$par .= '&amp;w=' . CROP_WIDTH;}
		if ($height > 0) {$par .= '&amp;h=' . $height;} elseif (0 == $height) {} else {$par .= '&amp;h=' . CROP_HEIGHT;}
		//d($height);
		if ($zc) {$par .= '&amp;zc=' . $zc;} elseif (0 == $zc) {} else {$par .= '&amp;zc=' . CROP_ZC;} 

		if (NULL == $html) {
			$html = "<img src='%s' class='%s' alt='%s' />";
		}
		$imgURL = get_crop_image($imgSrc, $par);
		//d($imgURL);
		
		return sprintf($html, $imgURL, $classes,  $alt);
	}

	function get_author_posts_link($deprecated = '') {
		if (!empty($deprecated))
			_deprecated_argument(__FUNCTION__, '2.1');

		global $authordata;
		if (!is_object($authordata))
			return false;
		$link = sprintf('<a href="%1$s" title="%2$s" rel="author">%3$s</a>', get_author_posts_url($authordata -> ID, $authordata -> user_nicename), esc_attr(sprintf(__('Posts by %s'), get_the_author())), get_the_author());
		return apply_filters('the_author_posts_link', $link);
	}

	function get_current_id() {
		global $wp_query;
		//inspect($wp_query);
		return $wp_query->post->ID;
		
	}
	
function get_customTerms($taxonomies = 'category') {
	global $wpdb;
	$query = "SELECT t.*, tt.* FROM wp_terms AS t INNER JOIN wp_term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ('$taxonomies') ORDER BY t.name ASC";

	$terms = $wpdb->get_results($query);
	return $terms;
}

function get_catByName($name, $taxonomies = 'category') {
	$cats = get_customTerms($taxonomies);
	if (is_array($cats)) {
		foreach ($cats as $k => $v) {
			if ($v->name == $name) {
				return $v->term_id;
			}
		}
	}
	return false;
}

function setOG($query = NULL) {
	global $mb_problema;
	global $mb_destaque;
	global $mb_proposta;
	
	if (NULL == $query) {
		global $wp_query;
		$query = $wp_query;
		
		if ($query->have_posts()) {
		 	while ($query->have_posts()) {
		 		 $query->the_post();
				
				$mb_proposta->the_meta($post->ID);
				$pmeta = $mb_proposta->meta;
				
				$mb_problema->the_meta($post->ID);
				$meta = $mb_problema->meta;
				
				$mb_destaque->the_meta($post->ID);
				$dmeta = $mb_destaque->meta;	
				
				//get image
				if($dmeta['videoURL']) {
					$code = getVideoCode($dmeta['videoURL']);
				} elseif ($pmeta['videoURL']) {
					$code = getVideoCode($pmeta['videoURL']);
				}
				if ($code) {
					$thumbnail = getYoutubeThumb($code);
				}
				
				$postImg = get_post_image_src();
				if($thumbnail) {
					$image = $thumbnail;
				} elseif($postImg) {
					$image = $postImg;
				} else {
					$image = NULL;
				}
				
				//get text 			
				if('' != $meta['descricao']) {
					$description = get_custom_length($meta['descricao'], 250);
				} else {
					$description = get_custom_excerpt(250);
				}
				
				$settings = array( 'image'=> $image, 'title'=> get_the_title(), 'description'=> $description, 'url'=> get_permalink(), 'type' => 'website');
				break;
			}
		}
		//d($settings);
		$query->rewind_posts();
		global $OG;
		if (is_array($settings)) {
			$OG = $settings;
		} else {
			return FALSE;
		}
		return TRUE;
	} else {
		return FALSE;
	}
}

function the_OG( $imgURL = NULL, $title = NULL, $description = NULL, $URL = NULL, $type = NULL) {
	
	
	global $OG;
	
	//set title 
	if(($title == NULL)&&($OG['title'])) {
			$title = $OG['title'];
	} elseif(function_exists('get_bloginfo')) {
		$title = get_bloginfo('name') . wp_title('»', false);
	} else {
		$title = OG_TITLE;
	}
	
	//set url 	
	if(($URL == NULL)&&($OG['url'])) {
		$URL = $OG['url'];
	}elseif(function_exists('get_permalink')) {
		$URL = get_permalink();
	} else {
		$URL = OG_URL;
	}
	
	//set image	
	if(($imgURL == NULL)&&($OG['image'])) {
		$imgURL = $OG['image'];
	}else {
		$imgURL = OG_IMAGE;
	}
	
	//set description 	
	if(($description == NULL)&&($OG['description'])) {
		$description = $OG['description'];
	}elseif(function_exists('get_the_content')) {
		$description = get_custom_excerpt(250);
	} else {
		$description = OG_DESCRIPTION;
	}
	
	//set type 
	if(($type == NULL)&&($OG['type'])) {
		$type = $OG['type'];
	} else {
		$type = OG_TYPE;
	}
	
	FB_OG($imgURL, $title, $description, $URL, $type);
}
