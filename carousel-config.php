<?php
	
	$wp_carousel_options_serialized = get_option('wp_carousel_options');
	$wp_carousel_options = unserialize($wp_carousel_options_serialized);

	$wp_carousel_carousels = $wp_carousel_options['carousels'];
		
	$n = 0;
	while ($wp_carousel_carousels > $n) {
		$n++;
		$wp_carousel_autostep = $wp_carousel_options['carousel_'.$n.'']['autostep'];
		$wp_carousel_autostep_time = $wp_carousel_options['carousel_'.$n.'']['autostep_time'];
		$wp_carousel_autostep_num = $wp_carousel_options['carousel_'.$n.'']['autostep_num'];
?>
stepcarousel.setup({
	galleryid: 'wp_carousel_<?php echo $n; ?>', //id of carousel DIV
	beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'panel', //class of panel DIVs each holding content
	autostep: {enable:<?php if ($wp_carousel_autostep == 'yes') { echo 'true'; ?>, moveby:<?php echo $wp_carousel_autostep_num; ?>, pause:<?php echo $wp_carousel_autostep_time; } else { echo 'false'; } ?>},
	panelbehavior: {speed:500, wraparound:true, persist:true},
	defaultbuttons: {enable: false},
	statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['external'] //content setting ['inline'] or ['external', 'path_to_external_file']
})
<?php
	}
?>