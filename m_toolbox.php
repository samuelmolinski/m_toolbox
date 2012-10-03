<?php
	/* M ToolBox 
	 * Version: 0.2
	 * Last Modified: 2012/06/22
	 * Author: Samuel Molinski
	 * 
	 * This is a personal collection of WordPress functions I have found to be 
	 * useful in most of my themecraft.  I have complited them into this 'toolbox
	 * to help keep them together for easy implementation.
	 * 
	 * To include this to any theme add the wp_toobox folder to your theme and 
	 * add the line "include_once('wp_toolbox/wp_toolbox.php');" inside the
	 * function.php
	 * 
	 * Most of the functions are written to use a similar nomenclature as
	 * Wordpress uses already 
	 * 
	 * 
	 */
	//settings to customize for each installation
	require_once ('config.php');
	
	//useful for the confige file
	include ('inc/generic/m_uri.php'); // URI manipulation
	include ('inc/generic/m_css.php'); // css functions (valid selector name etc)
	include ('inc/generic/m_super_dump.php'); // general purpose custom debug functions
	include ('inc/generic/m_xml.php'); // load/parse xml 
	include ('inc/generic/m_socialMedia.php'); // various social media function to get data 
	include ('inc/generic/m_cookie.php'); // cookie get, set, remove, cookie array 
	include ('inc/generic/m_video.php'); // various video manipulation for youtube 
	
	
	
	//comment out to not include WordPress specific functions
	include ('inc/m_wp.php'); //handles post based functions
	
	//comment out to not include Yii specific functions
	//include ('inc/m_yii.php'); //handles post based functions
	
	