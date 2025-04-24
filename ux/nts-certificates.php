<?php
// Đăng ký Element "NTS Chứng nhận và Giấy phép" cho Flatsome UX Builder
add_action('ux_builder_setup', 'nts_register_certificates_element');

function nts_register_certificates_element() {
    add_ux_builder_shortcode('nts_certificates', [
        'name'      => __('NTS Chứng nhận & Giấy phép', 'flatsome'),
        'category'  => __('Content', 'flatsome'),
        'options'   => [
            // Tiêu đề
            'title' => [
                'type'    => 'textfield',
                'heading' => __('Tiêu đề', 'flatsome'),
                'default' => 'Chứng nhận & Giấy phép',
            ],
            // Số lượng hiển thị
            'limit' => [
                'type'    => 'slider',
                'heading' => __('Số lượng hiển thị', 'flatsome'),
                'default' => -1,
                'min'     => -1,
                'max'     => 20,
                'step'    => 1,
            ],
            // Số cột
            'columns' => [
                'type'    => 'slider',
                'heading' => __('Số cột', 'flatsome'),
                'default' => 3,
                'min'     => 1,
                'max'     => 6,
                'step'    => 1,
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
            // Hiển thị thông tin
            'show_info' => [
                'type'    => 'checkbox',
                'heading' => __('Hiển thị thông tin chi tiết', 'flatsome'),
                'default' => 'true',
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
                'default' => 'nts-certificates',
            ],
        ],
    ]);
}

// Shortcode hiển thị danh sách chứng nhận và giấy phép
function nts_certificates_shortcode($atts) {
    // Xử lý các tham số đầu vào
    $atts = shortcode_atts([
        'title'       => 'Chứng nhận & Giấy phép',
        'limit'       => -1,
        'columns'     => 3,
        'style'       => 'grid',
        'show_info'   => 'true',
        'col_spacing' => 'normal',
        'class'       => 'nts-certificates'
    ], $atts, 'nts_certificates');
    
    // Lấy danh sách chứng nhận từ cơ sở dữ liệu
    $certificates = get_option('nts_certificates', []);
    
    // Giới hạn số lượng nếu cần
    if ($atts['limit'] > 0 && count($certificates) > $atts['limit']) {
        $certificates = array_slice($certificates, 0, $atts['limit']);
    }
    
    // Nếu không có chứng nhận nào, trả về thông báo
    if (empty($certificates)) {
        return '<div class="no-certificates">' . __('Chưa có chứng nhận hoặc giấy phép nào được thêm.', 'flatsome') . '</div>';
    }
    
    // Xác định các class cho container
    $classes = [];
    $classes[] = $atts['class'];
    
    // Xác định các class cho row
    $row_classes = [];
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
        
        <div class="certificates-list">
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
                
                foreach ($certificates as $certificate): 
                    $col_class = $atts['style'] === 'slider' ? 'slide' : 'col';
                ?>
                    <div class="<?php echo esc_attr($col_class); ?> <?php echo esc_attr($column_class); ?> small-12">
                        <div class="certificate-card">
                            <?php if (!empty($certificate['image'])): ?>
                                <div class="certificate-image">
                                    <img src="<?php echo esc_url($certificate['image']); ?>" alt="<?php echo esc_attr($certificate['name']); ?>">
                                </div>
                            <?php endif; ?>
                            
                            <div class="certificate-content">
                                <h3 class="certificate-name"><?php echo esc_html($certificate['name']); ?></h3>
                                
                                <?php if ($atts['show_info'] === 'true'): ?>
                                    <?php if (!empty($certificate['certificate_number'])): ?>
                                        <div class="certificate-number">
                                            <strong><?php _e('Số:', 'flatsome'); ?></strong> 
                                            <?php echo esc_html($certificate['certificate_number']); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($certificate['issuer'])): ?>
                                        <div class="certificate-issuer">
                                            <strong><?php _e('Đơn vị cấp:', 'flatsome'); ?></strong> 
                                            <?php echo esc_html($certificate['issuer']); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="certificate-dates">
                                        <?php if (!empty($certificate['issue_date'])): ?>
                                            <div class="issue-date">
                                                <strong><?php _e('Ngày cấp:', 'flatsome'); ?></strong> 
                                                <?php echo esc_html($certificate['issue_date']); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($certificate['expiry_date'])): ?>
                                            <div class="expiry-date">
                                                <strong><?php _e('Ngày hết hạn:', 'flatsome'); ?></strong> 
                                                <?php echo esc_html($certificate['expiry_date']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if (!empty($certificate['description'])): ?>
                                        <div class="certificate-description">
                                            <?php echo wp_kses_post($certificate['description']); ?>
                                        </div>
                                    <?php endif; ?>
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
// Đăng ký shortcode [nts_certificates]
add_shortcode('nts_certificates', 'nts_certificates_shortcode');

// Thêm CSS
function nts_certificates_css() {
    ?>
    <style>
    .nts-certificates {
        margin-bottom: 40px;
    }
    .nts-certificates .section-title {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        position: relative;
        overflow: hidden;
    }
    .nts-certificates .section-title span {
        display: inline-block;
        position: relative;
    }
    .nts-certificates .section-title span:before,
    .nts-certificates .section-title span:after {
        content: "";
        position: absolute;
        top: 50%;
        height: 1px;
        width: 100vw;
        background-color: #ddd;
    }
    .nts-certificates .section-title span:before {
        right: 100%;
        margin-right: 15px;
    }
    .nts-certificates .section-title span:after {
        left: 100%;
        margin-left: 15px;
    }
    .certificates-list {
        margin-bottom: 30px;
    }
    .certificate-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .certificate-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }
    .certificate-image {
        text-align: center;
        padding: 20px;
        background: #f9f9f9;
        border-bottom: 1px solid #eee;
    }
    .certificate-image img {
        max-width: 100%;
        max-height: 200px;
        width: auto;
        height: auto;
        object-fit: contain;
    }
    .certificate-content {
        padding: 15px 20px 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .certificate-name {
        margin: 0 0 10px;
        font-size: 18px;
        color: #333;
        text-align: center;
    }
    .certificate-number,
    .certificate-issuer,
    .issue-date,
    .expiry-date {
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
    }
    .certificate-dates {
        margin: 10px 0;
    }
    .certificate-description {
        font-size: 14px;
        line-height: 1.5;
        color: #666;
        margin-top: 10px;
        flex: 1;
    }
    </style>
    <?php
}
add_action('wp_head', 'nts_certificates_css');
