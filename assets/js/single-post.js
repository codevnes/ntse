/**
 * JavaScript for Single Post Water Treatment Template
 * Handles water animations and effects
 */

(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        // Water ripple effect on featured image
        initWaterRipples();
        
        // Bubble animation in hero section
        initBubbleAnimation();
        
        // Droplet decoration animation
        initDropletAnimation();
        
        // Parallax effects on scroll
        initParallaxEffects();
    });

    /**
     * Initialize water ripple effects
     */
    function initWaterRipples() {
        // Apply ripple effect to water-effect elements
        $('.water-drop-effect').each(function() {
            let $this = $(this);
            let parentWidth = $this.parent().width();
            let parentHeight = $this.parent().height();
            
            // Create ripples on hover
            $this.parent().on('mouseenter', function(e) {
                createRippleEffect(e, $this, parentWidth, parentHeight);
            });
            
            // Create ripples on click
            $this.parent().on('click', function(e) {
                createRippleEffect(e, $this, parentWidth, parentHeight, true);
            });
        });
        
        // Create ripple effect on search form
        $('.search-input-wrapper').on('click', function(e) {
            let $ripple = $(this).find('.search-ripple');
            $ripple.css('opacity', '0.3');
            setTimeout(function() {
                $ripple.css('opacity', '0');
            }, 600);
        });
    }
    
    /**
     * Create a ripple effect at mouse position
     */
    function createRippleEffect(e, $element, width, height, isStrong) {
        let posX = e.pageX - $element.offset().left;
        let posY = e.pageY - $element.offset().top;
        
        // Calculate position as percentage of parent
        let x = posX / width * 100;
        let y = posY / height * 100;
        
        // Create ripple element
        let $ripple = $('<div class="water-ripple-effect"></div>');
        $ripple.css({
            top: y + '%',
            left: x + '%',
            opacity: isStrong ? 0.5 : 0.3
        });
        
        // Add to the element
        $element.append($ripple);
        
        // Animate and remove
        setTimeout(function() {
            $ripple.css({
                transform: 'scale(2)',
                opacity: 0
            });
            
            setTimeout(function() {
                $ripple.remove();
            }, 600);
        }, 10);
    }
    
    /**
     * Initialize bubble animation in hero section
     */
    function initBubbleAnimation() {
        // Get all bubbles
        const $bubbles = $('.floating-bubbles .bubble');
        
        // Set random initial positions and delays
        $bubbles.each(function() {
            const $bubble = $(this);
            const randomX = Math.random() * 20 - 10; // -10 to 10
            const randomDelay = Math.random() * 3;
            const randomDuration = 6 + Math.random() * 4; // 6-10s
            
            $bubble.css({
                'animation-delay': randomDelay + 's',
                'animation-duration': randomDuration + 's',
                'transform': 'translateX(' + randomX + 'px)'
            });
        });
        
        // Periodically reposition bubbles for continuous random movement
        setInterval(function() {
            $bubbles.each(function() {
                const $bubble = $(this);
                const currentX = parseFloat($bubble.css('transform').split(',')[4]) || 0;
                const newX = currentX + (Math.random() * 6 - 3); // Slightly move left or right
                
                $bubble.css({
                    'transform': 'translateX(' + newX + 'px)'
                });
            });
        }, 5000);
    }
    
    /**
     * Initialize droplet animation for decorative elements
     */
    function initDropletAnimation() {
        // Add subtle animation to droplet decorations
        $('.droplet-decoration svg').each(function() {
            const $droplet = $(this);
            
            // Create subtle pulsing effect
            function pulseDroplet() {
                $droplet.animate({
                    opacity: 0.03
                }, 2000, function() {
                    $droplet.animate({
                        opacity: 0.07
                    }, 2000, pulseDroplet);
                });
            }
            
            pulseDroplet();
        });
        
        // Water drop animation in contact widget
        $('.water-drop-animation svg').each(function() {
            const $drop = $(this);
            
            function pulseWaterDrop() {
                $drop.animate({
                    opacity: 0.9
                }, 1500, function() {
                    $drop.animate({
                        opacity: 0.6
                    }, 1500, pulseWaterDrop);
                });
            }
            
            pulseWaterDrop();
        });
    }
    
    /**
     * Initialize parallax effects on scroll
     */
    function initParallaxEffects() {
        // Get relevant elements
        const $waterRipples = $('.water-ripples');
        const $waveSvg = $('.wave-bottom, .wave-top');
        
        // Handle scroll event
        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            const windowHeight = $(this).height();
            
            // Parallax effect for ripples
            $waterRipples.css({
                'background-position': '0 ' + (scrollTop * 0.2) + 'px'
            });
            
            // Subtle parallax for wave SVGs
            $waveSvg.each(function() {
                const $wave = $(this);
                const wavePosition = $wave.offset().top;
                const distanceFromTop = wavePosition - scrollTop;
                
                if (distanceFromTop < windowHeight && distanceFromTop > -$wave.height()) {
                    const parallaxValue = (windowHeight - distanceFromTop) * 0.05;
                    $wave.css({
                        'transform': 'translateY(' + parallaxValue + 'px)'
                    });
                }
            });
        });
        
        // Trigger initial scroll event
        $(window).trigger('scroll');
    }
    
    /**
     * Handle water button effects
     */
    $(document).on('mouseenter', '.water-button', function() {
        const $button = $(this);
        const $effect = $button.find('.button-water-effect');
        
        $effect.css({
            'transform': 'translate(-50%, -50%) scale(2)',
            'opacity': 1
        });
    });
    
    $(document).on('mouseleave', '.water-button', function() {
        const $button = $(this);
        const $effect = $button.find('.button-water-effect');
        
        $effect.css({
            'transform': 'translate(-50%, -50%) scale(0)',
            'opacity': 0
        });
    });

})(jQuery); 