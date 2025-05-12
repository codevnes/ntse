<?php
// Đăng ký Element "NTS Lịch sử hình thành" cho Flatsome UX Builder
add_action( 'ux_builder_setup', 'nts_register_history_element' );

function nts_register_history_element()
    {
    add_ux_builder_shortcode( 'nts_history', [
        'name'     => __( 'NTS Lịch sử hình thành', 'flatsome' ),
        'category' => __( 'Content', 'flatsome' ),
        'options'  => [

            // Số lượng hiển thị
            'limit'         => [
                'type'    => 'slider',
                'heading' => __( 'Số lượng hiển thị', 'flatsome' ),
                'default' => -1,
                'min'     => -1,
                'max'     => 20,
                'step'    => 1,
            ],
            // Kiểu hiển thị
            'style'         => [
                'type'    => 'select',
                'heading' => __( 'Kiểu hiển thị', 'flatsome' ),
                'default' => 'timeline',
                'options' => [
                    'timeline'     => 'Timeline',
                    'slider'       => 'Slider',
                    'slider_thumb' => 'Slider với Thumbnails',
                ],
            ],
            // Ảnh thumbnail
            'thumb_type'    => [
                'type'       => 'select',
                'heading'    => __( 'Kiểu thumbnail', 'flatsome' ),
                'default'    => 'year',
                'options'    => [
                    'year'  => 'Năm',
                    'image' => 'Hình ảnh',
                    'both'  => 'Năm + Hình ảnh',
                ],
                'conditions' => 'style === "slider_thumb"',
            ],
            // Logo cho thumbnail
            'thumb_logo'    => [
                'type'       => 'image',
                'heading'    => __( 'Logo cho thumbnail', 'flatsome' ),
                'conditions' => 'style === "slider_thumb" && (thumb_type === "image" || thumb_type === "both")',
                'default'    => '',
            ],
            // Hiển thị ảnh
            'show_images'   => [
                'type'    => 'checkbox',
                'heading' => __( 'Hiển thị hình ảnh', 'flatsome' ),
                'default' => 'true',
            ],
            // Màu chủ đạo
            'primary_color' => [
                'type'    => 'colorpicker',
                'heading' => __( 'Màu chủ đạo', 'flatsome' ),
                'default' => '#0073aa',
            ],
            // Custom Class
            'class'         => [
                'type'    => 'textfield',
                'heading' => __( 'Custom CSS Class', 'flatsome' ),
                'default' => 'nts-history',
            ],
        ],
    ] );
    }

