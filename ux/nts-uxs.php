<?php
// Đăng ký NTS Contact Form Element cho Flatsome UX Builder
add_action( 'ux_builder_setup', 'nts_register_contact_form_element' );

function nts_register_contact_form_element()
    {
    add_ux_builder_shortcode( 'nts_contact_form', array(
        'name'     => __( 'NTS Contact Form', 'flatsome' ),
        'category' => __( 'Content', 'flatsome' ),
        'info'     => __( 'Form liên hệ 2 cột với thông tin công ty và form liên hệ', 'flatsome' ),
        'priority' => 1,
        'options'  => array(
            // Thông tin công ty
            'logo'                 => array(
                'type'    => 'image',
                'heading' => __( 'Logo công ty', 'flatsome' ),
                'default' => '',
            ),
            'company_name'         => array(
                'type'    => 'textfield',
                'heading' => __( 'Tên công ty', 'flatsome' ),
                'default' => '',
            ),
            'email'                => array(
                'type'    => 'textfield',
                'heading' => __( 'Email', 'flatsome' ),
                'default' => '',
            ),
            'phone'                => array(
                'type'    => 'textfield',
                'heading' => __( 'Số điện thoại', 'flatsome' ),
                'default' => '',
            ),
            'address'              => array(
                'type'    => 'textarea',
                'heading' => __( 'Địa chỉ', 'flatsome' ),
                'default' => '',
            ),
            // Cài đặt Form
            'form_title'           => array(
                'type'    => 'textfield',
                'heading' => __( 'Tiêu đề Form', 'flatsome' ),
                'default' => __( 'Liên hệ với chúng tôi', 'flatsome' ),
            ),
            'submit_text'          => array(
                'type'    => 'textfield',
                'heading' => __( 'Nút gửi', 'flatsome' ),
                'default' => __( 'Gửi liên hệ', 'flatsome' ),
            ),
            'success_message'      => array(
                'type'    => 'textarea',
                'heading' => __( 'Thông báo thành công', 'flatsome' ),
                'default' => __( 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.', 'flatsome' ),
            ),
            // Tùy chọn hiển thị
            'show_company_section' => array(
                'type'    => 'checkbox',
                'heading' => __( 'Hiển thị thông tin công ty?', 'flatsome' ),
                'default' => 'true',
            ),
            'show_social_links'    => array(
                'type'    => 'checkbox',
                'heading' => __( 'Hiển thị mạng xã hội?', 'flatsome' ),
                'default' => 'true',
            ),
            // Style
            'form_bg_color'        => array(
                'type'    => 'colorpicker',
                'heading' => __( 'Màu nền Form', 'flatsome' ),
                'default' => '#f5f5f5',
                'alpha'   => true,
            ),
            'nts_class'            => array(
                'type'    => 'textfield',
                'heading' => __( 'Custom CSS Class', 'flatsome' ),
                'default' => '',
            ),
        ),
    ) );
    }

// Shortcode hiển thị NTS Contact Form
function nts_contact_form_shortcode($atts)
    {
    $atts = shortcode_atts( array(
        'logo'                 => '',
        'company_name'         => '',
        'email'                => '',
        'phone'                => '',
        'address'              => '',
        'social_links'         => array(),
        'form_title'           => 'Liên hệ với chúng tôi',
        'submit_text'          => 'Gửi liên hệ',
        'success_message'      => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.',
        'show_company_section' => 'true',
        'show_social_links'    => 'true',
        'form_bg_color'        => '#f5f5f5',
        'nts_class'            => '',
    ), $atts );

    // Xử lý social links
    $social_links = is_array( $atts['social_links'] ) ? $atts['social_links'] : array();

    // Tạo ID duy nhất cho form
    $form_id = 'nts-contact-form-' . wp_rand( 1000, 9999 );


    ob_start();
    ?>
    <style>
        .nts-contact-info-wrapper,
        .nts-contact-form-wrapper {
            padding: 2rem;
            border: 1px solid var(--primary);
            border-radius: 0.5rem;
            height: 100%;
        }

        .nts-contact-logo img {
            width: 120px;
            height: auto;
        }

        .nts-company-name {
            font-size: 2.4rem;
            color: var(--primary);
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .nts-contact-info .nts-contact-item {
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .nts-contact-info .nts-contact-item a {
            color: var(--primary);
        }

        .nts-form-group {
            margin-bottom: 0.5rem;
        }

        .nts-form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }

        .nts-form-group input,
        .nts-form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            box-shadow: none !important;
        }

        .nts-form .col {
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .nts-form-submit {
            margin-top: 1rem;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 0.75rem 1.25rem;
            margin-top: 1rem;
            border-radius: 0.25rem;
        }

        .nts-form-group textarea {
            min-height: unset;
            height: 100%;
        }
    </style>
    <div class="nts-contact-form <?php echo esc_attr( $atts['nts_class'] ); ?>" id="<?php echo esc_attr( $form_id ); ?>">
        <div class="row">
            <?php if ( $atts['show_company_section'] === 'true' ) : ?>
                <div class="col large-4 medium-12 small-12 nts-contact-info">
                    <div class="nts-contact-info-wrapper">

                        <?php if ( !empty($atts['logo']) ) : ?>
                            <div class="nts-contact-logo">
                                <?php echo wp_get_attachment_image( $atts['logo'], 'full', false, array( 'class' => 'img-logo' ) ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( !empty($atts['company_name']) ) : ?>
                            <h3 class="nts-company-name"><?php echo esc_html( $atts['company_name'] ); ?></h3>
                        <?php endif; ?>

                        <div class="nts-contact-details">
                            <?php if ( !empty($atts['email']) ) : ?>
                                <div class="nts-contact-item">
                                    <i class="fa-solid fa-envelope"></i>
                                    <a
                                        href="mailto:<?php echo esc_attr( $atts['email'] ); ?>"><?php echo esc_html( $atts['email'] ); ?></a>
                                </div>
                            <?php endif; ?>

                            <?php if ( !empty($atts['phone']) ) : ?>
                                <div class="nts-contact-item">
                                    <i class="fa-solid fa-phone"></i>
                                    <a
                                        href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $atts['phone'] ) ); ?>"><?php echo esc_html( $atts['phone'] ); ?></a>
                                </div>
                            <?php endif; ?>

                            <?php if ( !empty($atts['address']) ) : ?>
                                <div class="nts-contact-item">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span><?php echo wp_kses_post( nl2br( $atts['address'] ) ); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div
                class="col large-<?php echo ($atts['show_company_section'] === 'true') ? '8' : '12'; ?> medium-12 small-12">
                <div class="nts-contact-form-wrapper"
                    style="background-color: <?php echo esc_attr( $atts['form_bg_color'] ); ?>">
                    <?php if ( !empty($atts['form_title']) ) : ?>
                        <h3 class="nts-form-title"><?php echo esc_html( $atts['form_title'] ); ?></h3>
                    <?php endif; ?>

                    <form class="nts-form" method="post">
                        <div class="row">
                            <div class="col medium-6 small-12">
                                <div class="nts-form-group">
                                    <label for="<?php echo esc_attr( $form_id ); ?>-name">
                                        <i class="fa-solid fa-user"></i> <?php _e( 'Họ và tên', 'flatsome' ); ?> *
                                    </label>
                                    <input type="text" id="<?php echo esc_attr( $form_id ); ?>-name" name="name" required>
                                </div>
                            </div>
                            <div class="col medium-6 small-12">
                                <div class="nts-form-group">
                                    <label for="<?php echo esc_attr( $form_id ); ?>-company">
                                        <i class="fa-solid fa-building"></i> <?php _e( 'Tên công ty', 'flatsome' ); ?>
                                    </label>
                                    <input type="text" id="<?php echo esc_attr( $form_id ); ?>-company" name="company">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col medium-6 small-12">
                                <div class="nts-form-group">
                                    <label for="<?php echo esc_attr( $form_id ); ?>-email">
                                        <i class="fa-solid fa-envelope"></i> <?php _e( 'Email', 'flatsome' ); ?> *
                                    </label>
                                    <input type="email" id="<?php echo esc_attr( $form_id ); ?>-email" name="email"
                                        required>
                                </div>
                            </div>
                            <div class="col medium-6 small-12">
                                <div class="nts-form-group">
                                    <label for="<?php echo esc_attr( $form_id ); ?>-phone">
                                        <i class="fa-solid fa-phone"></i> <?php _e( 'Số điện thoại', 'flatsome' ); ?>
                                    </label>
                                    <input type="tel" id="<?php echo esc_attr( $form_id ); ?>-phone" name="phone">
                                </div>
                            </div>
                        </div>

                        <div class="nts-form-group">
                            <label for="<?php echo esc_attr( $form_id ); ?>-message">
                                <i class="fa-solid fa-comment-dots"></i> <?php _e( 'Nội dung liên hệ', 'flatsome' ); ?> *
                            </label>
                            <textarea id="<?php echo esc_attr( $form_id ); ?>-message" name="message" rows="2"
                                required></textarea>
                        </div>

                        <div class="nts-form-submit">
                            <button type="submit" class="button primary">
                                <i class="fa-solid fa-paper-plane"></i> <?php echo esc_html( $atts['submit_text'] ); ?>
                            </button>
                        </div>

                        <div class="nts-form-message" style="display: none;">
                            <div class="alert alert-success">
                                <i class="fa-solid fa-circle-check"></i> <?php echo esc_html( $atts['success_message'] ); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function ($) {
            $('#<?php echo esc_attr( $form_id ); ?> .nts-form').on('submit', function (e) {
                e.preventDefault();
                var form = $(this);
                var formData = form.serialize();

                $.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                    data: formData + '&action=nts_contact_form_submit',
                    beforeSend: function () {
                        form.find('button[type="submit"]').prop('disabled', true)
                            .html('<i class="fa-solid fa-spinner fa-spin"></i> <?php _e( 'Đang gửi...', 'flatsome' ); ?>');
                    },
                    success: function (response) {
                        if (response.success) {
                            form[0].reset();
                            form.find('.nts-form-message').show();
                        } else {
                            alert('<?php _e( 'Có lỗi xảy ra, vui lòng thử lại sau.', 'flatsome' ); ?>');
                        }
                        form.find('button[type="submit"]').prop('disabled', false)
                            .html('<i class="fa-solid fa-paper-plane"></i> <?php echo esc_js( $atts['submit_text'] ); ?>');
                    },
                    error: function () {
                        alert('<?php _e( 'Có lỗi xảy ra, vui lòng thử lại sau.', 'flatsome' ); ?>');
                        form.find('button[type="submit"]').prop('disabled', false)
                            .html('<i class="fa-solid fa-paper-plane"></i> <?php echo esc_js( $atts['submit_text'] ); ?>');
                    }
                });
            });
        });
    </script>
    <?php

    return ob_get_clean();
    }
