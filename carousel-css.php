/* Carousel de artículos destacados */
					
			#wp_carousel {
				position: relative; /* No edit */
				margin:10px 0 10px 0;
				height: 250px;
				background:#5B5B5B url(img/carousel-bg.png) bottom left repeat-x;
			}
			
			#wp_carousel .belt {
				position: absolute; /* No edit */
				left: 0;
				top: 0;
			}
			
			#wp_carousel .panel {
				float: left; /* No edit */
				overflow: hidden; /* No edit */
				<?php
					$panel_width = get_option('wp_carousel_panel_width');
					$panel_width_unit = get_option('wp_carousel_panel_width_unit');
					if($panel_width != '') {
				?>
				width: <?php echo $panel_width; ?><?php echo $panel_width_unit; ?>;
				<?php } ?>
				margin:4px;
				padding:7px;
				border:1px solid #5B5B5B;
				background:#383838 url(img/carousel-panel-bg.png) bottom left repeat-x;
				-moz-border-radius:5px;
			}
			
			#wp_carousel .panel .panel-text {
				padding-top:5px;
				font-size:13px;
				font-family:Verdana, Geneva, sans-serif;
				color:#FFF;
			}
			
			#wp_carousel .panel .panel-text a {
				color:#CCC;
				text-decoration:none;
			}
			
			#wp_carousel .panel .panel-text a:hover {
				color:#FFF;
				text-decoration:underline;
			}
			
						/* Botones del carousel */
						
			.button-prev {
				margin:10px 0 10px 0;
				height:250px;
				width:35px;
				float:left;
				background:#5B5B5B url(img/carousel-bg.png) bottom left repeat-x;
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
				background:#5B5B5B url(img/carousel-bg.png) bottom left repeat-x;
				-moz-border-radius:0 10px 10px 0;
			}
			
			.button-next a {
				display:block;
				padding:5px;
				margin-top:105px;
			}