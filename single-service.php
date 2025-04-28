<?php
get_header();

// Get the service data
$post_id = get_the_ID();
$short_description = get_post_meta($post_id, '_service_short_description', true);
$cta_text = get_post_meta($post_id, '_service_cta_text', true);
$cta_url = get_post_meta($post_id, '_service_cta_url', true);
$detailed_description = get_post_meta($post_id, '_service_detailed_description', true);
$customer_problems = get_post_meta($post_id, '_service_customer_problems', true);
$target_audience = get_post_meta($post_id, '_service_target_audience', true);
$main_benefits = get_post_meta($post_id, '_service_main_benefits', true);
$process_steps = get_post_meta($post_id, '_service_process_steps', true);
$highlights = get_post_meta($post_id, '_service_highlights', true);
$technologies = get_post_meta($post_id, '_service_technologies', true);
$certifications = get_post_meta($post_id, '_service_certifications', true);
$team = get_post_meta($post_id, '_service_team', true);
$testimonials = get_post_meta($post_id, '_service_testimonials', true);
$faqs = get_post_meta($post_id, '_service_faqs', true);
$response_time = get_post_meta($post_id, '_service_response_time', true);
$related_services = get_post_meta($post_id, '_service_related_services', true);
$resources = get_post_meta($post_id, '_service_resources', true);
?>

