<?php
/**
 * Trang hiển thị danh sách sản phẩm
 */

get_header();

// Lấy thông tin phân trang
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$products_per_page = 6;

// Thiết lập tham số truy vấn
$args = array(
    'post_type' => 'product',
    'posts_per_page' => $products_per_page,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC'
);

// Thêm điều kiện lọc nếu có
if (isset($_GET['product_category']) && !empty($_GET['product_category'])) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_category',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['product_category']),
        ),
    );
}

// Thêm điều kiện tìm kiếm nếu có
if (isset($_GET['s']) && !empty($_GET['s'])) {
    $args['s'] = sanitize_text_field($_GET['s']);
}

// Thực hiện truy vấn
$products_query = new WP_Query($args);
?>

<div class="product-archive">
    <div class="container">
        <div class="product-archive-header">
            <h1 class="page-title">Sản phẩm của chúng tôi</h1>
            <div class="page-description">
                Các giải pháp xử lý nước hiện đại, đáp ứng mọi nhu cầu. Sản phẩm của chúng tôi được thiết kế với tiêu chuẩn chất lượng cao, công nghệ tiên tiến và thân thiện với môi trường.
            </div>
            
            <!-- Hiệu ứng bong bóng nước sinh động -->
            <div class="bubbles-animation">
                <?php for ($i = 1; $i <= 15; $i++) : ?>
                    <div class="bubble" style="--size: <?php echo rand(2, 8); ?>rem; --delay: <?php echo $i * 0.2; ?>s; --duration: <?php echo rand(6, 12); ?>s; --left: <?php echo rand(0, 100); ?>%;"></div>
                <?php endfor; ?>
            </div>
        </div>

        <div class="product-filter">
            <div class="filter-header">
                <h3 class="filter-title">Bộ lọc sản phẩm</h3>
                <div class="filter-toggle">
                    <i class="fas fa-filter"></i>
                    <span>Lọc</span>
                </div>
            </div>
            <form class="filter-form" method="get">
                <div class="filter-group">
                    <div class="filter-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" name="s" placeholder="Tìm kiếm sản phẩm..." value="<?php echo esc_attr(get_search_query()); ?>">
                    </div>
                </div>
                
                <div class="filter-group">
                    <div class="filter-select-wrapper">
                        <i class="fas fa-tags"></i>
                        <select name="product_category" class="filter-select">
                            <option value="">Tất cả danh mục</option>
                            <?php if (!is_wp_error($product_categories)) : ?>
                                <?php foreach ($product_categories as $category) : ?>
                                    <option value="<?php echo esc_attr($category->slug); ?>" <?php echo isset($_GET['product_category']) && $_GET['product_category'] == $category->slug ? 'selected' : ''; ?>>
                                        <?php echo esc_html($category->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="filter-submit">
                        <i class="fas fa-search"></i>
                        <span>Tìm kiếm</span>
                    </button>
                    <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="filter-reset">
                        <i class="fas fa-redo"></i>
                        <span>Đặt lại</span>
                    </a>
                </div>
            </form>
        </div>

        <div class="product-grid">
            <?php if ($products_query->have_posts()) : ?>
                <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>
                    <?php
                    $product_id = get_the_ID();
                    $product_cats = get_the_terms($product_id, 'product_category');
                    $product_cat = !empty($product_cats) && !is_wp_error($product_cats) ? $product_cats[0]->name : '';
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
                        </div>
                        <div class="product-content">
                            <span class="product-category"><?php echo esc_html($product_cat); ?></span>
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
                    <p>Không tìm thấy sản phẩm nào phù hợp với tiêu chí tìm kiếm.</p>
                </div>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>

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
    </div>

    <!-- SVG Waves decoration ở dưới cùng -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="wave-animation" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 15%; z-index: -1; opacity: 0.15;">
        <path fill="#3a569e" fill-opacity="1" d="M0,128L48,149.3C96,171,192,213,288,218.7C384,224,480,192,576,186.7C672,181,768,203,864,197.3C960,192,1056,160,1152,149.3C1248,139,1344,149,1392,154.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</div>

<!-- JavaScript code moved to consolidated.js -->

<?php get_footer(); ?> 