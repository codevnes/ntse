<?php
// Đăng ký NTS Hero Element cho Flatsome UX Builder
add_action( 'ux_builder_setup', 'nts_register_ux_builder_element' );

function nts_register_ux_builder_element()
    {
    add_ux_builder_shortcode( 'nts_hero', array(
        'name'      => __( 'NTS Hero', 'flatsome' ), // Tên hiển thị trong UX Builder
        'category'  => __( 'Content', 'flatsome' ),  // Danh mục trong UX Builder
        'options'   => array(
            // Video nền (MP4)
            'video_bg'    => array(
                'type'        => 'textfield',
                'heading'     => __( 'Video Background (MP4)', 'flatsome' ),
                'description' => __( 'Nhập URL video MP4 (từ thư viện Media hoặc link ngoài).', 'flatsome' ),
                'default'     => '',
            ),
            // Tiêu đề
            'title'       => array(
                'type'    => 'textfield',
                'heading' => __( 'Tiêu đề', 'flatsome' ),
                'default' => __( 'Tiêu đề của bạn', 'flatsome' ),
            ),
            // Mô tả ngắn
            'description' => array(
                'type'    => 'textarea',
                'heading' => __( 'Mô tả ngắn', 'flatsome' ),
                'default' => __( 'Mô tả của bạn...', 'flatsome' ),
            ),
            // Tùy chọn CSS (tùy chọn)
            'class'       => array(
                'type'    => 'textfield',
                'heading' => __( 'Custom Class', 'flatsome' ),
                'default' => '',
            ),
        ),
    ) );
    }

// Shortcode hiển thị NTS Hero
function nts_hero_shortcode($atts)
    {
    extract( shortcode_atts( array(
        'video_bg'    => '',
        'title'       => 'Tiêu đề của bạn',
        'description' => 'Mô tả của bạn...',
        'class'       => '',
    ), $atts ) );

    ob_start(); // Bắt đầu output buffering
    ?>
    <div class="nts-hero <?php echo esc_attr( $class ); ?>">
        <?php if ( $video_bg ) : ?>
            <video class="nts-hero-video" preload="" playsinline="" autoplay="" muted="" loop="">
                <source src="/wp-content/uploads/2025/04/home-header-background.mp4" type="video/mp4">
            </video>
        <?php endif; ?>
        <div class="container nts-hero-content">
            <h1 class="nts-hero-title" data-animate="fadeInUp"><?php echo esc_html( $title ); ?></h1>
            <p class="nts-hero-description" data-animate="fadeInUp" data-animate-delay="200"><?php echo esc_html( $description ); ?></p>
        </div>

        <div class="hero-action">
            <a href="" class="action-button nts_animate__backInUp">
                <span>
                    Xem dự án đã thực hiện
                </span>
                <i class="fa-solid fa-arrow-right" ></i>
            </a>
            <a href="" class="action-button nts_animate__backInUp animate__delay-1s">
                <span>Liên hệ với chung tôi</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
    <?php
    return ob_get_clean(); // Trả về HTML
    }
add_shortcode( 'nts_hero', 'nts_hero_shortcode' );