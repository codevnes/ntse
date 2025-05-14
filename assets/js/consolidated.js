/**
 * Consolidated JavaScript file for NTSE theme
 * This file contains all the JavaScript code that was previously embedded in PHP files
 */

jQuery(document).ready(function($) {
    // ----------------------------------------
    // Header functions
    // ----------------------------------------
    
    // Toggle offcanvas menu
    $('#menu-toggle').on('click', function () {
        $(this).toggleClass('active');
        $('#offcanvas-menu').toggleClass('active');
        $('.offcanvas-overlay').toggleClass('active');
        $('body').toggleClass('offcanvas-active');

        // Create water particles in offcanvas menu
        if ($('#offcanvas-menu').hasClass('active')) {
            createWaterParticlesForMenu();
        }
    });

    // Add submenu toggle buttons to all menu items with children
    $('.offcanvas-menu-items .menu-item-has-children > a').after('<span class="submenu-toggle"></span>');

    // Close offcanvas menu
    $('.offcanvas-overlay, .offcanvas-close').on('click', function () {
        $('#menu-toggle').removeClass('active');
        $('#offcanvas-menu').removeClass('active');
        $('.offcanvas-overlay').removeClass('active');
        $('body').removeClass('offcanvas-active');
    });

    // Create water ripple effect on search input focus
    $('.search-field').on('focus', function () {
        $(this).closest('.search-input-wrapper').addClass('focused');
        animateSearchRipple();
    }).on('blur', function () {
        $(this).closest('.search-input-wrapper').removeClass('focused');
    });

    // Animate search ripple
    function animateSearchRipple() {
        const ripple = $('.search-ripple');
        ripple.removeClass('animate');
        setTimeout(function () {
            ripple.addClass('animate');
        }, 10);
    }

    // Create water particles for offcanvas menu
    function createWaterParticlesForMenu() {
        const container = $('.water-particles-container');
        container.empty();

        // Create multiple particles
        for (let i = 0; i < 15; i++) {
            createSingleParticle(container);
        }
    }

    function createSingleParticle(container) {
        // Random size between 5px and 15px
        const size = Math.floor(Math.random() * 10) + 5;

        // Random position
        const posX = Math.floor(Math.random() * 100);
        const posY = Math.floor(Math.random() * 100);

        // Random animation duration between 10s and 20s
        const duration = Math.floor(Math.random() * 10) + 10;

        // Create particle element
        const particle = $('<div class="water-particle"></div>');
        particle.css({
            width: size + 'px',
            height: size + 'px',
            left: posX + '%',
            top: posY + '%',
            animation: `float ${duration}s infinite ease-in-out ${Math.random() * 5}s`
        });

        // Add to container
        container.append(particle);
    }

    // Create header bubbles animation
    function animateHeaderBubbles() {
        $('.bubble').each(function () {
            const bubble = $(this);
            const startPosition = parseInt(bubble.css('bottom'));
            const duration = parseInt(bubble.css('animation-duration'));

            setInterval(function () {
                const newSize = Math.floor(Math.random() * 10) + 10;
                const newLeft = parseInt(bubble.css('left')) + (Math.random() * 20 - 10);

                bubble.css({
                    width: newSize + 'px',
                    height: newSize + 'px',
                    left: newLeft + '%'
                });

                bubble.removeClass('animate');
                setTimeout(function () {
                    bubble.addClass('animate');
                }, 10);
            }, duration * 1000);
        });
    }

    // Run bubble animation
    animateHeaderBubbles();

    // Handle submenu toggling in offcanvas menu - only on arrow click
    $('.offcanvas-menu-items .submenu-toggle').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const $parent = $(this).parent('.menu-item-has-children');
        const $submenu = $parent.find('> .sub-menu');
        
        // Toggle submenu
        $submenu.slideToggle(300);
        $parent.toggleClass('submenu-open');
        
        // Close other submenus at the same level
        $parent.siblings('.menu-item-has-children').removeClass('submenu-open')
            .find('> .sub-menu').slideUp(300);
    });

    // Close all submenus when closing offcanvas menu
    $('.offcanvas-overlay, .offcanvas-close').on('click', function() {
        $('.offcanvas-menu-items .sub-menu').slideUp(300);
        $('.menu-item-has-children').removeClass('submenu-open');
    });

    // ----------------------------------------
    // Project Archive functions
    // ----------------------------------------
    
    // Create water particles with limits
    var particleLimit = 0;
    var maxParticles = 20; // Limit maximum number of particles
    
    function createWaterParticle() {
        // Only create particle if under limit
        if (particleLimit < maxParticles) {
            var container = $('.particle-container');
            var containerWidth = container.width();
            var containerHeight = container.height();

            // Random size - reduced range
            var size = Math.floor(Math.random() * 4) + 2; // 2px to 6px

            // Random position
            var posX = Math.floor(Math.random() * containerWidth);
            var posY = Math.floor(Math.random() * (containerHeight / 3)) + (containerHeight * 2/3);

            // Create particle element
            var particle = $('<div class="water-particle"></div>');
            particle.css({
                width: size + 'px',
                height: size + 'px',
                left: posX + 'px',
                top: posY + 'px',
                opacity: Math.random() * 0.5 + 0.2
            });

            // Add to container
            container.append(particle);
            particleLimit++;

            // Add class to activate animation
            particle.addClass('particle-animate');

            // Remove particle after animation completes
            setTimeout(function() {
                particle.remove();
                particleLimit--;
            }, 8000);
        }
    }

    // Create particles less frequently
    var particleInterval = setInterval(createWaterParticle, 500);
    
    // Stop creating particles when page not visible
    $(window).on('blur', function() {
        clearInterval(particleInterval);
    });
    
    // Resume when page is visible
    $(window).on('focus', function() {
        particleInterval = setInterval(createWaterParticle, 500);
    });

    // Optimize hover effects
    $('.project-card').on('mouseenter', function() {
        $(this).find('.project-item-overlay').css('opacity', 1);
    }).on('mouseleave', function() {
        $(this).find('.project-item-overlay').css('opacity', 0);
    });

    // Optimize card animations
    function animateProjectCards() {
        $('.project-card').each(function(index) {
            var card = $(this);
            setTimeout(function() {
                card.addClass('animated-in');
            }, 100 * Math.min(index, 10)); // Cap animation delay
        });
    }

    // Only run animations if preferred
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        setTimeout(animateProjectCards, 500);
        
        // Simplified floating animation
        setTimeout(function() {
            $('.service-header-content').addClass('float-animation');
        }, 1000);
    }

    // Optimize ripple effect
    var rippleTimeout;
    $(document).on('click', '.btn-water-ripple', function(e) {
        var btn = $(this);
        var btnOffset = btn.offset();
        var xPos = e.pageX - btnOffset.left;
        var yPos = e.pageY - btnOffset.top;

        // Remove any existing ripples
        btn.find('.ripple-effect').remove();

        var ripple = $('<span class="ripple-effect"></span>');
        ripple.css({
            width: btn.width(),
            height: btn.width(),
            top: yPos - (btn.width()/2),
            left: xPos - (btn.width()/2)
        });

        btn.append(ripple);

        clearTimeout(rippleTimeout);
        rippleTimeout = setTimeout(function() {
            ripple.remove();
        }, 600);
    });

    // Lightweight 3D hover effect
    var isHovering = false;
    $('.project-card').on('mouseenter', function() {
        isHovering = true;
    }).on('mouseleave', function() {
        isHovering = false;
        $(this).css('transform', 'none');
    }).on('mousemove', function(e) {
        if (!isHovering) return;
        
        var card = $(this);
        var cardRect = card[0].getBoundingClientRect();
        var cardWidth = cardRect.width;
        var cardHeight = cardRect.height;
        
        var mouseX = e.clientX - cardRect.left;
        var mouseY = e.clientY - cardRect.top;
        
        var rotateY = ((mouseX / cardWidth) - 0.5) * 4;
        var rotateX = ((mouseY / cardHeight) - 0.5) * -4;
        
        card.css('transform', 'perspective(1000px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) scale3d(1.01, 1.01, 1.01)');
    });

    // Simple hover for category card
    $('.category-card').on('mouseenter', function() {
        $(this).find('.category-overlay').css('opacity', 0.3);
    }).on('mouseleave', function() {
        $(this).find('.category-overlay').css('opacity', 0);
    });

    // Toggle between grid and list views
    $('.view-button').on('click', function() {
        var viewMode = $(this).data('view');
        $('.view-button').removeClass('active');
        $(this).addClass('active');
        
        if (viewMode === 'grid') {
            $('#project-grid').show();
            $('#project-list').hide();
        } else {
            $('#project-grid').hide();
            $('#project-list').show();
        }
    });

    // Filter dropdown
    $('.filter-button').on('click', function() {
        $('.filter-dropdown-content').toggleClass('show');
    });

    // Close dropdown when clicking elsewhere
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.filter-dropdown').length) {
            $('.filter-dropdown-content').removeClass('show');
        }
    });

    // Smooth scroll with optimized animation
    $('.scroll-down-indicator').on('click', function() {
        $('html, body').animate({
            scrollTop: $('.project-categories-section').offset().top - 20
        }, 600); // Faster animation
    });

    // Initialize slider only if needed
    if ($('.featured-projects-slider').length) {
        // Add a small delay to load slider after critical content
        setTimeout(function() {
            $('.featured-projects-slider').slick({
                dots: true,
                arrows: true,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 5000,
                adaptiveHeight: true,
                lazyLoad: 'ondemand', // Add lazy loading
                prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>'
            });
        }, 1000);
    }

    // ----------------------------------------
    // Service Single Page functions
    // ----------------------------------------
    
    // Initialize Swiper for testimonials
    if ($('.testimonials-slider').length > 0) {
        var testimonialSwiper = new Swiper('.testimonials-slider', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                }
            }
        });
    }
    
    // FAQ Accordion
    $('.faq-question').on('click', function() {
        var $item = $(this).parent();
        
        if ($item.hasClass('active')) {
            $item.removeClass('active');
            $item.find('.faq-answer').slideUp();
        } else {
            $('.faq-item').removeClass('active');
            $('.faq-answer').slideUp();
            
            $item.addClass('active');
            $item.find('.faq-answer').slideDown();
        }
    });
    
    // Create water particles effect
    function createWaterParticles(containerId, count) {
        var container = document.getElementById(containerId);
        if (!container) return;
        
        for (var i = 0; i < count; i++) {
            var particle = document.createElement('div');
            particle.className = 'water-particle';
            particle.style.width = Math.random() * 10 + 5 + 'px';
            particle.style.height = particle.style.width;
            particle.style.left = Math.random() * 100 + '%';
            particle.style.bottom = '0';
            particle.style.opacity = Math.random() * 0.5 + 0.1;
            container.appendChild(particle);
            
            animateParticle(particle);
        }
    }
    
    function animateParticle(particle) {
        setTimeout(function() {
            particle.style.setProperty('--move-x', (Math.random() * 100 - 50) + 'px');
            particle.classList.add('particle-animate');
            
            setTimeout(function() {
                particle.style.opacity = '0';
                
                setTimeout(function() {
                    if (particle.parentElement) {
                        particle.classList.remove('particle-animate');
                        particle.style.bottom = '0';
                        particle.style.left = Math.random() * 100 + '%';
                        particle.style.opacity = Math.random() * 0.5 + 0.1;
                        animateParticle(particle);
                    }
                }, 100);
            }, 8000);
        }, Math.random() * 2000);
    }
    
    // Initialize water particles where containers exist
    if (document.getElementById('timelineWaterEffect')) {
        createWaterParticles('timelineWaterEffect', 20);
    }
}); 