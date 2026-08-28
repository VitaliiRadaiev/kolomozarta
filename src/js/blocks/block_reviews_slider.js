{
    const blocks = document.querySelectorAll('[data-slider="reviews"]');

    blocks.forEach((block) => {

        const mob = parseInt(block.dataset.slidesMob, 10) || 1;
        const tablet = parseInt(block.dataset.slidesTablet, 10) || 2;
        const desktop = parseInt(block.dataset.slidesDesktop, 10) || 3;

        const panels = block.querySelectorAll('.reviews-slider__panel');
        const tabs = block.querySelectorAll('.reviews-slider__tabs-btn');
        const prevBtn = block.querySelector('.slider-head__nav .swiper-button.prev');
        const nextBtn = block.querySelector('.slider-head__nav .swiper-button.next');

        if (!panels.length) return;

        // Кожен таб — окремий Swiper. Навігація спільна, тому опція navigation не задається:
        // кнопки вручну керують слайдером активної панелі.
        const sliders = new Map();
        let activeSlug = panels[0].dataset.panel;

        const getActive = () => sliders.get(activeSlug);

        // Слайди вміщуються цілком — гортати нічого, ховаємо кнопки навігації
        const toggleNav = () => {
            const active = getActive();
            block.classList.toggle('slider-nav-locked', !active || active.swiper.isLocked);
        };

        // Обрізаний текст: кнопка «Читати більше» потрібна лише там, де текст справді не вміщується.
        // Рахувати можна тільки на видимій панелі — у прихованої висоти немає.
        const refreshMoreButtons = (panel) => {
            panel.querySelectorAll('.review-card').forEach((card) => {
                const text = card.querySelector('.review-card__text');
                const more = card.querySelector('.review-card__more');

                if (!text || !more) return;
                if (card.classList.contains('is-expanded')) return;

                more.hidden = text.scrollHeight <= text.clientHeight + 1;
            });
        };

        panels.forEach((panel) => {
            const swiper = new Swiper(panel.querySelector('.swiper'), {
                observer: true,
                observeParents: true,
                pagination: {
                    el: panel.querySelector('.swiper-pagination'),
                    dynamicBullets: true,
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
                    lock: toggleNav,
                    unlock: toggleNav,
                    breakpoint: toggleNav,
                }
            });

            sliders.set(panel.dataset.panel, { panel, swiper });
        });

        const showPanel = (slug) => {
            if (!sliders.has(slug) || slug === activeSlug) return;

            activeSlug = slug;

            sliders.forEach((item, key) => {
                item.panel.hidden = key !== slug;
            });

            const active = getActive();
            // Панелі ініціалізуються прихованими — після показу треба перерахувати розміри
            active.swiper.update();
            refreshMoreButtons(active.panel);
            toggleNav();
        };

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                tabs.forEach((t) => t.classList.remove('is-active'));
                tab.classList.add('is-active');
                showPanel(tab.dataset.filter);
            });
        });

        if (prevBtn) {
            prevBtn.addEventListener('click', () => getActive().swiper.slidePrev());
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => getActive().swiper.slideNext());
        }

        block.addEventListener('click', (event) => {
            const more = event.target.closest('.review-card__more');
            if (!more) return;

            const card = more.closest('.review-card');
            const expanded = card.classList.toggle('is-expanded');

            more.textContent = expanded ? more.dataset.textLess : more.dataset.textMore;
            getActive().swiper.update();
        });

        window.addEventListener('resize', debounce(() => {
            refreshMoreButtons(getActive().panel);
        }, 200));

        refreshMoreButtons(panels[0]);
        toggleNav();
    });
}
