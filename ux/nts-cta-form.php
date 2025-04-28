<?php
// Đăng ký Element "NTS CTA Form" cho Flatsome UX Builder
add_action( 'ux_builder_setup', 'nts_register_cta_form_element' );

function nts_register_cta_form_element()
    {
    add_ux_builder_shortcode( 'nts_cta_form', array(
        'name'      => __( 'NTS CTA Form', 'flatsome' ),
        'category'  => __( 'Content', 'flatsome' ),
        'options'   => array(
            // Tiêu đề form
            'title'            => array(
                'type'    => 'textfield',
                'heading' => __( 'Tiêu đề form', 'flatsome' ),
                'default' => __( 'Liên hệ với chúng tôi', 'flatsome' ),
            ),
            // Mô tả
            'description'      => array(
                'type'    => 'textarea',
                'heading' => __( 'Mô tả', 'flatsome' ),
                'default' => __( 'Điền thông tin bên dưới, chúng tôi sẽ liên hệ lại trong 24h', 'flatsome' ),
            ),
            // Hiển thị hotline
            'show_hotline'     => array(
                'type'    => 'checkbox',
                'heading' => __( 'Hiển thị hotline', 'flatsome' ),
                'default' => 'true',
            ),
            // Hotline
            'hotline'          => array(
                'type'       => 'textfield',
                'heading'    => __( 'Số hotline', 'flatsome' ),
                'default'    => '0900.123.456',
            ),
            // Hiển thị nút chat
            'show_chat_button' => array(
                'type'    => 'checkbox',
                'heading' => __( 'Hiển thị nút "Chat ngay"', 'flatsome' ),
                'default' => 'true',
            ),
            // Thời gian phản hồi
            'response_time'    => array(
                'type'    => 'textfield',
                'heading' => __( 'Thời gian phản hồi', 'flatsome' ),
                'default' => '24 giờ',
            ),
            // Custom Class
            'class'            => array(
                'type'    => 'textfield',
                'heading' => __( 'Custom Class', 'flatsome' ),
                'default' => '',
            ),
        ),
    ) );
    }

// Shortcode hiển thị Form
function nts_cta_form_shortcode($atts)
    {
    extract( shortcode_atts( array(
        'title'            => 'Liên hệ với chúng tôi',
        'description'      => 'Điền thông tin bên dưới, chúng tôi sẽ liên hệ lại trong 24h',
        'show_hotline'     => 'true',
        'hotline'          => '0900.123.456',
        'show_chat_button' => 'true',
        'response_time'    => '24 giờ',
        'class'            => '',
    ), $atts ) );

    // Tạo nonce bảo mật
    $nonce = wp_create_nonce( 'nts_cta_form_nonce' );

    ob_start(); ?>

    <div class="nts-cta-form <?php echo esc_attr( $class ); ?>">
        <?php if ( !empty($title) ) : ?>
            <h3 class="form-title"><?php echo esc_html( $title ); ?></h3>
        <?php endif; ?>

        <?php if ( !empty($description) ) : ?>
            <div class="form-description">
                <?php echo wpautop( esc_html( $description ) ); ?>
            </div>
        <?php endif; ?>

        <form id="nts-contact-form" class="nts-contact-form" >
            <input type="hidden" name="action" value="nts_cta_form_submit">
            <input type="hidden" name="security" value="<?php echo esc_attr( $nonce ); ?>">

            <div class="form-group">
                <input type="text" name="fullname" placeholder="<?php esc_attr_e( 'Họ và tên*', 'flatsome' ); ?>" required>
            </div>

            <div class="form-group">
                <input type="text" name="company" placeholder="<?php esc_attr_e( 'Tên công ty', 'flatsome' ); ?>">
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="<?php esc_attr_e( 'Email*', 'flatsome' ); ?>" required>
            </div>

            <div class="form-group">
                <input type="tel" name="phone" placeholder="<?php esc_attr_e( 'Số điện thoại*', 'flatsome' ); ?>" required>
            </div>

            <div class="form-group">
                <textarea name="message" placeholder="<?php esc_attr_e( 'Nội dung liên hệ*', 'flatsome' ); ?>"
                    required></textarea>
            </div>

            <div class="form-footer">
                <button type="submit" class="button primary"><?php esc_html_e( 'Gửi liên hệ', 'flatsome' ); ?></button>

                <?php if ( $show_hotline == 'true' && !empty($hotline) ) : ?>
                    <div class="hotline-info">
                        <span><?php esc_html_e( 'Hoặc gọi ngay:', 'flatsome' ); ?></span>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $hotline ) ); ?>">
                            <?php echo esc_html( $hotline ); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </form>

        <?php if ( $show_chat_button == 'true' ) : ?>
            <button class="nts-chat-button button"><?php esc_html_e( 'Chat ngay', 'flatsome' ); ?></button>
        <?php endif; ?>

        <?php if ( !empty($response_time) ) : ?>
            <div class="response-time">
                <?php echo esc_html( sprintf( __( 'Thời gian phản hồi: %s', 'flatsome' ), $response_time ) ); ?>
            </div>
        <?php endif; ?>

        <div class="form-message"></div>
    </div>

    <?php

    return ob_get_clean();
    }
