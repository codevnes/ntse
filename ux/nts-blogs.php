<?php
// Đăng ký Element "NTS Blogs" cho Flatsome UX Builder
add_action( 'ux_builder_setup', 'nts_register_blogs_element' );

function nts_register_blogs_element()
    {
    add_ux_builder_shortcode( 'nts_blogs', array(
        'name'      => __( 'NTS Blogs', 'flatsome' ),
        'category'  => __( 'Content', 'flatsome' ),
        'options'   => array(
            // Số lượng bài viết
            'posts_per_page' => array(
                'type'    => 'slider',
                'heading' => __( 'Số lượng', 'flatsome' ),
                'default' => 6,
                'min'     => 1,
                'max'     => 12,
                'step'    => 1,
            ),
            // Chọn danh mục
            'categories'     => array(
                'type'    => 'select',
                'heading' => __( 'Danh mục', 'flatsome' ),
                'config'  => array(
                    'multiple'    => true,
                    'placeholder' => __( 'Chọn danh mục...', 'flatsome' ),
                    'termSelect'  => array(
                        'post_type' => 'post',
                        'taxonomy'  => 'category',
                    ),
                ),
            ),
            'dark_mode'      => array(
                'type'    => 'checkbox',
                'heading' => __( 'Chủ đề tối', 'flatsome' ),
                'default' => 'false',
            ),
            // Hiển thị navigation
            'show_nav'       => array(
                'type'    => 'checkbox',
                'heading' => __( 'Hiển thị Navigation', 'flatsome' ),
                'default' => 'true',
            ),
            // Hiển thị pagination
            'show_dots'      => array(
                'type'    => 'checkbox',
                'heading' => __( 'Hiển thị Pagination', 'flatsome' ),
                'default' => 'false',
            ),
            // Autoplay
            'autoplay'       => array(
                'type'    => 'checkbox',
                'heading' => __( 'Tự động chạy', 'flatsome' ),
                'default' => 'false',
            ),
            // Loop
            'loop'           => array(
                'type'    => 'checkbox',
                'heading' => __( 'Loop slides', 'flatsome' ),
                'default' => 'true',
            ),
            // Slides per view - Desktop
            'desktop_view'   => array(
                'type'    => 'slider',
                'heading' => __( 'Slides - Desktop', 'flatsome' ),
                'default' => 3,
                'min'     => 1,
                'max'     => 4,
                'step'    => 1,
            ),
            // Slides per view - Tablet
            'tablet_view'    => array(
                'type'    => 'slider',
                'heading' => __( 'Slides - Tablet', 'flatsome' ),
                'default' => 2,
                'min'     => 1,
                'max'     => 3,
                'step'    => 1,
            ),
            // Slides per view - Mobile
            'mobile_view'    => array(
                'type'    => 'slider',
                'heading' => __( 'Slides - Mobile', 'flatsome' ),
                'default' => 1,
                'min'     => 1,
                'max'     => 2,
                'step'    => 1,
            ),
            // Space between slides
            'space_between'  => array(
                'type'    => 'slider',
                'heading' => __( 'Khoảng cách giữa slides (px)', 'flatsome' ),
                'default' => 30,
                'min'     => 0,
                'max'     => 50,
                'step'    => 5,
            ),
            // Hiển thị ngày đăng
            'show_date'      => array(
                'type'    => 'checkbox',
                'heading' => __( 'Hiển thị ngày đăng', 'flatsome' ),
                'default' => 'true',
            ),
            // Custom Class
            'class'          => array(
                'type'    => 'textfield',
                'heading' => __( 'Custom Class', 'flatsome' ),
                'default' => '',
            ),
        ),
    ) );
    }

// Shortcode hiển thị Blogs Slider
function nts_blogs_shortcode($atts)
    {
    extract( shortcode_atts( array(
        'posts_per_page' => 6,
        'categories'     => '',
        'dark_mode'      => 'false',
        'show_nav'       => 'true',
        'show_dots'      => 'false',
        'autoplay'       => 'false',
        'loop'           => 'true',
        'desktop_view'   => 3,
        'tablet_view'    => 2,
        'mobile_view'    => 1,
        'space_between'  => 30,
        'show_date'      => 'true',
        'class'          => '',
    ), $atts ) );

    // Query args
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => intval( $posts_per_page ),
        'post_status'    => 'publish',
    );

    // Lọc theo danh mục nếu có
    if ( !empty($categories) ) {
        $args['category__in'] = explode( ',', $categories );
        }

    $blogs = new WP_Query( $args );

    // Swiper config
    $swiper_config = array(
        'slidesPerView' => intval( $mobile_view ),
        'spaceBetween'  => intval( $space_between ),
        'loop'          => ($loop == 'true'),
        'autoplay'      => ($autoplay == 'true') ? array( 'delay' => 3000 ) : false,
        'navigation'    => array(
            'nextEl' => '.swiper-button-next',
            'prevEl' => '.swiper-button-prev',
        ),
        'pagination'    => array(
            'el'        => '.swiper-pagination',
            'clickable' => true,
        ),
        'breakpoints'   => array(
            0    => array( 'slidesPerView' => intval( $mobile_view ) ),
            768  => array( 'slidesPerView' => intval( $tablet_view ) ),
            1024 => array( 'slidesPerView' => intval( $desktop_view ) ),
        ),
    );

    ob_start();

    if ( $blogs->have_posts() ) : ?>
        <div class="nts-blogs-slider nts-swiper <?php echo ($dark_mode == 'true') ? 'dark-mode' : ''; ?> <?php echo esc_attr($class); ?>"
            data-swiper='<?php echo json_encode( $swiper_config ); ?>'>
            <div class="swiper-wrapper">
                <?php while ( $blogs->have_posts() ) :
                    $blogs->the_post(); ?>
                    <div class="swiper-slide">
                        <article class="blog-card">
                            <a href="<?php the_permalink(); ?>" class="blog-thumbnail">
                                <?php the_post_thumbnail( 'medium_large' ); ?>
                            </a>
                            <div class="blog-content">
                                <h3 class="blog-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <?php if ( $show_date == 'true' ) : ?>
                                    <div class="blog-meta">
                                        <i class="fas fa-calendar-alt"></i>
                                        <time datetime="<?php echo get_the_date( 'c' ); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </div>
                                <?php endif; ?>
                                <div class="blog-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>

            <?php if ( $show_nav == 'true' || $show_dots == 'true' ) : ?>
                <div class="swiper-actions">
                    <?php if ( $show_nav == 'true' ) : ?>
                        <div class="swiper-prev">
                            <i class="fas fa-chevron-left"></i>
                        </div>
                    <?php endif; ?>

                    <?php if ( $show_dots == 'true' ) : ?>
                        <div class="swiper-pagination mt-8 light"></div>
                    <?php endif; ?>

                    <?php if ( $show_nav == 'true' ) : ?>
                        <div class="swiper-next">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <p><?php _e( 'Không tìm thấy bài viết nào.', 'flatsome' ); ?></p>
    <?php endif;

    return ob_get_clean();
    }
add_shortcode( 'nts_blogs', 'nts_blogs_shortcode' );