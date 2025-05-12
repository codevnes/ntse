<?php
/**
 * The template for displaying project category taxonomy archives
 */

get_header(); ?>

<?php include_once(get_stylesheet_directory() . '/assets/svg/water-elements.svg'); ?>

<div id="primary" class="content-area project-archive-page project-category-page">
    <main id="main" class="site-main project-archive-container" role="main">
        <!-- Header Section with Simplified Water Effect -->
        <header class="project-archive-header">
            <!-- Static background layer -->
            <div class="header-bg-layer"></div>
            
            <!-- Simple water pattern overlay -->
            <div class="header-pattern-layer">
                <svg width="100%" height="100%" preserveAspectRatio="none">
                    <use xlink:href="#water-pattern-bg"></use>
                </svg>
            </div>
            
            <!-- Limited decorative elements -->
            <div class="header-decoration">
                <div class="header-bubble bubble-1"></div>
                <div class="header-bubble bubble-2"></div>
                <div class="header-bubble bubble-3"></div>
            </div>
            
            <!-- Content container with improved z-index -->
            <div class="container">
                <div class="header-content">
                    <?php
                    $term = get_queried_object();
                    ?>
                    
                    <div class="category-breadcrumb">
                        <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>">Dự án</a>
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                        <span><?php echo esc_html($term->name); ?></span>
                    </div>
                    
                    <h1 class="page-title"><?php echo esc_html($term->name); ?></h1>
                    
                    <?php if (!empty($term->description)) : ?>
                        <p class="page-description"><?php echo esc_html($term->description); ?></p>
                    <?php else : ?>
                        <p class="page-description">Khám phá các dự án <?php echo esc_html(strtolower($term->name)); ?> tiêu biểu của chúng tôi với công nghệ tiên tiến và giải pháp hiệu quả. Mỗi dự án là minh chứng cho cam kết mang đến nguồn nước sạch, an toàn và bền vững.</p>
                    <?php endif; ?>
                    
                    <!-- Category Stats -->
                    <div class="category-stats">
                        <div class="stat-item">
                            <div class="stat-number"><?php echo esc_html($wp_query->found_posts); ?></div>
                            <div class="stat-label">Dự án</div>
                        </div>
                    </div>
                </div>
            </div>
        </header><!-- .page-header -->

        <div class="container">
            <?php if (have_posts()) : ?>
                <!-- Category Filter -->
                <div class="project-category-filter">
                    <div class="filter-title">Danh mục dự án:</div>
                    <div class="filter-items">
                        <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>" class="filter-item">Tất cả</a>
                        
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'project_category',
                            'hide_empty' => true,
                        ));
                        
                        if (!empty($categories) && !is_wp_error($categories)) {
                            foreach ($categories as $category) {
                                $active_class = ($category->term_id === $term->term_id) ? 'active' : '';
                                echo '<a href="' . esc_url(get_term_link($category)) . '" class="filter-item ' . esc_attr($active_class) . '">' . esc_html($category->name) . '</a>';
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="project-archive row">
                    <?php
                    /* Start the Loop */
                    while (have_posts()) :
                        the_post();
                        ?>
                        <div class="col large-4 medium-6 smail-12" data-animate="fadeInUp">
                            <article id="post-<?php the_ID(); ?>" <?php post_class('project-card'); ?>>
                                <div class="project-item-thumbnail">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <?php the_post_thumbnail('medium_large'); // Use an appropriate image size ?>
                                        </a>
                                    <?php else : ?>
                                        <div class="no-thumbnail">
                                            <svg class="water-icon">
                                                <use xlink:href="#water-treatment"></use>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                    <div class="project-item-overlay">
                                        <svg class="hexagon-pattern" width="100%" height="100%">
                                            <use xlink:href="#hexagon-grid"></use>
                                        </svg>
                                    </div>
                                    
                                    <!-- Category Badge -->
                                    <div class="project-category-badge">
                                        <?php echo esc_html($term->name); ?>
                                    </div>
                                </div>
                                <div class="project-item-content">
                                    <h2 class="project-item-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    
                                    <!-- Project Meta -->
                                    <?php
                                    $project_location = get_post_meta(get_the_ID(), 'project_location', true);
                                    $project_time = get_post_meta(get_the_ID(), 'project_time', true);
                                    
                                    if (!empty($project_location) || !empty($project_time)) :
                                    ?>
                                    <div class="project-item-meta">
                                        <?php if (!empty($project_location)) : ?>
                                            <div class="meta-item">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                <span><?php echo esc_html($project_location); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($project_time)) : ?>
                                            <div class="meta-item">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <span><?php echo esc_html($project_time); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>

                                    <div class="project-item-readmore">
                                        <a href="<?php the_permalink(); ?>" class="btn-water-ripple">
                                            <span>Chi tiết</span>
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div><!-- .project-item-content -->
                            </article><!-- #post-<?php the_ID(); ?> -->
                        </div>
                        <?php
                    endwhile;
                    ?>
                </div> <!-- .project-archive-grid -->
                <?php

                // Add pagination with custom wrapper class
                echo '<div class="project-pagination">';
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('‹ Trước', 'textdomain'), // Replace 'textdomain'
                    'next_text' => __('Sau ›', 'textdomain'),    // Replace 'textdomain'
                ));
                echo '</div>';

            else :

                // If no content, include the "No posts found" template.
                // You might need to create or adjust content-none.php in your theme
                get_template_part('template-parts/content', 'none');

            endif;
            ?>

        </div>
    </main><!-- #main -->