add_shortcode( 'nts_cta_form', 'nts_cta_form_shortcode' );

// Xử lý form submit
add_action( 'wp_ajax_nts_cta_form_submit', 'nts_cta_form_submit' );
add_action( 'wp_ajax_nopriv_nts_cta_form_submit', 'nts_cta_form_submit' );

function nts_cta_form_submit()
    {
    // Verify nonce
    if ( !check_ajax_referer( 'nts_cta_form_nonce', 'security', false ) ) {
        wp_send_json_error( __( 'Lỗi bảo mật, vui lòng tải lại trang!', 'flatsome' ) );
        }

    // Validate required fields
    $required_fields = array(
        'fullname' => __( 'Họ và tên', 'flatsome' ),
        'email'    => __( 'Email', 'flatsome' ),
        'phone'    => __( 'Số điện thoại', 'flatsome' ),
        'message'  => __( 'Nội dung', 'flatsome' ),
    );

    $errors = array();
    foreach ( $required_fields as $field => $name ) {
        if ( empty($_POST[$field]) ) {
            $errors[] = sprintf( __( 'Vui lòng điền %s', 'flatsome' ), $name );
            }
        }

    // Validate email
    if ( !empty($_POST['email']) && !is_email( $_POST['email'] ) ) {
        $errors[] = __( 'Email không hợp lệ', 'flatsome' );
        }

    if ( !empty($errors) ) {
        wp_send_json_error( implode( '<br>', $errors ) );
        }

    // Prepare email content
    $email_to = get_option( 'admin_email' );
    $subject  = __( 'Liên hệ mới từ website', 'flatsome' );

    $body = "Thông tin liên hệ:\n\n";
    $body .= "Họ và tên: " . sanitize_text_field( $_POST['fullname'] ) . "\n";
    $body .= "Công ty: " . sanitize_text_field( $_POST['company'] ) . "\n";
    $body .= "Email: " . sanitize_email( $_POST['email'] ) . "\n";
    $body .= "Điện thoại: " . sanitize_text_field( $_POST['phone'] ) . "\n";
    $body .= "Nội dung:\n" . sanitize_textarea_field( $_POST['message'] ) . "\n";

    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );

    // Send email
    if ( wp_mail( $email_to, $subject, $body, $headers ) ) {
        wp_send_json_success( __( 'Cảm ơn bạn! Chúng tôi sẽ liên hệ lại sớm nhất.', 'flatsome' ) );
        } else {
        wp_send_json_error( __( 'Không thể gửi email, vui lòng thử lại sau!', 'flatsome' ) );
        }
    }