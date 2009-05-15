<?php
	$auto = get_option('wp_carousel_autostep');
	$auto_t = get_option('wp_carousel_autostep_time');
	$auto_n = get_option('wp_carousel_autostep_num');
?>
stepcarousel.setup({
	galleryid: 'wp_carousel', //id of carousel DIV
	beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'panel', //class of panel DIVs each holding content
	autostep: {enable:<?php if ($auto == 'yes') { echo 'true'; } else { echo 'false'; } ?>, moveby:<?php echo $auto_n; ?>, pause:<?php echo $auto_t; ?>},
	panelbehavior: {speed:500, wraparound:true, persist:true},
	defaultbuttons: {enable: false},
	statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['external'] //content setting ['inline'] or ['external', 'path_to_external_file']
})