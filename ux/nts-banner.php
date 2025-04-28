<?php
/**
 * Banner Trang Chủ Element
 * Element UX Builder hiển thị banner trang chủ với hình ảnh, nội dung, CTA và hiệu ứng nước
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('ux_builder_setup', function() {
    add_ux_builder_shortcode('nts_banner', [
        'name'      => __('Banner Trang Chủ', 'ntse'),
        'category'  => __('NTS Elements', 'ntse'),
        'icon'      => 'dashicons-cover-image',
        'info'      => '{{ title }}',
        'options'   => [
            'title' => [
                'type'    => 'textfield',
                'heading' => __('Tiêu đề chính', 'ntse'),
                'default' => __('Giải Pháp Xử Lý Nước Hiện Đại', 'ntse'),
            ],
            'subtitle' => [
                'type'    => 'textfield',
                'heading' => __('Tiêu đề phụ', 'ntse'),
                'default' => __('Công Nghệ Tiên Tiến - Chất Lượng Vượt Trội', 'ntse'),
            ],
            'description' => [
                'type'    => 'textarea',
                'heading' => __('Mô tả', 'ntse'),
                'default' => __('Chúng tôi cung cấp các giải pháp toàn diện về xử lý nước sạch, nước thải và nước công nghiệp với công nghệ hiện đại, đáp ứng mọi nhu cầu của khách hàng và đảm bảo tiêu chuẩn môi trường.', 'ntse'),
            ],
            'background_image' => [
                'type'    => 'image',
                'heading' => __('Hình nền', 'ntse'),
                'default' => ''
            ],
            'overlay_opacity' => [
                'type'    => 'slider',
                'heading' => __('Độ mờ lớp phủ', 'ntse'),
                'default' => 50,
                'min'     => 0,
                'max'     => 100,
                'step'    => 5,
            ],
            'content_image' => [
                'type'    => 'image',
                'heading' => __('Hình ảnh nội dung', 'ntse'),
                'default' => ''
            ],
            'cta_text' => [
                'type'    => 'textfield',
                'heading' => __('Nút CTA - Văn bản', 'ntse'),
                'default' => __('Tìm Hiểu Thêm', 'ntse'),
            ],
            'cta_link' => [
                'type'    => 'textfield',
                'heading' => __('Nút CTA - Đường dẫn', 'ntse'),
                'default' => '#',
            ],
            'cta_secondary_text' => [
                'type'    => 'textfield',
                'heading' => __('Nút CTA Phụ - Văn bản', 'ntse'),
                'default' => __('Liên Hệ Ngay', 'ntse'),
            ],
            'cta_secondary_link' => [
                'type'    => 'textfield',
                'heading' => __('Nút CTA Phụ - Đường dẫn', 'ntse'),
                'default' => '/lien-he',
            ],
            'features' => [
                'type'    => 'group',
                'heading' => __('Đặc điểm nổi bật', 'ntse'),
                'options' => [
                    'feature_1' => [
                        'type'    => 'textfield',
                        'heading' => __('Đặc điểm 1', 'ntse'),
                        'default' => __('Xử lý nước sạch', 'ntse'),
                    ],
                    'feature_2' => [
                        'type'    => 'textfield',
                        'heading' => __('Đặc điểm 2', 'ntse'),
                        'default' => __('Xử lý nước thải', 'ntse'),
                    ],
                    'feature_3' => [
                        'type'    => 'textfield',
                        'heading' => __('Đặc điểm 3', 'ntse'),
                        'default' => __('Cấp thoát nước', 'ntse'),
                    ],
                    'feature_4' => [
                        'type'    => 'textfield',
                        'heading' => __('Đặc điểm 4', 'ntse'),
                        'default' => __('Nước công nghiệp', 'ntse'),
                    ],
                ],
            ],
            'wave_effect' => [
                'type'    => 'checkbox',
                'heading' => __('Hiệu ứng sóng nước', 'ntse'),
                'default' => 'true',
            ],
            'bubbles_effect' => [
                'type'    => 'checkbox',
                'heading' => __('Hiệu ứng bong bóng', 'ntse'),
                'default' => 'true',
            ],
            'particles_effect' => [
                'type'    => 'checkbox',
                'heading' => __('Hiệu ứng hạt nước', 'ntse'),
                'default' => 'true',
            ],
            'dark_mode' => [
                'type'    => 'checkbox',
                'heading' => __('Chế độ tối', 'ntse'),
                'default' => 'true',
            ],
            'primary_color' => [
                'type'    => 'colorpicker',
                'heading' => __('Màu chính', 'ntse'),
                'default' => '#3a569e',
            ],
            'secondary_color' => [
                'type'    => 'colorpicker',
                'heading' => __('Màu phụ', 'ntse'),
                'default' => '#28A34A',
            ],
        ],
    ]);
});

// Render element HTML
function nts_banner_element($atts) {
    extract(shortcode_atts([
        'title'               => __('Giải Pháp Xử Lý Nước Hiện Đại', 'ntse'),
        'subtitle'            => __('Công Nghệ Tiên Tiến - Chất Lượng Vượt Trội', 'ntse'),
        'description'         => __('Chúng tôi cung cấp các giải pháp toàn diện về xử lý nước sạch, nước thải và nước công nghiệp với công nghệ hiện đại, đáp ứng mọi nhu cầu của khách hàng và đảm bảo tiêu chuẩn môi trường.', 'ntse'),
        'background_image'    => '',
        'overlay_opacity'     => 50,
        'content_image'       => '',
        'cta_text'            => __('Tìm Hiểu Thêm', 'ntse'),
        'cta_link'            => '#',
        'cta_secondary_text'  => __('Liên Hệ Ngay', 'ntse'),
        'cta_secondary_link'  => '/lien-he',
        'feature_1'           => __('Xử lý nước sạch', 'ntse'),
        'feature_2'           => __('Xử lý nước thải', 'ntse'),
        'feature_3'           => __('Cấp thoát nước', 'ntse'),
        'feature_4'           => __('Nước công nghiệp', 'ntse'),
        'wave_effect'         => 'true',
        'bubbles_effect'      => 'true',
        'particles_effect'    => 'true',
        'dark_mode'           => 'true',
        'primary_color'       => '#3a569e',
        'secondary_color'     => '#28A34A',
    ], $atts));

    $background_image_url = wp_get_attachment_image_url($background_image, 'full');
    $content_image_url = wp_get_attachment_image_url($content_image, 'full');
    $overlay_opacity_decimal = $overlay_opacity / 100;
    $wave_effect = ($wave_effect === 'true');
    $bubbles_effect = ($bubbles_effect === 'true');
    $particles_effect = ($particles_effect === 'true');
    $dark_mode = ($dark_mode === 'true');
    
    $features = [
        $feature_1,
        $feature_2,
        $feature_3,
        $feature_4
    ];

    // Filter empty features
    $features = array_filter($features);

    ob_start();
    
    // Thêm CSS
    $inline_styles = '
    <style>
        .nts-banner {
            position: relative;
            overflow: hidden;
            padding: 100px 0;
            background-color: ' . ($dark_mode ? '#192140' : '#f5f8fc') . ';
            color: ' . ($dark_mode ? '#fff' : '#192140') . ';
        }
        
        .nts-banner-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            background-size: cover;
            background-position: center;
            filter: blur(60px);
        }
        
        .nts-banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            background: radial-gradient(circle at 30% 40%, ' . esc_attr($secondary_color) . ' 0%, transparent 40%), 
                        radial-gradient(circle at 70% 20%, ' . esc_attr($primary_color) . ' 0%, ' . esc_attr($primary_color) . ' 100%);
            opacity: ' . esc_attr($overlay_opacity_decimal) . ';
            backdrop-filter: blur(10px);
        }
        
        .nts-banner-content {
            position: relative;
            z-index: 5;
        }
        
        .nts-banner-title {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.2;
            color: ' . ($dark_mode ? '#fff' : '#192140') . ';
        }
        
        .nts-banner-subtitle {
            font-size: 24px;
            margin-bottom: 20px;
            opacity: 0.9;
            color: ' . ($dark_mode ? '#fff' : '#192140') . ';
        }
        
        .nts-banner-description {
            font-size: 16px;
            margin-bottom: 30px;
            max-width: 600px;
            opacity: 0.8;
            color: ' . ($dark_mode ? 'rgba(255, 255, 255, 0.8)' : 'rgba(25, 33, 64, 0.8)') . ';
        }
        
        .nts-banner-features {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }
        
        .nts-banner-feature {
            margin-right: 25px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .nts-banner-feature svg {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            fill: ' . esc_attr($secondary_color) . ';
        }
        
        .nts-banner-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 30px;
        }
        
        .nts-banner-button {
            display: inline-block;
            padding: 12px 32px;
            font-size: 16px;
            font-weight: 700;
            text-align: center;
            border-radius: 4px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .nts-banner-button-primary {
            background-color: ' . esc_attr($secondary_color) . ';
            color: #fff;
            border: 2px solid ' . esc_attr($secondary_color) . ';
        }
        
        .nts-banner-button-primary:hover {
            background-color: transparent;
            color: #fff;
        }
        
        .nts-banner-button-secondary {
            background-color: transparent;
            color: ' . ($dark_mode ? '#fff' : '#192140') . ';
            border: 2px solid ' . ($dark_mode ? '#fff' : '#192140') . ';
        }
        
        .nts-banner-button-secondary:hover {
            background-color: ' . ($dark_mode ? '#fff' : '#192140') . ';
            color: ' . ($dark_mode ? '#192140' : '#fff') . ';
        }
        
        .nts-banner-image {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .nts-banner-image img {
            position: relative;
            z-index: 2;
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease;
        }
        
        .nts-banner-image:hover img {
            transform: translateY(-10px);
        }
        
        .water-waves {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            z-index: 3;
            overflow: hidden;
        }
        
        .water-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 300%;
            height: 100%;
        }
        
        .water-wave svg {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
        }
        
        .water-wave-1 {
            opacity: 0.7;
            animation: wave 35s linear infinite;
        }
        
        .water-wave-2 {
            opacity: 0.5;
            animation: wave 30s linear infinite reverse;
            bottom: -10px;
        }
        
        .water-wave-3 {
            opacity: 0.3;
            animation: wave 25s linear infinite;
            bottom: -20px;
        }
        
        @keyframes wave {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-66.66%);
            }
        }
        
        .bubbles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 2;
            overflow: hidden;
            top: 0;
            left: 0;
        }
        
        .bubble {
            position: absolute;
            bottom: -100px;
            width: 40px;
            height: 40px;
            background: transparent;
            border-radius: 50%;
            border: 2px solid ' . ($dark_mode ? 'rgba(255, 255, 255, 0.2)' : 'rgba(25, 33, 64, 0.1)') . ';
            animation: rise 8s infinite ease-in;
            opacity: 0;
        }
        
        .bubble:nth-child(1) {
            width: 20px;
            height: 20px;
            left: 15%;
            animation-duration: 12s;
            animation-delay: 1s;
        }
        
        .bubble:nth-child(2) {
            width: 35px;
            height: 35px;
            left: 25%;
            animation-duration: 10s;
            animation-delay: 4s;
        }
        
        .bubble:nth-child(3) {
            width: 15px;
            height: 15px;
            left: 40%;
            animation-duration: 7s;
            animation-delay: 3s;
        }
        
        .bubble:nth-child(4) {
            width: 30px;
            height: 30px;
            left: 60%;
            animation-duration: 9s;
            animation-delay: 2s;
        }
        
        .bubble:nth-child(5) {
            width: 25px;
            height: 25px;
            left: 80%;
            animation-duration: 8s;
            animation-delay: 5s;
        }
        
        @keyframes rise {
            0% {
                bottom: -100px;
                transform: translateX(0);
                opacity: 0;
            }
            20% {
                opacity: 0.8;
            }
            40% {
                opacity: 0.4;
            }
            50% {
                transform: translateX(30px);
            }
            80% {
                opacity: 0.3;
            }
            100% {
                bottom: 1080px;
                transform: translateX(-20px);
                opacity: 0;
            }
        }
        
        .particle-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            overflow: hidden;
        }
        
        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background-color: ' . ($dark_mode ? 'rgba(255, 255, 255, 0.3)' : 'rgba(25, 33, 64, 0.2)') . ';
            border-radius: 50%;
            animation: particles-float 20s infinite linear;
        }
        
        @keyframes particles-float {
            0% {
                transform: translateY(0) translateX(0) rotate(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 0.3;
            }
            100% {
                transform: translateY(-800px) translateX(70px) rotate(360deg);
                opacity: 0;
            }
        }
        
        .water-wave svg path {
            transition: fill 0.3s ease;
        }
    </style>
    ';
    
    // Thêm JavaScript cho các hiệu ứng
    $inline_script = '
    jQuery(document).ready(function($) {
        // Tạo các hạt nước động
        if (' . ($particles_effect ? 'true' : 'false') . ') {
            var particleContainer = $(".particle-container");
            for (var i = 0; i < 30; i++) {
                var size = Math.random() * 6 + 2;
                var posX = Math.random() * 100;
                var posY = Math.random() * 100;
                var delay = Math.random() * 5;
                var duration = Math.random() * 15 + 10;
                
                $("<div class=\'particle\'></div>")
                    .css({
                        width: size + "px",
                        height: size + "px",
                        left: posX + "%",
                        top: posY + "%",
                        animation: "particles-float " + duration + "s infinite linear",
                        "animation-delay": delay + "s"
                    })
                    .appendTo(particleContainer);
            }
        }
        
        // Đảm bảo hiệu ứng sóng mượt mà
        if (' . ($wave_effect ? 'true' : 'false') . ') {
            var primaryColor = "' . esc_attr($primary_color) . '";
            var secondaryColor = "' . esc_attr($secondary_color) . '";
            var isDarkMode = ' . ($dark_mode ? 'true' : 'false') . ';
            
            $(".water-wave svg path").each(function(index) {
                // Thêm màu dựa theo theme
                if (index === 0) {
                    $(this).attr({
                        "fill": secondaryColor,
                        "fill-opacity": isDarkMode ? "0.5" : "0.4"
                    });
                } else if (index === 1) {
                    $(this).attr({
                        "fill": primaryColor,
                        "fill-opacity": isDarkMode ? "0.3" : "0.2"
                    });
                } else {
                    $(this).attr({
                        "fill": secondaryColor,
                        "fill-opacity": isDarkMode ? "0.2" : "0.1"
                    });
                }
            });
        }
    });
    ';
    
    echo $inline_styles;
    ?>
    
    <div class="nts-banner <?php echo $dark_mode ? 'nts-banner-dark' : 'nts-banner-light'; ?>">
        <?php if ($background_image_url) : ?>
            <div class="nts-banner-bg" style="background-image: url('<?php echo esc_url($background_image_url); ?>')"></div>
        <?php endif; ?>
        
        <div class="nts-banner-overlay"></div>
        
        <?php if ($particles_effect) : ?>
            <div class="particle-container"></div>
        <?php endif; ?>
        
        <?php if ($bubbles_effect) : ?>
            <div class="bubbles">
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
            </div>
        <?php endif; ?>
        
        <div class="container">
            <div class="row">
                <div class="col large-6 medium-12">
                    <div class="col-inner">
                        <div class="nts-banner-content">
                            <?php if ($subtitle) : ?>
                                <div class="nts-banner-subtitle"><?php echo esc_html($subtitle); ?></div>
                            <?php endif; ?>
                            
                            <?php if ($title) : ?>
                                <h1 class="nts-banner-title"><?php echo esc_html($title); ?></h1>
                            <?php endif; ?>
                            
                            <?php if ($description) : ?>
                                <div class="nts-banner-description"><?php echo esc_html($description); ?></div>
                            <?php endif; ?>
                            
                            <?php if (!empty($features)) : ?>
                                <div class="nts-banner-features">
                                    <?php foreach ($features as $feature) : ?>
                                        <div class="nts-banner-feature">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                            </svg>
                                            <span><?php echo esc_html($feature); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="nts-banner-buttons">
                                <?php if ($cta_text) : ?>
                                    <a href="<?php echo esc_url($cta_link); ?>" class="nts-banner-button nts-banner-button-primary">
                                        <?php echo esc_html($cta_text); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($cta_secondary_text) : ?>
                                    <a href="<?php echo esc_url($cta_secondary_link); ?>" class="nts-banner-button nts-banner-button-secondary">
                                        <?php echo esc_html($cta_secondary_text); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col large-6 medium-12">
                    <div class="col-inner">
                        <?php if ($content_image_url) : ?>
                            <div class="nts-banner-image">
                                <img src="<?php echo esc_url($content_image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if ($wave_effect) : ?>
            <div class="water-waves">
                <div class="water-wave water-wave-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="#FFFFFF" fill-opacity="0.5" d="M0,192L60,186.7C120,181,240,171,360,186.7C480,203,600,245,720,245.3C840,245,960,203,1080,176C1200,149,1320,139,1380,133.3L1440,128L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
                    </svg>
                </div>
                <div class="water-wave water-wave-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="#FFFFFF" fill-opacity="0.3" d="M0,160L48,154.7C96,149,192,139,288,149.3C384,160,480,192,576,176C672,160,768,96,864,96C960,96,1056,160,1152,181.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                    </svg>
                </div>
                <div class="water-wave water-wave-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="#FFFFFF" fill-opacity="0.2" d="M0,64L48,74.7C96,85,192,107,288,133.3C384,160,480,192,576,186.7C672,181,768,139,864,138.7C960,139,1056,181,1152,181.3C1248,181,1344,139,1392,117.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                    </svg>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <?php
    wp_add_inline_script('jquery', $inline_script);
    
    return ob_get_clean();
}
add_shortcode('nts_banner', 'nts_banner_element'); 