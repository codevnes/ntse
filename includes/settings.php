<?php
/**
 * Đăng ký menu cài đặt "Nội dung" trong WordPress Admin
 */
function nts_register_content_settings_menu() {
    // Thêm menu chính
    add_menu_page(
        __('Cài đặt Nội dung', 'flatsome'), // Tiêu đề trang
        __('Nội dung', 'flatsome'),          // Tên menu
        'manage_options',                    // Capability required
        'nts-content-settings',              // Menu slug
        'nts_content_settings_page',         // Callback function
        'dashicons-edit',                    // Icon
        30                                   // Vị trí menu
    );

    // Thêm submenu
    add_submenu_page(
        'nts-content-settings',              // Parent slug
        __('Cài đặt chung', 'flatsome'),     // Tiêu đề trang
        __('Cài đặt chung', 'flatsome'),     // Tên menu
        'manage_options',                    // Capability
        'nts-content-settings',              // Menu slug
        'nts_content_settings_page'          // Callback function
    );

    // Thêm submenu khác nếu cần
    add_submenu_page(
        'nts-content-settings',
        __('Quản lý Banner', 'flatsome'),
        __('Quản lý Banner', 'flatsome'),
        'manage_options',
        'nts-banner-settings',
        'nts_banner_settings_page'
    );

    // Thêm submenu "Công ty Thành Viên"
    add_submenu_page(
        'nts-content-settings',
        __('Công ty Thành Viên', 'flatsome'),
        __('Công ty Thành Viên', 'flatsome'),
        'manage_options',
        'nts-member-companies',
        'nts_member_companies_page'
    );

    // Thêm submenu "Chuyên gia"
    add_submenu_page(
        'nts-content-settings',
        __('Chuyên gia', 'flatsome'),
        __('Chuyên gia', 'flatsome'),
        'manage_options',
        'nts-experts',
        'nts_experts_page'
    );

    // Thêm submenu "Chứng nhận và Giấy phép"
    add_submenu_page(
        'nts-content-settings',
        __('Chứng nhận và Giấy phép', 'flatsome'),
        __('Chứng nhận và Giấy phép', 'flatsome'),
        'manage_options',
        'nts-certificates',
        'nts_certificates_page'
    );

    // Thêm submenu "Lịch sử hình thành"
    add_submenu_page(
        'nts-content-settings',
        __('Lịch sử hình thành', 'flatsome'),
        __('Lịch sử hình thành', 'flatsome'),
        'manage_options',
        'nts-history',
        'nts_history_page'
    );

    // Thêm submenu "Đối tác"
    add_submenu_page(
        'nts-content-settings',
        __('Đối tác', 'flatsome'),
        __('Đối tác', 'flatsome'),
        'manage_options',
        'nts-partners',
        'nts_partners_page'
    );

    // Thêm submenu "Thông tin liên hệ"
    add_submenu_page(
        'nts-content-settings',
        __('Thông tin liên hệ', 'flatsome'),
        __('Thông tin liên hệ', 'flatsome'),
        'manage_options',
        'nts-contact-info',
        'nts_contact_info_page'
    );

    // Đăng ký các setting
    add_action('admin_init', 'nts_register_content_settings');
}
add_action('admin_menu', 'nts_register_content_settings_menu');

/**
 * Đăng ký các setting cho trang cài đặt
 */
function nts_register_content_settings() {
    // Đăng ký setting section
    add_settings_section(
        'nts_content_main_section',          // ID
        __('Cài đặt nội dung chính', 'flatsome'), // Tiêu đề
        'nts_content_section_callback',      // Callback function
        'nts-content-settings'               // Page
    );

    // Đăng ký các field
    register_setting('nts-content-settings', 'nts_homepage_intro');
    add_settings_field(
        'nts_homepage_intro',
        __('Giới thiệu trang chủ', 'flatsome'),
        'nts_homepage_intro_callback',
        'nts-content-settings',
        'nts_content_main_section'
    );

    register_setting('nts-content-settings', 'nts_contact_email');
    add_settings_field(
        'nts_contact_email',
        __('Email liên hệ', 'flatsome'),
        'nts_contact_email_callback',
        'nts-content-settings',
        'nts_content_main_section'
    );

    register_setting('nts-content-settings', 'nts_footer_text');
    add_settings_field(
        'nts_footer_text',
        __('Văn bản chân trang', 'flatsome'),
        'nts_footer_text_callback',
        'nts-content-settings',
        'nts_content_main_section'
    );
}

/**
 * Callback functions cho các field
 */
function nts_content_section_callback() {
    echo '<p>' . __('Cài đặt các thông tin nội dung chính cho website', 'flatsome') . '</p>';
}

function nts_homepage_intro_callback() {
    $value = get_option('nts_homepage_intro');
    wp_editor($value, 'nts_homepage_intro', array(
        'textarea_name' => 'nts_homepage_intro',
        'media_buttons' => false,
        'textarea_rows' => 5,
    ));
}

function nts_contact_email_callback() {
    $value = get_option('nts_contact_email');
    echo '<input type="email" name="nts_contact_email" value="' . esc_attr($value) . '" class="regular-text">';
}

function nts_footer_text_callback() {
    $value = get_option('nts_footer_text');
    echo '<textarea name="nts_footer_text" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
}

/**
 * Callback function cho trang cài đặt chính
 */
function nts_content_settings_page() {
    // Kiểm tra quyền truy cập
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền truy cập trang này.', 'flatsome'));
    }

    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

        <form method="post" action="options.php">
            <?php
            // Output các hidden fields cần thiết
            settings_fields('nts-content-settings');
            // Output các sections và fields
            do_settings_sections('nts-content-settings');
            // Nút submit
            submit_button(__('Lưu thay đổi', 'flatsome'));
            ?>
        </form>
    </div>
    <?php
}

/**
 * Callback function cho trang quản lý banner
 */
function nts_banner_settings_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền truy cập trang này.', 'flatsome'));
    }

    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Quản lý Banner', 'flatsome'); ?></h1>
        <p><?php _e('Cài đặt các banner quảng cáo trên website', 'flatsome'); ?></p>

        <!-- Thêm nội dung quản lý banner tại đây -->
    </div>
    <?php
}

// Đăng ký settings cho công ty thành viên
function nts_register_member_companies_settings() {
    register_setting('nts-member-companies', 'nts_member_companies', array(
        'type' => 'array',
        'sanitize_callback' => 'nts_sanitize_member_companies'
    ));
}
add_action('admin_init', 'nts_register_member_companies_settings');

// Đăng ký settings cho chuyên gia
function nts_register_experts_settings() {
    register_setting('nts-experts', 'nts_experts', array(
        'type' => 'array',
        'sanitize_callback' => 'nts_sanitize_experts'
    ));
}
add_action('admin_init', 'nts_register_experts_settings');

// Đăng ký settings cho chứng nhận và giấy phép
function nts_register_certificates_settings() {
    register_setting('nts-certificates', 'nts_certificates', array(
        'type' => 'array',
        'sanitize_callback' => 'nts_sanitize_certificates'
    ));
}
add_action('admin_init', 'nts_register_certificates_settings');

// Đăng ký settings cho lịch sử hình thành
function nts_register_history_settings() {
    register_setting('nts-history', 'nts_history', [
        'type' => 'array',
        'sanitize_callback' => 'nts_sanitize_history'
    ]);
}
add_action('admin_init', 'nts_register_history_settings');

// Đăng ký settings cho đối tác
function nts_register_partners_settings() {
    register_setting('nts-partners', 'nts_partners', [
        'type' => 'array',
        'sanitize_callback' => 'nts_sanitize_partners'
    ]);
}
add_action('admin_init', 'nts_register_partners_settings');

// Hàm sanitize dữ liệu
function nts_sanitize_member_companies($companies) {
    if (!is_array($companies)) {
        return array();
    }

    $sanitized = array();
    foreach ($companies as $company) {
        if (!empty($company['name'])) {
            $sanitized[] = array(
                'name' => sanitize_text_field($company['name']),
                'logo' => esc_url_raw($company['logo']),
                'website' => esc_url_raw($company['website']),
                'info' => wp_kses_post($company['info'])
            );
        }
    }
    return $sanitized;
}

