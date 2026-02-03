$(document).ready(function () {
  // Reviews slider
  const reviews = document.querySelectorAll(".reviews");
  reviews.forEach((review) => {
    const sliderItems = Array.from(
      review.querySelectorAll(".reviews__slider-item")
    );
    const maxHeight = Math.max(...sliderItems.map((item) => item.clientHeight));
    const setMinHeight = () => {
      sliderItems.forEach((item) =>
        item.style.setProperty("min-height", `${maxHeight}px`)
      );
    };

    setMinHeight();
    window.addEventListener("resize", () => {
      setMinHeight();
    });
  });
  $(".reviews__slider").slick({
    dots: true,
    arrows: false,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: "linear",
    autoplay: true,
    //adaptiveHeight: true
  });

  $(".openMenu").click(function () {
    $("#header").toggleClass("open-popup");
    $("body").toggleClass("open-menu");
  });

  const mebileDorpdownMenuItems = document.querySelectorAll(
    ".menu__popup .has-submenu > a, .menu__popup .has-submenu-child > a"
  );
  mebileDorpdownMenuItems.forEach((navItem) => {
    navItem.addEventListener("click", (e) => {
      e.preventDefault();
      const parent = navItem.parentElement;
      if (parent.classList.contains("active")) {
        parent.classList.remove("active");
        slideUp(navItem.nextElementSibling);
      } else {
        parent.classList.add("active");
        slideDown(navItem.nextElementSibling);
      }

      const neighboursItems = Array.from(parent.parentElement.children);
      neighboursItems.forEach((neighboursItem) => {
        if (neighboursItem === parent) return;
        const submenu = neighboursItem.querySelector(".sub-menu");
        neighboursItem.classList.remove("active");
        submenu && slideUp(submenu);
      });
    });
  });
  // Animations

  AOS.init({
    duration: 1000,
    offset: window.innerWidth < 768 ? 80 : 120,
    once: true,
  });

  //Form
  const openOrderPopupBtn = $(".openOrderPopup");
  const closeOrderPopup = $(".closeOrderPopup");
  const orderPopup = $(".order__form-wrapper");

  openOrderPopupBtn.on("click", function () {
    const price = $(this).data("price");
    const title = $(this).data("title");
    const subtitle = $(this).data("subtitle");

    $(".order__form-title").text(title);
    $(".order__form-price").text(`${subtitle || ""} ${price} `);
    $('.order__form-wrap input[name="product-name"]').val(title);
    $('.order__form-wrap input[name="product-subname"]').val(subtitle);
    $('.order__form-wrap input[name="product-price"]').val(price);

    document.documentElement.style.setProperty(
      "padding-right",
      `${getScrollbarWidth()}px`
    );
    document.documentElement.style.setProperty("overflow", "hidden");

    orderPopup.addClass("active");
  });

  closeOrderPopup.on("click", function () {
    orderPopup.removeClass("active");
    setTimeout(() => {
      document.documentElement.style.removeProperty("overflow");
      document.documentElement.style.removeProperty("padding-right");
      const form = document.querySelector(
        ".order__form-wrapper form.wpcf7-form"
      );
      form && form.reset();
    }, 300);
  });

  orderPopup.on("click", function (e) {
    if (!$(e.target).closest(".order__form").length) {
      orderPopup.removeClass("active");
      setTimeout(() => {
        document.documentElement.style.removeProperty("overflow");
        document.documentElement.style.removeProperty("padding-right");
        const form = document.querySelector(
          ".order__form-wrapper form.wpcf7-form"
        );
        form && form.reset();
      }, 300);
    }
  });

  //auth-popup
  const popup = document.querySelector(".auth-popup");
  document.addEventListener("click", (e) => {
    if (e.target.closest('[data-action="open-auth-popup"]')) {
      e.preventDefault();
      document.documentElement.style.setProperty(
        "padding-right",
        `${getScrollbarWidth()}px`
      );
      document.documentElement.style.setProperty("overflow", "hidden");
      popup.classList.add("active");
    }

    if (e.target.closest('[data-action="close-auth-popup"]')) {
      e.preventDefault();
      popup.classList.remove("active");
      setTimeout(() => {
        document.documentElement.style.removeProperty("overflow");
        document.documentElement.style.removeProperty("padding-right");
      }, 300);
    }
  });

  popup.addEventListener("click", (e) => {
    if (!e.target.closest(".auth-popup__content")) {
      popup.classList.remove("active");
      setTimeout(() => {
        document.documentElement.style.removeProperty("overflow");
        document.documentElement.style.removeProperty("padding-right");
      }, 300);
    }
  });

  const materialListBlockItems = document.querySelectorAll(
    ".material__list-item"
  );
  const materialDescriptionItems = document.querySelectorAll(
    ".material-description__item"
  );
  materialListBlockItems.forEach((materialListItem, index) => {
    materialListItem.addEventListener("click", () => {
      const scrollToElement = materialDescriptionItems[index];
      if (scrollToElement) {
        scrollToEl(scrollToElement);
      }
    });
  });

  const interestingSections = document.querySelectorAll(
    '[data-section="interesting"]'
  );
  interestingSections.forEach((section) => {
    const pageId = section.getAttribute("data-page-id");
    const list = section.querySelector("[data-list]");
    const btnMore = section.querySelector('[data-action="load-more"]');
    let page = 1;

    if (btnMore) {
      btnMore.addEventListener("click", async () => {
        btnMore.classList.add("btn-loading", "disabled");
        const path = buildApiPath("interesting-list", {
          "page-id": pageId,
          page: ++page,
        });
        const res = await Fetch(path);
        if (res) {
          if (res?.posts) {
            list.insertAdjacentHTML("beforeend", res?.posts);
          }

          if (res.has_more === false) {
            btnMore.parentElement.remove();
          }
        }

        btnMore && btnMore.classList.remove("btn-loading", "disabled");
      });
    }
  });

  const videosPage = document.querySelector("[data-videos]");
  if (videosPage) {
    const navButtons = videosPage.querySelectorAll("[data-lesson-nav-btn]");
    const lessonsContent = videosPage.querySelector(".lessons__content");
    const lessons = videosPage.querySelectorAll("[data-lesson-item]");
    const scrollContainer = videosPage.querySelector(
      "[data-nav-buttons-scroll-container]"
    );

    if (navButtons.length && lessons.length) {
      let isNavClickAction = false;
      const clearActive = () => {
        navButtons.forEach((btn) => btn.classList.remove("active"));
      };

      function setPositionActiveFilterButton(scrollContainer, activeButton) {
        if (!scrollContainer || !activeButton) return;

        const containerRect = scrollContainer.getBoundingClientRect();
        const buttonRect = activeButton.getBoundingClientRect();

        // проверяем, выходит ли кнопка за границы контейнера
        if (
          buttonRect.left < containerRect.left ||
          buttonRect.right > containerRect.right
        ) {
          // плавно скроллим так, чтобы кнопка попала в зону видимости
          scrollContainer.scrollTo({
            left:
              activeButton.offsetLeft -
              scrollContainer.clientWidth / 2 +
              activeButton.clientWidth / 2,
            behavior: "smooth",
          });
        }
      }

      const throttledSetPositionActiveFilterButton = throttle(
        setPositionActiveFilterButton,
        300
      );

      const updateActiveOnScroll = () => {
        if (isNavClickAction) return;

        if (lessonsContent) {
          const rectContent = lessonsContent.getBoundingClientRect();

          if (rectContent.top > 61) {
            clearActive();
            return;
          }
        }

        lessons.forEach((lesson, index) => {
          const rect = lesson.getBoundingClientRect();

          if (rect.top <= 65 && rect.bottom > 0) {
            const key = lesson.dataset.lessonItem;
            clearActive();
            const activeBtn = videosPage.querySelector(
              `[data-lesson-nav-btn="${key}"]`
            );
            if (activeBtn) {
              activeBtn.classList.add("active");

              // если экран меньше 1024px – проверяем видимость и скроллим
              if (window.innerWidth < 1024 && !isNavClickAction) {
                throttledSetPositionActiveFilterButton(scrollContainer, activeBtn);
              }
            }
          }
        });
      };

      window.addEventListener("scroll", updateActiveOnScroll);

      updateActiveOnScroll();

      let timeId;
      navButtons.forEach((btn) => {
        const key = btn.getAttribute("data-lesson-nav-btn");
        const lesson = videosPage.querySelector(`[data-lesson-item="${key}"]`);

        if (lesson) {
          btn.addEventListener("click", () => {
            scrollToEl(lesson, () => {
              scrollToEl(lesson);
            });
            isNavClickAction = true;
            navButtons.forEach((otherBtn) => otherBtn.classList.toggle("active", otherBtn === btn));
            clearTimeout(timeId);
            timeId = setTimeout(() => {
              isNavClickAction = false;
            }, 1000);
          });
        }
      });
    }

    wp.hooks.addAction("presto.playerPlay", "my-plugin-namespace", (player) => {
      const allPlayers = window?.PrestoPlayer?.instances || [];

      allPlayers.forEach((player) => {
        if (player !== currentPlayer && typeof player.pause === "function") {
          player.pause();
        }
      });
    });

    wp.hooks.addAction("presto.playerReady", "my-plugin-namespace", (player) => {
      player.elements.buttons.play[0] && (player.elements.buttons.play[0].style.setProperty('border-radius', '12px'));
    });

  }
});

