<?php
// Đăng ký Element "NTS Dịch vụ" cho Flatsome UX Builder
add_action('ux_builder_setup', 'nts_register_services_element');

function nts_register_services_element() {
    add_ux_builder_shortcode('nts_services', [
        'name'      => __('NTS Dịch vụ', 'flatsome'),
        'category'  => __('Content', 'flatsome'),
        'options'   => [
            // Tiêu đề
            'title' => [
                'type'    => 'textfield',
                'heading' => __('Tiêu đề', 'flatsome'),
                'default' => 'Dịch vụ của chúng tôi',
            ],
            // Danh mục
            'category' => [
                'type'    => 'select',
                'heading' => __('Danh mục dịch vụ', 'flatsome'),
                'default' => '',
                'options' => nts_get_service_categories(),
                'config'  => [
                    'placeholder' => 'Chọn danh mục',
                    'multiple'    => true,
                    'tags'        => true,
                ],
            ],
            // Số lượng hiển thị
            'limit' => [
                'type'    => 'slider',
                'heading' => __('Số lượng hiển thị', 'flatsome'),
                'default' => 10,
                'min'     => 1,
                'max'     => 20,
                'step'    => 1,
            ],
            // Số cột
            'columns' => [
                'type'    => 'slider',
                'heading' => __('Số cột', 'flatsome'),
                'default' => 3,
                'min'     => 1,
                'max'     => 4,
                'step'    => 1,
            ],
            // Sắp xếp theo
            'orderby' => [
                'type'    => 'select',
                'heading' => __('Sắp xếp theo', 'flatsome'),
                'default' => 'date',
                'options' => [
                    'date'       => 'Ngày đăng',
                    'title'      => 'Tiêu đề',
                    'menu_order' => 'Thứ tự trang',
                    'rand'       => 'Ngẫu nhiên',
                ],
            ],
            // Thứ tự sắp xếp
            'order' => [
                'type'    => 'select',
                'heading' => __('Thứ tự sắp xếp', 'flatsome'),
                'default' => 'DESC',
                'options' => [
                    'DESC' => 'Giảm dần',
                    'ASC'  => 'Tăng dần',
                ],
            ],
            // Kiểu hiển thị
            'style' => [
                'type'    => 'select',
                'heading' => __('Kiểu hiển thị', 'flatsome'),
                'default' => 'grid',
                'options' => [
                    'grid'   => 'Lưới',
                    'slider' => 'Slider',
                ],
            ],
            // Khoảng cách cột
            'col_spacing' => [
                'type'    => 'select',
                'heading' => __('Khoảng cách cột', 'flatsome'),
                'default' => 'normal',
                'options' => [
                    'collapse' => 'Không',
                    'small'    => 'Nhỏ',
                    'normal'   => 'Bình thường',
                    'large'    => 'Lớn',
                ],
            ],
            // Custom Class
            'class' => [
                'type'    => 'textfield',
                'heading' => __('Custom CSS Class', 'flatsome'),
                'default' => 'nts-services',
            ],
        ],
    ]);
}

// Hàm lấy danh sách danh mục dịch vụ
function nts_get_service_categories() {
    $categories = get_terms([
        'taxonomy'   => 'service_category',
        'hide_empty' => false,
    ]);
    
    $options = ['' => 'Tất cả danh mục'];
    
    if (!is_wp_error($categories) && !empty($categories)) {
        foreach ($categories as $category) {
            $options[$category->slug] = $category->name;
        }
    }
    
    return $options;
}

