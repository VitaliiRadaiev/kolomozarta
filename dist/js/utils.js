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

function initFancybox() {
    if (window.Fancybox) {
        Fancybox.bind("[data-fancybox]", {
            on: {
                init: (fancybox) => {
                    const lockPaddingValue = window.innerWidth - document.querySelector('body').offsetWidth + 'px';
                    let targetPadding = document.querySelectorAll('[data-popup="add-right-padding"]');
                    if (targetPadding.length) {
                        for (let index = 0; index < targetPadding.length; index++) {
                            const el = targetPadding[index];
                            el.style.paddingRight = lockPaddingValue;
                        }
                    }
                    document.documentElement.style.paddingRight = lockPaddingValue;
                    document.documentElement.classList.add('overflow-hidden');
                    document.body.classList.add('overflow-hidden');

                    setTimeout(() => {
                        const closeBtn = fancybox.container.querySelector('[data-fancybox-close]');
                        closeBtn && closeBtn.focus();
                    }, 100);

                },
                destroy: (fancybox) => {
                    let targetPadding = document.querySelectorAll('[data-popup="add-right-padding"]');

                    if (targetPadding.length) {
                        for (let index = 0; index < targetPadding.length; index++) {
                            const el = targetPadding[index];
                            el.style.paddingRight = '0px';
                        }
                    }
                    document.documentElement.style.paddingRight = '0px';
                    document.documentElement.classList.remove('overflow-hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            },
            placeFocusBack: false,
        });

        document.addEventListener("click", (e) => {
            if (e.target.closest('.fancybox__content')) return;
            if (e.target.closest('.fancybox__slide')) {
                Fancybox.close();
            }
        });
    }
}

function initSmoothScrollByAnchors() {
    let anchors = document.querySelectorAll('a[href*="#"]:not([data-action="open-popup"])');
    if (anchors.length) {
        anchors.forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                const href = anchor.getAttribute('href')
                if (!href.startsWith('#')) {
                    const linkUrl = new URL(href, window.location.href);
                    const isSamePage = linkUrl.origin === window.location.origin
                        && linkUrl.pathname.replace(/\/$/, '') === window.location.pathname.replace(/\/$/, '');

                    if (!isSamePage) return;
                }

                let url = href.startsWith('#') ? href : new URL(href, window.location.href).hash;

                const id = url.length > 1 ? url : null;
                if (!id) return;
                let el = document.querySelector(url);

                if (el) {
                    e.preventDefault();
                    scrollToEl(el);
                }
            })
        })
    }
}
