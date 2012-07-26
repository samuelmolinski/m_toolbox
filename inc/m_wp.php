<?php
	//Metabox based path
	define('METAPATH', TOOLPATH . 'inc/wp/metaboxes/');	
	include (METAPATH .'MediaAccess.php'); //Custom Meta Data Class
	include (METAPATH .'MetaBox.php'); //Custom Meta Data Class
	include (METAPATH .'metaSetup.php'); //Setup Custom Meta Data 
	
	include_once ('wp/m_post.php');
	include_once ('wp/m_image.php');
	include_once ('wp/m_metabox.php'); //additional WP Alchemy functions
?>