// Callback function cho trang quản lý công ty thành viên
function nts_member_companies_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền truy cập trang này.', 'flatsome'));
    }

    // Lưu dữ liệu khi submit
    if (isset($_POST['submit']) && check_admin_referer('nts_member_companies_nonce')) {
        $companies = isset($_POST['companies']) ? $_POST['companies'] : array();
        update_option('nts_member_companies', $companies);
        echo '<div class="notice notice-success"><p>'. __('Đã lưu thay đổi.', 'flatsome') .'</p></div>';
    }

    // Lấy dữ liệu hiện tại
    $companies = get_option('nts_member_companies', array());
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Quản lý Công ty Thành Viên', 'flatsome'); ?></h1>

        <form method="post" action="">
            <?php wp_nonce_field('nts_member_companies_nonce'); ?>

            <div id="member-companies-container">
                <?php
                if (!empty($companies)) {
                    foreach ($companies as $index => $company) {
                        nts_render_company_fields($index, $company);
                    }
                }
                ?>
            </div>

            <button type="button" class="button" id="add-company">
                <?php _e('Thêm Công ty', 'flatsome'); ?>
            </button>

            <?php submit_button(__('Lưu thay đổi', 'flatsome')); ?>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var template = `<?php ob_start(); nts_render_company_fields('INDEX', array()); $template = ob_get_clean(); echo str_replace(array("\r", "\n"), '', $template); ?>`;

        $('#add-company').on('click', function() {
            var index = $('#member-companies-container .company-item').length;
            var html = template.replace(/INDEX/g, index);
            $('#member-companies-container').append(html);
        });

        $(document).on('click', '.remove-company', function() {
            if (confirm('<?php _e("Bạn có chắc muốn xóa công ty này?", "flatsome"); ?>')) {
                $(this).closest('.company-item').slideUp(300, function() {
                    $(this).remove();
                });
            }
        });

        $(document).on('click', '.upload-logo', function(e) {
            e.preventDefault();
            var button = $(this);
            var logoInput = button.parent().find('.logo-url');
            var logoPreview = button.closest('.form-field').find('.logo-preview');

            var frame = wp.media({
                title: '<?php _e("Chọn Logo", "flatsome"); ?>',
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                logoInput.val(attachment.url);
                logoPreview.attr('src', attachment.url).show();
            });

            frame.open();
        });
    });
    </script>
    <?php
}

// Đăng ký scripts và styles
add_action('admin_enqueue_scripts', 'nts_member_companies_admin_assets');

function nts_member_companies_admin_assets($hook) {
    if ('noi-dung_page_nts-member-companies' !== $hook) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('jquery');

    // Đăng ký style chính
    wp_register_style('nts-member-companies-style', false); // false vì chúng ta sẽ dùng inline style
    wp_enqueue_style('nts-member-companies-style');

    // Thêm CSS inline
    wp_add_inline_style('nts-member-companies-style', '
        .company-item {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .company-item h3 {
            margin: 0 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .logo-container {
            flex: 0 0 120px;
        }
        .logo-wrapper {
            width: 120px;
            height: 80px;
            border: 2px dashed #ddd;
            background: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
        }
        .logo-wrapper:hover {
            border-color: #2271b1;
        }
        .logo-preview {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }
        .logo-remove {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #fff;
            border: 1px solid #ddd;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            display: none;
        }
        .logo-wrapper:hover .logo-remove {
            display: flex;
        }
        .logo-remove:hover {
            background: #dc3232;
            border-color: #dc3232;
        }
        .logo-remove:hover svg path {
            fill: #fff;
        }
        .company-info {
            flex: 1;
        }
        .form-field {
            margin-bottom: 15px;
        }
        .form-field:last-child {
            margin-bottom: 0;
        }
        .form-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .form-field input[type="text"],
        .form-field input[type="url"],
        .form-field textarea {
            width: 100%;
            max-width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-field textarea {
            min-height: 100px;
            resize: vertical;
        }
        .button.remove-company {
            color: #dc3232;
            border-color: #dc3232;
        }
        .button.remove-company:hover {
            background: #dc3232;
            color: #fff;
        }
        #add-company {
            margin: 15px 0;
        }
        .logo-placeholder svg {
            opacity: 0.5;
        }
    ');

    // Đăng ký và enqueue script
    wp_register_script('nts-member-companies', false);
    wp_enqueue_script('nts-member-companies');

    // Thêm JavaScript inline
    wp_add_inline_script('nts-member-companies', '
        jQuery(document).ready(function($) {
            var template = `' . nts_get_company_template() . '`;

            $("#add-company").on("click", function() {
                var index = $("#member-companies-container .company-item").length;
                var html = template.replace(/INDEX/g, index);
                $("#member-companies-container").append(html);
            });

            $(document).on("click", ".remove-company", function() {
                if (confirm("' . esc_js(__("Bạn có chắc muốn xóa công ty này?", "flatsome")) . '")) {
                    $(this).closest(".company-item").slideUp(300, function() {
                        $(this).remove();
                    });
                }
            });

            $(document).on("click", ".upload-logo", function(e) {
                e.preventDefault();
                var button = $(this);
                var logoInput = button.parent().find(".logo-url");
                var logoWrapper = button.closest(".logo-wrapper");

                var frame = wp.media({
                    title: "' . esc_js(__("Chọn Logo", "flatsome")) . '",
                    multiple: false
                });

                frame.on("select", function() {
                    var attachment = frame.state().get("selection").first().toJSON();
                    logoInput.val(attachment.url);
                    logoWrapper.html(`
                        <img src="${attachment.url}" class="logo-preview">
                        <div class="logo-remove" title="' . esc_js(__("Xóa logo", "flatsome")) . '">
                            <svg width="14" height="14" viewBox="0 0 24 24">
                                <path fill="#666" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                        </div>
                    `);
                });

                frame.open();
            });

            $(document).on("click", ".logo-remove", function(e) {
                e.preventDefault();
                e.stopPropagation();
                var wrapper = $(this).closest(".logo-wrapper");
                wrapper.find(".logo-url").val("");
                wrapper.html(`
                    <div class="logo-placeholder">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <path fill="#666" d="M19.5 12c-2.483 0-4.5 2.015-4.5 4.5s2.017 4.5 4.5 4.5 4.5-2.015 4.5-4.5-2.017-4.5-4.5-4.5zm2.5 5h-2v2h-1v-2h-2v-1h2v-2h1v2h2v1zm-7.18 4h-14.82v-20h20v10.209c.867.584 1.599 1.33 2 2.191v-13.4c0-.553-.447-1-1-1h-22c-.553 0-1 .447-1 1v22c0 .553.447 1 1 1h17.18c-.685-.645-1.239-1.439-1.576-2.334l-.804-1.666zm-11.82-3h8v-1h-8v1zm0-3h8v-1h-8v1zm0-3h8v-1h-8v1zm0-3h16v-1h-16v1z"/>
                        </svg>
                    </div>
                `);
            });
        });
    ');
}

// Hàm render form fields
function nts_render_company_fields($index, $company = array()) {
    $name = isset($company['name']) ? $company['name'] : '';
    $logo = isset($company['logo']) ? $company['logo'] : '';
    $website = isset($company['website']) ? $company['website'] : '';
    $info = isset($company['info']) ? $company['info'] : '';
    ?>
    <div class="company-item">
        <h3>
            <span><?php _e('Thông tin công ty', 'flatsome'); ?></span>
            <button type="button" class="button remove-company">
                <?php _e('Xóa', 'flatsome'); ?>
            </button>
        </h3>

        <div class="form-row">
            <div class="logo-container">
                <input type="hidden" name="companies[<?php echo $index; ?>][logo]"
                       value="<?php echo esc_url($logo); ?>" class="logo-url">
                <div class="logo-wrapper upload-logo">
                    <?php if ($logo): ?>
                        <img src="<?php echo esc_url($logo); ?>" class="logo-preview">
                        <div class="logo-remove" title="<?php _e('Xóa logo', 'flatsome'); ?>">
                            <svg width="14" height="14" viewBox="0 0 24 24">
                                <path fill="#666" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                        </div>
                    <?php else: ?>
                        <div class="logo-placeholder">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <path fill="#666" d="M19.5 12c-2.483 0-4.5 2.015-4.5 4.5s2.017 4.5 4.5 4.5 4.5-2.015 4.5-4.5-2.017-4.5-4.5-4.5zm2.5 5h-2v2h-1v-2h-2v-1h2v-2h1v2h2v1zm-7.18 4h-14.82v-20h20v10.209c.867.584 1.599 1.33 2 2.191v-13.4c0-.553-.447-1-1-1h-22c-.553 0-1 .447-1 1v22c0 .553.447 1 1 1h17.18c-.685-.645-1.239-1.439-1.576-2.334l-.804-1.666zm-11.82-3h8v-1h-8v1zm0-3h8v-1h-8v1zm0-3h8v-1h-8v1zm0-3h16v-1h-16v1z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="company-info">
                <div class="form-field">
                    <label><?php _e('Tên công ty:', 'flatsome'); ?></label>
                    <input type="text" name="companies[<?php echo $index; ?>][name]"
                           value="<?php echo esc_attr($name); ?>">
                </div>

                <div class="form-field">
                    <label><?php _e('Website:', 'flatsome'); ?></label>
                    <input type="url" name="companies[<?php echo $index; ?>][website]"
                           value="<?php echo esc_url($website); ?>">
                </div>

                <div class="info-field">
                    <label><?php _e('Thông tin:', 'flatsome'); ?></label>
                    <textarea name="companies[<?php echo $index; ?>][info]" rows="4"><?php
                        echo esc_textarea($info);
                    ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <?php
}

// Helper function to get company template
function nts_get_company_template() {
    ob_start();
    nts_render_company_fields('INDEX', array());
    return str_replace(array("\r", "\n"), '', ob_get_clean());
}

// Hàm sanitize dữ liệu chuyên gia
function nts_sanitize_experts($experts) {
    if (!is_array($experts)) {
        return array();
    }

    $sanitized = array();
    foreach ($experts as $expert) {
        if (!empty($expert['name'])) {
            $sanitized[] = array(
                'name' => sanitize_text_field($expert['name']),
                'avatar' => esc_url_raw($expert['avatar']),
                'position' => sanitize_text_field($expert['position']),
                'bio' => wp_kses_post($expert['bio']),
                'email' => sanitize_email($expert['email']),
                'phone' => sanitize_text_field($expert['phone']),
                'social' => array(
                    'facebook' => esc_url_raw($expert['social']['facebook'] ?? ''),
                    'twitter' => esc_url_raw($expert['social']['twitter'] ?? ''),
                    'linkedin' => esc_url_raw($expert['social']['linkedin'] ?? ''),
                )
            );
        }
    }
    return $sanitized;
}

// Callback function cho trang quản lý chuyên gia
function nts_experts_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền truy cập trang này.', 'flatsome'));
    }

    // Lưu dữ liệu khi submit
    if (isset($_POST['submit']) && check_admin_referer('nts_experts_nonce')) {
        $experts = isset($_POST['experts']) ? $_POST['experts'] : array();
        update_option('nts_experts', $experts);
        echo '<div class="notice notice-success"><p>'. __('Đã lưu thay đổi.', 'flatsome') .'</p></div>';
    }

    // Lấy dữ liệu hiện tại
    $experts = get_option('nts_experts', array());
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Quản lý Chuyên gia', 'flatsome'); ?></h1>

        <form method="post" action="">
            <?php wp_nonce_field('nts_experts_nonce'); ?>

            <div id="experts-container">
                <?php
                if (!empty($experts)) {
                    foreach ($experts as $index => $expert) {
                        nts_render_expert_fields($index, $expert);
                    }
                }
                ?>
            </div>

            <button type="button" class="button" id="add-expert">
                <?php _e('Thêm Chuyên gia', 'flatsome'); ?>
            </button>

            <?php submit_button(__('Lưu thay đổi', 'flatsome')); ?>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var template = `<?php ob_start(); nts_render_expert_fields('INDEX', array()); $template = ob_get_clean(); echo str_replace(array("\r", "\n"), '', $template); ?>`;

        $('#add-expert').on('click', function() {
            var index = $('#experts-container .expert-item').length;
            var html = template.replace(/INDEX/g, index);
            $('#experts-container').append(html);
        });

        $(document).on('click', '.remove-expert', function() {
            if (confirm('<?php _e("Bạn có chắc muốn xóa chuyên gia này?", "flatsome"); ?>')) {
                $(this).closest('.expert-item').slideUp(300, function() {
                    $(this).remove();
                });
            }
        });

        $(document).on('click', '.upload-avatar', function(e) {
            e.preventDefault();
            var button = $(this);
            var avatarInput = button.parent().find('.avatar-url');
            var avatarWrapper = button.closest('.avatar-wrapper');

            var frame = wp.media({
                title: '<?php _e("Chọn Ảnh đại diện", "flatsome"); ?>',
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                avatarInput.val(attachment.url);
                avatarWrapper.html(`
                    <img src="${attachment.url}" class="avatar-preview">
                    <div class="avatar-remove" title="<?php _e("Xóa ảnh", "flatsome"); ?>">
                        <svg width="14" height="14" viewBox="0 0 24 24">
                            <path fill="#666" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </div>
                `);
            });

            frame.open();
        });

        $(document).on('click', '.avatar-remove', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var wrapper = $(this).closest('.avatar-wrapper');
            wrapper.find('.avatar-url').val('');
            wrapper.html(`
                <div class="avatar-placeholder">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#666" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                </div>
            `);
        });
    });
    </script>
    <?php
}

