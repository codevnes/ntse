<?php
/**
 * Add thumbnail metabox for product_category taxonomy
 */

// Add form field to add new category page
function ntse_product_category_add_form_fields() {
    ?>
    <div class="form-field term-thumbnail-wrap">
        <label for="product_category_thumbnail"><?php _e('Hình ảnh đại diện', 'flatsome'); ?></label>
        <div id="product_category_thumbnail_container">
            <div class="thumbnail-preview">
                <img src="<?php echo esc_url(admin_url('images/placeholder.png')); ?>" id="product_category_thumbnail_preview" style="max-width: 100%; max-height: 200px; display: none;">
            </div>
            <input type="hidden" id="product_category_thumbnail_id" name="product_category_thumbnail_id" value="">
            <button type="button" class="button" id="product_category_thumbnail_upload_button"><?php _e('Tải lên / Chọn hình ảnh', 'flatsome'); ?></button>
            <button type="button" class="button" id="product_category_thumbnail_remove_button" style="display:none;"><?php _e('Xóa hình ảnh', 'flatsome'); ?></button>
        </div>
        <p class="description"><?php _e('Hình ảnh đại diện cho danh mục sản phẩm', 'flatsome'); ?></p>
    </div>

    <!-- Phần giới thiệu danh mục -->
    <div class="form-field term-intro-wrap">
        <h3><?php _e('Phần giới thiệu (hiển thị dưới banner)', 'flatsome'); ?></h3>

        <div class="form-field">
            <label for="product_category_intro_title"><?php _e('Tiêu đề giới thiệu', 'flatsome'); ?></label>
            <input type="text" id="product_category_intro_title" name="product_category_intro_title" value="" placeholder="<?php _e('Ví dụ: Giải pháp lọc nước tiên tiến', 'flatsome'); ?>">
            <p class="description"><?php _e('Tiêu đề chính của phần giới thiệu', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="product_category_intro_content"><?php _e('Nội dung giới thiệu', 'flatsome'); ?></label>
            <textarea id="product_category_intro_content" name="product_category_intro_content" rows="5" placeholder="<?php _e('Nhập nội dung giới thiệu về danh mục sản phẩm này...', 'flatsome'); ?>"></textarea>
            <p class="description"><?php _e('Nội dung chi tiết giới thiệu về danh mục sản phẩm', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="product_category_intro_image"><?php _e('Hình ảnh minh họa', 'flatsome'); ?></label>
            <div id="product_category_intro_image_container">
                <div class="thumbnail-preview">
                    <img src="<?php echo esc_url(admin_url('images/placeholder.png')); ?>" id="product_category_intro_image_preview" style="max-width: 100%; max-height: 200px; display: none;">
                </div>
                <input type="hidden" id="product_category_intro_image_id" name="product_category_intro_image_id" value="">
                <button type="button" class="button" id="product_category_intro_image_upload_button"><?php _e('Tải lên / Chọn hình ảnh', 'flatsome'); ?></button>
                <button type="button" class="button" id="product_category_intro_image_remove_button" style="display:none;"><?php _e('Xóa hình ảnh', 'flatsome'); ?></button>
            </div>
            <p class="description"><?php _e('Hình ảnh minh họa cho phần giới thiệu', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="product_category_intro_button_text"><?php _e('Nút kêu gọi hành động (tùy chọn)', 'flatsome'); ?></label>
            <input type="text" id="product_category_intro_button_text" name="product_category_intro_button_text" value="" placeholder="<?php _e('Ví dụ: Tìm hiểu thêm', 'flatsome'); ?>">
            <p class="description"><?php _e('Văn bản hiển thị trên nút (để trống nếu không muốn hiển thị nút)', 'flatsome'); ?></p>
        </div>

        <div class="form-field">
            <label for="product_category_intro_button_url"><?php _e('Liên kết của nút', 'flatsome'); ?></label>
            <input type="url" id="product_category_intro_button_url" name="product_category_intro_button_url" value="" placeholder="https://...">
            <p class="description"><?php _e('URL khi người dùng nhấp vào nút', 'flatsome'); ?></p>
        </div>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Media Uploader for Thumbnail
        $('#product_category_thumbnail_upload_button').click(function() {
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
                $('#product_category_thumbnail_id').val(attachment.id);
                $('#product_category_thumbnail_preview').attr('src', attachment.url).show();
                $('#product_category_thumbnail_remove_button').show();
            });

            image_frame.open();
        });

        $('#product_category_thumbnail_remove_button').click(function() {
            $('#product_category_thumbnail_id').val('');
            $('#product_category_thumbnail_preview').attr('src', '').hide();
            $(this).hide();
        });

        // Media Uploader for Intro Image
        $('#product_category_intro_image_upload_button').click(function() {
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
                $('#product_category_intro_image_id').val(attachment.id);
                $('#product_category_intro_image_preview').attr('src', attachment.url).show();
                $('#product_category_intro_image_remove_button').show();
            });

            image_frame.open();
        });

        $('#product_category_intro_image_remove_button').click(function() {
            $('#product_category_intro_image_id').val('');
            $('#product_category_intro_image_preview').attr('src', '').hide();
            $(this).hide();
        });
    });
    </script>
    <?php
}
add_action('product_category_add_form_fields', 'ntse_product_category_add_form_fields');

