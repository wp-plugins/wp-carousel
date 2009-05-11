<?php

	/*
		Plugin Name: WP Carousel
		Plugin URI: http://sumolari.com/?p=1759
		Description: A simple post carousel for WordPress
		Version: 0.2
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
	
	function wp_carousel() {
		
		global $path_2;
	?>
		<?php $category_carousel = get_option('wp_carousel_post_cat_id'); ?>
		<?php $num_carousel = get_option('wp_carousel_post_num'); ?>
		<?php $step_num = get_option('wp_carousel_step_num'); ?>
		
		<?php if($category_carousel != 0 && $num_carousel != 0) { ?>
		
		<div class="button-next">
			<a href="javascript:stepcarousel.stepBy('wp_carousel', <?php echo $step_num; ?>)"><img src="<?php echo '', WP_PLUGIN_URL ,'/'.$path_2.'/'; ?>img/arrow_right.png" /></a>
		</div>
		
		<div class="button-prev">
			<a href="javascript:stepcarousel.stepBy('wp_carousel', -<?php echo $step_num; ?>)"><img src="<?php echo '', WP_PLUGIN_URL ,'/'.$path_2.'/'; ?>img/arrow_left.png" /></a>
		</div>
		
		<div id="wp_carousel" class="carousel">
			
			<div class="belt">
			
				<?php $txt_link_carousel = get_option('wp_carousel_post_link_txt'); ?>
				<?php $carousel_posts = new WP_Query('cat='.$category_carousel.'&showposts='.$num_carousel.''); ?>	
			
				<?php while ($carousel_posts->have_posts()) : $carousel_posts->the_post(); ?>
			
				<div class="panel">
					<a href="<?php echo get_permalink(); ?>"><img src="<?php echo wp_carousel_first_image(); ?>"  width="265px" height="150px"/></a>
					<div class="panel-text">
						 <?php the_excerpt(); ?> 
						 <?php
							echo '<p><a href="'. get_permalink() .'">'.$txt_link_carousel.'</a></p>';
						?>
					</div>
				</div>
				
				<?php endwhile; ?>
			
			</div>
		</div>
	<?php
		}
	}
	
	add_action('wp_head', 'wp_carousel_link_js_files');
		
	add_action('admin_menu', 'crear_link_wp_carousel');

	function crear_link_wp_carousel() {
		add_options_page(__('WP Carousel'), __('WP Carousel'), 'edit_themes', basename(__FILE__), 'wp_carousel_crear_pagina_opciones');
	}
		
	function wp_carousel_crear_pagina_opciones() {
	
		if (isset($_GET['updated'])) {
			echo '<div id="message" class="updated fade"><p>'.__('Settings updated.', 'kubrick').'</p></div>';
		}
		
		if (isset($_POST['wp_carousel_post_cat_id'])) {
			
			update_option('wp_carousel_post_cat_id', $_POST['wp_carousel_post_cat_id']);
			update_option('wp_carousel_post_num', $_POST['wp_carousel_post_num']);
			update_option('wp_carousel_post_link_txt', $_POST['wp_carousel_post_link_txt']);
			update_option('wp_carousel_autostep', $_POST['wp_carousel_autostep']);
			update_option('wp_carousel_autostep_time', $_POST['wp_carousel_autostep_time']);
			update_option('wp_carousel_autostep_num', $_POST['wp_carousel_autostep_num']);
			update_option('wp_carousel_step_num', $_POST['wp_carousel_step_num']);
						
			update_option('wp_carousel_panel_width', $_POST['wp_carousel_panel_width']);
			update_option('wp_carousel_panel_width_unit', $_POST['wp_carousel_panel_width_unit']);
			
			if(get_option('wp_carousel_post_cat_id') == '') { update_option('wp_carousel_post_cat_id', 0); }
			if(get_option('wp_carousel_post_num') == '') { update_option('wp_carousel_post_num', 0); }
			
			if(get_option('wp_carousel_panel_width') == '') { update_option('wp_carousel_panel_width', '360'); }
			if(get_option('wp_carousel_panel_width_unit') == '') { update_option('wp_carousel_post_num', 'px'); }
			if(get_option('wp_carousel_step_num') == '') { update_option('wp_carousel_step_num', '1'); }
									
		}
	?>
		
	<div class="wrap">
    <h2>WP Carousel</h2>
	
	<div id="message" class="updated"><p><strong>Note:</strong> To add the Carousel, add <code>&lt;?php wp_carousel(); ?&gt;</code> to your theme.</p></div>
    
    <p>You can edit WP Carousel's options here.</p>
   
    <form method="post" action="">
		
    <?php //wp_nonce_field('update-options'); ?>
    
    <table class="form-table">
	<tbody>

    <tr valign="top">
    <td colspan="2"><h2>Carousel Options</h2></td>
    </tr>
	
	<fieldset>
    <tr valign="top">
    <th scope="row"><label for="wp_carousel_post_cat_id">Carousel posts's category ID</label></th>
    <td><input name="wp_carousel_post_cat_id" id="wp_carousel_post_cat_id" value="<?php echo get_option('wp_carousel_post_cat_id'); ?>" /></td>
    </tr>
	
	<tr valign="top">
    <th scope="row"><label for="wp_carousel_post_num">Number of posts to display</label></th>
    <td><input name="wp_carousel_post_num" id="wp_carousel_post_num" value="<?php echo get_option('wp_carousel_post_num'); ?>" /></td>
    </tr>
	
	<tr valign="top">
    <th scope="row"><label for="wp_carousel_post_link_txt">Text for the "Read More" links</label></th>
    <td><input name="wp_carousel_post_link_txt" id="wp_carousel_post_link_txt" value="<?php echo get_option('wp_carousel_post_link_txt'); ?>" /></td>
    </tr>
	
	<tr valign="top">
    <th scope="row"><label for="wp_carousel_autostep">Slide automatically?</label></th>
    <td><select name="wp_carousel_autostep"><option value="yes" id="yes" <?php if(get_option('wp_carousel_autostep') == 'yes') { echo 'selected="selected" '; } ?>>Yes</option><option value="no" id="no" <?php if(get_option('wp_carousel_autostep') == 'no') { echo 'selected="selected" '; } ?>>No</option></select>
	
		<table class="form-table">
	
		<tr valign="top">
		<th scope="row"><label for="wp_carousel_autostep_time">Time between automatic slide (in ms)</label></th>
		<td><input name="wp_carousel_autostep_time" id="wp_carousel_autostep_time" value="<?php echo get_option('wp_carousel_autostep_time'); ?>" /></td>
		</tr>
		
		<tr valign="top">
		<th scope="row"><label for="wp_carousel_autostep_num">Number of posts to slide in each automatic slide</label></th>
		<td><input name="wp_carousel_autostep_num" id="wp_carousel_autostep_num" value="<?php echo get_option('wp_carousel_autostep_num'); ?>" /></td>
		</tr>
		
		</table>
	
	</td>
    </tr>	
	
	<tr valign="top">
    <th scope="row"><label for="wp_carousel_step_num">Number of posts to slide in each manual slide</label></th>
    <td><input name="wp_carousel_step_num" id="wp_carousel_step_num" value="<?php echo get_option('wp_carousel_step_num'); ?>" /></td>
    </tr>
	
	</fieldset>
	
	<tr valign="top">
    <td colspan="2"><h2>Design options</h2></td>
    </tr>
	
	<fieldset>
	
    <tr valign="top">
    <th scope="row"><label for="wp_carousel_panel_width">Carousel posts's panel width (first, <strong>width</strong>; second, <strong>unit</strong>)</label></th>
    <td><input name="wp_carousel_panel_width" id="wp_carousel_panel_width" value="<?php echo get_option('wp_carousel_panel_width'); ?>" /> <select name="wp_carousel_panel_width_unit"><option value="px" id="px" <?php if(get_option('wp_carousel_panel_width_unit') == 'px') { echo 'selected="selected" '; } ?>>Px</option><option value="%" id="percent" <?php if(get_option('wp_carousel_panel_width_unit') == 'percent') { echo 'selected="selected" '; } ?>>%</option></select></td>
	</tr>
	
	</fieldset>
	
	</tbody>
	</table>
    
	<p>Do you have any problem? You can find the tutorials in <a href="http://sumolari.com/plugins-temas/wp-carousel/#tutoriales">this page</a>.</p>

    
    <p class="submit">
	<input name="sumolari_action" value="sumolari_update_settings" type="hidden">
	<input name="action" value="update" type="hidden">
    <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
    
    </form>
	
	</div>
    
    <?php
	}
?>