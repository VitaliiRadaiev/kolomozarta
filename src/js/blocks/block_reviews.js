{
    const sliders = document.querySelectorAll('[data-slider="reviews"]');
    sliders.forEach((slider) => {

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
            loop: true,
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 12,
                },
                1024: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
            }
        });

    });
}