// Đăng ký scripts và styles cho trang chuyên gia
add_action('admin_enqueue_scripts', 'nts_experts_admin_assets');

function nts_experts_admin_assets($hook) {
    if ('noi-dung_page_nts-experts' !== $hook) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('jquery');

    // Đăng ký style chính
    wp_register_style('nts-experts-style', false); // false vì chúng ta sẽ dùng inline style
    wp_enqueue_style('nts-experts-style');

    // Thêm CSS inline
    wp_add_inline_style('nts-experts-style', '
        .expert-item {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .expert-item h3 {
            margin: 0 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .avatar-container {
            flex: 0 0 120px;
        }
        .avatar-wrapper {
            width: 120px;
            height: 120px;
            border: 2px dashed #ddd;
            background: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
            border-radius: 50%;
            overflow: hidden;
        }
        .avatar-wrapper:hover {
            border-color: #2271b1;
        }
        .avatar-preview {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }
        .avatar-remove {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #fff;
            border: 1px solid #ddd;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            display: none;
        }
        .avatar-wrapper:hover .avatar-remove {
            display: flex;
        }
        .avatar-remove:hover {
            background: #dc3232;
            border-color: #dc3232;
        }
        .avatar-remove:hover svg path {
            fill: #fff;
        }
        .expert-info {
            flex: 1;
        }
        .form-field {
            margin-bottom: 15px;
        }
        .form-field:last-child {
            margin-bottom: 0;
        }
        .form-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .form-field input[type="text"],
        .form-field input[type="email"],
        .form-field input[type="url"],
        .form-field textarea {
            width: 100%;
            max-width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-field textarea {
            min-height: 100px;
            resize: vertical;
        }
        .button.remove-expert {
            color: #dc3232;
            border-color: #dc3232;
        }
        .button.remove-expert:hover {
            background: #dc3232;
            color: #fff;
        }
        #add-expert {
            margin: 15px 0;
        }
        .avatar-placeholder svg {
            opacity: 0.5;
        }
        .social-fields {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        .social-fields h4 {
            margin-top: 0;
            margin-bottom: 10px;
        }
    ');
}

// Hàm render form fields cho chuyên gia
function nts_render_expert_fields($index, $expert = array()) {
    $name = isset($expert['name']) ? $expert['name'] : '';
    $avatar = isset($expert['avatar']) ? $expert['avatar'] : '';
    $position = isset($expert['position']) ? $expert['position'] : '';
    $bio = isset($expert['bio']) ? $expert['bio'] : '';
    $email = isset($expert['email']) ? $expert['email'] : '';
    $phone = isset($expert['phone']) ? $expert['phone'] : '';
    $social = isset($expert['social']) ? $expert['social'] : array();
    $facebook = isset($social['facebook']) ? $social['facebook'] : '';
    $twitter = isset($social['twitter']) ? $social['twitter'] : '';
    $linkedin = isset($social['linkedin']) ? $social['linkedin'] : '';
    ?>
    <div class="expert-item">
        <h3>
            <span><?php _e('Thông tin chuyên gia', 'flatsome'); ?></span>
            <button type="button" class="button remove-expert">
                <?php _e('Xóa', 'flatsome'); ?>
            </button>
        </h3>

        <div class="form-row">
            <div class="avatar-container">
                <input type="hidden" name="experts[<?php echo $index; ?>][avatar]"
                       value="<?php echo esc_url($avatar); ?>" class="avatar-url">
                <div class="avatar-wrapper upload-avatar">
                    <?php if ($avatar): ?>
                        <img src="<?php echo esc_url($avatar); ?>" class="avatar-preview">
                        <div class="avatar-remove" title="<?php _e('Xóa ảnh', 'flatsome'); ?>">
                            <svg width="14" height="14" viewBox="0 0 24 24">
                                <path fill="#666" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                        </div>
                    <?php else: ?>
                        <div class="avatar-placeholder">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <path fill="#666" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="expert-info">
                <div class="form-field">
                    <label><?php _e('Tên chuyên gia:', 'flatsome'); ?></label>
                    <input type="text" name="experts[<?php echo $index; ?>][name]"
                           value="<?php echo esc_attr($name); ?>">
                </div>

                <div class="form-field">
                    <label><?php _e('Chức vụ:', 'flatsome'); ?></label>
                    <input type="text" name="experts[<?php echo $index; ?>][position]"
                           value="<?php echo esc_attr($position); ?>">
                </div>

                <div class="form-field">
                    <label><?php _e('Email:', 'flatsome'); ?></label>
                    <input type="email" name="experts[<?php echo $index; ?>][email]"
                           value="<?php echo esc_attr($email); ?>">
                </div>

                <div class="form-field">
                    <label><?php _e('Số điện thoại:', 'flatsome'); ?></label>
                    <input type="text" name="experts[<?php echo $index; ?>][phone]"
                           value="<?php echo esc_attr($phone); ?>">
                </div>

                <div class="form-field">
                    <label><?php _e('Tiểu sử:', 'flatsome'); ?></label>
                    <textarea name="experts[<?php echo $index; ?>][bio]" rows="4"><?php
                        echo esc_textarea($bio);
                    ?></textarea>
                </div>

                <div class="social-fields">
                    <h4><?php _e('Mạng xã hội', 'flatsome'); ?></h4>

                    <div class="form-field">
                        <label><?php _e('Facebook:', 'flatsome'); ?></label>
                        <input type="url" name="experts[<?php echo $index; ?>][social][facebook]"
                               value="<?php echo esc_url($facebook); ?>">
                    </div>

                    <div class="form-field">
                        <label><?php _e('Twitter:', 'flatsome'); ?></label>
                        <input type="url" name="experts[<?php echo $index; ?>][social][twitter]"
                               value="<?php echo esc_url($twitter); ?>">
                    </div>

                    <div class="form-field">
                        <label><?php _e('LinkedIn:', 'flatsome'); ?></label>
                        <input type="url" name="experts[<?php echo $index; ?>][social][linkedin]"
                               value="<?php echo esc_url($linkedin); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

// Helper function to get expert template
function nts_get_expert_template() {
    ob_start();
    nts_render_expert_fields('INDEX', array());
    return str_replace(array("\r", "\n"), '', ob_get_clean());
}

// Hàm sanitize dữ liệu chứng nhận và giấy phép
function nts_sanitize_certificates($certificates) {
    if (!is_array($certificates)) {
        return [];
    }

    $sanitized = [];
    foreach ($certificates as $certificate) {
        if (!empty($certificate['name'])) {
            $sanitized[] = [
                'name' => sanitize_text_field($certificate['name']),
                'image' => esc_url_raw($certificate['image']),
                'description' => wp_kses_post($certificate['description']),
                'issue_date' => sanitize_text_field($certificate['issue_date']),
                'expiry_date' => sanitize_text_field($certificate['expiry_date']),
                'issuer' => sanitize_text_field($certificate['issuer']),
                'certificate_number' => sanitize_text_field($certificate['certificate_number'])
            ];
        }
    }
    return $sanitized;
}

// Callback function cho trang quản lý chứng nhận và giấy phép
function nts_certificates_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền truy cập trang này.', 'flatsome'));
    }

    // Lưu dữ liệu khi submit
    if (isset($_POST['submit']) && check_admin_referer('nts_certificates_nonce')) {
        $certificates = isset($_POST['certificates']) ? $_POST['certificates'] : [];
        update_option('nts_certificates', $certificates);
        echo '<div class="notice notice-success"><p>'. __('Đã lưu thay đổi.', 'flatsome') .'</p></div>';
    }

    // Lấy dữ liệu hiện tại
    $certificates = get_option('nts_certificates', []);
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Quản lý Chứng nhận và Giấy phép', 'flatsome'); ?></h1>

        <form method="post" action="">
            <?php wp_nonce_field('nts_certificates_nonce'); ?>

            <div id="certificates-container">
                <?php
                if (!empty($certificates)) {
                    foreach ($certificates as $index => $certificate) {
                        nts_render_certificate_fields($index, $certificate);
                    }
                }
                ?>
            </div>

            <button type="button" class="button" id="add-certificate">
                <?php _e('Thêm Chứng nhận / Giấy phép', 'flatsome'); ?>
            </button>

            <?php submit_button(__('Lưu thay đổi', 'flatsome')); ?>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var template = `<?php ob_start(); nts_render_certificate_fields('INDEX', []); $template = ob_get_clean(); echo str_replace(["\r", "\n"], '', $template); ?>`;

        $('#add-certificate').on('click', function() {
            var index = $('#certificates-container .certificate-item').length;
            var html = template.replace(/INDEX/g, index);
            $('#certificates-container').append(html);
        });

        $(document).on('click', '.remove-certificate', function() {
            if (confirm('<?php _e("Bạn có chắc muốn xóa chứng nhận/giấy phép này?", "flatsome"); ?>')) {
                $(this).closest('.certificate-item').slideUp(300, function() {
                    $(this).remove();
                });
            }
        });

        $(document).on('click', '.upload-certificate-image', function(e) {
            e.preventDefault();
            var button = $(this);
            var imageInput = button.parent().find('.image-url');
            var imageWrapper = button.closest('.image-wrapper');

            var frame = wp.media({
                title: '<?php _e("Chọn Hình ảnh", "flatsome"); ?>',
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                imageInput.val(attachment.url);
                imageWrapper.html(`
                    <img src="${attachment.url}" class="certificate-image-preview">
                    <div class="image-remove" title="<?php _e("Xóa ảnh", "flatsome"); ?>">
                        <svg width="14" height="14" viewBox="0 0 24 24">
                            <path fill="#666" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </div>
                `);
            });

            frame.open();
        });

        $(document).on('click', '.image-remove', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var wrapper = $(this).closest('.image-wrapper');
            wrapper.find('.image-url').val('');
            wrapper.html(`
                <div class="image-placeholder">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#666" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/>
                    </svg>
                </div>
            `);
        });

        // Datepicker for dates
        if ($.fn.datepicker) {
            $(document).on('focus', '.date-field', function() {
                $(this).datepicker({
                    dateFormat: 'yy-mm-dd'
                });
            });
        }
    });
    </script>
    <?php
}

