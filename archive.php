<?php
/**
 * The archive template file.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

get_header();

// Lấy thông tin archive hiện tại
$archive_title       = '';
$archive_description = '';

if ( is_category() ) {
    $archive_title       = single_cat_title( '', false );
    $archive_description = category_description();
    } elseif ( is_tag() ) {
    $archive_title       = single_tag_title( '', false );
    $archive_description = tag_description();
    } elseif ( is_author() ) {
    $archive_title       = get_the_author();
    $archive_description = get_the_author_meta( 'description' );
    } elseif ( is_date() ) {
    if ( is_day() ) {
        $archive_title = sprintf( __( 'Lưu trữ ngày: %s', 'flatsome' ), get_the_date() );
        } elseif ( is_month() ) {
        $archive_title = sprintf( __( 'Lưu trữ tháng: %s', 'flatsome' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'flatsome' ) ) );
        } elseif ( is_year() ) {
        $archive_title = sprintf( __( 'Lưu trữ năm: %s', 'flatsome' ), get_the_date( _x( 'Y', 'yearly archives date format', 'flatsome' ) ) );
        } else {
        $archive_title = __( 'Lưu trữ', 'flatsome' );
        }
    } else {
    $archive_title = __( 'Lưu trữ', 'flatsome' );
    }

// Get featured posts (2 latest posts or most viewed if you have a view counter plugin)
$featured_posts = new WP_Query(array(
    'posts_per_page' => 2,
    'post_type' => 'post',
    'ignore_sticky_posts' => 1,
    // If you have a popular posts plugin, you can use meta_key for sorting by views
    // 'meta_key' => 'post_views_count',
    // 'orderby' => 'meta_value_num',
    'orderby' => 'date',
    'order' => 'DESC'
));
?>

<div id="content" class="blog-archive">
    <!-- Banner Section -->
    <section class="archive-banner">
        <div class="container">
            <div class="row">
                <div class="col large-12">
                    <?php nts_the_breadcrumb(); ?>
                    <h1 class="archive-title"><?php echo esc_html( $archive_title ); ?></h1>
                    <?php if ( !empty($archive_description) ) : ?>
                        <div class="archive-description">
                            <?php echo wp_kses_post( $archive_description ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="wave-separator">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,32L80,42.7C160,53,320,75,480,74.7C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,100L1360,100C1280,100,1120,100,960,100C800,100,640,100,480,100C320,100,160,100,80,100L0,100Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- Featured Posts Section -->
    <?php if($featured_posts->have_posts()): ?>
    <section class="featured-posts-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php _e('Bài Viết Nổi Bật', 'flatsome'); ?></h2>
            </div>
            <div class="row">
                <?php while($featured_posts->have_posts()): $featured_posts->the_post(); ?>
                <div class="col large-6 medium-6 small-12">
                    <article id="featured-post-<?php the_ID(); ?>" <?php post_class('featured-post-item'); ?>>
                        <div class="post-inner">
                            <?php if(has_post_thumbnail()): ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large', array('class' => 'post-image')); ?>
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
                                    <?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?>
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
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Main Content Section -->
    <section class="main-content-section">
        <div class="container">
            <div class="row">
                <!-- Main Content Column -->
                <div class="col large-8 medium-8 small-12 main-column">
                    <?php if(have_posts()): ?>
                    <div id="posts-grid" class="posts-grid">
                        <?php while(have_posts()): the_post(); ?>
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
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        <?php
                        echo paginate_links(array(
                            'prev_text' => '<i class="fas fa-chevron-left"></i>',
                            'next_text' => '<i class="fas fa-chevron-right"></i>',
                            'type'      => 'list',
                            'end_size'  => 2,
                            'mid_size'  => 2,
                        ));
                        ?>
                    </div>
                    
                    <!-- Alternative: Load More Button -->
                    <?php
                        global $wp_query;
                        if ($wp_query->max_num_pages > 1) :
                    ?>
                    <button id="load-more" class="load-more-button">
                        <span class="button-text"><?php _e('Tải thêm bài viết', 'flatsome'); ?></span>
                    </button>
                    <script>
                        jQuery(document).ready(function($) {
                            var page = 2;
                            var loading = false;
                            var maxPages = <?php echo $wp_query->max_num_pages; ?>;
                            
                            // Load More button click handler
                            $('#load-more').on('click', function() {
                                if (loading || page > maxPages) return;
                                loading = true;
                                var button = $(this);
                                button.addClass('loading');
                                
                                var data = {
                                    action: 'load_more_posts',
                                    page: page,
                                    query: '<?php echo serialize($wp_query->query_vars); ?>',
                                    nonce: '<?php echo wp_create_nonce('load_more_posts_nonce'); ?>'
                                };
                                
                                $.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
                                    if (response) {
                                        var $newItems = $(response).hide();
                                        $('#posts-grid').append($newItems);
                                        
                                        // Animate new items
                                        $newItems.each(function(index) {
                                            var $item = $(this);
                                            setTimeout(function() {
                                                $item.css({opacity: 0, transform: 'translateY(20px)'})
                                                    .show()
                                                    .animate({opacity: 1, transform: 'translateY(0)'}, 400);
                                            }, index * 100);
                                        });
                                        
                                        page++;
                                        loading = false;
                                        button.removeClass('loading');
                                        
                                        // Hide button if no more pages
                                        if (page > maxPages) {
                                            button.fadeOut(300);
                                        }
                                    }
                                });
                            });
                            
                            // Add animation to pagination links
                            $('.pagination-wrapper a').on('click', function(e) {
                                e.preventDefault();
                                var link = $(this).attr('href');
                                $('#posts-grid').addClass('loading');
                                $('html, body').animate({
                                    scrollTop: $('#posts-grid').offset().top - 100
                                }, 500);
                                
                                setTimeout(function() {
                                    window.location = link;
                                }, 600);
                            });
                            
                            // Add hover effect to post items
                            $('.grid-item').hover(
                                function() {
                                    $(this).siblings().css('opacity', 0.7);
                                },
                                function() {
                                    $(this).siblings().css('opacity', 1);
                                }
                            );
                        });
                    </script>
                    <?php endif; ?>
                    
                    <?php else: ?>
                    <div class="no-posts-found">
                        <div class="no-posts-icon">
                            <i class="fas fa-water"></i>
                        </div>
                        <h2><?php _e('Không tìm thấy bài viết', 'flatsome'); ?></h2>
                        <p><?php _e('Không có bài viết nào phù hợp với tiêu chí tìm kiếm của bạn.', 'flatsome'); ?></p>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="button primary">
                            <i class="fas fa-home"></i> <?php _e('Quay lại trang chủ', 'flatsome'); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar Column -->
                <div class="col large-4 medium-4 small-12 sidebar-column">
                    <div class="sidebar-inner">
                        <!-- Filter Widget -->
                        <div class="sidebar-widget filter-widget">
                            <h3 class="widget-title"><?php _e('Lọc Bài Viết', 'flatsome'); ?></h3>
                            
                            <!-- Categories Filter -->
                            <div class="filter-section filter-categories">
                                <h4 class="filter-title"><?php _e('Danh Mục', 'flatsome'); ?></h4>
                                <ul class="category-list">
                                    <li>
                                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" 
                                           class="category-item <?php echo is_home() ? 'active' : ''; ?>">
                                            <?php _e('Tất cả', 'flatsome'); ?>
                                        </a>
                                    </li>
                                    <?php
                                    $categories = get_categories(array(
                                        'orderby' => 'name',
                                        'order'   => 'ASC',
                                        'parent'  => 0
                                    ));
                                    
                                    foreach($categories as $category) {
                                        $active_class = is_category($category->term_id) ? 'active' : '';
                                        echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-item ' . $active_class . '">' . esc_html($category->name) . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            
                            <!-- Date Filter -->
                            <div class="filter-section filter-date">
                                <h4 class="filter-title"><?php _e('Thời Gian', 'flatsome'); ?></h4>
                                <ul class="date-list">
                                    <?php
                                    // Get archives by month with count
                                    $archives = wp_get_archives(array(
                                        'type' => 'monthly',
                                        'limit' => 6,
                                        'echo' => 0
                                    ));
                                    
                                    // Display archives
                                    echo $archives;
                                    ?>
                                </ul>
                            </div>
                            
                            <!-- Search Box -->
                            <div class="filter-section filter-search">
                                <h4 class="filter-title"><?php _e('Tìm Kiếm', 'flatsome'); ?></h4>
                                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                                    <input type="search" class="search-field" 
                                           placeholder="<?php echo esc_attr_x('Tìm kiếm...', 'placeholder', 'flatsome'); ?>" 
                                           value="<?php echo get_search_query(); ?>" name="s" />
                                    <button type="submit" class="search-submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Recent Posts Widget -->
                        <div class="sidebar-widget recent-posts-widget">
                            <h3 class="widget-title"><?php _e('Bài Viết Gần Đây', 'flatsome'); ?></h3>
                            <ul class="recent-posts-list">
                                <?php
                                $recent_posts = new WP_Query(array(
                                    'posts_per_page' => 5,
                                    'post_type' => 'post',
                                    'ignore_sticky_posts' => 1
                                ));
                                
                                if($recent_posts->have_posts()):
                                    while($recent_posts->have_posts()):
                                        $recent_posts->the_post();
                                ?>
                                <li class="recent-post-item">
                                    <?php if(has_post_thumbnail()): ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('thumbnail', array('class' => 'post-image')); ?>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                    <div class="post-info">
                                        <h4 class="post-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                        <div class="post-meta">
                                            <span class="post-date">
                                                <i class="far fa-calendar-alt"></i> <?php echo get_the_date(); ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <?php
                                    endwhile;
                                    wp_reset_postdata();
                                endif;
                                ?>
                            </ul>
                        </div>
                        
                        <!-- Tags Widget -->
                        <div class="sidebar-widget tags-widget">
                            <h3 class="widget-title"><?php _e('Thẻ Phổ Biến', 'flatsome'); ?></h3>
                            <div class="tagcloud">
                                <?php
                                $tags = get_tags(array(
                                    'number' => 20,
                                    'orderby' => 'count',
                                    'order' => 'DESC'
                                ));
                                
                                if($tags) {
                                    foreach($tags as $tag) {
                                        echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="tag-link">' . esc_html($tag->name) . '</a>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="row">
                <div class="col large-6 medium-6 small-12">
                    <div class="newsletter-content">
                        <h2><?php _e('Đăng ký nhận tin', 'flatsome'); ?></h2>
                        <p><?php _e('Đăng ký để nhận những thông tin mới nhất về công nghệ xử lý nước và các giải pháp tiên tiến.', 'flatsome'); ?>
                        </p>
                    </div>
                </div>
                <div class="col large-6 medium-6 small-12">
                    <div class="newsletter-form">
                        <form action="#" method="post">
                            <div class="form-group">
                                <input type="email" name="email"
                                    placeholder="<?php _e('Nhập email của bạn', 'flatsome'); ?>" required>
                                <button type="submit" class="submit-button">
                                    <?php _e('Đăng ký', 'flatsome'); ?> <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="wave-separator bottom">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,42.7C1120,32,1280,32,1360,32L1440,32L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z">
                </path>
            </svg>
        </div>
    </section>
</div>

<?php get_footer(); ?>