<div class="service-single-content">
    <!-- Hero Section -->
    <section class="service-hero">
        <div class="water-bg"></div>
        <div class="water-pattern-bg"></div>
        
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
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="large-6 col">
                    <div class="col-inner">
                        <h1 class="service-title"><?php the_title(); ?></h1>
                        <?php if (!empty($short_description)) : ?>
                            <div class="service-short-description"><?php echo wpautop($short_description); ?></div>
                        <?php endif; ?>
                        
                        <div class="service-cta">
                            <a href="<?php echo !empty($cta_url) ? esc_url($cta_url) : esc_url(home_url('/lien-he/')); ?>" class="btn-water-ripple primary-btn">
                                <span><?php echo !empty($cta_text) ? esc_html($cta_text) : __('Liên hệ ngay', 'ntse'); ?></span>
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="large-6 col">
                    <div class="col-inner">
                        <div class="service-featured-image-container">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="service-featured-image">
                                    <?php the_post_thumbnail('large'); ?>
                                    <div class="image-overlay"></div>
                                    <div class="floating-droplets">
                                        <div class="droplet droplet-1"></div>
                                        <div class="droplet droplet-2"></div>
                                        <div class="droplet droplet-3"></div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="service-placeholder-image">
                                    <svg viewBox="0 0 24 24"><path d="M12,20C8.13,20 5,16.87 5,13C5,9.13 8.13,6 12,6C15.87,6 19,9.13 19,13C19,16.87 15.87,20 12,20M12,4C7.03,4 3,8.03 3,13C3,17.97 7.03,22 12,22C16.97,22 21,17.97 21,13C21,8.03 16.97,4 12,4M12,9C10.34,9 9,10.34 9,12C9,13.66 10.34,15 12,15C13.66,15 15,13.66 15,12C15,10.34 13.66,9 12,9Z"/></svg>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <svg class="wave-bottom" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffffff" fill-opacity="1" d="M0,192L48,181.3C96,171,192,149,288,149.3C384,149,480,171,576,176C672,181,768,171,864,176C960,181,1056,203,1152,202.7C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </section>

    <!-- Service Overview Section -->
    <?php if (!empty($detailed_description) || !empty($customer_problems) || !empty($target_audience) || !empty($main_benefits)) : ?>
    <section class="service-overview-section">
        <div class="container">
            <div class="section-header text-center">
                <div class="section-icon">
                    <i class="fas fa-info-circle fa-2x"></i>
                </div>
                <h2 class="section-title"><?php _e('Tổng quan dịch vụ', 'ntse'); ?></h2>
                <div class="section-divider">
                    <svg width="50" height="15" viewBox="0 0 120 30">
                        <path d="M0,15 C30,5 60,25 120,15 L120,0 L0,0 Z" />
                    </svg>
                </div>
            </div>

            <?php if (!empty($detailed_description)) : ?>
            <div class="service-description">
                <?php echo wpautop($detailed_description); ?>
            </div>
            <?php endif; ?>

            <div class="row service-overview-cards">
                <?php if (!empty($customer_problems)) : ?>
                <div class="medium-4 col">
                    <div class="col-inner mb-2">
                        <div class="water-card overview-card">
                            <div class="card-icon">
                                <svg width="50" height="50" viewBox="0 0 24 24">
                                    <path d="M12,2C6.47,2 2,6.47 2,12C2,17.53 6.47,22 12,22A10,10 0 0,0 22,12C22,6.47 17.53,2 12,2M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M13,10H11V6H13V10M13,14H11V12H13V14Z" />
                                </svg>
                            </div>
                            <h3 class="card-title"><?php _e('Vấn đề khách hàng', 'ntse'); ?></h3>
                            <div class="card-content">
                                <?php echo wpautop($customer_problems); ?>
                            </div>
                            <div class="card-water-effect"></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($target_audience)) : ?>
                <div class="medium-4 col">
                    <div class="col-inner mb-2">
                        <div class="water-card overview-card highlight-card">
                            <div class="card-icon">
                                <svg width="50" height="50" viewBox="0 0 24 24">
                                    <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
                                </svg>
                            </div>
                            <h3 class="card-title"><?php _e('Đối tượng phù hợp', 'ntse'); ?></h3>
                            <div class="card-content">
                                <?php echo wpautop($target_audience); ?>
                            </div>
                            <div class="card-water-effect"></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($main_benefits)) : ?>
                <div class="medium-4 col">
                    <div class="col-inner mb-2">
                        <div class="water-card overview-card">
                            <div class="card-icon">
                                <svg width="50" height="50" viewBox="0 0 24 24">
                                    <path d="M5,21V6H9V21H5M10,21V3H14V21H10M15,21V9H19V21H15Z" />
                                </svg>
                            </div>
                            <h3 class="card-title"><?php _e('Lợi ích chính', 'ntse'); ?></h3>
                            <div class="card-content">
                                <?php echo wpautop($main_benefits); ?>
                            </div>
                            <div class="card-water-effect"></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Service Process Section -->
    <?php if (!empty($process_steps) && is_array($process_steps)) : ?>
    <section class="service-process-section">
        <div class="container">
            <div class="section-header text-center">
                <div class="section-icon">
                    <i class="fas fa-tasks fa-2x"></i>
                </div>
                <h2 class="section-title"><?php _e('Quy trình thực hiện', 'ntse'); ?></h2>
                <div class="section-divider">
                    <svg width="50" height="15" viewBox="0 0 120 30">
                        <path d="M0,15 C30,5 60,25 120,15 L120,0 L0,0 Z" />
                    </svg>
                </div>
            </div>

            <div class="service-process-timeline">
                <div class="timeline-water-effect">
                    <div class="water-particles-effect" id="timelineWaterEffect"></div>
                </div>

                <?php foreach ($process_steps as $index => $step) : 
                    $position_class = ($index % 2 == 0) ? 'left' : 'right';
                ?>
                <div class="timeline-item <?php echo esc_attr($position_class); ?>">
                    <div class="timeline-marker">
                        <div class="marker-content"><?php echo $index + 1; ?></div>
                        <div class="marker-ripple"></div>
                    </div>
                    <div class="timeline-content water-card">
                        <h3 class="timeline-title"><?php echo esc_html($step['title']); ?></h3>
                        <div class="timeline-body">
                            <?php echo wpautop($step['description']); ?>
                        </div>
                        <?php if (!empty($step['time'])) : ?>
                        <div class="timeline-time">
                            <svg width="16" height="16" viewBox="0 0 24 24">
                                <path d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z" />
                            </svg>
                            <?php echo esc_html($step['time']); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Service Highlights Section -->
    <?php if (!empty($highlights) || !empty($technologies) || !empty($certifications) || !empty($team)) : ?>
    <section class="service-highlights-section">
        <div class="container">
            <div class="section-header text-center">
                <div class="section-icon">
                    <i class="fas fa-star fa-2x"></i>
                </div>
                <h2 class="section-title"><?php _e('Điểm nổi bật', 'ntse'); ?></h2>
                <div class="section-divider">
                    <svg width="50" height="15" viewBox="0 0 120 30">
                        <path d="M0,15 C30,5 60,25 120,15 L120,0 L0,0 Z" />
                    </svg>
                </div>
            </div>

            <div class="row">
                <?php if (!empty($highlights)) : ?>
                <div class="large-6 col">
                    <div class="col-inner mb-2">
                        <div class="water-card highlights-list">
                            <h3><?php _e('Tại sao chọn dịch vụ của chúng tôi?', 'ntse'); ?></h3>
                            <ul class="water-drop-list">
                                <?php 
                                $highlights_array = explode("\n", $highlights);
                                foreach ($highlights_array as $index => $highlight) :
                                    if (trim($highlight)) :
                                ?>
                                <li style="--delay: <?php echo $index; ?>">
                                    <div class="drop-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24">
                                            <path d="M12,20A6,6 0 0,1 6,14C6,10 12,3.25 12,3.25C12,3.25 18,10 18,14A6,6 0 0,1 12,20Z" />
                                        </svg>
                                    </div>
                                    <div class="drop-content">
                                        <?php echo esc_html(trim($highlight)); ?>
                                    </div>
                                </li>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($team)) : ?>
                <div class="large-6 col">
                    <div class="col-inner mb-2">
                        <div class="water-card team-info">
                            <h3><?php _e('Đội ngũ chuyên nghiệp', 'ntse'); ?></h3>
                            <?php echo wpautop($team); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($technologies)) : ?>
                <div class="large-6 col">
                    <div class="col-inner mb-2">
                        <div class="water-card tech-card special-card">
                            <div class="hexagon-overlay">
                                <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                    <path d="M50 0 L100 25 L100 75 L50 100 L0 75 L0 25 Z" />
                                </svg>
                            </div>
                            <div class="tech-icon">
                                <svg width="64" height="64" viewBox="0 0 24 24">
                                    <path d="M19.35,10.04C18.67,6.59 15.64,4 12,4C9.11,4 6.61,5.64 5.36,8.04C2.35,8.36 0,10.9 0,14A6,6 0 0,0 6,20H19A5,5 0 0,0 24,15C24,12.36 21.95,10.22 19.35,10.04Z" />
                                </svg>
                            </div>
                            <h3 class="tech-title"><?php _e('Công nghệ độc quyền', 'ntse'); ?></h3>
                            <div class="tech-content">
                                <?php echo wpautop($technologies); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($certifications)) : ?>
                <div class="large-6 col">
                    <div class="col-inner mb-2">
                        <div class="water-card cert-card">
                            <div class="cert-icon">
                                <svg width="64" height="64" viewBox="0 0 24 24">
                                    <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M11,16.5L18,9.5L16.59,8.09L11,13.67L7.91,10.59L6.5,12L11,16.5Z" />
                                </svg>
                            </div>
                            <h3 class="cert-title"><?php _e('Chứng nhận & Bảo đảm', 'ntse'); ?></h3>
                            <div class="cert-content">
                                <?php echo wpautop($certifications); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Testimonials Section -->
    <?php if (!empty($testimonials) && is_array($testimonials)) : ?>
    <section class="service-testimonials-section">
        <div class="container">
            <div class="section-header text-center">
                <div class="section-icon">
                    <i class="fas fa-quote-right fa-2x"></i>
                </div>
                <h2 class="section-title"><?php _e('Khách hàng nói gì về chúng tôi', 'ntse'); ?></h2>
                <div class="section-divider">
                    <svg width="50" height="15" viewBox="0 0 120 30">
                        <path d="M0,15 C30,5 60,25 120,15 L120,0 L0,0 Z" />
                    </svg>
                </div>
            </div>

            <div class="testimonials-slider swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($testimonials as $testimonial) : ?>
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="testimonial-rating">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <?php if ($i <= $testimonial['rating']) : ?>
                                        <svg class="star-filled" width="18" height="18" viewBox="0 0 24 24">
                                            <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" />
                                        </svg>
                                    <?php else : ?>
                                        <svg class="star-empty" width="18" height="18" viewBox="0 0 24 24">
                                            <path d="M12,15.39L8.24,17.66L9.23,13.38L5.91,10.5L10.29,10.13L12,6.09L13.71,10.13L18.09,10.5L14.77,13.38L15.76,17.66M22,9.24L14.81,8.63L12,2L9.19,8.63L2,9.24L7.45,13.97L5.82,21L12,17.27L18.18,21L16.54,13.97L22,9.24Z" />
                                        </svg>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <div class="testimonial-content">
                                <?php echo esc_html($testimonial['content']); ?>
                            </div>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <svg width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
                                    </svg>
                                </div>
                                <div class="author-info">
                                    <div class="author-name"><?php echo esc_html($testimonial['name']); ?></div>
                                    <div class="author-role"><?php echo esc_html($testimonial['role']); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- FAQ Section -->
    <?php if (!empty($faqs) && is_array($faqs)) : ?>
    <section class="service-faq-section">
        <div class="container">
            <div class="section-header text-center">
                <div class="section-icon">
                    <i class="fas fa-question-circle fa-2x"></i>
                </div>
                <h2 class="section-title"><?php _e('Câu hỏi thường gặp', 'ntse'); ?></h2>
                <div class="section-divider">
                    <svg width="50" height="15" viewBox="0 0 120 30">
                        <path d="M0,15 C30,5 60,25 120,15 L120,0 L0,0 Z" />
                    </svg>
                </div>
            </div>

            <div class="faq-accordion">
                <?php foreach ($faqs as $index => $faq) : ?>
                <div class="faq-item" id="faq-<?php echo $index; ?>">
                    <div class="faq-question">
                        <h3><?php echo esc_html($faq['question']); ?></h3>
                        <div class="faq-toggle">
                            <svg class="plus-icon" width="20" height="20" viewBox="0 0 24 24">
                                <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
                            </svg>
                            <svg class="minus-icon" width="20" height="20" viewBox="0 0 24 24">
                                <path d="M19,13H5V11H19V13Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <?php echo wpautop($faq['answer']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA & Related Section -->
    <section class="service-cta-section">
        <div class="container">
            <div class="water-card cta-card special-card text-center">
                <div class="water-pattern-bg"></div>
                <div class="cta-bubbles">
                    <div class="bubble bubble-1"></div>
                    <div class="bubble bubble-2"></div>
                    <div class="bubble bubble-3"></div>
                </div>
                <div class="cta-content">
                    <h2 class="cta-title"><?php _e('Bạn cần hỗ trợ ngay?', 'ntse'); ?></h2>
                    <p class="cta-text"><?php _e('Đội ngũ chuyên gia của chúng tôi sẵn sàng tư vấn cho bạn. Hãy liên hệ ngay!', 'ntse'); ?></p>
                    
                    <?php if (!empty($response_time)) : ?>
                    <div class="response-time">
                        <svg width="16" height="16" viewBox="0 0 24 24">
                            <path d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z" />
                        </svg>
                        <?php _e('Thời gian phản hồi:', 'ntse'); ?> <?php echo esc_html($response_time); ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="cta-actions">
                        <a href="<?php echo esc_url(home_url('/lien-he/')); ?>" class="btn-water-ripple">
                            <span><?php _e('Liên hệ ngay', 'ntse'); ?></span>
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <?php if (!empty($related_services) && is_array($related_services)) : ?>
            <div class="related-services-section">
                <div class="section-header text-center">
                    <h2 class="section-title"><?php _e('Dịch vụ liên quan', 'ntse'); ?></h2>
                    <div class="section-divider">
                        <svg width="50" height="15" viewBox="0 0 120 30">
                            <path d="M0,15 C30,5 60,25 120,15 L120,0 L0,0 Z" />
                        </svg>
                    </div>
                </div>

                <div class="row">
                    <?php 
                    foreach ($related_services as $related_id) : 
                        $related_post = get_post($related_id);
                        if ($related_post) :
                    ?>
                    <div class="medium-4 col">
                        <div class="col-inner mb-2">
                            <a href="<?php echo get_permalink($related_id); ?>" class="water-card related-service-card">
                                <div class="related-service-image">
                                    <?php if (has_post_thumbnail($related_id)) : ?>
                                        <?php echo get_the_post_thumbnail($related_id, 'medium'); ?>
                                    <?php else : ?>
                                        <div class="no-thumbnail">
                                            <svg viewBox="0 0 24 24"><path d="M12,20C8.13,20 5,16.87 5,13C5,9.13 8.13,6 12,6C15.87,6 19,9.13 19,13C19,16.87 15.87,20 12,20M12,4C7.03,4 3,8.03 3,13C3,17.97 7.03,22 12,22C16.97,22 21,17.97 21,13C21,8.03 16.97,4 12,4M12,9C10.34,9 9,10.34 9,12C9,13.66 10.34,15 12,15C13.66,15 15,13.66 15,12C15,10.34 13.66,9 12,9Z"/></svg>
                                        </div>
                                    <?php endif; ?>
                                    <div class="image-overlay"></div>
                                </div>
                                <div class="related-service-content">
                                    <h3 class="related-service-title"><?php echo get_the_title($related_id); ?></h3>
                                    <div class="related-service-arrow">
                                        <svg width="24" height="24" viewBox="0 0 24 24">
                                            <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($resources)) : ?>
            <div class="resources-section">
                <div class="section-header text-center">
                    <h2 class="section-title"><?php _e('Tài liệu & Thông tin thêm', 'ntse'); ?></h2>
                    <div class="section-divider">
                        <svg width="50" height="15" viewBox="0 0 120 30">
                            <path d="M0,15 C30,5 60,25 120,15 L120,0 L0,0 Z" />
                        </svg>
                    </div>
                </div>

                <div class="row">
                    <div class="large-8 small-centered col">
                        <div class="col-inner">
                            <div class="water-card resources-list">
                                <ul class="resource-links">
                                    <?php 
                                    $resources_array = explode("\n", $resources);
                                    foreach ($resources_array as $resource) :
                                        $resource_parts = explode('|', $resource);
                                        if (count($resource_parts) === 2) :
                                            $resource_title = trim($resource_parts[0]);
                                            $resource_url = trim($resource_parts[1]);
                                            if (!empty($resource_title) && !empty($resource_url)) :
                                    ?>
                                    <li>
                                        <a href="<?php echo esc_url($resource_url); ?>" class="resource-link" target="_blank">
                                            <div class="resource-icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24">
                                                    <path d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z" />
                                                </svg>
                                            </div>
                                            <div class="resource-info">
                                                <span class="resource-title"><?php echo esc_html($resource_title); ?></span>
                                                <span class="resource-url"><?php echo esc_url($resource_url); ?></span>
                                            </div>
                                            <div class="resource-arrow">
                                                <svg width="16" height="16" viewBox="0 0 24 24">
                                                    <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                                                </svg>
                                            </div>
                                        </a>
                                    </li>
                                    <?php 
                                            endif;
                                        endif;
                                    endforeach; 
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<script>
jQuery(document).ready(function($) {
    // Initialize Swiper for testimonials
    if ($('.testimonials-slider').length > 0) {
        var testimonialSwiper = new Swiper('.testimonials-slider', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                }
            }
        });
    }
    
    // FAQ Accordion
    $('.faq-question').on('click', function() {
        var $item = $(this).parent();
        
        if ($item.hasClass('active')) {
            $item.removeClass('active');
            $item.find('.faq-answer').slideUp();
        } else {
            $('.faq-item').removeClass('active');
            $('.faq-answer').slideUp();
            
            $item.addClass('active');
            $item.find('.faq-answer').slideDown();
        }
    });
    
    // Create water particles effect
    function createWaterParticles(containerId, count) {
        var container = document.getElementById(containerId);
        if (!container) return;
        
        for (var i = 0; i < count; i++) {
            var particle = document.createElement('div');
            particle.className = 'water-particle';
            particle.style.width = Math.random() * 10 + 5 + 'px';
            particle.style.height = particle.style.width;
            particle.style.left = Math.random() * 100 + '%';
            particle.style.bottom = '0';
            particle.style.opacity = Math.random() * 0.5 + 0.1;
            container.appendChild(particle);
            
            animateParticle(particle);
        }
    }
    
    function animateParticle(particle) {
        setTimeout(function() {
            particle.style.setProperty('--move-x', (Math.random() * 100 - 50) + 'px');
            particle.classList.add('particle-animate');
            
            setTimeout(function() {
                particle.style.opacity = '0';
                
                setTimeout(function() {
                    if (particle.parentElement) {
                        particle.classList.remove('particle-animate');
                        particle.style.bottom = '0';
                        particle.style.left = Math.random() * 100 + '%';
                        particle.style.opacity = Math.random() * 0.5 + 0.1;
                        animateParticle(particle);
                    }
                }, 100);
            }, 8000);
        }, Math.random() * 2000);
    }
    
    // Initialize water particles
    createWaterParticles('timelineWaterEffect', 20);
});
</script>

<?php
get_footer();
?>
