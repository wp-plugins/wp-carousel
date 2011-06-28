<?php

	/*
		Este archivo se importa (require_once) cuando es necesario acceder al archivo wp-blog-header.php, en la carpeta Raíz de WordPress. Para evitar código duplicado se almacena aquí el sistema para recorrer los directorios y acceder a la carpeta Raíz de WordPress desde la carpeta de WP Carousel.
	*/
	
	if (!defined('WP_CAROUSEL_WP_BLOG_HEADER_FILE'))
	{
		define('WP_CAROUSEL_WP_BLOG_HEADER_FILE', 'wp-blog-header.php');
	}
	
	$folder = str_replace('/'.__FILE__, '', $_SERVER['PHP_SELF']);
	$folder_exploded = explode('/', $folder);
	$folder_count = count($folder_exploded);
	krsort($folder_exploded);
	$folder_count--;
	unset ($folder_exploded[$folder_count]);
	$folder_count -= 2;
	$folder_path = "";
	$folder_temp = 0;
	for ($folder_temp = 0; $folder_temp < $folder_count; $folder_temp++)
	{
		$folder_path .= '../';
	}
		
	if (!is_readable($folder_path . WP_CAROUSEL_WP_BLOG_HEADER_FILE)) $folder_path = "../../../";
		

?>