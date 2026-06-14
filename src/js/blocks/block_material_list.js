document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.material__list-item').forEach((card) => {
        const swiperEl = card.querySelector('.swiper');
        const prevEl   = card.querySelector('.material__slider-prev');
        const nextEl   = card.querySelector('.material__slider-next');

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

    const tabs  = document.querySelectorAll('.material__tabs-btn');
    const cards = document.querySelectorAll('.material__list-item');

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            tabs.forEach((t) => t.classList.remove('is-active'));
            tab.classList.add('is-active');

            const filter = tab.dataset.filter;
            cards.forEach((card) => {
                if (filter === 'all') {
                    card.hidden = false;
                } else {
                    const cats = JSON.parse(card.dataset.categories || '[]');
                    card.hidden = !cats.includes(filter);
                }
            });
        });
    });
});
