{
    document.querySelectorAll('[data-slider="multicontent"]').forEach((slider) => {
        const swiperEl = slider.querySelector('.swiper');

        if (!swiperEl) return;

        new Swiper(swiperEl, {
            spaceBetween: 12,
            navigation: {
                prevEl: slider.querySelector('.multicontent__slider-prev'),
                nextEl: slider.querySelector('.multicontent__slider-next'),
            },
            pagination: {
                el: slider.querySelector('.swiper-pagination'),
                clickable: true,
                dynamicBullets: true,
            },
        });
    });
}
