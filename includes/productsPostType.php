<?php

// Đăng ký Custom Post Type "Sản phẩm" và Danh mục sản phẩm
function nts_register_product_post_type() {
    // Đăng ký Post Type
    $labels = [
        'name'               => __('Sản phẩm', 'flatsome'),
        'singular_name'      => __('Sản phẩm', 'flatsome'),
        'menu_name'          => __('Sản phẩm', 'flatsome'),
        'all_items'          => __('Tất cả sản phẩm', 'flatsome'),
        'add_new'            => __('Thêm sản phẩm', 'flatsome'),
        'add_new_item'       => __('Thêm sản phẩm mới', 'flatsome'),
        'edit_item'          => __('Sửa sản phẩm', 'flatsome'),
        'new_item'           => __('Sản phẩm mới', 'flatsome'),
        'view_item'          => __('Xem sản phẩm', 'flatsome'),
        'search_items'       => __('Tìm kiếm sản phẩm', 'flatsome'),
        'not_found'          => __('Không tìm thấy sản phẩm', 'flatsome'),
        'not_found_in_trash' => __('Không có sản phẩm trong thùng rác', 'flatsome'),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'san-pham'],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-products',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'show_in_rest'       => true,
    ];

    register_post_type('product', $args);

    // Đăng ký Taxonomy "Danh mục sản phẩm"
    $taxonomy_labels = [
        'name'              => __('Danh mục sản phẩm', 'flatsome'),
        'singular_name'     => __('Danh mục', 'flatsome'),
        'search_items'      => __('Tìm danh mục', 'flatsome'),
        'all_items'         => __('Tất cả danh mục', 'flatsome'),
        'parent_item'       => __('Danh mục cha', 'flatsome'),
        'parent_item_colon' => __('Danh mục cha:', 'flatsome'),
        'edit_item'         => __('Sửa danh mục', 'flatsome'),
        'update_item'       => __('Cập nhật danh mục', 'flatsome'),
        'add_new_item'      => __('Thêm danh mục mới', 'flatsome'),
        'new_item_name'     => __('Tên danh mục mới', 'flatsome'),
        'menu_name'         => __('Danh mục sản phẩm', 'flatsome'),
    ];

    $taxonomy_args = [
        'hierarchical'      => true,
        'labels'            => $taxonomy_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'danh-muc-san-pham'],
        'show_in_rest'      => true,
    ];

    register_taxonomy('product_category', 'product', $taxonomy_args);

    // Đăng ký Taxonomy "Thương hiệu" (không phân cấp)
    $brand_labels = [
        'name'              => __('Thương hiệu', 'flatsome'),
        'singular_name'     => __('Thương hiệu', 'flatsome'),
        'search_items'      => __('Tìm thương hiệu', 'flatsome'),
        'all_items'         => __('Tất cả thương hiệu', 'flatsome'),
        'edit_item'         => __('Sửa thương hiệu', 'flatsome'),
        'update_item'       => __('Cập nhật thương hiệu', 'flatsome'),
        'add_new_item'      => __('Thêm thương hiệu mới', 'flatsome'),
        'new_item_name'     => __('Tên thương hiệu mới', 'flatsome'),
        'menu_name'         => __('Thương hiệu', 'flatsome'),
    ];

    $brand_args = [
        'hierarchical'      => false,
        'labels'            => $brand_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'thuong-hieu'],
        'show_in_rest'      => true,
    ];

    register_taxonomy('product_brand', 'product', $brand_args);
}
add_action('init', 'nts_register_product_post_type');

// Đăng ký kích thước thumbnail tùy chỉnh cho sản phẩm
function nts_add_product_thumbnail_size() {
    // Đăng ký kích thước thumbnail cho sản phẩm
    add_image_size('product-thumbnail', 300, 300, true); // 300x300px, cắt để vừa
    add_image_size('product-medium', 600, 600, true);    // 600x600px, cắt để vừa
    add_image_size('product-large', 900, 900, true);     // 900x900px, cắt để vừa
}
add_action('after_setup_theme', 'nts_add_product_thumbnail_size');

