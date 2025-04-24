<?php
/**
 * Số Liệu Nổi Bật Element
 * Element UX Builder hiển thị các số liệu nổi bật (Năm kinh nghiệm, Số dự án, Số khách hàng...)
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('ux_builder_setup', function() {
    add_ux_builder_shortcode('nts_counter', [
        'name'      => __('Số Liệu Nổi Bật', 'ntse'),
        'category'  => __('NTS Elements', 'ntse'),
        'icon'      => 'dashicons-chart-area',
        'info'      => '{{ title }}',
        'options'   => [
            'title' => [
                'type'    => 'textfield',
                'heading' => __('Tiêu đề chính', 'ntse'),
                'default' => __('Số Liệu Nổi Bật', 'ntse'),
            ],
            'subtitle' => [
                'type'    => 'textfield',
                'heading' => __('Mô tả ngắn', 'ntse'),
                'default' => __('Chúng tôi tự hào về những con số thể hiện sự phát triển của công ty', 'ntse'),
            ],
            'style' => [
                'type'    => 'select',
                'heading' => __('Phong cách hiển thị', 'ntse'),
                'default' => 'style1',
                'options' => [
                    'style1' => __('Style 1 - Card nổi', 'ntse'),
                    'style2' => __('Style 2 - Dọc có icon', 'ntse'),
                    'style3' => __('Style 3 - Nền đậm, số lớn', 'ntse'),
                ],
            ],
            'bg_color' => [
                'type'    => 'colorpicker',
                'heading' => __('Màu nền (Style 3)', 'ntse'),
                'default' => '#3a569e',
                'conditions' => 'style === "style3"',
            ],
            'text_color' => [
                'type'    => 'colorpicker',
                'heading' => __('Màu chữ (Style 3)', 'ntse'),
                'default' => '#ffffff',
                'conditions' => 'style === "style3"',
            ],
            'animation' => [
                'type'    => 'select',
                'heading' => __('Hiệu ứng', 'ntse'),
                'default' => 'fade-in',
                'options' => [
                    'none'      => __('Không có', 'ntse'),
                    'fade-in'   => __('Fade In', 'ntse'),
                    'slide-up'  => __('Slide Up', 'ntse'),
                    'zoom-in'   => __('Zoom In', 'ntse'),
                    'flip'      => __('Flip', 'ntse'),
                ],
            ],
            'counter_1_value' => [
                'type'    => 'slider',
                'heading' => __('Năm kinh nghiệm - Giá trị', 'ntse'),
                'default' => 10,
                'min'     => 1,
                'max'     => 100,
                'step'    => 1,
            ],
            'counter_1_title' => [
                'type'    => 'textfield',
                'heading' => __('Năm kinh nghiệm - Tiêu đề', 'ntse'),
                'default' => __('Năm kinh nghiệm', 'ntse'),
            ],
            'counter_1_icon' => [
                'type'    => 'textfield',
                'heading' => __('Năm kinh nghiệm - Icon (Font Awesome)', 'ntse'),
                'default' => 'fa-solid fa-calendar-check',
            ],
            'counter_1_suffix' => [
                'type'    => 'textfield',
                'heading' => __('Năm kinh nghiệm - Hậu tố', 'ntse'),
                'default' => '+',
            ],
            'counter_1_desc' => [
                'type'    => 'textarea',
                'heading' => __('Năm kinh nghiệm - Mô tả', 'ntse'),
                'default' => __('Kinh nghiệm lâu năm trong ngành nước', 'ntse'),
            ],
            'counter_2_value' => [
                'type'    => 'slider',
                'heading' => __('Số dự án - Giá trị', 'ntse'),
                'default' => 150,
                'min'     => 1,
                'max'     => 1000,
                'step'    => 1,
            ],
            'counter_2_title' => [
                'type'    => 'textfield',
                'heading' => __('Số dự án - Tiêu đề', 'ntse'),
                'default' => __('Dự án thành công', 'ntse'),
            ],
            'counter_2_icon' => [
                'type'    => 'textfield',
                'heading' => __('Số dự án - Icon (Font Awesome)', 'ntse'),
                'default' => 'fa-solid fa-diagram-project',
            ],
            'counter_2_suffix' => [
                'type'    => 'textfield',
                'heading' => __('Số dự án - Hậu tố', 'ntse'),
                'default' => '+',
            ],
            'counter_2_desc' => [
                'type'    => 'textarea',
                'heading' => __('Số dự án - Mô tả', 'ntse'),
                'default' => __('Hoàn thành các dự án chất lượng cao', 'ntse'),
            ],
            'counter_3_value' => [
                'type'    => 'slider',
                'heading' => __('Số khách hàng - Giá trị', 'ntse'),
                'default' => 200,
                'min'     => 1,
                'max'     => 1000,
                'step'    => 1,
            ],
            'counter_3_title' => [
                'type'    => 'textfield',
                'heading' => __('Số khách hàng - Tiêu đề', 'ntse'),
                'default' => __('Khách hàng tin tưởng', 'ntse'),
            ],
            'counter_3_icon' => [
                'type'    => 'textfield',
                'heading' => __('Số khách hàng - Icon (Font Awesome)', 'ntse'),
                'default' => 'fa-solid fa-handshake',
            ],
            'counter_3_suffix' => [
                'type'    => 'textfield',
                'heading' => __('Số khách hàng - Hậu tố', 'ntse'),
                'default' => '+',
            ],
            'counter_3_desc' => [
                'type'    => 'textarea',
                'heading' => __('Số khách hàng - Mô tả', 'ntse'),
                'default' => __('Đối tác và khách hàng hàng đầu', 'ntse'),
            ],
            'counter_4_value' => [
                'type'    => 'slider',
                'heading' => __('Counter 4 - Giá trị (Tùy chọn)', 'ntse'),
                'default' => 25,
                'min'     => 1,
                'max'     => 1000,
                'step'    => 1,
            ],
            'counter_4_title' => [
                'type'    => 'textfield',
                'heading' => __('Counter 4 - Tiêu đề (Tùy chọn)', 'ntse'),
                'default' => __('Tỉnh thành hoạt động', 'ntse'),
            ],
            'counter_4_icon' => [
                'type'    => 'textfield',
                'heading' => __('Counter 4 - Icon (Font Awesome)', 'ntse'),
                'default' => 'fa-solid fa-map-location-dot',
            ],
            'counter_4_suffix' => [
                'type'    => 'textfield',
                'heading' => __('Counter 4 - Hậu tố', 'ntse'),
                'default' => '+',
            ],
            'counter_4_desc' => [
                'type'    => 'textarea',
                'heading' => __('Counter 4 - Mô tả (Tùy chọn)', 'ntse'),
                'default' => __('Mạng lưới hoạt động toàn quốc', 'ntse'),
            ],
            'show_counter_4' => [
                'type'    => 'checkbox',
                'heading' => __('Hiển thị Counter 4', 'ntse'),
                'default' => 'false',
            ],
        ],
    ]);
});

// Render element HTML
function nts_counter_element($atts) {
    extract(shortcode_atts([
        'title'            => __('Số Liệu Nổi Bật', 'ntse'),
        'subtitle'         => __('Chúng tôi tự hào về những con số thể hiện sự phát triển của công ty', 'ntse'),
        'style'            => 'style1',
        'bg_color'         => '#3a569e',
        'text_color'       => '#ffffff',
        'animation'        => 'fade-in',
        'counter_1_value'  => 10,
        'counter_1_title'  => __('Năm kinh nghiệm', 'ntse'),
        'counter_1_icon'   => 'fa-solid fa-calendar-check',
        'counter_1_suffix' => '+',
        'counter_1_desc'   => __('Kinh nghiệm lâu năm trong ngành nước', 'ntse'),
        'counter_2_value'  => 150,
        'counter_2_title'  => __('Dự án thành công', 'ntse'),
        'counter_2_icon'   => 'fa-solid fa-diagram-project',
        'counter_2_suffix' => '+',
        'counter_2_desc'   => __('Hoàn thành các dự án chất lượng cao', 'ntse'),
        'counter_3_value'  => 200,
        'counter_3_title'  => __('Khách hàng tin tưởng', 'ntse'),
        'counter_3_icon'   => 'fa-solid fa-handshake',
        'counter_3_suffix' => '+',
        'counter_3_desc'   => __('Đối tác và khách hàng hàng đầu', 'ntse'),
        'counter_4_value'  => 25,
        'counter_4_title'  => __('Tỉnh thành hoạt động', 'ntse'),
        'counter_4_icon'   => 'fa-solid fa-map-location-dot',
        'counter_4_suffix' => '+',
        'counter_4_desc'   => __('Mạng lưới hoạt động toàn quốc', 'ntse'),
        'show_counter_4'   => 'false',
    ], $atts));

    $animation_class = ($animation !== 'none') ? 'nts-animation-' . $animation : '';
    $style_class = 'nts-counter-' . $style;
    $show_counter_4 = ($show_counter_4 === 'true');
    
    $counters = [
        [
            'value'  => $counter_1_value,
            'title'  => $counter_1_title,
            'icon'   => $counter_1_icon,
            'suffix' => $counter_1_suffix,
            'desc'   => $counter_1_desc
        ],
        [
            'value'  => $counter_2_value,
            'title'  => $counter_2_title,
            'icon'   => $counter_2_icon,
            'suffix' => $counter_2_suffix,
            'desc'   => $counter_2_desc
        ],
        [
            'value'  => $counter_3_value,
            'title'  => $counter_3_title,
            'icon'   => $counter_3_icon,
            'suffix' => $counter_3_suffix,
            'desc'   => $counter_3_desc
        ]
    ];
    
    // Thêm counter 4 nếu được bật
    if ($show_counter_4) {
        $counters[] = [
            'value'  => $counter_4_value,
            'title'  => $counter_4_title,
            'icon'   => $counter_4_icon,
            'suffix' => $counter_4_suffix,
            'desc'   => $counter_4_desc
        ];
    }
    
    // Tính toán số cột
    $col_class = $show_counter_4 ? 'large-3 medium-6' : 'large-4 medium-6';
    
    // Inline styles cho style3
    $style3_styles = '';
    if ($style === 'style3') {
        $style3_styles = 'background-color: ' . esc_attr($bg_color) . '; color: ' . esc_attr($text_color) . ';';
    }

    ob_start();
    
    // Thêm script jQuery Countup
    wp_enqueue_script('waypoints', 'https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js', ['jquery'], null, true);
    wp_enqueue_script('countup', 'https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js', ['jquery', 'waypoints'], null, true);
    
    // Add inline script for countup
    $inline_script = '
    jQuery(document).ready(function($) {
        $(".counter-number").counterUp({
            delay: 10,
            time: 1000
        });
    });';
    
    wp_add_inline_script('countup', $inline_script);
    
    // Thêm CSS để tạo khoảng cách giữa các cột
    $inline_styles = '
    <style>
        .nts-counter-section .nts-counter-item {
            padding: 20px;
            margin-bottom: 30px;
        }
        .nts-counter-style1 .nts-counter-item {
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .nts-counter-style1 .nts-counter-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .nts-counter-style2 .nts-counter-item, 
        .nts-counter-style3 .nts-counter-item {
            margin: 15px;
        }
    </style>
    ';
    ?>
    
    <?php echo $inline_styles; ?>
    <div class="nts-counter-section <?php echo esc_attr($style_class); ?>" <?php if ($style === 'style3') echo 'style="' . $style3_styles . '"'; ?>>
        <div class="container">
            <?php if ($title || $subtitle) : ?>
                <div class="nts-counter-header">
                    <?php if ($title) : ?>
                        <h2 class="nts-counter-title"><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>
                    
                    <?php if ($subtitle) : ?>
                        <div class="nts-counter-subtitle"><?php echo esc_html($subtitle); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <div class="nts-counter-grid row">
                <?php foreach ($counters as $index => $counter) : 
                    $delay = ($index + 1) * 0.2;
                    $item_class = $animation_class ? $animation_class . ' delay-' . ($index + 1) : '';
                ?>
                    <div class="col <?php echo esc_attr($col_class); ?>">
                        <div class="col-inner">
                            <div class="nts-counter-item <?php echo esc_attr($item_class); ?>">
                                <div class="counter-icon">
                                    <i class="<?php echo esc_attr($counter['icon']); ?>"></i>
                                </div>
                                
                                <div class="counter-content">
                                    <div class="counter-value">
                                        <span class="counter-number"><?php echo esc_html($counter['value']); ?></span>
                                        <?php if (!empty($counter['suffix'])) : ?>
                                            <span class="counter-suffix"><?php echo esc_html($counter['suffix']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h3 class="counter-title"><?php echo esc_html($counter['title']); ?></h3>
                                    
                                    <?php if (!empty($counter['desc'])) : ?>
                                        <div class="counter-desc"><?php echo esc_html($counter['desc']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <?php
    return ob_get_clean();
}
add_shortcode('nts_counter', 'nts_counter_element'); 