<?php

// Đăng ký Custom Post Type "Dự án"
function nts_register_project_post_type() {
    $labels = array(
        'name'               => __('Dự án', 'textdomain'),
        'singular_name'      => __('Dự án', 'textdomain'),
        'menu_name'          => __('Dự án', 'textdomain'),
        'all_items'          => __('Tất cả dự án', 'textdomain'),
        'add_new'            => __('Thêm mới', 'textdomain'),
        'add_new_item'       => __('Thêm dự án mới', 'textdomain'),
        'edit_item'          => __('Sửa dự án', 'textdomain'),
        'new_item'           => __('Dự án mới', 'textdomain'),
        'view_item'          => __('Xem dự án', 'textdomain'),
        'search_items'       => __('Tìm kiếm dự án', 'textdomain'),
        'not_found'          => __('Không tìm thấy dự án', 'textdomain'),
        'not_found_in_trash' => __('Không có dự án trong thùng rác', 'textdomain'),
    );

    $args = array(
        'labels'              => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'du-an'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-portfolio', // Icon trong admin menu
        'supports'           => array('title', 'thumbnail'),
        'show_in_rest'       => false, // Cho phép sử dụng Gutenberg editor
    );

    register_post_type('project', $args);

    // Đăng ký Taxonomy "Danh mục dự án"
    $taxonomy_labels = array(
        'name'              => __('Danh mục dự án', 'textdomain'),
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
        'rewrite'           => array('slug' => 'danh-muc-du-an'),
        'show_in_rest'      => true,
    );

    register_taxonomy('project_category', 'project', $taxonomy_args);
}
add_action('init', 'nts_register_project_post_type');

// Đăng ký CSS và JS cho admin
function nts_project_admin_scripts($hook) {
    global $post;
    
    if (!$post || $post->post_type !== 'project') {
        return;
    }
    
    // Đảm bảo file CSS và JS tồn tại trước khi đăng ký
    $css_file = get_template_directory() . '/assets/css/project-admin.css';
    $js_file = get_template_directory() . '/assets/js/project-admin.js';
    
    // Tạo file nếu chưa tồn tại
    if (!file_exists($css_file) || !file_exists($js_file)) {
        // Log lỗi nếu có
        error_log('Project admin files missing, creating them now.');
        nts_project_setup_files();
        
        // Double check nếu file đã được tạo
        if (!file_exists($css_file) || !file_exists($js_file)) {
            error_log('Failed to create project admin files.');
            return; // Không đăng ký script nếu không tạo được file
        }
    }
    
    // Đăng ký và enqueue CSS
    wp_register_style('nts-project-admin-css', get_template_directory_uri() . '/assets/css/project-admin.css', array(), '1.0.0');
    wp_enqueue_style('nts-project-admin-css');
    
    // WordPress Media Uploader
    wp_enqueue_media();
    
    // Đăng ký và enqueue JS
    wp_register_script('nts-project-admin-js', get_template_directory_uri() . '/assets/js/project-admin.js', array('jquery', 'jquery-ui-sortable'), '1.0.0', true);
    wp_enqueue_script('nts-project-admin-js');
    
    // Thêm biến cho JS
    wp_localize_script('nts-project-admin-js', 'ntsProjectAdmin', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nts-project-admin-nonce'),
    ));
}
add_action('admin_enqueue_scripts', 'nts_project_admin_scripts');

