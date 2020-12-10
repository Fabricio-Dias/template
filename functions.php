<?php
//function woocommerce suport 
function moon_add_woocommerce_support(){
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'moon_add_woocommerce_support');

//function woocommerce css theme 

function moon_css(){
    wp_register_style('moon-style', get_template_directory_uri() . '/style.css', [], '1.0.0');
    wp_enqueue_style('moon-style');
}
add_action('wp_enqueue_scripts', 'moon_css');

function moon_custom_image(){
    add_image_size('slide', 1000, 800, true, ['center', 'top']);
    update_option('medium_crop', 1);
}
add_action('after_setup_theme', 'moon_custom_image');

function moon_loop_shop_per_page(){
    return 6;
}
add_filter('loop_shop_per_page', 'moon_loop_shop_per_page');


function remove_some_body_class($classes) {
  $woo_class = array_search('woocommerce', $classes);
  $woopage_class = array_search('woocommerce-page', $classes);
  $search = in_array('archive', $classes) || in_array('product-template-default', $classes);
  if($woo_class && $woopage_class && $search) {
    unset($classes[$woo_class]);
    unset($classes[$woopage_class]);
  }
  return $classes;
}
add_filter('body_class', 'remove_some_body_class');



include(get_template_directory() . '/inc/product-list.php');

include(get_template_directory() . '/inc/user-custom-menu.php');
include(get_template_directory() . '/inc/checkout-customizado.php');

?>
