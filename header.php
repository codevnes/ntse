<?php
/**
 * Header template for NTS Water Treatment theme.
 *
 * @package NTSE
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php do_action( 'flatsome_after_body_open' ); ?>
    <?php wp_body_open(); ?>

    <a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'flatsome' ); ?></a>
    <div id="wrapper">

        <?php do_action( 'flatsome_before_header' ); ?>


        <header id="masthead" class="site-header water-header">
            <?php include_once(get_stylesheet_directory() . '/assets/svg/water-elements.svg'); ?>

            <!-- Water-themed decorative elements -->
            <div class="header-water-bg">
                <div class="water-ripple-effect"></div>

                <div class="bubbles-container">
                    <div class="bubble bubble-1"></div>
                    <div class="bubble bubble-2"></div>
                    <div class="bubble bubble-3"></div>
                </div>

                <svg class="header-wave" viewBox="0 0 1440 120" preserveAspectRatio="none">
                    <path fill="rgba(var(--primary-rgb), 0.05)"
                        d="M0,32L48,37.3C96,43,192,53,288,58.7C384,64,480,64,576,74.7C672,85,768,107,864,112C960,117,1056,107,1152,96C1248,85,1344,75,1392,69.3L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z">
                    </path>
                </svg>

                <svg class="header-wave header-wave-2" viewBox="0 0 1440 120" preserveAspectRatio="none">
                    <path fill="rgba(var(--primary-rgb), 0.03)"
                        d="M0,0L48,5.3C96,11,192,21,288,21.3C384,21,480,11,576,16C672,21,768,43,864,53.3C960,64,1056,64,1152,53.3C1248,43,1344,21,1392,10.7L1440,0L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z">
                    </path>
                </svg>
            </div>

            <div class="header-inner container">
                <div class="header-row">
                    <!-- Logo -->
                    <div class="site-branding">
                        <?php
                        // Get logo settings from theme mods
                        $site_logo_id        = get_theme_mod( 'site_logo', get_template_directory_uri() . '/assets/image/logo.png' );
                        $site_logo_sticky_id = get_theme_mod( 'site_logo_sticky', '' );
                        $site_logo_dark_id   = get_theme_mod( 'site_logo_dark', '' );
                        $site_logo           = wp_get_attachment_image_src( $site_logo_id, 'large' );
                        $site_logo_sticky    = wp_get_attachment_image_src( $site_logo_sticky_id, 'large' );
                        $site_logo_dark      = wp_get_attachment_image_src( $site_logo_dark_id, 'large' );
                        $logo_link           = get_theme_mod( 'logo_link' );
                        $logo_link           = $logo_link ? $logo_link : home_url( '/' );
                        $width               = get_theme_mod( 'logo_width', 200 );
                        $height              = get_theme_mod( 'header_height', 90 );

                        // Handle non-numeric logo IDs (default values)
                        if ( !empty($site_logo_id) && !is_numeric( $site_logo_id ) ) {
                            $site_logo = array( $site_logo_id, $width, $height );
                            }

                        if ( !empty($site_logo_sticky_id) && !is_numeric( $site_logo_sticky_id ) ) {
                            $site_logo_sticky = array( $site_logo_sticky_id, $width, $height );
                            }

                        if ( !empty($site_logo_dark_id) && !is_numeric( $site_logo_dark_id ) ) {
                            $site_logo_dark = array( $site_logo_dark_id, $width, $height );
                            }
                        ?>
                        <a href="<?php echo esc_url( $logo_link ); ?>"
                            title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?><?php echo get_bloginfo( 'name' ) && get_bloginfo( 'description' ) ? ' - ' : ''; ?><?php bloginfo( 'description' ); ?>"
                            rel="home" class="custom-logo-link">
                            <?php
                            if ( $site_logo ) {
                                $site_title = esc_attr( get_bloginfo( 'name', 'display' ) );
                                if ( $site_logo_sticky ) echo '<img width="' . esc_attr( $site_logo_sticky[1] ) . '" height="' . esc_attr( $site_logo_sticky[2] ) . '" src="' . esc_url( $site_logo_sticky[0] ) . '" class="header-logo-sticky" alt="' . $site_title . '"/>';
                                echo '<img width="' . esc_attr( $site_logo[1] ) . '" height="' . esc_attr( $site_logo[2] ) . '" src="' . esc_url( $site_logo[0] ) . '" class="header_logo header-logo custom-logo" alt="' . $site_title . '"/>';
                                if ( $site_logo_dark ) echo '<img width="' . esc_attr( $site_logo_dark[1] ) . '" height="' . esc_attr( $site_logo_dark[2] ) . '" src="' . esc_url( $site_logo_dark[0] ) . '" class="header-logo-dark" alt="' . $site_title . '"/>';
                                else echo '<img width="' . esc_attr( $site_logo[1] ) . '" height="' . esc_attr( $site_logo[2] ) . '" src="' . esc_url( $site_logo[0] ) . '" class="header-logo-dark" alt="' . $site_title . '"/>';
                                } else {
                                ?>
                                <svg class="water-logo" width="50" height="50">
                                    <use xlink:href="#water-droplet-logo"></use>
                                </svg>
                                <h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
                                <?php
                                }
                            ?>
                        </a>
                        <?php
                        if ( get_theme_mod( 'site_logo_slogan' ) ) {
                            echo '<p class="logo-tagline">' . get_bloginfo( 'description' ) . '</p>';
                            }
                        ?>
                    </div>

                    <!-- Search Form with Water Effect -->
                    <div class="header-search">
                        <form role="search" method="get" class="water-search-form"
                            action="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <div class="search-input-wrapper">
                                <input type="search" class="search-field"
                                    placeholder="<?php echo esc_attr_x( 'Tìm kiếm...', 'placeholder', 'ntse' ); ?>"
                                    value="<?php echo get_search_query(); ?>" name="s" />
                                <button type="submit" class="search-submit">
                                    <svg class="search-icon" width="16" height="16">
                                        <use xlink:href="#search-icon"></use>
                                    </svg>
                                </button>
                                <div class="search-ripple"></div>
                            </div>
                        </form>
                    </div>

                    <!-- Offcanvas Menu Button -->
                    <div class="header-actions">
                        <button id="menu-toggle" class="menu-toggle-btn" aria-controls="primary-menu"
                            aria-expanded="false">
                            <div class="water-droplet-icon">
                                <svg width="24" height="24">
                                    <use xlink:href="#water-drop"></use>
                                </svg>
                            </div>
                            <span class="menu-toggle-inner">
                                <span class="menu-line menu-line-1"></span>
                                <span class="menu-line menu-line-2"></span>
                                <span class="menu-line menu-line-3"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Offcanvas Menu -->
            <div id="offcanvas-menu" class="offcanvas-menu">
                <div class="offcanvas-header">
                    <div class="site-branding">
                        <?php
                        // Reuse the same logo code for offcanvas
                        if ( $site_logo ) {
                            $site_title = esc_attr( get_bloginfo( 'name', 'display' ) );
                            echo '<a href="' . esc_url( $logo_link ) . '" rel="home" class="custom-logo-link">';
                            echo '<img width="' . esc_attr( $site_logo[1] ) . '" height="' . esc_attr( $site_logo[2] ) . '" src="' . esc_url( $site_logo[0] ) . '" class="custom-logo" alt="' . $site_title . '"/>';
                            echo '</a>';
                            } else {
                            ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <svg class="water-logo" width="40" height="40">
                                    <use xlink:href="#water-droplet-logo"></use>
                                </svg>
                                <h2 class="site-title"><?php bloginfo( 'name' ); ?></h2>
                            </a>
                        <?php } ?>
                    </div>
                    <button class="offcanvas-close">
                        <span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'ntse' ); ?></span>
                        <span class="close-icon"></span>
                    </button>
                </div>

                <div class="offcanvas-content">
                    <nav id="offcanvas-navigation" class="offcanvas-navigation">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'primary',
                                'menu_id'        => 'primary-menu',
                                'container'      => false,
                                'menu_class'     => 'offcanvas-menu-items',
                                'fallback_cb'    => false,
                            )
                        );
                        ?>
                    </nav>

                    <div class="offcanvas-contact">
                        <h3><?php esc_html_e( 'Liên hệ', 'ntse' ); ?></h3>
                        <ul class="contact-list">
                            <li>
                                <i class="fas fa-phone"></i>
                                <?php 
                                $phone = nts_get_contact_info('phone');
                                if (!empty($phone)) {
                                    $phones = explode(',', $phone);
                                    foreach ($phones as $index => $phone_number) {
                                        if ($index > 0) {
                                            echo '<br>';
                                        }
                                        echo '<a href="tel:' . esc_attr(trim($phone_number)) . '">' . esc_html(trim($phone_number)) . '</a>';
                                    }
                                } else {
                                    echo '<a href="tel:+84123456789">0123 456 789</a>';
                                }
                                ?>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <?php 
                                $email = nts_get_contact_info('email');
                                if (!empty($email)) {
                                    echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
                                } else {
                                    echo '<a href="mailto:info@xulynuoc.com">info@xulynuoc.com</a>';
                                }
                                ?>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <?php 
                                $address = nts_get_contact_info('address');
                                if (!empty($address)) {
                                    echo '<span>' . nl2br(esc_html($address)) . '</span>';
                                } else {
                                    echo '<span>123 Đường ABC, Quận XYZ, TP. HCM</span>';
                                }
                                ?>
                            </li>
                        </ul>

                        <div class="social-links">
                            <?php 
                            $facebook = nts_get_contact_info('facebook');
                            if (!empty($facebook)) {
                                echo '<a href="' . esc_url($facebook) . '" class="social-link" target="_blank"><i class="fab fa-facebook-f"></i></a>';
                            }
                            
                            $youtube = nts_get_contact_info('youtube');
                            if (!empty($youtube)) {
                                echo '<a href="' . esc_url($youtube) . '" class="social-link" target="_blank"><i class="fab fa-youtube"></i></a>';
                            }
                            
                            $instagram = nts_get_contact_info('instagram');
                            if (!empty($instagram)) {
                                echo '<a href="' . esc_url($instagram) . '" class="social-link" target="_blank"><i class="fab fa-instagram"></i></a>';
                            }
                            
                            $linkedin = nts_get_contact_info('linkedin');
                            if (!empty($linkedin)) {
                                echo '<a href="' . esc_url($linkedin) . '" class="social-link" target="_blank"><i class="fab fa-linkedin-in"></i></a>';
                            }
                            
                            // Fallback if no social media links are set
                            if (empty($facebook) && empty($youtube) && empty($instagram) && empty($linkedin)) {
                                echo '<a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>';
                                echo '<a href="#" class="social-link"><i class="fab fa-youtube"></i></a>';
                                echo '<a href="#" class="social-link"><i class="fab fa-instagram"></i></a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="offcanvas-water-decoration">
                    <svg class="water-pattern" width="100%" height="300" preserveAspectRatio="none">
                        <use xlink:href="#water-pattern-bg"></use>
                    </svg>
                    <div class="water-particles-container"></div>
                </div>
            </div>

            <div class="offcanvas-overlay"></div>
        </header><!-- #masthead -->

        <script>
            // This script will be executed when the page loads
            jQuery(document).ready(function ($) {
                // Toggle offcanvas menu
                $('#menu-toggle').on('click', function () {
                    $(this).toggleClass('active');
                    $('#offcanvas-menu').toggleClass('active');
                    $('.offcanvas-overlay').toggleClass('active');
                    $('body').toggleClass('offcanvas-active');

                    // Create water particles in offcanvas menu
                    if ($('#offcanvas-menu').hasClass('active')) {
                        createWaterParticlesForMenu();
                    }
                });

                // Close offcanvas menu
                $('.offcanvas-overlay, .offcanvas-close').on('click', function () {
                    $('#menu-toggle').removeClass('active');
                    $('#offcanvas-menu').removeClass('active');
                    $('.offcanvas-overlay').removeClass('active');
                    $('body').removeClass('offcanvas-active');
                });

                // Create water ripple effect on search input focus
                $('.search-field').on('focus', function () {
                    $(this).closest('.search-input-wrapper').addClass('focused');
                    animateSearchRipple();
                }).on('blur', function () {
                    $(this).closest('.search-input-wrapper').removeClass('focused');
                });

                // Animate search ripple
                function animateSearchRipple() {
                    const ripple = $('.search-ripple');
                    ripple.removeClass('animate');
                    setTimeout(function () {
                        ripple.addClass('animate');
                    }, 10);
                }

                // Create water particles for offcanvas menu
                function createWaterParticlesForMenu() {
                    const container = $('.water-particles-container');
                    container.empty();

                    // Create multiple particles
                    for (let i = 0; i < 15; i++) {
                        createSingleParticle(container);
                    }
                }

                function createSingleParticle(container) {
                    // Random size between 5px and 15px
                    const size = Math.floor(Math.random() * 10) + 5;

                    // Random position
                    const posX = Math.floor(Math.random() * 100);
                    const posY = Math.floor(Math.random() * 100);

                    // Random animation duration between 10s and 20s
                    const duration = Math.floor(Math.random() * 10) + 10;

                    // Create particle element
                    const particle = $('<div class="water-particle"></div>');
                    particle.css({
                        width: size + 'px',
                        height: size + 'px',
                        left: posX + '%',
                        top: posY + '%',
                        animation: `float ${duration}s infinite ease-in-out ${Math.random() * 5}s`
                    });

                    // Add to container
                    container.append(particle);
                }

                // Create header bubbles animation
                function animateHeaderBubbles() {
                    $('.bubble').each(function () {
                        const bubble = $(this);
                        const startPosition = parseInt(bubble.css('bottom'));
                        const duration = parseInt(bubble.css('animation-duration'));

                        setInterval(function () {
                            const newSize = Math.floor(Math.random() * 10) + 10;
                            const newLeft = parseInt(bubble.css('left')) + (Math.random() * 20 - 10);

                            bubble.css({
                                width: newSize + 'px',
                                height: newSize + 'px',
                                left: newLeft + '%'
                            });

                            bubble.removeClass('animate');
                            setTimeout(function () {
                                bubble.addClass('animate');
                            }, 10);
                        }, duration * 1000);
                    });
                }

                // Run bubble animation
                animateHeaderBubbles();
            });
        </script>
	<?php do_action( 'flatsome_after_header' ); ?>

<main id="main" class="<?php flatsome_main_classes(); ?>">
