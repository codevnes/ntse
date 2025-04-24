<?php

// Đăng ký Custom Post Type "Dịch vụ" và Danh mục dịch vụ
function nts_register_service_post_type() {
    // Đăng ký Post Type
    $labels = array(
        'name'               => __('Dịch vụ', 'textdomain'),
        'singular_name'      => __('Dịch vụ', 'textdomain'),
        'menu_name'          => __('Dịch vụ', 'textdomain'),
        'all_items'          => __('Tất cả dịch vụ', 'textdomain'),
        'add_new'            => __('Thêm dịch vụ', 'textdomain'),
        'add_new_item'       => __('Thêm dịch vụ mới', 'textdomain'),
        'edit_item'          => __('Sửa dịch vụ', 'textdomain'),
        'new_item'           => __('Dịch vụ mới', 'textdomain'),
        'view_item'          => __('Xem dịch vụ', 'textdomain'),
        'search_items'       => __('Tìm kiếm dịch vụ', 'textdomain'),
        'not_found'          => __('Không tìm thấy dịch vụ', 'textdomain'),
        'not_found_in_trash' => __('Không có dịch vụ trong thùng rác', 'textdomain'),
    );

    $args = array(
        'labels'              => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'dich-vu'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => true, // Cho phép tạo subpages
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-admin-tools',
        'supports'           => array('title', 'thumbnail'), // Removed 'editor' to hide content editor
        'show_in_rest'       => false, // Disable Gutenberg
    );

    register_post_type('service', $args);

    // Đăng ký Taxonomy "Danh mục dịch vụ"
    $taxonomy_labels = array(
        'name'              => __('Danh mục dịch vụ', 'textdomain'),
        'singular_name'     => __('Danh mục', 'textdomain'),
        'search_items'      => __('Tìm danh mục', 'textdomain'),
        'all_items'         => __('Tất cả danh mục', 'textdomain'),
        'parent_item'       => __('Danh mục cha', 'textdomain'),
        'parent_item_colon' => __('Danh mục cha:', 'textdomain'),
        'edit_item'         => __('Sửa danh mục', 'textdomain'),
        'update_item'       => __('Cập nhật danh mục', 'textdomain'),
        'add_new_item'      => __('Thêm danh mục mới', 'textdomain'),
        'new_item_name'     => __('Tên danh mục mới', 'textdomain'),
        'menu_name'         => __('Danh mục', 'textdomain'),
    );

    $taxonomy_args = array(
        'hierarchical'      => true,
        'labels'            => $taxonomy_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'danh-muc-dich-vu'),
        'show_in_rest'      => false, // Disable Gutenberg for taxonomy
    );

    register_taxonomy('service_category', 'service', $taxonomy_args);
}
add_action('init', 'nts_register_service_post_type');

/**
 * Enqueue admin styles for service post type
 */
