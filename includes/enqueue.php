<?php
/**
 * Enqueue Scripts and Styles
 * Quản lý việc đăng ký và load các assets: CSS, JS, Fonts...
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enqueue scripts and styles for the child theme
 */
function nts_enqueue_child_theme_scripts() {
    // Đăng ký Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css',
        array(),
        '6.4.2'
    );

    // Đăng ký và load CSS
    wp_enqueue_style(
        'nts',
        get_stylesheet_directory_uri() . '/assets/css/main.css',
        [],
        filemtime(get_stylesheet_directory() . '/assets/css/main.css')
    );

    // Đăng ký và load Partners JavaScript
    wp_enqueue_script(
        'nts-partners',
        get_stylesheet_directory_uri() . '/assets/js/partners.js',
        ['jquery'],
        filemtime(get_stylesheet_directory() . '/assets/js/partners.js'),
        true
    );

    // Đăng ký và load Main JavaScript
    wp_enqueue_script(
        'nts',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        filemtime(get_stylesheet_directory() . '/assets/js/main.js'),
        true
    );

    // Localize script để dùng biến PHP trong JS
    wp_localize_script(
        'nts',
        'nts_ajax_object',
        array(
            'ajax_url'     => admin_url('admin-ajax.php'),
            'nonce'        => wp_create_nonce('nts_nonce'),
            'text_sending' => esc_js(__('Đang gửi...', 'flatsome')),
            'text_submit'  => esc_js(__('Gửi liên hệ', 'flatsome')),
            'text_error'   => esc_js(__('Có lỗi xảy ra, vui lòng thử lại sau!', 'flatsome')),
        )
    );
}
add_action('wp_enqueue_scripts', 'nts_enqueue_child_theme_scripts', 15);

/**
 * Enqueue Swiper Library and custom Swiper scripts
 */
