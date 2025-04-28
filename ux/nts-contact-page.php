<?php
// Đăng ký Element "NTS Contact Page" cho Flatsome UX Builder
add_action('ux_builder_setup', 'nts_register_contact_page_element');

function nts_register_contact_page_element()
{
    add_ux_builder_shortcode('nts_contact_page', array(
        'name'      => __('NTS Contact Page', 'flatsome'),
        'category'  => __('Content', 'flatsome'),
        'options'   => array(
            // Tiêu đề
            'title' => array(
                'type'    => 'textfield',
                'heading' => __('Tiêu đề trang', 'flatsome'),
                'default' => __('Liên hệ', 'flatsome'),
            ),
            // Mô tả
            'subtitle' => array(
                'type'    => 'textarea',
                'heading' => __('Mô tả phụ', 'flatsome'),
                'default' => __('Hãy liên hệ với chúng tôi để được tư vấn về giải pháp xử lý nước tốt nhất cho bạn', 'flatsome'),
            ),
            // Thông tin liên hệ
            'address' => array(
                'type'    => 'textfield',
                'heading' => __('Địa chỉ', 'flatsome'),
                'default' => __('123 Đường ABC, Quận XYZ, Thành phố HCM', 'flatsome'),
            ),
            'phone' => array(
                'type'    => 'textfield',
                'heading' => __('Số điện thoại', 'flatsome'),
                'default' => __('0123 456 789', 'flatsome'),
            ),
            'email' => array(
                'type'    => 'textfield',
                'heading' => __('Email', 'flatsome'),
                'default' => __('info@xulynuoc.com', 'flatsome'),
            ),
            'working_hours' => array(
                'type'    => 'textfield',
                'heading' => __('Giờ làm việc', 'flatsome'),
                'default' => __('Thứ Hai - Thứ Sáu: 8:00 - 17:30', 'flatsome'),
            ),
            // Dịch vụ
            'services' => array(
                'type'    => 'textarea',
                'heading' => __('Dịch vụ (mỗi dịch vụ một dòng)', 'flatsome'),
                'default' => "Xử lý nước sinh hoạt\nXử lý nước công nghiệp\nHệ thống lọc RO\nBảo trì hệ thống nước",
            ),
            // Form đích
            'form_action' => array(
                'type'    => 'textfield',
                'heading' => __('Form Action URL', 'flatsome'),
                'default' => '#',
            ),
            // Bản đồ
            'map_iframe' => array(
                'type'    => 'textarea',
                'heading' => __('Mã nhúng Google Maps', 'flatsome'),
                'default' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4478896189677!2d106.6271430748042!3d10.776988889371922!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529e4a15a886b%3A0x35e5a5480416b0e5!2zQ8O0bmcgVHkgVE5ISCBHaeG6o2kgUGjDoXAgQ8O0bmcgTmdo4buHIE5hbSBLaMawxqFuZw!5e0!3m2!1svi!2s!4v1719550795099!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            ),
            // CTA
            'cta_title' => array(
                'type'    => 'textfield',
                'heading' => __('Tiêu đề CTA', 'flatsome'),
                'default' => __('Giải pháp xử lý nước toàn diện', 'flatsome'),
            ),
            'cta_text' => array(
                'type'    => 'textarea',
                'heading' => __('Nội dung CTA', 'flatsome'),
                'default' => __('Chúng tôi cung cấp dịch vụ tư vấn, thiết kế và lắp đặt hệ thống xử lý nước chất lượng cao', 'flatsome'),
            ),
            'cta_button_text' => array(
                'type'    => 'textfield',
                'heading' => __('Văn bản nút CTA', 'flatsome'),
                'default' => __('Tìm hiểu thêm', 'flatsome'),
            ),
            'cta_button_link' => array(
                'type'    => 'textfield',
                'heading' => __('Liên kết nút CTA', 'flatsome'),
                'default' => '#',
            ),
            // Custom Class
            'class' => array(
                'type'    => 'textfield',
                'heading' => __('Custom Class', 'flatsome'),
                'default' => '',
            ),
        ),
    ));
}

