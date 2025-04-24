<?php
// Đăng ký Element "NTS technology Card" cho Flatsome UX Builder
add_action('ux_builder_setup', 'nts_register_technology_card_element');

function nts_register_technology_card_element(): void {
    add_ux_builder_shortcode('nts_technology_card', array(
        'name'      => __('NTS technology Card', 'flatsome'),
        'category'  => __('Content', 'flatsome'),
        'options'   => array(
            // Hình ảnh
            'image' => array(
                'type'    => 'image',
                'heading' => __('Hình ảnh', 'flatsome'),
                'default' => '',
            ),
            // Tiêu đề
            'title' => array(
                'type'    => 'textfield',
                'heading' => __('Tiêu đề', 'flatsome'),
                'default' => __('Giải pháp của chúng tôi', 'flatsome'),
            ),
            // Mô tả
            'description' => array(
                'type'    => 'textarea',
                'heading' => __('Mô tả', 'flatsome'),
                'default' => __('Mô tả ngắn về công nghệ...', 'flatsome'),
            ),
            // Màu nền
            'bg_color' => array(
                'type'    => 'colorpicker',
                'heading' => __('Màu nền', 'flatsome'),
                'default' => '#ffffff',
            ),
            // Custom Class
            'class' => array(
                'type'    => 'textfield',
                'heading' => __('Custom Class', 'flatsome'),
                'default' => '',
            ),
        ),
    ));
}

// Shortcode hiển thị technology Card
function nts_technology_card_shortcode($atts) {
    extract(shortcode_atts(array(
        'image'       => '',
        'title'       => 'Công nghệ của chúng tôi',
        'description' => 'lorem ipsum dolor sit amet consectetur adipiscing elit lorem ipsum dolor sit amet consectetur adipiscing elit',
        'bg_color'    => '#ffffff',
        'class'       => '',
    ), $atts));

    ob_start(); ?>
    
    <div class="nts-technology-card <?php echo esc_attr($class); ?>" 
         style="background-color: <?php echo esc_attr($bg_color); ?>">
        <?php if (!empty($image)) : ?>
            <div class="technology-image">
                <?php echo wp_get_attachment_image($image, 'medium_large'); ?>
            </div>
        <?php endif; ?>
        
        <div class="technology-content">
            <?php if (!empty($title)) : ?>
                <h3 class="technology-title"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
            
            <?php if (!empty($description)) : ?>
                <div class="technology-description">
                    <?php echo wpautop(do_shortcode($description)); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php return ob_get_clean();
}
add_shortcode('nts_technology_card', 'nts_technology_card_shortcode');

?>


<?php
// Đăng ký Element "NTS Page Title" cho Flatsome UX Builder
add_action('ux_builder_setup', 'nts_register_page_title_element');

function nts_register_page_title_element() {
    add_ux_builder_shortcode('nts_page_title', array(
        'name'      => __('NTS Page Title', 'flatsome'),
        'category'  => __('Content', 'flatsome'),
        'options'   => array(
            // Font size
            'font_size' => array(
                'type'    => 'slider',
                'heading' => __('Font Size (px)', 'flatsome'),
                'default' => 32,
                'min'     => 14,
                'max'     => 72,
                'step'    => 1,
            ),
            // Font weight
            'font_weight' => array(
                'type'    => 'select',
                'heading' => __('Font Weight', 'flatsome'),
                'options' => array(
                    '300' => __('Light (300)', 'flatsome'),
                    '400' => __('Normal (400)', 'flatsome'),
                    '500' => __('Medium (500)', 'flatsome'),
                    '600' => __('Semi Bold (600)', 'flatsome'),
                    '700' => __('Bold (700)', 'flatsome'),
                    '800' => __('Extra Bold (800)', 'flatsome'),
                ),
                'default' => '600',
            ),
            // Text color
            'text_color' => array(
                'type'    => 'colorpicker',
                'heading' => __('Text Color', 'flatsome'),
                'default' => '',
            ),
            // Alignment
            'align' => array(
                'type'    => 'radio-buttons',
                'heading' => __('Alignment', 'flatsome'),
                'default' => 'left',
                'options' => array(
                    'left'   => array('title' => 'Left'),
                    'center' => array('title' => 'Center'),
                    'right'  => array('title' => 'Right'),
                ),
            ),
            // Custom Class
            'class' => array(
                'type'    => 'textfield',
                'heading' => __('Custom Class', 'flatsome'),
                'default' => '',
            ),
        ),
    ));
}

