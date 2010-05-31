<?php
	/* Calculamos la ruta al archivo wp-blog-header.php */
	
	$folder = str_replace('/update_db.php', '', $_SERVER['PHP_SELF']);
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
	
	/* Cargamos el archivo */
	
	require_once($folder_path . 'wp-blog-header.php');

	$wp_carousel_content = maybe_unserialize(get_option('wp_carousel'));
	
	if (!isset($_POST['carousel_id']))
	{
		echo '<div class="error"><p>There was an error, please, report it in the forum and attach this error message:</p></div><p>'.base64_encode(serialize($_POST)).'</p>';
		exit;
	}
	
	$carousel_content = $wp_carousel_content[$_POST['carousel_id']];

	if (isset($_POST['action']))
	{
		if ($_POST['action'] == 'updateSortableContent')
		{
			if (!isset($_POST['action'])) $_POST['action'] = '';
			if (!isset($_POST['internal_type'])) $_POST['internal_type'] = '';
			
			foreach ($_POST as $key => $value)
			{
				if (($key != 'action' && $key != 'internal_type' && $key != 'carousel_id') && $_POST['internal_type'] == 'serialized') // No es el campo de accion y el indicador es de serializado
				{
					$temp_printable = base64_decode($_POST[$key]);
					$temp_printable = explode('&', $temp_printable);
					foreach ($temp_printable as $temp_key => $temp_value)
					{
						$temp_value = explode('=', $temp_value);
						$array_keys = array('category_id', 'posts_order', 'posts_number', 'show_in_loop', 'order', 'type', 'post_title', 'desc', 'url_image', 'url_link');
						$array_names = array('ID', 'POSTS_ORDER', 'POSTS_NUMBER', 'SHOW', 'ORDER', 'TYPE', 'TITLE', 'DESC', 'IMAGE_URL', 'LINK_URL');
						$temp_value[0] = str_replace($array_keys, $array_names, $temp_value[0]);
						$temp_printable[$temp_value[0]] = urldecode($temp_value[1]);
						unset($temp_printable[$temp_key]);
					}
					if (!isset($temp_printable['POSTS_NUMBER'])) $temp_printable['POSTS_NUMBER'] = 0;
					if (!isset($temp_printable['SHOW'])) $temp_printable['SHOW'] = 0;
					unset($_POST[$key]);
					$key_exploded = explode('_', $key);
					$key = $key_exploded[1].'_'.$temp_printable['ID'].'_'.$temp_printable['TYPE'];
					$_POST[$key] = $temp_printable;
				}
			}
			
			$new_content = $_POST;
			$carousel_id = $new_content['carousel_id'];
			
			unset($new_content['action']);
			unset($new_content['internal_type']);
			unset($new_content['carousel_id']);
			
			/* ONLY FOR DEBUG */
			
			/*
			
			echo '<pre>';
			print_r($new_content);
			echo '</pre>';
			
			*/ 
			
		}
		elseif ($_POST['action'] == 'updateSortableOrder')
		{
			
			/* ONLY FOR DEBUG */
			
			/*
			
			echo '<pre>';
			print_r($_POST);
			echo '<pre>';
			
			*/ 
			
		}
		
		$wp_carousel_content[$_POST['carousel_id']] = $new_content;
		
		update_option('wp_carousel', serialize($wp_carousel_content));
		
	}
?>