</div><!-- #primary -->

<script>
jQuery(document).ready(function($) {
    // Create water particles with reduced frequency and count
    var particleCount = 0;
    var maxParticles = 30; // Limit maximum particles
    
    function createWaterParticle() {
        // Limit total number of particles
        if (particleCount >= maxParticles) {
            return;
        }
        
        var container = $('.particle-container');
        var containerWidth = container.width();
        var containerHeight = container.height();
        
        // Random size (smaller)
        var size = Math.floor(Math.random() * 4) + 2; // 2px to 6px
        
        // Random position
        var posX = Math.floor(Math.random() * containerWidth);
        var posY = Math.floor(Math.random() * (containerHeight / 3)) + (containerHeight * 2/3);
        
        // Create particle element
        var particle = $('<div class="water-particle"></div>');
        particle.css({
            width: size + 'px',
            height: size + 'px',
            left: posX + 'px',
            top: posY + 'px',
            opacity: Math.random() * 0.4 + 0.1 // Reduced opacity
        });
        
        // Add to container
        container.append(particle);
        particleCount++;
        
        // Add class to activate animation
        particle.addClass('particle-animate');
        
        // Remove particle after animation completes
        setTimeout(function() {
            particle.remove();
            particleCount--;
        }, 6000); // Reduced time
    }
    
    // Create particles less frequently
    setInterval(createWaterParticle, 500); // Changed from 200ms to 500ms
    
    // Hiệu ứng hover cho project card
    $('.project-card').hover(
        function() {
            $(this).find('.project-item-overlay').css('opacity', 1);
        },
        function() {
            $(this).find('.project-item-overlay').css('opacity', 0);
        }
    );

    // Hiệu ứng xuất hiện tuần tự cho các thẻ dự án
    function animateProjectCards() {
        $('.project-card').each(function(index) {
            var card = $(this);
            setTimeout(function() {
                card.addClass('animated-in');
            }, 100 * index); // Reduced delay
        });
    }
    
    // Chạy animation khi trang tải xong
    setTimeout(animateProjectCards, 300); // Reduced delay
    
    // Simplified floating animation
    function floatingAnimation() {
        $('.service-header-content').addClass('float-animation');
    }
    
    // Chạy animation floating
    setTimeout(floatingAnimation, 800); // Reduced delay

    // Hiệu ứng ripple khi click vào nút 
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

    // Simplified 3D hover effect
    $('.project-card').on('mousemove', function(e) {
        const card = $(this);
        const cardRect = card[0].getBoundingClientRect();
        const cardWidth = cardRect.width;
        const cardHeight = cardRect.height;
        
        // Tính toán vị trí tương đối của chuột trên thẻ
        const mouseX = e.clientX - cardRect.left;
        const mouseY = e.clientY - cardRect.top;
        
        // Tính góc xoay (reduced range)
        const rotateY = ((mouseX / cardWidth) - 0.5) * 6; // -3 to 3 degrees
        const rotateX = ((mouseY / cardHeight) - 0.5) * -6; // -3 to 3 degrees
        
        // Áp dụng hiệu ứng with minimal scaling
        card.css('transform', `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.01, 1.01, 1.01)`);
    });
    
    // Reset khi ra khỏi thẻ
    $('.project-card').on('mouseleave', function() {
        $(this).css('transform', 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)');
    });
    
    // Filter hover effect
    $('.filter-item').hover(
        function() {
            $(this).addClass('filter-hover');
        },
        function() {
            $(this).removeClass('filter-hover');
        }
    );
});
</script>

