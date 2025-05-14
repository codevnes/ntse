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

        <?php
        // Lấy dữ liệu phần giới thiệu
        $intro_data = ntse_get_product_category_intro($category_id);

        // Hiển thị phần giới thiệu nếu có dữ liệu
        if (!empty($intro_data['title']) || !empty($intro_data['content'])) :
        ?>
        <!-- Category Introduction Section -->
        <div class="category-introduction">
            <!-- Modern Water Background Elements -->
            <div class="water-background">
                <div class="water-wave-top"></div>
                <div class="water-wave-bottom"></div>

                <!-- Animated Particles -->
                <div class="particles-container">
                    <?php for ($i = 1; $i <= 20; $i++) : ?>
                        <div class="particle particle-<?php echo $i; ?>"></div>
                    <?php endfor; ?>
                </div>

                <!-- Animated Water Circles -->
                <div class="water-circles">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <div class="water-circle circle-<?php echo $i; ?>">
                            <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="2" />
                                <path class="water-path" d="M5,50 Q25,30 50,50 T95,50" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="2" />
                            </svg>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="container">
                <div class="intro-content-wrapper">
                    <div class="intro-content animate-on-scroll fade-in-up">
                        <div class="intro-header">
                            <?php if (!empty($intro_data['title'])) : ?>
                                <h2 class="intro-title">
                                    <span class="title-highlight"><?php echo esc_html($intro_data['title']); ?></span>
                                    <div class="title-decoration">
                                        <span class="dot"></span>
                                        <span class="line"></span>
                                        <span class="dot"></span>
                                    </div>
                                </h2>
                            <?php endif; ?>

                            <?php if (!empty($intro_data['subtitle'])) : ?>
                                <div class="intro-subtitle"><?php echo esc_html($intro_data['subtitle']); ?></div>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($intro_data['content'])) : ?>
                            <div class="intro-text">
                                <?php echo wp_kses_post($intro_data['content']); ?>
                            </div>
                        <?php endif; ?>

                        <div class="intro-features">
                            <?php if (!empty($intro_data['features']) && is_array($intro_data['features'])) : ?>
                                <?php foreach ($intro_data['features'] as $feature) : ?>
                                    <div class="feature-item">
                                        <div class="feature-icon">
                                            <i class="<?php echo esc_attr($feature['icon']); ?>"></i>
                                        </div>
                                        <div class="feature-text"><?php echo esc_html($feature['text']); ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <!-- Default features if none are specified -->
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="feature-text">Chất lượng cao</div>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div class="feature-text">Bảo hành dài hạn</div>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <div class="feature-text">Giao hàng nhanh chóng</div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <a href="<?php echo esc_url(!empty($intro_data['button_url']) ? $intro_data['button_url'] : '/lien-he'); ?>" class="intro-button">
                            <span class="button-text"><?php echo esc_html(!empty($intro_data['button_text']) ? $intro_data['button_text'] : 'Liên hệ ngay'); ?></span>
                            <span class="button-icon"><i class="fas fa-arrow-right"></i></span>
                            <span class="button-effect"></span>
                        </a>
                    </div>

                    <?php if (!empty($intro_data['image_url'])) : ?>
                        <div class="intro-image animate-on-scroll fade-in-right">
                            <div class="image-frame">
                                <div class="image-container">
                                    <div class="image-overlay"></div>
                                    <img src="<?php echo esc_url($intro_data['image_url']); ?>" alt="<?php echo esc_attr($category_name); ?> - <?php echo esc_attr($intro_data['title']); ?>">

                                    <!-- Decorative Elements -->
                                    <div class="image-decoration top-left"></div>
                                    <div class="image-decoration top-right"></div>
                                    <div class="image-decoration bottom-left"></div>
                                    <div class="image-decoration bottom-right"></div>

                                    <!-- Water Drops Animation -->
                                    <div class="water-drops">
                                        <?php for ($i = 1; $i <= 8; $i++) : ?>
                                            <div class="water-drop drop-<?php echo $i; ?>">
                                                <svg viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15,3 Q25,18 15,27 Q5,18 15,3" fill="rgba(255,255,255,0.7)" />
                                                </svg>
                                            </div>
                                        <?php endfor; ?>
                                    </div>

                                    <!-- Ripple Effect -->
                                    <div class="ripple-container">
                                        <div class="ripple ripple-1"></div>
                                        <div class="ripple ripple-2"></div>
                                        <div class="ripple ripple-3"></div>
                                    </div>
                                </div>

                                <!-- Image Caption -->
                                <?php if (!empty($intro_data['image_caption'])) : ?>
                                    <div class="image-caption">
                                        <i class="fas fa-info-circle"></i>
                                        <span><?php echo esc_html($intro_data['image_caption']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Hiển thị hình ảnh mặc định nếu không có hình ảnh được tải lên -->
                        <div class="intro-image animate-on-scroll fade-in-right">
                            <div class="image-frame">
                                <div class="image-container default-image">
                                    <div class="water-animation">
                                        <div class="water-wave"></div>
                                        <div class="water-drop-animation">
                                            <i class="fas fa-tint fa-4x"></i>
                                            <div class="water-ripples">
                                                <div class="ripple-circle c1"></div>
                                                <div class="ripple-circle c2"></div>
                                                <div class="ripple-circle c3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Stats Counter Section -->
                <?php if (!empty($intro_data['stats']) && is_array($intro_data['stats'])) : ?>
                <div class="intro-stats animate-on-scroll fade-in-up">
                    <?php foreach ($intro_data['stats'] as $stat) : ?>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="<?php echo esc_attr($stat['icon']); ?>"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number" data-count="<?php echo esc_attr($stat['number']); ?>">0</div>
                                <div class="stat-label"><?php echo esc_html($stat['label']); ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Modern Wave Decoration -->
            <div class="wave-decoration">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none">
                    <path class="wave-path-1" d="M0,64 C320,120 480,0 720,40 C960,80 1200,0 1440,80 L1440,120 L0,120 Z" fill="#f8f9fa" fill-opacity="1"></path>
                    <path class="wave-path-2" d="M0,80 C240,40 480,120 720,80 C960,40 1200,120 1440,40 L1440,120 L0,120 Z" fill="#f8f9fa" fill-opacity="0.8"></path>
                </svg>
            </div>
        </div>
        <?php endif; ?>

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

<!-- CSS cho phần giới thiệu danh mục -->
<style>
/* Category Introduction Section */
.category-introduction {
    position: relative;
    padding: 80px 0 60px;
    background: linear-gradient(135deg, rgba(240,249,255,1) 0%, rgba(249,251,255,1) 100%);
    overflow: hidden;
    margin-bottom: 30px;
    z-index: 1;
}

/* Floating Bubbles */
.floating-bubbles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 0;
}

