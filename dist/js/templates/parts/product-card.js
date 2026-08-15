{
    document.querySelectorAll('.product-card').forEach((card) => {
        const swiperEl = card.querySelector('.swiper');
        const prevEl = card.querySelector('.product-card__slider-prev');
        const nextEl = card.querySelector('.product-card__slider-next');

        if (!swiperEl) return;

        new Swiper(swiperEl, {
            spaceBetween: 12,
            navigation: {
                prevEl,
                nextEl,
            },
            pagination: {
                el: swiperEl.querySelector('.swiper-pagination'),
                clickable: true,
                dynamicBullets: true,
            },
        });

        [prevEl, nextEl].forEach((btn) => {
            if (btn) {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                });
            }
        });
    });
}