// Đăng ký scripts và styles cho trang chứng nhận
add_action('admin_enqueue_scripts', 'nts_certificates_admin_assets');

function nts_certificates_admin_assets($hook) {
    if ('noi-dung_page_nts-certificates' !== $hook) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');

    // Đăng ký style chính
    wp_register_style('nts-certificates-style', false); // false vì chúng ta sẽ dùng inline style
    wp_enqueue_style('nts-certificates-style');

    // Thêm CSS inline
    wp_add_inline_style('nts-certificates-style', '
        .certificate-item {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .certificate-item h3 {
            margin: 0 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .image-container {
            flex: 0 0 150px;
        }
        .image-wrapper {
            width: 150px;
            height: 100px;
            border: 2px dashed #ddd;
            background: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }
        .image-wrapper:hover {
            border-color: #2271b1;
        }
        .certificate-image-preview {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }
        .image-remove {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #fff;
            border: 1px solid #ddd;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            display: none;
        }
        .image-wrapper:hover .image-remove {
            display: flex;
        }
        .image-remove:hover {
            background: #dc3232;
            border-color: #dc3232;
        }
        .image-remove:hover svg path {
            fill: #fff;
        }
        .certificate-info {
            flex: 1;
        }
        .form-field {
            margin-bottom: 15px;
        }
        .form-field:last-child {
            margin-bottom: 0;
        }
        .form-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .form-field input[type="text"],
        .form-field input[type="date"],
        .form-field textarea {
            width: 100%;
            max-width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-field textarea {
            min-height: 100px;
            resize: vertical;
        }
        .button.remove-certificate {
            color: #dc3232;
            border-color: #dc3232;
        }
        .button.remove-certificate:hover {
            background: #dc3232;
            color: #fff;
        }
        #add-certificate {
            margin: 15px 0;
        }
        .image-placeholder svg {
            opacity: 0.5;
        }
        .date-fields {
            display: flex;
            gap: 15px;
        }
        .date-fields .form-field {
            flex: 1;
        }
    ');
}

// Hàm render form fields cho chứng nhận
function nts_render_certificate_fields($index, $certificate = []) {
    $name = $certificate['name'] ?? '';
    $image = $certificate['image'] ?? '';
    $description = $certificate['description'] ?? '';
    $issue_date = $certificate['issue_date'] ?? '';
    $expiry_date = $certificate['expiry_date'] ?? '';
    $issuer = $certificate['issuer'] ?? '';
    $certificate_number = $certificate['certificate_number'] ?? '';
    ?>
    <div class="certificate-item">
        <h3>
            <span><?php _e('Thông tin chứng nhận/giấy phép', 'flatsome'); ?></span>
            <button type="button" class="button remove-certificate">
                <?php _e('Xóa', 'flatsome'); ?>
            </button>
        </h3>

        <div class="form-row">
            <div class="image-container">
                <input type="hidden" name="certificates[<?php echo $index; ?>][image]"
                       value="<?php echo esc_url($image); ?>" class="image-url">
                <div class="image-wrapper upload-certificate-image">
                    <?php if ($image): ?>
                        <img src="<?php echo esc_url($image); ?>" class="certificate-image-preview">
                        <div class="image-remove" title="<?php _e('Xóa ảnh', 'flatsome'); ?>">
                            <svg width="14" height="14" viewBox="0 0 24 24">
                                <path fill="#666" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                        </div>
                    <?php else: ?>
                        <div class="image-placeholder">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <path fill="#666" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="certificate-info">
                <div class="form-field">
                    <label><?php _e('Tên chứng nhận/giấy phép:', 'flatsome'); ?></label>
                    <input type="text" name="certificates[<?php echo $index; ?>][name]"
                           value="<?php echo esc_attr($name); ?>">
                </div>

                <div class="form-field">
                    <label><?php _e('Số chứng nhận/giấy phép:', 'flatsome'); ?></label>
                    <input type="text" name="certificates[<?php echo $index; ?>][certificate_number]"
                           value="<?php echo esc_attr($certificate_number); ?>">
                </div>

                <div class="form-field">
                    <label><?php _e('Đơn vị cấp:', 'flatsome'); ?></label>
                    <input type="text" name="certificates[<?php echo $index; ?>][issuer]"
                           value="<?php echo esc_attr($issuer); ?>">
                </div>

                <div class="date-fields">
                    <div class="form-field">
                        <label><?php _e('Ngày cấp:', 'flatsome'); ?></label>
                        <input type="text" name="certificates[<?php echo $index; ?>][issue_date]"
                               value="<?php echo esc_attr($issue_date); ?>" class="date-field">
                    </div>

                    <div class="form-field">
                        <label><?php _e('Ngày hết hạn:', 'flatsome'); ?></label>
                        <input type="text" name="certificates[<?php echo $index; ?>][expiry_date]"
                               value="<?php echo esc_attr($expiry_date); ?>" class="date-field">
                    </div>
                </div>

                <div class="form-field">
                    <label><?php _e('Mô tả:', 'flatsome'); ?></label>
                    <textarea name="certificates[<?php echo $index; ?>][description]" rows="4"><?php
                        echo esc_textarea($description);
                    ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <?php
}

// Helper function to get certificate template
function nts_get_certificate_template() {
    ob_start();
    nts_render_certificate_fields('INDEX', []);
    return str_replace(["\r", "\n"], '', ob_get_clean());
}

// Hàm sanitize dữ liệu lịch sử hình thành
function nts_sanitize_history($history_items) {
    if (!is_array($history_items)) {
        return [];
    }

    $sanitized = [];
    foreach ($history_items as $item) {
        if (!empty($item['year'])) {
            $sanitized[] = [
                'year' => sanitize_text_field($item['year']),
                'title' => sanitize_text_field($item['title']),
                'description' => wp_kses_post($item['description']),
                'image' => esc_url_raw($item['image'])
            ];
        }
    }

    // Sắp xếp theo năm tăng dần
    usort($sanitized, function($a, $b) {
        return $a['year'] <=> $b['year'];
    });

    return $sanitized;
}

// Hàm sanitize dữ liệu đối tác
function nts_sanitize_partners($partners) {
    if (!is_array($partners)) {
        return [];
    }

    $sanitized = [];
    foreach ($partners as $partner) {
        if (!empty($partner['name'])) {
            $sanitized[] = [
                'name' => sanitize_text_field($partner['name']),
                'logo' => esc_url_raw($partner['logo']),
                'website' => esc_url_raw($partner['website']),
                'description' => wp_kses_post($partner['description']),
                'type' => sanitize_text_field($partner['type'])
            ];
        }
    }
    return $sanitized;
}

// Callback function cho trang quản lý đối tác
function nts_partners_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền truy cập trang này.', 'flatsome'));
    }

    // Lưu dữ liệu khi submit
    if (isset($_POST['submit']) && check_admin_referer('nts_partners_nonce')) {
        $partners = $_POST['partners'] ?? [];
        update_option('nts_partners', $partners);
        echo '<div class="notice notice-success"><p>'. __('Đã lưu thay đổi.', 'flatsome') .'</p></div>';
    }

    // Lấy dữ liệu hiện tại
    $partners = get_option('nts_partners', []);
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Quản lý Đối tác', 'flatsome'); ?></h1>

        <form method="post" action="">
            <?php wp_nonce_field('nts_partners_nonce'); ?>

            <div id="partners-container">
                <?php
                if (!empty($partners)) {
                    foreach ($partners as $index => $partner) {
                        nts_render_partner_fields($index, $partner);
                    }
                }
                ?>
            </div>

            <button type="button" class="button" id="add-partner">
                <?php _e('Thêm Đối tác', 'flatsome'); ?>
            </button>

            <?php submit_button(__('Lưu thay đổi', 'flatsome')); ?>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var template = `<?php ob_start(); nts_render_partner_fields('INDEX', []); $template = ob_get_clean(); echo str_replace(["\
", "\
"], '', $template); ?>`;

        $('#add-partner').on('click', function() {
            var index = $('#partners-container .partner-item').length;
            var html = template.replace(/INDEX/g, index);
            $('#partners-container').append(html);
        });

        $(document).on('click', '.remove-partner', function() {
            if (confirm('<?php _e("Bạn có chắc muốn xóa đối tác này?", "flatsome"); ?>')) {
                $(this).closest('.partner-item').slideUp(300, function() {
                    $(this).remove();
                });
            }
        });

        $(document).on('click', '.upload-logo', function(e) {
            e.preventDefault();
            var button = $(this);
            var logoInput = button.parent().find('.logo-url');
            var logoWrapper = button.closest('.logo-wrapper');

            var frame = wp.media({
                title: '<?php _e("Chọn Logo", "flatsome"); ?>',
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                logoInput.val(attachment.url);
                logoWrapper.html(`
                    <img src="${attachment.url}" class="logo-preview">
                    <div class="logo-remove" title="<?php _e("Xóa logo", "flatsome"); ?>">
                        <svg width="14" height="14" viewBox="0 0 24 24">
                            <path fill="#666" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </div>
                `);
            });

            frame.open();
        });

        $(document).on('click', '.logo-remove', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var wrapper = $(this).closest('.logo-wrapper');
            wrapper.find('.logo-url').val('');
            wrapper.html(`
                <div class="logo-placeholder">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#666" d="M19.5 12c-2.483 0-4.5 2.015-4.5 4.5s2.017 4.5 4.5 4.5 4.5-2.015 4.5-4.5-2.017-4.5-4.5-4.5zm2.5 5h-2v2h-1v-2h-2v-1h2v-2h1v2h2v1zm-7.18 4h-14.82v-20h20v10.209c.867.584 1.599 1.33 2 2.191v-13.4c0-.553-.447-1-1-1h-22c-.553 0-1 .447-1 1v22c0 .553.447 1 1 1h17.18c-.685-.645-1.239-1.439-1.576-2.334l-.804-1.666zm-11.82-3h8v-1h-8v1zm0-3h8v-1h-8v1zm0-3h8v-1h-8v1zm0-3h16v-1h-16v1z"/>
                    </svg>
                </div>
            `);
        });
    });
    </script>
    <?php
}