.bubble {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(to right, rgba(255,255,255,0.3), rgba(255,255,255,0.1));
    box-shadow: 0 0 10px rgba(255,255,255,0.5), inset 0 0 10px rgba(255,255,255,0.5);
    animation: float 15s infinite ease-in-out;
    opacity: 0;
}

.bubble:before {
    content: '';
    position: absolute;
    top: 10%;
    left: 10%;
    width: 30%;
    height: 30%;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
}

@keyframes float {
    0% {
        transform: translateY(100%) translateX(0) scale(0.3);
        opacity: 0;
    }
    10% {
        opacity: 0.8;
    }
    90% {
        opacity: 0.2;
    }
    100% {
        transform: translateY(-100%) translateX(30px) scale(1);
        opacity: 0;
    }
}

/* Generate random bubble sizes and positions */
.bubble-1 { width: 30px; height: 30px; left: 10%; animation-duration: 20s; }
.bubble-2 { width: 15px; height: 15px; left: 20%; animation-duration: 18s; animation-delay: 1s; }
.bubble-3 { width: 25px; height: 25px; left: 30%; animation-duration: 16s; animation-delay: 2s; }
.bubble-4 { width: 20px; height: 20px; left: 40%; animation-duration: 15s; animation-delay: 0.5s; }
.bubble-5 { width: 35px; height: 35px; left: 50%; animation-duration: 17s; animation-delay: 1.5s; }
.bubble-6 { width: 40px; height: 40px; left: 60%; animation-duration: 19s; animation-delay: 3s; }
.bubble-7 { width: 18px; height: 18px; left: 70%; animation-duration: 14s; animation-delay: 2.5s; }
.bubble-8 { width: 22px; height: 22px; left: 80%; animation-duration: 21s; animation-delay: 1s; }
.bubble-9 { width: 28px; height: 28px; left: 90%; animation-duration: 22s; animation-delay: 0.5s; }
.bubble-10 { width: 15px; height: 15px; left: 5%; animation-duration: 23s; animation-delay: 2s; }
.bubble-11 { width: 32px; height: 32px; left: 15%; animation-duration: 24s; animation-delay: 3.5s; }
.bubble-12 { width: 26px; height: 26px; left: 25%; animation-duration: 25s; animation-delay: 4s; }
.bubble-13 { width: 38px; height: 38px; left: 35%; animation-duration: 19s; animation-delay: 2.5s; }
.bubble-14 { width: 42px; height: 42px; left: 45%; animation-duration: 18s; animation-delay: 1.5s; }
.bubble-15 { width: 36px; height: 36px; left: 55%; animation-duration: 20s; animation-delay: 3s; }

.intro-content-wrapper {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 40px;
    position: relative;
    z-index: 2;
}

