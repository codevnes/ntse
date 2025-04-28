<?php
/**
 * Shortcodes
 * Định nghĩa các shortcodes tùy chỉnh cho theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Header Action Shortcode - Hiển thị thanh tìm kiếm và nút menu
 */
function header_action() {
    ob_start();
    ?>
    <div class="header-action">
        <form method="get" class="header-action__search" action="<?php echo esc_url(home_url('/')); ?>" role="search">
            <i class="fa-solid nts-search-icon fa-magnifying-glass"></i>
            <input type="search" class="search-field mb-0" name="s" value="" id="s" placeholder="<?php _e('Tìm kiếm...', 'ntse'); ?>" autocomplete="off">
            <button type="submit" class="search-submit" aria-label="<?php _e('Gửi', 'ntse'); ?>">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>
        <div class="open-menu">
            <i class="fa fa-bars"></i>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('header_action', 'header_action');

/**
 * Product Card Shortcode - Hiển thị thẻ sản phẩm
 */
function nts_product_card($atts) {
    $atts = shortcode_atts(array(
        'id' => 0,
    ), $atts, 'nts_product_card');
    
    $product_id = intval($atts['id']);
    
    if (!$product_id) {
        return '';
    }
    
    // Lấy thông tin sản phẩm
    $product = get_post($product_id);
    
    if (!$product || $product->post_type !== 'product') {
        return '';
    }
    
    $product_cats = get_the_terms($product_id, 'product_category');
    $product_cat = !empty($product_cats) && !is_wp_error($product_cats) ? $product_cats[0]->name : '';
    
    ob_start();
    ?>
    <div class="product-card animate-on-scroll">
        <div class="product-image">
            <?php if (has_post_thumbnail($product_id)) : ?>
                <?php echo get_the_post_thumbnail($product_id, 'medium'); ?>
            <?php else : ?>
                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/image/placeholder.png" alt="<?php echo esc_attr($product->post_title); ?>">
            <?php endif; ?>
            <div class="water-ripple"></div>
        </div>
        <div class="product-content">
            <span class="product-category"><?php echo esc_html($product_cat); ?></span>
            <h3 class="product-title"><a href="<?php echo esc_url(get_permalink($product_id)); ?>"><?php echo esc_html($product->post_title); ?></a></h3>
            <div class="product-description"><?php echo wp_trim_words(get_the_excerpt($product_id), 20); ?></div>
            <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="product-detail-link"><?php _e('Xem chi tiết', 'ntse'); ?> <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('nts_product_card', 'nts_product_card');

/**
 * Project Card Shortcode - Hiển thị thẻ dự án
 */
function nts_project_card($atts) {
    $atts = shortcode_atts(array(
        'id' => 0,
    ), $atts, 'nts_project_card');
    
    $project_id = intval($atts['id']);
    
    if (!$project_id) {
        return '';
    }
    
    // Lấy thông tin dự án
    $project = get_post($project_id);
    
    if (!$project || $project->post_type !== 'project') {
        return '';
    }
    
    ob_start();
    ?>
    <div class="project-card">
        <div class="project-image">
            <?php if (has_post_thumbnail($project_id)) : ?>
                <?php echo get_the_post_thumbnail($project_id, 'medium'); ?>
            <?php else : ?>
                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/image/placeholder.png" alt="<?php echo esc_attr($project->post_title); ?>">
            <?php endif; ?>
        </div>
        <div class="project-content">
            <h3 class="project-title"><a href="<?php echo esc_url(get_permalink($project_id)); ?>"><?php echo esc_html($project->post_title); ?></a></h3>
            <div class="project-description"><?php echo wp_trim_words(get_the_excerpt($project_id), 15); ?></div>
            <a href="<?php echo esc_url(get_permalink($project_id)); ?>" class="project-link"><?php _e('Xem dự án', 'ntse'); ?> <i class="fas fa-long-arrow-alt-right"></i></a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('nts_project_card', 'nts_project_card');