// Add form field to edit category page
function ntse_product_category_edit_form_fields($term) {
    // Lấy dữ liệu thumbnail
    $thumbnail_id = get_term_meta($term->term_id, 'product_category_thumbnail_id', true);
    $thumbnail_url = '';

    if ($thumbnail_id) {
        $thumbnail_url = wp_get_attachment_url($thumbnail_id);
    }

    // Lấy dữ liệu phần giới thiệu
    $intro_title = get_term_meta($term->term_id, 'product_category_intro_title', true);
    $intro_content = get_term_meta($term->term_id, 'product_category_intro_content', true);
    $intro_image_id = get_term_meta($term->term_id, 'product_category_intro_image_id', true);
    $intro_image_url = '';

    if ($intro_image_id) {
        $intro_image_url = wp_get_attachment_url($intro_image_id);
    }

    $intro_button_text = get_term_meta($term->term_id, 'product_category_intro_button_text', true);
    $intro_button_url = get_term_meta($term->term_id, 'product_category_intro_button_url', true);
    ?>
    <tr class="form-field term-thumbnail-wrap">
        <th scope="row"><label for="product_category_thumbnail"><?php _e('Hình ảnh đại diện', 'flatsome'); ?></label></th>
        <td>
            <div id="product_category_thumbnail_container">
                <div class="thumbnail-preview">
                    <?php if ($thumbnail_url) : ?>
                        <img src="<?php echo esc_url($thumbnail_url); ?>" id="product_category_thumbnail_preview" style="max-width: 100%; max-height: 200px;">
                    <?php else : ?>
                        <img src="<?php echo esc_url(admin_url('images/placeholder.png')); ?>" id="product_category_thumbnail_preview" style="max-width: 100%; max-height: 200px; display: none;">
                    <?php endif; ?>
                </div>
                <input type="hidden" id="product_category_thumbnail_id" name="product_category_thumbnail_id" value="<?php echo esc_attr($thumbnail_id); ?>">
                <button type="button" class="button" id="product_category_thumbnail_upload_button"><?php _e('Tải lên / Chọn hình ảnh', 'flatsome'); ?></button>
                <button type="button" class="button" id="product_category_thumbnail_remove_button" <?php echo empty($thumbnail_id) ? 'style="display:none;"' : ''; ?>><?php _e('Xóa hình ảnh', 'flatsome'); ?></button>
            </div>
            <p class="description"><?php _e('Hình ảnh đại diện cho danh mục sản phẩm', 'flatsome'); ?></p>
        </td>
    </tr>

    <!-- Phần giới thiệu danh mục -->
    <tr class="form-field">
        <th colspan="2"><h3><?php _e('Phần giới thiệu (hiển thị dưới banner)', 'flatsome'); ?></h3></th>
    </tr>

    <tr class="form-field">
        <th scope="row"><label for="product_category_intro_title"><?php _e('Tiêu đề giới thiệu', 'flatsome'); ?></label></th>
        <td>
            <input type="text" id="product_category_intro_title" name="product_category_intro_title" value="<?php echo esc_attr($intro_title); ?>" placeholder="<?php _e('Ví dụ: Giải pháp lọc nước tiên tiến', 'flatsome'); ?>">
            <p class="description"><?php _e('Tiêu đề chính của phần giới thiệu', 'flatsome'); ?></p>
        </td>
    </tr>

    <tr class="form-field">
        <th scope="row"><label for="product_category_intro_content"><?php _e('Nội dung giới thiệu', 'flatsome'); ?></label></th>
        <td>
            <textarea id="product_category_intro_content" name="product_category_intro_content" rows="5" placeholder="<?php _e('Nhập nội dung giới thiệu về danh mục sản phẩm này...', 'flatsome'); ?>"><?php echo esc_textarea($intro_content); ?></textarea>
            <p class="description"><?php _e('Nội dung chi tiết giới thiệu về danh mục sản phẩm', 'flatsome'); ?></p>
        </td>
    </tr>

    <tr class="form-field">
        <th scope="row"><label for="product_category_intro_image"><?php _e('Hình ảnh minh họa', 'flatsome'); ?></label></th>
        <td>
            <div id="product_category_intro_image_container">
                <div class="thumbnail-preview">
                    <?php if ($intro_image_url) : ?>
                        <img src="<?php echo esc_url($intro_image_url); ?>" id="product_category_intro_image_preview" style="max-width: 100%; max-height: 200px;">
                    <?php else : ?>
                        <img src="<?php echo esc_url(admin_url('images/placeholder.png')); ?>" id="product_category_intro_image_preview" style="max-width: 100%; max-height: 200px; display: none;">
                    <?php endif; ?>
                </div>
                <input type="hidden" id="product_category_intro_image_id" name="product_category_intro_image_id" value="<?php echo esc_attr($intro_image_id); ?>">
                <button type="button" class="button" id="product_category_intro_image_upload_button"><?php _e('Tải lên / Chọn hình ảnh', 'flatsome'); ?></button>
                <button type="button" class="button" id="product_category_intro_image_remove_button" <?php echo empty($intro_image_id) ? 'style="display:none;"' : ''; ?>><?php _e('Xóa hình ảnh', 'flatsome'); ?></button>
            </div>
            <p class="description"><?php _e('Hình ảnh minh họa cho phần giới thiệu', 'flatsome'); ?></p>
        </td>
    </tr>

    <tr class="form-field">
        <th scope="row"><label for="product_category_intro_button_text"><?php _e('Nút kêu gọi hành động (tùy chọn)', 'flatsome'); ?></label></th>
        <td>
            <input type="text" id="product_category_intro_button_text" name="product_category_intro_button_text" value="<?php echo esc_attr($intro_button_text); ?>" placeholder="<?php _e('Ví dụ: Tìm hiểu thêm', 'flatsome'); ?>">
            <p class="description"><?php _e('Văn bản hiển thị trên nút (để trống nếu không muốn hiển thị nút)', 'flatsome'); ?></p>
        </td>
    </tr>

    <tr class="form-field">
        <th scope="row"><label for="product_category_intro_button_url"><?php _e('Liên kết của nút', 'flatsome'); ?></label></th>
        <td>
            <input type="url" id="product_category_intro_button_url" name="product_category_intro_button_url" value="<?php echo esc_url($intro_button_url); ?>" placeholder="https://...">
            <p class="description"><?php _e('URL khi người dùng nhấp vào nút', 'flatsome'); ?></p>
        </td>
    </tr>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Media Uploader for Thumbnail
        $('#product_category_thumbnail_upload_button').click(function() {
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
                $('#product_category_thumbnail_id').val(attachment.id);
                $('#product_category_thumbnail_preview').attr('src', attachment.url).show();
                $('#product_category_thumbnail_remove_button').show();
            });

            image_frame.open();
        });

        $('#product_category_thumbnail_remove_button').click(function() {
            $('#product_category_thumbnail_id').val('');
            $('#product_category_thumbnail_preview').attr('src', '').hide();
            $(this).hide();
        });

        // Media Uploader for Intro Image
        $('#product_category_intro_image_upload_button').click(function() {
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
                $('#product_category_intro_image_id').val(attachment.id);
                $('#product_category_intro_image_preview').attr('src', attachment.url).show();
                $('#product_category_intro_image_remove_button').show();
            });

            image_frame.open();
        });

        $('#product_category_intro_image_remove_button').click(function() {
            $('#product_category_intro_image_id').val('');
            $('#product_category_intro_image_preview').attr('src', '').hide();
            $(this).hide();
        });
    });
    </script>
    <?php
}
add_action('product_category_edit_form_fields', 'ntse_product_category_edit_form_fields');

