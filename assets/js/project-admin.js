/* Project Admin Script */
jQuery(document).ready(function($) {
    console.log('Project admin script loaded');
    
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
            console.log('Add gallery images clicked');
            
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
                
                console.log('Current gallery ids:', galleryIds);
                
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    console.log('Selected attachment:', attachment);
                    
                    if ($.inArray(attachment.id.toString(), galleryIds) === -1) {
                        galleryIds.push(attachment.id);
                        
                        var image = $('<div class="gallery-item" data-id="' + attachment.id + '"></div>');
                        image.append('<div class="gallery-item-inner"><img src="' + attachment.sizes.thumbnail.url + '" alt=""><div class="gallery-item-tools"><button type="button" class="remove-image"><span class="dashicons dashicons-no-alt"></span></button></div></div>');
                        
                        // Insert before the add button
                        $('.gallery-item-add').before(image);
                    }
                });
                
                // Ensure galleryIds contains only non-empty string values
                galleryIds = galleryIds.filter(function(id) { 
                    return id && id.trim() !== ''; 
                });
                
                console.log('Updated gallery ids:', galleryIds);
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
            
            console.log('Removing image with id:', imageId);
            console.log('Current gallery ids:', galleryIds);
            
            galleryIds = galleryIds.filter(function(id) {
                return id !== imageId && id.trim() !== '';
            });
            
            console.log('Updated gallery ids after removal:', galleryIds);
            galleryInput.val(galleryIds.join(','));
            item.remove();
            
            // Trigger change event on input to ensure WordPress recognizes the change
            galleryInput.trigger('change');
        });
    }
    
    // Make gallery items sortable
    function initSortable() {
        if (!$('#project_gallery_preview').hasClass('ui-sortable') && $('#project_gallery_preview').length > 0) {
            console.log('Initializing sortable');
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
                    
                    console.log('Updated gallery ids after sorting:', galleryIds);
                    galleryInput.val(galleryIds.join(','));
                    
                    // Trigger change event on input to ensure WordPress recognizes the change
                    galleryInput.trigger('change');
                }
            });
        } else {
            console.log('Sortable already initialized or container not found');
        }
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
        console.log('Form submission detected');
        var galleryInput = $('#project_gallery');
        var galleryIds = [];
        
        $('#project_gallery_preview .gallery-item:not(.gallery-item-add)').each(function() {
            galleryIds.push($(this).data('id'));
        });
        
        // Ensure galleryIds contains only non-empty string values
        galleryIds = galleryIds.filter(function(id) { 
            return id && id.toString().trim() !== ''; 
        });
        
        console.log('Final gallery ids on form submission:', galleryIds);
        galleryInput.val(galleryIds.join(','));
    });
});
