<?php
	$path_1 = plugin_basename(__FILE__);
	
	$path_2 = ereg_replace('/carousel-css.php', '', $path_1);
	
	/* Pre 2.6 */
	
	if (!defined( 'WP_CONTENT_URL' ) )
		define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
	if (!defined( 'WP_PLUGIN_URL' ) )
		define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
?>
/* Carousel de artículos destacados */
					
			.wp_carousel {
				position: relative; /* No edit */
				margin:10px 0 10px 0;
				height: 250px;
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
				<?php
					$wp_carousel_options_serialized = get_option('wp_carousel_options');
			
					$wp_carousel_options = unserialize($wp_carousel_options_serialized);
					
					$panel_width = $wp_carousel_options['carousel_1']['panel_width'];
					$panel_width_unit = $wp_carousel_options['carousel_1']['panel_width_unit'];
					
					if($panel_width != '') {
				?>
				width: <?php echo $panel_width; ?><?php if ($panel_width_unit == 'px') { echo 'px'; } elseif ($panel_width_unit == 'percent') { echo '%'; } else { echo 'px'; } ?>;
				<?php } else { echo 'width: 360px;'; }?>
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
				height:250px;
				width:35px;
				float:left;
				background:#5B5B5B url(<?php echo '', WP_PLUGIN_URL ,'/'.$path_2.'/'; ?>img/carousel-bg.png) bottom left repeat-x;
				-moz-border-radius:10px 0 0 10px;
			}
			
			.button-prev a {
				display:block;
				padding:5px;
				margin-top:105px;
			}
			
			.button-next {
				margin:10px 0 10px 0;
				height:250px;
				width:35px;
				float:right;
				background:#5B5B5B url(<?php echo '', WP_PLUGIN_URL ,'/'.$path_2.'/'; ?>img/carousel-bg.png) bottom left repeat-x;
				-moz-border-radius:0 10px 10px 0;
			}
			
			.button-next a {
				display:block;
				padding:5px;
				margin-top:105px;
			}
			
					/* Widget de Carrusel */
					
			.widget_wp_carousel_widget .wp_carousel .panel {
				width:96px;
			}
			
			.widget_wp_carousel_widget .button-prev, .widget_wp_carousel_widget .button-next {
				margin:0px 0 0 0;
			}