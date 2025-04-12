$(document).ready(function () {


    // Reviews slider
    const reviews = document.querySelectorAll('.reviews');
    reviews.forEach(review => {
        const sliderItems = Array.from(review.querySelectorAll('.reviews__slider-item'));
        const maxHeight = Math.max(...sliderItems.map(item => item.clientHeight));
        const setMinHeight = () => {
            sliderItems.forEach(item => item.style.setProperty('min-height', `${maxHeight}px`));
        }

        setMinHeight();
        window.addEventListener('resize', () => {
            setMinHeight();
        });
    })
    $('.reviews__slider').slick({
        dots: true,
        arrows: false,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        autoplay: true,
        //adaptiveHeight: true
    });

    $('.openMenu').click(function () {
        $('#header').toggleClass('open-popup');
        $('body').toggleClass('open-menu')
    });

    const mebileDorpdownMenuItems = document.querySelectorAll('.menu__popup .has-submenu > a, .menu__popup .has-submenu-child > a');
    mebileDorpdownMenuItems.forEach(navItem => {
        navItem.addEventListener('click', (e) => {
            e.preventDefault();
            const parent = navItem.parentElement;
            if(parent.classList.contains('active')) {
                parent.classList.remove('active');
                slideUp(navItem.nextElementSibling);
            } else {
                parent.classList.add('active');
                slideDown(navItem.nextElementSibling);
            }

            const neighboursItems = Array.from(parent.parentElement.children);
            neighboursItems.forEach(neighboursItem => {
                if(neighboursItem === parent) return;
                const submenu = neighboursItem.querySelector('.sub-menu');
                neighboursItem.classList.remove('active');
                submenu && slideUp(submenu);
            })
        });
    });
    // Animations

    AOS.init({
        duration: 1000,
        offset: window.innerWidth < 768 ? 80 : 120,
        once: true
    });

    //Form
    const openOrderPopupBtn = $('.openOrderPopup');
    const closeOrderPopup = $('.closeOrderPopup');
    const orderPopup = $('.order__form-wrapper');

    openOrderPopupBtn.on('click', function () {
        const price = $(this).data('price');
        const title = $(this).data('title');

        $('.order__form-title').text(title);
        $('.order__form-price').text(`Ціна: ${price} `);
        $('.order__form-wrap input[name="product-name"]').val(title);
        $('.order__form-wrap input[name="product-price"]').val(price);

        document.documentElement.style.setProperty('padding-right', `${getScrollbarWidth()}px`);
        document.documentElement.style.setProperty('overflow', 'hidden');

        orderPopup.addClass('active');
    });

    closeOrderPopup.on('click', function () {
        orderPopup.removeClass('active');
        setTimeout(() => {
            document.documentElement.style.removeProperty('overflow');
            document.documentElement.style.removeProperty('padding-right');
        }, 300);
    });

    orderPopup.on('click', function (e) {
        if (!$(e.target).closest('.order__form').length) {
            orderPopup.removeClass('active');
            setTimeout(() => {
                document.documentElement.style.removeProperty('overflow');
                document.documentElement.style.removeProperty('padding-right');
            }, 300);
        }
    });

    const materialListBlockItems = document.querySelectorAll('.material__list-item');
    const materialDescriptionItems = document.querySelectorAll('.material-description__item');
    materialListBlockItems.forEach((materialListItem, index) => {
        materialListItem.addEventListener('click', () => {
            const scrollToElement = materialDescriptionItems[index];
            if(scrollToElement) {
                scrollToEl(scrollToElement);
            }
        });
    });
});

function getScrollbarWidth() {
    const lockPaddingValue = window.innerWidth - document.body.offsetWidth;

    return lockPaddingValue;
}

function slideUp(target, duration = 500) {
    target.style.transitionProperty = 'height, margin, padding';
    target.style.transitionDuration = duration + 'ms';
    target.style.height = target.offsetHeight + 'px';
    target.offsetHeight;
    target.style.overflow = 'hidden';
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    window.setTimeout(() => {
        target.style.display = 'none';
        target.style.removeProperty('height');
        target.style.removeProperty('padding-top');
        target.style.removeProperty('padding-bottom');
        target.style.removeProperty('margin-top');
        target.style.removeProperty('margin-bottom');
        target.style.removeProperty('overflow');
        target.style.removeProperty('transition-duration');
        target.style.removeProperty('transition-property');
        target?.classList.remove('_slide');
    }, duration);
}
function slideDown(target, duration = 500) {
    target.style.removeProperty('display');
    let display = window.getComputedStyle(target).display;
    if (display === 'none')
        display = 'block';

    target.style.display = display;
    let height = target.offsetHeight;
    target.style.overflow = 'hidden';
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    target.offsetHeight;
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + 'ms';
    target.style.height = height + 'px';
    target.style.removeProperty('padding-top');
    target.style.removeProperty('padding-bottom');
    target.style.removeProperty('margin-top');
    target.style.removeProperty('margin-bottom');
    window.setTimeout(() => {
        target.style.removeProperty('height');
        target.style.removeProperty('overflow');
        target.style.removeProperty('transition-duration');
        target.style.removeProperty('transition-property');
        target?.classList.remove('_slide');
    }, duration);
}
function slideToggle(target, duration = 500) {
    if (!target?.classList.contains('_slide')) {
        target?.classList.add('_slide');
        if (window.getComputedStyle(target).display === 'none') {
            return this.slideDown(target, duration);
        } else {
            return this.slideUp(target, duration);
        }
    }
}

function scrollToEl(target) {
    let el = typeof target === 'string' ? document.querySelector(target) : target;
    if (!el) return;

    let header = document.querySelector('[data-header]');
    let elTop = Math.abs(document.body.getBoundingClientRect().top) + el.getBoundingClientRect().top;
    let headerHeight = header ? header.clientHeight : 0;
    let viewportHeight = window.innerHeight;
    let top = elTop - headerHeight;

    setTimeout(() => {
        window.scrollTo({
            top: top,
            behavior: 'smooth',
        });
    }, 0);
}