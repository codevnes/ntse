<?php
// Đăng ký NTS Công ty Thành viên Element cho Flatsome UX Builder
add_action('ux_builder_setup', 'nts_register_member_companies_element');

function nts_register_member_companies_element() {
    add_ux_builder_shortcode('nts_member_companies', array(
        'name' => __('NTS CT Thành Viên', 'flatsome'),
        'category' => __('Content', 'flatsome'),
        'options' => array(
            'style' => array(
                'type' => 'select',
                'heading' => __('Style hiển thị', 'flatsome'),
                'default' => 'grid',
                'options' => array(
                    'grid' => 'Lưới',
                    'slider' => 'Slider',
                ),
            ),
            'columns' => array(
                'type' => 'slider',
                'heading' => __('Số cột', 'flatsome'),
                'default' => 4,
                'min' => 1,
                'max' => 6,
            ),
            'col_spacing' => array(
                'type' => 'select',
                'heading' => __('Khoảng cách cột', 'flatsome'),
                'default' => 'normal',
                'options' => array(
                    'collapse' => 'Không',
                    'small' => 'Nhỏ',
                    'normal' => 'Bình thường',
                    'large' => 'Lớn',
                ),
            ),
            'show_name' => array(
                'type' => 'checkbox',
                'heading' => __('Hiển thị tên công ty', 'flatsome'),
                'default' => 'true',
            ),
            'show_info' => array(
                'type' => 'checkbox',
                'heading' => __('Hiển thị thông tin', 'flatsome'),
                'default' => 'true',
            ),
            'class' => array(
                'type' => 'textfield',
                'heading' => __('Custom CSS Class', 'flatsome'),
                'default' => '',
            ),
        ),
    ));
}

// Shortcode hiển thị công ty thành viên
function nts_member_companies_shortcode($atts) {
    extract(shortcode_atts(array(
        'style' => 'grid',
        'columns' => 4,
        'col_spacing' => 'normal',
        'show_name' => 'true',
        'show_info' => 'true',
        'class' => '',
    ), $atts));

    // Lấy danh sách công ty từ options
    $companies = get_option('nts_member_companies', array());
    if (empty($companies)) return '';

    $classes = array();
    $classes[] = 'row';
    $classes[] = 'row-' . $col_spacing;
    if ($style === 'slider') {
        $classes[] = 'slider';
        $classes[] = 'slider-nav-outside';
        $classes[] = 'slider-nav-push';
    }
    if ($class) {
        $classes[] = $class;
    }

    ob_start();
    ?>
    <div class="nts-member-companies">
        <div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
            <?php foreach ($companies as $company): 
                $col_class = $style === 'slider' ? 'slide' : 'col';
                $col_size = 12 / intval($columns);
            ?>
                <div class="<?php echo esc_attr($col_class); ?> medium-<?php echo esc_attr($col_size); ?> small-12">
                    <div class="company-item text-center">
                        <?php if (!empty($company['website'])): ?>
                            <a href="<?php echo esc_url($company['website']); ?>" target="_blank" rel="noopener">
                        <?php endif; ?>

                        <?php if (!empty($company['logo'])): ?>
                            <div class="company-logo">
                                <img src="<?php echo esc_url($company['logo']); ?>" 
                                     alt="<?php echo esc_attr($company['name']); ?>"
                                     class="company-logo-img">
                            </div>
                        <?php endif; ?>

                        <?php if ($show_name === 'true' && !empty($company['name'])): ?>
                            <h3 class="company-name"><?php echo esc_html($company['name']); ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($company['website'])): ?>
                            </a>
                        <?php endif; ?>

                        <?php if ($show_info === 'true' && !empty($company['info'])): ?>
                            <div class="company-info">
                                <?php echo wp_kses_post($company['info']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('nts_member_companies', 'nts_member_companies_shortcode');

// Thêm CSS
function nts_member_companies_css() {
    ?>
    <style>
        .nts-member-companies .company-item {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .nts-member-companies .company-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        .nts-member-companies .company-logo {
            margin-bottom: 15px;
            min-height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nts-member-companies .company-logo-img {
            max-width: 100%;
            max-height: 100px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .nts-member-companies .company-name {
            margin: 10px 0;
            font-size: 1.1em;
            color: #333;
        }

        .nts-member-companies .company-info {
            font-size: 0.9em;
            color: #666;
            margin-top: 10px;
        }

        .nts-member-companies a {
            color: inherit;
            text-decoration: none;
        }

        /* Slider styles */
        .nts-member-companies .slider {
            padding-bottom: 30px;
        }

        .nts-member-companies .slider .company-item {
            margin: 0 10px;
        }
    </style>
    <?php
}
add_action('wp_head', 'nts_member_companies_css');