<?php
/**
 * The modern single post template for water treatment company.
 *
 * @package NTSE
 */

get_header();
?>

<div id="content" class="blog-single water-treatment-single">
    <?php include_once(get_stylesheet_directory() . '/assets/svg/water-elements.svg'); ?>
    
    <div class="post-hero" data-animate="fadeIn">
        <div class="water-effect-overlay">
            <div class="water-ripples"></div>
            <div class="floating-bubbles">
                <div class="bubble bubble-1"></div>
                <div class="bubble bubble-2"></div>
                <div class="bubble bubble-3"></div>
                <div class="bubble bubble-4"></div>
                <div class="bubble bubble-5"></div>
            </div>
            <svg class="wave-bottom" viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path fill="var(--white)" d="M0,32L48,37.3C96,43,192,53,288,58.7C384,64,480,64,576,74.7C672,85,768,107,864,112C960,117,1056,107,1152,96C1248,85,1344,75,1392,69.3L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
            </svg>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col large-7 medium-12 small-12">
                    <div class="breadcrumb-container">
                        <?php
                        nts_the_breadcrumb([
                            'show_post_title' => false
                        ]);
                        ?>
                    </div>
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    
                    <div class="post-meta">
                        <div class="post-date">
                            <svg class="meta-icon" width="16" height="16">
                                <use xlink:href="#calendar-icon"></use>
                            </svg>
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </div>
                        
                        <div class="post-author">
                            <svg class="meta-icon" width="16" height="16">
                                <use xlink:href="#user-icon"></use>
                            </svg>
                            <?php the_author(); ?>
                        </div>
                        
                        <?php if (has_category()): ?>
                        <div class="post-categories">
                            <svg class="meta-icon" width="16" height="16">
                                <use xlink:href="#folder-icon"></use>
                            </svg>
                            <?php the_category(', '); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col large-5 medium-12 small-12">
                    <div class="featured-image-container">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="featured-image water-effect">
                                <?php the_post_thumbnail('full', ['class' => 'img-fluid']); ?>
                                <div class="image-overlay"></div>
                                <div class="water-drop-effect"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="post-content-section">
        <div class="container">
            <div class="row">
                <div class="col large-8 medium-12 small-12">
                    <div class="post-content water-card">
                        <div class="droplet-decoration droplet-top-right">
                            <svg width="80" height="80" viewBox="0 0 24 24" opacity="0.07">
                                <use xlink:href="#water-drop"></use>
                            </svg>
                        </div>
                        
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <?php while (have_posts()) : the_post(); ?>
                                <div class="entry-content">
                                    <?php the_content(); ?>
                                </div>
                            <?php endwhile; ?>
                            
                            <div class="post-tags">
                                <?php the_tags('<span class="tag-label">Tags:</span> ', ', '); ?>
                            </div>
                        </article>
                        
                        <div class="droplet-decoration droplet-bottom-left">
                            <svg width="60" height="60" viewBox="0 0 24 24" opacity="0.04">
                                <use xlink:href="#water-drop"></use>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="post-navigation water-card">
                        <h3 class="navigation-title"><?php esc_html_e('Bài viết liên quan', 'ntse'); ?></h3>
                        <div class="related-posts">
                            <?php
                            $related = get_posts([
                                'category__in' => wp_get_post_categories(get_the_ID()),
                                'numberposts' => 3,
                                'post__not_in' => [get_the_ID()]
                            ]);
                            
                            if ($related):
                                echo '<div class="row">';
                                foreach ($related as $post):
                                    setup_postdata($post);
                            ?>
                                <div class="col large-4 medium-4 small-12">
                                    <a href="<?php the_permalink(); ?>" class="related-post-item water-effect">
                                        <?php if (has_post_thumbnail()): ?>
                                            <div class="related-thumb">
                                                <?php the_post_thumbnail('medium'); ?>
                                                <div class="ripple-effect"></div>
                                            </div>
                                        <?php endif; ?>
                                        <h4><?php the_title(); ?></h4>
                                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                                    </a>
                                </div>
                            <?php
                                endforeach;
                                echo '</div>';
                                wp_reset_postdata();
                            else:
                            ?>
                                <p><?php esc_html_e('Không có bài viết liên quan.', 'ntse'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if (comments_open() || get_comments_number()): ?>
                    <div class="comments-section water-card">
                        <div class="wave-decoration">
                            <svg class="wave-top" viewBox="0 0 1440 120" preserveAspectRatio="none">
                                <path fill="rgba(var(--primary-rgb), 0.03)" d="M0,64L48,80C96,96,192,128,288,128C384,128,480,96,576,85.3C672,75,768,85,864,96C960,107,1056,117,1152,112C1248,107,1344,85,1392,74.7L1440,64L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
                            </svg>
                        </div>
                        <?php comments_template(); ?>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="col large-4 medium-12 small-12">
                    <div class="sidebar">
                        <div class="sidebar-widget water-card">
                            <h3 class="widget-title"><?php esc_html_e('Tìm kiếm', 'ntse'); ?></h3>
                            <div class="search-form-container">
                                <form role="search" method="get" class="water-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                                    <div class="search-input-wrapper">
                                        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Tìm kiếm...', 'placeholder', 'ntse'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                                        <button type="submit" class="search-submit">
                                            <svg class="search-icon" width="16" height="16">
                                                <use xlink:href="#search-icon"></use>
                                            </svg>
                                        </button>
                                        <div class="search-ripple"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="sidebar-widget water-card">
                            <h3 class="widget-title"><?php esc_html_e('Danh mục', 'ntse'); ?></h3>
                            <ul class="category-list">
                                <?php wp_list_categories(['title_li' => '', 'show_count' => true]); ?>
                            </ul>
                        </div>
                        
                        <div class="sidebar-widget water-card">
                            <h3 class="widget-title"><?php esc_html_e('Bài viết phổ biến', 'ntse'); ?></h3>
                            <div class="popular-posts">
                                <?php
                                $popular_posts = new WP_Query([
                                    'posts_per_page' => 5,
                                    'meta_key' => 'post_views_count',
                                    'orderby' => 'meta_value_num',
                                    'order' => 'DESC'
                                ]);
                                
                                while ($popular_posts->have_posts()):
                                    $popular_posts->the_post();
                                ?>
                                <a href="<?php the_permalink(); ?>" class="popular-post-item">
                                    <?php if (has_post_thumbnail()): ?>
                                    <div class="post-thumb">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                        <div class="thumb-overlay"></div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="post-info">
                                        <h4><?php the_title(); ?></h4>
                                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                                    </div>
                                </a>
                                <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                        
                        <div class="sidebar-widget water-card contact-widget">
                            <h3 class="widget-title"><?php esc_html_e('Liên hệ tư vấn', 'ntse'); ?></h3>
                            <div class="contact-info">
                                <div class="water-drop-animation">
                                    <svg width="80" height="80" class="water-drop-large">
                                        <use xlink:href="#water-drop"></use>
                                    </svg>
                                </div>
                                <p><?php esc_html_e('Bạn cần tư vấn về giải pháp xử lý nước? Hãy liên hệ với chúng tôi ngay!', 'ntse'); ?></p>
                                <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="water-button">
                                    <?php esc_html_e('Liên hệ ngay', 'ntse'); ?>
                                    <div class="button-water-effect"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
