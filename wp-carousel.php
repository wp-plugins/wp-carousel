<?php

	/*
		Plugin Name: WP Carousel
		Plugin URI: http://sumolari.com/?p=1759
		Description: A simple post carousel for WordPress
		Version: 0.3
		Author: Llu&iacute;s Ulzurrun
		Author URI: http://sumolari.com
	*/

	/*
		Copyright 2009  Llu&iacute;s Ulzurrun  (email : info@sumolari.com)
	
		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation; either version 2 of the License, or
		(at your option) any later version.
	
		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.
	
		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	*/
	
	$path_1 = plugin_basename(__FILE__);
	
	$path_2 = ereg_replace('/wp-carousel.php', '', $path_1);
	
	/* Pre 2.6 */
	
	if (!defined( 'WP_CONTENT_URL' ) )
		define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
	if (!defined( 'WP_PLUGIN_URL' ) )
		define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
		
	$wp_carousel_options_serialized = get_option('wp_carousel_options');
	$wp_carousel_options = unserialize($wp_carousel_options_serialized);
		
	$wp_carousel_options_lang = $wp_carousel_options['lang'];
	
	include('lang/index.php');
			
	function wp_carousel_link_js_files () {
		
		global $path_2;
		
		echo '<script type="text/javascript" src="', bloginfo('url') ,'/wp-includes/js/jquery/jquery.js"></script>';
		echo '<script type="text/javascript" src="', WP_PLUGIN_URL ,'/'.$path_2.'/carousel.js"></script>';
		echo '<script type="text/javascript">';
			include ('carousel-config.php');		
		echo '</script>';

		echo '<style type="text/css" media="screen">';
			include('carousel-css.php');
		echo '</style>';
	}
	
	function wp_carousel_first_image() {
		global $post, $posts;
		
		$first_img = '';
		
		ob_start();
		ob_end_clean();
		
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches [1] [0];
		
		if(empty($first_img)){ //Defines a default image
			$first_img = "";
		}
		
		return $first_img;
	}
	
	function wp_carousel($carousel_id) {
				
		global $path_2;
		
		$wp_carousel_options_serialized = get_option('wp_carousel_options');
		$wp_carousel_options = unserialize($wp_carousel_options_serialized);
		
		$wp_carousel_post_cat_id = $wp_carousel_options['carousel_'.$carousel_id.'']['cat_id'];
		$wp_carousel_post_num = $wp_carousel_options['carousel_'.$carousel_id.'']['post_num'];
		$wp_carousel_post_link_txt = $wp_carousel_options['carousel_'.$carousel_id.'']['post_link_txt'];
		$wp_carousel_autostep = $wp_carousel_options['carousel_'.$carousel_id.'']['autostep'];
		$wp_carousel_autostep_time = $wp_carousel_options['carousel_'.$carousel_id.'']['autostep_time'];
		$wp_carousel_autostep_num = $wp_carousel_options['carousel_'.$carousel_id.'']['autostep_num'];
		$wp_carousel_step_num = $wp_carousel_options['carousel_'.$carousel_id.'']['step_num'];
		
		$wp_carousel_panel_width = $wp_carousel_options['carousel_'.$carousel_id.'']['panel_width'];
		$wp_carousel_panel_width_unit = $wp_carousel_options['carousel_'.$carousel_id.'']['panel_width_unit'];
		$wp_carousel_image_same_width = $wp_carousel_options['carousel_'.$carousel_id.'']['image_same_width'];
		$wp_carousel_image_more_height = $wp_carousel_options['carousel_'.$carousel_id.'']['image_more_height'];
		$wp_carousel_image_more_height_h = $wp_carousel_options['carousel_'.$carousel_id.'']['image_more_height_h'];
		$wp_carousel_image_more_height_h_unit = $wp_carousel_options['carousel_'.$carousel_id.'']['image_more_height_h_unit'];
		
		$wp_carousel_content_order = $wp_carousel_options['carousel_'.$carousel_id.'']['content_order'];
		$wp_carousel_more_content = $wp_carousel_options['carousel_'.$carousel_id.''];
		
	?>		
		<?php if($wp_carousel_post_cat_id != 0 && $wp_carousel_post_num != 0 || $wp_carousel_more_content != '') { ?>
		
		<div class="button-next">
			<?php if ($wp_carousel_step_num > 0) { ?><a href="javascript:stepcarousel.stepBy('wp_carousel_<?php echo $carousel_id; ?>', <?php echo $wp_carousel_step_num; ?>)"><img src="<?php echo '', WP_PLUGIN_URL ,'/'.$path_2.'/'; ?>img/arrow_right.png" /></a><?php } ?>
		</div>
		
		<div class="button-prev">
			<?php if ($wp_carousel_step_num > 0) { ?><a href="javascript:stepcarousel.stepBy('wp_carousel_<?php echo $carousel_id; ?>', -<?php echo $wp_carousel_step_num; ?>)"><img src="<?php echo '', WP_PLUGIN_URL ,'/'.$path_2.'/'; ?>img/arrow_left.png" /></a><?php } ?>
		</div>
		
		
		<div id="wp_carousel_<?php echo $carousel_id; ?>" class="wp_carousel carousel">
			
			<div class="belt">
			
				<?php 
				if($wp_carousel_content_order == 'posts') {
										
					if ($wp_carousel_post_cat_id != 0 && $wp_carousel_post_num != 0) { 
			
						$carousel_posts = new WP_Query('cat='.$wp_carousel_post_cat_id.'&showposts='.$wp_carousel_post_num.'');	
					
						while ($carousel_posts->have_posts()) : $carousel_posts->the_post();
						
						?>
					
						<div class="panel">
							<a href="<?php echo get_permalink(); ?>"><img src="<?php echo wp_carousel_first_image(); ?>" <?php if ($same_width == 'yes') { echo 'width="'.$width.''.$unit.'"'; } ?> <?php if ($more_height == 'yes') { echo 'height="'.$more_height_h.''.$more_height_unit.'"'; } ?> /></a>
							<div class="panel-text">
								 <?php the_excerpt(); ?> 
								 <?php
									if ($wp_carousel_post_link_txt != '') {
										echo '<p><a href="'. get_permalink() .'">'.$wp_carousel_post_link_txt.'</a></p>';
									}
								?>
							</div>
						</div>
						
						<?php 
						
						endwhile; 
					}
					
					$n = 1;
					do {
						$m = 1;
						while ($wp_carousel_more_content['costumized_content_'.$m.'']['order'] != $n) {
							$m++;
						}
						?>
						
						<div class="panel">
							<a href="<?php echo $wp_carousel_more_content['costumized_content_'.$m.'']['link_url']; ?>"><img src="<?php echo $wp_carousel_more_content['costumized_content_'.$m.'']['image_url']; ?>" <?php if ($wp_carousel_image_same_width == 'yes') { echo 'width="'.$wp_carousel_panel_width.''.$wp_carousel_panel_width_unit.'"'; } ?> <?php if ($wp_carousel_image_more_height == 'yes') { echo 'height="'.$wp_carousel_image_more_height_h.''.$wp_carousel_image_more_height_h_unit.'"'; } ?> /></a>
							<div class="panel-text">
								 <?php
								 	echo $wp_carousel_more_content['costumized_content_'.$m.'']['text'];
									if ($wp_carousel_post_link_txt != '') {
										echo '<p><a href="'. get_permalink() .'">'.$wp_carousel_post_link_txt.'</a></p>';
									}
								 ?> 
							</div>
						</div>
						
						<?php
						$n++;
					} while ($wp_carousel_more_content['costumized_content_'.$n.'']['image_url'] != '');
					
				} else {					
					
					$n = 1;
					do {
						$m = 1;
						while ($wp_carousel_more_content['costumized_content_'.$m.'']['order'] != $n) {
							$m++;
						}
						?>
						
						<div class="panel">
							<a href="<?php echo $wp_carousel_more_content['costumized_content_'.$m.'']['link_url']; ?>"><img src="<?php echo $wp_carousel_more_content['costumized_content_'.$m.'']['image_url']; ?>" <?php if ($wp_carousel_image_same_width == 'yes') { echo 'width="'.$wp_carousel_panel_width.''.$wp_carousel_panel_width_unit.'"'; } ?> <?php if ($wp_carousel_image_more_height == 'yes') { echo 'height="'.$wp_carousel_image_more_height_h.''.$wp_carousel_image_more_height_h_unit.'"'; } ?> /></a>
							<div class="panel-text">
								 <?php
								 	echo $wp_carousel_more_content['costumized_content_'.$m.'']['text'];
									if ($wp_carousel_post_link_txt != '') {
										echo '<p><a href="'. get_permalink() .'">'.$wp_carousel_post_link_txt.'</a></p>';
									}
								 ?> 
							</div>
						</div>
						
						<?php
						$n++;
					} while ($wp_carousel_more_content['costumized_content_'.$n.'']['image_url'] != '');
					
					if ($wp_carousel_post_cat_id != 0 && $wp_carousel_post_num != 0) { 
			
						$carousel_posts = new WP_Query('cat='.$wp_carousel_post_cat_id.'&showposts='.$wp_carousel_post_num.'');	
					
						while ($carousel_posts->have_posts()) : $carousel_posts->the_post();
						
						?>
					
						<div class="panel">
							<a href="<?php echo get_permalink(); ?>"><img src="<?php echo wp_carousel_first_image(); ?>" <?php if ($same_width == 'yes') { echo 'width="'.$width.''.$unit.'"'; } ?> <?php if ($more_height == 'yes') { echo 'height="'.$more_height_h.''.$more_height_unit.'"'; } ?> /></a>
							<div class="panel-text">
								 <?php the_excerpt(); ?> 
								 <?php
									if ($wp_carousel_post_link_txt != '') {
										echo '<p><a href="'. get_permalink() .'">'.$wp_carousel_post_link_txt.'</a></p>';
									}
								?>
							</div>
						</div>
						
						<?php 
						
						endwhile; 
					}
					
				}
				
				?>
			
			</div>
		</div>
	<?php
		}
	}
	
	add_action('wp_head', 'wp_carousel_link_js_files');
		
	add_action('admin_menu', 'crear_link_wp_carousel');
	
	add_action('admin_head', 'wp_carousel_admin_head');
	
	function crear_link_wp_carousel() {
		global $path_2;
		global $wp_carousel_txt;
		
		$wp_carousel_options_serialized = get_option('wp_carousel_options');
			
		$wp_carousel_options = unserialize($wp_carousel_options_serialized);
		
		$wp_carousel_options_lang = $wp_carousel_options['lang'];
		$wp_carousel_carousels = $wp_carousel_options['carousels'];
		
		add_menu_page('WP Carousel', 'WP Carousel', 'edit_themes', basename(__FILE__), 'wp_carousel_crear_pagina_opciones_general', ''.get_bloginfo('url').'/wp-content/plugins/'.$path_2.'/img/icon.png');
		
		$n = 0;
		while ($wp_carousel_carousels > $n) {
			$n++;
			add_submenu_page(basename(__FILE__), ''.$wp_carousel_txt['8'].' '.$n.'', ''.$wp_carousel_txt['8'].' '.$n.'', 'edit_themes', 'wp_carousel_carousel-'.$n.'', 'wp_carousel_crear_pagina_opciones');
		}
	}
	
	function wp_carousel_admin_head() {
		global $wp_carousel_txt;
		echo '
		<script>
			jQuery(document).ready(function(){
				jQuery("#wp_carousel_toggle_1_l").click(function(){
					jQuery(".wp_carousel_toggle_1_c").toggle();
				});
				jQuery(".wp_carousel_toggle_1_c").hide();
				
				jQuery("#wp_carousel_toggle_2_l").click(function(){
					jQuery(".wp_carousel_toggle_2_c").toggle();
				});
				jQuery(".wp_carousel_toggle_2_c").hide();
				
				var wp_carousel_more_content_last_id = jQuery(".wp_carousel_more_content:last").attr("title");
				
				jQuery("#wp_carousel_more_personalized_content").click(function(){
					wp_carousel_more_content_last_id++
					jQuery(".wp_carousel_more_content:last").after(\'<tr valign="top" class="wp_carousel_more_content" title="\' + wp_carousel_more_content_last_id + \'"><th scope="row"><h3>'.$wp_carousel_txt['18'].' #\' + wp_carousel_more_content_last_id + \'</h3></th><td><table class="form"><tr valign="top"><th scope="row"><label for="wp_carousel_more_content_\' + wp_carousel_more_content_last_id + \'_image_url">'.$wp_carousel_txt['31'].'</label></th><td><input name="wp_carousel_more_content_\' + wp_carousel_more_content_last_id + \'_image_url" id="wp_carousel_more_content_\' + wp_carousel_more_content_last_id + \'_image_url" value="" /></td></tr><tr valign="top"><th scope="row"><label for="wp_carousel_more_content_\' + wp_carousel_more_content_last_id + \'_link_url">'.$wp_carousel_txt['32'].'</label></th><td><input name="wp_carousel_more_content_\' + wp_carousel_more_content_last_id + \'_link_url" id="wp_carousel_more_content_\' + wp_carousel_more_content_last_id + \'_link_url" value="" /></td></tr><tr valign="top"><th scope="row"><label for="wp_carousel_more_content_\' + wp_carousel_more_content_last_id + \'_text">'.$wp_carousel_txt['33'].'</label></th><td><textarea name="wp_carousel_more_content_\' + wp_carousel_more_content_last_id + \'_text" id="wp_carousel_more_content_\' + wp_carousel_more_content_last_id + \'_text"></textarea></td></tr><tr valign="top"><th scope="row"><label for="wp_carousel_more_content_\' + wp_carousel_more_content_last_id + \'_order">'.$wp_carousel_txt['34'].'</label></th><td><input name="wp_carousel_more_content_\' + wp_carousel_more_content_last_id + \'_order" id="wp_carousel_more_content_\' + wp_carousel_more_content_last_id + \'_order" value="\' + wp_carousel_more_content_last_id + \'" /></td></tr></table></td></tr>\');
				});
			});
		</script>
		';
	}
	
	function wp_carousel_crear_pagina_opciones_general() {
		global $wp_carousel_txt;		
		
		$wp_carousel_options_serialized = get_option('wp_carousel_options');
		$wp_carousel_options = unserialize($wp_carousel_options_serialized);
		$wp_carousel_orig_options = $wp_carousel_options;
	
		if (isset($_GET['updated'])) {
			echo '<div id="message" class="updated fade"><p>'.__('Settings updated.', 'kubrick').'</p></div>';
		}
		
		if (isset($_POST['wp_carousel_options_lang'])) {
			
			$wp_carousel_options_lang = $_POST['wp_carousel_options_lang'];
			$wp_carousel_carousels = $_POST['wp_carousel_carousels'];
			
			$wp_carousel_options = array (
				'lang' => $wp_carousel_options_lang,
				'carousels' => $wp_carousel_carousels
			);
			
			$n = 1;
			do {
				$wp_carousel_options['carousel_'.$n.'']['cat_id'] = $wp_carousel_orig_options['carousel_'.$n.'']['cat_id'];
				$wp_carousel_options['carousel_'.$n.'']['post_num'] = $wp_carousel_orig_options['carousel_'.$n.'']['post_num'];
				$wp_carousel_options['carousel_'.$n.'']['post_link_txt'] = $wp_carousel_orig_options['carousel_'.$n.'']['post_link_txt'];
				$wp_carousel_options['carousel_'.$n.'']['autostep'] = $wp_carousel_orig_options['carousel_'.$n.'']['autostep'];
				$wp_carousel_options['carousel_'.$n.'']['autostep_time'] = $wp_carousel_orig_options['carousel_'.$n.'']['autostep_time'];
				$wp_carousel_options['carousel_'.$n.'']['autostep_num'] = $wp_carousel_orig_options['carousel_'.$n.'']['autostep_num'];
				$wp_carousel_options['carousel_'.$n.'']['step_num'] = $wp_carousel_orig_options['carousel_'.$n.'']['step_num'];
		
				$wp_carousel_options['carousel_'.$n.'']['panel_width'] = $wp_carousel_orig_options['carousel_'.$n.'']['panel_width'];
				$wp_carousel_options['carousel_'.$n.'']['panel_width_unit'] = $wp_carousel_orig_options['carousel_'.$n.'']['panel_width_unit'];
				$wp_carousel_options['carousel_'.$n.'']['image_same_width'] = $wp_carousel_orig_options['carousel_'.$n.'']['image_same_width'];
				$wp_carousel_options['carousel_'.$n.'']['image_more_height'] = $wp_carousel_orig_options['carousel_'.$n.'']['image_more_height'];
				$wp_carousel_options['carousel_'.$n.'']['image_more_height_h'] = $wp_carousel_orig_options['carousel_'.$n.'']['image_more_height_h'];
				$wp_carousel_options['carousel_'.$n.'']['image_more_height_h_unit'] = $wp_carousel_orig_options['carousel_'.$n.'']['image_more_height_h_unit'];
				$wp_carousel_options['carousel_'.$n.'']['content_order'] = $wp_carousel_orig_options['carousel_'.$n.'']['content_order'];
				$m = 1;
				while (isset($wp_carousel_orig_options['carousel_'.$n.'']['costumized_content_'.$m.'']['image_url'])) {
					$wp_carousel_options['carousel_'.$n.'']['costumized_content_'.$m.'']['image_url'] = $wp_carousel_orig_options['carousel_'.$n.'']['costumized_content_'.$m.'']['image_url'];
					$wp_carousel_options['carousel_'.$n.'']['costumized_content_'.$m.'']['link_url'] = $wp_carousel_orig_options['carousel_'.$n.'']['costumized_content_'.$m.'']['link_url'];
					$wp_carousel_options['carousel_'.$n.'']['costumized_content_'.$m.'']['text'] = $wp_carousel_orig_options['carousel_'.$n.'']['costumized_content_'.$m.'']['text'];
					$wp_carousel_options['carousel_'.$n.'']['costumized_content_'.$m.'']['order'] = $wp_carousel_orig_options['carousel_'.$n.'']['costumized_content_'.$m.'']['order'];
					$m++;
				}
				$n++;
			} while (isset($wp_carousel_orig_options['carousel_'.$n.'']['cat_id']));

			$wp_carousel_options_serialized = serialize($wp_carousel_options);
			
			update_option('wp_carousel_options', $wp_carousel_options_serialized);
									
		}
				
		$wp_carousel_options_lang = $wp_carousel_options['lang'];
		$wp_carousel_carousels = $wp_carousel_options['carousels'];
		
		
	?>
		
	<div class="wrap">
	
	<h2>WP Carousel</h2>
		
	<div id="message" class="updated"><p><?php echo $wp_carousel_txt['2']; ?></p></div>
       
    <form method="post" action="">
		    
    <table class="form-table">
	<tbody>

    <tr valign="top">
    <td colspan="2"><h2><?php echo $wp_carousel_txt['1']; ?></h2></td>
    </tr>
	
	<fieldset>
    <tr valign="top">
    <th scope="row"><label for="wp_carousel_options_lang"><?php echo $wp_carousel_txt['3']; ?></label></th>
    <td><select name="wp_carousel_options_lang"><option value="en" id="en" <?php if($wp_carousel_options_lang == 'en') { echo 'selected="selected" '; } ?>><?php echo $wp_carousel_txt['4']; ?></option><option value="es" id="es" <?php if($wp_carousel_options_lang == 'es') { echo 'selected="selected" '; } ?>><?php echo $wp_carousel_txt['5']; ?></option></select></td>	
    </tr>
	
	</fieldset>
	
	<tr valign="top">
    <td colspan="2"><h2><?php echo $wp_carousel_txt['6']; ?></h2></td>
    </tr>
	
	<fieldset>
    <tr valign="top">
    <th scope="row"><label for="wp_carousel_carousels"><?php echo $wp_carousel_txt['6']; ?></label></th>
    <td><input type="text" name="wp_carousel_carousels" id="wp_carousel_carousels" value="<?php echo $wp_carousel_carousels; ?>" /></td>	
    </tr>
	
	</fieldset>
	
	</tbody>
	</table>
    
    
    <p class="submit">
	<input name="sumolari_action" value="sumolari_update_settings" type="hidden">
	<input name="action" value="update" type="hidden">
    <input type="submit" name="Submit" class="button-primary" value="<?php echo $wp_carousel_txt['7']; ?>" />
    </p>
    
    </form>
	
	</div>
    
    <?php
	}
		
	function wp_carousel_crear_pagina_opciones() {
		global $wp_carousel_txt;
		
		$carousel_id = explode("-", $_GET['page']);
		$carousel_id = $carousel_id[1];	
		
		$wp_carousel_options_serialized = get_option('wp_carousel_options');
		$wp_carousel_options = unserialize($wp_carousel_options_serialized);
		$wp_carousel_orig_options = $wp_carousel_options;
		
		/*echo '<pre>';
		print_r($wp_carousel_orig_options);
		echo '</pre>';*/
				
		$wp_carousel_options_lang = $wp_carousel_options['lang'];
		$wp_carousel_carousels = $wp_carousel_options['carousels'];
	
		if (isset($_GET['updated'])) {
			echo '<div id="message" class="updated fade"><p>'.__('Settings updated.', 'kubrick').'</p></div>';
		}
		
		if (isset($_POST['Submit'])) {
			
			/*echo '<pre>';
			print_r($_POST);
			echo '</pre>';*/
			
			$wp_carousel_post_cat_id = $_POST['wp_carousel_post_cat_id'];
			$wp_carousel_post_num = $_POST['wp_carousel_post_num'];
			$wp_carousel_post_link_txt = $_POST['wp_carousel_post_link_txt'];
			$wp_carousel_autostep = $_POST['wp_carousel_autostep'];
			$wp_carousel_autostep_time = $_POST['wp_carousel_autostep_time'];
			$wp_carousel_autostep_num = $_POST['wp_carousel_autostep_num'];
			$wp_carousel_step_num = $_POST['wp_carousel_step_num'];
			
			$wp_carousel_panel_width = $_POST['wp_carousel_panel_width'];
			$wp_carousel_panel_width_unit = $_POST['wp_carousel_panel_width_unit'];
			$wp_carousel_image_same_width = $_POST['wp_carousel_image_same_width'];
			$wp_carousel_image_more_height = $_POST['wp_carousel_image_more_height'];
			$wp_carousel_image_more_height_h = $_POST['wp_carousel_image_more_height_h'];
			$wp_carousel_image_more_height_h_unit = $_POST['wp_carousel_image_more_height_h_unit'];
			$wp_carousel_step_num = $_POST['wp_carousel_step_num'];
			
			$wp_carousel_content_order = $_POST['wp_carousel_content_order'];
			
			$wp_carousel_options = array (
				
				'lang' => $wp_carousel_options_lang,
				'carousels' => $wp_carousel_carousels
				
			);			
			
			$n = 1;
				
			do {
				$wp_carousel_options['carousel_'.$n.'']['cat_id'] = $wp_carousel_orig_options['carousel_'.$n.'']['cat_id'];
				$wp_carousel_options['carousel_'.$n.'']['post_num'] = $wp_carousel_orig_options['carousel_'.$n.'']['post_num'];
				$wp_carousel_options['carousel_'.$n.'']['post_link_txt'] = $wp_carousel_orig_options['carousel_'.$n.'']['post_link_txt'];
				$wp_carousel_options['carousel_'.$n.'']['autostep'] = $wp_carousel_orig_options['carousel_'.$n.'']['autostep'];
				$wp_carousel_options['carousel_'.$n.'']['autostep_time'] = $wp_carousel_orig_options['carousel_'.$n.'']['autostep_time'];
				$wp_carousel_options['carousel_'.$n.'']['autostep_num'] = $wp_carousel_orig_options['carousel_'.$n.'']['autostep_num'];
				$wp_carousel_options['carousel_'.$n.'']['step_num'] = $wp_carousel_orig_options['carousel_'.$n.'']['step_num'];
		
				$wp_carousel_options['carousel_'.$n.'']['panel_width'] = $wp_carousel_orig_options['carousel_'.$n.'']['panel_width'];
				$wp_carousel_options['carousel_'.$n.'']['panel_width_unit'] = $wp_carousel_orig_options['carousel_'.$n.'']['panel_width_unit'];
				$wp_carousel_options['carousel_'.$n.'']['image_same_width'] = $wp_carousel_orig_options['carousel_'.$n.'']['image_same_width'];
				$wp_carousel_options['carousel_'.$n.'']['image_more_height'] = $wp_carousel_orig_options['carousel_'.$n.'']['image_more_height'];
				$wp_carousel_options['carousel_'.$n.'']['image_more_height_h'] = $wp_carousel_orig_options['carousel_'.$n.'']['image_more_height_h'];
				$wp_carousel_options['carousel_'.$n.'']['image_more_height_h_unit'] = $wp_carousel_orig_options['carousel_'.$n.'']['image_more_height_h_unit'];
				
				$wp_carousel_options['carousel_'.$n.'']['content_order'] = $wp_carousel_orig_options['carousel_'.$n.'']['content_order'];
				
				$m = 1;
				while (isset($wp_carousel_orig_options['carousel_'.$n.'']['costumized_content_'.$m.'']['image_url'])) {
					$wp_carousel_options['carousel_'.$n.'']['costumized_content_'.$m.'']['image_url'] = $wp_carousel_orig_options['carousel_'.$n.'']['costumized_content_'.$m.'']['image_url'];
					$wp_carousel_options['carousel_'.$n.'']['costumized_content_'.$m.'']['link_url'] = $wp_carousel_orig_options['carousel_'.$n.'']['costumized_content_'.$m.'']['link_url'];
					$wp_carousel_options['carousel_'.$n.'']['costumized_content_'.$m.'']['text'] = $wp_carousel_orig_options['carousel_'.$n.'']['costumized_content_'.$m.'']['text'];
					$wp_carousel_options['carousel_'.$n.'']['costumized_content_'.$m.'']['order'] = $wp_carousel_orig_options['carousel_'.$n.'']['costumized_content_'.$m.'']['order'];
					$m++;
				}

				$n++;
			} while (isset($wp_carousel_orig_options['carousel_'.$n.'']['cat_id']));
			
			if (isset($_POST['wp_carousel_more_content_1_link_url'])) {
				
				$n = 1;
				
				do {
					$wp_carousel_options['carousel_'.$carousel_id.'']['costumized_content_'.$n.'']['image_url'] = $_POST['wp_carousel_more_content_'.$n.'_image_url'];
					$wp_carousel_options['carousel_'.$carousel_id.'']['costumized_content_'.$n.'']['link_url'] = $_POST['wp_carousel_more_content_'.$n.'_link_url'];
					$wp_carousel_options['carousel_'.$carousel_id.'']['costumized_content_'.$n.'']['text'] = $_POST['wp_carousel_more_content_'.$n.'_text'];
					$wp_carousel_options['carousel_'.$carousel_id.'']['costumized_content_'.$n.'']['order'] = $_POST['wp_carousel_more_content_'.$n.'_order'];
					$n++;
				} while (isset($_POST['wp_carousel_more_content_'.$n.'_link_url']));
															
			}
			
			$wp_carousel_options['carousel_'.$carousel_id.'']['cat_id'] = $wp_carousel_post_cat_id;
			$wp_carousel_options['carousel_'.$carousel_id.'']['post_num'] = $wp_carousel_post_num;
			$wp_carousel_options['carousel_'.$carousel_id.'']['post_link_txt'] = $wp_carousel_post_link_txt;
			$wp_carousel_options['carousel_'.$carousel_id.'']['autostep'] = $wp_carousel_autostep;
			$wp_carousel_options['carousel_'.$carousel_id.'']['autostep_time'] = $wp_carousel_autostep_time;
			$wp_carousel_options['carousel_'.$carousel_id.'']['autostep_num'] = $wp_carousel_autostep_num;
			$wp_carousel_options['carousel_'.$carousel_id.'']['step_num'] = $wp_carousel_step_num;
				
			$wp_carousel_options['carousel_'.$carousel_id.'']['panel_width'] = $wp_carousel_panel_width;
			$wp_carousel_options['carousel_'.$carousel_id.'']['panel_width_unit'] = $wp_carousel_panel_width_unit;
			$wp_carousel_options['carousel_'.$carousel_id.'']['image_same_width'] = $wp_carousel_image_same_width;
			$wp_carousel_options['carousel_'.$carousel_id.'']['image_more_height'] = $wp_carousel_image_more_height;
			$wp_carousel_options['carousel_'.$carousel_id.'']['image_more_height_h'] = $wp_carousel_image_more_height_h;
			$wp_carousel_options['carousel_'.$carousel_id.'']['image_more_height_h_unit'] = $wp_carousel_image_more_height_h_unit;
			
			$wp_carousel_options['carousel_'.$carousel_id.'']['content_order'] = $wp_carousel_content_order;
			
			$wp_carousel_options_serialized = serialize($wp_carousel_options);
			
			update_option('wp_carousel_options', $wp_carousel_options_serialized);
			
			if(get_option('wp_carousel_post_cat_id') == '') { update_option('wp_carousel_post_cat_id', 0); }
			if(get_option('wp_carousel_post_num') == '') { update_option('wp_carousel_post_num', 0); }
			if(get_option('wp_carousel_autostep_time') == '') { update_option('wp_carousel_autostep_time', '3000'); }
			if(get_option('wp_carousel_autostep_num') == '') { update_option('wp_carousel_autostep_num', '1'); }
			
			if(get_option('wp_carousel_panel_width') == '') { update_option('wp_carousel_panel_width', '360'); }
			if(get_option('wp_carousel_step_num') == '') { update_option('wp_carousel_step_num', '1'); }
			if(get_option('wp_carousel_image_more_height_h') == '') { update_option('wp_carousel_image_more_height_h', 150); }
									
		}
											
		$wp_carousel_post_cat_id = $wp_carousel_options['carousel_'.$carousel_id.'']['cat_id'];
		$wp_carousel_post_num = $wp_carousel_options['carousel_'.$carousel_id.'']['post_num'];
		$wp_carousel_post_link_txt = $wp_carousel_options['carousel_'.$carousel_id.'']['post_link_txt'];
		$wp_carousel_autostep = $wp_carousel_options['carousel_'.$carousel_id.'']['autostep'];
		$wp_carousel_autostep_time = $wp_carousel_options['carousel_'.$carousel_id.'']['autostep_time'];
		$wp_carousel_autostep_num = $wp_carousel_options['carousel_'.$carousel_id.'']['autostep_num'];
		$wp_carousel_step_num = $wp_carousel_options['carousel_'.$carousel_id.'']['step_num'];
		
		$wp_carousel_panel_width = $wp_carousel_options['carousel_'.$carousel_id.'']['panel_width'];
		$wp_carousel_panel_width_unit = $wp_carousel_options['carousel_'.$carousel_id.'']['panel_width_unit'];
		$wp_carousel_image_same_width = $wp_carousel_options['carousel_'.$carousel_id.'']['image_same_width'];
		$wp_carousel_image_more_height = $wp_carousel_options['carousel_'.$carousel_id.'']['image_more_height'];
		$wp_carousel_image_more_height_h = $wp_carousel_options['carousel_'.$carousel_id.'']['image_more_height_h'];
		$wp_carousel_image_more_height_h_unit = $wp_carousel_options['carousel_'.$carousel_id.'']['image_more_height_h_unit'];
		
		$wp_carousel_content_order = $wp_carousel_options['carousel_'.$carousel_id.'']['content_order'];

	?>
		
	<div class="wrap">
    <h2>WP Carousel</h2>
		
	<div id="message" class="updated"><p><?php echo $wp_carousel_txt['9']; ?> <code>&lt;?php wp_carousel('<?php echo $carousel_id; ?>'); ?&gt;</code> <?php echo $wp_carousel_txt['10']; ?></p></div>
    
    <p><?php echo $wp_carousel_txt['11']; ?></p>
   
    <form method="post" action="">
		
    <?php //wp_nonce_field('update-options'); ?>
    
    <table class="form-table">
	<tbody>

    <tr valign="top">
    <td colspan="2"><h2><?php echo $wp_carousel_txt['12']; ?></h2></td>
    </tr>
	
	<fieldset>
    <tr valign="top">
    <th scope="row"><label for="wp_carousel_post_cat_id"><?php echo $wp_carousel_txt['13']; ?></label></th>
    <td><input name="wp_carousel_post_cat_id" id="wp_carousel_post_cat_id" value="<?php echo $wp_carousel_post_cat_id; ?>" /></td>
    </tr>
	
	<tr valign="top">
    <th scope="row"><label for="wp_carousel_post_num"><?php echo $wp_carousel_txt['14']; ?></label></th>
    <td><input name="wp_carousel_post_num" id="wp_carousel_post_num" value="<?php echo $wp_carousel_post_num; ?>" /></td>
    </tr>
	
	<tr valign="top">
    <th scope="row"><label for="wp_carousel_post_link_txt"><?php echo $wp_carousel_txt['15']; ?></label></th>
    <td><input name="wp_carousel_post_link_txt" id="wp_carousel_post_link_txt" value="<?php echo $wp_carousel_post_link_txt; ?>" /></td>
    </tr>
	
	<tr valign="top">
    <th scope="row"><label for="wp_carousel_content_order"><?php echo $wp_carousel_txt['16']; ?></label></th>
    <td><select name="wp_carousel_content_order"><option value="posts" id="posts" <?php if($wp_carousel_content_order == 'posts') { echo 'selected="selected" '; } ?>><?php echo $wp_carousel_txt['17']; ?></option><option value="costumized" id="costumized" <?php if($wp_carousel_content_order == 'costumized') { echo 'selected="selected" '; } ?>><?php echo $wp_carousel_txt['18']; ?></option></select></td>
    </tr>
	
	<tr valign="top">
	<th scope="row" colspan="2">
	<a href="#" id="wp_carousel_toggle_1_l"><?php echo $wp_carousel_txt['19']; ?></a>
	</th>
	</tr>
	
	<tr valign="top" class="wp_carousel_toggle_1_c">
    <th scope="row"><label for="wp_carousel_autostep"><?php echo $wp_carousel_txt['20']; ?></label></th>
    <td><select name="wp_carousel_autostep"><option value="yes" id="yes" <?php if($wp_carousel_autostep == 'yes') { echo 'selected="selected" '; } ?>><?php echo $wp_carousel_txt['21']; ?></option><option value="no" id="no" <?php if($wp_carousel_autostep == 'no') { echo 'selected="selected" '; } ?>>No</option></select>
	
		<table class="form-table">
	
		<tr valign="top">
		<th scope="row"><label for="wp_carousel_autostep_time"><?php echo $wp_carousel_txt['22']; ?></label></th>
		<td><input name="wp_carousel_autostep_time" id="wp_carousel_autostep_time" value="<?php echo $wp_carousel_autostep_time; ?>" /></td>
		</tr>
		
		<tr valign="top">
		<th scope="row"><label for="wp_carousel_autostep_num"><?php echo $wp_carousel_txt['23']; ?></label></th>
		<td><input name="wp_carousel_autostep_num" id="wp_carousel_autostep_num" value="<?php echo $wp_carousel_autostep_num; ?>" /></td>
		</tr>
		
		</table>
	
	</td>
    </tr>	
	
	<tr valign="top" class="wp_carousel_toggle_1_c">
    <th scope="row"><label for="wp_carousel_step_num"><?php echo $wp_carousel_txt['24']; ?></label></th>
    <td><input name="wp_carousel_step_num" id="wp_carousel_step_num" value="<?php echo $wp_carousel_step_num; ?>" /></td>
    </tr>
	
	</fieldset>
	
	<tr valign="top">
    <td colspan="2"><h2><?php echo $wp_carousel_txt['25']; ?></h2></td>
    </tr>
	
	<fieldset>
	
    <tr valign="top">
    <th scope="row"><label for="wp_carousel_panel_width"><?php echo $wp_carousel_txt['26']; ?></label></th>
    <td><input name="wp_carousel_panel_width" id="wp_carousel_panel_width" value="<?php echo $wp_carousel_panel_width; ?>" /> <select name="wp_carousel_panel_width_unit"><option value="px" id="px" <?php if($wp_carousel_panel_width_unit == 'px') { echo 'selected="selected" '; } ?>>Px</option><option value="percent" id="percent" <?php if($wp_carousel_panel_width_unit == 'percent') { echo 'selected="selected" '; } ?>>%</option></select></td>
	</tr>
	
	<tr valign="top">
	<th scope="row" colspan="2">
	<a href="#" id="wp_carousel_toggle_2_l"><?php echo $wp_carousel_txt['19']; ?></a>
	</th>
	</tr>
	
	<tr valign="top" class="wp_carousel_toggle_2_c">
    <th scope="row"><label for="wp_carousel_image_same_width"><?php echo $wp_carousel_txt['27']; ?></label></th>
    <td><select name="wp_carousel_image_same_width"><option value="yes" id="yes" <?php if($wp_carousel_image_same_width == 'yes') { echo 'selected="selected" '; } ?>><?php echo $wp_carousel_txt['21']; ?></option><option value="no" id="no" <?php if($wp_carousel_image_same_width == 'no') { echo 'selected="selected" '; } ?>>No</option></select></td>
	</tr>
	
	<tr valign="top" class="wp_carousel_toggle_2_c">
    <th scope="row"><label for="wp_carousel_image_more_height"><?php echo $wp_carousel_txt['28']; ?></label></th>
    <td><select name="wp_carousel_image_more_height"><option value="yes" id="yes" <?php if($wp_carousel_image_more_height == 'yes') { echo 'selected="selected" '; } ?>><?php echo $wp_carousel_txt['21']; ?></option><option value="no" id="no" <?php if($wp_carousel_image_more_height == 'no') { echo 'selected="selected" '; } ?>>No</option></select>
	
		<table class="form-table">
	
		<tr valign="top">
		<th scope="row"><label for="wp_carousel_image_more_height_h"><?php echo $wp_carousel_txt['29']; ?></label></th>
		<td><input name="wp_carousel_image_more_height_h" id="wp_carousel_image_more_height_h" value="<?php echo $wp_carousel_image_more_height_h; ?>" /> <select name="wp_carousel_image_more_height_h_unit"><option value="px" id="px" <?php if($wp_carousel_image_more_height_h_unit == 'px') { echo 'selected="selected" '; } ?>>Px</option><option value="percent" id="percent" <?php if($wp_carousel_image_more_height_h_unit == 'percent') { echo 'selected="selected" '; } ?>>%</option></select></td>
		</tr>
		
		</table>
	</td>
	</tr>
	
	</fieldset>
	
	<tr valign="top">
    <td colspan="2"><h2><?php echo $wp_carousel_txt['30']; ?></h2></td>
    </tr>
	
	<fieldset>
	
	<?php 
	
		$wp_carousel_more_content = $wp_carousel_options['carousel_'.$carousel_id.''];
	
		$n = 1;
		do {
	?>	
    <tr valign="top" class="wp_carousel_more_content" title="<?php echo $n; ?>">
	
		<th scope="row">
		
			<h3><?php echo $wp_carousel_txt['18']; ?> #<?php echo $n; ?></h3>
		
		</th>
		
		<td>
			
		<table class="form">
		
		<tr valign="top">
	
			<th scope="row"><label for="wp_carousel_more_content_<?php echo $n; ?>_image_url"><?php echo $wp_carousel_txt['31']; ?></label></th>
			<td><input name="wp_carousel_more_content_<?php echo $n; ?>_image_url" id="wp_carousel_more_content_<?php echo $n; ?>_image_url" value="<?php echo $wp_carousel_more_content['costumized_content_'.$n.'']['image_url']; ?>" /></td>
	
		</tr>
		
		<tr valign="top">
	
			<th scope="row"><label for="wp_carousel_more_content_<?php echo $n; ?>_link_url"><?php echo $wp_carousel_txt['32']; ?></label></th>
			<td><input name="wp_carousel_more_content_<?php echo $n; ?>_link_url" id="wp_carousel_more_content_<?php echo $n; ?>_link_url" value="<?php echo $wp_carousel_more_content['costumized_content_'.$n.'']['link_url']; ?>" /></td>
	
		</tr>
		
		<tr valign="top">
	
			<th scope="row"><label for="wp_carousel_more_content_<?php echo $n; ?>_text"><?php echo $wp_carousel_txt['33']; ?></label></th>
			<td><textarea name="wp_carousel_more_content_<?php echo $n; ?>_text" id="wp_carousel_more_content_<?php echo $n; ?>_text"><?php echo $wp_carousel_more_content['costumized_content_'.$n.'']['text']; ?></textarea></td>
	
		</tr>
		
		<tr valign="top">
	
			<th scope="row"><label for="wp_carousel_more_content_<?php echo $n; ?>_order"><?php echo $wp_carousel_txt['34']; ?></label></th>
			<td><input name="wp_carousel_more_content_<?php echo $n; ?>_order" id="wp_carousel_more_content_<?php echo $n; ?>_order" value="<?php echo $wp_carousel_more_content['costumized_content_'.$n.'']['order']; ?>" /></td>
	
		</tr>
		
	
		</table>
		
		</td>
	
	</tr>
	<?php
			$n++;
		} while ($wp_carousel_more_content['costumized_content_'.$n.'']['image_url'] != '');
	?>
	
	<tr valign="top">
	<th scope="row" colspan="2">
	<a href="#wp_carousel_more_personalized_content" id="wp_carousel_more_personalized_content"><?php echo $wp_carousel_txt['35']; ?></a> <?php echo $wp_carousel_txt['36']; ?>
	</th>
	</tr>
		
	</fieldset>
	
	</tbody>
	</table>
    
	<p><?php echo $wp_carousel_txt['2']; ?></p>

    
    <p class="submit">
	<input name="sumolari_action" value="sumolari_update_settings" type="hidden">
	<input name="action" value="update" type="hidden">
    <input type="submit" name="Submit" class="button-primary" value="<?php echo $wp_carousel_txt['7']; ?>" />
    </p>
    
    </form>
	
	</div>
    
    <?php
	}
	
	class WP_Carousel_Widget extends WP_Widget {
	
		function WP_Carousel_Widget() {
			parent::WP_Widget(false, $name = 'WP Carousel Widget');	
		}
	
		function widget($args, $instance) {		
			extract( $args );
			?>
				  <?php echo $before_widget; ?>
				  <?php wp_carousel($instance['id']); ?>
				  <?php echo $after_widget;  ?>
			<?php
		}
	
		function update($new_instance, $old_instance) {				
			return $new_instance;
		}
	
		function form($instance) {
			global $wp_carousel_txt;
			$id = esc_attr($instance['id']);
			?>
				<p><label for="<?php echo $this->get_field_id('id'); ?>"><?php echo $wp_carousel_txt['38']; ?> <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo $id; ?>" /></label></p>
			<?php 
		}
	
	}

	add_action('widgets_init', create_function('', 'return register_widget("WP_Carousel_Widget");'));

?>