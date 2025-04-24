<?php
/**
 * Trang hiển thị danh mục sản phẩm
 */

get_header();

// Lấy thông tin danh mục hiện tại
$current_category = get_queried_object();
$category_name = $current_category->name;
$category_description = $current_category->description;
$category_id = $current_category->term_id;
$category_image_id = get_term_meta($category_id, 'category_image', true);
$category_image_url = $category_image_id ? wp_get_attachment_image_url($category_image_id, 'large') : '';

// Lấy thông tin phân trang
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$products_per_page = 9;

// Thiết lập tham số truy vấn
$args = array(
    'post_type' => 'product',
    'posts_per_page' => $products_per_page,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => array(
        array(
            'taxonomy' => 'product_category',
            'field' => 'term_id',
            'terms' => $category_id,
        ),
    ),
);

// Thêm điều kiện tìm kiếm nếu có
if (isset($_GET['s']) && !empty($_GET['s'])) {
    $args['s'] = sanitize_text_field($_GET['s']);
}

// Thực hiện truy vấn
$products_query = new WP_Query($args);

// Lấy tất cả danh mục sản phẩm
$product_categories = get_terms(array(
    'taxonomy' => 'product_category',
    'hide_empty' => true,
));
?>

<div class="product-archive product-category-archive">
    <div class="container">
        <!-- Hero Section -->
        <div class="product-category-hero">
            <div class="category-hero-content">
                <div class="breadcrumb-trail">
                    <a href="<?php echo esc_url(home_url()); ?>">Trang chủ</a>
                    <i class="fas fa-chevron-right"></i>
                    <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>">Sản phẩm</a>
                    <i class="fas fa-chevron-right"></i>
                    <span><?php echo esc_html($category_name); ?></span>
                </div>
                
                <h1 class="category-title"><?php echo esc_html($category_name); ?></h1>
                
                <?php if (!empty($category_description)) : ?>
                    <div class="category-description"><?php echo wp_kses_post($category_description); ?></div>
                <?php endif; ?>
                
                <div class="category-stats">
                    <div class="stat-item">
                        <div class="stat-icon"><i class="fas fa-box-open"></i></div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo esc_html($products_query->found_posts); ?></div>
                            <div class="stat-label">Sản phẩm</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="category-hero-image">
                <?php if (!empty($category_image_url)) : ?>
                    <img src="<?php echo esc_url($category_image_url); ?>" alt="<?php echo esc_attr($category_name); ?>">
                <?php else : ?>
                    <div class="category-placeholder">
                        <i class="fas fa-water"></i>
                    </div>
                <?php endif; ?>
                
                <!-- Water Drops Animation -->
                <div class="water-drops">
                    <?php for ($i = 1; $i <= 8; $i++) : ?>
                        <div class="water-drop drop-<?php echo $i; ?>"></div>
                    <?php endfor; ?>
                </div>
            </div>
            
            <!-- Wave Decoration -->
            <div class="wave-decoration">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <path fill="#ffffff" fill-opacity="1" d="M0,192L48,176C96,160,192,128,288,122.7C384,117,480,139,576,149.3C672,160,768,160,864,138.7C960,117,1056,75,1152,69.3C1248,64,1344,96,1392,112L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                </svg>
            </div>
        </div>

        <!-- Category Navigation -->
        <div class="category-navigation">
            <h3 class="nav-title">Danh mục sản phẩm</h3>
            <div class="category-nav-items">
                <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="nav-item">
                    <i class="fas fa-th-large"></i>
                    <span>Tất cả sản phẩm</span>
                </a>
                
                <?php if (!empty($product_categories) && !is_wp_error($product_categories)) : ?>
                    <?php foreach ($product_categories as $category) : ?>
                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="nav-item <?php echo ($category->term_id === $category_id) ? 'active' : ''; ?>">
                            <i class="fas fa-tag"></i>
                            <span><?php echo esc_html($category->name); ?></span>
                            <span class="count"><?php echo esc_html($category->count); ?></span>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>


        <!-- Products Grid -->
        <div class="product-grid">
            <?php if ($products_query->have_posts()) : ?>
                <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>
                    <?php
                    $product_id = get_the_ID();
                    $product_rating = rand(45, 50) / 10; // Random rating từ 4.5 đến 5.0
                    $product_reviews = rand(10, 50); // Random số lượng đánh giá
                    ?>
                    <div class="product-card animate-on-scroll">
                        <div class="product-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/image/placeholder.png" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                            <div class="product-overlay">
                                <div class="overlay-icons">
                                    <a href="#" class="icon-btn"><i class="fas fa-heart"></i></a>
                                    <a href="<?php the_permalink(); ?>" class="icon-btn"><i class="fas fa-search"></i></a>
                                    <a href="#" class="icon-btn"><i class="fas fa-shopping-cart"></i></a>
                                </div>
                            </div>
                            <div class="water-ripple"></div>
                            <div class="product-badge"><?php echo esc_html($category_name); ?></div>
                        </div>
                        <div class="product-content">
                            <span class="product-category"><?php echo esc_html($category_name); ?></span>
                            <h3 class="product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="product-description"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></div>
                            <div class="product-meta">
                                <div class="product-rating">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <i class="fas fa-star<?php echo ($i <= $product_rating) ? '' : '-o'; ?>"></i>
                                    <?php endfor; ?>
                                    <span>(<?php echo $product_reviews; ?>)</span>
                                </div>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="product-detail-link">Xem chi tiết <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="no-products">
                    <div class="no-products-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3>Không tìm thấy sản phẩm</h3>
                    <p>Không tìm thấy sản phẩm nào trong danh mục này. Vui lòng thử danh mục khác hoặc quay lại sau.</p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="back-to-products">
                        <i class="fas fa-arrow-left"></i> Xem tất cả sản phẩm
                    </a>
                </div>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php
            if ($products_query->max_num_pages > 1) {
                echo paginate_links(array(
                    'base' => get_pagenum_link(1) . '%_%',
                    'format' => 'page/%#%',
                    'current' => $paged,
                    'total' => $products_query->max_num_pages,
                    'prev_text' => '<i class="fas fa-chevron-left"></i>',
                    'next_text' => '<i class="fas fa-chevron-right"></i>',
                    'type' => 'list'
                ));
            }
            ?>
        </div>
        
        <!-- Related Categories -->
        <?php if (count($product_categories) > 1) : ?>
            <div class="related-categories">
                <h3 class="section-title">Danh mục liên quan</h3>
                <div class="categories-grid">
                    <?php foreach ($product_categories as $category) : ?>
                        <?php if ($category->term_id !== $category_id) : ?>
                            <?php 
                            $cat_image_id = get_term_meta($category->term_id, 'category_image', true);
                            $cat_image_url = $cat_image_id ? wp_get_attachment_image_url($cat_image_id, 'medium') : '';
                            ?>
                            <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-card">
                                <div class="category-card-image">
                                    <?php if (!empty($cat_image_url)) : ?>
                                        <img src="<?php echo esc_url($cat_image_url); ?>" alt="<?php echo esc_attr($category->name); ?>">
                                    <?php else : ?>
                                        <div class="category-icon">
                                            <i class="fas fa-water"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="category-card-content">
                                    <h4><?php echo esc_html($category->name); ?></h4>
                                    <span class="category-count"><?php echo esc_html($category->count); ?> sản phẩm</span>
                                </div>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- SVG Waves decoration ở dưới cùng -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="wave-animation" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 15%; z-index: -1; opacity: 0.15;">
        <path fill="#3a569e" fill-opacity="1" d="M0,128L48,149.3C96,171,192,213,288,218.7C384,224,480,192,576,186.7C672,181,768,203,864,197.3C960,192,1056,160,1152,149.3C1248,139,1344,149,1392,154.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</div>

