<?php
sb_meta_box_nonce();
global $post;
$post_id = $post->ID;
SB_Theme::meta_box_before('product-information');
$key = 'price';
$value = SB_Post::get_sb_meta($post_id, $key);
$args = array(
    'id' => 'sb_' . $key,
    'name' => sb_build_meta_name($key),
    'value' => $value,
    'label' => 'Price',
    'field_class' => 'display-block width-medium'
);
SB_Meta_Field::text($args);
SB_Theme::meta_box_after();