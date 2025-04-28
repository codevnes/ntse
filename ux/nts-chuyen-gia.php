<?php
// Đăng ký Element "NTS Chuyên Gia" cho Flatsome UX Builder
add_action('ux_builder_setup', 'nts_register_chuyen_gia_element');

function nts_register_chuyen_gia_element() {
    add_ux_builder_shortcode('nts_chuyen_gia', array(
        'name'      => __('NTS Chuyên Gia', 'flatsome'),
        'category'  => __('Content', 'flatsome'),
        'options'   => array(
            // Tiêu đề
            'title' => array(
                'type'    => 'textfield',
                'heading' => __('Tiêu đề', 'flatsome'),
                'default' => 'NTS Chuyên Gia',
            ),
            // Số lượng hiển thị
            'limit' => array(
                'type'    => 'slider',
                'heading' => __('Số lượng hiển thị', 'flatsome'),
                'default' => -1,
                'min'     => -1,
                'max'     => 20,
                'step'    => 1,
            ),
            // Số cột
            'columns' => array(
                'type'    => 'slider',
                'heading' => __('Số cột', 'flatsome'),
                'default' => 3,
                'min'     => 1,
                'max'     => 6,
                'step'    => 1,
            ),
            // Kiểu hiển thị
            'style' => array(
                'type'    => 'select',
                'heading' => __('Kiểu hiển thị', 'flatsome'),
                'default' => 'grid',
                'options' => array(
                    'grid'   => 'Lưới',
                    'slider' => 'Slider',
                ),
            ),
            // Khoảng cách cột
            'col_spacing' => array(
                'type'    => 'select',
                'heading' => __('Khoảng cách cột', 'flatsome'),
                'default' => 'normal',
                'options' => array(
                    'collapse' => 'Không',
                    'small'    => 'Nhỏ',
                    'normal'   => 'Bình thường',
                    'large'    => 'Lớn',
                ),
            ),
            // Custom Class
            'class' => array(
                'type'    => 'textfield',
                'heading' => __('Custom CSS Class', 'flatsome'),
                'default' => 'nts-chuyen-gia',
            ),
        ),
    ));
}