// Shortcode hiển thị lịch sử hình thành
function nts_history_shortcode($atts)
    {
    // Xử lý các tham số đầu vào
    $atts = shortcode_atts( [
        'limit'         => -1,
        'style'         => 'timeline',
        'thumb_type'    => 'year',
        'thumb_logo'    => '',
        'show_images'   => 'true',
        'primary_color' => '#0073aa',
        'class'         => 'nts-history'
    ], $atts, 'nts_history' );

    // Lấy danh sách lịch sử từ cơ sở dữ liệu
    $history_items = get_option( 'nts_history', [] );

    // Giới hạn số lượng nếu cần
    if ( $atts['limit'] > 0 && count( $history_items ) > $atts['limit'] ) {
        $history_items = array_slice( $history_items, 0, $atts['limit'] );
        }

    // Nếu không có mục lịch sử nào, trả về thông báo
    if ( empty($history_items) ) {
        return '<div class="no-history">' . __( 'Chưa có mục lịch sử nào được thêm.', 'flatsome' ) . '</div>';
        }

    // Xác định các class cho container
    $classes   = [];
    $classes[] = $atts['class'];
    $classes[] = 'style-' . $atts['style'];

    // Bắt đầu output buffer
    ob_start();
    ?>
    <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
        <?php if ( $atts['style'] === 'timeline' ) : ?>
            <div class="history-timeline">
                <div class="timeline-line" style="background-color: <?php echo esc_attr( $atts['primary_color'] ); ?>"></div>
                <?php foreach ( $history_items as $index => $item ) :
                    $position = $index % 2 === 0 ? 'left' : 'right';
                    ?>
                    <div class="timeline-item <?php echo esc_attr( $position ); ?>">
                        <div class="timeline-dot" style="background-color: <?php echo esc_attr( $atts['primary_color'] ); ?>"></div>
                        <div class="timeline-content">
                            <div class="timeline-year" style="color: <?php echo esc_attr( $atts['primary_color'] ); ?>">
                                <?php echo esc_html( $item['year'] ); ?>
                            </div>

                            <?php if ( $atts['show_images'] === 'true' && !empty($item['image']) ) : ?>
                                <div class="timeline-image">
                                    <img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
                                </div>
                            <?php endif; ?>

                            <h3 class="timeline-title"><?php echo esc_html( $item['title'] ); ?></h3>

                            <?php if ( !empty($item['description']) ) : ?>
                                <div class="timeline-description">
                                    <?php echo wp_kses_post( $item['description'] ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif ( $atts['style'] === 'slider' ) : ?>
            <div class="history-slider slider slider-nav-circle slider-nav-large slider-nav-light slider-style-normal">
                <div class="slider-track">
                    <?php foreach ( $history_items as $item ) : ?>
                        <div class="slide">
                            <div class="history-slide-content">
                                <div class="history-slide-year"">
                                    <?php echo esc_html( $item['year'] ); ?>
                                </div>

                                <?php if ( $atts['show_images'] === 'true' && !empty($item['image']) ) : ?>
                                    <div class="history-slide-image">
                                        <img src="<?php echo esc_url( $item['image'] ); ?>"
                                            alt="<?php echo esc_attr( $item['title'] ); ?>">
                                    </div>
                                <?php endif; ?>

                                <h3 class="history-slide-title"><?php echo esc_html( $item['title'] ); ?></h3>

                                <?php if ( !empty($item['description']) ) : ?>
                                    <div class="history-slide-description">
                                        <?php echo wp_kses_post( $item['description'] ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else : ?>
            <!-- Slider với Thumbnails sử dụng Swiper -->
            <div class="history-slider-with-thumbs">
                <!-- Slider chính -->
                <div class="swiper history-main-slider">
                    <div class="swiper-wrapper">
                        <?php foreach ( $history_items as $item ) : ?>
                            <div class="swiper-slide history-main-slide">
                                <div class="history-slide-content row">
                                    <div class="col large-4 medium-6 small-12">
                                        <?php if ( $atts['show_images'] === 'true' && !empty($item['image']) ) : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                viewBox="0 0 665 688" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M276.799 0.0019709C363.593 0.44379 418.944 83.4264 483.522 141.407C554.355 205.005 657.02 253.197 664.486 348.087C672.163 445.65 592.429 525.549 518.823 590.061C450.8 649.679 367.218 690.569 276.799 687.874C188.833 685.253 107.506 641.59 48.7859 576.053C-6.8162 513.996 -31.299 431.322 -27.6449 348.087C-24.1549 268.59 15.5686 199.194 67.9601 139.292C125.224 73.8189 189.807 -0.440852 276.799 0.0019709Z"
                                                    fill="url(#pattern-0)"></path>
                                                <defs>
                                                    <pattern id="pattern-0" patternContentUnits="objectBoundingBox" width="1"
                                                        height="1">
                                                        <use xlink:href="#image-0"
                                                            transform="matrix(0.000676284 0 0 0.000681199 -0.198263 0)">
                                                        </use>
                                                    </pattern>
                                                    <image id="image-0" width="2065" height="1468"
                                                        xlink:href="<?php echo esc_url( $item['image'] ); ?>">
                                                    </image>
                                                </defs>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col large-8 medium-6 small-12">
                                        <div class="history-slide-year"
                                            style="color: <?php echo esc_attr( $atts['primary_color'] ); ?>">
                                            <?php echo esc_html( $item['year'] ); ?>
                                        </div>

                                        <h3 class="history-slide-title"><?php echo esc_html( $item['title'] ); ?></h3>

                                        <?php if ( !empty($item['description']) ) : ?>
                                            <div class="history-slide-description">
                                                <?php echo wp_kses_post( $item['description'] ); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Điều hướng -->
                    <div class="swiper-button-next" style="color: <?php echo esc_attr( $atts['primary_color'] ); ?>"></div>
                    <div class="swiper-button-prev" style="color: <?php echo esc_attr( $atts['primary_color'] ); ?>"></div>
                </div>

                <!-- Thumbnails -->
                <div class="swiper history-thumb-slider">
                    <div class="swiper-wrapper">
                        <?php foreach ( $history_items as $item ) : ?>
                            <div class="swiper-slide history-thumb">
                                <?php if ( $atts['thumb_type'] === 'year' || $atts['thumb_type'] === 'both' ) : ?>
                                    <div class="thumb-year">
                                        <?php echo esc_html( $item['year'] ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( ($atts['thumb_type'] === 'image' || $atts['thumb_type'] === 'both') && !empty($atts['thumb_logo']) ) :
                                    $logo_url = wp_get_attachment_url( $atts['thumb_logo'] );
                                    if ( $logo_url ) : ?>
                                        <div class="thumb-logo">
                                            <img src="<?php echo esc_url( $logo_url ); ?>" alt="Logo">
                                        </div>


                                    <?php endif;
                                endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <script>
                jQuery(document).ready(function ($) {
                    // Hàm cập nhật đường line tiến trình
                    function updateProgressLine(activeIndex, totalSlides) {
                        // Đảm bảo có ít nhất 2 slide để tránh chia cho 0
                        if (totalSlides <= 1) return;

                        // Tính toán phần trăm hoàn thành
                        var progressPercent = (activeIndex / (totalSlides - 1)) * 100;

                        // Đảm bảo giá trị hợp lệ
                        progressPercent = Math.max(0, Math.min(100, progressPercent));

                        console.log('Progress: ' + progressPercent + '%', 'Active Index: ' + activeIndex, 'Total Slides: ' + totalSlides);

                        // Cập nhật chiều rộng của đường line
                        $('.history-thumb-slider .progress-line').css('width', progressPercent + '%');
                    }
                    // Khởi tạo Swiper Thumbnails
                    var historyThumbs = new Swiper('.history-thumb-slider', {
                        slidesPerView: 3,
                        spaceBetween: 20, // Tăng khoảng cách giữa các thumb
                        watchSlidesProgress: true,
                        slideToClickedSlide: true, // Cho phép click vào thumb để chuyển slide
                        // centeredSlides: true, // Căn giữa slide active
                        loop: false,
                        breakpoints: {
                            // Mobile
                            320: {
                                slidesPerView: 2,
                                spaceBetween: 15
                            },
                           
                            1024: {
                                slidesPerView: 4,
                                spaceBetween: 25
                            }
                        }
                    });

                    // Khởi tạo Swiper chính
                    var historyMain = new Swiper('.history-main-slider', {
                        spaceBetween: 10,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        thumbs: {
                            swiper: historyThumbs,
                            multipleActiveThumbs: false // Chỉ active 1 thumb tại một thời điểm
                        },
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false
                        },
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        },
                        speed: 500, // Tốc độ chuyển slide
                        on: {
                            slideChange: function () {
                                // Đảm bảo thumb active luôn ở giữa
                                historyThumbs.slideTo(historyMain.activeIndex);

                                // Cập nhật đường line tiến trình
                                updateProgressLine(historyMain.activeIndex, historyMain.slides.length);
                            },
                            init: function () {
                                // Khởi tạo đường line tiến trình
                                updateProgressLine(0, historyMain.slides.length);
                            }
                        }
                    });
                });
            </script>
        <?php endif; ?>
    </div>

    <style>
        .<?php echo esc_attr( $atts['class'] ); ?> {
            margin-bottom: 40px;
        }

        .<?php echo esc_attr( $atts['class'] ); ?> .section-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            position: relative;
            overflow: hidden;
        }

        .<?php echo esc_attr( $atts['class'] ); ?> .section-title span {
            display: inline-block;
            position: relative;
        }

        .<?php echo esc_attr( $atts['class'] ); ?> .section-title span:before,
        .<?php echo esc_attr( $atts['class'] ); ?> .section-title span:after {
            content: "";
            position: absolute;
            top: 50%;
            height: 1px;
            width: 100vw;
            background-color: #ddd;
        }

        .<?php echo esc_attr( $atts['class'] ); ?> .section-title span:before {
            right: 100%;
            margin-right: 15px;
        }

        .<?php echo esc_attr( $atts['class'] ); ?> .section-title span:after {
            left: 100%;
            margin-left: 15px;
        }

        /* Timeline Style */
        .history-timeline {
            position: relative;
            padding: 20px 0;
            margin: 0 auto;
            max-width: 1200px;
        }

        .timeline-line {
            position: absolute;
            width: 4px;
            background-color:
                <?php echo esc_attr( $atts['primary_color'] ); ?>
            ;
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -2px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 50px;
            width: 100%;
            box-sizing: border-box;
        }


        .timeline-item .timeline-content {
            position: relative;
            width: 45%;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .timeline-item .timeline-content:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .timeline-item.left .timeline-content {
            float: left;
        }

        .timeline-item.right .timeline-content {
            float: right;
        }

        .timeline-dot {
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color:
                <?php echo esc_attr( $atts['primary_color'] ); ?>
            ;
            top: 20px;
            left: 50%;
            margin-left: -8px;
            z-index: 1;
        }

        .timeline-year {
            display: inline-block;
            padding: 5px 15px;
            background-color: rgba(0, 115, 170, 0.1);
            border-radius: 20px;
            font-weight: bold;
            color:
                <?php echo esc_attr( $atts['primary_color'] ); ?>
            ;
            margin-bottom: 10px;
        }

        .timeline-title {
            margin: 10px 0;
            font-size: 18px;
            color: #333;
        }

        .timeline-description {
            font-size: 14px;
            line-height: 1.5;
            color: #555;
        }

        .timeline-image {
            margin-bottom: 15px;
            border-radius: 4px;
            overflow: hidden;
        }

        .timeline-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Responsive Timeline */
        @media screen and (max-width: 768px) {
            .timeline-line {
                left: 30px;
            }

            .timeline-item .timeline-content {
                width: calc(100% - 60px);
                float: right;
                margin-left: 60px;
            }

            .timeline-dot {
                left: 30px;
            }
        }

        /* Slider Style */
        .history-slider {
            margin-top: 30px;
        }


        .history-slide-year {
            display: inline-block;
            border-radius: 20px;
            font-size: 3.5rem;
            font-weight: bold;
            line-height: 1;
            color: #FFF;
            margin-bottom: 10px;
        }

        .history-slide-image {
            margin-bottom: 15px;
            border-radius: 4px;
            overflow: hidden;
        }

        .history-slide-image img {
            width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: cover;
            display: block;
        }

        .history-slide-title {
            margin: 10px 0;
            font-size: 2.4rem;
            color: #333;
        }


        /* Slider with Thumbnails Style - Swiper */
        .history-slider-with-thumbs {
            margin-top: 30px;
        }

        .history-main-slider {
            margin-bottom: 20px;
        }

        .history-main-slide {
            width: 100%;
        }

        .history-thumb-slider {
            margin-top: 10px;
            margin-bottom: 30px;
            position: relative;
        }

        /* Đường line xuyên qua các thumb */
        .history-thumb-slider:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #ddd;
            opacity: 0.5;
            z-index: 1;
        }


        .history-thumb {
            height: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 2;
            opacity: 0.5;
            padding: 1rem;
            background-color: #fff;
            border-radius: 1rem;
            margin: 0.5rem;
        }

        .history-thumb.swiper-slide-thumb-active {
            opacity: 1;
            transform: scale(1.2);
        }

        .thumb-year {
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            z-index: 2;
            transition: all 0.3s ease;
            color: var(--primary);
        }

        .history-thumb.swiper-slide-thumb-active .thumb-year {
            font-size: 18px;
        }

        .thumb-logo {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.2;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .thumb-logo img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
            transition: all 0.3s ease;
        }

        .history-thumb.swiper-slide-thumb-active .thumb-logo {
            opacity: 0.4;
        }

        .history-thumb.swiper-slide-thumb-active .thumb-logo img {
            max-width: 85%;
            max-height: 85%;
        }

        /* Swiper Navigation */
        .history-main-slider .swiper-button-next,
        .history-main-slider .swiper-button-prev {
            color:
                <?php echo esc_attr( $atts['primary_color'] ); ?>
            ;
        }

        .history-main-slider .swiper-button-next:after,
        .history-main-slider .swiper-button-prev:after {
            font-size: 24px;
        }

        /* Fade effect */
        .history-main-slider .swiper-slide {
            transition: opacity 0.3s ease;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 849px) {

            .history-main-slider .swiper-button-next:after,
            .history-main-slider .swiper-button-prev:after {
                font-size: 20px;
            }
        }

        @media screen and (max-width: 549px) {

            .history-main-slider .swiper-button-next:after,
            .history-main-slider .swiper-button-prev:after {
                font-size: 18px;
            }
        }
    </style>
    <?php
    // Trả về nội dung đã được buffer
    return ob_get_clean();
    }
// Đăng ký shortcode [nts_history]
add_shortcode( 'nts_history', 'nts_history_shortcode' );