<!-- Script hiệu ứng tùy chỉnh -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hiệu ứng xuất hiện khi cuộn
    const animateOnScroll = function() {
        const items = document.querySelectorAll('.animate-on-scroll');
        
        items.forEach(item => {
            const itemTop = item.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (itemTop < windowHeight - 100) {
                item.classList.add('animate-in');
            }
        });
    };
    
    // Hiệu ứng gợn nước khi hover
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function(e) {
            const ripple = this.querySelector('.water-ripple');
            ripple.style.left = e.offsetX + 'px';
            ripple.style.top = e.offsetY + 'px';
            ripple.classList.add('active');
            
            // Thêm hiệu ứng scale cho card
            this.style.transform = 'scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            const ripple = this.querySelector('.water-ripple');
            ripple.classList.remove('active');
            
            // Trả về kích thước ban đầu
            this.style.transform = 'scale(1)';
        });
    });
    
    // Hiệu ứng giọt nước
    function createWaterDrop() {
        const drops = document.querySelectorAll('.water-drop');
        drops.forEach(drop => {
            const delay = Math.random() * 5;
            const duration = Math.random() * 3 + 2;
            drop.style.animationDelay = delay + 's';
            drop.style.animationDuration = duration + 's';
        });
    }
    
    // Thực hiện animation khi trang tải
    animateOnScroll();
    createWaterDrop();
    
    // Thực hiện animation khi cuộn
    window.addEventListener('scroll', animateOnScroll);
});
</script>

<?php get_footer(); ?>