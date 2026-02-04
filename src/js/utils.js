function toggleDisablePageScroll(state) {
    const needOffsetElements = document.querySelectorAll('[data-popup="add-right-padding"]');

    if (state) {
        if (typeof lenis !== 'undefined' && lenis) {
            lenis.stop();
        }

        const offsetValue = getScrollbarWidth();
        document.documentElement?.classList.add('overflow-hidden');
        document.body?.classList.add('overflow-hidden');
        document.documentElement.style.paddingRight = offsetValue + 'px';
        needOffsetElements.forEach(el => el.style.paddingRight = offsetValue + 'px');
    } else {
        setTimeout(() => {
            if (typeof lenis !== 'undefined' && lenis) {
                lenis.start();
            }

            document.documentElement?.classList.remove('overflow-hidden');
            document.body?.classList.remove('overflow-hidden');
            document.documentElement.style.removeProperty('padding-right');
            needOffsetElements.forEach(el => el.style.removeProperty('padding-right'));
        }, 400);
    }
}