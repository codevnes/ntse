<?php
/**
 * Breadcrumb functions
 *
 * @package NTS Theme
 */

/**
 * Hiển thị breadcrumb (đường dẫn điều hướng) sử dụng Font Awesome
 *
 * @param string $separator Ký tự phân cách giữa các mục
 * @param string $home_text Văn bản cho trang chủ
 * @param bool   $show_current Hiển thị trang hiện tại
 * @param bool   $show_on_home Hiển thị breadcrumb trên trang chủ
 * @param bool   $show_post_title Hiển thị tiêu đề bài viết trong breadcrumb
 * @param string $before_current HTML trước trang hiện tại
 * @param string $after_current HTML sau trang hiện tại
 * @param bool   $echo Hiển thị hoặc trả về breadcrumb
 * @param string $wrapper_class Class cho wrapper
 * @return string|void
 */
function nts_the_breadcrumb($args = [])
    {
    // Tham số mặc định
    $defaults = [
        'separator'       => '<i class="fas fa-angle-right"></i>',
        'home_text'       => 'Trang chủ',
        'show_current'    => true,
        'show_on_home'    => false,
        'show_post_title' => true,  // Hiển thị tiêu đề bài viết trong breadcrumb
        'before_current'  => '<span class="current">',
        'after_current'   => '</span>',
        'echo'            => true,
        'wrapper_class'   => 'nts-breadcrumb',
    ];

    // Kết hợp tham số người dùng với tham số mặc định
    $args = wp_parse_args( $args, $defaults );

    // Khởi tạo biến
    $breadcrumb = '';
    $home_url   = home_url( '/' );
    $before     = '<div class="' . esc_attr( $args['wrapper_class'] ) . '">';
    $after      = '</div>';

    // Bắt đầu breadcrumb
    $breadcrumb .= $before;

    // Trang chủ
    $breadcrumb .= '<span class="home"><a href="' . esc_url( $home_url ) . '">' . esc_html( $args['home_text'] ) . '</a></span>';

    // Nếu đang ở trang chủ
    if ( is_home() || is_front_page() ) {
        if ( $args['show_on_home'] ) {
            $breadcrumb .= ' ' . $args['separator'] . ' ' . $args['before_current'] . __( 'Bài viết', 'nts' ) . $args['after_current'];
            }
        } else {
        $breadcrumb .= ' ' . $args['separator'] . ' ';

        // Trang danh mục
        if ( is_category() ) {
            $cat = get_category( get_query_var( 'cat' ), false );

            if ( $cat->parent != 0 ) {
                $parent_categories = [];
                $parent_id         = $cat->parent;

                while ( $parent_id ) {
                    $parent_cat          = get_category( $parent_id );
                    $parent_categories[] = '<span><a href="' . esc_url( get_category_link( $parent_cat->term_id ) ) . '">' . esc_html( $parent_cat->name ) . '</a></span>';
                    $parent_id           = $parent_cat->parent;
                    }

                $breadcrumb .= implode( ' ' . $args['separator'] . ' ', array_reverse( $parent_categories ) ) . ' ' . $args['separator'] . ' ';
                }

            if ( $args['show_current'] ) {
                $breadcrumb .= $args['before_current'] . single_cat_title( '', false ) . $args['after_current'];
                }
            }
        // Trang bài viết
        elseif ( is_single() && !is_attachment() ) {
            // Bài viết thuộc danh mục
            if ( get_post_type() == 'post' ) {
                $categories = get_the_category();

                if ( $categories ) {
                    $cat               = $categories[0];
                    $parent_categories = [];
                    $parent_id         = $cat->parent;

                    while ( $parent_id ) {
                        $parent_cat          = get_category( $parent_id );
                        $parent_categories[] = '<span><a href="' . esc_url( get_category_link( $parent_cat->term_id ) ) . '">' . esc_html( $parent_cat->name ) . '</a></span>';
                        $parent_id           = $parent_cat->parent;
                        }

                    if ( !empty($parent_categories) ) {
                        $breadcrumb .= implode( ' ' . $args['separator'] . ' ', array_reverse( $parent_categories ) ) . ' ' . $args['separator'] . ' ';
                        }

                    $breadcrumb .= '<span><a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a></span>';

                    if ( $args['show_current'] && $args['show_post_title'] ) {
                        $breadcrumb .= ' ' . $args['separator'] . ' ' . $args['before_current'] . get_the_title() . $args['after_current'];
                        }
                    }
                }
            // Custom post type
            elseif ( get_post_type() != 'post' ) {
                $post_type    = get_post_type_object( get_post_type() );
                $archive_link = get_post_type_archive_link( get_post_type() );

                $breadcrumb .= '<span><a href="' . esc_url( $archive_link ) . '">' . esc_html( $post_type->labels->name ) . '</a></span>';

                // Hiển thị taxonomy nếu có
                $taxonomies = get_object_taxonomies( get_post_type(), 'objects' );

                if ( !empty($taxonomies) ) {
                    foreach ( $taxonomies as $taxonomy ) {
                        if ( $taxonomy->hierarchical ) {
                            $terms = get_the_terms( get_the_ID(), $taxonomy->name );

                            if ( $terms && !is_wp_error( $terms ) ) {
                                $term         = $terms[0];
                                $parent_terms = [];
                                $parent_id    = $term->parent;

                                while ( $parent_id ) {
                                    $parent_term    = get_term( $parent_id, $taxonomy->name );
                                    $parent_terms[] = '<span><a href="' . esc_url( get_term_link( $parent_term ) ) . '">' . esc_html( $parent_term->name ) . '</a></span>';
                                    $parent_id      = $parent_term->parent;
                                    }

                                if ( !empty($parent_terms) ) {
                                    $breadcrumb .= ' ' . $args['separator'] . ' ' . implode( ' ' . $args['separator'] . ' ', array_reverse( $parent_terms ) );
                                    }

                                $breadcrumb .= ' ' . $args['separator'] . ' <span><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></span>';
                                break; // Chỉ hiển thị taxonomy đầu tiên
                                }
                            }
                        }
                    }

                if ( $args['show_current'] && $args['show_post_title'] ) {
                    $breadcrumb .= ' ' . $args['separator'] . ' ' . $args['before_current'] . get_the_title() . $args['after_current'];
                    }
                }
            }
        // Trang tĩnh
        elseif ( is_page() && !is_front_page() ) {
            $post = get_post( get_the_ID() );

            if ( $post->post_parent ) {
                $parent_pages = [];
                $parent_id    = $post->post_parent;

                while ( $parent_id ) {
                    $parent_page    = get_post( $parent_id );
                    $parent_pages[] = '<span><a href="' . esc_url( get_permalink( $parent_page->ID ) ) . '">' . esc_html( get_the_title( $parent_page->ID ) ) . '</a></span>';
                    $parent_id      = $parent_page->post_parent;
                    }

                $breadcrumb .= implode( ' ' . $args['separator'] . ' ', array_reverse( $parent_pages ) ) . ' ' . $args['separator'] . ' ';
                }

            if ( $args['show_current'] && $args['show_post_title'] ) {
                $breadcrumb .= $args['before_current'] . get_the_title() . $args['after_current'];
                }
            }
        // Trang tìm kiếm
        elseif ( is_search() ) {
            $breadcrumb .= $args['before_current'] . __( 'Kết quả tìm kiếm cho', 'nts' ) . ' "' . get_search_query() . '"' . $args['after_current'];
            }
        // Trang tag
        elseif ( is_tag() ) {
            $breadcrumb .= $args['before_current'] . __( 'Bài viết được gắn thẻ', 'nts' ) . ' "' . single_tag_title( '', false ) . '"' . $args['after_current'];
            }
        // Trang tác giả
        elseif ( is_author() ) {
            $author_id  = get_query_var( 'author' );
            $breadcrumb .= $args['before_current'] . __( 'Bài viết của tác giả', 'nts' ) . ' ' . get_the_author_meta( 'display_name', $author_id ) . $args['after_current'];
            }
        // Trang lưu trữ theo ngày
        elseif ( is_day() ) {
            $breadcrumb .= '<span><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a></span>';
            $breadcrumb .= ' ' . $args['separator'] . ' <span><a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . get_the_time( 'F' ) . '</a></span>';
            $breadcrumb .= ' ' . $args['separator'] . ' ' . $args['before_current'] . get_the_time( 'd' ) . $args['after_current'];
            }
        // Trang lưu trữ theo tháng
        elseif ( is_month() ) {
            $breadcrumb .= '<span><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a></span>';
            $breadcrumb .= ' ' . $args['separator'] . ' ' . $args['before_current'] . get_the_time( 'F' ) . $args['after_current'];
            }
        // Trang lưu trữ theo năm
        elseif ( is_year() ) {
            $breadcrumb .= $args['before_current'] . get_the_time( 'Y' ) . $args['after_current'];
            }
        // Trang lưu trữ
        elseif ( is_post_type_archive() ) {
            $post_type  = get_post_type_object( get_post_type() );
            $breadcrumb .= $args['before_current'] . esc_html( $post_type->labels->name ) . $args['after_current'];
            }
        // Trang taxonomy
        elseif ( is_tax() ) {
            $term     = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            $taxonomy = get_taxonomy( get_query_var( 'taxonomy' ) );

            if ( $term->parent != 0 ) {
                $parent_terms = [];
                $parent_id    = $term->parent;

                while ( $parent_id ) {
                    $parent_term    = get_term( $parent_id, get_query_var( 'taxonomy' ) );
                    $parent_terms[] = '<span><a href="' . esc_url( get_term_link( $parent_term ) ) . '">' . esc_html( $parent_term->name ) . '</a></span>';
                    $parent_id      = $parent_term->parent;
                    }

                $breadcrumb .= implode( ' ' . $args['separator'] . ' ', array_reverse( $parent_terms ) ) . ' ' . $args['separator'] . ' ';
                }

            $breadcrumb .= $args['before_current'] . esc_html( $term->name ) . $args['after_current'];
            }
        // Trang 404
        elseif ( is_404() ) {
            $breadcrumb .= $args['before_current'] . __( 'Không tìm thấy trang', 'nts' ) . $args['after_current'];
            }
        }

    // Kết thúc breadcrumb
    $breadcrumb .= $after;

    // Hiển thị hoặc trả về breadcrumb
    if ( $args['echo'] ) {
        echo $breadcrumb;
        } else {
        return $breadcrumb;
        }
    }

/**
 * Thêm CSS cho breadcrumb
 */
function nts_breadcrumb_styles()
    {
    ?>
    <style>
        .nts-breadcrumb {
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
        }

        .nts-breadcrumb .current {
            color: #0073aa;
            font-weight: 600;
        }
    </style>
    <?php
    }
add_action( 'wp_head', 'nts_breadcrumb_styles' );
