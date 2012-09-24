<?php
	// path definition used internally for the tool kit
	// Requires the folder structure to remain intact
	
	$path_parts = pathinfo(__FILE__);
	define('TOOLPATH', $path_parts['dirname'] . '/'); //system based path	
	//define('TOOLURL', currentBaseURI().'/wp-content/themes/rodrigoMaia/m_toolbox/'); //OFFLINE HTTP based path (for image manipulation)	
	if(function_exists('get_bloginfo')) {
		//for Wordpress Template Path		
		define('TOOLURL', get_bloginfo('template_url').'/m_toolbox/'); //ONLINE HTTP based path (for image manipulation)	
	} else {
		define('TOOLURL', TOOLPATH); //ONLINE HTTP based path (for image manipulation)	
	}
	//Debug global toggle
	define('m_debug', 1);
	
	//Required for Google TinyURL
	define('GOOGLE_API_KEY', 'AIzaSyBLxv3xZgvL-MyMHGCupCydYMnuUsrCU14');
	define('GOOGLE_ENDPOINT', 'https://www.googleapis.com/urlshortener/v1');
	
	//Default cropping sizes for placement and timthumb
	define('CROP_HEIGHT', 500);
	define('CROP_WIDTH', 960);
	define('CROP_ZC', 1);
	
	//required for Facebook apps (Like Box, Comment Box)
	define('FB_ID', '');
	define('FB_ADMINS', '');
	define('FB_SECRET', '');
	define('FB_APP_URL', '');
	define('FB_BASEURL', '');
	
	// OG defaults settings 
	define('OG_TITLE', '');
	define('OG_DESCRIPTION', '');
	define('OG_URL', '');
	define('OG_TYPE', 'website');
	define('OG_IMAGE', '');