function nts_service_admin_styles() {
    global $post_type;
    
    // Only enqueue on service post type screens
    if ('service' == $post_type) {
        wp_enqueue_style('service-admin-style', get_template_directory_uri() . '/assets/css/admin-style.css');
        wp_enqueue_script('jquery-ui-sortable');
        
        // Add some inline styles to complement the CSS file
        wp_add_inline_style('service-admin-style', '
            .process-step-header h4 .step-number {
                background: #3a569e;
                color: white;
                padding: 2px 8px;
                border-radius: 50%;
                margin-right: 8px;
                display: inline-block;
                width: 24px;
                height: 24px;
                text-align: center;
                line-height: 20px;
            }
            .process-step-header .dashicons {
                color: #666;
                cursor: pointer;
            }
            .process-step-header .dashicons:hover {
                color: #0073aa;
            }
            .process-step .sortable-handle {
                cursor: move;
                margin-right: 5px;
            }
            .process-controls {
                display: flex;
                justify-content: flex-end;
            }
            .process-controls button {
                margin-left: 10px;
            }
        ');
    }
}
add_action('admin_enqueue_scripts', 'nts_service_admin_styles');

/**
 * Add meta boxes for Service post type
 */
function nts_service_add_meta_boxes() {
    // Hero / Header section
    add_meta_box(
        'nts_service_hero_meta',
        __('Thông tin Hero / Header', 'textdomain'),
        'nts_service_hero_meta_callback',
        'service',
        'normal',
        'high'
    );
    
    // Service Overview
    add_meta_box(
        'nts_service_overview_meta',
        __('Tổng quan dịch vụ', 'textdomain'),
        'nts_service_overview_meta_callback',
        'service',
        'normal',
        'high'
    );
    
    // Service Process
    add_meta_box(
        'nts_service_process_meta',
        __('Quy trình thực hiện', 'textdomain'),
        'nts_service_process_meta_callback',
        'service',
        'normal',
        'high'
    );
    
    // Service Highlights
    add_meta_box(
        'nts_service_highlights_meta',
        __('Điểm nổi bật', 'textdomain'),
        'nts_service_highlights_meta_callback',
        'service',
        'normal',
        'high'
    );
    
    // Testimonials
    add_meta_box(
        'nts_service_testimonials_meta',
        __('Khách hàng đánh giá', 'textdomain'),
        'nts_service_testimonials_meta_callback',
        'service',
        'normal',
        'high'
    );
    
    // FAQ
    add_meta_box(
        'nts_service_faq_meta',
        __('FAQ - Câu hỏi thường gặp', 'textdomain'),
        'nts_service_faq_meta_callback',
        'service',
        'normal',
        'high'
    );
    
    // CTA & Related
    add_meta_box(
        'nts_service_cta_meta',
        __('CTA & Liên quan', 'textdomain'),
        'nts_service_cta_meta_callback',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nts_service_add_meta_boxes');

/**
 * Hero / Header Meta Box Callback
 */
function nts_service_hero_meta_callback($post) {
    wp_nonce_field('nts_service_meta_box', 'nts_service_meta_box_nonce');
    
    $short_description = get_post_meta($post->ID, '_nts_service_short_description', true);
    $cta_text = get_post_meta($post->ID, '_nts_service_cta_text', true);
    $cta_url = get_post_meta($post->ID, '_nts_service_cta_url', true);
    
    // Set default values if empty
    if (empty($cta_text)) {
        $cta_text = __('Liên hệ ngay', 'ntse');
    }
    
    if (empty($cta_url)) {
        $cta_url = home_url('/lien-he/');
    }
    
    ?>
    <div class="nts-meta-box">
        <div class="nts-meta-field">
            <label for="nts_service_short_description"><?php _e('Mô tả ngắn', 'ntse'); ?></label>
            <textarea id="nts_service_short_description" name="nts_service_short_description" rows="3"><?php echo esc_textarea($short_description); ?></textarea>
            <p class="description"><?php _e('Hiển thị ở phần hero và trong các listing.', 'ntse'); ?></p>
        </div>
        
        <div class="nts-meta-field">
            <label for="nts_service_cta_text"><?php _e('Nút CTA - Text', 'ntse'); ?></label>
            <input type="text" id="nts_service_cta_text" name="nts_service_cta_text" value="<?php echo esc_attr($cta_text); ?>">
            <p class="description"><?php _e('Ví dụ: Liên hệ ngay, Tìm hiểu thêm', 'ntse'); ?></p>
        </div>
        
        <div class="nts-meta-field">
            <label for="nts_service_cta_url"><?php _e('Nút CTA - URL', 'ntse'); ?></label>
            <input type="url" id="nts_service_cta_url" name="nts_service_cta_url" value="<?php echo esc_url($cta_url); ?>">
            <p class="description"><?php _e('Mặc định là trang liên hệ. Để trống nếu muốn sử dụng giá trị mặc định.', 'ntse'); ?></p>
        </div>
    </div>
    <?php
}

/**
 * Service Overview Meta Box Callback
 */
function nts_service_overview_meta_callback($post) {
    // Get the saved values
    $detailed_description = get_post_meta($post->ID, '_service_detailed_description', true);
    $customer_problems = get_post_meta($post->ID, '_service_customer_problems', true);
    $target_audience = get_post_meta($post->ID, '_service_target_audience', true);
    $main_benefits = get_post_meta($post->ID, '_service_main_benefits', true);
    ?>
    <div class="meta-container">
    <div class="meta-section">
            <div class="meta-section-header">
                <h4><?php _e('Mô tả chi tiết', 'ntse'); ?></h4>
            </div>
            <div class="meta-section-content">
                <div class="form-row">
                    <textarea name="service_detailed_description" id="service_detailed_description" rows="5"
                        placeholder="<?php _e('Nhập mô tả chi tiết về dịch vụ', 'ntse'); ?>"><?php echo esc_textarea($detailed_description); ?></textarea>
                </div>
        </div>
    </div>
    
    <div class="meta-section">
            <div class="meta-section-header">
                <h4><?php _e('Vấn đề khách hàng', 'ntse'); ?></h4>
            </div>
            <div class="meta-section-content">
                <div class="form-row">
                    <textarea name="service_customer_problems" id="service_customer_problems" rows="4"
                        placeholder="<?php _e('Mô tả các vấn đề mà khách hàng thường gặp phải', 'ntse'); ?>"><?php echo esc_textarea($customer_problems); ?></textarea>
                </div>
        </div>
    </div>
    
    <div class="meta-section">
            <div class="meta-section-header">
                <h4><?php _e('Đối tượng khách hàng', 'ntse'); ?></h4>
            </div>
            <div class="meta-section-content">
                <div class="form-row">
                    <textarea name="service_target_audience" id="service_target_audience" rows="4"
                        placeholder="<?php _e('Mô tả đối tượng khách hàng của dịch vụ', 'ntse'); ?>"><?php echo esc_textarea($target_audience); ?></textarea>
                </div>
        </div>
    </div>
    
    <div class="meta-section">
            <div class="meta-section-header">
                <h4><?php _e('Lợi ích chính', 'ntse'); ?></h4>
            </div>
            <div class="meta-section-content">
                <div class="form-row">
                    <textarea name="service_main_benefits" id="service_main_benefits" rows="4"
                        placeholder="<?php _e('Liệt kê các lợi ích chính mà dịch vụ mang lại cho khách hàng', 'ntse'); ?>"><?php echo esc_textarea($main_benefits); ?></textarea>
                    <p class="description"><?php _e('Mỗi lợi ích nên viết ngắn gọn, dễ hiểu', 'ntse'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Service Process Meta Box Callback
 */
function nts_service_process_meta_callback($post) {
    $process_title = get_post_meta($post->ID, '_service_process_title', true);
    $process_steps = get_post_meta($post->ID, '_service_process_steps', true);
    if (!is_array($process_steps)) {
        $process_steps = array(
            array('title' => '', 'description' => '', 'time' => '')
        );
    }
    ?>
    <div class="service-process-container">
        <div class="service-process-title">
            <label for="service_process_title"><?php _e('Tiêu đề quy trình', 'ntse'); ?>:</label>
            <input type="text" id="service_process_title" name="service_process_title" value="<?php echo esc_attr($process_title); ?>" placeholder="<?php _e('Ví dụ: Quy trình xử lý nước thải công nghiệp', 'ntse'); ?>">
        </div>
        
        <div id="process_steps_container" class="process-steps-container">
        <?php foreach ($process_steps as $index => $step) : ?>
                <div class="process-step" data-index="<?php echo $index; ?>">
                    <div class="process-step-header">
                        <h4>
                            <span class="sortable-handle dashicons dashicons-move"></span>
                            <span class="step-number"><?php echo $index + 1; ?></span>
                            <span class="step-title-preview"><?php echo !empty($step['title']) ? esc_html($step['title']) : __('Bước mới', 'ntse'); ?></span>
                        </h4>
                        <div class="step-actions">
                            <span class="toggle-step dashicons dashicons-arrow-down-alt2"></span>
                            <span class="remove-step dashicons dashicons-trash" <?php echo ($index === 0) ? 'style="display:none;"' : ''; ?>></span>
                </div>
                </div>
                    <div class="process-step-content">
                        <div class="form-row">
                            <label for="service_process_steps_<?php echo $index; ?>_title"><?php _e('Tiêu đề bước', 'ntse'); ?>:</label>
                            <input type="text" 
                                id="service_process_steps_<?php echo $index; ?>_title" 
                                name="service_process_steps[<?php echo $index; ?>][title]" 
                                value="<?php echo esc_attr($step['title']); ?>" 
                                class="step-title-input"
                                placeholder="<?php _e('Nhập tiêu đề cho bước này', 'ntse'); ?>">
                </div>
                        <div class="form-row">
                            <label for="service_process_steps_<?php echo $index; ?>_description"><?php _e('Mô tả', 'ntse'); ?>:</label>
                            <textarea 
                                id="service_process_steps_<?php echo $index; ?>_description" 
                                name="service_process_steps[<?php echo $index; ?>][description]" 
                                rows="4"
                                placeholder="<?php _e('Mô tả chi tiết cho bước này', 'ntse'); ?>"><?php echo esc_textarea($step['description']); ?></textarea>
                        </div>
                        <div class="form-row">
                            <label for="service_process_steps_<?php echo $index; ?>_time"><?php _e('Thời gian ước tính', 'ntse'); ?>:</label>
                            <input type="text" 
                                id="service_process_steps_<?php echo $index; ?>_time" 
                                name="service_process_steps[<?php echo $index; ?>][time]" 
                                value="<?php echo esc_attr($step['time']); ?>"
                                placeholder="<?php _e('Ví dụ: 2-3 ngày', 'ntse'); ?>">
                        </div>
                    </div>
            </div>
        <?php endforeach; ?>
    </div>
        
        <div class="process-controls">
            <button type="button" class="button button-secondary collapse-all-steps"><?php _e('Thu gọn tất cả', 'ntse'); ?></button>
            <button type="button" class="button button-secondary expand-all-steps"><?php _e('Mở rộng tất cả', 'ntse'); ?></button>
            <button type="button" class="button button-primary add-process-step">
                <span class="dashicons dashicons-plus-alt"></span>
                <?php _e('Thêm bước', 'ntse'); ?>
            </button>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var stepCount = <?php echo count($process_steps); ?>;
        
        // Make the steps sortable
        $('#process_steps_container').sortable({
            handle: '.sortable-handle',
            update: function(event, ui) {
                // Update step numbers after sorting
                updateStepNumbers();
            }
        });
        
        // Toggle step content visibility
        $(document).on('click', '.toggle-step', function() {
            var $header = $(this).closest('.process-step-header');
            var $content = $header.next('.process-step-content');
            
            $content.slideToggle();
            $(this).toggleClass('dashicons-arrow-down-alt2 dashicons-arrow-up-alt2');
        });
        
        // Update step title in header when input changes
        $(document).on('input', '.step-title-input', function() {
            var title = $(this).val();
            var $step = $(this).closest('.process-step');
            $step.find('.step-title-preview').text(title || '<?php _e('Bước mới', 'ntse'); ?>');
        });
        
        // Add new step
        $('.add-process-step').on('click', function() {
            var newStep = `
                <div class="process-step" data-index="${stepCount}">
                    <div class="process-step-header">
                        <h4>
                            <span class="sortable-handle dashicons dashicons-move"></span>
                            <span class="step-number">${stepCount + 1}</span>
                            <span class="step-title-preview"><?php _e('Bước mới', 'ntse'); ?></span>
                        </h4>
                        <div class="step-actions">
                            <span class="toggle-step dashicons dashicons-arrow-down-alt2"></span>
                            <span class="remove-step dashicons dashicons-trash"></span>
                    </div>
                    </div>
                    <div class="process-step-content">
                        <div class="form-row">
                            <label for="service_process_steps_${stepCount}_title"><?php _e('Tiêu đề bước', 'ntse'); ?>:</label>
                            <input type="text" 
                                id="service_process_steps_${stepCount}_title" 
                                name="service_process_steps[${stepCount}][title]" 
                                value="" 
                                class="step-title-input"
                                placeholder="<?php _e('Nhập tiêu đề cho bước này', 'ntse'); ?>">
                    </div>
                        <div class="form-row">
                            <label for="service_process_steps_${stepCount}_description"><?php _e('Mô tả', 'ntse'); ?>:</label>
                            <textarea 
                                id="service_process_steps_${stepCount}_description" 
                                name="service_process_steps[${stepCount}][description]" 
                                rows="4"
                                placeholder="<?php _e('Mô tả chi tiết cho bước này', 'ntse'); ?>"></textarea>
                        </div>
                        <div class="form-row">
                            <label for="service_process_steps_${stepCount}_time"><?php _e('Thời gian ước tính', 'ntse'); ?>:</label>
                            <input type="text" 
                                id="service_process_steps_${stepCount}_time" 
                                name="service_process_steps[${stepCount}][time]" 
                                value=""
                                placeholder="<?php _e('Ví dụ: 2-3 ngày', 'ntse'); ?>">
                        </div>
                    </div>
                </div>
            `;
            $('#process_steps_container').append(newStep);
            stepCount++;
            updateStepNumbers();
        });
        
        // Remove step
        $(document).on('click', '.remove-step', function() {
            if (confirm('<?php _e('Bạn có chắc muốn xóa bước này?', 'ntse'); ?>')) {
            $(this).closest('.process-step').remove();
                updateStepNumbers();
            }
        });
        
        // Collapse all steps
        $('.collapse-all-steps').on('click', function() {
            $('.process-step-content').slideUp();
            $('.toggle-step').removeClass('dashicons-arrow-up-alt2').addClass('dashicons-arrow-down-alt2');
        });
        
        // Expand all steps
        $('.expand-all-steps').on('click', function() {
            $('.process-step-content').slideDown();
            $('.toggle-step').removeClass('dashicons-arrow-down-alt2').addClass('dashicons-arrow-up-alt2');
        });
        
        // Update step numbers
        function updateStepNumbers() {
            $('.process-step').each(function(index) {
                $(this).attr('data-index', index);
                $(this).find('.step-number').text(index + 1);
                
                // Update field names and IDs to match new index
                $(this).find('input, textarea').each(function() {
                    var name = $(this).attr('name');
                    var id = $(this).attr('id');
                    
                    if (name) {
                        var newName = name.replace(/\[\d+\]/, '[' + index + ']');
                        $(this).attr('name', newName);
                    }
                    
                    if (id) {
                        var newId = id.replace(/_\d+_/, '_' + index + '_');
                        $(this).attr('id', newId);
                    }
                });
                
                // Hide remove button for first step
                if (index === 0) {
                    $(this).find('.remove-step').hide();
                } else {
                    $(this).find('.remove-step').show();
                }
            });
        }
    });
    </script>
    <?php
}

/**
 * Service Highlights Meta Box Callback
 */
function nts_service_highlights_meta_callback($post) {
    $highlights = get_post_meta($post->ID, '_service_highlights', true);
    $technologies = get_post_meta($post->ID, '_service_technologies', true);
    $certifications = get_post_meta($post->ID, '_service_certifications', true);
    $team = get_post_meta($post->ID, '_service_team', true);
    ?>
    <div class="meta-container">
    <div class="meta-section">
            <div class="meta-section-header">
                <h4><?php _e('Điểm nổi bật', 'ntse'); ?></h4>
            </div>
            <div class="meta-section-content">
                <div class="form-row">
                    <textarea name="service_highlights" id="service_highlights" rows="5"
                        placeholder="<?php _e('Nhập các điểm nổi bật của dịch vụ', 'ntse'); ?>"><?php echo esc_textarea($highlights); ?></textarea>
                    <p class="description"><?php _e('Mỗi điểm nổi bật viết trên một dòng', 'ntse'); ?></p>
                </div>
        </div>
    </div>
    
    <div class="meta-section">
            <div class="meta-section-header">
                <h4><?php _e('Công nghệ độc quyền', 'ntse'); ?></h4>
            </div>
            <div class="meta-section-content">
                <div class="form-row">
                    <textarea name="service_technologies" id="service_technologies" rows="4"
                        placeholder="<?php _e('Mô tả các công nghệ dùng trong dịch vụ', 'ntse'); ?>"><?php echo esc_textarea($technologies); ?></textarea>
                </div>
        </div>
    </div>
    
    <div class="meta-section">
            <div class="meta-section-header">
                <h4><?php _e('Chứng nhận & Đảm bảo', 'ntse'); ?></h4>
            </div>
            <div class="meta-section-content">
                <div class="form-row">
                    <textarea name="service_certifications" id="service_certifications" rows="4"
                        placeholder="<?php _e('Liệt kê các chứng nhận và cam kết', 'ntse'); ?>"><?php echo esc_textarea($certifications); ?></textarea>
                </div>
        </div>
    </div>
    
    <div class="meta-section">
            <div class="meta-section-header">
                <h4><?php _e('Đội ngũ chuyên gia', 'ntse'); ?></h4>
            </div>
            <div class="meta-section-content">
                <div class="form-row">
                    <textarea name="service_team" id="service_team" rows="4"
                        placeholder="<?php _e('Mô tả về đội ngũ thực hiện dịch vụ', 'ntse'); ?>"><?php echo esc_textarea($team); ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Service Testimonials Meta Box Callback
 */
function nts_service_testimonials_meta_callback($post) {
    $testimonials = get_post_meta($post->ID, '_service_testimonials', true);
    if (!is_array($testimonials)) {
        $testimonials = array(
            array('name' => '', 'role' => '', 'content' => '', 'rating' => '5')
        );
    }
    ?>
    <div class="testimonials-container">
        <div id="testimonials_container" class="repeater-container">
        <?php foreach ($testimonials as $index => $testimonial) : ?>
                <div class="testimonial-item repeater-item" data-index="<?php echo $index; ?>">
                    <div class="repeater-header">
                        <h4>
                            <span class="sortable-handle dashicons dashicons-move"></span>
                            <span class="item-number"><?php echo $index + 1; ?></span>
                            <span class="item-title-preview"><?php echo !empty($testimonial['name']) ? esc_html($testimonial['name']) : __('Đánh giá mới', 'ntse'); ?></span>
                        </h4>
                        <div class="item-actions">
                            <span class="toggle-item dashicons dashicons-arrow-down-alt2"></span>
                            <span class="remove-item dashicons dashicons-trash" <?php echo ($index === 0) ? 'style="display:none;"' : ''; ?>></span>
                </div>
                </div>
                    <div class="repeater-content">
                        <div class="form-row">
                            <label for="service_testimonials_<?php echo $index; ?>_name"><?php _e('Tên người đánh giá', 'ntse'); ?>:</label>
                            <input type="text" 
                                id="service_testimonials_<?php echo $index; ?>_name" 
                                name="service_testimonials[<?php echo $index; ?>][name]" 
                                value="<?php echo esc_attr($testimonial['name']); ?>" 
                                class="item-title-input"
                                placeholder="<?php _e('Nhập tên khách hàng', 'ntse'); ?>">
                </div>
                        <div class="form-row">
                            <label for="service_testimonials_<?php echo $index; ?>_role"><?php _e('Vai trò / Công ty', 'ntse'); ?>:</label>
                            <input type="text" 
                                id="service_testimonials_<?php echo $index; ?>_role" 
                                name="service_testimonials[<?php echo $index; ?>][role]" 
                                value="<?php echo esc_attr($testimonial['role']); ?>"
                                placeholder="<?php _e('Ví dụ: Giám đốc Công ty ABC', 'ntse'); ?>">
                        </div>
                        <div class="form-row">
                            <label for="service_testimonials_<?php echo $index; ?>_content"><?php _e('Nội dung nhận xét', 'ntse'); ?>:</label>
                            <textarea 
                                id="service_testimonials_<?php echo $index; ?>_content" 
                                name="service_testimonials[<?php echo $index; ?>][content]" 
                                rows="3"
                                placeholder="<?php _e('Nhập nội dung nhận xét của khách hàng', 'ntse'); ?>"><?php echo esc_textarea($testimonial['content']); ?></textarea>
                        </div>
                        <div class="form-row rating-row">
                            <label><?php _e('Điểm đánh giá', 'ntse'); ?>:</label>
                            <div class="rating-stars">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <label class="star-label">
                                        <input type="radio" 
                                            name="service_testimonials[<?php echo $index; ?>][rating]" 
                                            value="<?php echo $i; ?>" 
                                            <?php checked($testimonial['rating'], $i); ?>>
                                        <span class="dashicons <?php echo $i <= $testimonial['rating'] ? 'dashicons-star-filled' : 'dashicons-star-empty'; ?>"></span>
                                    </label>
                        <?php endfor; ?>
                </div>
                        </div>
                    </div>
            </div>
        <?php endforeach; ?>
    </div>
        
        <div class="repeater-controls">
            <button type="button" class="button button-secondary collapse-all-items"><?php _e('Thu gọn tất cả', 'ntse'); ?></button>
            <button type="button" class="button button-secondary expand-all-items"><?php _e('Mở rộng tất cả', 'ntse'); ?></button>
            <button type="button" class="button button-primary add-testimonial">
                <span class="dashicons dashicons-plus-alt"></span>
                <?php _e('Thêm đánh giá', 'ntse'); ?>
            </button>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var itemCount = <?php echo count($testimonials); ?>;
        
        // Make the items sortable
        $('#testimonials_container').sortable({
            handle: '.sortable-handle',
            update: function(event, ui) {
                // Update item numbers after sorting
                updateItemNumbers();
            }
        });
        
        // Toggle item content visibility
        $(document).on('click', '.toggle-item', function() {
            var $header = $(this).closest('.repeater-header');
            var $content = $header.next('.repeater-content');
            
            $content.slideToggle();
            $(this).toggleClass('dashicons-arrow-down-alt2 dashicons-arrow-up-alt2');
        });
        
        // Update item title in header when input changes
        $(document).on('input', '.item-title-input', function() {
            var title = $(this).val();
            var $item = $(this).closest('.repeater-item');
            $item.find('.item-title-preview').text(title || '<?php _e('Đánh giá mới', 'ntse'); ?>');
        });
        
        // Rating star functionality
        $(document).on('click', '.star-label', function() {
            var $stars = $(this).parent().find('.star-label');
            var index = $stars.index(this);
            
            $stars.each(function(i) {
                if (i <= index) {
                    $(this).find('span').removeClass('dashicons-star-empty').addClass('dashicons-star-filled');
                } else {
                    $(this).find('span').removeClass('dashicons-star-filled').addClass('dashicons-star-empty');
                }
            });
        });
        
        // Add new testimonial
        $('.add-testimonial').on('click', function() {
            var newItem = `
                <div class="testimonial-item repeater-item" data-index="${itemCount}">
                    <div class="repeater-header">
                        <h4>
                            <span class="sortable-handle dashicons dashicons-move"></span>
                            <span class="item-number">${itemCount + 1}</span>
                            <span class="item-title-preview"><?php _e('Đánh giá mới', 'ntse'); ?></span>
                        </h4>
                        <div class="item-actions">
                            <span class="toggle-item dashicons dashicons-arrow-down-alt2"></span>
                            <span class="remove-item dashicons dashicons-trash"></span>
                    </div>
                    </div>
                    <div class="repeater-content">
                        <div class="form-row">
                            <label for="service_testimonials_${itemCount}_name"><?php _e('Tên người đánh giá', 'ntse'); ?>:</label>
                            <input type="text" 
                                id="service_testimonials_${itemCount}_name" 
                                name="service_testimonials[${itemCount}][name]" 
                                value="" 
                                class="item-title-input"
                                placeholder="<?php _e('Nhập tên khách hàng', 'ntse'); ?>">
                    </div>
                        <div class="form-row">
                            <label for="service_testimonials_${itemCount}_role"><?php _e('Vai trò / Công ty', 'ntse'); ?>:</label>
                            <input type="text" 
                                id="service_testimonials_${itemCount}_role" 
                                name="service_testimonials[${itemCount}][role]" 
                                value=""
                                placeholder="<?php _e('Ví dụ: Giám đốc Công ty ABC', 'ntse'); ?>">
                    </div>
                        <div class="form-row">
                            <label for="service_testimonials_${itemCount}_content"><?php _e('Nội dung nhận xét', 'ntse'); ?>:</label>
                            <textarea 
                                id="service_testimonials_${itemCount}_content" 
                                name="service_testimonials[${itemCount}][content]" 
                                rows="3"
                                placeholder="<?php _e('Nhập nội dung nhận xét của khách hàng', 'ntse'); ?>"></textarea>
                        </div>
                        <div class="form-row rating-row">
                            <label><?php _e('Điểm đánh giá', 'ntse'); ?>:</label>
                            <div class="rating-stars">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <label class="star-label">
                                        <input type="radio" 
                                            name="service_testimonials[${itemCount}][rating]" 
                                            value="<?php echo $i; ?>" 
                                            <?php echo ($i === 5) ? 'checked' : ''; ?>>
                                        <span class="dashicons <?php echo ($i <= 5) ? 'dashicons-star-filled' : 'dashicons-star-empty'; ?>"></span>
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#testimonials_container').append(newItem);
            itemCount++;
            updateItemNumbers();
        });
        
        // Remove item
        $(document).on('click', '.remove-item', function() {
            if (confirm('<?php _e('Bạn có chắc muốn xóa đánh giá này?', 'ntse'); ?>')) {
                $(this).closest('.repeater-item').remove();
                updateItemNumbers();
            }
        });
        
        // Collapse all items
        $('.collapse-all-items').on('click', function() {
            $('.repeater-content').slideUp();
            $('.toggle-item').removeClass('dashicons-arrow-up-alt2').addClass('dashicons-arrow-down-alt2');
        });
        
        // Expand all items
        $('.expand-all-items').on('click', function() {
            $('.repeater-content').slideDown();
            $('.toggle-item').removeClass('dashicons-arrow-down-alt2').addClass('dashicons-arrow-up-alt2');
        });
        
        // Update item numbers
        function updateItemNumbers() {
            $('.repeater-item').each(function(index) {
                $(this).attr('data-index', index);
                $(this).find('.item-number').text(index + 1);
                
                // Update field names and IDs to match new index
                $(this).find('input, textarea').each(function() {
                    var name = $(this).attr('name');
                    var id = $(this).attr('id');
                    
                    if (name) {
                        var newName = name.replace(/\[\d+\]/, '[' + index + ']');
                        $(this).attr('name', newName);
                    }
                    
                    if (id) {
                        var newId = id.replace(/_\d+_/, '_' + index + '_');
                        $(this).attr('id', newId);
                    }
                });
                
                // Hide remove button for first item
                if (index === 0) {
                    $(this).find('.remove-item').hide();
                } else {
                    $(this).find('.remove-item').show();
                }
            });
        }
    });
    </script>
    <?php
}

/**
 * Service FAQ Meta Box Callback
 */
function nts_service_faq_meta_callback($post) {
    $faqs = get_post_meta($post->ID, '_service_faqs', true);
    if (!is_array($faqs)) {
        $faqs = array(
            array('question' => '', 'answer' => '')
        );
    }
    ?>
    <div class="faqs-container">
        <div id="faqs_container" class="repeater-container">
        <?php foreach ($faqs as $index => $faq) : ?>
                <div class="faq-item repeater-item" data-index="<?php echo $index; ?>">
                    <div class="repeater-header">
                        <h4>
                            <span class="sortable-handle dashicons dashicons-move"></span>
                            <span class="item-number"><?php echo $index + 1; ?></span>
                            <span class="item-title-preview"><?php echo !empty($faq['question']) ? esc_html($faq['question']) : __('Câu hỏi mới', 'ntse'); ?></span>
                        </h4>
                        <div class="item-actions">
                            <span class="toggle-item dashicons dashicons-arrow-down-alt2"></span>
                            <span class="remove-item dashicons dashicons-trash" <?php echo ($index === 0) ? 'style="display:none;"' : ''; ?>></span>
                </div>
                </div>
                    <div class="repeater-content">
                        <div class="form-row">
                            <label for="service_faqs_<?php echo $index; ?>_question"><?php _e('Câu hỏi', 'ntse'); ?>:</label>
                            <input type="text" 
                                id="service_faqs_<?php echo $index; ?>_question" 
                                name="service_faqs[<?php echo $index; ?>][question]" 
                                value="<?php echo esc_attr($faq['question']); ?>" 
                                class="item-title-input"
                                placeholder="<?php _e('Nhập câu hỏi', 'ntse'); ?>">
                        </div>
                        <div class="form-row">
                            <label for="service_faqs_<?php echo $index; ?>_answer"><?php _e('Câu trả lời', 'ntse'); ?>:</label>
                            <textarea 
                                id="service_faqs_<?php echo $index; ?>_answer" 
                                name="service_faqs[<?php echo $index; ?>][answer]" 
                                rows="3"
                                placeholder="<?php _e('Nhập câu trả lời', 'ntse'); ?>"><?php echo esc_textarea($faq['answer']); ?></textarea>
                        </div>
                    </div>
            </div>
        <?php endforeach; ?>
    </div>
        
        <div class="repeater-controls">
            <button type="button" class="button button-secondary collapse-all-items"><?php _e('Thu gọn tất cả', 'ntse'); ?></button>
            <button type="button" class="button button-secondary expand-all-items"><?php _e('Mở rộng tất cả', 'ntse'); ?></button>
            <button type="button" class="button button-primary add-faq">
                <span class="dashicons dashicons-plus-alt"></span>
                <?php _e('Thêm câu hỏi', 'ntse'); ?>
            </button>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var itemCount = <?php echo count($faqs); ?>;
        
        // Make the items sortable
        $('#faqs_container').sortable({
            handle: '.sortable-handle',
            update: function(event, ui) {
                // Update item numbers after sorting
                updateItemNumbers();
            }
        });
        
        // Toggle item content visibility
        $(document).on('click', '.toggle-item', function() {
            var $header = $(this).closest('.repeater-header');
            var $content = $header.next('.repeater-content');
            
            $content.slideToggle();
            $(this).toggleClass('dashicons-arrow-down-alt2 dashicons-arrow-up-alt2');
        });
        
        // Update item title in header when input changes
        $(document).on('input', '.item-title-input', function() {
            var title = $(this).val();
            var $item = $(this).closest('.repeater-item');
            $item.find('.item-title-preview').text(title || '<?php _e('Câu hỏi mới', 'ntse'); ?>');
        });
        
        // Add new faq
        $('.add-faq').on('click', function() {
            var newItem = `
                <div class="faq-item repeater-item" data-index="${itemCount}">
                    <div class="repeater-header">
                        <h4>
                            <span class="sortable-handle dashicons dashicons-move"></span>
                            <span class="item-number">${itemCount + 1}</span>
                            <span class="item-title-preview"><?php _e('Câu hỏi mới', 'ntse'); ?></span>
                        </h4>
                        <div class="item-actions">
                            <span class="toggle-item dashicons dashicons-arrow-down-alt2"></span>
                            <span class="remove-item dashicons dashicons-trash"></span>
                    </div>
                    </div>
                    <div class="repeater-content">
                        <div class="form-row">
                            <label for="service_faqs_${itemCount}_question"><?php _e('Câu hỏi', 'ntse'); ?>:</label>
                            <input type="text" 
                                id="service_faqs_${itemCount}_question" 
                                name="service_faqs[${itemCount}][question]" 
                                value="" 
                                class="item-title-input"
                                placeholder="<?php _e('Nhập câu hỏi', 'ntse'); ?>">
                        </div>
                        <div class="form-row">
                            <label for="service_faqs_${itemCount}_answer"><?php _e('Câu trả lời', 'ntse'); ?>:</label>
                            <textarea 
                                id="service_faqs_${itemCount}_answer" 
                                name="service_faqs[${itemCount}][answer]" 
                                rows="3"
                                placeholder="<?php _e('Nhập câu trả lời', 'ntse'); ?>"></textarea>
                        </div>
                    </div>
                </div>
            `;
            $('#faqs_container').append(newItem);
            itemCount++;
            updateItemNumbers();
        });
        
        // Remove item
        $(document).on('click', '.remove-item', function() {
            if (confirm('<?php _e('Bạn có chắc muốn xóa câu hỏi này?', 'ntse'); ?>')) {
                $(this).closest('.repeater-item').remove();
                updateItemNumbers();
            }
        });
        
        // Collapse all items
        $('.collapse-all-items').on('click', function() {
            $('.repeater-content').slideUp();
            $('.toggle-item').removeClass('dashicons-arrow-up-alt2').addClass('dashicons-arrow-down-alt2');
        });
        
        // Expand all items
        $('.expand-all-items').on('click', function() {
            $('.repeater-content').slideDown();
            $('.toggle-item').removeClass('dashicons-arrow-down-alt2').addClass('dashicons-arrow-up-alt2');
        });
        
        // Update item numbers
        function updateItemNumbers() {
            $('.repeater-item').each(function(index) {
                $(this).attr('data-index', index);
                $(this).find('.item-number').text(index + 1);
                
                // Update field names and IDs to match new index
                $(this).find('input, textarea').each(function() {
                    var name = $(this).attr('name');
                    var id = $(this).attr('id');
                    
                    if (name) {
                        var newName = name.replace(/\[\d+\]/, '[' + index + ']');
                        $(this).attr('name', newName);
                    }
                    
                    if (id) {
                        var newId = id.replace(/_\d+_/, '_' + index + '_');
                        $(this).attr('id', newId);
                    }
                });
                
                // Hide remove button for first item
                if (index === 0) {
                    $(this).find('.remove-item').hide();
                } else {
                    $(this).find('.remove-item').show();
                }
            });
        }
    });
    </script>
    <?php
}

/**
 * Service CTA & Related Meta Box Callback
 */
function nts_service_cta_meta_callback($post) {
    $response_time = get_post_meta($post->ID, '_service_response_time', true);
    $related_services = get_post_meta($post->ID, '_service_related_services', true);
    if (!is_array($related_services)) {
        $related_services = array();
    }
    $resources = get_post_meta($post->ID, '_service_resources', true);
    
    // Get services for dropdown
            $services = get_posts(array(
                'post_type' => 'service',
                'posts_per_page' => -1,
                'post__not_in' => array($post->ID),
                'orderby' => 'title',
                'order' => 'ASC'
            ));
    ?>
    <div class="meta-container">
        <div class="meta-section">
            <div class="meta-section-header">
                <h4><?php _e('Thông tin liên hệ', 'ntse'); ?></h4>
            </div>
            <div class="meta-section-content">
                <div class="form-row">
                    <label for="service_response_time"><?php _e('Thời gian phản hồi trung bình', 'ntse'); ?>:</label>
                    <input type="text" 
                        id="service_response_time" 
                        name="service_response_time" 
                        value="<?php echo esc_attr($response_time); ?>" 
                        placeholder="<?php _e('Ví dụ: 24 giờ, 2-3 ngày làm việc, v.v.', 'ntse'); ?>">
                </div>
            </div>
        </div>
        
        <div class="meta-section">
            <div class="meta-section-header">
                <h4><?php _e('Dịch vụ liên quan', 'ntse'); ?></h4>
            </div>
            <div class="meta-section-content">
                <?php if ($services) : ?>
                    <div class="form-row">
                        <select name="service_related_services[]" id="service_related_services" multiple style="width: 100%; min-height: 120px;">
                    <?php foreach ($services as $service) : ?>
                        <option value="<?php echo $service->ID; ?>" <?php selected(in_array($service->ID, $related_services), true); ?>>
                            <?php echo $service->post_title; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                        <p class="description"><?php _e('Giữ phím Ctrl/Command để chọn nhiều dịch vụ', 'ntse'); ?></p>
                    </div>
            <?php else : ?>
                    <p><?php _e('Không có dịch vụ khác nào.', 'ntse'); ?></p>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="meta-section">
            <div class="meta-section-header">
                <h4><?php _e('Tài liệu bổ sung', 'ntse'); ?></h4>
            </div>
            <div class="meta-section-content">
                <div class="form-row">
                    <label for="service_resources"><?php _e('Video, brochure, blog...', 'ntse'); ?>:</label>
                    <textarea 
                        id="service_resources" 
                        name="service_resources" 
                        rows="4"
                        placeholder="<?php _e('Nhập theo định dạng: Tiêu đề|URL (mỗi mục một dòng)', 'ntse'); ?>"><?php echo esc_textarea($resources); ?></textarea>
                    <p class="description"><?php _e('Ví dụ: Video giới thiệu|https://youtube.com/watch?v=xyz', 'ntse'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Save meta box data
 */
function nts_service_save_meta_box_data($post_id) {
    // Check if our nonce is set
    if (!isset($_POST['nts_service_meta_box_nonce'])) {
        return;
    }
    
    // Verify the nonce
    if (!wp_verify_nonce($_POST['nts_service_meta_box_nonce'], 'nts_service_meta_box')) {
        return;
    }
    
    // If this is an autosave, we don't want to do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check the user's permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Hero Section
    if (isset($_POST['nts_service_short_description'])) {
        update_post_meta($post_id, '_nts_service_short_description', sanitize_textarea_field($_POST['nts_service_short_description']));
    }
    
    if (isset($_POST['nts_service_cta_text'])) {
        update_post_meta($post_id, '_nts_service_cta_text', sanitize_text_field($_POST['nts_service_cta_text']));
    } else {
        update_post_meta($post_id, '_nts_service_cta_text', __('Liên hệ ngay', 'ntse'));
    }
    
    if (isset($_POST['nts_service_cta_url']) && !empty($_POST['nts_service_cta_url'])) {
        update_post_meta($post_id, '_nts_service_cta_url', esc_url_raw($_POST['nts_service_cta_url']));
    } else {
        update_post_meta($post_id, '_nts_service_cta_url', home_url('/lien-he/'));
    }
    
    // Service Overview
    if (isset($_POST['service_detailed_description'])) {
        update_post_meta($post_id, '_service_detailed_description', sanitize_textarea_field($_POST['service_detailed_description']));
    }
    
    if (isset($_POST['service_customer_problems'])) {
        update_post_meta($post_id, '_service_customer_problems', sanitize_textarea_field($_POST['service_customer_problems']));
    }
    
    if (isset($_POST['service_target_audience'])) {
        update_post_meta($post_id, '_service_target_audience', sanitize_textarea_field($_POST['service_target_audience']));
    }
    
    if (isset($_POST['service_main_benefits'])) {
        update_post_meta($post_id, '_service_main_benefits', sanitize_textarea_field($_POST['service_main_benefits']));
    }
    
    // Process Steps
    if (isset($_POST['service_process_title'])) {
        update_post_meta($post_id, '_service_process_title', sanitize_text_field($_POST['service_process_title']));
    }
    
    if (isset($_POST['service_process_steps']) && is_array($_POST['service_process_steps'])) {
        $process_steps = array();
        foreach ($_POST['service_process_steps'] as $step) {
            if (!empty($step['title'])) {
                $process_steps[] = array(
                    'title' => sanitize_text_field($step['title']),
                    'description' => sanitize_textarea_field($step['description']),
                    'time' => sanitize_text_field($step['time'])
                );
            }
        }
        update_post_meta($post_id, '_service_process_steps', $process_steps);
    }
    
    // Highlights
    if (isset($_POST['service_highlights'])) {
        update_post_meta($post_id, '_service_highlights', sanitize_textarea_field($_POST['service_highlights']));
    }
    
    if (isset($_POST['service_technologies'])) {
        update_post_meta($post_id, '_service_technologies', sanitize_textarea_field($_POST['service_technologies']));
    }
    
    if (isset($_POST['service_certifications'])) {
        update_post_meta($post_id, '_service_certifications', sanitize_textarea_field($_POST['service_certifications']));
    }
    
    if (isset($_POST['service_team'])) {
        update_post_meta($post_id, '_service_team', sanitize_textarea_field($_POST['service_team']));
    }
    
    // Testimonials
    if (isset($_POST['service_testimonials']) && is_array($_POST['service_testimonials'])) {
        $testimonials = array();
        foreach ($_POST['service_testimonials'] as $testimonial) {
            if (!empty($testimonial['name'])) {
                $testimonials[] = array(
                    'name' => sanitize_text_field($testimonial['name']),
                    'role' => sanitize_text_field($testimonial['role']),
                    'content' => sanitize_textarea_field($testimonial['content']),
                    'rating' => intval($testimonial['rating'])
                );
            }
        }
        update_post_meta($post_id, '_service_testimonials', $testimonials);
    }
    
    // FAQs
    if (isset($_POST['service_faqs']) && is_array($_POST['service_faqs'])) {
        $faqs = array();
        foreach ($_POST['service_faqs'] as $faq) {
            if (!empty($faq['question'])) {
                $faqs[] = array(
                    'question' => sanitize_text_field($faq['question']),
                    'answer' => sanitize_textarea_field($faq['answer'])
                );
            }
        }
        update_post_meta($post_id, '_service_faqs', $faqs);
    }
    
    // CTA & Related
    if (isset($_POST['service_response_time'])) {
        update_post_meta($post_id, '_service_response_time', sanitize_text_field($_POST['service_response_time']));
    }
    
    if (isset($_POST['service_related_services']) && is_array($_POST['service_related_services'])) {
        $related_services = array_map('intval', $_POST['service_related_services']);
        update_post_meta($post_id, '_service_related_services', $related_services);
    } else {
        update_post_meta($post_id, '_service_related_services', array());
    }
    
    if (isset($_POST['service_resources'])) {
        update_post_meta($post_id, '_service_resources', sanitize_textarea_field($_POST['service_resources']));
    }
}
add_action('save_post_service', 'nts_service_save_meta_box_data');