// Save the form field
function ntse_save_product_category_meta($term_id) {
    // Lưu thumbnail
    if (isset($_POST['product_category_thumbnail_id'])) {
        update_term_meta(
            $term_id,
            'product_category_thumbnail_id',
            absint($_POST['product_category_thumbnail_id'])
        );
    }

    // Lưu dữ liệu phần giới thiệu
    if (isset($_POST['product_category_intro_title'])) {
        update_term_meta(
            $term_id,
            'product_category_intro_title',
            sanitize_text_field($_POST['product_category_intro_title'])
        );
    }

    if (isset($_POST['product_category_intro_content'])) {
        update_term_meta(
            $term_id,
            'product_category_intro_content',
            wp_kses_post($_POST['product_category_intro_content'])
        );
    }

    if (isset($_POST['product_category_intro_image_id'])) {
        update_term_meta(
            $term_id,
            'product_category_intro_image_id',
            absint($_POST['product_category_intro_image_id'])
        );
    }

    if (isset($_POST['product_category_intro_button_text'])) {
        update_term_meta(
            $term_id,
            'product_category_intro_button_text',
            sanitize_text_field($_POST['product_category_intro_button_text'])
        );
    }

    if (isset($_POST['product_category_intro_button_url'])) {
        update_term_meta(
            $term_id,
            'product_category_intro_button_url',
            esc_url_raw($_POST['product_category_intro_button_url'])
        );
    }
}
add_action('created_product_category', 'ntse_save_product_category_meta');
add_action('edited_product_category', 'ntse_save_product_category_meta');

