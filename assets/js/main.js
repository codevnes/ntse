jQuery(document).ready(function ($){
    $('header .open-menu').on('click', function (){
        // $('body').addClass('overlayWhite removeScroll');
        console.log('open menu');
        $('.nts-offcanvas-menu').addClass('is-open');
    })
    $('.offcanvas__header__close').on('click', function (){
        $('body').removeClass('overlayWhite removeScroll');
        $('.nts-offcanvas-menu').removeClass('is-open');
    })
})


// Hàm xử lý hiệu ứng khi cuộn
function initializeNtsAnimations() {
    // Lấy tất cả phần tử có lớp bắt đầu bằng 'nts_animate_'
    const elements = document.querySelectorAll('[class*="nts_animate_"]');

    // Tạo Intersection Observer
    const observer = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    // Lấy tất cả lớp của phần tử
                    const classList = Array.from(element.classList);
                    // Tìm lớp bắt đầu bằng 'nts_animate_'
                    const ntsClass = classList.find((cls) =>
                        cls.startsWith("nts_animate_")
                    );

                    if (ntsClass) {
                        // Loại bỏ tiền tố 'nts_' để lấy tên hiệu ứng gốc của Animate.css
                        const animationClass = ntsClass.replace("nts_", "");
                        // Thêm lớp cơ bản và lớp hiệu ứng
                        element.classList.add("animate__animated", animationClass);
                        // Ngừng theo dõi sau khi chạy hiệu ứng (tuỳ chọn)
                        observer.unobserve(element);
                    }
                }
            });
        },
        {
            threshold: 0.5, // Kích hoạt khi 50% phần tử hiển thị
        }
    );

    // Theo dõi tất cả phần tử
    elements.forEach((element) => {
        observer.observe(element);
    });
}

// Gọi hàm khi trang đã tải xong
document.addEventListener("DOMContentLoaded", initializeNtsAnimations);


jQuery(document).ready(function($) {
    $("#nts-contact-form").on("submit", function(e) {
        e.preventDefault();
        var $form = $(this);
        var $message = $form.siblings(".form-message");

        // Reset message
        $message.removeClass("success error").html("").hide();
        $form.find("button[type=submit]").prop("disabled", true).text(nts_ajax_object.text_sending);

        // AJAX request
        $.ajax({
            type: "POST",
            url: nts_ajax_object.ajax_url, 
            data: $form.serialize(),
            success: function(response) {
                if (response.success) {
                    $form.trigger("reset");
                    $message.addClass("success").html(response.data).show();
                } else {
                    $message.addClass("error").html(response.data).show();
                }
                $form.find("button[type=submit]").prop("disabled", false).text(nts_ajax_object.text_submit);
            },
            error: function() {
                $message.addClass("error").html(nts_ajax_object.text_error).show();
                $form.find("button[type=submit]").prop("disabled", false).text(nts_ajax_object.text_submit);
            }
        });
    });
});

// Single Product Modern Template JavaScript
jQuery(document).ready(function($) {
    // FAQ toggle
    $('.faq-question').on('click', function() {
        $(this).toggleClass('active');
        $(this).next('.faq-answer').toggleClass('active');
    });
    
    // Hiệu ứng hover cho overview box
    $('.overview-box').hover(
        function() {
            $(this).find('.overview-box-icon').addClass('icon-pulse');
        },
        function() {
            $(this).find('.overview-box-icon').removeClass('icon-pulse');
        }
    );
    
    // Hiệu ứng khi cuộn đến phần overview
    if ($('.product-overview').length > 0) {
        $(window).on('scroll', function() {
            const overviewSection = $('.product-overview');
            const overviewPosition = overviewSection.offset().top;
            const scrollPosition = $(window).scrollTop() + $(window).height() * 0.7;
            
            if (scrollPosition > overviewPosition) {
                $('.overview-main').addClass('fade-in-right');
                
                // Hiệu ứng delay cho các box bên sidebar
                $('.overview-sidebar .overview-box').each(function(index) {
                    const delay = 300 * (index + 1);
                    setTimeout(() => {
                        $(this).addClass('fade-in-up');
                    }, delay);
                });
            }
        });
        
        // Kích hoạt kiểm tra scroll khi trang tải xong
        $(window).trigger('scroll');
    }
    
    // Hiệu ứng cho tiêu đề section khi cuộn đến
    function initSectionTitleAnimations() {
        $(window).on('scroll', function() {
            $('.section-title-anim').each(function() {
                const elementTop = $(this).offset().top;
                const viewportBottom = $(window).scrollTop() + $(window).height() * 0.85;
                
                if (viewportBottom > elementTop) {
                    $(this).addClass('animate');
                }
            });
        });
        
        // Kích hoạt kiểm tra scroll ban đầu
        $(window).trigger('scroll');
    }

    // Thêm hiệu ứng hover và interactive cho các section-icon
    function initSectionIconEffects() {
        $('.section-icon').hover(
            function() {
                $(this).css('transform', 'scale(1.1) rotate(5deg)');
            },
            function() {
                // Nếu icon nằm trong tiêu đề with-icon, giữ transform translateX
                if ($(this).closest('.with-icon').length) {
                    $(this).css('transform', 'translateX(-50%)');
                } else {
                    $(this).css('transform', 'scale(1) rotate(0deg)');
                }
            }
        );
    }
    
    // Hiệu ứng giọt nước tự động
    function createWaterDroplet() {
        const container = $('.water-droplets-container');
        if (container.length === 0) return;
        
        const containerWidth = container.width();
        const containerHeight = container.height();
        
        // Tạo giọt nước mới
        const droplet = $('<div class="water-droplet droplet-animate"></div>');
        
        // Ngẫu nhiên vị trí
        const left = Math.floor(Math.random() * (containerWidth - 50));
        const top = Math.floor(Math.random() * (containerHeight - 50));
        
        // Ngẫu nhiên kích thước
        const size = Math.floor(Math.random() * 30) + 20;
        
        droplet.css({
            left: left + 'px',
            top: top + 'px',
            width: size + 'px',
            height: size + 'px'
        });
        
        container.append(droplet);
        
        // Xóa sau khi animation hoàn thành
        setTimeout(function() {
            droplet.remove();
        }, 3000);
    }
    
    // Khởi tạo các hiệu ứng cho trang single-product khi DOM đã sẵn sàng
    initSectionTitleAnimations();
    initSectionIconEffects();
    
    // Chỉ thực hiện nếu đang ở template Single Product Modern
    if ($('.product-modern').length > 0) {
        // Tạo giọt nước theo thời gian
        setInterval(createWaterDroplet, 2000);
        
        // Tạo một số giọt nước ban đầu
        for (let i = 0; i < 3; i++) {
            setTimeout(function() {
                createWaterDroplet();
            }, i * 500);
        }
    }
});


// Khởi tạo AOS
AOS.init({
    offset: 100,
    duration: 500,
    easing: 'ease-in-sine',
    delay: 100,
});