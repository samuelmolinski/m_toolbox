<?php

function get_featured_posts($post_type = array('post'), $numPost = 3) {
    $a = array(
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'post_type' => $post_type,
		'order' => 'DESC',
		'orderby' => 'modified'
	);
	
	$featured = array();
	$qObject = new WP_Query($a);
	$ps = $qObject->posts;
	global $mb_destaque;
	//d($qObject);
	foreach ($ps as $p) {		
		$mb_destaque->the_meta($p->ID);
		$meta = $mb_destaque->meta;
		$ef = $mb_destaque->meta['enableFeatured'];
		//d($ef);
		if ($ef) {
			$featured[] = $p->ID;
		}
		
		if (($numPost != -1)&&(count($featured) >= $numPost)) {
			 break;
		}
	
	}
	//d($featured);
	
		if (isset($featured)) {
			$arg = array(
				'post__in' => $featured,
				'posts_per_page' => $numPost,
				'post_status' => 'publish',
				'post_type' => $post_type,
				'order' => 'DESC',
				'orderby' => 'modified'
			);
			$queryObject = new WP_Query($arg);
		}
	
	return $queryObject;
}