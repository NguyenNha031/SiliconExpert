document.addEventListener("DOMContentLoaded", function () {
  if (typeof Swiper === "undefined") return;

  const sliderEl = document.querySelector(".hero-slider");
  if (!sliderEl) return;

  const autoplayEnabled = sliderEl.dataset.autoplay === "1";

  new Swiper(".hero-slider", {
    loop: true,

    autoplay: autoplayEnabled
      ? {
          delay: 3500,
          disableOnInteraction: false,
        }
      : false,

    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },

    speed: 700,
  });
});
