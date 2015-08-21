<?php
defined('ABSPATH') or die('Please do not pip me!');
get_header();
if(have_posts()) {
    while(have_posts()) {
        the_post();
        SB_Theme::get_custom_content('content-single');
    }
}
get_footer();