// Shortcode hiển thị Contact Page
function nts_contact_page_shortcode($atts)
{
    extract(shortcode_atts(array(
        'title'           => 'Liên hệ',
        'subtitle'        => 'Hãy liên hệ với chúng tôi để được tư vấn về giải pháp xử lý nước tốt nhất cho bạn',
        'address'         => '123 Đường ABC, Quận XYZ, Thành phố HCM',
        'phone'           => '0123 456 789',
        'email'           => 'info@xulynuoc.com',
        'working_hours'   => 'Thứ Hai - Thứ Sáu: 8:00 - 17:30',
        'services'        => "Xử lý nước sinh hoạt\nXử lý nước công nghiệp\nHệ thống lọc RO\nBảo trì hệ thống nước",
        'form_action'     => '#',
        'map_iframe'      => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4478896189677!2d106.6271430748042!3d10.776988889371922!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529e4a15a886b%3A0x35e5a5480416b0e5!2zQ8O0bmcgVHkgVE5ISCBHaeG6o2kgUGjDoXAgQ8O0bmcgTmdo4buHIE5hbSBLaMawxqFuZw!5e0!3m2!1svi!2s!4v1719550795099!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        'cta_title'       => 'Giải pháp xử lý nước toàn diện',
        'cta_text'        => 'Chúng tôi cung cấp dịch vụ tư vấn, thiết kế và lắp đặt hệ thống xử lý nước chất lượng cao',
        'cta_button_text' => 'Tìm hiểu thêm',
        'cta_button_link' => '#',
        'class'           => '',
    ), $atts));

    // Chuyển đổi dịch vụ từ text nhiều dòng thành mảng
    $services_array = explode("\n", $services);

    // Tạo nonce bảo mật
    $nonce = wp_create_nonce('contact_form_nonce');

    ob_start(); ?>

    <main id="primary" class="site-main contact-page water-treatment-theme <?php echo esc_attr($class); ?>">
        <header class="contact-page__header water-effect-header" data-animate="fadeInUp">
            <div class="water-bg"></div>
            
            <!-- Thêm mẫu nước nền -->
            <div class="water-pattern-bg">
                <svg width="100%" height="100%" preserveAspectRatio="none">
                    <use xlink:href="#water-pattern-bg" class="water-pattern"></use>
                </svg>
            </div>
            
            <!-- SVG Molecules nổi -->
            <div class="chemical-container">
                <svg class="chemical-molecules-svg" width="120" height="120">
                    <use xlink:href="#chemical-molecules"></use>
                </svg>
            </div>
            
            <!-- Water particles effect -->
            <div class="water-particles-effect">
                <div class="particle-container">
                    <!-- Dynamic particles will be generated by JS -->
                </div>
            </div>
            
            <div class="bubbles-container">
                <div class="bubble bubble-1"></div>
                <div class="bubble bubble-2"></div>
                <div class="bubble bubble-3"></div>
                <div class="bubble bubble-4"></div>
                <div class="bubble bubble-5"></div>
                <div class="bubble bubble-6"></div>
                <div class="bubble bubble-7"></div>
                <div class="bubble bubble-8"></div>
                <div class="bubble bubble-9"></div>
                <div class="bubble bubble-10"></div>
                
                <!-- Thêm hiệu ứng Splash -->
                <div class="splash-container">
                    <svg class="water-splash-svg" width="80" height="80">
                        <use xlink:href="#water-splash"></use>
                    </svg>
                </div>
            </div>

            <div class="container">
                <div class="contact-page__header-content service-header-content">
                    <!-- Animated Droplet Icon -->
                    <div class="animated-droplet-icon">
                        <svg width="60" height="90">
                            <use xlink:href="#animated-water-drop"></use>
                        </svg>
                    </div>
                    
                    <h1 class="contact-page__title page-title"><?php echo esc_html($title); ?></h1>
                    <p class="contact-page__subtitle page-description"><?php echo esc_html($subtitle); ?></p>
                </div>
            </div>
        </header>

        <div class="contact-page__content">
            <div class="container">
                <div class="contact-page__grid">
                    <section class="contact-page__info">
                        <div class="contact-page__section-heading">
                            <i class="fas fa-tint contact-page__water-icon"></i>
                            <h2>Thông tin liên hệ</h2>
                        </div>
                        
                        <div class="contact-page__info-card">
                            <?php if ($address): ?>
                                <div class="contact-page__info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><?php echo esc_html($address); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($phone): ?>
                                <div class="contact-page__info-item">
                                    <i class="fas fa-phone"></i>
                                    <span><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($email): ?>
                                <div class="contact-page__info-item">
                                    <i class="fas fa-envelope"></i>
                                    <span><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($working_hours): ?>
                                <div class="contact-page__info-item">
                                    <i class="fas fa-clock"></i>
                                    <span><?php echo esc_html($working_hours); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="contact-page__services">
                            <h3 class="contact-page__services-title">Dịch vụ xử lý nước</h3>
                            <ul class="contact-page__services-list">
                                <?php foreach ($services_array as $service): ?>
                                    <?php if (!empty(trim($service))): ?>
                                        <li class="contact-page__services-item"><i class="fas fa-check"></i> <span><?php echo esc_html(trim($service)); ?></span></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </section>

                    <section class="contact-page__form-section">
                        <div class="contact-page__section-heading">
                            <i class="fas fa-paper-plane contact-page__water-icon"></i>
                            <h2>Gửi tin nhắn cho chúng tôi</h2>
                        </div>
                        
                        <div class="contact-page__form-container">
                            <form action="<?php echo esc_url($form_action); ?>" method="post" class="contact-page__form">
                                <div class="contact-page__form-row">
                                    <div class="contact-page__form-group contact-page__form-group--half">
                                        <label for="contact-name" class="contact-page__form-label">
                                            Họ và tên <span class="contact-page__required">*</span>
                                        </label>
                                        <div class="contact-page__input-wrapper">
                                            <span class="contact-page__input-icon">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" id="contact-name" name="contact_name" class="contact-page__input" required>
                                        </div>
                                    </div>
                                    <div class="contact-page__form-group contact-page__form-group--half">
                                        <label for="contact-phone" class="contact-page__form-label">
                                            Số điện thoại
                                        </label>
                                        <div class="contact-page__input-wrapper">
                                            <span class="contact-page__input-icon">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            <input type="tel" id="contact-phone" name="contact_phone" class="contact-page__input">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="contact-page__form-group">
                                    <label for="contact-email" class="contact-page__form-label">
                                        Email <span class="contact-page__required">*</span>
                                    </label>
                                    <div class="contact-page__input-wrapper">
                                        <span class="contact-page__input-icon">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" id="contact-email" name="contact_email" class="contact-page__input" required>
                                    </div>
                                </div>
                                
                                <div class="contact-page__form-group">
                                    <label for="contact-service" class="contact-page__form-label">
                                        Dịch vụ quan tâm
                                    </label>
                                    <div class="contact-page__input-wrapper">
                                        <span class="contact-page__input-icon">
                                            <i class="fas fa-filter"></i>
                                        </span>
                                        <select id="contact-service" name="contact_service" class="contact-page__select">
                                            <option value="">Chọn dịch vụ</option>
                                            <option value="residential">Xử lý nước sinh hoạt</option>
                                            <option value="industrial">Xử lý nước công nghiệp</option>
                                            <option value="ro">Hệ thống lọc RO</option>
                                            <option value="maintenance">Bảo trì hệ thống</option>
                                            <option value="other">Dịch vụ khác</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="contact-page__form-group">
                                    <label for="contact-message" class="contact-page__form-label">
                                        Nội dung <span class="contact-page__required">*</span>
                                    </label>
                                    <div class="contact-page__input-wrapper">
                                        <span class="contact-page__input-icon contact-page__input-icon--textarea">
                                            <i class="fas fa-comment-alt"></i>
                                        </span>
                                        <textarea id="contact-message" name="contact_message" rows="5" class="contact-page__textarea" required></textarea>
                                    </div>
                                </div>
                                
                                <div class="contact-page__form-submit">
                                    <button type="submit" class="contact-page__btn contact-page__btn--primary btn-water-ripple">
                                        <i class="fas fa-paper-plane"></i> 
                                        <span>Gửi tin nhắn</span>
                                    </button>
                                </div>
                                
                                <?php wp_nonce_field('contact_form_nonce', 'contact_form_nonce_field'); ?>
                            </form>
                            
                            <div class="contact-page__form-decoration">
                                <div class="contact-page__water-drop"></div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <section class="contact-page__map">
            <div class="contact-page__map-title-container">
                <div class="container">
                    <h2 class="contact-page__map-title"><i class="fas fa-map-marked-alt"></i> Vị trí của chúng tôi</h2>
                </div>
            </div>
            
            <div class="contact-page__map-wrapper">
                <?php echo $map_iframe; // Map iFrame already escaped in extract() ?>
            </div>
        </section>

        <section class="contact-page__cta">
            <div class="container">
                <div class="contact-page__cta-content">
                    <h2 class="contact-page__cta-title"><?php echo esc_html($cta_title); ?></h2>
                    <p class="contact-page__cta-text"><?php echo esc_html($cta_text); ?></p>
                    <a href="<?php echo esc_url($cta_button_link); ?>" class="contact-page__btn contact-page__btn--secondary btn-water-ripple"><?php echo esc_html($cta_button_text); ?></a>
                </div>
            </div>
        </section>
    </main><!-- #main -->

    <script>
    jQuery(document).ready(function($) {
        // Create water particles
        function createWaterParticle() {
            var container = $('.particle-container');
            var containerWidth = container.width();
            var containerHeight = container.height();
            
            // Random size
            var size = Math.floor(Math.random() * 6) + 2; // 2px to 8px
            
            // Random position
            var posX = Math.floor(Math.random() * containerWidth);
            var posY = Math.floor(Math.random() * (containerHeight / 3)) + (containerHeight * 2/3); // Only in bottom 1/3
            
            // Create particle element
            var particle = $('<div class="water-particle"></div>');
            particle.css({
                width: size + 'px',
                height: size + 'px',
                left: posX + 'px',
                top: posY + 'px',
                opacity: Math.random() * 0.5 + 0.2
            });
            
            // Add to container
            container.append(particle);
            
            // Add class to activate animation
            particle.addClass('particle-animate');
            
            // Remove particle after animation completes
            setTimeout(function() {
                particle.remove();
            }, 8000);
        }
        
        // Create particles periodically
        setInterval(createWaterParticle, 200);
        
        // Floating Animation for header content
        function floatingAnimation() {
            $('.service-header-content').addClass('float-animation');
        }
        
        // Run floating animation
        setTimeout(floatingAnimation, 1000);
        
        // Button ripple effect
        $('.btn-water-ripple').on('click', function(e) {
            var btn = $(this);
            var btnOffset = btn.offset();
            var xPos = e.pageX - btnOffset.left;
            var yPos = e.pageY - btnOffset.top;

            var ripple = $('<span class="ripple-effect"></span>');
            ripple.css({
                width: btn.width(),
                height: btn.width(),
                top: yPos - (btn.width()/2),
                left: xPos - (btn.width()/2)
            });

            btn.append(ripple);

            setTimeout(function() {
                ripple.remove();
            }, 600);
        });
    });
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('nts_contact_page', 'nts_contact_page_shortcode'); 