<?php
// Đăng ký NTS CTA Element cho Flatsome UX Builder
add_action( 'ux_builder_setup', 'nts_register_cta_element' );

function nts_register_cta_element()
    {
    add_ux_builder_shortcode( 'nts_cta', array(
        'name'      => __( 'NTS CTA', 'flatsome' ), // Tên hiển thị trong UX Builder
        'category'  => __( 'Content', 'flatsome' ), // Danh mục trong UX Builder
        'options'   => array(
            // Tên nút
            'button_text'  => array(
                'type'    => 'textfield',
                'heading' => __( 'Tên Link', 'flatsome' ),
                'default' => __( 'Click me', 'flatsome' ),
            ),
            // Đường dẫn
            'link'         => array(
                'type'    => 'textfield',
                'heading' => __( 'Đường Link', 'flatsome' ),
                'default' => '#',
            ),
            // Mở tab mới
            'open_new_tab' => array(
                'type'    => 'checkbox',
                'heading' => __( 'Open New Tab?', 'flatsome' ),
                'default' => 'false',
            ),
            // Kiểu nút (Primary/Secondary)
            'button_type'  => array(
                'type'    => 'select',
                'heading' => __( 'Button Type', 'flatsome' ),
                'options' => array(
                    'primary'   => __( 'Primary', 'flatsome' ),
                    'secondary' => __( 'Secondary', 'flatsome' ),
                ),
                'default' => 'primary',
            ),
            // Shadow
            'has_shadow'   => array(
                'type'    => 'checkbox',
                'heading' => __( 'Add Shadow?', 'flatsome' ),
                'default' => 'false',
            ),
            // Custom Class
            'class'        => array(
                'type'    => 'textfield',
                'heading' => __( 'Custom Class', 'flatsome' ),
                'default' => '',
            ),
        ),
    ) );
    }

// Shortcode hiển thị NTS CTA
function nts_cta_shortcode($atts)
    {
    extract( shortcode_atts( array(
        'button_text'  => 'Click me',
        'link'         => '#',
        'open_new_tab' => 'false',
        'button_type'  => 'primary',
        'has_shadow'   => 'false',
        'class'        => '',
    ), $atts ) );

    // Xử lý logic
    $target       = ($open_new_tab == 'true') ? '_blank' : '_self';
    $button_class = 'nts-cta-button cta-' . esc_attr( $button_type );
    $button_class .= ($has_shadow == 'true') ? ' has-shadow' : '';
    $button_class .= ' ' . esc_attr( $class );

    ob_start(); // Bắt đầu output buffering
    ?>
    <div class="nts-cta <?php echo esc_attr( $button_class ); ?>">
        <a href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>"
            class="nts-cta link">
            <?php echo esc_html( $button_text ); ?>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    <?php
    return ob_get_clean(); // Trả về HTML
    }
add_shortcode( 'nts_cta', 'nts_cta_shortcode' );