// Ghi đè shortcode để hỗ trợ UX Builder
function nts_services_ux_builder_shortcode($atts) {
    $atts = shortcode_atts([
        'title'       => 'Dịch vụ của chúng tôi',
        'category'    => '',
        'limit'       => 10,
        'columns'     => 3,
        'orderby'     => 'date',
        'order'       => 'DESC',
        'style'       => 'grid',
        'col_spacing' => 'normal',
        'class'       => 'nts-services'
    ], $atts, 'nts_services');
    
    $args = [
        'post_type'      => 'service',
        'posts_per_page' => $atts['limit'],
        'orderby'        => $atts['orderby'],
        'order'          => $atts['order'],
    ];
    
    // Lọc theo danh mục nếu có
    if (!empty($atts['category'])) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'service_category',
                'field'    => 'slug',
                'terms'    => explode(',', $atts['category']),
            ],
        ];
    }
    
    $services_query = new WP_Query($args);
    
    ob_start();
    
    // Hiển thị tiêu đề nếu có
    if (!empty($atts['title'])) {
        echo '<h2 class="section-title"><span>' . esc_html($atts['title']) . '</span></h2>';
    }
    
    if ($services_query->have_posts()) :
        // Xác định các class cho container
        $container_classes = [$atts['class']];
        
        // Xác định các class cho row
        $row_classes = ['row'];
        $row_classes[] = 'row-' . $atts['col_spacing'];
        
        if ($atts['style'] === 'slider') {
            $row_classes[] = 'slider';
            $row_classes[] = 'slider-nav-circle';
            $row_classes[] = 'slider-nav-large';
            $row_classes[] = 'slider-nav-light';
            $row_classes[] = 'slider-style-normal';
        }
        
        echo '<div class="' . esc_attr(implode(' ', $container_classes)) . '">';
        echo '<div class="' . esc_attr(implode(' ', $row_classes)) . '">';
        
        while ($services_query->have_posts()) : $services_query->the_post();
            // Xác định class cho cột dựa trên số cột
            $column_class = 'medium-4'; // Mặc định 3 cột
            switch ((int)$atts['columns']) {
                case 1:
                    $column_class = 'medium-12';
                    break;
                case 2:
                    $column_class = 'medium-6';
                    break;
                case 4:
                    $column_class = 'medium-3';
                    break;
            }
            
            $col_class = $atts['style'] === 'slider' ? 'slide' : 'col';
            
            echo '<div class="' . esc_attr($col_class) . ' ' . esc_attr($column_class) . ' small-12">';
            echo '<div class="service-item">';
            
            // Thumbnail
            if (has_post_thumbnail()) {
                echo '<div class="service-thumbnail">';
                echo '<a href="' . get_permalink() . '">';
                the_post_thumbnail('service-thumbnail', ['class' => 'service-image']);
                echo '</a>';
                echo '</div>';
            }
            
            // Nội dung
            echo '<div class="service-content">';
            echo '<h3 class="service-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            echo '<div class="service-excerpt">' . get_the_excerpt() . '</div>';
            echo '<a href="' . get_permalink() . '" class="service-readmore">Xem thêm &raquo;</a>';
            echo '</div>';
            
            echo '</div>';
            echo '</div>';
        endwhile;
        
        echo '</div>';
        echo '</div>';
        
        // Khôi phục dữ liệu post
        wp_reset_postdata();
        
    else :
        echo '<p>Không có dịch vụ nào.</p>';
    endif;
    
    // Thêm CSS
    echo '<style>
    .section-title {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        position: relative;
        overflow: hidden;
    }
    .section-title span {
        display: inline-block;
        position: relative;
    }
    .section-title span:before,
    .section-title span:after {
        content: "";
        position: absolute;
        top: 50%;
        height: 1px;
        width: 100vw;
        background-color: #ddd;
    }
    .section-title span:before {
        right: 100%;
        margin-right: 15px;
    }
    .section-title span:after {
        left: 100%;
        margin-left: 15px;
    }
    .' . esc_attr($atts['class']) . ' {
        margin-bottom: 30px;
    }
    .service-item {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
    }
    .service-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }
    .service-thumbnail {
        position: relative;
        overflow: hidden;
    }
    .service-image {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s;
    }
    .service-item:hover .service-image {
        transform: scale(1.05);
    }
    .service-content {
        padding: 15px 20px 20px;
    }
    .service-title {
        margin: 0 0 10px;
        font-size: 18px;
    }
    .service-title a {
        color: #333;
        text-decoration: none;
    }
    .service-title a:hover {
        color: #0073aa;
    }
    .service-excerpt {
        font-size: 14px;
        line-height: 1.5;
        color: #666;
        margin-bottom: 15px;
    }
    .service-readmore {
        display: inline-block;
        color: #0073aa;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
    }
    .service-readmore:hover {
        text-decoration: underline;
    }
    </style>';
    
    return ob_get_clean();
}
add_shortcode('nts_services', 'nts_services_ux_builder_shortcode');
