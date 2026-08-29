{
    const ANIMATION_DURATION = 300;

    const isElementVisible = (el) => {
        const rect = el.getBoundingClientRect();

        return rect.top >= 0 && rect.bottom <= window.innerHeight;
    };

    const getPanel = (trigger) => {
        const id = trigger.getAttribute('aria-controls');

        return id ? document.getElementById(id) : trigger.nextElementSibling;
    };

    const closeItem = (item) => {
        const trigger = item.querySelector('[data-accordion-trigger]');
        if (!trigger) return;

        const panel = getPanel(trigger);

        item.classList.remove('active');
        trigger.classList.remove('active');
        trigger.setAttribute('aria-expanded', 'false');

        if (panel) {
            slideUp(panel, ANIMATION_DURATION);

            setTimeout(() => {
                panel.setAttribute('hidden', '');
            }, ANIMATION_DURATION);
        }
    };

    const initTrigger = (accordion, trigger) => {
        if (trigger.dataset.accordionInited === 'true') return;

        if (trigger.tagName !== 'BUTTON') {
            trigger.setAttribute('role', 'button');
            trigger.setAttribute('tabindex', '0');
        }

        trigger.setAttribute('aria-expanded', trigger.classList.contains('active') ? 'true' : 'false');

        trigger.addEventListener('keydown', (e) => {
            const triggers = Array.from(accordion.querySelectorAll('[data-accordion-trigger]'));
            const index = triggers.indexOf(trigger);

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                triggers[(index + 1) % triggers.length]?.focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                triggers[(index - 1 + triggers.length) % triggers.length]?.focus();
            } else if (e.key === 'Home') {
                e.preventDefault();
                triggers[0]?.focus();
            } else if (e.key === 'End') {
                e.preventDefault();
                triggers[triggers.length - 1]?.focus();
            } else if ((e.key === 'Enter' || e.key === ' ') && trigger.tagName !== 'BUTTON') {
                e.preventDefault();
                trigger.click();
            }
        });

        trigger.dataset.accordionInited = 'true';
    };

    const initAccordion = (accordion) => {
        if (accordion.dataset.accordionInited === 'true') return;
        accordion.dataset.accordionInited = 'true';

        const isOneActiveItem = accordion.dataset.accordion.trim() === 'one';
        const initTriggers = () => {
            accordion.querySelectorAll('[data-accordion-trigger]').forEach((trigger) => initTrigger(accordion, trigger));
        };

        initTriggers();

        new MutationObserver(initTriggers).observe(accordion, {
            childList: true,
            subtree: true,
        });

        accordion.addEventListener('click', (e) => {
            const trigger = e.target.closest('[data-accordion-trigger]');
            if (!trigger || !accordion.contains(trigger)) return;

            e.preventDefault();

            const item = trigger.closest('[data-accordion-item]');
            const panel = getPanel(trigger);

            item.classList.toggle('active');
            trigger.classList.toggle('active');
            trigger.classList.add('is-locked');

            const isOpen = trigger.classList.contains('active');

            trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

            if (panel) {
                // slideToggle ориентируется на computed display, поэтому атрибут hidden
                // снимаем только после запуска анимации раскрытия
                slideToggle(panel, ANIMATION_DURATION);

                if (isOpen) {
                    panel.removeAttribute('hidden');
                } else {
                    setTimeout(() => {
                        panel.setAttribute('hidden', '');
                    }, ANIMATION_DURATION);
                }
            }

            setTimeout(() => {
                trigger.classList.remove('is-locked');

                if (isOpen && !isElementVisible(item)) {
                    scrollToEl(item);
                }
            }, ANIMATION_DURATION);

            if (isOneActiveItem && isOpen) {
                accordion.querySelectorAll('[data-accordion-item].active').forEach((sibling) => {
                    if (sibling !== item) {
                        closeItem(sibling);
                    }
                });
            }
        });
    };

    const initFaqToggle = (button) => {
        const list = document.getElementById(button.getAttribute('aria-controls'));
        if (!list) return;

        const textShow = button.dataset.textShow || button.textContent.trim();
        const textHide = button.dataset.textHide || textShow;

        button.addEventListener('click', () => {
            const isExpanded = list.classList.toggle('is-expanded');

            button.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
            button.textContent = isExpanded ? textHide : textShow;

            if (!isExpanded && list.getBoundingClientRect().top < 0) {
                scrollToEl(list);
            }
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-accordion]').forEach(initAccordion);
        document.querySelectorAll('[data-faq-toggle]').forEach(initFaqToggle);
    });
}
