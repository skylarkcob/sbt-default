<?php
$sb_load = get_template_directory() . "/sb/load.php";
if(file_exists($sb_load)) {
	include $sb_load;
} else {
	wp_die('Please put sb folder in your theme.');
}
?>