// Shortcode hiển thị Page Title
function nts_page_title_shortcode($atts) {
    extract(shortcode_atts(array(
        'font_size'   => 32,
        'font_weight' => '600',
        'text_color'  => '',
        'align'       => 'left',
        'class'       => '',
    ), $atts));

    // Lấy tiêu đề trang/ bài viết hiện tại
    $title = get_the_title();
    
    // Nếu là trang chủ (front page)
    if (is_front_page()) {
        $title = get_bloginfo('name');
    }
    // Nếu là trang blog (posts page)
    elseif (is_home()) {
        $title = get_the_title(get_option('page_for_posts'));
    }

    // Tạo inline style
    $style = '';
    $style .= 'font-size: ' . absint($font_size) . 'px;';
    $style .= 'font-weight: ' . esc_attr($font_weight) . ';';
    if (!empty($text_color)) {
        $style .= 'color: ' . esc_attr($text_color) . ';';
    }
    $style .= 'text-align: ' . esc_attr($align) . ';';

    ob_start(); ?>
    
    <div class="nts-page-title <?php echo esc_attr($class); ?>" style="<?php echo esc_attr($style); ?>">
        <?php echo esc_html($title); ?>
    </div>

    <?php return ob_get_clean();
}
add_shortcode('nts_page_title', 'nts_page_title_shortcode');




add_action('ux_builder_setup', function() {
    add_ux_builder_shortcode('nts_section', array(
        'name'      => __('NTS Section', 'your-text-domain'),
        'category'  => __('Custom', 'your-text-domain'),
        'type'      => 'container', // Định nghĩa đây là container
        'options'   => array(
            'type' => array(
                'type'    => 'select',
                'heading' => __('Section Type', 'your-text-domain'),
                'default' => 'type-1',
                'options' => array(
                    'type-1' => __('Type 1', 'your-text-domain'),
                    'type-2' => __('Type 2', 'your-text-domain'),
                    'type-3' => __('Type 3', 'your-text-domain'),
                ),
            ),
            // Có thể thêm các tùy chọn khác nếu cần
            'advanced_options' => array(
                'type'       => 'group',
                'heading'    => __('Advanced', 'your-text-domain'),
                'options'    => array(
                    'class' => array(
                        'type'    => 'textfield',
                        'heading' => __('Custom Class', 'your-text-domain'),
                    ),
                ),
            ),
        ),
    ));
});

// Hàm render shortcode
function nts_section_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'type'  => 'type-1',
        'class' => '',
    ), $atts));

    // Xử lý class tùy chỉnh
    $classes = array('nts-section', $type);
    if ($class) {
        $classes[] = $class;
    }
    $class_output = implode(' ', $classes);

    // Render HTML
    ob_start();
    ?>
    <div class="<?php echo esc_attr($class_output); ?>">
        <?php echo do_shortcode($content); ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('nts_section', 'nts_section_shortcode');

?>

<?php
// Đăng ký Element "NTS Step" cho Flatsome UX Builder
add_action('ux_builder_setup', 'nts_register_step_element');

function nts_register_step_element() {
    add_ux_builder_shortcode('nts_step', array(
        'name'      => __('NTS Step', 'flatsome'),
        'category'  => __('Content', 'flatsome'),
        'options'   => array(
            // Số thứ tự (1-10)
            'number' => array(
                'type'    => 'slider',
                'heading' => __('Số thứ tự', 'flatsome'),
                'default' => 1,
                'min'     => 1,
                'max'     => 10,
                'step'    => 1,
            ),
            // Tiêu đề
            'title' => array(
                'type'    => 'textfield',
                'heading' => __('Tiêu đề', 'flatsome'),
                'default' => __('Bước thực hiện', 'flatsome'),
            ),
            // Nội dung
            'content' => array(
                'type'    => 'textarea',
                'heading' => __('Nội dung', 'flatsome'),
                'default' => __('Mô tả chi tiết các bước thực hiện...', 'flatsome'),
            ),
            // Kiểu hiển thị
            'style' => array(
                'type'    => 'select',
                'heading' => __('Kiểu hiển thị', 'flatsome'),
                'options' => array(
                    'style-1' => __('Style 1 - Cơ bản', 'flatsome'),
                    'style-2' => __('Style 2 - Hiện đại', 'flatsome'),
                    'style-3' => __('Style 3 - Card', 'flatsome'),
                ),
                'default' => 'style-1',
            ),
            // Màu sắc
            'color' => array(
                'type'    => 'colorpicker',
                'heading' => __('Màu chính', 'flatsome'),
                'default' => '#446084',
            ),
            // Custom Class
            'class' => array(
                'type'    => 'textfield',
                'heading' => __('Custom Class', 'flatsome'),
                'default' => '',
            ),
        ),
    ));
}

// Shortcode hiển thị Step
function nts_step_shortcode($atts) {
    extract(shortcode_atts(array(
        'number'  => 1,
        'title'   => 'Tiêu đề',
        'content' => 'Mô tả chi tiết các bước thực hiện...',
        'style'   => 'style-1',
        'color'   => '#446084',
        'class'   => '',
    ), $atts));

    ob_start(); ?>
    
    <div class="nts-step <?php echo esc_attr($style); ?> <?php echo esc_attr($class); ?>" style="--primary-color: <?php echo esc_attr($color); ?>">
        <div class="step-number">
            <span><?php echo absint($number); ?></span>
        </div>
        <span class="step-line"></span>
        <div class="step-content">
            <?php if (!empty($title)) : ?>
                <h3 class="step-title"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
            
            <?php if (!empty($content)) : ?>
                <div class="step-text">
                    <?php echo wpautop(do_shortcode($content)); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php return ob_get_clean();
}
add_shortcode('nts_step', 'nts_step_shortcode');

?>


