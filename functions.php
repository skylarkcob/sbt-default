<?php
$sb_load = get_template_directory() . "/sb/load.php";
if(file_exists($sb_load)) {
	include $sb_load;
	$load = new SB_Load();
	$load->run();
} else {
	wp_die('Please put sb folder in your theme.');
}
?>