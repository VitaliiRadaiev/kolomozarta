document.addEventListener('DOMContentLoaded', () => {
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