add_shortcode( 'nts_contact_form', 'nts_contact_form_shortcode' );

// Xử lý form submit
add_action( 'wp_ajax_nts_contact_form_submit', 'nts_handle_contact_form_submit' );
add_action( 'wp_ajax_nopriv_nts_contact_form_submit', 'nts_handle_contact_form_submit' );

function nts_handle_contact_form_submit()
    {
    if ( !isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message']) ) {
        wp_send_json_error();
        }

    $name    = sanitize_text_field( $_POST['name'] );
    $company = isset($_POST['company']) ? sanitize_text_field( $_POST['company'] ) : '';
    $email   = sanitize_email( $_POST['email'] );
    $phone   = isset($_POST['phone']) ? sanitize_text_field( $_POST['phone'] ) : '';
    $message = sanitize_textarea_field( $_POST['message'] );

    // Gửi email (cần cấu hình thêm)
    $to      = get_option( 'admin_email' );
    $subject = 'Liên hệ mới từ ' . $name;
    $body    = "Tên: $name\n";
    $body .= "Công ty: $company\n";
    $body .= "Email: $email\n";
    $body .= "Điện thoại: $phone\n\n";
    $body .= "Nội dung:\n$message";

    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );

    if ( wp_mail( $to, $subject, $body, $headers ) ) {
        wp_send_json_success();
        } else {
        wp_send_json_error();
        }
    }