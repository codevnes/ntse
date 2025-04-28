<?php
// Đăng ký Element "NTS Project Images" cho Flatsome UX Builder
add_action( 'ux_builder_setup', 'nts_register_project_images_element' );

function nts_register_project_images_element()
    {
    add_ux_builder_shortcode( 'nts_project_images', array(
        'name'     => 'NTS Project Images',
        'category' => 'NTS Elements',
        'options'  => array(
            'ids' => array(
                'type'    => 'gallery',
                'heading' => __( 'Images' ),
            ),
        )
    ) );

    }
function nts_project_images_shortcode($atts, $content = null)
    {
    $atts = shortcode_atts( array(
        'ids' => '',
    ), $atts, 'nts_project_images' );

    $image_ids = explode( ',', $atts['ids'] );
    if ( empty($image_ids) ) return '';

    ob_start();
    ?>

    <div class="nts-project-images">
        <!-- Main Swiper -->
        <div class="swiper main-swiper">
            <div class="swiper-wrapper">
                <?php foreach ( $image_ids as $id ) :
                    $img = wp_get_attachment_image_url( $id, 'large' ); ?>
                    <div class="swiper-slide">
                        <img src="<?php echo esc_url( $img ); ?>" alt="Project Image" />
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Thumbnail Swiper -->
        <div class="swiper thumb-swiper">
            <div class="swiper-wrapper">
                <?php foreach ( $image_ids as $id ) :
                    $thumb = wp_get_attachment_image_url( $id, 'thumbnail' ); ?>
                    <div class="swiper-slide">
                        <img src="<?php echo esc_url( $thumb ); ?>" alt="Thumb" />
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="swiper-actions">
            <div class="swiper-prev">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="swiper-pagination dark"></div>
            <div class="swiper-next">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const thumbSwiper = new Swiper('.thumb-swiper', {
                spaceBetween: 10,
                slidesPerView: 5,
                watchSlidesProgress: true,
            });

            const mainSwiper = new Swiper('.main-swiper', {
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-next',
                    prevEl: '.swiper-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                thumbs: {
                    swiper: thumbSwiper,
                },
            });
        });
    </script>

    <style>
        .nts-project-images {
            max-width: 800px;
            margin: auto;
        }

        .main-swiper .swiper-slide img {
            width: 100%;
            border-radius: 12px;
            object-fit: cover;
            aspect-ratio: 16/9;
        }

        .thumb-swiper {
            margin-top: 10px;
        }

        .thumb-swiper .swiper-slide {
            cursor: pointer;
            opacity: 0.6;
        }

        .thumb-swiper .swiper-slide-thumb-active {
            opacity: 1;
        }

        .thumb-swiper .swiper-slide img {
            width: 100%;
            border-radius: 8px;
            object-fit: cover;
            aspect-ratio: 16/9;
        }
    </style>
    <?php
    return ob_get_clean();
    }
add_shortcode( 'nts_project_images', 'nts_project_images_shortcode' );
