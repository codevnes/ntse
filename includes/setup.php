<?php
/**
 * Theme Setup
 * Thực hiện các thiết lập cơ bản cho theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Đăng ký các menu của theme
 */
function nts_register_custom_menus() {
    register_nav_menus(array(
        'nts_services_menu'    => __('Services Menu', 'ntse'),
        'nts_projects_menu'    => __('Projects Menu', 'ntse'),
        'nts_products_menu'    => __('Products Menu', 'ntse'),
        'nts_about_us_menu'    => __('About Us Menu', 'ntse'),
        'nts_policies_menu'    => __('Policies Menu', 'ntse'),
    ));
}
add_action('init', 'nts_register_custom_menus');

/**
 * Thêm class vào body cho template single-product-modern
 */
function ntse_add_body_class($classes) {
    if (is_page_template('single-product-modern.php') || 
        (is_singular('product') && get_page_template_slug() == 'single-product-modern.php')) {
        $classes[] = 'product-modern-template';
    }
    return $classes;
}
add_filter('body_class', 'ntse_add_body_class');

/**
 * Thêm Offcanvas Menu vào body
 */
function nts_add_offcanvas_menu_to_body() {
   require_once get_stylesheet_directory() . '/template/offcanvas.php';
}
add_action('wp_body_open', 'nts_add_offcanvas_menu_to_body'); 