// Hàm render form fields cho đối tác
function nts_render_partner_fields($index, $partner = []) {
    $name = $partner['name'] ?? '';
    $logo = $partner['logo'] ?? '';
    $website = $partner['website'] ?? '';
    $description = $partner['description'] ?? '';
    $type = $partner['type'] ?? '';
    ?>
    <div class="partner-item">
        <h3>
            <span><?php _e('Thông tin đối tác', 'flatsome'); ?></span>
            <button type="button" class="button remove-partner">
                <?php _e('Xóa', 'flatsome'); ?>
            </button>
        </h3>

        <div class="form-row">
            <div class="logo-container">
                <input type="hidden" name="partners[<?php echo $index; ?>][logo]"
                       value="<?php echo esc_url($logo); ?>" class="logo-url">
                <div class="logo-wrapper upload-logo">
                    <?php if ($logo): ?>
                        <img src="<?php echo esc_url($logo); ?>" class="logo-preview">
                        <div class="logo-remove" title="<?php _e('Xóa logo', 'flatsome'); ?>">
                            <svg width="14" height="14" viewBox="0 0 24 24">
                                <path fill="#666" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                        </div>
                    <?php else: ?>
                        <div class="logo-placeholder">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <path fill="#666" d="M19.5 12c-2.483 0-4.5 2.015-4.5 4.5s2.017 4.5 4.5 4.5 4.5-2.015 4.5-4.5-2.017-4.5-4.5-4.5zm2.5 5h-2v2h-1v-2h-2v-1h2v-2h1v2h2v1zm-7.18 4h-14.82v-20h20v10.209c.867.584 1.599 1.33 2 2.191v-13.4c0-.553-.447-1-1-1h-22c-.553 0-1 .447-1 1v22c0 .553.447 1 1 1h17.18c-.685-.645-1.239-1.439-1.576-2.334l-.804-1.666zm-11.82-3h8v-1h-8v1zm0-3h8v-1h-8v1zm0-3h8v-1h-8v1zm0-3h16v-1h-16v1z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="partner-info">
                <div class="form-field">
                    <label><?php _e('Tên đối tác:', 'flatsome'); ?></label>
                    <input type="text" name="partners[<?php echo $index; ?>][name]"
                           value="<?php echo esc_attr($name); ?>">
                </div>

                <div class="form-field">
                    <label><?php _e('Website:', 'flatsome'); ?></label>
                    <input type="url" name="partners[<?php echo $index; ?>][website]"
                           value="<?php echo esc_url($website); ?>">
                </div>

                <div class="form-field">
                    <label><?php _e('Loại đối tác:', 'flatsome'); ?></label>
                    <select name="partners[<?php echo $index; ?>][type]">
                        <option value="" <?php selected($type, ''); ?>><?php _e('-- Chọn loại đối tác --', 'flatsome'); ?></option>
                        <option value="product" <?php selected($type, 'product'); ?>><?php _e('Đối tác cung ứng sản phẩm', 'flatsome'); ?></option>
                        <option value="software" <?php selected($type, 'software'); ?>><?php _e('Đối tác phần mềm', 'flatsome'); ?></option>
                        <option value="project" <?php selected($type, 'project'); ?>><?php _e('Đối tác dự án', 'flatsome'); ?></option>
                    </select>
                </div>

                <div class="form-field">
                    <label><?php _e('Mô tả:', 'flatsome'); ?></label>
                    <textarea name="partners[<?php echo $index; ?>][description]" rows="4"><?php
                        echo esc_textarea($description);
                    ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <?php
}

