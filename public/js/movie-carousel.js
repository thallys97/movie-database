document.addEventListener('DOMContentLoaded', function() {
    var galleryTop = new Swiper('.gallery-top', {
        spaceBetween: 10,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        preloadImages: false, // Ativa o lazy loading
        lazy: true, // Configurações do lazy loading
        keyboard: {
            enabled: true,
            onlyInViewport: true,
        },
        mousewheel: true,
        breakpoints: {
            // Quando a largura da tela é >= 640px
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            // Quando a largura da tela é >= 768px
            768: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
        on: {
            init: function () {
                this.slides.forEach(slide => {
                    slide.style.display = 'block'; // Garante que todos os slides são visíveis inicialmente
                });
            },
            slideChange: function () {
                this.slides[this.activeIndex].style.display = 'block';
            },
        },
    });
});