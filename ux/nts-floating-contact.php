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
                <i class="icon-phone"></i>
                <span class="btn-label">Gọi điện</span>
            </a>
        <?php endif; ?>
        
        <?php if (!empty($facebook)) : ?>
            <a href="https://m.me/<?php echo esc_attr(basename($facebook)); ?>" class="contact-btn messenger-btn animate-2" title="Chat Messenger" target="_blank">
                <i class="icon-facebook"></i>
                <span class="btn-label">Messenger</span>
            </a>
        <?php endif; ?>
        
        <?php if (!empty($atts['zalo'])) : 
            // Clean up Zalo number
            $zalo = preg_replace('/[^0-9]/', '', $atts['zalo']);
        ?>
            <a href="https://zalo.me/<?php echo esc_attr($zalo); ?>" class="contact-btn zalo-btn animate-3" title="Chat Zalo" target="_blank">
                <svg class="zalo-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.7151 7.21864C13.0133 7.21864 13.2547 7.45984 13.2547 7.75819C13.2547 8.05679 13.0133 8.29774 12.7151 8.29774C12.4167 8.29774 12.1755 8.05679 12.1755 7.75819C12.1755 7.45984 12.4167 7.21864 12.7151 7.21864Z" fill="white"/>
                    <path d="M14.6512 7.21864C14.9496 7.21864 15.1909 7.45984 15.1909 7.75819C15.1909 8.05679 14.9496 8.29774 14.6512 8.29774C14.353 8.29774 14.1115 8.05679 14.1115 7.75819C14.1115 7.45984 14.353 7.21864 14.6512 7.21864Z" fill="white"/>
                    <path d="M16.5875 7.21862C16.8857 7.21862 17.1272 7.45982 17.1272 7.75817C17.1272 8.05677 16.8857 8.29772 16.5875 8.29772C16.2893 8.29772 16.0479 8.05677 16.0479 7.75817C16.0479 7.45982 16.2893 7.21862 16.5875 7.21862Z" fill="white"/>
                    <path d="M18.4866 18.5212L17.4456 16.1317C17.4104 16.0593 17.3159 16.0499 17.2478 16.1087C16.4599 16.7786 15.3998 17.3185 14.1139 17.5869V18.0629C14.1139 18.3212 13.9051 18.53 13.6468 18.53H9.40806C9.14976 18.53 8.94092 18.3212 8.94092 18.0629V17.3185C6.44366 16.7339 4.64845 14.9387 4.06375 12.6836C4.02813 12.5499 4.00519 12.4131 3.98663 12.2741C3.90311 11.5994 3.9306 10.935 4.06375 10.3096C4.32643 9.21248 4.7531 8.31497 5.32517 7.61492C5.96245 6.82673 6.7837 6.1862 7.75778 5.71896C8.94092 5.15932 10.0055 5.0063 10.4958 5.0063H12.559C13.0496 5.0063 14.1139 5.15932 15.297 5.71896C16.2711 6.1862 17.0924 6.82673 17.7296 7.61492C18.3017 8.31497 18.7284 9.21248 18.991 10.3096C19.1244 10.935 19.1517 11.5994 19.0684 12.2741C18.7558 14.5289 17.2478 16.5006 14.9925 17.2944C14.9761 17.3005 14.9596 17.3063 14.9433 17.3123H14.9434C15.9429 16.8962 16.8108 16.2728 17.478 15.4841C17.5335 15.4153 17.6379 15.4167 17.6912 15.4866C18.3301 16.3324 18.9878 17.6573 19.3145 18.5212C19.3989 18.7305 19.2373 18.9648 19.0113 18.9648H18.79C18.5639 18.9648 18.5694 18.7305 18.4866 18.5212Z" fill="white"/>
                    <path d="M12.6762 10.6232C12.3593 10.6232 12.1017 10.881 12.1017 11.1979V14.0506C12.1017 14.3674 12.3593 14.6253 12.6762 14.6253C12.9932 14.6253 13.2511 14.3674 13.2511 14.0506V11.1979C13.2511 10.881 12.9932 10.6232 12.6762 10.6232Z" fill="white"/>
                    <path d="M15.6013 10.2432C15.4574 10.0994 15.263 10.0204 15.0593 10.0204H14.4358C14.1188 10.0204 13.8612 10.2783 13.8612 10.5952C13.8612 10.9121 14.1188 11.1698 14.4358 11.1698H14.6778V14.0506C14.6778 14.3674 14.9355 14.6253 15.2525 14.6253C15.5693 14.6253 15.8273 14.3674 15.8273 14.0506V11.1698C15.8273 11.1698 15.8278 11.1698 15.8284 11.1698C15.8284 11.1698 15.8289 11.1698 15.8294 11.1698C16.1078 11.1698 16.334 10.9435 16.334 10.6653C16.334 10.5101 16.2859 10.3679 16.2063 10.2577C16.0336 10.0206 15.7448 9.87347 15.4209 9.87347C15.1552 9.87347 14.917 9.95991 14.7452 10.1022C14.7349 10.1109 14.7252 10.1202 14.7163 10.13C14.7069 10.1403 14.6983 10.1512 14.6902 10.1624C14.6807 10.1756 14.6721 10.1891 14.6645 10.2027C14.6577 10.2152 14.652 10.2278 14.6469 10.2406C14.6405 10.2564 14.6349 10.2725 14.6307 10.2889C14.6277 10.3006 14.6254 10.3123 14.624 10.3241C14.6211 10.3487 14.6211 10.3746 14.6211 10.4C14.6211 10.5048 14.6565 10.5992 14.7163 10.6727C14.7761 10.7462 14.8604 10.799 14.9582 10.8242C14.9826 10.8311 15.0079 10.836 15.0337 10.8392C15.0602 10.8426 15.0871 10.8438 15.1146 10.8438C15.1422 10.8438 15.1691 10.8426 15.1957 10.8392C15.2214 10.836 15.2467 10.8311 15.2711 10.8242C15.3238 10.8114 15.3726 10.7898 15.416 10.7607C15.4586 10.7323 15.4958 10.6966 15.5257 10.6554C15.5556 10.6141 15.5785 10.5659 15.5925 10.5133C15.6066 10.4607 15.6128 10.405 15.6106 10.3473C15.6085 10.3101 15.6055 10.2744 15.6013 10.2432Z" fill="white"/>
                    <path d="M9.84375 10.0203C9.52686 10.0203 9.26903 10.2781 9.26903 10.595V14.0506C9.26903 14.3674 9.52686 14.6253 9.84375 14.6253C10.1606 14.6253 10.4185 14.3674 10.4185 14.0506V12.5765L11.2271 13.7035C11.3646 13.9005 11.5875 14.0203 11.8281 14.0203C11.9296 14.0203 12.028 13.9976 12.118 13.9544C12.4062 13.8128 12.5264 13.457 12.385 13.1687L11.5136 11.7594C11.5181 11.7596 11.5227 11.7597 11.5272 11.7597C12.1611 11.7597 12.6766 11.2444 12.6766 10.6103C12.6766 9.97618 12.1611 9.46083 11.5272 9.46083H9.84375V10.0203ZM11.5272 10.6103C11.5272 10.6103 11.5272 10.6108 11.5272 10.6114C11.5272 10.6119 11.5272 10.6125 11.5272 10.6125V10.0203V10.6103Z" fill="white"/>
                </svg>
                <span class="btn-label">Zalo</span>
            </a>
        <?php endif; ?>
    </div>

    <style>
        .nts-floating-contact {
            position: fixed;
            bottom: 20px;
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
        }
        
        .nts-floating-contact.square .contact-btn {
            border-radius: 8px;
        }
        
        .nts-floating-contact .contact-btn i,
        .nts-floating-contact .contact-btn .zalo-icon {
            font-size: 24px;
        }
        
        .nts-floating-contact .contact-btn .zalo-icon {
            width: 24px;
            height: 24px;
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
            .nts-floating-contact .contact-btn .zalo-icon {
                font-size: 20px;
            }
            
            .nts-floating-contact .contact-btn .zalo-icon {
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