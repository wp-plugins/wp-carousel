<?php

	/* Esta variable almacenara si se ha producido un error o no */
	
	$wp_carousel_error = false;
	
	$had_backup = false;

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
		
	if (!is_readable($folder_path . 'wp-blog-header.php')) $folder_path = "../../../";
		
	/* Comprobamos si podemos cargar el archivo */
	
	if (!is_readable($folder_path . 'wp-blog-header.php')) 
	{
		$wp_carousel_error = true;
		?>
			<div class="error">
				<p><?php printf('File <code>%s</code> can\'t be read!', $folder_path . 'wp-blog-header.php'); ?></p>
			</div>
		<?php
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
							$array_keys = array('category_id', 'posts_order', 'posts_number', 'show_in_loop', 'order', 'type', 'post_title', 'desc', 'url_image', 'url_video', 'url_link', 'wp_carousel_ei_url', 'wp_carousel_ei_id');
							$array_names = array('ID', 'POSTS_ORDER', 'POSTS_NUMBER', 'SHOW', 'ORDER', 'TYPE', 'TITLE', 'DESC', 'IMAGE_URL', 'VIDEO_URL', 'LINK_URL', 'WP_CAROUSEL_EI_URL', 'WP_CAROUSEL_EI_ID');
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
					
		}
		$action_sended = 'SAVE-NO-AJAX:'.base64_encode(serialize($new_content)).':'.$carousel_id;
		?>
			<div class="updated fade">
				<p>Click <a href="admin.php?page=edit-carousel-<?php echo $_POST['carousel_id']; ?>&action=<?php echo $action_sended; ?>">here</a> to save changes.</p>
			</div>
		<?php
		exit;
	}
		
	/* Cargamos el archivo */
	
	echo '<p style="display:none;">';	
	require_once($folder_path . 'wp-blog-header.php');
	echo '</p>';
	
	/*
		Cargamos los archivos del idioma correspondiente
	*/
		
	$currentLocale = get_locale();
	if(!empty($currentLocale)) 
	{
		$moFile = dirname(__FILE__) . "/language/" . $currentLocale . ".mo";
		if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('wp_carousel', $moFile);
	}

	if (!current_user_can('manage_options'))
	{
		?>
		<div class="error">
			<p>
				<?php _e('WP Carousel can\'t confirm that you have an admin account. You are not allowed to perform modifications in the Database for security reasons.', 'wp_carousel'); ?>
			</p>
		</div>
		<?php
		exit;
	}

	$wp_carousel_content = maybe_unserialize(get_option(WP_CAROUSEL_ITEMS_TABLE));
	
	if (!isset($_POST['carousel_id']))
	{
		$wp_carousel_error = true;
		?>
			<div class="error">
				<p>
					<?php printf(__('There was an error, please, report it in the forum and attach this error message:', 'wp_carousel'), $folder_path . 'wp-blog-header.php'); ?>
				</p>
				<p>
					<?php echo base64_encode(serialize($_POST)).' (file: update_db.php - 149)'; ?>
				</p>
			</div>
		<?php
		exit;
	}
	
	$carousel_content = $wp_carousel_content[$_POST['carousel_id']];

	if (isset($_POST['action']))
	{
		if ($_POST['action'] == 'updateSortableContent')
		{
						
			if (!isset($_POST['must_backup']))
			{
				$_POST['must_backup'] = 'no';
			}
			
			//print_r($_POST);
			
			foreach ($_POST as $key => $value)
			{
				if (($key != 'action' && $key != 'internal_type' && $key != 'carousel_id' && $key != 'must_backup') && $_POST['internal_type'] == 'serialized') // No es el campo de accion y el indicador es de serializado
				{
					$temp_printable = base64_decode($_POST[$key]);
					$temp_printable = explode('&', $temp_printable);
					foreach ($temp_printable as $temp_key => $temp_value)
					{
						$temp_value = explode('=', $temp_value);
						$array_keys = array('category_id', 'posts_order', 'posts_number', 'show_in_loop', 'order', 'type', 'post_title', 'desc', 'url_image', 'url_video', 'url_link', 'wp_carousel_ei_url', 'wp_carousel_ei_id');
							$array_names = array('ID', 'POSTS_ORDER', 'POSTS_NUMBER', 'SHOW', 'ORDER', 'TYPE', 'TITLE', 'DESC', 'IMAGE_URL', 'VIDEO_URL', 'LINK_URL', 'WP_CAROUSEL_EI_URL', 'WP_CAROUSEL_EI_ID');
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
			unset($new_content['must_backup']);
			
			/* ONLY FOR DEBUG */
			
			/*
			
			echo '<pre>';
			print_r($new_content);
			echo '</pre>';
			
			*/ 
			
			$wp_carousel_content[$_POST['carousel_id']] = $new_content;
			
			if ($_POST['must_backup'] == 'yes' && WP_CAROUSEL_AUTOSAVE_BACKUPS)
			{
			
				$backup_config = maybe_unserialize(get_option(WP_CAROUSEL_CONFIG_TABLE));
				$backup_config = $backup_config[$_POST['carousel_id']];
				
				$backup_structure = maybe_unserialize(get_option(WP_CAROUSEL_BACKUP_TABLE));
				
				if (!isset($backup_structure[$_POST['carousel_id']])) 
				{
					$backup_structure[$_POST['carousel_id']] = array();
				}
				
				$backup_structure_current_carousel = $backup_structure[$_POST['carousel_id']];
				$backup_structure_current_carousel[time()] = array(
					'items' => serialize($new_content),
					'config' => serialize($backup_config)
				);
				
				$backup_structure[$_POST['carousel_id']] = $backup_structure_current_carousel;
				
				update_option(WP_CAROUSEL_BACKUP_TABLE, serialize($backup_structure));
				
				$had_backup = true;
			
			}
			
			update_option(WP_CAROUSEL_ITEMS_TABLE, serialize($wp_carousel_content));
			
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
		elseif ($_POST['action'] == 'updateStandardOptions')
		{
			$_POST['must_backup'] = 'yes';
			
			$main_config = maybe_unserialize(get_option(WP_CAROUSEL_CONFIG_TABLE));
			$old_config = $main_config[$_POST['carousel_id']];
			
			$config = array();
			$config = $old_config;
			
			$new_config = base64_decode($_POST['content']);
			$new_config_exploded = explode('&', $new_config);
			
			/* ONLY FOR DEBUG */
			
			/*
			
			echo '<pre>';
			$content = explode('&', base64_decode($_POST['content']));
			echo implode('<br />', $content);
			echo '</pre>';
			
			*/
						
			if (array_search('use_jcarousel=yes', $new_config_exploded) === false)
			{
				$new_config_exploded[] = 'use_jcarousel=no';
			}
			
			if (array_search('vertical_mode=yes', $new_config_exploded) === false)
			{
				$new_config_exploded[] = 'vertical_mode=no';
			}
						
			if (array_search('show_arrows=yes', $new_config_exploded) === false)
			{
				$new_config_exploded[] = 'show_arrows=no';
			}
						
			if (array_search('loop_mode=yes', $new_config_exploded) === false)
			{
				$new_config_exploded[] = 'loop_mode=no';
			}
						
			if (array_search('enable_pagination=yes', $new_config_exploded) === false)
			{
				$new_config_exploded[] = 'enable_pagination=no';
			}
		
			foreach ($new_config_exploded as $key => $value)
			{
				$new_option_exploded = explode('=', $value);
				
				if ($new_option_exploded[1] == 'yes')
				{
					$new_option_exploded[1] = 1;
				}
				
				if ($new_option_exploded[1] == 'no')
				{
					$new_option_exploded[1] = 0;
				}
				
				$config[strtoupper($new_option_exploded[0])] = urldecode($new_option_exploded[1]);
			}
									
			$main_config[$_POST['carousel_id']] = $config;
			
			/* ONLY FOR DEBUG */
			
			/*
			
			echo '<pre>';
			echo implode('<br />', $new_config_exploded);
			echo '</pre>';
			
			*/
			
			if (WP_CAROUSEL_AUTOSAVE_BACKUPS):
						
				$backup_items = maybe_unserialize(get_option(WP_CAROUSEL_ITEMS_TABLE));
				$backup_items = $backup_items[$_POST['carousel_id']];
				
				$backup_structure = maybe_unserialize(get_option(WP_CAROUSEL_BACKUP_TABLE));
				
				if (!isset($backup_structure[$_POST['carousel_id']])) 
				{
					$backup_structure[$_POST['carousel_id']] = array();
				}
				
				$backup_structure_current_carousel = $backup_structure[$_POST['carousel_id']];
				$backup_structure_current_carousel[time()] = array(
					'items' => serialize($backup_items),
					'config' => serialize($config)
				);
				
				$backup_structure[$_POST['carousel_id']] = $backup_structure_current_carousel;
				
				update_option(WP_CAROUSEL_BACKUP_TABLE, serialize($backup_structure));
				
				$had_backup = true;

			endif;
						
			update_option(WP_CAROUSEL_CONFIG_TABLE, serialize($main_config)); 		
		}
		elseif ($_POST['action'] == 'updateThemeOptions')
		{
			$_POST['must_backup'] = 'yes';
			
			$main_config = maybe_unserialize(get_option(WP_CAROUSEL_CONFIG_TABLE));
			$old_config = $main_config[$_POST['carousel_id']];
			
			$config = array();
			$config = $old_config;
			
			$new_config = base64_decode($_POST['content']);
			$new_config_exploded = explode('&', $new_config);
		
			foreach ($new_config_exploded as $key => $value)
			{
				$new_option_exploded = explode('=', $value);
				
				if ($new_option_exploded[1] == 'yes')
				{
					$new_option_exploded[1] = 1;
				}
				
				$config['THEME_SETTINGS'][strtoupper($new_option_exploded[0])] = urldecode($new_option_exploded[1]);
			}
						
			$main_config[$_POST['carousel_id']] = $config;
			
			/* ONLY FOR DEBUG */
			
			/*
			
			echo '<pre>';
			print_r($main_config);
			echo '</pre>';
			
			*/
			
			if (WP_CAROUSEL_AUTOSAVE_BACKUPS):
			
				$backup_items = maybe_unserialize(get_option(WP_CAROUSEL_ITEMS_TABLE));
				$backup_items = $backup_items[$_POST['carousel_id']];
				
				$backup_structure = maybe_unserialize(get_option(WP_CAROUSEL_BACKUP_TABLE));
				
				if (!isset($backup_structure[$_POST['carousel_id']])) 
				{
					$backup_structure[$_POST['carousel_id']] = array();
				}
				
				$backup_structure_current_carousel = $backup_structure[$_POST['carousel_id']];
				$backup_structure_current_carousel[time()] = array(
					'items' => serialize($backup_items),
					'config' => serialize($config)
				);
				
				$backup_structure[$_POST['carousel_id']] = $backup_structure_current_carousel;
				
				update_option(WP_CAROUSEL_BACKUP_TABLE, serialize($backup_structure));
				
				$had_backup = true;
				
			endif;
						
			update_option(WP_CAROUSEL_CONFIG_TABLE, serialize($main_config)); 		
		}
		
	}
	
	if (!$wp_carousel_error)
	{
		?><div class="updated changes_saved"><p><?php _e('Changes saved', 'wp_carousel'); ?></p></div><?php
		if ($had_backup)
		{
			?><div class="updated changes_saved"><p><?php _e('A Backup has been saved', 'wp_carousel'); ?></p></div><?php
		}
	}
	else
	{
		?><div class="error"><p><?php _e('There was an error!', 'wp_carousel'); ?></p></div><?php
	}
?>