<style>
/* Project Archive Header Styles */
.project-archive-header {
    position: relative;
    padding: 80px 0 60px;
    overflow: hidden;
    margin-bottom: 40px;
}

/* Background layers */
.header-bg-layer {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #0b5394 0%, #0073a8 50%, #00a0c6 100%);
    z-index: 1;
}

.header-pattern-layer {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0.2;
    z-index: 2;
}

/* Header decorations */
.header-decoration {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 3;
    pointer-events: none;
}

.header-bubble {
    position: absolute;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    animation: bubbleFloat 10s infinite ease-in-out;
}

.header-bubble.bubble-1 {
    width: 50px;
    height: 50px;
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.header-bubble.bubble-2 {
    width: 35px;
    height: 35px;
    top: 30%;
    right: 15%;
    animation-delay: 2s;
}

.header-bubble.bubble-3 {
    width: 25px;
    height: 25px;
    bottom: 25%;
    right: 30%;
    animation-delay: 1s;
}

@keyframes bubbleFloat {
    0%, 100% {
        transform: translateY(0) translateX(0);
    }
    25% {
        transform: translateY(-15px) translateX(10px);
    }
    50% {
        transform: translateY(8px) translateX(-8px);
    }
    75% {
        transform: translateY(12px) translateX(5px);
    }
}

/* Header content */
.header-content {
    position: relative;
    z-index: 10;
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
    color: #fff;
}

.category-breadcrumb {
    margin-bottom: 20px;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.category-breadcrumb a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.3s ease;
}

.category-breadcrumb a:hover {
    color: #fff;
}

.category-breadcrumb i {
    color: rgba(255, 255, 255, 0.6);
    font-size: 14px;
}

.page-title {
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #fff;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    position: relative;
    display: inline-block;
}

.page-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 2px;
}

.page-description {
    font-size: 18px;
    line-height: 1.6;
    margin-bottom: 30px;
    color: rgba(255, 255, 255, 0.9);
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.category-stats {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.category-stats .stat-item {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(5px);
    padding: 15px 30px;
    border-radius: 8px;
    text-align: center;
    transition: transform 0.3s ease, background-color 0.3s ease;
}

.category-stats .stat-item:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.15);
}

.category-stats .stat-number {
    font-size: 32px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 5px;
}

.category-stats .stat-label {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
}

/* Responsive styles */
@media (max-width: 768px) {
    .project-archive-header {
        padding: 60px 0 40px;
    }
    
    .page-title {
        font-size: 32px;
    }
    
    .page-description {
        font-size: 16px;
    }
}

@media (max-width: 576px) {
    .project-archive-header {
        padding: 40px 0 30px;
    }
    
    .page-title {
        font-size: 28px;
    }
    
    .category-stats .stat-item {
        padding: 10px 20px;
    }
    
    .category-stats .stat-number {
        font-size: 28px;
    }
}
</style>

<?php
get_footer();
