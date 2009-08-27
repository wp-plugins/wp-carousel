<?php
	$path_1 = plugin_basename(__FILE__);
	
	$path_2 = ereg_replace('/carousel-css.php', '', $path_1);
	
	/* Pre 2.6 */
	
	if (!defined( 'WP_CONTENT_URL' ) )
		define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
	if (!defined( 'WP_PLUGIN_URL' ) )
		define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
		
	$wp_carousel_options_serialized = get_option('wp_carousel_options');
	
	$wp_carousel_options = unserialize($wp_carousel_options_serialized);
					
	$panel_width = $wp_carousel_options['carousel_1']['panel_width'];
	$panel_width_unit = $wp_carousel_options['carousel_1']['panel_width_unit'];
					
	$panel_height = $wp_carousel_options['carousel_1']['image_more_height_h'];
	$panel_height_unit = $wp_carousel_options['carousel_1']['image_more_height_h_unit'];
	
	$wp_carousel_carousels = $wp_carousel_options['carousels'];
		
?>
/* Carousel de artículos destacados */
					
			.wp_carousel {
				position: relative; /* No edit */
				margin:10px 0 10px 0;
				min-height: 250px;
				background:#5B5B5B url(<?php echo '', WP_PLUGIN_URL ,'/'.$path_2.'/'; ?>img/carousel-bg.png) bottom left repeat-x;
			}
			
			.wp_carousel .belt {
				position: absolute; /* No edit */
				left: 0;
				top: 0;
			}
			
			.wp_carousel .panel {
				float: left; /* No edit */
				overflow: hidden; /* No edit */
				margin:4px;
				padding:7px;
				border:1px solid #5B5B5B;
				background:#383838 url(<?php echo '', WP_PLUGIN_URL ,'/'.$path_2.'/'; ?>img/carousel-panel-bg.png) bottom left repeat-x;
				-moz-border-radius:5px;
			}
			
			.wp_carousel .panel .panel-text {
				padding-top:5px;
				font-size:13px;
				font-family:Verdana, Geneva, sans-serif;
				color:#FFF;
			}
			
			.wp_carousel .panel .panel-text a {
				color:#CCC;
				text-decoration:none;
			}
			
			.wp_carousel .panel .panel-text a:hover {
				color:#FFF;
				text-decoration:underline;
			}
			
						/* Botones del carousel */
						
			.button-prev {
				margin:10px 0 10px 0;
				min-height:250px;
				width:35px;
				float:left;
				background:#5B5B5B url(<?php echo '', WP_PLUGIN_URL ,'/'.$path_2.'/'; ?>img/carousel-bg.png) bottom left repeat-x;
				-moz-border-radius:10px 0 0 10px;
			}
			
			.button-prev a {
				display:block;
				padding:5px;
			}
			
			.button-next {
				margin:10px 0 10px 0;
				min-height:250px;
				width:35px;
				float:right;
				background:#5B5B5B url(<?php echo '', WP_PLUGIN_URL ,'/'.$path_2.'/'; ?>img/carousel-bg.png) bottom left repeat-x;
				-moz-border-radius:0 10px 10px 0;
			}
			
			.button-next a {
				display:block;
				padding:5px;
			}
			
					/* Widget de Carrusel */
					
			.widget_wp_carousel_widget .wp_carousel .panel {
				width:96px;
			}
			
			.widget_wp_carousel_widget .button-prev, .widget_wp_carousel_widget .button-next {
				margin:0px 0 0 0;
			}
			
					/* Estilos únicos de cada carrusel */			
					
<?php
		
	$n = 0;
	while ($wp_carousel_carousels > $n) {
		$n++;
?>
		
		#wp_carousel_<?php echo $n; ?>.wp_carousel.carousel, #wp_carousel_<?php echo $n; ?>.wp_carousel.carousel .belt, .button-next.carousel_<?php echo $n; ?>, .button-prev.carousel_<?php echo $n; ?> {
			<?php 
			if($panel_height != '') {
				?>
				height: <?php if ($panel_height_unit == 'px') { echo $panel_height+25; } else { echo $panel_height+3; } ?><?php if ($panel_height_unit == 'px') { echo 'px'; } elseif ($panel_height_unit == 'percent') { echo '%'; } else { echo 'px'; } echo ';';
			} else { echo 'height: 250px;'; } ?>
		}
		
		.button-prev.carousel_<?php echo $n; ?> a, .button-next.carousel_<?php echo $n; ?> a {
			margin-top: <?php if ($panel_height != '') { $ph = $panel_height - 35; $ph = $ph / 2; echo $ph; } else { echo '105'; } ?>px;
		}
		
		#wp_carousel_<?php echo $n; ?>.wp_carousel.carousel .belt .panel {
			<?php 
			if($panel_height != '') {
				?>
				height: <?php echo $panel_height; ?><?php if ($panel_height_unit == 'px') { echo 'px'; } elseif ($panel_height_unit == 'percent') { echo '%'; } else { echo 'px'; } echo ';';
			} else { echo 'height: 250px;'; } 
			
			if($panel_width != '') { ?>
			width: <?php echo $panel_width; ?><?php if ($panel_width_unit == 'px') { echo 'px'; } elseif ($panel_width_unit == 'percent') { echo '%'; } else { echo 'px'; } echo ';';
			} else { 
				echo 'width: 360px;'; 
			} ?>
		}
		
<?php
	}
?>