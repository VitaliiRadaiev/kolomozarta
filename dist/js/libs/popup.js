{
    const popupLinks = document.querySelectorAll('[data-action="open-popup"]');

    let unlock = true;

    const timeout = 300;

    if (popupLinks.length > 0) {
        for (let index = 0; index < popupLinks.length; index++) {
            const popupLink = popupLinks[index];
            popupLink.addEventListener('click', function (e) {
                const popupName = popupLink.tagName === 'A' ? popupLink.getAttribute('href') : popupLink.getAttribute('data-popup');
                const curentPopup = document.querySelector(popupName);
                popupOpen(curentPopup);
                e.preventDefault();
            }); 
        }
    }


    const popupCloseIcon = document.querySelectorAll('[data-action="close-popup"]');
    if (popupCloseIcon.length > 0) {
        for (let index = 0; index < popupCloseIcon.length; index++) {
            const el = popupCloseIcon[index];
            el.addEventListener('click', function (e) {
                popupClose(el.closest('.popup'));
                e.preventDefault();
            });
        }
    }

    function popupOpen(curentPopup) {
        if (curentPopup && unlock) {
            const popupActive = document.querySelector('.popup.popup--open');
            if (popupActive) {
                popupClose(popupActive, false);
            } else {
                bodyLock();
            }
            curentPopup.classList.add('popup--open');

            curentPopup.addEventListener('click', function (e) {
                if (!e.target.closest('.popup__content')) {
                    popupClose(e.target.closest('.popup'));
                }
            });
        }
    }

    function popupClose(popupActive, doUnlock = true) {
        if (unlock) {
            popupActive.classList.remove('popup--open');

            if (doUnlock) {
                bodyUnlock();
            }
        }
    }

    function bodyLock() {
        toggleDisablePageScroll(true);

        unlock = false;
        setTimeout(function () {
            unlock = true;
        }, timeout);
    }

    function bodyUnlock() {
        toggleDisablePageScroll(false);

        unlock = false;
        setTimeout(function () {
            unlock = true;
        }, timeout);
    }

    window.popup = {
        open(id) {
            if (!id) return;

            let popup = document.querySelector(id);

            if (!popup) return;

            popupOpen(popup);
        },
        close(id) {
            if (!id) return;

            let popup = document.querySelector(id);

            if (!popup) return;

            popupClose(popup);
        }
    }
}