function nts_enqueue_swiper_assets() {
    // Kiểm tra nếu Swiper chưa được load bởi theme/plugin khác
    if (!wp_script_is('swiper-js', 'registered')) {
        // Swiper CSS
        wp_enqueue_style(
            'swiper-css',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            array(),
            '11.0.0'
        );

        // Swiper JS
        wp_enqueue_script(
            'swiper-js',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            array(),
            '11.0.0',
            true
        );
    }

    // File JS tùy chỉnh cho Swiper
    wp_enqueue_script(
        'nts-swiper-custom',
        get_stylesheet_directory_uri() . '/assets/js/nts-swiper-init.js',
        array('swiper-js'),
        filemtime(get_stylesheet_directory() . '/assets/js/nts-swiper-init.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'nts_enqueue_swiper_assets');

/**
 * Enqueue stylesheets for single posts
 * Load SCSS styles only on single post pages
 */
function nts_enqueue_single_post_styles() {
    // Only load on single post pages
    if (is_single() && !is_singular(['product', 'project', 'service'])) {
        // Check if the CSS file exists
        $single_post_css_path = get_stylesheet_directory() . '/assets/css/single-post.css';
        $single_post_css_uri = get_stylesheet_directory_uri() . '/assets/css/single-post.css';
        
        // If the CSS file doesn't exist yet, try to generate it from SCSS
        if (!file_exists($single_post_css_path)) {
            // The path to the SCSS file
            $scss_file = get_stylesheet_directory() . '/assets/scss/single-post.scss';
            
            // Check if SCSS exists
            if (file_exists($scss_file)) {
                // Create CSS directory if it doesn't exist
                $css_dir = dirname($single_post_css_path);
                if (!file_exists($css_dir)) {
                    wp_mkdir_p($css_dir);
                }
                
                // Try to use WP SCSS plugin if active
                if (class_exists('WP_SCSS')) {
                    // Plugin will handle conversion
                } else {
                    // Otherwise, just copy the SCSS file as CSS for now
                    // In a real environment, you'd convert SCSS to CSS here
                    copy($scss_file, $single_post_css_path);
                }
            }
        }
        
        // If CSS file exists now, enqueue it
        if (file_exists($single_post_css_path)) {
            wp_enqueue_style(
                'nts-single-post',
                $single_post_css_uri,
                ['nts'], // Main stylesheet dependency
                filemtime($single_post_css_path)
            );
        }
        
        // Add single post JavaScript functionality if needed
        wp_enqueue_script(
            'nts-single-post',
            get_stylesheet_directory_uri() . '/assets/js/single-post.js',
            ['jquery'],
            filemtime(get_stylesheet_directory() . '/assets/js/single-post.js'),
            true
        );
        
        // Add water effect animations
        wp_add_inline_script('nts-single-post', '
            jQuery(document).ready(function($) {
                // Water ripple effect on images
                $(".water-effect").on("mouseenter", function() {
                    $(this).find(".ripple-effect").addClass("active");
                }).on("mouseleave", function() {
                    $(this).find(".ripple-effect").removeClass("active");
                });
                
                // Floating bubbles animation
                function animateBubbles() {
                    $(".floating-bubbles .bubble").each(function() {
                        var bubble = $(this);
                        var randomX = Math.random() * 20 - 10;
                        var randomDelay = Math.random() * 2;
                        
                        bubble.css({
                            "animation-delay": randomDelay + "s",
                            "transform": "translateX(" + randomX + "px)"
                        });
                    });
                }
                
                // Initialize animations
                animateBubbles();
                
                // Water button effect
                $(".water-button").on("mouseenter", function() {
                    $(this).find(".button-water-effect").addClass("active");
                }).on("mouseleave", function() {
                    $(this).find(".button-water-effect").removeClass("active");
                });
            });
        ');
    }
}
add_action('wp_enqueue_scripts', 'nts_enqueue_single_post_styles', 20);

/**
 * Handle Load More Posts Ajax Request
 */
function nts_load_more_posts_ajax_handler() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_posts_nonce')) {
        die('Invalid nonce');
    }
    
    // Get query parameters
    $args = unserialize(stripslashes($_POST['query']));
    $args['paged'] = $_POST['page'];
    $args['post_status'] = 'publish';
    
    // Start the query
    $ajax_query = new WP_Query($args);
    
    if ($ajax_query->have_posts()) {
        while ($ajax_query->have_posts()) {
            $ajax_query->the_post();
            ?>
            <div class="grid-item">
                <article id="post-<?php the_ID(); ?>" <?php post_class('archive-post-item'); ?>>
                    <div class="post-inner">
                        <?php if(has_post_thumbnail()): ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium_large', array('class' => 'post-image')); ?>
                            </a>
                            <div class="post-date">
                                <span class="day"><?php echo get_the_date('d'); ?></span>
                                <span class="month"><?php echo get_the_date('M'); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <div class="post-meta">
                                <?php
                                $categories = get_the_category();
                                if(!empty($categories)) {
                                    echo '<div class="post-categories">';
                                    foreach($categories as $category) {
                                        echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="post-category">' . esc_html($category->name) . '</a>';
                                    }
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            
                            <h2 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="post-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                            </div>
                            
                            <div class="post-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more-link">
                                    <?php _e('Xem thêm', 'flatsome'); ?> <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <?php
        }
    }
    wp_reset_postdata();
    die();
}
add_action('wp_ajax_load_more_posts', 'nts_load_more_posts_ajax_handler');
add_action('wp_ajax_nopriv_load_more_posts', 'nts_load_more_posts_ajax_handler');

/**
 * AJAX handler for loading more posts on the Tin Tức page template
 */
function nts_load_more_page_posts_ajax_handler() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_page_posts_nonce')) {
        wp_die('Security check failed');
    }
    
    // Get pagination parameters with defaults
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : get_option('posts_per_page');
    
    // Query for posts
    $args = array(
        'post_type'         => 'post',
        'posts_per_page'    => $posts_per_page,
        'paged'             => $page,
        'post_status'       => 'publish',
        'ignore_sticky_posts' => 1,
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="grid-item">
                <article id="post-<?php the_ID(); ?>" <?php post_class('archive-post-item'); ?>>
                    <div class="post-inner">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large', array('class' => 'post-image')); ?>
                                </a>
                                <div class="post-date">
                                    <span class="day"><?php echo get_the_date('d'); ?></span>
                                    <span class="month"><?php echo get_the_date('M'); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <div class="post-meta">
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    echo '<div class="post-categories">';
                                    foreach ($categories as $category) {
                                        echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="post-category">' . esc_html($category->name) . '</a>';
                                    }
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            
                            <h2 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="post-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                            </div>
                            
                            <div class="post-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more-link">
                                    <?php _e('Xem thêm', 'ntse'); ?> <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <?php
        }
    }
    
    wp_reset_postdata();
    wp_die();
}

// Register AJAX handlers
add_action('wp_ajax_load_more_page_posts', 'nts_load_more_page_posts_ajax_handler');
add_action('wp_ajax_nopriv_load_more_page_posts', 'nts_load_more_page_posts_ajax_handler'); 