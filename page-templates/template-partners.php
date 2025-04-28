<?php
/**
 * Template Name: Đối tác
 *
 * @package Flatsome
 */

get_header();
?>

<?php include_once(get_stylesheet_directory() . '/assets/svg/water-elements.svg'); ?>

<div id="content" class="content-area page-wrapper" role="main">
    <!-- Hero Section with Dynamic Background -->
    <div class="partners-hero">
        <div class="hero-background">
            <div class="wave-container">
                <svg class="wave" preserveAspectRatio="none" viewBox="0 0 1440 320">
                    <use xlink:href="#water-wave-animated" class="wave-path"></use>
                </svg>
            </div>
            <div class="bubbles-container">
                <div class="bubble bubble-1"></div>
                <div class="bubble bubble-2"></div>
                <div class="bubble bubble-3"></div>
                <div class="bubble bubble-4"></div>
                <div class="bubble bubble-5"></div>
                <div class="bubble bubble-6"></div>
            </div>
        </div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo get_the_title(); ?></h1>
                <div class="hero-description">
                    <p>Hợp tác cùng các đối tác hàng đầu trong lĩnh vực xử lý nước và công nghệ môi trường</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-main">
        <div class="large-12 col">
            <div class="col-inner partners-section">
                <!-- Decorative Elements -->
                <div class="decorative-icon icon-top-left">
                    <svg width="40" height="40" viewBox="0 0 24 24">
                        <use xlink:href="#water-drop"></use>
                    </svg>
                </div>
                <div class="decorative-icon icon-top-right">
                    <svg width="40" height="40" viewBox="0 0 24 24">
                        <use xlink:href="#water-treatment"></use>
                    </svg>
                </div>
                <div class="decorative-pattern pattern-left">
                    <svg width="100" height="200" viewBox="0 0 100 100">
                        <use xlink:href="#hexagon-grid"></use>
                    </svg>
                </div>
                <div class="decorative-pattern pattern-right">
                    <svg width="100" height="200" viewBox="0 0 100 100">
                        <use xlink:href="#bubbles-pattern"></use>
                    </svg>
                </div>
                <?php
                // Get the partners data
                $partners = get_option('nts_partners', []);

                // Check if we have partners
                if (!empty($partners)) {
                    // Get the current filter type from URL parameter
                    $current_type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';

                    // Filter partners if a type is selected
                    $filtered_partners = !empty($current_type)
                        ? array_filter($partners, fn($partner) => $partner['type'] === $current_type)
                        : $partners;

                    // Partner type labels
                    $type_labels = [
                        'product' => 'Đối tác cung ứng sản phẩm',
                        'software' => 'Đối tác phần mềm',
                        'project' => 'Đối tác dự án'
                    ];
                    ?>

                    <div class="partners-filter-section">
                        <div class="section-header">
                            <h2 class="section-title">Danh mục đối tác</h2>
                            <div class="title-decoration">
                                <span class="line"></span>
                                <svg class="icon" width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#water-drop"></use>
                                </svg>
                                <span class="line"></span>
                            </div>
                        </div>

                        <div class="filter-tabs">
                            <div class="tab-container">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="tab-item <?php echo empty($current_type) ? 'active' : ''; ?>">
                                    <div class="tab-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24">
                                            <path d="M3,5H9V11H3V5M5,7V9H7V7H5M11,7H21V9H11V7M11,15H21V17H11V15M5,13V15H7V13H5M3,13H9V19H3V13Z" fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <span>Tất cả</span>
                                </a>

                                <a href="<?php echo esc_url(add_query_arg('type', 'product', get_permalink())); ?>" class="tab-item <?php echo $current_type === 'product' ? 'active' : ''; ?>">
                                    <div class="tab-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24">
                                            <use xlink:href="#water-filter"></use>
                                        </svg>
                                    </div>
                                    <span><?php echo esc_html($type_labels['product']); ?></span>
                                </a>

                                <a href="<?php echo esc_url(add_query_arg('type', 'software', get_permalink())); ?>" class="tab-item <?php echo $current_type === 'software' ? 'active' : ''; ?>">
                                    <div class="tab-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24">
                                            <path d="M20.5,11H19V7C19,5.89 18.1,5 17,5H13V3.5A2.5,2.5 0 0,0 10.5,1A2.5,2.5 0 0,0 8,3.5V5H4A2,2 0 0,0 2,7V10.8H3.5C5,10.8 6.2,12 6.2,13.5C6.2,15 5,16.2 3.5,16.2H2V20A2,2 0 0,0 4,22H7.8V20.5C7.8,19 9,17.8 10.5,17.8C12,17.8 13.2,19 13.2,20.5V22H17A2,2 0 0,0 19,20V16H20.5A2.5,2.5 0 0,0 23,13.5A2.5,2.5 0 0,0 20.5,11Z" fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <span><?php echo esc_html($type_labels['software']); ?></span>
                                </a>

                                <a href="<?php echo esc_url(add_query_arg('type', 'project', get_permalink())); ?>" class="tab-item <?php echo $current_type === 'project' ? 'active' : ''; ?>">
                                    <div class="tab-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24">
                                            <use xlink:href="#water-pump"></use>
                                        </svg>
                                    </div>
                                    <span><?php echo esc_html($type_labels['project']); ?></span>
                                </a>
                            </div>

                            <div class="tab-indicator"></div>
                        </div>
                    </div>

                    <div class="partners-grid-container">
                        <div class="partners-grid">
                            <?php
                            $i = 0;
                            foreach ($filtered_partners as $partner) :
                                $animation_order = $i++;
                                $type_icon = '';
                                switch($partner['type']) {
                                    case 'product':
                                        $type_icon = '#water-filter';
                                        break;
                                    case 'software':
                                        $type_icon = '#molecule-pattern';
                                        break;
                                    case 'project':
                                        $type_icon = '#water-pump';
                                        break;
                                }
                            ?>
                                <div class="partner-card" style="--animation-order: <?php echo $animation_order; ?>">
                                    <div class="card-inner">
                                        <div class="card-front">
                                            <div class="partner-logo">
                                                <?php if (!empty($partner['logo'])) : ?>
                                                    <img src="<?php echo esc_url($partner['logo']); ?>" alt="<?php echo esc_attr($partner['name']); ?>" />
                                                <?php endif; ?>
                                            </div>
                                            <div class="partner-header">
                                                <h3 class="partner-name"><?php echo esc_html($partner['name']); ?></h3>
                                                <?php if (!empty($partner['type'])) : ?>
                                                    <div class="partner-type">
                                                        <span class="partner-type-label">
                                                            <svg class="type-icon" width="16" height="16" viewBox="0 0 24 24">
                                                                <use xlink:href="<?php echo $type_icon; ?>"></use>
                                                            </svg>
                                                            <?php echo esc_html($type_labels[$partner['type']] ?? ''); ?>
                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-overlay">
                                                <div class="overlay-icon">
                                                    <svg width="24" height="24" viewBox="0 0 24 24">
                                                        <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z" fill="currentColor"/>
                                                    </svg>
                                                </div>
                                                <span>Xem chi tiết</span>
                                            </div>
                                        </div>
                                        <div class="card-back">
                                            <div class="back-header">
                                                <h3 class="partner-name"><?php echo esc_html($partner['name']); ?></h3>
                                                <div class="back-close">
                                                    <svg width="20" height="20" viewBox="0 0 24 24">
                                                        <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" fill="currentColor"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <?php if (!empty($partner['description'])) : ?>
                                                <div class="partner-description">
                                                    <?php echo wpautop(esc_html($partner['description'])); ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($partner['website'])) : ?>
                                                <div class="partner-website">
                                                    <a href="<?php echo esc_url($partner['website']); ?>" target="_blank" rel="noopener noreferrer">
                                                        <svg class="website-icon" width="16" height="16" viewBox="0 0 24 24">
                                                            <path d="M16.36,14C16.44,13.34 16.5,12.68 16.5,12C16.5,11.32 16.44,10.66 16.36,10H19.74C19.9,10.64 20,11.31 20,12C20,12.69 19.9,13.36 19.74,14M14.59,19.56C15.19,18.45 15.65,17.25 15.97,16H18.92C17.96,17.65 16.43,18.93 14.59,19.56M14.34,14H9.66C9.56,13.34 9.5,12.68 9.5,12C9.5,11.32 9.56,10.65 9.66,10H14.34C14.43,10.65 14.5,11.32 14.5,12C14.5,12.68 14.43,13.34 14.34,14M12,19.96C11.17,18.76 10.5,17.43 10.09,16H13.91C13.5,17.43 12.83,18.76 12,19.96M8,8H5.08C6.03,6.34 7.57,5.06 9.4,4.44C8.8,5.55 8.35,6.75 8,8M5.08,16H8C8.35,17.25 8.8,18.45 9.4,19.56C7.57,18.93 6.03,17.65 5.08,16M4.26,14C4.1,13.36 4,12.69 4,12C4,11.31 4.1,10.64 4.26,10H7.64C7.56,10.66 7.5,11.32 7.5,12C7.5,12.68 7.56,13.34 7.64,14M12,4.03C12.83,5.23 13.5,6.57 13.91,8H10.09C10.5,6.57 11.17,5.23 12,4.03M18.92,8H15.97C15.65,6.75 15.19,5.55 14.59,4.44C16.43,5.07 17.96,6.34 18.92,8M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" fill="currentColor"/>
                                                        </svg>
                                                        <span><?php echo esc_html($partner['website']); ?></span>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="back-decoration">
                                                <svg width="60" height="60" viewBox="0 0 100 100" class="decoration-svg">
                                                    <use xlink:href="<?php echo $type_icon; ?>"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Decorative Flow Pattern -->
                        <div class="flow-pattern">
                            <svg width="100%" height="20" viewBox="0 0 100 20" preserveAspectRatio="none">
                                <use xlink:href="#water-flow" class="flow-path"></use>
                            </svg>
                        </div>
                    </div>

                    <?php if (empty($filtered_partners)) : ?>
                        <div class="no-partners">
                            <div class="no-data-icon">
                                <svg width="60" height="60" viewBox="0 0 24 24">
                                    <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12,10.5A1.5,1.5 0 0,0 10.5,12A1.5,1.5 0 0,0 12,13.5A1.5,1.5 0 0,0 13.5,12A1.5,1.5 0 0,0 12,10.5M7.5,10.5A1.5,1.5 0 0,0 6,12A1.5,1.5 0 0,0 7.5,13.5A1.5,1.5 0 0,0 9,12A1.5,1.5 0 0,0 7.5,10.5M16.5,10.5A1.5,1.5 0 0,0 15,12A1.5,1.5 0 0,0 16.5,13.5A1.5,1.5 0 0,0 18,12A1.5,1.5 0 0,0 16.5,10.5Z" fill="currentColor"/>
                                </svg>
                            </div>
                            <p>Không tìm thấy đối tác nào trong danh mục này.</p>
                            <div class="water-drops">
                                <span class="drop drop-1"></span>
                                <span class="drop drop-2"></span>
                                <span class="drop drop-3"></span>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php } else { ?>
                    <div class="no-partners">
                        <div class="no-data-icon">
                            <svg width="60" height="60" viewBox="0 0 24 24">
                                <path d="M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M19,5V19H5V5H19Z" fill="currentColor"/>
                                <path d="M12,12A3,3 0 0,0 9,15A3,3 0 0,0 12,18A3,3 0 0,0 15,15A3,3 0 0,0 12,12Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <p>Chưa có đối tác nào được thêm vào.</p>
                        <div class="water-drops">
                            <span class="drop drop-1"></span>
                            <span class="drop drop-2"></span>
                            <span class="drop drop-3"></span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
