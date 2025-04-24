<?php

add_action( 'ux_builder_setup', 'nts_register_nts_mask_element' );
function nts_register_nts_mask_element()
    {
    add_ux_builder_shortcode( 'nts_mask', array(
        'name'     => 'NTS Mask',
        'category' => 'NTS Elements',
        'options'  => array(
            'mask_version' => array(
                'type'    => 'select',
                'heading' => 'Mask version',
                'default' => '1',
                'options' => array(
                    '1' => 'Version 1',
                    '2' => 'Version 2',
                    '3' => 'Version 3',
                    '4' => 'Version 4',
                    '5' => 'Version 5',
                ),
            ),
            'image'        => array(
                'type'    => 'image',
                'heading' => 'Image',
                'default' => '',
            ),
        )
    ) );
    }


function nts_mask_shortcode($atts, $content = null)
    {
    $atts = shortcode_atts( array(
        'mask_version' => '1',
        'image'        => '',
    ), $atts, 'nts_mask' );

    $image   = ( $atts['image'] );
    $image_url = wp_get_attachment_image_url( $image, 'full' );
    $version = $atts['mask_version'];

    ob_start();

    if ( $version === '1' && $image ) :
        ?>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 697 662" fill="none">
            <g style="mix-blend-mode:multiply">
                <path
                    d="M-256.263 4.24387C-377.935 -19.3817 -495.268 58.0196 -518.891 177.085C-541.624 296.324 -461.703 412.026 -340.03 435.652C-272.956 448.676 -207.264 431.149 -157.788 392.809C-154.42 390.183 -151.07 387.216 -147.833 384.396C42.6163 229.588 48.0963 482.332 162.596 576.233C204.972 615.584 258.779 644.117 320.101 656.025C491.756 689.355 657.401 580.033 690.531 412.007C722.787 243.726 609.978 80.5041 438.324 47.1734C377.001 35.2662 316.442 41.5083 262.419 62.142C121.033 106.273 21.4304 338.696 -97.2287 123.784C-99.1756 119.957 -101.188 116.033 -103.393 112.24C-134.829 58.1054 -189.189 17.2678 -256.263 4.24387Z"
                    fill="url(#pattern-nts-mask)">
                </path>
            </g>
            <defs>
                <pattern id="pattern-nts-mask" patternContentUnits="objectBoundingBox" width="1" height="1">
                    <use xlink:href="#image-nts-mask" transform="matrix(0.000277778 0 0 0.000511403 0.307707 -0.113684)"></use>
                </pattern>
                <image id="image-nts-mask" width="3600" height="2400" xlink:href="<?php echo $image_url; ?>"></image>
            </defs>
        </svg>
        <?php
    endif;

    return ob_get_clean();
    }
add_shortcode( 'nts_mask', 'nts_mask_shortcode' );
