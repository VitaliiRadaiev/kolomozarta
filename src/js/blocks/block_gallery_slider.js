{
    const sliders = document.querySelectorAll('[data-slider="gallery"]');
    sliders.forEach((slider) => {

        const mob = parseInt(slider.dataset.slidesMob, 10) || 1;
        const tablet = parseInt(slider.dataset.slidesTablet, 10) || 2;
        const desktop = parseInt(slider.dataset.slidesDesktop, 10) || 3;

        // Слайди вміщуються цілком — гортати нічого, ховаємо кнопки навігації
        const toggleNav = (swiper) => {
            slider.classList.toggle('slider-nav-locked', swiper.isLocked);
        };

        const swiper = new Swiper(slider.querySelector('.swiper'), {
            observer: true,
            observeParents: true,
            pagination: {
                el: slider.querySelector('.swiper-pagination'),
                dynamicBullets: true,
            },
            navigation: {
                nextEl: slider.querySelector('.swiper-button.next'),
                prevEl: slider.querySelector('.swiper-button.prev'),
            },
            speed: 600,
            breakpoints: {
                0: {
                    slidesPerView: mob,
                    spaceBetween: 12,
                },
                768: {
                    slidesPerView: tablet,
                    spaceBetween: 16,
                },
                1024: {
                    slidesPerView: desktop,
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
