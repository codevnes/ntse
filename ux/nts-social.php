<?php
// Đăng ký Element "NTS Social" cho Flatsome UX Builder
add_action( 'ux_builder_setup', 'nts_register_social_element' );

function nts_register_social_element()
    {
    add_ux_builder_shortcode( 'nts_social', array(
        'name'      => __( 'NTS Social', 'flatsome' ),
        'category'  => __( 'Content', 'flatsome' ),
        'options'   => array(
            // Facebook
            'facebook_url'  => array(
                'type'        => 'textfield',
                'heading'     => __( 'Facebook URL', 'flatsome' ),
                'default'     => '',
                'placeholder' => 'https://facebook.com/username'
            ),
            // Instagram
            'instagram_url' => array(
                'type'        => 'textfield',
                'heading'     => __( 'Instagram URL', 'flatsome' ),
                'default'     => '',
                'placeholder' => 'https://instagram.com/username'
            ),
            // TikTok
            'tiktok_url'    => array(
                'type'        => 'textfield',
                'heading'     => __( 'TikTok URL', 'flatsome' ),
                'default'     => '',
                'placeholder' => 'https://tiktok.com/@username'
            ),
            // YouTube
            'youtube_url'   => array(
                'type'        => 'textfield',
                'heading'     => __( 'YouTube URL', 'flatsome' ),
                'default'     => '',
                'placeholder' => 'https://youtube.com/username'
            ),
            // Custom Class
            'class'         => array(
                'type'    => 'textfield',
                'heading' => __( 'Custom Class', 'flatsome' ),
                'default' => ''
            )
        )
    ) );
    }

// Shortcode hiển thị Social Icons
function nts_social_shortcode($atts)
    {
    extract( shortcode_atts( array(
        'facebook_url'  => '',
        'instagram_url' => '',
        'tiktok_url'    => '',
        'youtube_url'   => '',
        'class'         => ''
    ), $atts ) );

    // Tạo array các social links
    $social_links = array();

    if ( $facebook_url ) $social_links['facebook'] = array(
            'url'  => esc_url( $facebook_url ),
            'icon' => 'facebook-f'
        );

    if ( $instagram_url ) $social_links['instagram'] = array(
            'url'  => esc_url( $instagram_url ),
            'icon' => 'instagram'
        );

    if ( $tiktok_url ) $social_links['tiktok'] = array(
            'url'  => esc_url( $tiktok_url ),
            'icon' => 'tiktok'
        );

    if ( $youtube_url ) $social_links['youtube'] = array(
            'url'  => esc_url( $youtube_url ),
            'icon' => 'youtube'
        );

    ob_start();

    if ( !empty($social_links) ) : ?>
        <div class="nts-social">
            <div class="nts-social-title">
                <?php _e( 'Follow us on', 'flatsome' ); ?>
            </div>
            <div class="nts-social-links">
                <?php foreach ( $social_links as $network => $data ) : ?>
                    <a href="<?php echo $data['url']; ?>" target="_blank" rel="noopener noreferrer"
                        class="nts-social-link social-<?php echo $network; ?>"
                        aria-label="<?php echo ucfirst( $network ); ?>">
                        <i class="fab fa-<?php echo $data['icon']; ?>"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

    <?php endif;

    return ob_get_clean();
    }
add_shortcode( 'nts_social', 'nts_social_shortcode' );