function getScrollbarWidth() {
  const lockPaddingValue = window.innerWidth - document.body.offsetWidth;

  return lockPaddingValue;
}

function slideUp(target, duration = 500) {
  target.style.transitionProperty = "height, margin, padding";
  target.style.transitionDuration = duration + "ms";
  target.style.height = target.offsetHeight + "px";
  target.offsetHeight;
  target.style.overflow = "hidden";
  target.style.height = 0;
  target.style.paddingTop = 0;
  target.style.paddingBottom = 0;
  target.style.marginTop = 0;
  target.style.marginBottom = 0;
  window.setTimeout(() => {
    target.style.display = "none";
    target.style.removeProperty("height");
    target.style.removeProperty("padding-top");
    target.style.removeProperty("padding-bottom");
    target.style.removeProperty("margin-top");
    target.style.removeProperty("margin-bottom");
    target.style.removeProperty("overflow");
    target.style.removeProperty("transition-duration");
    target.style.removeProperty("transition-property");
    target?.classList.remove("_slide");
  }, duration);
}
function slideDown(target, duration = 500) {
  target.style.removeProperty("display");
  let display = window.getComputedStyle(target).display;
  if (display === "none") display = "block";

  target.style.display = display;
  let height = target.offsetHeight;
  target.style.overflow = "hidden";
  target.style.height = 0;
  target.style.paddingTop = 0;
  target.style.paddingBottom = 0;
  target.style.marginTop = 0;
  target.style.marginBottom = 0;
  target.offsetHeight;
  target.style.transitionProperty = "height, margin, padding";
  target.style.transitionDuration = duration + "ms";
  target.style.height = height + "px";
  target.style.removeProperty("padding-top");
  target.style.removeProperty("padding-bottom");
  target.style.removeProperty("margin-top");
  target.style.removeProperty("margin-bottom");
  window.setTimeout(() => {
    target.style.removeProperty("height");
    target.style.removeProperty("overflow");
    target.style.removeProperty("transition-duration");
    target.style.removeProperty("transition-property");
    target?.classList.remove("_slide");
  }, duration);
}
function slideToggle(target, duration = 500) {
  if (!target?.classList.contains("_slide")) {
    target?.classList.add("_slide");
    if (window.getComputedStyle(target).display === "none") {
      return this.slideDown(target, duration);
    } else {
      return this.slideUp(target, duration);
    }
  }
}