// Add thumbnail column to category admin
function ntse_product_category_columns($columns) {
    $new_columns = array();

    // Add thumbnail column after checkbox column
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'cb') {
            $new_columns['thumbnail'] = __('Hình ảnh', 'flatsome');
        }
    }

    return $new_columns;
}
add_filter('manage_edit-product_category_columns', 'ntse_product_category_columns');

// Display thumbnail in the column
function ntse_product_category_column_content($content, $column_name, $term_id) {
    if ($column_name === 'thumbnail') {
        $thumbnail_id = get_term_meta($term_id, 'product_category_thumbnail_id', true);

        if ($thumbnail_id) {
            $content = wp_get_attachment_image($thumbnail_id, array(50, 50));
        } else {
            $content = '<div style="width:50px;height:50px;border:1px solid #eee;display:flex;align-items:center;justify-content:center;"><span class="dashicons dashicons-format-image"></span></div>';
        }
    }

    return $content;
}
add_filter('manage_product_category_custom_column', 'ntse_product_category_column_content', 10, 3);

// Enqueue media scripts for taxonomy pages
function ntse_product_category_admin_scripts() {
    $screen = get_current_screen();

    // Only enqueue on product_category taxonomy pages
    if ($screen && $screen->taxonomy === 'product_category') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'ntse_product_category_admin_scripts');

// Function to get product category thumbnail
function ntse_get_product_category_thumbnail($term_id, $size = 'thumbnail') {
    $thumbnail_id = get_term_meta($term_id, 'product_category_thumbnail_id', true);

    if ($thumbnail_id) {
        return wp_get_attachment_image($thumbnail_id, $size);
    }

    return '';
}

// Function to get product category thumbnail URL
function ntse_get_product_category_thumbnail_url($term_id, $size = 'thumbnail') {
    $thumbnail_id = get_term_meta($term_id, 'product_category_thumbnail_id', true);

    if ($thumbnail_id) {
        return wp_get_attachment_image_url($thumbnail_id, $size);
    }

    return '';
}

// Function to get product category introduction data
function ntse_get_product_category_intro($term_id) {
    $intro_data = array(
        'title' => get_term_meta($term_id, 'product_category_intro_title', true),
        'content' => get_term_meta($term_id, 'product_category_intro_content', true),
        'image_id' => get_term_meta($term_id, 'product_category_intro_image_id', true),
        'button_text' => get_term_meta($term_id, 'product_category_intro_button_text', true) ?: 'Liên hệ ngay',
        'button_url' => get_term_meta($term_id, 'product_category_intro_button_url', true) ?: home_url('/lien-he'),
    );

    // Add image URL if image ID exists
    if (!empty($intro_data['image_id'])) {
        $intro_data['image_url'] = wp_get_attachment_image_url($intro_data['image_id'], 'large');
        $intro_data['image'] = wp_get_attachment_image($intro_data['image_id'], 'large');
    } else {
        $intro_data['image_url'] = '';
        $intro_data['image'] = '';
    }

    return $intro_data;
}
