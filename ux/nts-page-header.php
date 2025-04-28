<?php
// Đăng ký NTS Page Header Element cho Flatsome UX Builder
add_action( 'ux_builder_setup', 'nts_register_page_header_element' );

function nts_register_page_header_element()
    {
    add_ux_builder_shortcode( 'nts_page_header', array(
        'name'     => __( 'NTS Page Header', 'flatsome' ),
        'category' => __( 'Content', 'flatsome' ),
        'info'     => __( 'Header trang với tiêu đề tự động và nội dung tùy chỉnh, responsive 2 cột desktop/1 cột mobile', 'flatsome' ),
        'priority' => 1,
        'options'  => array(
            'content'          => array(
                'type'        => 'textarea',
                'heading'     => __( 'Nội dung bổ sung', 'flatsome' ),
                'default'     => '',
                'placeholder' => __( 'Nhập nội dung bổ sung...', 'flatsome' ),
            ),
            'content_position' => array(
                'type'    => 'select',
                'heading' => __( 'Vị trí nội dung', 'flatsome' ),
                'options' => array(
                    'right' => __( 'Bên phải tiêu đề', 'flatsome' ),
                    'left'  => __( 'Bên trái tiêu đề', 'flatsome' ),
                ),
                'default' => 'right',
            ),
            'vertical_align'   => array(
                'type'    => 'select',
                'heading' => __( 'Căn chỉnh dọc', 'flatsome' ),
                'options' => array(
                    'top'    => __( 'Trên cùng', 'flatsome' ),
                    'middle' => __( 'Giữa', 'flatsome' ),
                    'bottom' => __( 'Dưới cùng', 'flatsome' ),
                ),
                'default' => 'middle',
            ),
            'title_tag'        => array(
                'type'    => 'select',
                'heading' => __( 'Thẻ HTML tiêu đề', 'flatsome' ),
                'options' => array(
                    'h1'  => 'H1',
                    'h2'  => 'H2',
                    'h3'  => 'H3',
                    'h4'  => 'H4',
                    'h5'  => 'H5',
                    'h6'  => 'H6',
                    'div' => 'DIV',
                ),
                'default' => 'h1',
            ),
            'title_class'      => array(
                'type'        => 'textfield',
                'heading'     => __( 'Class CSS cho tiêu đề', 'flatsome' ),
                'default'     => '',
                'placeholder' => __( 'vd: text-primary, large', 'flatsome' ),
            ),
            'content_class'    => array(
                'type'        => 'textfield',
                'heading'     => __( 'Class CSS cho nội dung', 'flatsome' ),
                'default'     => '',
                'placeholder' => __( 'vd: text-secondary, small', 'flatsome' ),
            ),
            'nts_class'        => array(
                'type'    => 'textfield',
                'heading' => __( 'Custom CSS Class', 'flatsome' ),
                'default' => '',
            ),
            'nts_id'           => array(
                'type'    => 'textfield',
                'heading' => __( 'Custom ID', 'flatsome' ),
                'default' => '',
            ),
        ),
    ) );
    }

// Shortcode hiển thị NTS Page Header
function nts_page_header_shortcode($atts)
    {
    extract( shortcode_atts( array(
        'content'          => '',
        'content_position' => 'right',
        'vertical_align'   => 'middle',
        'title_tag'        => 'h1',
        'title_class'      => '',
        'content_class'    => '',
        'nts_class'        => '',
        'nts_id'           => '',
    ), $atts ) );

    // Lấy tiêu đề trang hiện tại
    $page_title = get_the_title();

    // Xác định vị trí cột
    $left_col  = $content_position === 'left' ? $content : $page_title;
    $right_col = $content_position === 'right' ? $content : $page_title;

    // Class align items
    $align_class = '';
    if ( $vertical_align === 'middle' ) {
        $align_class = ' align-items-center';
        } elseif ( $vertical_align === 'bottom' ) {
        $align_class = ' align-items-end';
        }

    // Class cho cột
    $col_class       = 'col medium-6 small-12';
    $left_col_class  = $col_class . ($content_position === 'left' ? ' nts-content-col' : ' nts-title-col');
    $right_col_class = $col_class . ($content_position === 'right' ? ' nts-content-col' : ' nts-title-col');

    // Thêm custom class nếu có
    if ( !empty($title_class) && $content_position === 'right' ) {
        $left_col_class .= ' ' . esc_attr( $title_class );
        } elseif ( !empty($title_class) ) {
        $right_col_class .= ' ' . esc_attr( $title_class );
        }

    if ( !empty($content_class) && $content_position === 'left' ) {
        $left_col_class .= ' ' . esc_attr( $content_class );
        } elseif ( !empty($content_class) ) {
        $right_col_class .= ' ' . esc_attr( $content_class );
        }

    ob_start();
    ?>
    <div class="nts-page-header <?php echo esc_attr( $nts_class ); ?>" id="<?php echo esc_attr( $nts_id ); ?>">
        <div class="row<?php echo esc_attr( $align_class ); ?>">
            <?php if ( !empty($left_col) ) : ?>
                <div class="<?php echo esc_attr( $left_col_class ); ?>">
                    <?php if ( $content_position === 'left' ) : ?>
                        <?php echo wpautop( do_shortcode( $left_col ) ); ?>
                    <?php else : ?>
                        <<?php echo esc_attr( $title_tag ); ?> class="<?php echo esc_attr( $title_class ); ?>">
                            <?php echo esc_html( $left_col ); ?>
                        </<?php echo esc_attr( $title_tag ); ?>>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ( !empty($right_col) ) : ?>
                <div class="<?php echo esc_attr( $right_col_class ); ?>">
                    <?php if ( $content_position === 'right' ) : ?>
                        <?php echo wpautop( do_shortcode( $right_col ) ); ?>
                    <?php else : ?>
                        <<?php echo esc_attr( $title_tag ); ?> class="<?php echo esc_attr( $title_class ); ?>">
                            <?php echo esc_html( $right_col ); ?>
                        </<?php echo esc_attr( $title_tag ); ?>>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <style>
        .nts-page-header {
            background-image: url(<?php echo get_stylesheet_directory_uri() . '/assets/image/nts-page-header-bg.webp'; ?>);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 24px;
            padding-top: 48px;
            border-radius: 12px;
            margin: 0 24px;
        }
        .nts-page-header h1 {
            font-size: 36px;
            color: #fff;
            line-height: 1;
        }
        .nts-page-header p {
            font-size: 18px;
            color: #fff;
        }
    </style>
    <?php



    return ob_get_clean();
    }
add_shortcode( 'nts_page_header', 'nts_page_header_shortcode' );