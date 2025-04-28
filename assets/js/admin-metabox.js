jQuery(document).ready(function($) {
    'use strict';

    // Initialize all features
    initRepeaters();
    initAccordion();
    initImageUploads();
    initGalleryUploads();
    initTabs();
    initColorPickers();
    initIconSelectors();
    initTooltips();
    initToggleSwitches();
    initSortableSections();
    initDynamicFields();

    /**
     * Initialize repeater fields
     */
    function initRepeaters() {
        // Add new repeater item
        $(document).on('click', '.ntse-add-repeater-item', function(e) {
            e.preventDefault();

            var $repeater = $(this).prev('.ntse-repeater');
            var $template = $repeater.find('.ntse-repeater-template').html();
            var templateId = 'ntse_template_' + Math.floor(Math.random() * 10000);
            
            // Replace placeholder ID with a unique ID
            $template = $template.replace(/{{id}}/g, templateId);
            
            $repeater.append($template);
            
            // Initialize any nested features in the new item
            initImageUploads();
            initColorPickers();
            initIconSelectors();
            
            // Trigger a custom event for plugins to hook into
            $(document).trigger('ntse_repeater_item_added', [$repeater.find('.ntse-repeater-item').last()]);
        });

        // Remove repeater item
        $(document).on('click', '.ntse-remove-item', function(e) {
            e.preventDefault();

            var $item = $(this).closest('.ntse-repeater-item');
            
            if (confirm('Are you sure you want to remove this item? This action cannot be undone.')) {
                $item.slideUp(300, function() {
                    $(this).remove();
                    // Trigger a custom event for plugins to hook into
                    $(document).trigger('ntse_repeater_item_removed');
                });
            }
        });
    }

    /**
     * Initialize accordion functionality for repeaters
     */
    function initAccordion() {
        $(document).on('click', '.ntse-repeater-title', function() {
            var $content = $(this).next('.ntse-repeater-content');
            
            // Toggle active class
            $(this).toggleClass('active');
            
            // Toggle content with slide animation
            $content.slideToggle(300);
            
            // Close other items if needed
            if ($(this).hasClass('active') && $(this).data('accordion') === 'single') {
                $(this).closest('.ntse-repeater').find('.ntse-repeater-title').not($(this)).removeClass('active');
                $(this).closest('.ntse-repeater').find('.ntse-repeater-content').not($content).slideUp(300);
            }
        });
    }

    /**
     * Initialize image upload fields
     */
    function initImageUploads() {
        $('.ntse-image-upload:not(.initialized)').each(function() {
            var $upload = $(this);
            var $button = $upload.find('.ntse-upload-image');
            var $preview = $upload.find('.ntse-image-preview');
            var $input = $upload.find('.ntse-image-id');
            var $remove = $upload.find('.ntse-remove-image');
            
            // Mark as initialized to prevent duplicate initialization
            $upload.addClass('initialized');
            
            // Handle the upload button click
            $button.on('click', function(e) {
                e.preventDefault();
                
                var mediaFrame;
                
                // If the media frame already exists, reopen it
                if (mediaFrame) {
                    mediaFrame.open();
                    return;
                }
                
                // Create a new media frame
                mediaFrame = wp.media({
                    title: 'Select or Upload an Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false,
                    library: {
                        type: 'image'
                    }
                });
                
                // When an image is selected in the media frame
                mediaFrame.on('select', function() {
                    var attachment = mediaFrame.state().get('selection').first().toJSON();
                    
                    // Set the image ID value
                    $input.val(attachment.id);
                    
                    // Update the preview
                    if (attachment.sizes && attachment.sizes.medium) {
                        $preview.html('<img src="' + attachment.sizes.medium.url + '" alt="">');
                    } else {
                        $preview.html('<img src="' + attachment.url + '" alt="">');
                    }
                    
                    // Show the remove button
                    $remove.show();
                    
                    // Trigger change for any dependencies
                    $input.trigger('change');
                });
                
                // Open the media frame
                mediaFrame.open();
            });
            
            // Handle the remove button click
            $remove.on('click', function(e) {
                e.preventDefault();
                
                // Clear the image ID value
                $input.val('');
                
                // Clear the preview
                $preview.html('');
                
                // Hide the remove button
                $(this).hide();
                
                // Trigger change for any dependencies
                $input.trigger('change');
            });
            
            // Show/hide the remove button on init
            if ($input.val()) {
                $remove.show();
            } else {
                $remove.hide();
            }
        });
    }

    /**
     * Initialize gallery upload fields
     */
    function initGalleryUploads() {
        $('.ntse-gallery-upload:not(.initialized)').each(function() {
            var $upload = $(this);
            var $button = $upload.find('.ntse-upload-gallery');
            var $preview = $upload.find('.ntse-gallery-preview');
            var $input = $upload.find('.ntse-gallery-ids');
            
            // Mark as initialized to prevent duplicate initialization
            $upload.addClass('initialized');
            
            // Make gallery sortable
            $preview.sortable({
                items: '.ntse-gallery-item',
                placeholder: 'ntse-gallery-item ntse-gallery-item-placeholder',
                cursor: 'move',
                opacity: 0.7,
                update: function() {
                    updateGalleryIds($upload);
                }
            });
            
            // Handle the upload button click
            $button.on('click', function(e) {
                e.preventDefault();
                
                var mediaFrame;
                
                // If the media frame already exists, reopen it
                if (mediaFrame) {
                    mediaFrame.open();
                    return;
                }
                
                // Create a new media frame
                mediaFrame = wp.media({
                    title: 'Select or Upload Images',
                    button: {
                        text: 'Add to gallery'
                    },
                    multiple: true,
                    library: {
                        type: 'image'
                    }
                });
                
                // When images are selected in the media frame
                mediaFrame.on('select', function() {
                    var attachments = mediaFrame.state().get('selection').toJSON();
                    var existingIds = $input.val() ? $input.val().split(',') : [];
                    
                    // Process each selected image
                    $.each(attachments, function(index, attachment) {
                        // Only add if not already in the gallery
                        if ($.inArray(attachment.id.toString(), existingIds) === -1) {
                            existingIds.push(attachment.id.toString());
                            
                            // Add image to preview
                            var imageUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                            var $item = $('<div class="ntse-gallery-item" data-id="' + attachment.id + '">' +
                                '<img src="' + imageUrl + '" alt="">' +
                                '<span class="ntse-remove-gallery-item dashicons dashicons-no-alt"></span>' +
                                '</div>');
                            
                            $preview.append($item);
                        }
                    });
                    
                    // Update the gallery IDs
                    updateGalleryIds($upload);
                });
                
                // Open the media frame
                mediaFrame.open();
            });
            
            // Handle the remove button click
            $(document).on('click', '.ntse-remove-gallery-item', function(e) {
                e.preventDefault();
                
                $(this).parent().remove();
                
                // Update the gallery IDs
                updateGalleryIds($upload);
            });
            
            // Update the gallery IDs on init
            updateGalleryIds($upload);
        });
        
        // Helper function to update gallery IDs
        function updateGalleryIds($upload) {
            var $input = $upload.find('.ntse-gallery-ids');
            var $items = $upload.find('.ntse-gallery-preview .ntse-gallery-item');
            var ids = [];
            
            $items.each(function() {
                ids.push($(this).data('id'));
            });
            
            $input.val(ids.join(','));
            $input.trigger('change');
        }
    }

    /**
     * Initialize tabs
     */
    function initTabs() {
        $('.ntse-tabs-container').each(function() {
            var $container = $(this);
            var $tabs = $container.find('.ntse-tab');
            var $contents = $container.find('.ntse-tab-content');
            
            // Set the first tab as active by default
            if (!$tabs.filter('.active').length) {
                $tabs.first().addClass('active');
                $contents.first().addClass('active');
            }
            
            // Handle tab clicks
            $tabs.on('click', function(e) {
                e.preventDefault();
                
                var tabId = $(this).data('tab');
                
                // Update active tab
                $tabs.removeClass('active');
                $(this).addClass('active');
                
                // Show the corresponding content
                $contents.removeClass('active');
                $container.find('.ntse-tab-content[data-tab="' + tabId + '"]').addClass('active');
                
                // Save the active tab in a hidden field for persistence
                $container.find('.ntse-active-tab').val(tabId);
            });
        });
    }

    /**
     * Initialize color pickers
     */
    function initColorPickers() {
        $('.ntse-color-picker:not(.initialized)').each(function() {
            var $input = $(this);
            var $preview = $input.next('.ntse-color-preview');
            
            // Mark as initialized
            $input.addClass('initialized');
            
            // Initialize color picker
            $input.wpColorPicker({
                change: function(event, ui) {
                    var color = ui.color.toString();
                    $preview.css('background-color', color);
                    $input.trigger('change');
                },
                clear: function() {
                    $preview.css('background-color', '');
                    $input.trigger('change');
                }
            });
            
            // Update preview on init
            if ($input.val()) {
                $preview.css('background-color', $input.val());
            }
        });
    }

    /**
     * Initialize icon selectors
     */
    function initIconSelectors() {
        $('.ntse-icon-field:not(.initialized)').each(function() {
            var $field = $(this);
            var $input = $field.find('.ntse-icon-value');
            var $selector = $field.find('.ntse-icon-selector');
            var $preview = $field.find('.ntse-icon-preview');
            var $toggle = $field.find('.ntse-icon-toggle');
            
            // Mark as initialized
            $field.addClass('initialized');
            
            // Toggle icon selector
            $toggle.on('click', function(e) {
                e.preventDefault();
                $selector.slideToggle(300);
            });
            
            // Select an icon
            $selector.on('click', '.ntse-icon-option', function() {
                var iconClass = $(this).data('icon');
                
                // Update active icon
                $selector.find('.ntse-icon-option').removeClass('selected');
                $(this).addClass('selected');
                
                // Update the input value
                $input.val(iconClass).trigger('change');
                
                // Update the preview
                updateIconPreview();
                
                // Hide the selector
                $selector.slideUp(300);
            });
            
            // Helper function to update icon preview
            function updateIconPreview() {
                var iconClass = $input.val();
                
                if (iconClass) {
                    $preview.html('<i class="' + iconClass + '"></i>');
                } else {
                    $preview.html('<span class="no-icon">No icon selected</span>');
                }
            }
            
            // Update preview on init
            updateIconPreview();
        });
    }

    /**
     * Initialize tooltips
     */
    function initTooltips() {
        $('.ntse-tooltip').each(function() {
            var $tooltip = $(this);
            var $content = $tooltip.find('.ntse-tooltip-content');
            
            // Position the tooltip correctly
            $tooltip.on('mouseenter', function() {
                var tooltipWidth = $content.outerWidth();
                var tooltipLeft = -tooltipWidth / 2 + $tooltip.width() / 2;
                
                $content.css('margin-left', tooltipLeft + 'px');
            });
        });
    }

    /**
     * Initialize toggle switches
     */
    function initToggleSwitches() {
        $('.ntse-toggle-switch input').on('change', function() {
            var $input = $(this);
            var $field = $input.closest('.ntse-metabox-row');
            var $dependent = $('.ntse-dependent-field[data-depends-on="' + $input.attr('name') + '"]');
            
            if ($input.is(':checked')) {
                $dependent.slideDown(300);
            } else {
                $dependent.slideUp(300);
            }
        }).trigger('change');
    }

    /**
     * Initialize sortable sections
     */
    function initSortableSections() {
        $('.ntse-sortable-sections').each(function() {
            var $container = $(this);
            var $input = $container.find('.ntse-sections-order');
            
            $container.sortable({
                items: '.ntse-section',
                handle: '.ntse-section-handle',
                placeholder: 'ntse-section-placeholder',
                cursor: 'move',
                opacity: 0.7,
                update: function() {
                    updateSectionsOrder($container);
                }
            });
            
            // Helper function to update sections order
            function updateSectionsOrder($container) {
                var $sections = $container.find('.ntse-section');
                var order = [];
                
                $sections.each(function() {
                    order.push($(this).data('section-id'));
                });
                
                $input.val(order.join(','));
                $input.trigger('change');
            }
            
            // Update order on init
            updateSectionsOrder($container);
        });
    }

    /**
     * Initialize dynamic fields with conditional logic
     */
    function initDynamicFields() {
        // Process conditional fields
        $('.ntse-conditional-field').each(function() {
            var $field = $(this);
            var conditions = $field.data('conditions');
            
            if (typeof conditions === 'string') {
                try {
                    conditions = JSON.parse(conditions);
                } catch (e) {
                    console.error('Invalid conditions format', e);
                    return;
                }
            }
            
            // Process dependencies
            processFieldConditions($field, conditions);
            
            // Listen for changes on dependency fields
            $.each(conditions, function(i, condition) {
                var $dependencyField = $('[name="' + condition.field + '"]');
                
                $dependencyField.on('change', function() {
                    processFieldConditions($field, conditions);
                });
            });
        });
        
        // Helper function to process field conditions
        function processFieldConditions($field, conditions) {
            var show = true;
            
            $.each(conditions, function(i, condition) {
                var $dependencyField = $('[name="' + condition.field + '"]');
                var fieldValue = $dependencyField.val();
                
                // Handle checkbox/radio
                if ($dependencyField.is(':checkbox') || $dependencyField.is(':radio')) {
                    fieldValue = $dependencyField.is(':checked');
                }
                
                // Evaluate the condition
                var conditionMet = false;
                
                switch (condition.operator) {
                    case '==':
                        conditionMet = fieldValue == condition.value;
                        break;
                    case '!=':
                        conditionMet = fieldValue != condition.value;
                        break;
                    case '>':
                        conditionMet = parseFloat(fieldValue) > parseFloat(condition.value);
                        break;
                    case '<':
                        conditionMet = parseFloat(fieldValue) < parseFloat(condition.value);
                        break;
                    case 'contains':
                        conditionMet = fieldValue.indexOf(condition.value) !== -1;
                        break;
                    case 'in':
                        if (Array.isArray(condition.value)) {
                            conditionMet = condition.value.indexOf(fieldValue) !== -1;
                        }
                        break;
                }
                
                // Apply AND/OR logic
                if (i === 0 || condition.relation === 'AND') {
                    show = show && conditionMet;
                } else if (condition.relation === 'OR') {
                    show = show || conditionMet;
                }
            });
            
            // Show/hide the field
            if (show) {
                $field.slideDown(300);
            } else {
                $field.slideUp(300);
            }
        }
    }
}); 