// Thêm meta box cho thông tin sản phẩm
function nts_add_product_meta_boxes() {
    // Thông tin cơ bản sản phẩm
    add_meta_box(
        'nts_product_details',
        __('Thông tin sản phẩm', 'flatsome'),
        'nts_product_details_callback',
        'product',
        'normal',
        'high'
    );

    // Hero Banner
    add_meta_box(
        'nts_product_hero',
        __('Hero Banner', 'flatsome'),
        'nts_product_hero_callback',
        'product',
        'normal',
        'high'
    );

    // Tổng quan sản phẩm
    add_meta_box(
        'nts_product_overview',
        __('Tổng quan sản phẩm', 'flatsome'),
        'nts_product_overview_callback',
        'product',
        'normal',
        'default'
    );

    // Công nghệ vật chất
    add_meta_box(
        'nts_product_technology',
        __('Công nghệ vật chất', 'flatsome'),
        'nts_product_technology_callback',
        'product',
        'normal',
        'default'
    );

    // Ứng dụng nổi bật
    add_meta_box(
        'nts_product_applications',
        __('Ứng dụng nổi bật', 'flatsome'),
        'nts_product_applications_callback',
        'product',
        'normal',
        'default'
    );

    // Đánh giá khách hàng
    add_meta_box(
        'nts_product_reviews',
        __('Đánh giá khách hàng', 'flatsome'),
        'nts_product_reviews_callback',
        'product',
        'normal',
        'default'
    );

    // Câu hỏi thường gặp (FAQ)
    add_meta_box(
        'nts_product_faq',
        __('Câu hỏi thường gặp (FAQ)', 'flatsome'),
        'nts_product_faq_callback',
        'product',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'nts_add_product_meta_boxes');

// Callback function cho meta box
function nts_product_details_callback($post) {
    // Thêm nonce field để bảo mật
    wp_nonce_field('nts_product_details_nonce', 'nts_product_details_nonce');

    // Lấy giá trị hiện tại
    $product_code = get_post_meta($post->ID, '_product_code', true);
    $product_price = get_post_meta($post->ID, '_product_price', true);
    $product_specs = get_post_meta($post->ID, '_product_specs', true);
    $product_features = get_post_meta($post->ID, '_product_features', true);

    // Hiển thị form
    ?>
    <div class="nts-product-meta-box">
        <style>
            .nts-product-meta-box .form-field {
                margin-bottom: 15px;
            }
            .nts-product-meta-box label {
                display: block;
                font-weight: 600;
                margin-bottom: 5px;
            }
            .nts-product-meta-box input[type="text"] {
                width: 100%;
                padding: 8px;
            }
            .nts-product-meta-box textarea {
                width: 100%;
                height: 100px;
            }
        </style>

        <div class="form-field">
            <label for="product_code"><?php _e('Mã sản phẩm:', 'flatsome'); ?></label>
            <input type="text" id="product_code" name="product_code" value="<?php echo esc_attr($product_code); ?>">
        </div>

        <div class="form-field">
            <label for="product_price"><?php _e('Giá sản phẩm:', 'flatsome'); ?></label>
            <input type="text" id="product_price" name="product_price" value="<?php echo esc_attr($product_price); ?>">
            <p class="description"><?php _e('Nhập giá sản phẩm (VD: 1,500,000 VNĐ)', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="product_specs"><?php _e('Thông số kỹ thuật:', 'flatsome'); ?></label>
            <textarea id="product_specs" name="product_specs"><?php echo esc_textarea($product_specs); ?></textarea>
            <p class="description"><?php _e('Nhập thông số kỹ thuật của sản phẩm', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="product_features"><?php _e('Tính năng nổi bật:', 'flatsome'); ?></label>
            <textarea id="product_features" name="product_features"><?php echo esc_textarea($product_features); ?></textarea>
            <p class="description"><?php _e('Nhập các tính năng nổi bật của sản phẩm', 'flatsome'); ?></p>
        </div>
    </div>
    <?php
}

// Callback function cho Hero Banner metabox
function nts_product_hero_callback($post) {
    wp_nonce_field('nts_product_hero_nonce', 'nts_product_hero_nonce');

    // Lấy giá trị hiện tại
    $product_type = get_post_meta($post->ID, '_product_type', true);
    $hero_image_id = get_post_meta($post->ID, '_hero_image_id', true);
    $short_description = get_post_meta($post->ID, '_short_description', true);
    
    // Hiển thị form
    ?>
    <div class="nts-product-meta-box">
        <style>
            .nts-product-meta-box .form-field {
                margin-bottom: 15px;
            }
            .nts-product-meta-box label {
                display: block;
                font-weight: 600;
                margin-bottom: 5px;
            }
            .nts-product-meta-box input[type="text"] {
                width: 100%;
                padding: 8px;
            }
            .nts-product-meta-box textarea {
                width: 100%;
                height: 100px;
            }
            .nts-product-meta-box .image-preview {
                margin-top: 10px;
                max-width: 300px;
            }
            .nts-product-meta-box .image-preview img {
                max-width: 100%;
                height: auto;
            }
        </style>

        <div class="form-field">
            <label for="product_type"><?php _e('Loại sản phẩm:', 'flatsome'); ?></label>
            <input type="text" id="product_type" name="product_type" value="<?php echo esc_attr($product_type); ?>">
            <p class="description"><?php _e('Nhập loại sản phẩm (VD: Máy lọc nước, Lõi lọc, etc.)', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="hero_image"><?php _e('Hình ảnh chất lượng cao:', 'flatsome'); ?></label>
            <input type="hidden" id="hero_image_id" name="hero_image_id" value="<?php echo esc_attr($hero_image_id); ?>">
            <button type="button" class="button" id="upload_hero_image_button"><?php _e('Tải lên / Chọn hình ảnh', 'flatsome'); ?></button>
            <button type="button" class="button" id="remove_hero_image_button" <?php echo empty($hero_image_id) ? 'style="display:none"' : ''; ?>><?php _e('Xóa hình ảnh', 'flatsome'); ?></button>
            
            <div class="image-preview" id="hero_image_preview">
                <?php if (!empty($hero_image_id)) : ?>
                    <?php echo wp_get_attachment_image($hero_image_id, 'medium'); ?>
                <?php endif; ?>
            </div>
            
            <p class="description"><?php _e('Chọn hình ảnh chất lượng cao cho banner hero', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="short_description"><?php _e('Mô tả ngắn (1-2 câu):', 'flatsome'); ?></label>
            <textarea id="short_description" name="short_description"><?php echo esc_textarea($short_description); ?></textarea>
            <p class="description"><?php _e('Nhập mô tả ngắn về sản phẩm (tối đa 1-2 câu)', 'flatsome'); ?></p>
        </div>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Media Uploader for Hero Image
        $('#upload_hero_image_button').click(function() {
            var image_frame;
            if (image_frame) {
                image_frame.open();
                return;
            }
            
            image_frame = wp.media({
                title: '<?php _e("Chọn hoặc tải lên hình ảnh", "flatsome"); ?>',
                button: {
                    text: '<?php _e("Sử dụng hình ảnh này", "flatsome"); ?>',
                },
                multiple: false
            });
            
            image_frame.on('select', function() {
                var attachment = image_frame.state().get('selection').first().toJSON();
                $('#hero_image_id').val(attachment.id);
                $('#hero_image_preview').html('<img src="' + attachment.url + '" alt="" style="max-width:100%;">');
                $('#remove_hero_image_button').show();
            });
            
            image_frame.open();
        });
        
        $('#remove_hero_image_button').click(function() {
            $('#hero_image_id').val('');
            $('#hero_image_preview').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}

// Callback function cho Tổng quan sản phẩm
function nts_product_overview_callback($post) {
    wp_nonce_field('nts_product_overview_nonce', 'nts_product_overview_nonce');

    // Lấy giá trị hiện tại
    $overview = get_post_meta($post->ID, '_product_overview', true);
    $product_purpose = get_post_meta($post->ID, '_product_purpose', true);
    $target_customers = get_post_meta($post->ID, '_target_customers', true);
    $key_benefits = get_post_meta($post->ID, '_key_benefits', true);
    
    // Hiển thị form
    ?>
    <div class="nts-product-meta-box">
        <div class="form-field">
            <label for="product_overview"><?php _e('Mô tả tổng quan:', 'flatsome'); ?></label>
            <?php
            wp_editor(
                htmlspecialchars_decode($overview),
                'product_overview',
                array(
                    'media_buttons' => true,
                    'textarea_name' => 'product_overview',
                    'textarea_rows' => 10,
                    'teeny' => false
                )
            );
            ?>
            <p class="description"><?php _e('Mô tả tổng quan và chi tiết về sản phẩm', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="product_purpose"><?php _e('Mục tiêu sản phẩm:', 'flatsome'); ?></label>
            <textarea id="product_purpose" name="product_purpose"><?php echo esc_textarea($product_purpose); ?></textarea>
            <p class="description"><?php _e('Mục tiêu mà sản phẩm được tạo ra (vấn đề mà sản phẩm giải quyết)', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="target_customers"><?php _e('Khách hàng mục tiêu:', 'flatsome'); ?></label>
            <textarea id="target_customers" name="target_customers"><?php echo esc_textarea($target_customers); ?></textarea>
            <p class="description"><?php _e('Mô tả đối tượng khách hàng mục tiêu của sản phẩm', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="key_benefits"><?php _e('Lợi ích chính:', 'flatsome'); ?></label>
            <textarea id="key_benefits" name="key_benefits"><?php echo esc_textarea($key_benefits); ?></textarea>
            <p class="description"><?php _e('Liệt kê các lợi ích chính của sản phẩm (mỗi lợi ích một dòng)', 'flatsome'); ?></p>
        </div>
    </div>
    <?php
}

// Callback function cho Công nghệ vật chất
function nts_product_technology_callback($post) {
    wp_nonce_field('nts_product_technology_nonce', 'nts_product_technology_nonce');

    // Lấy giá trị hiện tại
    $materials = get_post_meta($post->ID, '_product_materials', true);
    $production_technology = get_post_meta($post->ID, '_production_technology', true);
    
    // Hiển thị form
    ?>
    <div class="nts-product-meta-box">
        <div class="form-field">
            <label for="product_materials"><?php _e('Công nghệ vật liệu:', 'flatsome'); ?></label>
            <?php
            wp_editor(
                htmlspecialchars_decode($materials),
                'product_materials',
                array(
                    'media_buttons' => true,
                    'textarea_name' => 'product_materials',
                    'textarea_rows' => 8,
                    'teeny' => false
                )
            );
            ?>
            <p class="description"><?php _e('Mô tả về công nghệ và vật liệu sử dụng trong sản phẩm', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="production_technology"><?php _e('Công nghệ sản xuất:', 'flatsome'); ?></label>
            <?php
            wp_editor(
                htmlspecialchars_decode($production_technology),
                'production_technology',
                array(
                    'media_buttons' => true,
                    'textarea_name' => 'production_technology',
                    'textarea_rows' => 8,
                    'teeny' => false
                )
            );
            ?>
            <p class="description"><?php _e('Mô tả về công nghệ sản xuất của sản phẩm', 'flatsome'); ?></p>
        </div>
    </div>
    <?php
}

// Callback function cho Ứng dụng nổi bật
function nts_product_applications_callback($post) {
    wp_nonce_field('nts_product_applications_nonce', 'nts_product_applications_nonce');

    // Lấy giá trị hiện tại
    $applications = get_post_meta($post->ID, '_product_applications', true);
    $certificates = get_post_meta($post->ID, '_product_certificates', true);
    
    // Hiển thị form
    ?>
    <div class="nts-product-meta-box">
        <div class="form-field">
            <label for="product_applications"><?php _e('Ứng dụng thực tiễn nổi bật:', 'flatsome'); ?></label>
            <?php
            wp_editor(
                htmlspecialchars_decode($applications),
                'product_applications',
                array(
                    'media_buttons' => true,
                    'textarea_name' => 'product_applications',
                    'textarea_rows' => 8,
                    'teeny' => false
                )
            );
            ?>
            <p class="description"><?php _e('Mô tả các ứng dụng thực tiễn nổi bật của sản phẩm', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="product_certificates"><?php _e('Chứng chỉ/Giấy phép:', 'flatsome'); ?></label>
            <textarea id="product_certificates" name="product_certificates"><?php echo esc_textarea($certificates); ?></textarea>
            <p class="description"><?php _e('Liệt kê các chứng chỉ, giấy phép mà sản phẩm đạt được (mỗi chứng chỉ một dòng)', 'flatsome'); ?></p>
        </div>
    </div>
    <?php
}

// Callback function cho Đánh giá khách hàng
function nts_product_reviews_callback($post) {
    wp_nonce_field('nts_product_reviews_nonce', 'nts_product_reviews_nonce');

    // Lấy giá trị hiện tại
    $reviews = get_post_meta($post->ID, '_product_reviews', true);
    if (!is_array($reviews)) {
        $reviews = array();
    }
    
    // Hiển thị form
    ?>
    <div class="nts-product-meta-box">
        <style>
            .review-item {
                padding: 15px;
                background: #f9f9f9;
                margin-bottom: 15px;
                border: 1px solid #e5e5e5;
                border-radius: 3px;
            }
            .review-item h4 {
                margin-top: 0;
                margin-bottom: 10px;
                border-bottom: 1px solid #eee;
                padding-bottom: 8px;
            }
            .review-actions {
                margin-top: 10px;
                text-align: right;
            }
            .review-template {
                display: none;
            }
            .add-review-button {
                margin: 15px 0;
            }
        </style>

        <div id="reviews-container">
            <?php if (!empty($reviews)) : ?>
                <?php foreach ($reviews as $index => $review) : ?>
                    <div class="review-item" data-index="<?php echo $index; ?>">
                        <h4><?php _e('Đánh giá', 'flatsome'); ?> #<span class="review-number"><?php echo $index + 1; ?></span></h4>
                        
                        <div class="form-field">
                            <label><?php _e('Phản hồi thực tế:', 'flatsome'); ?></label>
                            <textarea name="product_reviews[<?php echo $index; ?>][content]" rows="3"><?php echo esc_textarea($review['content'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-field">
                            <label><?php _e('Tên khách hàng:', 'flatsome'); ?></label>
                            <input type="text" name="product_reviews[<?php echo $index; ?>][name]" value="<?php echo esc_attr($review['name'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-field">
                            <label><?php _e('Chức danh và công ty:', 'flatsome'); ?></label>
                            <input type="text" name="product_reviews[<?php echo $index; ?>][position]" value="<?php echo esc_attr($review['position'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-field">
                            <label><?php _e('Điểm số đánh giá (1-5):', 'flatsome'); ?></label>
                            <input type="number" name="product_reviews[<?php echo $index; ?>][rating]" min="1" max="5" value="<?php echo esc_attr($review['rating'] ?? '5'); ?>">
                        </div>
                        
                        <div class="review-actions">
                            <button type="button" class="button remove-review"><?php _e('Xóa đánh giá này', 'flatsome'); ?></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Mẫu để thêm đánh giá mới -->
        <div class="review-template">
            <div class="review-item">
                <h4><?php _e('Đánh giá', 'flatsome'); ?> #<span class="review-number"></span></h4>
                
                <div class="form-field">
                    <label><?php _e('Phản hồi thực tế:', 'flatsome'); ?></label>
                    <textarea name="product_reviews[INDEX][content]" rows="3"></textarea>
                </div>
                
                <div class="form-field">
                    <label><?php _e('Tên khách hàng:', 'flatsome'); ?></label>
                    <input type="text" name="product_reviews[INDEX][name]" value="">
                </div>
                
                <div class="form-field">
                    <label><?php _e('Chức danh và công ty:', 'flatsome'); ?></label>
                    <input type="text" name="product_reviews[INDEX][position]" value="">
                </div>
                
                <div class="form-field">
                    <label><?php _e('Điểm số đánh giá (1-5):', 'flatsome'); ?></label>
                    <input type="number" name="product_reviews[INDEX][rating]" min="1" max="5" value="5">
                </div>
                
                <div class="review-actions">
                    <button type="button" class="button remove-review"><?php _e('Xóa đánh giá này', 'flatsome'); ?></button>
                </div>
            </div>
        </div>
        
        <div class="add-review-button">
            <button type="button" class="button button-primary" id="add-review"><?php _e('Thêm đánh giá mới', 'flatsome'); ?></button>
        </div>
        
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Thêm đánh giá mới
            $('#add-review').on('click', function() {
                var container = $('#reviews-container');
                var template = $('.review-template').html();
                var index = container.find('.review-item').length;
                
                // Thay thế INDEX với index thực tế
                template = template.replace(/INDEX/g, index);
                
                // Thêm vào container
                container.append(template);
                
                // Cập nhật số đánh giá
                container.find('.review-item:last .review-number').text(index + 1);
                container.find('.review-item:last').attr('data-index', index);
            });
            
            // Xóa đánh giá
            $(document).on('click', '.remove-review', function() {
                if (confirm('<?php _e("Bạn có chắc chắn muốn xóa đánh giá này?", "flatsome"); ?>')) {
                    $(this).closest('.review-item').remove();
                    
                    // Cập nhật lại các index
                    $('#reviews-container .review-item').each(function(i) {
                        $(this).attr('data-index', i);
                        $(this).find('.review-number').text(i + 1);
                        
                        // Cập nhật tên trường
                        $(this).find('textarea, input').each(function() {
                            var name = $(this).attr('name');
                            if (name) {
                                name = name.replace(/product_reviews\[\d+\]/, 'product_reviews[' + i + ']');
                                $(this).attr('name', name);
                            }
                        });
                    });
                }
            });
        });
        </script>
    </div>
    <?php
}

// Callback function cho Câu hỏi thường gặp
function nts_product_faq_callback($post) {
    wp_nonce_field('nts_product_faq_nonce', 'nts_product_faq_nonce');

    // Lấy giá trị hiện tại
    $faqs = get_post_meta($post->ID, '_product_faqs', true);
    if (!is_array($faqs)) {
        $faqs = array();
    }
    
    // Hiển thị form
    ?>
    <div class="nts-product-meta-box">
        <style>
            .faq-item {
                padding: 15px;
                background: #f9f9f9;
                margin-bottom: 15px;
                border: 1px solid #e5e5e5;
                border-radius: 3px;
            }
            .faq-item h4 {
                margin-top: 0;
                margin-bottom: 10px;
                border-bottom: 1px solid #eee;
                padding-bottom: 8px;
            }
            .faq-actions {
                margin-top: 10px;
                text-align: right;
            }
            .faq-template {
                display: none;
            }
            .add-faq-button {
                margin: 15px 0;
            }
        </style>

        <div id="faqs-container">
            <?php if (!empty($faqs)) : ?>
                <?php foreach ($faqs as $index => $faq) : ?>
                    <div class="faq-item" data-index="<?php echo $index; ?>">
                        <h4><?php _e('Câu hỏi', 'flatsome'); ?> #<span class="faq-number"><?php echo $index + 1; ?></span></h4>
                        
                        <div class="form-field">
                            <label><?php _e('Câu hỏi:', 'flatsome'); ?></label>
                            <input type="text" name="product_faqs[<?php echo $index; ?>][question]" value="<?php echo esc_attr($faq['question'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-field">
                            <label><?php _e('Trả lời:', 'flatsome'); ?></label>
                            <textarea name="product_faqs[<?php echo $index; ?>][answer]" rows="3"><?php echo esc_textarea($faq['answer'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-field">
                            <label><?php _e('Link trang chi tiết (nếu có):', 'flatsome'); ?></label>
                            <input type="url" name="product_faqs[<?php echo $index; ?>][link]" value="<?php echo esc_url($faq['link'] ?? ''); ?>">
                        </div>
                        
                        <div class="faq-actions">
                            <button type="button" class="button remove-faq"><?php _e('Xóa câu hỏi này', 'flatsome'); ?></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Mẫu để thêm câu hỏi mới -->
        <div class="faq-template">
            <div class="faq-item">
                <h4><?php _e('Câu hỏi', 'flatsome'); ?> #<span class="faq-number"></span></h4>
                
                <div class="form-field">
                    <label><?php _e('Câu hỏi:', 'flatsome'); ?></label>
                    <input type="text" name="product_faqs[INDEX][question]" value="">
                </div>
                
                <div class="form-field">
                    <label><?php _e('Trả lời:', 'flatsome'); ?></label>
                    <textarea name="product_faqs[INDEX][answer]" rows="3"></textarea>
                </div>
                
                <div class="form-field">
                    <label><?php _e('Link trang chi tiết (nếu có):', 'flatsome'); ?></label>
                    <input type="url" name="product_faqs[INDEX][link]" value="">
                </div>
                
                <div class="faq-actions">
                    <button type="button" class="button remove-faq"><?php _e('Xóa câu hỏi này', 'flatsome'); ?></button>
                </div>
            </div>
        </div>
        
        <div class="add-faq-button">
            <button type="button" class="button button-primary" id="add-faq"><?php _e('Thêm câu hỏi mới', 'flatsome'); ?></button>
        </div>
        
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Thêm câu hỏi mới
            $('#add-faq').on('click', function() {
                var container = $('#faqs-container');
                var template = $('.faq-template').html();
                var index = container.find('.faq-item').length;
                
                // Thay thế INDEX với index thực tế
                template = template.replace(/INDEX/g, index);
                
                // Thêm vào container
                container.append(template);
                
                // Cập nhật số câu hỏi
                container.find('.faq-item:last .faq-number').text(index + 1);
                container.find('.faq-item:last').attr('data-index', index);
            });
            
            // Xóa câu hỏi
            $(document).on('click', '.remove-faq', function() {
                if (confirm('<?php _e("Bạn có chắc chắn muốn xóa câu hỏi này?", "flatsome"); ?>')) {
                    $(this).closest('.faq-item').remove();
                    
                    // Cập nhật lại các index
                    $('#faqs-container .faq-item').each(function(i) {
                        $(this).attr('data-index', i);
                        $(this).find('.faq-number').text(i + 1);
                        
                        // Cập nhật tên trường
                        $(this).find('textarea, input').each(function() {
                            var name = $(this).attr('name');
                            if (name) {
                                name = name.replace(/product_faqs\[\d+\]/, 'product_faqs[' + i + ']');
                                $(this).attr('name', name);
                            }
                        });
                    });
                }
            });
        });
        </script>
    </div>
    <?php
}

// Hàm lưu dữ liệu meta box
function nts_save_product_details($post_id) {
    // Kiểm tra nonce cho bảo mật
    if (!isset($_POST['nts_product_details_nonce']) || !wp_verify_nonce($_POST['nts_product_details_nonce'], 'nts_product_details_nonce')) {
        return;
    }

    // Kiểm tra quyền chỉnh sửa
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Kiểm tra autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Lưu các field thông tin cơ bản sản phẩm
    if (isset($_POST['product_code'])) {
        update_post_meta($post_id, '_product_code', sanitize_text_field($_POST['product_code']));
    }

    if (isset($_POST['product_price'])) {
        update_post_meta($post_id, '_product_price', sanitize_text_field($_POST['product_price']));
    }

    if (isset($_POST['product_specs'])) {
        update_post_meta($post_id, '_product_specs', sanitize_textarea_field($_POST['product_specs']));
    }

    if (isset($_POST['product_features'])) {
        update_post_meta($post_id, '_product_features', sanitize_textarea_field($_POST['product_features']));
    }
    
    // Lưu Hero Banner fields
    if (isset($_POST['product_type'])) {
        update_post_meta($post_id, '_product_type', sanitize_text_field($_POST['product_type']));
    }
    
    if (isset($_POST['hero_image_id'])) {
        update_post_meta($post_id, '_hero_image_id', absint($_POST['hero_image_id']));
    }
    
    if (isset($_POST['short_description'])) {
        update_post_meta($post_id, '_short_description', sanitize_textarea_field($_POST['short_description']));
    }
    
    // Lưu Tổng quan sản phẩm
    if (isset($_POST['product_overview'])) {
        update_post_meta($post_id, '_product_overview', wp_kses_post($_POST['product_overview']));
    }
    
    if (isset($_POST['product_purpose'])) {
        update_post_meta($post_id, '_product_purpose', sanitize_textarea_field($_POST['product_purpose']));
    }
    
    if (isset($_POST['target_customers'])) {
        update_post_meta($post_id, '_target_customers', sanitize_textarea_field($_POST['target_customers']));
    }
    
    if (isset($_POST['key_benefits'])) {
        update_post_meta($post_id, '_key_benefits', sanitize_textarea_field($_POST['key_benefits']));
    }
    
    // Lưu Công nghệ vật chất
    if (isset($_POST['product_materials'])) {
        update_post_meta($post_id, '_product_materials', wp_kses_post($_POST['product_materials']));
    }
    
    if (isset($_POST['production_technology'])) {
        update_post_meta($post_id, '_production_technology', wp_kses_post($_POST['production_technology']));
    }
    
    // Lưu Ứng dụng nổi bật
    if (isset($_POST['product_applications'])) {
        update_post_meta($post_id, '_product_applications', wp_kses_post($_POST['product_applications']));
    }
    
    if (isset($_POST['product_certificates'])) {
        update_post_meta($post_id, '_product_certificates', sanitize_textarea_field($_POST['product_certificates']));
    }
    
    // Lưu Đánh giá khách hàng
    if (isset($_POST['product_reviews']) && is_array($_POST['product_reviews'])) {
        $reviews = array();
        foreach ($_POST['product_reviews'] as $review) {
            if (!empty($review['content']) || !empty($review['name'])) {
                $reviews[] = array(
                    'content' => sanitize_textarea_field($review['content']),
                    'name' => sanitize_text_field($review['name']),
                    'position' => sanitize_text_field($review['position']),
                    'rating' => absint($review['rating'])
                );
            }
        }
        update_post_meta($post_id, '_product_reviews', $reviews);
    }
    
    // Lưu FAQ
    if (isset($_POST['product_faqs']) && is_array($_POST['product_faqs'])) {
        $faqs = array();
        foreach ($_POST['product_faqs'] as $faq) {
            if (!empty($faq['question']) || !empty($faq['answer'])) {
                $faqs[] = array(
                    'question' => sanitize_text_field($faq['question']),
                    'answer' => sanitize_textarea_field($faq['answer']),
                    'link' => esc_url_raw($faq['link'])
                );
            }
        }
        update_post_meta($post_id, '_product_faqs', $faqs);
    }
}
add_action('save_post_product', 'nts_save_product_details');

// JavaScript cho admin
function nts_product_admin_scripts() {
    global $post_type;
    if ('product' === $post_type) {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'nts_product_admin_scripts');

// Thêm shortcode để hiển thị danh sách sản phẩm
function nts_products_shortcode($atts) {
    $atts = shortcode_atts([
        'category' => '',      // Danh mục sản phẩm
        'brand' => '',         // Thương hiệu
        'limit' => 12,         // Số lượng sản phẩm hiển thị
        'columns' => 4,        // Số cột
        'orderby' => 'date',   // Sắp xếp theo
        'order' => 'DESC',     // Thứ tự sắp xếp
    ], $atts, 'nts_products');

    $args = [
        'post_type' => 'product',
        'posts_per_page' => $atts['limit'],
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
    ];

    // Lọc theo danh mục nếu có
    if (!empty($atts['category'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'product_category',
            'field' => 'slug',
            'terms' => explode(',', $atts['category']),
        ];
    }

    // Lọc theo thương hiệu nếu có
    if (!empty($atts['brand'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'product_brand',
            'field' => 'slug',
            'terms' => explode(',', $atts['brand']),
        ];
    }

    $products_query = new WP_Query($args);

    ob_start();

    if ($products_query->have_posts()) :
        echo '<div class="nts-products-grid row row-small">';

        while ($products_query->have_posts()) : $products_query->the_post();
            // Xác định class cho cột dựa trên số cột
            $column_class = 'medium-3'; // Mặc định 4 cột
            switch ((int)$atts['columns']) {
                case 1:
                    $column_class = 'medium-12';
                    break;
                case 2:
                    $column_class = 'medium-6';
                    break;
                case 3:
                    $column_class = 'medium-4';
                    break;
                case 6:
                    $column_class = 'medium-2';
                    break;
            }

            // Lấy thông tin sản phẩm
            $product_code = get_post_meta(get_the_ID(), '_product_code', true);
            $product_price = get_post_meta(get_the_ID(), '_product_price', true);

            echo '<div class="col ' . esc_attr($column_class) . ' small-12">';
            echo '<div class="product-item">';

            // Thumbnail
            if (has_post_thumbnail()) {
                echo '<div class="product-thumbnail">';
                echo '<a href="' . get_permalink() . '">';
                the_post_thumbnail('product-thumbnail', ['class' => 'product-image']);
                echo '</a>';
                echo '</div>';
            }

            // Nội dung
            echo '<div class="product-content">';

            // Danh mục
            $categories = get_the_terms(get_the_ID(), 'product_category');
            if ($categories && !is_wp_error($categories)) {
                echo '<div class="product-category">';
                $cat_names = [];
                foreach ($categories as $category) {
                    $cat_names[] = '<a href="' . get_term_link($category) . '">' . $category->name . '</a>';
                }
                echo implode(', ', $cat_names);
                echo '</div>';
            }

            // Tiêu đề
            echo '<h3 class="product-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';

            // Mã sản phẩm
            if (!empty($product_code)) {
                echo '<div class="product-code">Mã: ' . esc_html($product_code) . '</div>';
            }

            // Giá
            if (!empty($product_price)) {
                echo '<div class="product-price">' . esc_html($product_price) . '</div>';
            }

            // Tóm tắt
            echo '<div class="product-excerpt">' . get_the_excerpt() . '</div>';

            // Nút xem chi tiết
            echo '<a href="' . get_permalink() . '" class="product-readmore">Xem chi tiết</a>';

            echo '</div>'; // .product-content
            echo '</div>'; // .product-item
            echo '</div>'; // .col
        endwhile;

        echo '</div>'; // .nts-products-grid

        // Khôi phục dữ liệu post
        wp_reset_postdata();

    else :
        echo '<p>Không có sản phẩm nào.</p>';
    endif;

    // Thêm CSS
    echo '<style>
    .nts-products-grid {
        margin-bottom: 30px;
    }
    .product-item {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .product-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }
    .product-thumbnail {
        position: relative;
        overflow: hidden;
    }
    .product-image {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s;
        aspect-ratio: 1/1;
        object-fit: cover;
    }
    .product-item:hover .product-image {
        transform: scale(1.05);
    }
    .product-content {
        padding: 15px 20px 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .product-category {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
    }
    .product-category a {
        color: var(--primary);
        text-decoration: none;
    }
    .product-title {
        margin: 0 0 10px;
        font-size: 18px;
        line-height: 1.3;
    }
    .product-title a {
        color: #333;
        text-decoration: none;
    }
    .product-title a:hover {
        color: var(--primary);
    }
    .product-code {
        font-size: 13px;
        color: #666;
        margin-bottom: 5px;
    }
    .product-price {
        font-size: 16px;
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 10px;
    }
    .product-excerpt {
        font-size: 14px;
        line-height: 1.5;
        color: #666;
        margin-bottom: 15px;
        flex-grow: 1;
    }
    .product-readmore {
        display: inline-block;
        background-color: var(--primary);
        color: white;
        padding: 8px 15px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.3s;
        text-align: center;
    }
    .product-readmore:hover {
        background-color: var(--primary-dark);
        color: white;
    }
    </style>';

    return ob_get_clean();
}
add_shortcode('nts_products', 'nts_products_shortcode');

// Đăng ký UX Builder element cho sản phẩm
add_action('ux_builder_setup', 'nts_register_products_element');

function nts_register_products_element() {
    add_ux_builder_shortcode('nts_products', [
        'name'      => __('Sản phẩm', 'flatsome'),
        'category'  => __('Content', 'flatsome'),
        'info'      => __('Hiển thị danh sách sản phẩm', 'flatsome'),
        'icon'      => 'dashicons-products',

        'options' => [
            'category' => [
                'type'    => 'select',
                'heading' => __('Danh mục sản phẩm', 'flatsome'),
                'default' => '',
                'config'  => [
                    'placeholder' => __('Chọn danh mục', 'flatsome'),
                    'termSelect' => [
                        'post_type' => 'product',
                        'taxonomies' => 'product_category'
                    ]
                ]
            ],
            'brand' => [
                'type'    => 'select',
                'heading' => __('Thương hiệu', 'flatsome'),
                'default' => '',
                'config'  => [
                    'placeholder' => __('Chọn thương hiệu', 'flatsome'),
                    'termSelect' => [
                        'post_type' => 'product',
                        'taxonomies' => 'product_brand'
                    ]
                ]
            ],
            'limit' => [
                'type'    => 'slider',
                'heading' => __('Số lượng hiển thị', 'flatsome'),
                'default' => 12,
                'min'     => 1,
                'max'     => 50,
                'step'    => 1,
            ],
            'columns' => [
                'type'    => 'slider',
                'heading' => __('Số cột', 'flatsome'),
                'default' => 4,
                'min'     => 1,
                'max'     => 6,
                'step'    => 1,
            ],
            'orderby' => [
                'type'    => 'select',
                'heading' => __('Sắp xếp theo', 'flatsome'),
                'default' => 'date',
                'options' => [
                    'date'  => 'Ngày đăng',
                    'title' => 'Tiêu đề',
                    'rand'  => 'Ngẫu nhiên',
                ]
            ],
            'order' => [
                'type'    => 'select',
                'heading' => __('Thứ tự', 'flatsome'),
                'default' => 'DESC',
                'options' => [
                    'DESC' => 'Giảm dần',
                    'ASC'  => 'Tăng dần',
                ]
            ],
        ],
    ]);
}
