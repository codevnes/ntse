/**
 * Partners Page JavaScript
 */
(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        initPartnerCards();
        initFilterTabs();
    });

    /**
     * Initialize partner cards with interactive features
     */
    function initPartnerCards() {
        // Add animation order to cards for staggered animation
        $('.partner-card').each(function(index) {
            $(this).css('--animation-order', index);
        });

        // Handle card flip on click
        $('.card-overlay').on('click', function(e) {
            e.preventDefault();
            $(this).closest('.partner-card').find('.card-inner').css('transform', 'rotateY(180deg)');
        });

        // Handle card flip back on close button click
        $('.back-close').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('.partner-card').find('.card-inner').css('transform', 'rotateY(0deg)');
        });

        // Add water ripple effect on hover
        $('.partner-card').on('mouseenter', function() {
            const $logo = $(this).find('.partner-logo');
            $logo.append('<div class="ripple"></div>');
            
            setTimeout(function() {
                $logo.find('.ripple').remove();
            }, 1000);
        });
    }

    /**
     * Initialize filter tabs with active indicator
     */
    function initFilterTabs() {
        // Set active tab indicator position
        function setActiveTabIndicator() {
            const $activeTab = $('.tab-item.active');
            if ($activeTab.length) {
                const $tabIndicator = $('.tab-indicator');
                const tabWidth = $activeTab.outerWidth();
                const tabLeft = $activeTab.position().left;
                const tabCenter = tabLeft + (tabWidth / 2);
                
                $tabIndicator.css({
                    '--tab-center': tabCenter + 'px'
                });
            }
        }

        // Initial position
        setActiveTabIndicator();
        
        // Update on window resize
        $(window).on('resize', function() {
            setActiveTabIndicator();
        });
        
        // Animate tab hover
        $('.tab-item').on('mouseenter', function() {
            $(this).addClass('tab-hover');
        }).on('mouseleave', function() {
            $(this).removeClass('tab-hover');
        });
    }

    /**
     * Add parallax effect to decorative elements
     */
    $(window).on('mousemove', function(e) {
        const moveX = (e.pageX * -1 / 50);
        const moveY = (e.pageY * -1 / 50);
        
        $('.decorative-icon').css({
            'transform': 'translate3d(' + moveX + 'px, ' + moveY + 'px, 0)'
        });
        
        const moveXSlow = (e.pageX * -1 / 100);
        const moveYSlow = (e.pageY * -1 / 100);
        
        $('.decorative-pattern').css({
            'transform': 'translate3d(' + moveXSlow + 'px, ' + moveYSlow + 'px, 0) rotate(var(--rotation, 0deg))'
        });
    });

})(jQuery);