// Đăng ký metabox cho Custom Fields của Dự án
function nts_register_project_meta_boxes() {
    add_meta_box(
        'project_details',
        __('Thông tin chi tiết dự án', 'textdomain'),
        'nts_project_details_callback',
        'project',
        'normal',
        'high'
    );
    
    add_meta_box(
        'project_gallery',
        __('Thư viện hình ảnh dự án', 'textdomain'),
        'nts_project_gallery_callback',
        'project',
        'normal',
        'high'
    );
    
    add_meta_box(
        'project_statistics',
        __('Số liệu dự án', 'textdomain'),
        'nts_project_statistics_callback',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nts_register_project_meta_boxes');

// Callback function cho metabox thông tin chi tiết
function nts_project_details_callback($post) {
    wp_nonce_field('nts_project_details_nonce', 'project_details_nonce');
    
    $project_description = get_post_meta($post->ID, 'project_description', true);
    $project_challenges = get_post_meta($post->ID, 'project_challenges', true);
    $project_solutions = get_post_meta($post->ID, 'project_solutions', true);
    $project_results = get_post_meta($post->ID, 'project_results', true);
    $project_location = get_post_meta($post->ID, 'project_location', true);
    $project_time = get_post_meta($post->ID, 'project_time', true);
    $project_technology = get_post_meta($post->ID, 'project_technology', true);
    
    ?>
    <div class="nts-meta-box-container">
        <div class="nts-meta-tabs">
            <ul class="nts-tab-nav">
                <li class="tab-active" data-tab="tab-overview">
                    <span class="dashicons dashicons-info"></span>
                    Tổng quan
                </li>
                <li data-tab="tab-challenges">
                    <span class="dashicons dashicons-warning"></span>
                    Thách thức
                </li>
                <li data-tab="tab-solutions">
                    <span class="dashicons dashicons-lightbulb"></span>
                    Giải pháp
                </li>
                <li data-tab="tab-results">
                    <span class="dashicons dashicons-chart-line"></span>
                    Kết quả
                </li>
                <li data-tab="tab-info">
                    <span class="dashicons dashicons-admin-settings"></span>
                    Thông tin kỹ thuật
                </li>
            </ul>
            
            <div class="nts-tab-content">
                <div id="tab-overview" class="nts-tab-pane active">
                    <div class="nts-field-group">
                        <label for="project_description" class="nts-field-label">
                            <span class="dashicons dashicons-editor-paragraph"></span>
                            <span class="label-text">Mô tả tổng quan dự án</span>
                        </label>
                        <div class="nts-field-input">
                            <textarea id="project_description" name="project_description" class="large-text" rows="8"><?php echo esc_textarea($project_description); ?></textarea>
                            <p class="nts-field-desc">Nhập mô tả tổng quan về dự án. Thông tin này sẽ hiển thị ở đầu trang chi tiết dự án.</p>
                        </div>
                    </div>
                </div>
                
                <div id="tab-challenges" class="nts-tab-pane">
                    <div class="nts-field-group">
                        <label for="project_challenges" class="nts-field-label">
                            <span class="dashicons dashicons-warning"></span>
                            <span class="label-text">Thách thức</span>
                        </label>
                        <div class="nts-field-input">
                            <textarea id="project_challenges" name="project_challenges" class="large-text" rows="8"><?php echo esc_textarea($project_challenges); ?></textarea>
                            <p class="nts-field-desc">Mô tả những thách thức cần giải quyết trong dự án này.</p>
                        </div>
                    </div>
                </div>
                
                <div id="tab-solutions" class="nts-tab-pane">
                    <div class="nts-field-group">
                        <label for="project_solutions" class="nts-field-label">
                            <span class="dashicons dashicons-lightbulb"></span>
                            <span class="label-text">Giải pháp</span>
                        </label>
                        <div class="nts-field-input">
                            <textarea id="project_solutions" name="project_solutions" class="large-text" rows="8"><?php echo esc_textarea($project_solutions); ?></textarea>
                            <p class="nts-field-desc">Mô tả các giải pháp đã triển khai để giải quyết thách thức.</p>
                        </div>
                    </div>
                </div>
                
                <div id="tab-results" class="nts-tab-pane">
                    <div class="nts-field-group">
                        <label for="project_results" class="nts-field-label">
                            <span class="dashicons dashicons-chart-line"></span>
                            <span class="label-text">Kết quả</span>
                        </label>
                        <div class="nts-field-input">
                            <textarea id="project_results" name="project_results" class="large-text" rows="8"><?php echo esc_textarea($project_results); ?></textarea>
                            <p class="nts-field-desc">Mô tả kết quả đạt được sau khi triển khai dự án.</p>
                        </div>
                    </div>
                    
                    <div class="nts-field-group">
                        <label class="nts-field-label">
                            <span class="dashicons dashicons-chart-bar"></span>
                            <span class="label-text">Tỷ lệ kết quả chính</span>
                        </label>
                        
                        <div class="nts-meta-grid">
                            <div class="nts-field-input">
                                <label for="project_energy_saving" class="nts-sub-field-label">Tiết kiệm năng lượng (%)</label>
                                <input type="number" id="project_energy_saving" name="project_energy_saving" value="<?php echo esc_attr(get_post_meta($post->ID, 'project_energy_saving', true)); ?>" class="small-text" min="0" max="100" placeholder="30">
                            </div>
                            
                            <div class="nts-field-input">
                                <label for="project_water_recycling" class="nts-sub-field-label">Tái sử dụng nước (%)</label>
                                <input type="number" id="project_water_recycling" name="project_water_recycling" value="<?php echo esc_attr(get_post_meta($post->ID, 'project_water_recycling', true)); ?>" class="small-text" min="0" max="100" placeholder="85">
                            </div>
                        </div>
                        <p class="nts-field-desc">Nhập tỷ lệ phần trăm cho các kết quả chính của dự án. Những thông tin này sẽ được hiển thị trong phần kết quả dự án.</p>
                    </div>
                </div>
                
                <div id="tab-info" class="nts-tab-pane">
                    <div class="nts-meta-grid">
                        <div class="nts-field-group">
                            <label for="project_location" class="nts-field-label">
                                <span class="dashicons dashicons-location"></span>
                                <span class="label-text">Địa điểm</span>
                            </label>
                            <div class="nts-field-input">
                                <input type="text" id="project_location" name="project_location" value="<?php echo esc_attr($project_location); ?>" class="regular-text">
                                <p class="nts-field-desc">Nhập địa điểm thực hiện dự án.</p>
                            </div>
                        </div>
                        
                        <div class="nts-field-group">
                            <label for="project_time" class="nts-field-label">
                                <span class="dashicons dashicons-calendar-alt"></span>
                                <span class="label-text">Thời gian</span>
                            </label>
                            <div class="nts-field-input">
                                <input type="text" id="project_time" name="project_time" value="<?php echo esc_attr($project_time); ?>" class="regular-text">
                                <p class="nts-field-desc">Nhập thời gian thực hiện dự án (ví dụ: Tháng 3 - Tháng 5/2023).</p>
                            </div>
                        </div>
                        
                        <div class="nts-field-group">
                            <label for="project_technology" class="nts-field-label">
                                <span class="dashicons dashicons-admin-tools"></span>
                                <span class="label-text">Công nghệ sử dụng</span>
                            </label>
                            <div class="nts-field-input">
                                <input type="text" id="project_technology" name="project_technology" value="<?php echo esc_attr($project_technology); ?>" class="regular-text">
                                <p class="nts-field-desc">Nhập công nghệ chính áp dụng trong dự án.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

// Callback function cho metabox gallery
function nts_project_gallery_callback($post) {
    wp_nonce_field('nts_project_gallery_nonce', 'project_gallery_nonce');
    
    $gallery_images = get_post_meta($post->ID, 'project_gallery', true);
    
    ?>
    <div id="project_gallery_container" class="nts-gallery-container">
        <input type="hidden" id="project_gallery" name="project_gallery" value="<?php echo esc_attr($gallery_images ? implode(',', (array)$gallery_images) : ''); ?>">
        
        <div class="nts-gallery-header">
            <p class="nts-gallery-desc">
                <span class="dashicons dashicons-images-alt2"></span>
                Thêm hình ảnh vào thư viện dự án để hiển thị trong trang chi tiết.
            </p>
            <button type="button" class="button button-primary" id="add_project_gallery_images">
                <span class="dashicons dashicons-plus-alt"></span>
                Thêm hình ảnh
            </button>
        </div>
        
        <div id="project_gallery_preview" class="nts-gallery-preview">
            <?php
            if (!empty($gallery_images)) {
                $gallery_images_array = is_array($gallery_images) ? $gallery_images : explode(',', $gallery_images);
                foreach ($gallery_images_array as $image_id) {
                    $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                    if ($image_url) {
                        echo '<div class="gallery-item" data-id="' . esc_attr($image_id) . '">';
                        echo '<div class="gallery-item-inner">';
                        echo '<img src="' . esc_url($image_url) . '" alt="">';
                        echo '<div class="gallery-item-tools">';
                        echo '<button type="button" class="remove-image"><span class="dashicons dashicons-no-alt"></span></button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }
            ?>
            <div class="gallery-item gallery-item-add">
                <div class="gallery-item-inner add-placeholder">
                    <span class="dashicons dashicons-plus-alt2"></span>
                    <span class="add-text">Thêm ảnh</span>
                </div>
            </div>
        </div>
        
        <div class="nts-gallery-footer">
            <p class="nts-field-desc">
                <span class="dashicons dashicons-info"></span>
                Bạn có thể kéo thả để sắp xếp thứ tự hình ảnh.
            </p>
        </div>
    </div>
    <?php
}

// Callback function cho metabox số liệu dự án
function nts_project_statistics_callback($post) {
    wp_nonce_field('nts_project_statistics_nonce', 'project_statistics_nonce');
    
    // Lấy dữ liệu đã lưu
    $processing_capacity = get_post_meta($post->ID, 'project_processing_capacity', true);
    $implementation_time = get_post_meta($post->ID, 'project_implementation_time', true);
    $system_lifetime = get_post_meta($post->ID, 'project_system_lifetime', true);
    $purity_efficiency = get_post_meta($post->ID, 'project_purity_efficiency', true);
    
    ?>
    <div class="nts-meta-box-container">
        <p class="nts-field-desc">
            <span class="dashicons dashicons-chart-bar"></span>
            Thông tin số liệu sẽ hiển thị trong phần "Số liệu dự án" ở trang chi tiết.
        </p>
        
        <div class="nts-meta-grid">
            <div class="nts-field-group">
                <label for="project_processing_capacity" class="nts-field-label">
                    <span class="dashicons dashicons-database"></span>
                    <span class="label-text">Công suất xử lý</span>
                </label>
                <div class="nts-field-input">
                    <div class="nts-number-field">
                        <input type="text" id="project_processing_capacity" name="project_processing_capacity" value="<?php echo esc_attr($processing_capacity); ?>" class="regular-text" placeholder="Ví dụ: 1500">
                        <span class="nts-unit">m³/ngày</span>
                    </div>
                    <p class="nts-field-desc">Nhập công suất xử lý nước của dự án.</p>
                </div>
            </div>
            
            <div class="nts-field-group">
                <label for="project_implementation_time" class="nts-field-label">
                    <span class="dashicons dashicons-clock"></span>
                    <span class="label-text">Thời gian triển khai</span>
                </label>
                <div class="nts-field-input">
                    <div class="nts-number-field">
                        <input type="text" id="project_implementation_time" name="project_implementation_time" value="<?php echo esc_attr($implementation_time); ?>" class="regular-text" placeholder="Ví dụ: 3">
                        <span class="nts-unit">tháng</span>
                    </div>
                    <p class="nts-field-desc">Nhập thời gian triển khai dự án.</p>
                </div>
            </div>
            
            <div class="nts-field-group">
                <label for="project_system_lifetime" class="nts-field-label">
                    <span class="dashicons dashicons-backup"></span>
                    <span class="label-text">Tuổi thọ hệ thống</span>
                </label>
                <div class="nts-field-input">
                    <div class="nts-number-field">
                        <input type="text" id="project_system_lifetime" name="project_system_lifetime" value="<?php echo esc_attr($system_lifetime); ?>" class="regular-text" placeholder="Ví dụ: 25">
                        <span class="nts-unit">năm</span>
                    </div>
                    <p class="nts-field-desc">Nhập tuổi thọ dự kiến của hệ thống xử lý nước.</p>
                </div>
            </div>
            
            <div class="nts-field-group">
                <label for="project_purity_efficiency" class="nts-field-label">
                    <span class="dashicons dashicons-chart-line"></span>
                    <span class="label-text">Độ tinh khiết</span>
                </label>
                <div class="nts-field-input">
                    <div class="nts-number-field">
                        <input type="text" id="project_purity_efficiency" name="project_purity_efficiency" value="<?php echo esc_attr($purity_efficiency); ?>" class="regular-text" placeholder="Ví dụ: 98">
                        <span class="nts-unit">%</span>
                    </div>
                    <p class="nts-field-desc">Nhập hiệu suất độ tinh khiết của nước sau xử lý.</p>
                </div>
            </div>
        </div>
    </div>
    <?php
}

// Tạo file CSS cho metabox
function nts_create_project_admin_css() {
    $css_dir = get_template_directory() . '/assets/css/';
    $css_file = $css_dir . 'project-admin.css';
    
    // Kiểm tra thư mục tồn tại chưa, nếu chưa thì tạo mới
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }
    
    // Nội dung CSS
    $css_content = '/* Project Admin Metabox Styles */

/* General Styles */
.nts-meta-box-container {
    margin: 15px 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
}

/* Tabs Navigation */
.nts-meta-tabs {
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
}

.nts-tab-nav {
    display: flex;
    padding: 0;
    margin: 0;
    background: #f8f9fa;
    border-bottom: 1px solid #e2e4e7;
}

.nts-tab-nav li {
    cursor: pointer;
    margin: 0;
    padding: 15px 20px;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    border-right: 1px solid #e2e4e7;
    color: #555;
    transition: all 0.2s ease;
}

.nts-tab-nav li:hover {
    background: #f0f0f1;
    color: #0073aa;
}

.nts-tab-nav li.tab-active {
    background: #fff;
    color: #0073aa;
    border-bottom: 2px solid #0073aa;
    margin-bottom: -1px;
}

.nts-tab-nav li .dashicons {
    margin-right: 8px;
    font-size: 18px;
    width: 18px;
    height: 18px;
}

/* Tab Content */
.nts-tab-content {
    padding: 20px;
    background: #fff;
}

.nts-tab-pane {
    display: none;
}

.nts-tab-pane.active {
    display: block;
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Field Styles */
.nts-field-group {
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #f0f0f1;
}

.nts-field-group:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.nts-field-label {
    display: flex;
    align-items: center;
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 14px;
    color: #23282d;
}

.nts-sub-field-label {
    display: block;
    font-weight: 500;
    margin-bottom: 5px;
    font-size: 13px;
    color: #666;
}

.nts-field-label .dashicons {
    margin-right: 8px;
    color: #0073aa;
}

.nts-field-input input,
.nts-field-input textarea {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.07);
}

.nts-field-input input:focus,
.nts-field-input textarea:focus {
    border-color: #0073aa;
    box-shadow: 0 0 0 1px #0073aa;
    outline: 2px solid transparent;
}

.nts-field-desc {
    margin: 5px 0 0;
    color: #666;
    font-style: italic;
    font-size: 13px;
    display: flex;
    align-items: center;
}

.nts-field-desc .dashicons {
    margin-right: 5px;
    font-size: 16px;
    width: 16px;
    height: 16px;
}

/* Grid Layout for Fields */
.nts-meta-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

@media screen and (max-width: 782px) {
    .nts-meta-grid {
        grid-template-columns: 1fr;
    }
}

/* Number Field with Unit */
.nts-number-field {
    display: flex;
    align-items: center;
}

.nts-number-field input {
    flex-grow: 1;
}

.nts-unit {
    margin-left: 8px;
    padding: 8px;
    background: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: #666;
    font-size: 13px;
    line-height: 1;
    white-space: nowrap;
}

/* Gallery Styles */
.nts-gallery-container {
    margin: 15px 0;
}

.nts-gallery-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.nts-gallery-desc {
    margin: 0;
    font-size: 14px;
    display: flex;
    align-items: center;
}

.nts-gallery-desc .dashicons {
    margin-right: 8px;
    color: #0073aa;
}

#add_project_gallery_images {
    display: flex;
    align-items: center;
}

#add_project_gallery_images .dashicons {
    margin-right: 5px;
}

.nts-gallery-preview {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
    margin-bottom: 15px;
}

@media screen and (max-width: 1280px) {
    .nts-gallery-preview {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media screen and (max-width: 782px) {
    .nts-gallery-preview {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media screen and (max-width: 600px) {
    .nts-gallery-preview {
        grid-template-columns: repeat(2, 1fr);
    }
}

.gallery-item {
    position: relative;
    border-radius: 4px;
    overflow: hidden;
    cursor: move;
}

.gallery-item-inner {
    position: relative;
    padding-bottom: 100%;
    background: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 4px;
    overflow: hidden;
}

.gallery-item img {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    top: 0;
    left: 0;
}

.gallery-item-tools {
    position: absolute;
    top: 0;
    right: 0;
    padding: 5px;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.gallery-item:hover .gallery-item-tools {
    opacity: 1;
}

.remove-image {
    background: rgba(0, 0, 0, 0.7);
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    padding: 0;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.remove-image:hover {
    background: #dc3232;
}

.gallery-item-add {
    cursor: pointer;
}

.add-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #0073aa;
    transition: all 0.2s ease;
}

.add-placeholder:hover {
    background: #f0f0f1;
}

.add-placeholder .dashicons {
    font-size: 30px;
    width: 30px;
    height: 30px;
    margin-bottom: 5px;
}

.add-text {
    font-size: 13px;
    font-weight: 500;
}

.nts-gallery-footer {
    margin-top: 10px;
    border-top: 1px solid #f0f0f1;
    padding-top: 10px;
}

/* Drag and Drop Placeholder */
.ui-sortable-placeholder {
    visibility: visible !important;
    background: #e6f2f8 !important;
    border: 2px dashed #0073aa !important;
    border-radius: 4px !important;
}

/* Custom scrollbar */
.nts-tab-content::-webkit-scrollbar {
    width: 8px;
}

.nts-tab-content::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.nts-tab-content::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 4px;
}

.nts-tab-content::-webkit-scrollbar-thumb:hover {
    background: #0073aa;
}
';
    
    // Tạo file CSS
    file_put_contents($css_file, $css_content);
}

// Tạo file JavaScript cho metabox
function nts_create_project_admin_js() {
    $js_dir = get_template_directory() . '/assets/js/';
    $js_file = $js_dir . 'project-admin.js';
    
    // Kiểm tra thư mục tồn tại chưa, nếu chưa thì tạo mới
    if (!file_exists($js_dir)) {
        wp_mkdir_p($js_dir);
    }
    
    // Nội dung JavaScript
    $js_content = "
jQuery(document).ready(function($) {
    // Tab functionality
    $('.nts-tab-nav li').on('click', function() {
        var tab_id = $(this).data('tab');
        
        $('.nts-tab-nav li').removeClass('tab-active');
        $('.nts-tab-pane').removeClass('active');
        
        $(this).addClass('tab-active');
        $('#' + tab_id).addClass('active');
    });
    
    // Gallery image uploader
    function initGalleryUpload() {
        $('#add_project_gallery_images, .gallery-item-add').on('click', function(e) {
            e.preventDefault();
            
            var galleryPreview = $('#project_gallery_preview');
            var galleryInput = $('#project_gallery');
            
            var frame = wp.media({
                title: 'Chọn hình ảnh cho dự án',
                button: {
                    text: 'Thêm vào thư viện'
                },
                multiple: true
            });
            
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var galleryIds = galleryInput.val() ? galleryInput.val().split(',') : [];
                
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    
                    if ($.inArray(attachment.id.toString(), galleryIds) === -1) {
                        galleryIds.push(attachment.id);
                        
                        var image = $('<div class=\"gallery-item\" data-id=\"' + attachment.id + '\"></div>');
                        image.append('<div class=\"gallery-item-inner\"><img src=\"' + attachment.sizes.thumbnail.url + '\" alt=\"\"><div class=\"gallery-item-tools\"><button type=\"button\" class=\"remove-image\"><span class=\"dashicons dashicons-no-alt\"></span></button></div></div>');
                        
                        // Insert before the add button
                        $('.gallery-item-add').before(image);
                    }
                });
                
                // Ensure galleryIds contains only non-empty string values
                galleryIds = galleryIds.filter(function(id) { 
                    return id && id.trim() !== ''; 
                });
                
                galleryInput.val(galleryIds.join(','));
                
                // Reinitialize sortable after adding new items
                initSortable();
                
                // Trigger change event on input to ensure WordPress recognizes the change
                galleryInput.trigger('change');
            });
            
            frame.open();
        });
        
        // Remove image functionality
        $('#project_gallery_preview').on('click', '.remove-image', function() {
            var item = $(this).closest('.gallery-item');
            var galleryInput = $('#project_gallery');
            var imageId = item.data('id').toString();
            var galleryIds = galleryInput.val() ? galleryInput.val().split(',') : [];
            
            galleryIds = galleryIds.filter(function(id) {
                return id !== imageId && id.trim() !== '';
            });
            
            galleryInput.val(galleryIds.join(','));
            item.remove();
            
            // Trigger change event on input to ensure WordPress recognizes the change
            galleryInput.trigger('change');
        });
    }
    
    // Make gallery items sortable
    function initSortable() {
        $('#project_gallery_preview').sortable({
            items: '.gallery-item:not(.gallery-item-add)',
            placeholder: 'ui-sortable-placeholder',
            cursor: 'move',
            update: function(event, ui) {
                var galleryInput = $('#project_gallery');
                var galleryIds = [];
                
                $('#project_gallery_preview .gallery-item:not(.gallery-item-add)').each(function() {
                    galleryIds.push($(this).data('id'));
                });
                
                // Ensure galleryIds contains only non-empty string values
                galleryIds = galleryIds.filter(function(id) { 
                    return id && id.toString().trim() !== ''; 
                });
                
                galleryInput.val(galleryIds.join(','));
                
                // Trigger change event on input to ensure WordPress recognizes the change
                galleryInput.trigger('change');
            }
        });
    }
    
    // Initialize functions
    initGalleryUpload();
    initSortable();
    
    // Add WordPress color picker to color fields if they exist
    if ($.fn.wpColorPicker) {
        $('.nts-color-picker').wpColorPicker();
    }
    
    // Ensure form submission captures the latest gallery values
    $('form#post').on('submit', function() {
        var galleryInput = $('#project_gallery');
        var galleryIds = [];
        
        $('#project_gallery_preview .gallery-item:not(.gallery-item-add)').each(function() {
            galleryIds.push($(this).data('id'));
        });
        
        // Ensure galleryIds contains only non-empty string values
        galleryIds = galleryIds.filter(function(id) { 
            return id && id.toString().trim() !== ''; 
        });
        
        galleryInput.val(galleryIds.join(','));
    });
});
";
    
    // Tạo file JavaScript
    file_put_contents($js_file, $js_content);
}

// Hook để tạo file CSS và JS khi theme được kích hoạt
function nts_project_setup_files() {
    $css_dir = get_template_directory() . '/assets/css/';
    $css_file = $css_dir . 'project-admin.css';
    $js_dir = get_template_directory() . '/assets/js/';
    $js_file = $js_dir . 'project-admin.js';
    
    // Chỉ tạo các file nếu chưa tồn tại
    if (!file_exists($css_file)) {
        // Đảm bảo thư mục tồn tại
        if (!file_exists($css_dir)) {
            wp_mkdir_p($css_dir);
        }
        nts_create_project_admin_css();
    }
    
    if (!file_exists($js_file)) {
        // Đảm bảo thư mục tồn tại
        if (!file_exists($js_dir)) {
            wp_mkdir_p($js_dir);
        }
        nts_create_project_admin_js();
    }
}
// Thực thi khi theme được kích hoạt
add_action('after_switch_theme', 'nts_project_setup_files');
// Thực thi trên init để đảm bảo file được tạo nếu chưa tồn tại
add_action('init', 'nts_project_setup_files');

// Lưu dữ liệu custom fields khi lưu post
function nts_save_project_meta($post_id) {
    // Kiểm tra nếu đang thực hiện auto-save, không làm gì cả
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Kiểm tra nếu post type không phải là 'project', không làm gì cả
    if (!isset($_POST['post_type']) || $_POST['post_type'] !== 'project') {
        return;
    }
    
    // Kiểm tra permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Kiểm tra nonce cho project details
    if (!isset($_POST['project_details_nonce']) || !wp_verify_nonce($_POST['project_details_nonce'], 'nts_project_details_nonce')) {
        error_log('Project details nonce verification failed');
        return;
    }
    
    // Kiểm tra nonce cho project gallery
    if (!isset($_POST['project_gallery_nonce']) || !wp_verify_nonce($_POST['project_gallery_nonce'], 'nts_project_gallery_nonce')) {
        error_log('Project gallery nonce verification failed');
        return;
    }
    
    // Kiểm tra nonce cho project statistics
    if (!isset($_POST['project_statistics_nonce']) || !wp_verify_nonce($_POST['project_statistics_nonce'], 'nts_project_statistics_nonce')) {
        error_log('Project statistics nonce verification failed');
        return;
    }
    
    // Lưu dữ liệu details
    if (isset($_POST['project_description'])) {
        update_post_meta($post_id, 'project_description', wp_kses_post($_POST['project_description']));
    }
    
    if (isset($_POST['project_challenges'])) {
        update_post_meta($post_id, 'project_challenges', wp_kses_post($_POST['project_challenges']));
    }
    
    if (isset($_POST['project_solutions'])) {
        update_post_meta($post_id, 'project_solutions', wp_kses_post($_POST['project_solutions']));
    }
    
    if (isset($_POST['project_results'])) {
        update_post_meta($post_id, 'project_results', wp_kses_post($_POST['project_results']));
    }
    
    if (isset($_POST['project_location'])) {
        update_post_meta($post_id, 'project_location', sanitize_text_field($_POST['project_location']));
    }
    
    if (isset($_POST['project_time'])) {
        update_post_meta($post_id, 'project_time', sanitize_text_field($_POST['project_time']));
    }
    
    if (isset($_POST['project_technology'])) {
        update_post_meta($post_id, 'project_technology', sanitize_text_field($_POST['project_technology']));
    }
    
    // Lưu dữ liệu số liệu dự án
    if (isset($_POST['project_processing_capacity'])) {
        update_post_meta($post_id, 'project_processing_capacity', sanitize_text_field($_POST['project_processing_capacity']));
    }
    
    if (isset($_POST['project_implementation_time'])) {
        update_post_meta($post_id, 'project_implementation_time', sanitize_text_field($_POST['project_implementation_time']));
    }
    
    if (isset($_POST['project_system_lifetime'])) {
        update_post_meta($post_id, 'project_system_lifetime', sanitize_text_field($_POST['project_system_lifetime']));
    }
    
    if (isset($_POST['project_purity_efficiency'])) {
        update_post_meta($post_id, 'project_purity_efficiency', sanitize_text_field($_POST['project_purity_efficiency']));
    }
    
    // Lưu dữ liệu kết quả dự án
    if (isset($_POST['project_energy_saving'])) {
        update_post_meta($post_id, 'project_energy_saving', sanitize_text_field($_POST['project_energy_saving']));
    }
    
    if (isset($_POST['project_water_recycling'])) {
        update_post_meta($post_id, 'project_water_recycling', sanitize_text_field($_POST['project_water_recycling']));
    }
    
    // Lưu dữ liệu gallery
    if (isset($_POST['project_gallery'])) {
        // Debug: Log gallery input
        error_log('Project gallery input: ' . $_POST['project_gallery']);
        
        // Xử lý và lọc IDs
        $gallery_ids = array_filter(
            explode(',', sanitize_text_field($_POST['project_gallery'])),
            function($id) { return !empty(trim($id)); }
        );
        
        // Debug: Log gallery IDs after processing
        error_log('Project gallery IDs after processing: ' . implode(',', $gallery_ids));
        
        // Cập nhật post meta
        update_post_meta($post_id, 'project_gallery', $gallery_ids);
    } else {
        error_log('Project gallery not found in POST data');
    }
}
add_action('save_post', 'nts_save_project_meta');