// Helper function to get partner template
function nts_get_partner_template() {
    ob_start();
    nts_render_partner_fields('INDEX', []);
    return str_replace(["\
", "\
"], '', ob_get_clean());
}

// Đăng ký scripts và styles cho trang đối tác
add_action('admin_enqueue_scripts', 'nts_partners_admin_assets');

function nts_partners_admin_assets($hook) {
    if ('noi-dung_page_nts-partners' !== $hook) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('jquery');

    // Đăng ký style chính
    wp_register_style('nts-partners-style', false); // false vì chúng ta sẽ dùng inline style
    wp_enqueue_style('nts-partners-style');

    // Thêm CSS inline
    wp_add_inline_style('nts-partners-style', '
        .partner-item {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .partner-item h3 {
            margin: 0 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .logo-container {
            flex: 0 0 150px;
        }
        .logo-wrapper {
            width: 150px;
            height: 100px;
            border: 2px dashed #ddd;
            background: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }
        .logo-wrapper:hover {
            border-color: #2271b1;
        }
        .logo-preview {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }
        .logo-remove {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #fff;
            border: 1px solid #ddd;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            display: none;
        }
        .logo-wrapper:hover .logo-remove {
            display: flex;
        }
        .logo-remove:hover {
            background: #dc3232;
            border-color: #dc3232;
        }
        .logo-remove:hover svg path {
            fill: #fff;
        }
        .partner-info {
            flex: 1;
        }
        .form-field {
            margin-bottom: 15px;
        }
        .form-field:last-child {
            margin-bottom: 0;
        }
        .form-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .form-field input[type="text"],
        .form-field input[type="url"],
        .form-field textarea,
        .form-field select {
            width: 100%;
            max-width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-field textarea {
            min-height: 100px;
            resize: vertical;
        }
        .button.remove-partner {
            color: #dc3232;
            border-color: #dc3232;
        }
        .button.remove-partner:hover {
            background: #dc3232;
            color: #fff;
        }
        #add-partner {
            margin: 15px 0;
        }
        .logo-placeholder svg {
            opacity: 0.5;
        }
    ');
}

// Callback function cho trang quản lý lịch sử hình thành
function nts_history_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền truy cập trang này.', 'flatsome'));
    }

    // Lưu dữ liệu khi submit
    if (isset($_POST['submit']) && check_admin_referer('nts_history_nonce')) {
        $history_items = isset($_POST['history']) ? $_POST['history'] : [];
        update_option('nts_history', $history_items);
        echo '<div class="notice notice-success"><p>'. __('Đã lưu thay đổi.', 'flatsome') .'</p></div>';
    }

    // Lấy dữ liệu hiện tại
    $history_items = get_option('nts_history', []);
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Quản lý Lịch sử hình thành', 'flatsome'); ?></h1>

        <form method="post" action="">
            <?php wp_nonce_field('nts_history_nonce'); ?>

            <div id="history-container">
                <?php
                if (!empty($history_items)) {
                    foreach ($history_items as $index => $item) {
                        nts_render_history_fields($index, $item);
                    }
                }
                ?>
            </div>

            <button type="button" class="button" id="add-history-item">
                <?php _e('Thêm mốc lịch sử', 'flatsome'); ?>
            </button>

            <?php submit_button(__('Lưu thay đổi', 'flatsome')); ?>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var template = `<?php ob_start(); nts_render_history_fields('INDEX', []); $template = ob_get_clean(); echo str_replace(["\r", "\n"], '', $template); ?>`;

        $('#add-history-item').on('click', function() {
            var index = $('#history-container .history-item').length;
            var html = template.replace(/INDEX/g, index);
            $('#history-container').append(html);
        });

        // Xử lý sự kiện xóa mốc lịch sử
        $(document).on('click', '.remove-history-item', function() {
            if (confirm('<?php _e("Bạn có chắc muốn xóa mốc lịch sử này?", "flatsome"); ?>')) {
                $(this).closest('.history-item').slideUp(300, function() {
                    $(this).remove();
                });
            }
        });

        // Xử lý sự kiện sao chép mốc lịch sử
        $(document).on('click', '.copy-history-item', function() {
            var $originalItem = $(this).closest('.history-item');
            var index = $('#history-container .history-item').length;

            // Lấy dữ liệu từ mốc lịch sử gốc
            var year = $originalItem.find('input[name*="[year]"]').val();
            var title = $originalItem.find('input[name*="[title]"]').val();
            var description = $originalItem.find('textarea[name*="[description]"]').val();
            var image = $originalItem.find('input[name*="[image]"]').val();

            // Tạo mốc lịch sử mới
            var html = template.replace(/INDEX/g, index);
            var $newItem = $(html).appendTo('#history-container');

            // Điền dữ liệu vào mốc lịch sử mới
            $newItem.find('input[name*="[year]"]').val(year);
            $newItem.find('input[name*="[title]"]').val(title + ' (<?php _e("Bản sao", "flatsome"); ?>)');
            $newItem.find('textarea[name*="[description]"]').val(description);

            // Xử lý hình ảnh nếu có
            if (image) {
                $newItem.find('input[name*="[image]"]').val(image);
                $newItem.find('.image-wrapper').html(`
                    <img src="${image}" class="history-image-preview">
                    <div class="image-remove" title="<?php _e("Xóa ảnh", "flatsome"); ?>">
                        <svg width="14" height="14" viewBox="0 0 24 24">
                            <path fill="#666" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </div>
                `);
            }

            // Hiệu ứng hiển thị
            $newItem.hide().slideDown(300);

            // Cuộn đến mốc lịch sử mới
            $('html, body').animate({
                scrollTop: $newItem.offset().top - 100
            }, 500);
        });

        $(document).on('click', '.upload-history-image', function(e) {
            e.preventDefault();
            var button = $(this);
            var imageInput = button.parent().find('.image-url');
            var imageWrapper = button.closest('.image-wrapper');

            var frame = wp.media({
                title: '<?php _e("Chọn Hình ảnh", "flatsome"); ?>',
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                imageInput.val(attachment.url);
                imageWrapper.html(`
                    <img src="${attachment.url}" class="history-image-preview">
                    <div class="image-remove" title="<?php _e("Xóa ảnh", "flatsome"); ?>">
                        <svg width="14" height="14" viewBox="0 0 24 24">
                            <path fill="#666" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </div>
                `);
            });

            frame.open();
        });

        $(document).on('click', '.image-remove', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var wrapper = $(this).closest('.image-wrapper');
            wrapper.find('.image-url').val('');
            wrapper.html(`
                <div class="image-placeholder">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#666" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/>
                    </svg>
                </div>
            `);
        });
    });
    </script>
    <?php
}

