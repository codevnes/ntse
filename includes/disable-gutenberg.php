<?php
/**
 * Disable Gutenberg Editor for specific post types
 */

// Disable Gutenberg editor for product post type
function ntse_disable_gutenberg_for_product($use_block_editor, $post_type) {
    if ($post_type === 'product') {
        return false; // Disable Gutenberg for product post type
    }
    return $use_block_editor; // Return original value for other post types
}
add_filter('use_block_editor_for_post_type', 'ntse_disable_gutenberg_for_product', 10, 2);

// Disable Gutenberg for product post type in WordPress 5.0+
function ntse_disable_gutenberg_for_product_5($is_enabled, $post_type, $post) {
    if ($post_type === 'product') {
        return false; // Disable Gutenberg for product post type
    }
    return $is_enabled; // Return original value for other post types
}
add_filter('gutenberg_can_edit_post_type', 'ntse_disable_gutenberg_for_product_5', 10, 3);
