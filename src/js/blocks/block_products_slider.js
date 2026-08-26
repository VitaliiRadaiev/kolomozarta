{
    const sliders = document.querySelectorAll('[data-slider="products-slider"]');
    sliders.forEach((slider) => {

        // Слайди вміщуються цілком — гортати нічого, ховаємо кнопки навігації
        const toggleNav = (swiper) => {
            slider.classList.toggle('slider-nav-locked', swiper.isLocked);
        };

        const swiper = new Swiper(slider.querySelector('.swiper'), {
            observer: true,
            observeParents: true,
            pagination: {
                el: slider.querySelector('.slider-pagination-wrapper .swiper-pagination'),
                dynamicBullets: true,
            },
            navigation: {
                nextEl: slider.querySelector('.swiper-button.next'),
                prevEl: slider.querySelector('.swiper-button.prev'),
            },
            speed: 600,
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 12,
                },
                744: {
                    slidesPerView: 2,
                    spaceBetween: 12,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 16,
                }
            },
            on: {
                init: toggleNav,
                lock: toggleNav,
                unlock: toggleNav,
                breakpoint: toggleNav,
            }
        });

        toggleNav(swiper);

    });
}