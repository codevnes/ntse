document.addEventListener('DOMContentLoaded', function () {
    const sliders = document.querySelectorAll('.nts-swiper');

    sliders.forEach(slider => {
        // Parse config từ data-swiper
        const config = slider.dataset.swiper ? JSON.parse(slider.dataset.swiper) : {};

        // Tìm các phần tử bên trong slider hiện tại
        const nextEl = slider.querySelector('.swiper-next');
        const prevEl = slider.querySelector('.swiper-prev');
        const paginationEl = slider.querySelector('.swiper-pagination');

        // Gán các phần tử này vào config nếu có
        if (nextEl && prevEl) {
            config.navigation = {
                nextEl: nextEl,
                prevEl: prevEl
            };
        }

        if (paginationEl) {
            config.pagination = {
                el: paginationEl,
                clickable: true
            };
        }

        new Swiper(slider, config);
    });
});

