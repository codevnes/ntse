<?php
// Đăng ký Element "NTS Project Overview" cho Flatsome UX Builder
add_action( 'ux_builder_setup', 'nts_register_project_overview_element' );

function nts_register_project_overview_element()
    {
    add_ux_builder_shortcode( 'nts_project_overview', array(
        'name'      => __( 'NTS Project Overview', 'flatsome' ),
        'category'  => __( 'Content', 'flatsome' ),
        'options'   => array(
            // Mô tả ngắn
            'description' => array(
                'type'        => 'textarea',
                'heading'     => __( 'Mô tả ngắn', 'flatsome' ),
                'default'     => '',
                'placeholder' => __( 'Nhập mô tả ngắn về dự án', 'flatsome' )
            ),
            // Custom Class
            'class'       => array(
                'type'    => 'textfield',
                'heading' => __( 'Custom Class', 'flatsome' ),
                'default' => ''
            )
        )
    ) );
    }

// Shortcode hiển thị Project Overview
function nts_project_overview_shortcode($atts)
    {
    extract( shortcode_atts( array(
        'title'       => '',
        'description' => '',
        'class'       => ''
    ), $atts ) );

    ob_start(); ?>

    <div class="nts-project-overview <?php echo esc_attr( $class ); ?>">
        <div class="container">
            <div class="nts-project-breadcrumb">
                <?php
                // Hiển thị breadcrumb
                echo '<a href="' . home_url() . '">' . __( 'Trang chủ', 'flatsome' ) . '</a> &raquo; ';
                echo '<a href="' . get_post_type_archive_link( 'project' ) . '">' . __( 'Dự án', 'flatsome' ) . '</a>';
                ?>
            </div>

            <?php if ( $title ) : ?>
                <h1 class="nts-project-title"><?php echo esc_html( $title ); ?></h1>
            <?php else : ?>
                <h1 class="nts-project-title"><?php the_title(); ?></h1>
            <?php endif; ?>
            <?php if ( $description ) : ?>
                <div class="nts-project-description">
                    <?php echo wpautop( do_shortcode( $description ) ); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php return ob_get_clean();
    }
add_shortcode( 'nts_project_overview', 'nts_project_overview_shortcode' );