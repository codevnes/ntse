<?php
/**
 * Floating Contact Buttons
 * 
 * Adds floating contact buttons to the bottom right corner of the screen
 * for quick access to contact methods like phone, messenger, and zalo.
 */

// Đăng ký shortcode [nts_floating_contact]
add_shortcode('nts_floating_contact', 'nts_floating_contact_shortcode');

// Function to display floating contact buttons
function nts_floating_contact_shortcode($atts) {
    // Get contact information
    $phone = nts_get_contact_info('phone');
    $facebook = nts_get_contact_info('facebook');
    
    // If phone has multiple numbers, get the first one
    if (!empty($phone)) {
        $phones = explode(',', $phone);
        $phone = trim($phones[0]);
    }
    
    // Parse attributes
    $atts = shortcode_atts(
        array(
            'zalo' => '', // Zalo number (often same as phone)
            'position' => 'right', // right or left
            'style' => 'circle', // circle or square
            'primary_color' => '#0073aa', // Primary color
        ),
        $atts,
        'nts_floating_contact'
    );
    
    // Use phone number for Zalo if not specified
    if (empty($atts['zalo'])) {
        $atts['zalo'] = $phone;
    }
    
    // Start output buffer
    ob_start();
    ?>
    <div class="nts-floating-contact <?php echo esc_attr($atts['position'] . ' ' . $atts['style']); ?>">
        <?php if (!empty($phone)) : ?>
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="contact-btn phone-btn animate-1" title="Gọi điện">
                <svg class="icon-img" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="white"><path d="M798-120q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12Z"/></svg>
                <span class="btn-label">Gọi điện</span>
            </a>
        <?php endif; ?>
        
        <?php if (!empty($facebook)) : ?>
            <a href="https://m.me/<?php echo esc_attr(basename($facebook)); ?>" class="contact-btn messenger-btn animate-2" title="Chat Messenger" target="_blank">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/image/messenger.webp" alt="Messenger" class="icon-img">
                <span class="btn-label">Messenger</span>
            </a>
        <?php endif; ?>
        
        <?php if (!empty($atts['zalo'])) : 
            // Clean up Zalo number
            $zalo = preg_replace('/[^0-9]/', '', $atts['zalo']);
        ?>
            <a href="https://zalo.me/<?php echo esc_attr($zalo); ?>" class="contact-btn zalo-btn animate-3" title="Chat Zalo" target="_blank">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/image/zalo.png" alt="Zalo" class="icon-img">
                <span class="btn-label">Zalo</span>
            </a>
        <?php endif; ?>
    </div>

    <style>
        .nts-floating-contact {
            position: fixed;
            bottom: 120px;
            z-index: 999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .nts-floating-contact.right .contact-btn {
            animation: fadeInRight 0.5s ease both;
        }
        
        .nts-floating-contact.left .contact-btn {
            animation: fadeInLeft 0.5s ease both;
        }
        
        .nts-floating-contact .animate-1 {
            animation-delay: 0.1s;
        }
        
        .nts-floating-contact .animate-2 {
            animation-delay: 0.3s;
        }
        
        .nts-floating-contact .animate-3 {
            animation-delay: 0.5s;
        }
        
        .nts-floating-contact.left {
            left: 20px;
        }
        
        .nts-floating-contact.right {
            right: 20px;
        }
        
        .nts-floating-contact .contact-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            position: relative;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .nts-floating-contact.square .contact-btn {
            border-radius: 8px;
        }
        
        .nts-floating-contact .contact-btn i,
        .nts-floating-contact .contact-btn .zalo-icon,
        .nts-floating-contact .contact-btn .icon-img {
            font-size: 24px;
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }
        
        .nts-floating-contact .contact-btn .zalo-icon,
        .nts-floating-contact .contact-btn .icon-img {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }
        
        .nts-floating-contact .contact-btn .btn-label {
            position: absolute;
            right: 64px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 2;
        }
        
        .nts-floating-contact.left .contact-btn .btn-label {
            left: 64px;
            right: auto;
        }
        
        .nts-floating-contact .contact-btn:hover .btn-label {
            opacity: 1;
            visibility: visible;
        }
        
        .nts-floating-contact .contact-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
        }
        
        .nts-floating-contact .contact-btn:hover i,
        .nts-floating-contact .contact-btn:hover .zalo-icon,
        .nts-floating-contact .contact-btn:hover .icon-img {
            transform: scale(1.1);
        }
        
        .nts-floating-contact .contact-btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .nts-floating-contact .contact-btn:hover:before {
            opacity: 1;
        }
        
        /* Phone button */
        .nts-floating-contact .phone-btn {
            background-color: #4CAF50;
        }
        
        /* Messenger button */
        .nts-floating-contact .messenger-btn {
            background-color: #0084FF;
        }
        
        /* Zalo button */
        .nts-floating-contact .zalo-btn {
            background-color: #0068FF;
        }
        
        /* Responsive styles */
        @media (max-width: 767px) {
            .nts-floating-contact {
                bottom: 10px;
            }
            
            .nts-floating-contact.right {
                right: 10px;
            }
            
            .nts-floating-contact.left {
                left: 10px;
            }
            
            .nts-floating-contact .contact-btn {
                width: 45px;
                height: 45px;
            }
            
            .nts-floating-contact .contact-btn i,
            .nts-floating-contact .contact-btn .zalo-icon,
            .nts-floating-contact .contact-btn .icon-img {
                font-size: 20px;
            }
            
            .nts-floating-contact .contact-btn .zalo-icon,
            .nts-floating-contact .contact-btn .icon-img {
                width: 20px;
                height: 20px;
            }
        }
    </style>
    <?php
    // Return the content
    return ob_get_clean();
}

