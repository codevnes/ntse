<div class="nts-offcanvas-menu">
    <div class="container">
        <div class="offcanvas__header">
            <div class="offcanvas__header__logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="/wp-content/uploads/2025/04/logo-fullwidth.webp" alt="Logo NTS">
                </a>
            </div>
            <div class="offcanvas__header__close">
                <span class="fa fa-close"></span>
            </div>
        </div>

        <div class="row">
            <div class="col large-4 medium-12 small-12"></div>
            <div class="col large-8 medium-12 small-12">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'nts-nav-menu',
                ) );
                ?>
            </div>
        </div>
    </div>
</div>