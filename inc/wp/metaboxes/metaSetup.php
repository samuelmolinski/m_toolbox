<?php

require_once('MetaBox.php');
require_once('MediaAccess.php');

// global styles for the meta boxes
if (is_admin()) wp_enqueue_style('wpalchemy-metabox', get_stylesheet_directory_uri() . '/library/css/metaboxes.css');

$mb_agenda = new WPAlchemy_MetaBox(array
(
	'id' => 'agenda-customMeta',
	'title' => 'Agenda',
	'types' => array('agenda'), // added only for pages and to custom post type "events"
	'context' => 'normal', // same as above, defaults to "normal"
	'priority' => 'high', // same as above, defaults to "high"
	'template' => METAPATH . 'meta/agenda-meta.php'
));
//default required for m_metabox.php
//featured image is seperated to make it easier to sort the query results
$mb_destaque = new WPAlchemy_MetaBox(array
(
	'id' => 'destaque-customMeta',
	'title' => 'Destaque',
	'types' => array('problema', 'resposta', 'post'), // added only for pages and to custom post type "events"
	'context' => 'side', // defaults to "normal"
	'priority' => 'high', // defaults to "high"
	'template' => METAPATH . 'meta/destaque-meta.php'
));
$mb_gmap = new WPAlchemy_MetaBox(array
(
	'id' => 'gmap-customMeta',
	'title' => 'Google Map',
	'types' => array('agenda', 'problema', 'proposta'), // added only for pages and to custom post type "events"
	'context' => 'normal', // defaults to "normal"
	'priority' => 'high', // defaults to "high"
	'template' => METAPATH . 'meta/gmap-meta.php'
));
$mb_problema = new WPAlchemy_MetaBox(array
(
	'id' => 'problema-customMeta',
	'title' => 'Problema',
	'types' => array('problema'), // added only for pages and to custom post type "events"
	'context' => 'normal', // same as above, defaults to "normal"
	'priority' => 'high', // same as above, defaults to "high"
	'template' => METAPATH . 'meta/problema-meta.php'
));

$mb_projeto = new WPAlchemy_MetaBox(array
(
	'id' => 'projeto-customMeta',
	'title' => 'Projeto',
	'types' => array('projeto'), // added only for pages and to custom post type "events"
	'context' => 'normal', // same as above, defaults to "normal"
	'priority' => 'high', // same as above, defaults to "high"
	'template' => METAPATH . 'meta/projeto-meta.php'
));

$mb_proposta = new WPAlchemy_MetaBox(array
(
	'id' => 'proposta-customMeta',
	'title' => 'Proposta',
	'types' => array('proposta'), // added only for pages and to custom post type "events"
	'context' => 'normal', // same as above, defaults to "normal"
	'priority' => 'high', // same as above, defaults to "high"
	'template' => METAPATH . 'meta/proposta-meta.php'
));

$mb_resposta = new WPAlchemy_MetaBox(array
(
	'id' => 'resposta-customMeta',
	'title' => 'Resposta',
	'types' => array('resposta'), // added only for pages and to custom post type "events"
	'context' => 'normal', // same as above, defaults to "normal"
	'priority' => 'high', // same as above, defaults to "high"
	'template' => METAPATH . 'meta/resposta-meta.php'
));
$mb_blogDeVideo = new WPAlchemy_MetaBox(array
(
	'id' => 'blogDeVideo-customMeta',
	'title' => 'Meta do Blog de Video',
	'types' => array('page'), // added only for pages and to custom post type "events"
	'context' => 'normal', // same as above, defaults to "normal"
	'priority' => 'high', // same as above, defaults to "high"
	'template' => METAPATH . 'meta/blogDeVideo-meta.php'
));

/* eof */