/**
 * NTSE Theme - Admin JavaScript
 * 
 * This file contains all the JavaScript functionality used in the WordPress admin area
 * for post type metaboxes, settings pages, and other admin features.
 */

jQuery(document).ready(function($) {
    // Media Uploader for Hero Image
    $('#upload_hero_image_button').on('click', function() {
        var image_frame;
        if (image_frame) {
            image_frame.open();
            return;
        }

        image_frame = wp.media({
            title: 'Chọn hoặc tải lên hình ảnh',
            button: {
                text: 'Sử dụng hình ảnh này',
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

    $('#remove_hero_image_button').on('click', function() {
        $('#hero_image_id').val('');
        $('#hero_image_preview').html('');
        $(this).hide();
    });

    // Media Uploader for Introduction Image
    $('#upload_introduction_image_button').on('click', function() {
        var image_frame;
        if (image_frame) {
            image_frame.open();
            return;
        }

        image_frame = wp.media({
            title: 'Chọn hoặc tải lên hình ảnh',
            button: {
                text: 'Sử dụng hình ảnh này',
            },
            multiple: false
        });

        image_frame.on('select', function() {
            var attachment = image_frame.state().get('selection').first().toJSON();
            $('#introduction_image_id').val(attachment.id);
            $('#introduction_image_preview').html('<img src="' + attachment.url + '" alt="" style="max-width:100%;">');
            $('#remove_introduction_image_button').show();
        });

        image_frame.open();
    });

    $('#remove_introduction_image_button').on('click', function() {
        $('#introduction_image_id').val('');
        $('#introduction_image_preview').html('');
        $(this).hide();
    });

    // Function for handling all media uploaders with a common structure
    function setupMediaUploader(uploadButtonId, removeButtonId, imageIdField, previewContainer) {
        $(uploadButtonId).on('click', function() {
            var image_frame;
            if (image_frame) {
                image_frame.open();
                return;
            }

            image_frame = wp.media({
                title: 'Chọn hoặc tải lên hình ảnh',
                button: {
                    text: 'Sử dụng hình ảnh này',
                },
                multiple: false
            });

            image_frame.on('select', function() {
                var attachment = image_frame.state().get('selection').first().toJSON();
                $(imageIdField).val(attachment.id);
                $(previewContainer).html('<img src="' + attachment.url + '" alt="" style="max-width:100%;">');
                $(removeButtonId).show();
            });

            image_frame.open();
        });

        $(removeButtonId).on('click', function() {
            $(imageIdField).val('');
            $(previewContainer).html('');
            $(this).hide();
        });
    }

    // Setup media uploaders for various fields if they exist
    if ($('#upload_feature_image_button').length) {
        setupMediaUploader(
            '#upload_feature_image_button',
            '#remove_feature_image_button',
            '#feature_image_id',
            '#feature_image_preview'
        );
    }

    if ($('#upload_gallery_image_button').length) {
        setupMediaUploader(
            '#upload_gallery_image_button',
            '#remove_gallery_image_button',
            '#gallery_image_id',
            '#gallery_image_preview'
        );
    }

    // Handle dynamic rows for benefits
    $('.add-benefit-button').on('click', function() {
        var $container = $(this).closest('.form-field').find('.benefits-container');
        var index = $container.find('.benefit-item').length;
        
        var html = '<div class="benefit-item">' +
                   '<input type="text" name="benefits[' + index + '][title]" placeholder="Tiêu đề lợi ích" class="benefit-title" value="">' +
                   '<textarea name="benefits[' + index + '][description]" placeholder="Mô tả lợi ích" class="benefit-description"></textarea>' +
                   '<button type="button" class="button remove-benefit-button">Xóa</button>' +
                   '</div>';
        
        $container.append(html);
    });
    
    // Remove benefit item
    $(document).on('click', '.remove-benefit-button', function() {
        $(this).closest('.benefit-item').remove();
    });

    // Handle dynamic rows for features
    $('.add-feature-button').on('click', function() {
        var $container = $(this).closest('.form-field').find('.features-container');
        var index = $container.find('.feature-item').length;
        
        var html = '<div class="feature-item">' +
                   '<input type="text" name="features[' + index + '][title]" placeholder="Tiêu đề tính năng" class="feature-title" value="">' +
                   '<textarea name="features[' + index + '][description]" placeholder="Mô tả tính năng" class="feature-description"></textarea>' +
                   '<button type="button" class="button remove-feature-button">Xóa</button>' +
                   '</div>';
        
        $container.append(html);
    });
    
    // Remove feature item
    $(document).on('click', '.remove-feature-button', function() {
        $(this).closest('.feature-item').remove();
    });

    // Handle dynamic rows for FAQs
    $('.add-faq-button').on('click', function() {
        var $container = $(this).closest('.form-field').find('.faqs-container');
        var index = $container.find('.faq-item').length;
        
        var html = '<div class="faq-item">' +
                   '<input type="text" name="faqs[' + index + '][question]" placeholder="Câu hỏi" class="faq-question" value="">' +
                   '<textarea name="faqs[' + index + '][answer]" placeholder="Câu trả lời" class="faq-answer"></textarea>' +
                   '<button type="button" class="button remove-faq-button">Xóa</button>' +
                   '</div>';
        
        $container.append(html);
    });
    
    // Remove FAQ item
    $(document).on('click', '.remove-faq-button', function() {
        $(this).closest('.faq-item').remove();
    });

    // Sort functionality for dynamic items with drag and drop
    if ($.fn.sortable) {
        $('.benefits-container, .features-container, .faqs-container').sortable({
            handle: '.sort-handle',
            update: function() {
                // Optional: Update indices after sorting
            }
        });
    }

    // Product Category metabox functionality
    if ($('.product-category-fields').length) {
        // Category image uploader
        $('.upload_category_image_button').on('click', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var customUploader = wp.media({
                title: 'Chọn hình ảnh danh mục',
                library: {
                    type: 'image'
                },
                button: {
                    text: 'Sử dụng hình ảnh này'
                },
                multiple: false
            }).on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                $('.category_image').val(attachment.id);
                $('.category_image_preview').html('<img src="' + attachment.url + '" style="max-width:100%;height:auto;">');
                $('.remove_category_image_button').show();
            }).open();
        });
        
        $('.remove_category_image_button').on('click', function(e) {
            e.preventDefault();
            $('.category_image').val('');
            $('.category_image_preview').html('');
            $(this).hide();
        });
    }

    // Service Post Type metabox functionality
    if ($('.service-process-step-container').length) {
        // Add process step
        $('.add-process-step').on('click', function() {
            var container = $('.service-process-step-container');
            var count = container.find('.process-step').length;
            
            var html = '<div class="process-step">' +
                       '<div class="process-step-header">' +
                       '<span class="step-number">Bước ' + (count + 1) + '</span>' +
                       '<span class="remove-step dashicons dashicons-no-alt"></span>' +
                       '</div>' +
                       '<div class="process-step-content">' +
                       '<input type="text" name="_service_process_steps[' + count + '][title]" placeholder="Tiêu đề bước" value="">' +
                       '<textarea name="_service_process_steps[' + count + '][description]" placeholder="Mô tả chi tiết bước thực hiện"></textarea>' +
                       '<input type="text" name="_service_process_steps[' + count + '][time]" placeholder="Thời gian (tùy chọn)" value="">' +
                       '</div>' +
                       '</div>';
            
            container.append(html);
        });
        
        // Remove process step
        $(document).on('click', '.remove-step', function() {
            $(this).closest('.process-step').remove();
            // Renumber steps
            $('.process-step').each(function(index) {
                $(this).find('.step-number').text('Bước ' + (index + 1));
            });
        });
    }

    // Testimonial functionality
    if ($('.testimonial-container').length) {
        // Add testimonial
        $('.add-testimonial').on('click', function() {
            var container = $('.testimonial-container');
            var count = container.find('.testimonial-item').length;
            
            var html = '<div class="testimonial-item">' +
                       '<div class="testimonial-header">' +
                       '<span class="testimonial-title">Đánh giá #' + (count + 1) + '</span>' +
                       '<span class="remove-testimonial dashicons dashicons-no-alt"></span>' +
                       '</div>' +
                       '<div class="testimonial-content">' +
                       '<input type="text" name="_service_testimonials[' + count + '][name]" placeholder="Tên khách hàng" value="">' +
                       '<input type="text" name="_service_testimonials[' + count + '][role]" placeholder="Chức vụ/công ty" value="">' +
                       '<textarea name="_service_testimonials[' + count + '][content]" placeholder="Nội dung đánh giá"></textarea>' +
                       '<div class="rating-field">' +
                       '<label>Đánh giá (1-5):</label>' +
                       '<select name="_service_testimonials[' + count + '][rating]">' +
                       '<option value="5">5 sao</option>' +
                       '<option value="4">4 sao</option>' +
                       '<option value="3">3 sao</option>' +
                       '<option value="2">2 sao</option>' +
                       '<option value="1">1 sao</option>' +
                       '</select>' +
                       '</div>' +
                       '</div>' +
                       '</div>';
            
            container.append(html);
        });
        
        // Remove testimonial
        $(document).on('click', '.remove-testimonial', function() {
            $(this).closest('.testimonial-item').remove();
            // Renumber testimonials
            $('.testimonial-item').each(function(index) {
                $(this).find('.testimonial-title').text('Đánh giá #' + (index + 1));
            });
        });
    }

    // FAQ functionality
    if ($('.faq-container').length) {
        // Add FAQ
        $('.add-faq').on('click', function() {
            var container = $('.faq-container');
            var count = container.find('.faq-item').length;
            
            var html = '<div class="faq-item">' +
                       '<div class="faq-header">' +
                       '<span class="faq-title">Câu hỏi #' + (count + 1) + '</span>' +
                       '<span class="remove-faq dashicons dashicons-no-alt"></span>' +
                       '</div>' +
                       '<div class="faq-content">' +
                       '<input type="text" name="_service_faqs[' + count + '][question]" placeholder="Câu hỏi" value="">' +
                       '<textarea name="_service_faqs[' + count + '][answer]" placeholder="Câu trả lời"></textarea>' +
                       '</div>' +
                       '</div>';
            
            container.append(html);
        });
        
        // Remove FAQ
        $(document).on('click', '.remove-faq', function() {
            $(this).closest('.faq-item').remove();
            // Renumber FAQs
            $('.faq-item').each(function(index) {
                $(this).find('.faq-title').text('Câu hỏi #' + (index + 1));
            });
        });
    }
}); 