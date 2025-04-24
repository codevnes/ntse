<?php
// Đăng ký Container NTS Project Challenge
add_action( 'ux_builder_setup', 'nts_register_project_challenge_container' );

function nts_register_project_challenge_container()
    {
    add_ux_builder_shortcode( 'nts_project_challenge', array(
        'name'      => __( 'NTS Project Challenge', 'flatsome' ),
        'category'  => __( 'Content', 'flatsome' ),
        'type'      => 'container',
        'allow'     => array( 'nts_project_challenge_item' ),
        'options'   => array(
            'image'       => array(
                'type'    => 'image',
                'heading' => __( 'Hình ảnh', 'flatsome' ),
                'default' => '',
            ),
            'description' => array(
                'type'    => 'textarea',
                'heading' => __( 'Mô tả ngắn', 'flatsome' ),
                'default' => '',
            ),
            'class'       => array(
                'type'    => 'textfield',
                'heading' => __( 'Custom Class', 'flatsome' ),
                'default' => '',
            ),
        ),
    ) );

    // Đăng ký Challenge Item
    add_ux_builder_shortcode( 'nts_project_challenge_item', array(
        'name'      => __( 'Challenge Item', 'flatsome' ),
        'category'  => __( 'Content', 'flatsome' ),
        'thumbnail' => get_stylesheet_directory_uri() . '/assets/image/nts-challenge-item-thumb.jpg',
        'nested'    => true, // Cho phép nested trong container
        'options'   => array(
            'text' => array(
                'type'    => 'textfield',
                'heading' => __( 'Nội dung', 'flatsome' ),
                'default' => '',
            ),
        ),
    ) );
    }

// Shortcode hiển thị Container
function nts_project_challenge_shortcode($atts, $content = null)
    {
    extract( shortcode_atts( array(
        'image'       => '',
        'description' => '',
        'class'       => '',
    ), $atts ) );

    ob_start(); ?>

    <div class="nts-project-challenge <?php echo esc_attr( $class ); ?>">

        <div class="row">
            <div class="col medium-7 small-12 large-7">
                <div class="challenge-content">
                    <h2 class="challenge-title">Thử thách của dự án</h2>
                    <?php if ( !empty($description) ) : ?>
                        <div class="challenge-description">
                            <?php echo wpautop( do_shortcode( $description ) ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( !empty($content) ) : ?>
                        <div class="challenge-items">
                            <?php echo do_shortcode( $content ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col medium-5 small-12 large-5">
                <?php if ( !empty($image) ) : ?>
                    <div class="challenge-image">
                        <?php echo wp_get_attachment_image( $image, 'large' ); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <?php return ob_get_clean();
    }
add_shortcode( 'nts_project_challenge', 'nts_project_challenge_shortcode' );

// Shortcode hiển thị Item
function nts_project_challenge_item_shortcode($atts)
    {
    extract( shortcode_atts( array(
        'text' => '',
    ), $atts ) );

    ob_start(); ?>

    <div class="challenge-item">
    <i class="fa-solid fa-xmark"></i>
        <div class="item-text"><?php echo esc_html( $text ); ?></div>
    </div>

    <?php return ob_get_clean();
    }
add_shortcode( 'nts_project_challenge_item', 'nts_project_challenge_item_shortcode' );