.intro-content {
    flex: 1;
    min-width: 300px;
    padding-right: 20px;
    position: relative;
}

/* Animation classes */
.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.fade-in-right {
    opacity: 0;
    transform: translateX(30px);
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.animate-in.fade-in-up,
.animate-in.fade-in-right {
    opacity: 1;
    transform: translate(0);
}

.intro-title {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 15px;
    font-weight: 700;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.intro-title:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 80px;
    height: 3px;
    background: linear-gradient(to right, var(--primary), var(--primary-light));
    border-radius: 3px;
}

.intro-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #555;
    margin-bottom: 30px;
}

.intro-text p {
    margin-bottom: 15px;
}

.intro-button {
    display: inline-block;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: 14px 30px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.4s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.intro-button:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    color: white;
}

.intro-button i {
    margin-left: 8px;
    transition: transform 0.4s ease;
    position: relative;
    z-index: 2;
}

.intro-button:hover i {
    transform: translateX(5px);
}

.button-effect {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: -1;
}

.intro-button:hover .button-effect {
    opacity: 1;
}

.intro-image {
    flex: 1;
    min-width: 300px;
    position: relative;
}

.image-container {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(0,0,0,0), rgba(0,100,255,0.2));
    z-index: 1;
    opacity: 0.5;
    transition: opacity 0.5s ease;
}

.image-container:hover .image-overlay {
    opacity: 0.7;
}

.image-container:hover {
    transform: translateY(-15px) scale(1.03);
    box-shadow: 0 25px 45px rgba(0,0,0,0.2);
}

.intro-image img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 15px;
    transition: transform 0.8s ease;
}

.image-container:hover img {
    transform: scale(1.08);
}

/* Default image with water animation */
.image-container.default-image {
    background: linear-gradient(135deg, #e0f7ff 0%, #c5e8ff 100%);
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.water-animation {
    position: relative;
    width: 150px;
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.water-wave {
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(58, 125, 242, 0.2);
    border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
    animation: waterWave 5s infinite linear;
}

.water-animation i {
    color: var(--primary);
    z-index: 1;
    animation: waterBounce 2s infinite ease-in-out;
}

@keyframes waterWave {
    0% {
        border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        transform: rotate(0deg);
    }
    50% {
        border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
    }
    100% {
        border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        transform: rotate(360deg);
    }
}

@keyframes waterBounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

/* Water drops animation for intro section */
.water-drops.small {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 2;
}

.water-drop.drop-s-1,
.water-drop.drop-s-2,
.water-drop.drop-s-3,
.water-drop.drop-s-4,
.water-drop.drop-s-5 {
    position: absolute;
    width: 15px;
    height: 15px;
    background: rgba(255,255,255,0.7);
    border-radius: 50%;
    animation: waterDrop 3s infinite ease-in-out;
}

.water-drop.drop-s-1 { top: 15%; left: 10%; }
.water-drop.drop-s-2 { top: 25%; right: 15%; animation-delay: 0.5s; }
.water-drop.drop-s-3 { bottom: 30%; left: 20%; animation-delay: 1s; }
.water-drop.drop-s-4 { bottom: 15%; right: 25%; animation-delay: 1.5s; }
.water-drop.drop-s-5 { top: 50%; left: 50%; animation-delay: 2s; }

@keyframes waterDrop {
    0% {
        transform: scale(0);
        opacity: 0.8;
    }
    50% {
        transform: scale(1);
        opacity: 0.5;
    }
    100% {
        transform: scale(1.5);
        opacity: 0;
    }
}

/* Ripple effect */
.ripple-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
    z-index: 1;
    pointer-events: none;
}

.ripple {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255,255,255,0.4);
    animation: ripple 4s infinite ease-out;
}

.ripple-2 {
    animation-delay: 1s;
}

.ripple-3 {
    animation-delay: 2s;
}

@keyframes ripple {
    0% {
        width: 0;
        height: 0;
        opacity: 0.5;
    }
    100% {
        width: 200%;
        height: 200%;
        opacity: 0;
    }
}

.wave-decoration.small {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    line-height: 0;
    z-index: 2;
}

/* Responsive styles */
@media (max-width: 991px) {
    .intro-content-wrapper {
        flex-direction: column;
    }

    .intro-content, .intro-image {
        width: 100%;
        padding-right: 0;
    }

    .intro-title {
        font-size: 2rem;
    }

    .intro-text {
        font-size: 1rem;
    }

    .category-introduction {
        padding: 60px 0 40px;
    }
}

@media (max-width: 576px) {
    .intro-title {
        font-size: 1.8rem;
    }

    .intro-button {
        width: 100%;
        text-align: center;
    }
}
</style>

<!-- JavaScript code moved to consolidated.js -->

<?php get_footer(); ?>