// Shortcode hiển thị danh sách NTS Chuyên Gia
function nts_chuyen_gia_shortcode($atts) {
    // Xử lý các tham số đầu vào
    $atts = shortcode_atts([
        'title'       => 'NTS Chuyên Gia',
        'limit'       => -1,
        'columns'     => 3,
        'style'       => 'grid',
        'col_spacing' => 'normal',
        'class'       => 'nts-chuyen-gia'
    ], $atts, 'nts_chuyen_gia');
    
    // Lấy danh sách chuyên gia từ cơ sở dữ liệu
    $experts = get_option('nts_experts', []);
    
    // Giới hạn số lượng nếu cần
    if ($atts['limit'] > 0 && count($experts) > $atts['limit']) {
        $experts = array_slice($experts, 0, $atts['limit']);
    }
    
    // Nếu không có chuyên gia nào, trả về thông báo
    if (empty($experts)) {
        return '<div class="no-experts">' . __('Chưa có chuyên gia nào được thêm.', 'flatsome') . '</div>';
    }
    
    // Xác định các class cho container
    $classes = array();
    $classes[] = $atts['class'];
    
    // Xác định các class cho row
    $row_classes = array();
    $row_classes[] = 'row';
    $row_classes[] = 'row-' . $atts['col_spacing'];
    
    if ($atts['style'] === 'slider') {
        $row_classes[] = 'slider';
        $row_classes[] = 'slider-nav-outside';
        $row_classes[] = 'slider-nav-push';
    }
    
    // Bắt đầu output buffer
    ob_start();
    ?>
    <div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
        <?php if (!empty($atts['title'])): ?>
            <h2 class="section-title">
                <span><?php echo esc_html($atts['title']); ?></span>
            </h2>
        <?php endif; ?>
        
        <div class="nts-experts-list">
            <div class="<?php echo esc_attr(implode(' ', $row_classes)); ?>">
                <?php 
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
                    case 6:
                        $column_class = 'medium-2';
                        break;
                }
                
                foreach ($experts as $expert): 
                    $col_class = $atts['style'] === 'slider' ? 'slide' : 'col';
                ?>
                    <div class="<?php echo esc_attr($col_class); ?> <?php echo esc_attr($column_class); ?> small-12">
                        <div class="expert-card">
                            <?php if (!empty($expert['avatar'])): ?>
                                <div class="expert-avatar">
                                    <img src="<?php echo esc_url($expert['avatar']); ?>" alt="<?php echo esc_attr($expert['name']); ?>">
                                </div>
                            <?php endif; ?>
                            
                            <div class="expert-info">
                                <h3 class="expert-name"><?php echo esc_html($expert['name']); ?></h3>
                                
                                <?php if (!empty($expert['position'])): ?>
                                    <div class="expert-position"><?php echo esc_html($expert['position']); ?></div>
                                <?php endif; ?>
                                
                                <?php if (!empty($expert['bio'])): ?>
                                    <div class="expert-bio"><?php echo wp_kses_post($expert['bio']); ?></div>
                                <?php endif; ?>
                                
                                <div class="expert-contact">
                                    <?php if (!empty($expert['email'])): ?>
                                        <div class="expert-email">
                                            <i class="icon-envelop"></i> 
                                            <a href="mailto:<?php echo esc_attr($expert['email']); ?>">
                                                <?php echo esc_html($expert['email']); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($expert['phone'])): ?>
                                        <div class="expert-phone">
                                            <i class="icon-phone"></i> 
                                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $expert['phone'])); ?>">
                                                <?php echo esc_html($expert['phone']); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if (!empty($expert['social'])): ?>
                                    <div class="expert-social">
                                        <?php if (!empty($expert['social']['facebook'])): ?>
                                            <a href="<?php echo esc_url($expert['social']['facebook']); ?>" target="_blank" class="social-icon">
                                                <i class="icon-facebook"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($expert['social']['twitter'])): ?>
                                            <a href="<?php echo esc_url($expert['social']['twitter']); ?>" target="_blank" class="social-icon">
                                                <i class="icon-twitter"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($expert['social']['linkedin'])): ?>
                                            <a href="<?php echo esc_url($expert['social']['linkedin']); ?>" target="_blank" class="social-icon">
                                                <i class="icon-linkedin"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
    // Trả về nội dung đã được buffer
    return ob_get_clean();
}
// Đăng ký shortcode [nts_chuyen_gia]
add_shortcode('nts_chuyen_gia', 'nts_chuyen_gia_shortcode');

// Thêm CSS
function nts_chuyen_gia_css() {
    ?>
    <style>
    .nts-chuyen-gia {
        margin-bottom: 40px;
    }
    .nts-chuyen-gia .section-title {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        position: relative;
        overflow: hidden;
    }
    .nts-chuyen-gia .section-title span {
        display: inline-block;
        position: relative;
    }
    .nts-chuyen-gia .section-title span:before,
    .nts-chuyen-gia .section-title span:after {
        content: "";
        position: absolute;
        top: 50%;
        height: 1px;
        width: 100vw;
        background-color: #ddd;
    }
    .nts-chuyen-gia .section-title span:before {
        right: 100%;
        margin-right: 15px;
    }
    .nts-chuyen-gia .section-title span:after {
        left: 100%;
        margin-left: 15px;
    }
    .nts-experts-list {
        margin-bottom: 30px;
    }
    .expert-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .expert-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }
    .expert-avatar {
        text-align: center;
        padding: 20px 20px 0;
    }
    .expert-avatar img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f5f5f5;
    }
    .expert-info {
        padding: 15px 20px 20px;
    }
    .expert-name {
        margin: 0 0 5px;
        font-size: 18px;
        color: #333;
        text-align: center;
    }
    .expert-position {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
        text-align: center;
    }
    .expert-bio {
        font-size: 14px;
        line-height: 1.5;
        color: #555;
        margin-bottom: 15px;
    }
    .expert-contact {
        margin-bottom: 15px;
        font-size: 14px;
    }
    .expert-email, .expert-phone {
        margin-bottom: 5px;
    }
    .expert-email a, .expert-phone a {
        color: #555;
        text-decoration: none;
    }
    .expert-email a:hover, .expert-phone a:hover {
        color: #0073aa;
    }
    .expert-social {
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f5f5f5;
        color: #555;
        transition: background 0.3s, color 0.3s;
    }
    .social-icon:hover {
        background: #0073aa;
        color: #fff;
    }
    </style>
    <?php
}
add_action('wp_head', 'nts_chuyen_gia_css');
