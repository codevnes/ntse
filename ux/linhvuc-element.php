<?php
/**
 * Lĩnh Vực Hoạt Động Element
 * Element UX Builder hiển thị 4 lĩnh vực hoạt động chính
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('ux_builder_setup', function() {
    add_ux_builder_shortcode('nts_linh_vuc', [
        'name'      => __('Lĩnh Vực Hoạt Động', 'ntse'),
        'category'  => __('NTS Elements', 'ntse'),
        'icon'      => 'dashicons-networking',
        'info'      => '{{ title }}',
        'options'   => [
            'title' => [
                'type'    => 'textfield',
                'heading' => __('Tiêu đề', 'ntse'),
                'default' => __('Lĩnh Vực Hoạt Động', 'ntse'),
            ],
            'subtitle' => [
                'type'    => 'textfield',
                'heading' => __('Mô tả ngắn', 'ntse'),
                'default' => __('Chúng tôi chuyên cung cấp các dịch vụ chất lượng cao trong lĩnh vực nước', 'ntse'),
            ],
            'style' => [
                'type'    => 'select',
                'heading' => __('Phong cách hiển thị', 'ntse'),
                'default' => 'style1',
                'options' => [
                    'style1' => __('Style 1 - Card nổi', 'ntse'),
                    'style2' => __('Style 2 - Card phẳng', 'ntse'),
                    'style3' => __('Style 3 - Card có hình ảnh', 'ntse'),
                ],
            ],
            'show_number' => [
                'type'    => 'checkbox',
                'heading' => __('Hiển thị số thứ tự', 'ntse'),
                'default' => 'true',
            ],
            'animation' => [
                'type'    => 'select',
                'heading' => __('Hiệu ứng', 'ntse'),
                'default' => 'fade-in',
                'options' => [
                    'none'       => __('Không có', 'ntse'),
                    'fade-in'    => __('Fade In', 'ntse'),
                    'slide-up'   => __('Slide Up', 'ntse'),
                    'zoom-in'    => __('Zoom In', 'ntse'),
                    'bounce'     => __('Bounce', 'ntse'),
                ],
            ],
            'linhvuc1_title' => [
                'type'    => 'textfield',
                'heading' => __('Lĩnh vực 1 - Tiêu đề', 'ntse'),
                'default' => __('Công trình nước', 'ntse'),
            ],
            'linhvuc1_desc' => [
                'type'    => 'textarea',
                'heading' => __('Lĩnh vực 1 - Mô tả', 'ntse'),
                'default' => __('Thiết kế, xây dựng và vận hành các công trình nước hiện đại, đảm bảo chất lượng và tiến độ.', 'ntse'),
            ],
            'linhvuc1_icon' => [
                'type'    => 'textfield',
                'heading' => __('Lĩnh vực 1 - Icon (Font Awesome)', 'ntse'),
                'default' => 'fa-solid fa-city',
            ],
            'linhvuc1_image' => [
                'type'    => 'image',
                'heading' => __('Lĩnh vực 1 - Hình ảnh', 'ntse'),
            ],
            'linhvuc2_title' => [
                'type'    => 'textfield',
                'heading' => __('Lĩnh vực 2 - Tiêu đề', 'ntse'),
                'default' => __('Vận hành xử lý nước thải', 'ntse'),
            ],
            'linhvuc2_desc' => [
                'type'    => 'textarea',
                'heading' => __('Lĩnh vực 2 - Mô tả', 'ntse'),
                'default' => __('Quản lý và vận hành hệ thống xử lý nước thải với công nghệ tiên tiến, thân thiện với môi trường.', 'ntse'),
            ],
            'linhvuc2_icon' => [
                'type'    => 'textfield',
                'heading' => __('Lĩnh vực 2 - Icon (Font Awesome)', 'ntse'),
                'default' => 'fa-solid fa-water',
            ],
            'linhvuc2_image' => [
                'type'    => 'image',
                'heading' => __('Lĩnh vực 2 - Hình ảnh', 'ntse'),
            ],
            'linhvuc3_title' => [
                'type'    => 'textfield',
                'heading' => __('Lĩnh vực 3 - Tiêu đề', 'ntse'),
                'default' => __('Tưới cây tự động', 'ntse'),
            ],
            'linhvuc3_desc' => [
                'type'    => 'textarea',
                'heading' => __('Lĩnh vực 3 - Mô tả', 'ntse'),
                'default' => __('Thiết kế và lắp đặt hệ thống tưới cây tự động thông minh, tiết kiệm nước và năng lượng.', 'ntse'),
            ],
            'linhvuc3_icon' => [
                'type'    => 'textfield',
                'heading' => __('Lĩnh vực 3 - Icon (Font Awesome)', 'ntse'),
                'default' => 'fa-solid fa-seedling',
            ],
            'linhvuc3_image' => [
                'type'    => 'image',
                'heading' => __('Lĩnh vực 3 - Hình ảnh', 'ntse'),
            ],
            'linhvuc4_title' => [
                'type'    => 'textfield',
                'heading' => __('Lĩnh vực 4 - Tiêu đề', 'ntse'),
                'default' => __('Đào tạo nghề ngành nước', 'ntse'),
            ],
            'linhvuc4_desc' => [
                'type'    => 'textarea',
                'heading' => __('Lĩnh vực 4 - Mô tả', 'ntse'),
                'default' => __('Đào tạo chuyên sâu về kỹ thuật và quản lý ngành nước, trang bị kiến thức và kỹ năng thiết thực.', 'ntse'),
            ],
            'linhvuc4_icon' => [
                'type'    => 'textfield',
                'heading' => __('Lĩnh vực 4 - Icon (Font Awesome)', 'ntse'),
                'default' => 'fa-solid fa-graduation-cap',
            ],
            'linhvuc4_image' => [
                'type'    => 'image',
                'heading' => __('Lĩnh vực 4 - Hình ảnh', 'ntse'),
            ],
        ],
    ]);
});

// Render element HTML
function nts_linh_vuc_element($atts) {
    extract(shortcode_atts([
        'title'          => __('Lĩnh Vực Hoạt Động', 'ntse'),
        'subtitle'       => __('Chúng tôi chuyên cung cấp các dịch vụ chất lượng cao trong lĩnh vực nước', 'ntse'),
        'style'          => 'style1',
        'show_number'    => 'true',
        'animation'      => 'fade-in',
        'linhvuc1_title' => __('Công trình nước', 'ntse'),
        'linhvuc1_desc'  => __('Thiết kế, xây dựng và vận hành các công trình nước hiện đại, đảm bảo chất lượng và tiến độ.', 'ntse'),
        'linhvuc1_icon'  => 'fa-solid fa-city',
        'linhvuc1_image' => '',
        'linhvuc2_title' => __('Vận hành xử lý nước thải', 'ntse'),
        'linhvuc2_desc'  => __('Quản lý và vận hành hệ thống xử lý nước thải với công nghệ tiên tiến, thân thiện với môi trường.', 'ntse'),
        'linhvuc2_icon'  => 'fa-solid fa-water',
        'linhvuc2_image' => '',
        'linhvuc3_title' => __('Tưới cây tự động', 'ntse'),
        'linhvuc3_desc'  => __('Thiết kế và lắp đặt hệ thống tưới cây tự động thông minh, tiết kiệm nước và năng lượng.', 'ntse'),
        'linhvuc3_icon'  => 'fa-solid fa-seedling',
        'linhvuc3_image' => '',
        'linhvuc4_title' => __('Đào tạo nghề ngành nước', 'ntse'),
        'linhvuc4_desc'  => __('Đào tạo chuyên sâu về kỹ thuật và quản lý ngành nước, trang bị kiến thức và kỹ năng thiết thực.', 'ntse'),
        'linhvuc4_icon'  => 'fa-solid fa-graduation-cap',
        'linhvuc4_image' => '',
    ], $atts));

    $animation_class = ($animation !== 'none') ? 'nts-animation-' . $animation : '';
    $style_class = 'nts-linhvuc-' . $style;
    $show_number = ($show_number === 'true');
    
    $linhvucs = [
        [
            'title' => $linhvuc1_title,
            'desc'  => $linhvuc1_desc,
            'icon'  => $linhvuc1_icon,
            'image' => $linhvuc1_image,
            'num'   => '01'
        ],
        [
            'title' => $linhvuc2_title,
            'desc'  => $linhvuc2_desc,
            'icon'  => $linhvuc2_icon,
            'image' => $linhvuc2_image,
            'num'   => '02'
        ],
        [
            'title' => $linhvuc3_title,
            'desc'  => $linhvuc3_desc,
            'icon'  => $linhvuc3_icon,
            'image' => $linhvuc3_image,
            'num'   => '03'
        ],
        [
            'title' => $linhvuc4_title,
            'desc'  => $linhvuc4_desc,
            'icon'  => $linhvuc4_icon,
            'image' => $linhvuc4_image,
            'num'   => '04'
        ],
    ];

    ob_start();
    ?>
    
    <div class="nts-linhvuc-section <?php echo esc_attr($style_class); ?>">
        <div class="nts-linhvuc-header">
            <?php if ($title) : ?>
                <h2 class="nts-linhvuc-title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            
            <?php if ($subtitle) : ?>
                <div class="nts-linhvuc-subtitle"><?php echo esc_html($subtitle); ?></div>
            <?php endif; ?>
        </div>
        
        <div class="nts-linhvuc-grid">
            <?php foreach ($linhvucs as $index => $linhvuc) : 
                $delay = ($index + 1) * 0.2;
                $item_class = $animation_class ? $animation_class . ' delay-' . ($index + 1) : '';
            ?>
                <div class="nts-linhvuc-item <?php echo esc_attr($item_class); ?>">
                    <?php if ($style === 'style3' && !empty($linhvuc['image'])) : ?>
                        <div class="linhvuc-image">
                            <img src="<?php echo esc_url($linhvuc['image']); ?>" alt="<?php echo esc_attr($linhvuc['title']); ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="linhvuc-content">
                        <?php if ($show_number) : ?>
                            <div class="linhvuc-number"><?php echo esc_html($linhvuc['num']); ?></div>
                        <?php endif; ?>
                        
                        <div class="linhvuc-icon">
                            <i class="<?php echo esc_attr($linhvuc['icon']); ?>"></i>
                        </div>
                        
                        <h3 class="linhvuc-title"><?php echo esc_html($linhvuc['title']); ?></h3>
                        
                        <div class="linhvuc-desc">
                            <?php echo esc_html($linhvuc['desc']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php
    return ob_get_clean();
}
add_shortcode('nts_linh_vuc', 'nts_linh_vuc_element'); 