<?php
/**
 * Template Name: Single Product Modern
 * Template Post Type: product
 */

get_header(); ?>

<div id="primary" class="content-area product-modern">
    <main id="main" class="site-main" role="main">
        <style>
            /* CSS cho phần giới thiệu sản phẩm */
            .product-introduction {
                padding: 60px 0;
                position: relative;
                overflow: hidden;
                background-color: #f9fcff;
            }

            .introduction-inner {
                display: flex;
                align-items: center;
                gap: 40px;
            }

            .introduction-content {
                flex: 1;
                padding-right: 20px;
            }

            .introduction-title {
                font-size: 2.2em;
                margin-bottom: 20px;
                color: var(--primary);
                position: relative;
                padding-bottom: 15px;
            }

            .introduction-title:after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 80px;
                height: 3px;
                background: var(--primary);
                border-radius: 3px;
            }

            .introduction-text {
                font-size: 1.1em;
                line-height: 1.6;
                color: #444;
                margin-bottom: 25px;
            }

            .introduction-text p {
                margin-bottom: 15px;
            }

            .introduction-button {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background-color: var(--primary);
                color: white;
                padding: 12px 24px;
                border-radius: 6px;
                font-weight: 500;
                transition: all 0.3s ease;
                text-decoration: none;
                box-shadow: 0 4px 10px rgba(0, 120, 200, 0.2);
            }

            .introduction-button:hover {
                background-color: var(--primary-dark);
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(0, 120, 200, 0.3);
                color: white;
            }

            .introduction-button svg {
                width: 18px;
                height: 18px;
                transition: transform 0.3s ease;
            }

            .introduction-button:hover svg {
                transform: translateX(4px);
            }

            .introduction-image {
                flex: 1;
                position: relative;
                z-index: 1;
            }

            .introduction-image img {
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                transition: transform 0.5s ease;
                max-width: 100%;
                height: auto;
            }

            .introduction-image:hover img {
                transform: scale(1.02);
            }

            .image-decoration {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 15px;
                left: 15px;
                border-radius: 10px;
                background: rgba(var(--primary-rgb), 0.1);
                z-index: -1;
            }

            @media (max-width: 768px) {
                .introduction-inner {
                    flex-direction: column;
                    gap: 30px;
                }

                .introduction-content {
                    padding-right: 0;
                }

                .introduction-title {
                    font-size: 1.8em;
                }

                .introduction-image {
                    width: 100%;
                }
            }
        </style>

        <?php while (have_posts()) : the_post(); ?>

            <?php
            // Lấy dữ liệu meta
            $product_type = get_post_meta(get_the_ID(), '_product_type', true);
            $hero_image_id = get_post_meta(get_the_ID(), '_hero_image_id', true);
            $short_description = get_post_meta(get_the_ID(), '_short_description', true);
            $product_overview = get_post_meta(get_the_ID(), '_product_overview', true);
            $product_purpose = get_post_meta(get_the_ID(), '_product_purpose', true);
            $target_customers = get_post_meta(get_the_ID(), '_target_customers', true);
            $key_benefits = get_post_meta(get_the_ID(), '_key_benefits', true);
            $product_materials = get_post_meta(get_the_ID(), '_product_materials', true);
            $production_technology = get_post_meta(get_the_ID(), '_production_technology', true);
            $product_applications = get_post_meta(get_the_ID(), '_product_applications', true);
            $product_certificates = get_post_meta(get_the_ID(), '_product_certificates', true);
            $product_reviews = get_post_meta(get_the_ID(), '_product_reviews', true);
            $product_faqs = get_post_meta(get_the_ID(), '_product_faqs', true);
            ?>

            <!-- 1. Hero Banner Section -->
            <section class="product-hero">
                <div class="water-bg"></div>

                <div class="water-droplets-container">
                    <div class="water-droplet water-droplet-1 droplet-animate"></div>
                    <div class="water-droplet water-droplet-2 droplet-animate"></div>
                    <div class="water-droplet water-droplet-3 droplet-animate"></div>
                </div>

                <div class="water-container product-hero-inner">
                    <div class="product-hero-content">
                        <?php if (!empty($product_type)) : ?>
                            <div class="product-type">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>
                                <?php echo esc_html($product_type); ?>
                            </div>
                        <?php endif; ?>

                        <h1 class="product-title"><?php the_title(); ?></h1>

                        <?php if (!empty($short_description)) : ?>
                            <div class="product-short-desc"><?php echo esc_html($short_description); ?></div>
                        <?php endif; ?>

                        <a href="#contact-form" class="product-cta-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            <?php _e('Nhận tư vấn', 'flatsome'); ?>
                        </a>
                    </div>

                    <div class="product-hero-image">
                        <?php
                        if (!empty($hero_image_id)) {
                            echo wp_get_attachment_image($hero_image_id, 'large');
                        } elseif (has_post_thumbnail()) {
                            the_post_thumbnail('large');
                        }
                        ?>
                    </div>
                </div>
            </section>

            <div class="wave-divider"></div>

            <?php
            // Lấy dữ liệu phần giới thiệu
            $introduction_title = get_post_meta(get_the_ID(), '_introduction_title', true);
            $introduction_content = get_post_meta(get_the_ID(), '_introduction_content', true);
            $introduction_image_id = get_post_meta(get_the_ID(), '_introduction_image_id', true);
            $introduction_button_text = get_post_meta(get_the_ID(), '_introduction_button_text', true);
            $introduction_button_url = get_post_meta(get_the_ID(), '_introduction_button_url', true);

            // Hiển thị phần giới thiệu nếu có dữ liệu
            if (!empty($introduction_title) || !empty($introduction_content)) :
            ?>
            <!-- Phần giới thiệu sản phẩm -->
            <section class="product-introduction">
                <div class="water-container">
                    <div class="introduction-inner">
                        <div class="introduction-content">
                            <?php if (!empty($introduction_title)) : ?>
                                <h2 class="introduction-title"><?php echo esc_html($introduction_title); ?></h2>
                            <?php endif; ?>

                            <?php if (!empty($introduction_content)) : ?>
                                <div class="introduction-text">
                                    <?php echo wpautop($introduction_content); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($introduction_button_text) && !empty($introduction_button_url)) : ?>
                                <a href="<?php echo esc_url($introduction_button_url); ?>" class="introduction-button">
                                    <?php echo esc_html($introduction_button_text); ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </a>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($introduction_image_id)) : ?>
                            <div class="introduction-image">
                                <?php echo wp_get_attachment_image($introduction_image_id, 'large'); ?>
                                <div class="image-decoration"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <div class="wave-divider-top"></div>
            <?php endif; ?>

            <!-- 2. Tổng quan sản phẩm -->
            <section class="product-section">
                <div class="water-container product-section-inner">
                    <div class="section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    </div>
                    <h2 class="section-title"><span><?php _e('Tổng quan sản phẩm', 'flatsome'); ?></span></h2>

                    <div class="product-overview">
                        <div class="overview-main">
                            <?php if (!empty($product_overview)) : ?>
                                <div class="overview-main-content">
                                    <h3>Giới thiệu sản phẩm</h3>
                                    <?php echo wpautop($product_overview); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="overview-sidebar">
                            <?php if (!empty($product_purpose)) : ?>
                                <div class="overview-box">
                                    <div class="overview-box-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    </div>
                                    <h3><?php _e('Mục tiêu sản phẩm', 'flatsome'); ?></h3>
                                    <p><?php echo esc_html($product_purpose); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($target_customers)) : ?>
                                <div class="overview-box">
                                    <div class="overview-box-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    </div>
                                    <h3><?php _e('Khách hàng mục tiêu', 'flatsome'); ?></h3>
                                    <p><?php echo esc_html($target_customers); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($key_benefits)) : ?>
                                <div class="overview-box">
                                    <div class="overview-box-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                    <h3><?php _e('Lợi ích chính', 'flatsome'); ?></h3>
                                    <ul>
                                        <?php
                                        $benefits = explode("\n", $key_benefits);
                                        foreach ($benefits as $benefit) {
                                            $benefit = trim($benefit);
                                            if (!empty($benefit)) {
                                                echo '<li>' . esc_html($benefit) . '</li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>

            <div class="wave-divider-top"></div>

            <!-- 3. Công nghệ vật chất -->
            <?php if (!empty($product_materials) || !empty($production_technology)) : ?>
            <section class="product-section">
                <div class="water-bg"></div>
                <div class="water-container product-section-inner">
                    <div class="section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                    </div>
                    <h2 class="section-title"><span><?php _e('Công nghệ vật chất', 'flatsome'); ?></span></h2>

                    <div class="product-technology">
                        <?php if (!empty($product_materials)) : ?>
                        <div class="technology-item">
                            <div class="technology-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                            <h3><?php _e('Công nghệ vật liệu', 'flatsome'); ?></h3>
                            <div class="technology-content">
                                <?php echo wpautop($product_materials); ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($production_technology)) : ?>
                        <div class="technology-item">
                            <div class="technology-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                            </div>
                            <h3><?php _e('Công nghệ sản xuất', 'flatsome'); ?></h3>
                            <div class="technology-content">
                                <?php echo wpautop($production_technology); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <div class="wave-divider"></div>

            <!-- 4. Ứng dụng nổi bật -->
            <?php if (!empty($product_applications) || !empty($product_certificates)) : ?>
            <section class="product-section">
                <div class="water-container product-section-inner">
                    <div class="section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="12" x2="2" y2="12"></line><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path><line x1="6" y1="16" x2="6.01" y2="16"></line><line x1="10" y1="16" x2="10.01" y2="16"></line></svg>
                    </div>
                    <h2 class="section-title"><span><?php _e('Ứng dụng nổi bật', 'flatsome'); ?></span></h2>

                    <?php if (!empty($product_applications)) : ?>
                        <div class="applications-content">
                            <?php echo wpautop($product_applications); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product_certificates)) : ?>
                        <div class="certificates-list">
                            <?php
                            $certificates = explode("\n", $product_certificates);
                            foreach ($certificates as $certificate) {
                                $certificate = trim($certificate);
                                if (!empty($certificate)) {
                                    echo '<div class="certificate-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                                        ' . esc_html($certificate) . '</div>';
                                }
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
            <?php endif; ?>

            <div class="wave-divider-top"></div>

            <!-- 5. Đánh giá khách hàng -->
            <?php if (!empty($product_reviews) && is_array($product_reviews)) : ?>
            <section class="product-section reviews-section">
                <div class="water-bg"></div>
                <div class="water-container product-section-inner">
                    <div class="section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    </div>
                    <h2 class="section-title"><span><?php _e('Đánh giá khách hàng', 'flatsome'); ?></span></h2>

                    <div class="product-reviews-slider">
                        <div class="product-reviews">
                            <?php foreach ($product_reviews as $review) : ?>
                                <div class="review-item">
                                    <div class="review-content">
                                        <?php echo esc_html($review['content']); ?>
                                    </div>

                                    <div class="reviewer-info">
                                        <div class="reviewer-avatar">
                                            <?php echo substr(esc_html($review['name']), 0, 1); ?>
                                        </div>
                                        <div class="reviewer-details">
                                            <div class="reviewer-name"><?php echo esc_html($review['name']); ?></div>
                                            <?php if (!empty($review['position'])) : ?>
                                                <div class="reviewer-position"><?php echo esc_html($review['position']); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if (!empty($review['rating'])) : ?>
                                        <div class="review-rating">
                                            <div class="rating-stars">
                                                <?php
                                                $rating = intval($review['rating']);
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $rating) {
                                                        echo '★';
                                                    } else {
                                                        echo '☆';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <div class="wave-divider"></div>

            <!-- 6. FAQ -->
            <?php if (!empty($product_faqs) && is_array($product_faqs)) : ?>
            <section class="product-section">
                <div class="water-container product-section-inner">
                    <div class="section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    </div>
                    <h2 class="section-title"><span><?php _e('Câu hỏi thường gặp', 'flatsome'); ?></span></h2>

                    <div class="product-faq">
                        <?php foreach ($product_faqs as $index => $faq) : ?>
                            <div class="faq-item">
                                <div class="faq-question" data-index="<?php echo $index; ?>">
                                    <?php echo esc_html($faq['question']); ?>
                                </div>
                                <div class="faq-answer" id="faq-answer-<?php echo $index; ?>">
                                    <p><?php echo nl2br(esc_html($faq['answer'])); ?></p>

                                    <?php if (!empty($faq['link'])) : ?>
                                        <p><a href="<?php echo esc_url($faq['link']); ?>" target="_blank" class="faq-more-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                            <?php _e('Xem thêm chi tiết', 'flatsome'); ?>
                                        </a></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <div class="wave-divider-top"></div>

            <!-- 7. CTA -->
            <section class="product-section product-cta-section">
                <div class="water-container product-section-inner">
                    <div class="section-icon cta-section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </div>
                    <h2 class="section-title cta-title"><span><?php _e('Liên hệ tư vấn ngay', 'flatsome'); ?></span></h2>

                    <div class="contact-info">
                        <div class="contact-phone">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            Hotline: <a href="tel:+84123456789">0123 456 789</a>
                        </div>
                    </div>

                    <div class="contact-form" id="contact-form">
                        <?php
                        // Sử dụng Contact Form 7 nếu có
                        if (shortcode_exists('contact-form-7')) {
                            echo do_shortcode('[contact-form-7 id="FORM_ID" title="Form tư vấn sản phẩm"]');
                        } else {
                        ?>
                            <form method="post" action="" class="modern-form">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="name">Họ và tên <span class="required">*</span></label>
                                        <input type="text" name="name" id="name" placeholder="Nhập họ và tên" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại <span class="required">*</span></label>
                                        <input type="tel" name="phone" id="phone" placeholder="Nhập số điện thoại" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="required">*</span></label>
                                    <input type="email" name="email" id="email" placeholder="Nhập email" required>
                                </div>

                                <div class="form-group">
                                    <label for="message">Nội dung cần tư vấn <span class="required">*</span></label>
                                    <textarea name="message" id="message" rows="4" placeholder="Nhập nội dung" required></textarea>
                                </div>

                                <input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>">
                                <input type="hidden" name="product_name" value="<?php echo esc_attr(get_the_title()); ?>">

                                <div class="form-submit">
                                    <button type="submit" class="submit-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                        Gửi yêu cầu tư vấn
                                    </button>
                                </div>
                            </form>
                        <?php } ?>
                    </div>

                    <div class="response-time">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <?php _e('Chúng tôi sẽ phản hồi trong vòng 24 giờ làm việc', 'flatsome'); ?>
                    </div>
                </div>
            </section>

            <div class="wave-divider"></div>

            <!-- 8. Nội dung liên quan -->
            <section class="product-section">
                <div class="water-container product-section-inner">
                    <div class="section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    </div>
                    <h2 class="section-title"><span><?php _e('Nội dung liên quan', 'flatsome'); ?></span></h2>

                    <div class="related-content">
                        <?php
                        // Lấy sản phẩm liên quan
                        $related_args = array(
                            'post_type' => 'product',
                            'post_status' => 'publish',
                            'posts_per_page' => 3,
                            'post__not_in' => array(get_the_ID()),
                            'orderby' => 'rand',
                        );

                        $related_query = new WP_Query($related_args);

                        if ($related_query->have_posts()) {
                            while ($related_query->have_posts()) {
                                $related_query->the_post();
                                ?>
                                <div class="related-item">
                                    <div class="related-image">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('medium'); ?>
                                        <?php else : ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/image/placeholder.jpg" alt="<?php the_title_attribute(); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="related-content-inner">
                                        <h3 class="related-title"><?php the_title(); ?></h3>
                                        <div class="related-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></div>
                                        <a href="<?php the_permalink(); ?>" class="related-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                            <?php _e('Xem chi tiết', 'flatsome'); ?>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            wp_reset_postdata();
                        }
                        ?>
                    </div>
                </div>
            </section>

        <?php endwhile; ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>