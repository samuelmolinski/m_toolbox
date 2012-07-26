<?php

	/*
	 * get_crop_image 
	 * returns the url of the cropped image based on timthumb
	 * 
	 * default cropping can be configured in config file or provided as the URL
	 * encoded extention for timthumb directly
	 * 
	 */
	
	function get_crop_image($imgSrc, $timthumbOptions = NULL) {
		if (NULL == $timthumbOptions) {
			// &amp;w=800&amp;h=400&amp;zc=1
			$timthumbOptions = '&amp;w=' . CROP_WIDTH . '&amp;h=' . CROP_HEIGHT . '&amp;zc=' . CROP_ZC; 
		}
		return TOOLURL . "timthumb/timthumb.php?src=" . $imgSrc . $timthumbOptions;		
	}
	
	/*
	 * the_crop_image 
	 * prints preformatted image tag with class, alt, and cropped image 
	 * 
	 * set default HTML structure, the order of the $arg will always be same 
	 * order: source, class, alternate name
	 * 
	 */
	
	function the_crop_image($imgSrc, $timthumbOptions = NULL, $classes = '', $alt = '', $html = NULL) {
		if (NULL == $html) {
			$html = "<img src='%s' class='%s' alt='%s' />";
		}
		$imgURL = get_crop_image($imgSrc, $timthumbOptions);
		
		printf($html, $imgURL, $classes,  $alt);
	}	
	
	/*
	 * get_desaturate_image 
	 * returns the url of the desaturated image if it exists or creates a new
	 * one (in the same directory as the orginial)
	 *
	 */

	function get_desaturate_image($image_src) {

		// Find thumbnail locations
		$image_src_path = dirname($image_src);
		//		inspect($image_src_path);
		$image_src_filename = basename($image_src);
		//		inspect($image_src_filename);

		// Create greyscale filename
		$image_src_extention_loc = (strripos($image_src_filename, '.') - strlen($image_src_filename));
		$bw_image_filename = substr($image_src_filename, 0, $image_src_extention_loc) . '_bw' . substr($image_src_filename, $image_src_extention_loc);

		$path = explode('wp-content', $image_src_path);
		//		inspect(WP_CONTENT_DIR);
		//		inspect($path);
		//		inspect($bw_image_filename);

		if (file_exists(WP_CONTENT_DIR . $path[1] . '/' . $bw_image_filename)) {
			//			inspect('found it!');
		}

		if (!file_exists(WP_CONTENT_DIR . $path[1] . '/' . $bw_image_filename)) {
			// Create greyscale image
			$bw_image = wp_load_image(WP_CONTENT_DIR . $path[1] . '/' . $image_src_filename);
			//			inspect($bw_image);

			// Apply greyscale filter
			imagefilter($bw_image, IMG_FILTER_GRAYSCALE);

			// Save the image.
			imagejpeg($bw_image, WP_CONTENT_DIR . $path[1] . '/' . $bw_image_filename, 100);

			imagedestroy($bw_image);
		}

		return $image_src_path . '/' . $bw_image_filename;
	}