// Đăng ký scripts và styles cho trang lịch sử hình thành
add_action('admin_enqueue_scripts', 'nts_history_admin_assets');

function nts_history_admin_assets($hook) {
    if ('noi-dung_page_nts-history' !== $hook) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('jquery');

    // Đăng ký style chính
    wp_register_style('nts-history-style', false); // false vì chúng ta sẽ dùng inline style
    wp_enqueue_style('nts-history-style');

    // Thêm CSS inline
    // Đăng ký dashicons
    wp_enqueue_style('dashicons');

    wp_add_inline_style('nts-history-style', '
        .history-item {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .history-item h3 {
            margin: 0 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .item-actions {
            display: flex;
            gap: 5px;
        }
        .copy-history-item {
            color: #0073aa;
            border-color: #0073aa;
        }
        .copy-history-item:hover {
            background: #0073aa;
            color: #fff;
        }
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .image-container {
            flex: 0 0 150px;
        }
        .image-wrapper {
            width: 150px;
            height: 100px;
            border: 2px dashed #ddd;
            background: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }
        .image-wrapper:hover {
            border-color: #2271b1;
        }
        .history-image-preview {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }
        .image-remove {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #fff;
            border: 1px solid #ddd;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            display: none;
        }
        .image-wrapper:hover .image-remove {
            display: flex;
        }
        .image-remove:hover {
            background: #dc3232;
            border-color: #dc3232;
        }
        .image-remove:hover svg path {
            fill: #fff;
        }
        .history-info {
            flex: 1;
        }
        .form-field {
            margin-bottom: 15px;
        }
        .form-field:last-child {
            margin-bottom: 0;
        }
        .form-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .form-field input[type="text"],
        .form-field textarea {
            width: 100%;
            max-width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-field textarea {
            min-height: 100px;
            resize: vertical;
        }
        .button.remove-history-item {
            color: #dc3232;
            border-color: #dc3232;
        }
        .button.remove-history-item:hover {
            background: #dc3232;
            color: #fff;
        }
        #add-history-item {
            margin: 15px 0;
        }
        .image-placeholder svg {
            opacity: 0.5;
        }
        .year-field {
            width: 100px !important;
        }
    ');
}

// Hàm render form fields cho lịch sử hình thành
function nts_render_history_fields($index, $item = []) {
    $year = $item['year'] ?? '';
    $title = $item['title'] ?? '';
    $description = $item['description'] ?? '';
    $image = $item['image'] ?? '';
    ?>
    <div class="history-item">
        <h3>
            <span><?php _e('Thông tin mốc lịch sử', 'flatsome'); ?></span>
            <div class="item-actions">
                <button type="button" class="button copy-history-item" title="<?php _e('Sao chép', 'flatsome'); ?>">
                    <span class="dashicons dashicons-admin-page"></span>
                </button>
                <button type="button" class="button remove-history-item" title="<?php _e('Xóa', 'flatsome'); ?>">
                    <span class="dashicons dashicons-trash"></span>
                </button>
            </div>
        </h3>

        <div class="form-row">
            <div class="image-container">
                <input type="hidden" name="history[<?php echo $index; ?>][image]"
                       value="<?php echo esc_url($image); ?>" class="image-url">
                <div class="image-wrapper upload-history-image">
                    <?php if ($image): ?>
                        <img src="<?php echo esc_url($image); ?>" class="history-image-preview">
                        <div class="image-remove" title="<?php _e('Xóa ảnh', 'flatsome'); ?>">
                            <svg width="14" height="14" viewBox="0 0 24 24">
                                <path fill="#666" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                            </svg>
                        </div>
                    <?php else: ?>
                        <div class="image-placeholder">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <path fill="#666" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="history-info">
                <div class="form-field">
                    <label><?php _e('Năm:', 'flatsome'); ?></label>
                    <input type="text" name="history[<?php echo $index; ?>][year]"
                           value="<?php echo esc_attr($year); ?>" class="year-field">
                </div>

                <div class="form-field">
                    <label><?php _e('Tiêu đề:', 'flatsome'); ?></label>
                    <input type="text" name="history[<?php echo $index; ?>][title]"
                           value="<?php echo esc_attr($title); ?>">
                </div>

                <div class="form-field">
                    <label><?php _e('Mô tả:', 'flatsome'); ?></label>
                    <textarea name="history[<?php echo $index; ?>][description]" rows="4"><?php
                        echo esc_textarea($description);
                    ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <?php
}

// Helper function to get history template
function nts_get_history_template() {
    ob_start();
    nts_render_history_fields('INDEX', []);
    return str_replace(["\r", "\n"], '', ob_get_clean());
}

// Shortcode để hiển thị danh sách chuyên gia
function nts_experts_shortcode($atts = []) {
    // Xử lý các tham số đầu vào
    $atts = shortcode_atts([
        'limit' => -1,       // Số lượng chuyên gia hiển thị, -1 là tất cả
        'columns' => 3,     // Số cột hiển thị
    ], $atts, 'nts_experts');

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

    // Bắt đầu output buffer
    ob_start();
    ?>
    <div class="nts-experts-list">
        <div class="row row-small">
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
            ?>
                <div class="col <?php echo esc_attr($column_class); ?> small-12">
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

    <style>
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
    // Trả về nội dung đã được buffer
    return ob_get_clean();
}
// Đăng ký shortcode [nts_experts]
add_shortcode('nts_experts', 'nts_experts_shortcode');

// Đăng ký settings cho thông tin liên hệ
function nts_register_contact_info_settings() {
    // Đăng ký setting section
    add_settings_section(
        'nts_contact_info_section',
        __('Thông tin liên hệ', 'flatsome'),
        'nts_contact_info_section_callback',
        'nts-contact-info'
    );
    
    // Đăng ký các field
    register_setting('nts-contact-info', 'nts_contact_phone');
    add_settings_field(
        'nts_contact_phone',
        __('Số điện thoại', 'flatsome'),
        'nts_contact_phone_callback',
        'nts-contact-info',
        'nts_contact_info_section'
    );
    
    register_setting('nts-contact-info', 'nts_contact_email');
    add_settings_field(
        'nts_contact_email',
        __('Email', 'flatsome'),
        'nts_contact_info_email_callback',
        'nts-contact-info',
        'nts_contact_info_section'
    );
    
    register_setting('nts-contact-info', 'nts_contact_address');
    add_settings_field(
        'nts_contact_address',
        __('Địa chỉ', 'flatsome'),
        'nts_contact_address_callback',
        'nts-contact-info',
        'nts_contact_info_section'
    );
    
    register_setting('nts-contact-info', 'nts_contact_facebook');
    add_settings_field(
        'nts_contact_facebook',
        __('Facebook', 'flatsome'),
        'nts_contact_facebook_callback',
        'nts-contact-info',
        'nts_contact_info_section'
    );
    
    register_setting('nts-contact-info', 'nts_contact_youtube');
    add_settings_field(
        'nts_contact_youtube',
        __('Youtube', 'flatsome'),
        'nts_contact_youtube_callback',
        'nts-contact-info',
        'nts_contact_info_section'
    );
    
    register_setting('nts-contact-info', 'nts_contact_instagram');
    add_settings_field(
        'nts_contact_instagram',
        __('Instagram', 'flatsome'),
        'nts_contact_instagram_callback',
        'nts-contact-info',
        'nts_contact_info_section'
    );
    
    register_setting('nts-contact-info', 'nts_contact_linkedin');
    add_settings_field(
        'nts_contact_linkedin',
        __('LinkedIn', 'flatsome'),
        'nts_contact_linkedin_callback',
        'nts-contact-info',
        'nts_contact_info_section'
    );
}
add_action('admin_init', 'nts_register_contact_info_settings');

/**
 * Callback functions cho các field thông tin liên hệ
 */
function nts_contact_info_section_callback() {
    echo '<p>' . __('Cài đặt thông tin liên hệ của công ty hiển thị trên website', 'flatsome') . '</p>';
}

function nts_contact_phone_callback() {
    $value = get_option('nts_contact_phone');
    echo '<input type="text" name="nts_contact_phone" value="' . esc_attr($value) . '" class="regular-text">';
    echo '<p class="description">' . __('Nhập số điện thoại liên hệ (có thể nhập nhiều số, phân cách bằng dấu phẩy)', 'flatsome') . '</p>';
}

function nts_contact_info_email_callback() {
    $value = get_option('nts_contact_email');
    echo '<input type="email" name="nts_contact_email" value="' . esc_attr($value) . '" class="regular-text">';
    echo '<p class="description">' . __('Nhập địa chỉ email liên hệ', 'flatsome') . '</p>';
}

function nts_contact_address_callback() {
    $value = get_option('nts_contact_address');
    echo '<textarea name="nts_contact_address" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
    echo '<p class="description">' . __('Nhập địa chỉ công ty', 'flatsome') . '</p>';
}

function nts_contact_facebook_callback() {
    $value = get_option('nts_contact_facebook');
    echo '<input type="url" name="nts_contact_facebook" value="' . esc_attr($value) . '" class="regular-text">';
    echo '<p class="description">' . __('Nhập link Facebook', 'flatsome') . '</p>';
}

function nts_contact_youtube_callback() {
    $value = get_option('nts_contact_youtube');
    echo '<input type="url" name="nts_contact_youtube" value="' . esc_attr($value) . '" class="regular-text">';
    echo '<p class="description">' . __('Nhập link Youtube', 'flatsome') . '</p>';
}

function nts_contact_instagram_callback() {
    $value = get_option('nts_contact_instagram');
    echo '<input type="url" name="nts_contact_instagram" value="' . esc_attr($value) . '" class="regular-text">';
    echo '<p class="description">' . __('Nhập link Instagram', 'flatsome') . '</p>';
}

function nts_contact_linkedin_callback() {
    $value = get_option('nts_contact_linkedin');
    echo '<input type="url" name="nts_contact_linkedin" value="' . esc_attr($value) . '" class="regular-text">';
    echo '<p class="description">' . __('Nhập link LinkedIn', 'flatsome') . '</p>';
}

/**
 * Callback function cho trang thông tin liên hệ
 */
function nts_contact_info_page() {
    // Kiểm tra quyền truy cập
    if (!current_user_can('manage_options')) {
        wp_die(__('Bạn không có quyền truy cập trang này.', 'flatsome'));
    }

    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Thông tin liên hệ', 'flatsome'); ?></h1>
        <p><?php _e('Quản lý thông tin liên hệ và mạng xã hội hiển thị trên website', 'flatsome'); ?></p>

        <form method="post" action="options.php">
            <?php
            // Output các hidden fields cần thiết
            settings_fields('nts-contact-info');
            // Output các sections và fields
            do_settings_sections('nts-contact-info');
            // Nút submit
            submit_button(__('Lưu thay đổi', 'flatsome'));
            ?>
        </form>
    </div>
    <?php
}

/**
 * Hàm lấy thông tin liên hệ để sử dụng trong theme
 * @param string $type Loại thông tin cần lấy (phone, email, address, facebook, youtube, instagram, linkedin)
 * @return string Thông tin liên hệ
 */
function nts_get_contact_info($type = '') {
    switch ($type) {
        case 'phone':
            return get_option('nts_contact_phone');
        case 'email':
            return get_option('nts_contact_email');
        case 'address':
            return get_option('nts_contact_address');
        case 'facebook':
            return get_option('nts_contact_facebook');
        case 'youtube':
            return get_option('nts_contact_youtube');
        case 'instagram':
            return get_option('nts_contact_instagram');
        case 'linkedin':
            return get_option('nts_contact_linkedin');
        default:
            return '';
    }
}

/**
 * Shortcode để hiển thị thông tin liên hệ
 * Sử dụng: [nts_contact_info type="phone|email|address|facebook|youtube|instagram|linkedin"]
 * @param array $atts Các thuộc tính của shortcode
 * @return string HTML hiển thị thông tin liên hệ
 */
function nts_contact_info_shortcode($atts = []) {
    $atts = shortcode_atts([
        'type' => 'phone',
        'icon' => 'true',
        'class' => '',
    ], $atts);
    
    $type = $atts['type'];
    $show_icon = filter_var($atts['icon'], FILTER_VALIDATE_BOOLEAN);
    $class = sanitize_html_class($atts['class']);
    
    $value = nts_get_contact_info($type);
    if (empty($value)) {
        return '';
    }
    
    $icon_html = '';
    if ($show_icon) {
        switch ($type) {
            case 'phone':
                $icon_html = '<i class="icon-phone"></i> ';
                break;
            case 'email':
                $icon_html = '<i class="icon-envelop"></i> ';
                break;
            case 'address':
                $icon_html = '<i class="icon-map-pin-fill"></i> ';
                break;
            case 'facebook':
                $icon_html = '<i class="icon-facebook"></i> ';
                break;
            case 'youtube':
                $icon_html = '<i class="icon-youtube"></i> ';
                break;
            case 'instagram':
                $icon_html = '<i class="icon-instagram"></i> ';
                break;
            case 'linkedin':
                $icon_html = '<i class="icon-linkedin"></i> ';
                break;
        }
    }
    
    $output = '<span class="nts-contact-info ' . esc_attr($class) . '">';
    $output .= $icon_html;
    
    switch ($type) {
        case 'phone':
            $phones = explode(',', $value);
            foreach ($phones as $index => $phone) {
                if ($index > 0) {
                    $output .= ' / ';
                }
                $output .= '<a href="tel:' . esc_attr(trim($phone)) . '">' . esc_html(trim($phone)) . '</a>';
            }
            break;
        case 'email':
            $output .= '<a href="mailto:' . esc_attr($value) . '">' . esc_html($value) . '</a>';
            break;
        case 'address':
            $output .= nl2br(esc_html($value));
            break;
        case 'facebook':
        case 'youtube':
        case 'instagram':
        case 'linkedin':
            $output .= '<a href="' . esc_url($value) . '" target="_blank" rel="noopener noreferrer">' . esc_html($value) . '</a>';
            break;
        default:
            $output .= esc_html($value);
    }
    
    $output .= '</span>';
    return $output;
}
add_shortcode('nts_contact_info', 'nts_contact_info_shortcode');

/**
 * Widget hiển thị các liên kết mạng xã hội
 */
class NTS_Social_Links_Widget extends WP_Widget {
    /**
     * Khởi tạo widget
     */
    public function __construct() {
        parent::__construct(
            'nts_social_links',
            __('NTS - Mạng xã hội', 'flatsome'),
            array('description' => __('Hiển thị các liên kết mạng xã hội', 'flatsome'))
        );
    }

    /**
     * Hiển thị widget ở frontend
     */
    public function widget($args, $instance) {
        $title = ! empty($instance['title']) ? apply_filters('widget_title', $instance['title']) : '';
        
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        echo '<ul class="nts-social-links">';
        
        $facebook = nts_get_contact_info('facebook');
        if (!empty($facebook)) {
            echo '<li><a href="' . esc_url($facebook) . '" target="_blank" rel="noopener noreferrer" class="social-facebook"><i class="icon-facebook"></i> Facebook</a></li>';
        }
        
        $youtube = nts_get_contact_info('youtube');
        if (!empty($youtube)) {
            echo '<li><a href="' . esc_url($youtube) . '" target="_blank" rel="noopener noreferrer" class="social-youtube"><i class="icon-youtube"></i> Youtube</a></li>';
        }
        
        $instagram = nts_get_contact_info('instagram');
        if (!empty($instagram)) {
            echo '<li><a href="' . esc_url($instagram) . '" target="_blank" rel="noopener noreferrer" class="social-instagram"><i class="icon-instagram"></i> Instagram</a></li>';
        }
        
        $linkedin = nts_get_contact_info('linkedin');
        if (!empty($linkedin)) {
            echo '<li><a href="' . esc_url($linkedin) . '" target="_blank" rel="noopener noreferrer" class="social-linkedin"><i class="icon-linkedin"></i> LinkedIn</a></li>';
        }
        
        echo '</ul>';
        
        echo $args['after_widget'];
    }

    /**
     * Hiển thị form cài đặt trong admin
     */
    public function form($instance) {
        $title = ! empty($instance['title']) ? $instance['title'] : __('Kết nối với chúng tôi', 'flatsome');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Tiêu đề:', 'flatsome'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <?php _e('Liên kết mạng xã hội được lấy từ trang cài đặt Thông tin liên hệ. Bạn có thể cập nhật liên kết tại:', 'flatsome'); ?>
            <a href="<?php echo admin_url('admin.php?page=nts-contact-info'); ?>"><?php _e('Cài đặt Thông tin liên hệ', 'flatsome'); ?></a>
        </p>
        <?php
    }

    /**
     * Xử lý khi lưu widget
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * Đăng ký Widget
 */
function nts_register_social_links_widget() {
    register_widget('NTS_Social_Links_Widget');
}
add_action('widgets_init', 'nts_register_social_links_widget');