function scrollToEl(target, callback) {
  let el = typeof target === "string" ? document.querySelector(target) : target;
  if (!el) return;

  let elTop =
    Math.abs(document.body.getBoundingClientRect().top) +
    el.getBoundingClientRect().top;

  let top = elTop - 60;

  setTimeout(() => {
    window.scrollTo({
      top: top,
      behavior: "smooth",
    });

    let finished = false;
    const timeoutId = setTimeout(() => {
      if (!finished) {
        finished = true;
        callback && callback();
      }
    }, 1000);

    const checkScroll = () => {
      const atTarget = Math.abs(window.scrollY - top) < 2;
      const atBottom = window.innerHeight + window.scrollY >= document.body.scrollHeight - 2;

      if ((atTarget || atBottom) && !finished) {
        finished = true;
        clearTimeout(timeoutId);
        callback && callback();
      } else if (!finished) {
        requestAnimationFrame(checkScroll);
      }
    };
    requestAnimationFrame(checkScroll);
  }, 0);
}


async function Fetch(url) {
  const controller = new AbortController();
  const tId = setTimeout(() => controller.abort(), 5000);

  try {
    const res = await fetch(
      `${document.location.origin}/wp-json/site-core/v1${url}`,
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8",
        },
        signal: controller.signal,
      }
    );

    clearTimeout(tId);

    if (!res.ok) {
      throw new Error("Network error: " + res.status);
    }

    return res.json();
  } catch (err) {
    if (err.name == "AbortError") {
      return { success: false };
    } else {
      throw err;
    }
  }
}

function buildApiPath(basePath, query = {}) {
  const url = new URL(basePath, window.location.origin);
  const params = new URLSearchParams();

  Object.entries(query).forEach(([key, value]) => {
    if (value !== undefined && value !== null && value !== "") {
      params.set(key, value);
    }
  });

  url.search = params.toString();
  return url.pathname + url.search;
}

function debounce(func, wait) {
  let timeout;

  function debounced(...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(this, args), wait);
  }

  debounced.cancel = function () {
    clearTimeout(timeout);
  };

  return debounced;
}

function throttle(func, limit) {
  let inThrottle;
  return function (...args) {
    if (!inThrottle) {
      func.apply(this, args);
      inThrottle = true;
      setTimeout(() => inThrottle = false, limit);
    }
  };
}
