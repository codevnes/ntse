<?php
/**
 * Partners Shortcode
 *
 * Usage: [partners type="product" columns="3" limit="6"]
 */

// Register the partners shortcode
add_shortcode('partners', 'nts_partners_display_shortcode');

function nts_partners_display_shortcode($atts) {
    // Default attributes
    $atts = shortcode_atts([
        'type' => '',       // Filter by partner type (product, software, project)
        'columns' => 3,     // Number of columns
        'limit' => -1,      // Number of partners to display (-1 for all)
    ], $atts);

    // Get partners data
    $partners = get_option('nts_partners', []);

    // Filter by type if specified
    if (!empty($atts['type'])) {
        $partners = array_filter($partners, function($partner) use ($atts) {
            return $partner['type'] === $atts['type'];
        });
    }

    // Limit the number of partners if specified
    if ($atts['limit'] > 0 && count($partners) > $atts['limit']) {
        $partners = array_slice($partners, 0, $atts['limit']);
    }

    // Partner type labels
    $type_labels = [
        'product' => 'Đối tác cung ứng sản phẩm',
        'software' => 'Đối tác phần mềm',
        'project' => 'Đối tác dự án'
    ];

    // Determine column class based on number of columns
    $column_class = 'medium-4'; // Default for 3 columns
    switch ((int)$atts['columns']) {
        case 1:
            $column_class = 'medium-12';
            break;
        case 2:
            $column_class = 'medium-6';
            break;
        case 4:
            $column_class = 'medium-3';
            break;
        case 6:
            $column_class = 'medium-2';
            break;
    }

    // Start output buffer
    ob_start();

    if (!empty($partners)) {
        ?>
        <div class="row row-small partners-shortcode">
            <?php
            $i = 0;
            foreach ($partners as $partner) :
                $animation_order = $i++;
            ?>
                <div class="col <?php echo esc_attr($column_class); ?> col-partners">
                    <div class="col-inner">
                        <div class="partner-item" style="--animation-order: <?php echo $animation_order; ?>">
                            <div class="partner-logo">
                                <?php if (!empty($partner['logo'])) : ?>
                                    <img src="<?php echo esc_url($partner['logo']); ?>" alt="<?php echo esc_attr($partner['name']); ?>" />
                                <?php endif; ?>
                            </div>
                            <div class="partner-content">
                                <h3 class="partner-name"><?php echo esc_html($partner['name']); ?></h3>
                                <?php if (!empty($partner['type'])) : ?>
                                    <div class="partner-type">
                                        <span class="partner-type-label"><?php echo esc_html($type_labels[$partner['type']] ?? ''); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($partner['description'])) : ?>
                                    <div class="partner-description">
                                        <?php echo wpautop(esc_html($partner['description'])); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($partner['website'])) : ?>
                                    <div class="partner-website">
                                        <a href="<?php echo esc_url($partner['website']); ?>" target="_blank" rel="noopener noreferrer">
                                            <i class="fa fa-globe"></i> <?php echo esc_html($partner['website']); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <style>
            /* Using the color variables from main.scss */
            .partners-shortcode {
                position: relative;
                overflow: hidden;
            }

            .partners-shortcode .partner-item {
                border: 1px solid rgba(var(--primary), 0.1);
                border-radius: 12px;
                overflow: hidden;
                transition: all 0.4s ease;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                background: white;
                position: relative;
                height: 100%;
                display: flex;
                flex-direction: column;
                margin-bottom: 20px;
                animation-duration: 1.5s;
                animation-fill-mode: both;
                animation-name: fadeInUp;
                animation-delay: calc(0.1s * var(--animation-order, 0));
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translate3d(0, 30px, 0);
                }
                to {
                    opacity: 1;
                    transform: translate3d(0, 0, 0);
                }
            }

            .partners-shortcode .partner-item:hover {
                transform: translateY(-8px);
                box-shadow: 0 15px 30px rgba(var(--primary), 0.1);
                border-color: rgba(var(--primary), 0.2);
            }

            /* Water drop effect on hover */
            .partners-shortcode .partner-item::before {
                content: '';
                position: absolute;
                top: -20px;
                left: 50%;
                transform: translateX(-50%);
                width: 40px;
                height: 40px;
                background: radial-gradient(circle, rgba(var(--primary-light), 0.3) 0%, rgba(var(--primary-light), 0) 70%);
                border-radius: 50%;
                opacity: 0;
                transition: all 0.5s ease;
            }

            .partners-shortcode .partner-item:hover::before {
                opacity: 1;
                top: -10px;
                animation: water-drop 1.5s ease-out;
            }

            @keyframes water-drop {
                0% { transform: translateX(-50%) scale(0.3); opacity: 0.8; }
                100% { transform: translateX(-50%) scale(2); opacity: 0; }
            }

            .partners-shortcode .partner-logo {
                height: 160px;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: rgba(var(--primary-lighter), 0.03);
                padding: 25px;
                border-bottom: 1px solid rgba(var(--primary), 0.05);
                position: relative;
                overflow: hidden;
            }

            /* Water ripple effect */
            .partners-shortcode .partner-logo::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                background: radial-gradient(circle, rgba(var(--primary), 0.1) 0%, rgba(var(--primary), 0) 70%);
                border-radius: 50%;
                transform: translate(-50%, -50%);
                transition: all 0.5s ease;
                opacity: 0;
            }

            .partners-shortcode .partner-item:hover .partner-logo::after {
                width: 200%;
                height: 200%;
                opacity: 1;
            }

            .partners-shortcode .partner-logo img {
                max-width: 85%;
                max-height: 85%;
                object-fit: contain;
                transition: all 0.4s ease;
                filter: saturate(0.9);
            }

            .partners-shortcode .partner-item:hover .partner-logo img {
                transform: scale(1.05);
                filter: saturate(1.1);
            }

            .partners-shortcode .partner-content {
                padding: 25px;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }

            .partners-shortcode .partner-name {
                margin: 0 0 12px;
                font-size: 20px;
                font-weight: bold;
                color: var(--primary);
                transition: all 0.3s ease;
            }

            .partners-shortcode .partner-item:hover .partner-name {
                color: var(--primary-dark);
            }

            .partners-shortcode .partner-type {
                margin-bottom: 15px;
            }

            .partners-shortcode .partner-type-label {
                display: inline-block;
                padding: 4px 10px;
                background-color: rgba(var(--secondary), 0.1);
                color: var(--secondary);
                border-radius: 20px;
                font-size: 13px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .partners-shortcode .partner-item:hover .partner-type-label {
                background-color: rgba(var(--secondary), 0.15);
            }

            .partners-shortcode .partner-description {
                margin-bottom: 20px;
                color: #555;
                font-size: 15px;
                line-height: 1.6;
                flex-grow: 1;
            }

            .partners-shortcode .partner-website {
                font-size: 14px;
                margin-top: auto;
                padding-top: 15px;
                border-top: 1px dashed rgba(var(--primary), 0.1);
            }

            .partners-shortcode .partner-website a {
                color: var(--primary);
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                transition: all 0.3s ease;
                font-weight: 500;
            }

            .partners-shortcode .partner-website a i {
                margin-right: 8px;
                transition: all 0.3s ease;
            }

            .partners-shortcode .partner-website a:hover {
                color: var(--secondary);
            }

            .partners-shortcode .partner-website a:hover i {
                transform: translateX(3px);
            }

            @media (max-width: 768px) {
                .partners-shortcode .col-partners {
                    flex-basis: 50%;
                    max-width: 50%;
                }
            }

            @media (max-width: 480px) {
                .partners-shortcode .col-partners {
                    flex-basis: 100%;
                    max-width: 100%;
                }
            }
        </style>
        <?php
    } else {
        echo '<p>Chưa có đối tác nào được thêm vào.</p>';
    }

    // Return the output buffer content
    return ob_get_clean();
}
