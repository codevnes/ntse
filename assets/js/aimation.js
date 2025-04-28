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