/**
 * Add floating contact buttons to the footer
 */
function nts_add_floating_contact_to_footer() {
    echo do_shortcode('[nts_floating_contact]');
}
add_action('wp_footer', 'nts_add_floating_contact_to_footer');

/**
 * Function to add a settings section for floating contact buttons
 */
function nts_register_floating_contact_settings() {
    // Register settings section
    add_settings_section(
        'nts_floating_contact_section',
        __('Nút liên hệ nổi', 'flatsome'),
        'nts_floating_contact_section_callback',
        'nts-contact-info'
    );
    
    // Register Zalo field
    register_setting('nts-contact-info', 'nts_contact_zalo');
    add_settings_field(
        'nts_contact_zalo',
        __('Zalo', 'flatsome'),
        'nts_contact_zalo_callback',
        'nts-contact-info',
        'nts_floating_contact_section'
    );
    
    // Register position field
    register_setting('nts-contact-info', 'nts_floating_contact_position');
    add_settings_field(
        'nts_floating_contact_position',
        __('Vị trí hiển thị', 'flatsome'),
        'nts_floating_contact_position_callback',
        'nts-contact-info',
        'nts_floating_contact_section'
    );
    
    // Register enable/disable field
    register_setting('nts-contact-info', 'nts_floating_contact_enabled');
    add_settings_field(
        'nts_floating_contact_enabled',
        __('Bật/Tắt', 'flatsome'),
        'nts_floating_contact_enabled_callback',
        'nts-contact-info',
        'nts_floating_contact_section'
    );
}
add_action('admin_init', 'nts_register_floating_contact_settings');

/**
 * Callback functions for floating contact settings
 */
function nts_floating_contact_section_callback() {
    echo '<p>' . __('Cấu hình các nút liên hệ nhanh hiển thị ở góc màn hình', 'flatsome') . '</p>';
}

function nts_contact_zalo_callback() {
    $value = get_option('nts_contact_zalo');
    echo '<input type="text" name="nts_contact_zalo" value="' . esc_attr($value) . '" class="regular-text">';
    echo '<p class="description">' . __('Nhập số Zalo (nếu khác số điện thoại)', 'flatsome') . '</p>';
}

function nts_floating_contact_position_callback() {
    $value = get_option('nts_floating_contact_position', 'right');
    ?>
    <select name="nts_floating_contact_position">
        <option value="right" <?php selected($value, 'right'); ?>><?php _e('Bên phải', 'flatsome'); ?></option>
        <option value="left" <?php selected($value, 'left'); ?>><?php _e('Bên trái', 'flatsome'); ?></option>
    </select>
    <?php
}

function nts_floating_contact_enabled_callback() {
    $value = get_option('nts_floating_contact_enabled', '1');
    ?>
    <input type="checkbox" name="nts_floating_contact_enabled" value="1" <?php checked($value, '1'); ?>>
    <span class="description"><?php _e('Hiển thị các nút liên hệ nổi', 'flatsome'); ?></span>
    <?php
}

/**
 * Modify the default floating contact buttons based on settings
 */
function nts_modify_floating_contact() {
    // Check if enabled
    $enabled = get_option('nts_floating_contact_enabled', '1');
    if (empty($enabled)) {
        // Remove the default buttons if disabled
        remove_action('wp_footer', 'nts_add_floating_contact_to_footer');
        return;
    }
    
    // Get settings
    $position = get_option('nts_floating_contact_position', 'right');
    $zalo = get_option('nts_contact_zalo', '');
    
    // Add modified shortcode
    function nts_custom_floating_contact() {
        $position = get_option('nts_floating_contact_position', 'right');
        $zalo = get_option('nts_contact_zalo', '');
        
        echo do_shortcode('[nts_floating_contact position="' . esc_attr($position) . '" zalo="' . esc_attr($zalo) . '"]');
    }
    
    // Remove default and add custom
    remove_action('wp_footer', 'nts_add_floating_contact_to_footer');
    add_action('wp_footer', 'nts_custom_floating_contact');
}
add_action('init', 'nts_modify_floating_contact'); 