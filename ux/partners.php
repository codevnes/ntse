<?php
/**
 * UX Builder Element: Partners
 */

// Đăng ký Element "Partners" cho Flatsome UX Builder
add_action('ux_builder_setup', 'nts_register_partners_element');

function nts_register_partners_element() {
    add_ux_builder_shortcode('nts_partners', [
        'name'      => __('Đối tác', 'flatsome'),
        'category'  => __('Content', 'flatsome'),
        'info'      => __('Hiển thị danh sách đối tác', 'flatsome'),
        'icon'      => 'dashicons-groups',

        'options' => [
            'type' => [
                'type'    => 'select',
                'heading' => __('Loại đối tác', 'flatsome'),
                'default' => '',
                'options' => [
                    ''         => 'Tất cả',
                    'product'  => 'Đối tác cung ứng sản phẩm',
                    'software' => 'Đối tác phần mềm',
                    'project'  => 'Đối tác dự án',
                ],
            ],
            'columns' => [
                'type'    => 'slider',
                'heading' => __('Số cột', 'flatsome'),
                'default' => 3,
                'min'     => 1,
                'max'     => 6,
                'step'    => 1,
            ],
            'limit' => [
                'type'    => 'slider',
                'heading' => __('Số lượng hiển thị', 'flatsome'),
                'default' => -1,
                'min'     => -1,
                'max'     => 50,
                'step'    => 1,
            ],
            'class' => [
                'type'    => 'textfield',
                'heading' => __('CSS class', 'flatsome'),
                'default' => '',
            ],
        ],
    ]);
}

// Shortcode hiển thị Partners
function nts_partners_shortcode($atts) {
    extract(shortcode_atts([
        'type'    => '',
        'columns' => 3,
        'limit'   => -1,
        'class'   => '',
    ], $atts));

    // Build shortcode
    $shortcode = '[partners';

    if (!empty($type)) {
        $shortcode .= ' type="' . esc_attr($type) . '"';
    }

    if (!empty($columns)) {
        $shortcode .= ' columns="' . esc_attr($columns) . '"';
    }

    if (!empty($limit)) {
        $shortcode .= ' limit="' . esc_attr($limit) . '"';
    }

    $shortcode .= ']';

    // Add wrapper with class
    $output = '<div class="partners-element ' . esc_attr($class) . '">';
    $output .= do_shortcode($shortcode);
    $output .= '</div>';

    return $output;
}

// Register the shortcode if partners-shortcode.php is not loaded
if (!shortcode_exists('nts_partners')) {
    add_shortcode('nts_partners', 'nts_partners_shortcode');
}
