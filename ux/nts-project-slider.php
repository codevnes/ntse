<?php
// Đăng ký Element "NTS Project Slider" cho Flatsome UX Builder
add_action( 'ux_builder_setup', 'nts_register_project_slider_element' );

function nts_register_project_slider_element()
    {
    add_ux_builder_shortcode( 'nts_project_slider', array(
        'name'      => __( 'NTS Project Slider', 'flatsome' ),
        'category'  => __( 'Content', 'flatsome' ),
        'options'   => array(
            // Số lượng dự án
            'posts_per_page' => array(
                'type'    => 'slider',
                'heading' => __( 'Số lượng', 'flatsome' ),
                'default' => 6,
                'min'     => 1,
                'max'     => 24,
                'step'    => 1,
            ),
            // Chọn danh mục (multi-select)
            'categories'     => array(
                'type'    => 'select',
                'heading' => __( 'Danh mục', 'flatsome' ),
                'config'  => array(
                    'multiple'    => true,
                    'placeholder' => __( 'Chọn danh mục...', 'flatsome' ),
                    'termSelect'  => array(
                        'post_type' => 'project',
                        'taxonomy'  => 'project_category',
                    ),
                ),
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
                'max'     => 6,
                'step'    => 1,
            ),
            // Slides per view - Tablet
            'tablet_view'    => array(
                'type'    => 'slider',
                'heading' => __( 'Slides - Tablet', 'flatsome' ),
                'default' => 2,
                'min'     => 1,
                'max'     => 4,
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
                'max'     => 100,
                'step'    => 5,
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

// Shortcode hiển thị Project Slider
function nts_project_slider_shortcode($atts)
    {
    extract( shortcode_atts( array(
        'posts_per_page' => 6,
        'categories'     => '',
        'show_nav'       => 'true',
        'show_dots'      => 'false',
        'autoplay'       => 'false',
        'loop'           => 'true',
        'desktop_view'   => 3,
        'tablet_view'    => 2,
        'mobile_view'    => 1,
        'space_between'  => 30,
        'class'          => '',
    ), $atts ) );

    // Query args
    $args = array(
        'post_type'      => 'project',
        'posts_per_page' => intval( $posts_per_page ),
        'post_status'    => 'publish',
    );

    // Lọc theo danh mục nếu có
    if ( !empty($categories) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'project_category',
                'field'    => 'term_id',
                'terms'    => explode( ',', $categories ),
            ),
        );
        }

    $projects = new WP_Query( $args );

    // Swiper config
    $swiper_config = array(
        'slidesPerView' => intval( $mobile_view ),
        'spaceBetween'  => intval( $space_between ),
        'loop'          => ($loop == 'true'),
        'autoplay'      => ($autoplay == 'true') ? array( 'delay' => 3000 ) : false,
        'breakpoints'   => array(
            0    => array( 'slidesPerView' => intval( $mobile_view ) ),
            768  => array( 'slidesPerView' => intval( $tablet_view ) ),
            1024 => array( 'slidesPerView' => intval( $desktop_view ) ),
        ),
    );

    ob_start();

    if ( $projects->have_posts() ) : ?>
        <div class="nts-project-slider nts-swiper <?php echo esc_attr( $class ); ?>"
            data-swiper='<?php echo json_encode( $swiper_config ); ?>'>
            <div class="swiper-wrapper">
                <?php while ( $projects->have_posts() ) :
                    $projects->the_post(); ?>
                    <div class="swiper-slide">
                        <div class="project-card">
                            <a href="<?php the_permalink(); ?>">

                                <div class="project-image">
                                    <?php the_post_thumbnail( 'medium_large' ); ?>
                                    <div class="project-action">
                                        <div class="btn-cricle">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $terms = get_the_terms( get_the_ID(), 'project_category' );
                                if ( !empty($terms) && !is_wp_error( $terms ) ) :
                                    echo '<div class="project-categories">';
                                    foreach ( $terms as $term ) {
                                        echo '<span class="project-category">' . esc_html( $term->name ) . '</span>';
                                        }
                                    echo '</div>';
                                endif;
                                ?>
                                <h3 class="project-title"><?php the_title(); ?></h3>
                            </a>
                        </div>
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
        <p><?php _e( 'Không tìm thấy dự án nào.', 'flatsome' ); ?></p>
    <?php endif;

    return ob_get_clean();
    }
add_shortcode( 'nts_project_slider', 'nts_project_slider_shortcode' );