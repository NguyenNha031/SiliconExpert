//  BTN GET STARTED – TEXT + ICON SWAP
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".btn-get-started").forEach((btn) => {
    const textEl = btn.querySelector(".btn-get-started__text");
    if (textEl && !textEl.querySelector(".btn-swap-text")) {
      const wrap = document.createElement("span");
      wrap.className = "btn-swap-text";
      const original = document.createElement("span");
      original.textContent = textEl.textContent;
      const clone = document.createElement("span");
      clone.className = "clone";
      clone.textContent = textEl.textContent;
      wrap.appendChild(original);
      wrap.appendChild(clone);
      textEl.textContent = "";
      textEl.appendChild(wrap);
    }
    const iconEl = btn.querySelector(".btn-get-started__icon");
    const icon = iconEl?.querySelector("i");
    if (icon && !iconEl.querySelector(".btn-swap-icon")) {
      const iconWrap = document.createElement("span");
      iconWrap.className = "btn-swap-icon";
      const originalIcon = document.createElement("span");
      originalIcon.appendChild(icon.cloneNode(true));
      const cloneIcon = document.createElement("span");
      cloneIcon.className = "clone";
      cloneIcon.appendChild(icon.cloneNode(true));
      iconWrap.appendChild(originalIcon);
      iconWrap.appendChild(cloneIcon);
      iconEl.innerHTML = "";
      iconEl.appendChild(iconWrap);
    }
  });
});

//  HEADER COLLAPSED LOGO
document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector(".header");
  const logoIcon = document.querySelector(".logo-icon");
  const logoText = document.querySelector(".logo-text");

  if (!header || !logoIcon) return;

  logoIcon.addEventListener("click", () => {
    if (header.classList.contains("is-mega-open")) return;
    header.classList.toggle("is-collapsed");
  });

  logoText?.addEventListener("click", () => {
    if (header.classList.contains("is-mega-open")) return;

    if (!header.classList.contains("is-collapsed")) {
      header.classList.add("is-collapsed");
    }
  });
});

//  FEATURE CALLOUT SLIDER
document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelectorAll(".feature-callout .feature-slide");
  const section = document.querySelector(".feature-callout");
  const indicator = document.getElementById("fc-current");
  const progressBar = document.querySelector(".fc-progress__bar");

  if (!slides.length || !section) return;

  let current = 0;

  function showSlide(index) {
    if (window.innerWidth < 1024) return;

    slides.forEach((slide, i) => {
      const isActive = i === index;

      slide.classList.toggle("lg:opacity-100", isActive);
      slide.classList.toggle("lg:opacity-0", !isActive);
      slide.classList.toggle("lg:z-10", isActive);
      slide.classList.toggle("lg:z-0", !isActive);
      slide.classList.toggle("is-active", isActive);
    });

    indicator && (indicator.textContent = index + 1);
    progressBar &&
      (progressBar.style.transform = `translateX(${index * 100}%)`);
  }

  setTimeout(() => showSlide(0), 50);

  section.addEventListener("click", () => {
    if (window.innerWidth >= 1024) {
      current = (current + 1) % slides.length;
      showSlide(current);
    }
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth < 1024) {
      slides.forEach((s) => {
        s.classList.add("is-active");
        s.style.opacity = "1";
        s.style.position = "relative";
      });
    } else {
      showSlide(current);
    }
  });
});

//  SEARCH TOGGLE
document.addEventListener("DOMContentLoaded", () => {
  const searchToggle = document.querySelector(
    ".header-actions .fa-magnifying-glass, .mobile-search"
  );
  const searchPanel = document.getElementById("header-search");
  const header = document.querySelector(".header");
  const mega = document.getElementById("mega-solutions");

  if (!searchToggle || !searchPanel || !header) return;

  searchToggle.addEventListener("click", (e) => {
    e.preventDefault();

    mega?.classList.add("hidden");
    header.classList.remove("is-mega-open");

    const isOpen = !searchPanel.classList.contains("hidden");
    searchPanel.classList.toggle("hidden", isOpen);
    header.classList.toggle("is-search-open", !isOpen);
  });

  searchPanel.addEventListener("mouseleave", () => {
    searchPanel.classList.add("hidden");
    header.classList.remove("is-search-open");
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      searchPanel.classList.add("hidden");
      header.classList.remove("is-search-open");
    }
  });
});

//  MEGA MENU
document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector(".header");
  if (!header) return;

  function hideAllMega() {
    document
      .querySelectorAll(".mega-menu")
      .forEach((m) => m.classList.add("hidden"));
    header.classList.remove("is-mega-open");
    document
      .querySelectorAll(".header-nav a.is-active")
      .forEach((a) => a.classList.remove("is-active"));
  }

  document.querySelectorAll(".header-nav li.has-mega").forEach((li) => {
    const link = li.querySelector("a");
    const megaClass = [...li.classList].find((c) => c.startsWith("mega-"));
    if (!megaClass) return;

    const mega = document.getElementById(megaClass);
    if (!mega) return;

    li.addEventListener("mouseenter", () => {
      hideAllMega();
      mega.classList.remove("hidden");
      header.classList.add("is-mega-open");
      if (link) link.classList.add("is-active");
    });
  });

  header.addEventListener("mouseleave", hideAllMega);
});

//  VIDEO HOVER PLAY
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("[data-hover-video]").forEach((video) => {
    const card = video.closest(".group");
    if (!card) return;

    card.addEventListener("mouseenter", () => {
      video.currentTime = 0;
      video.play();
    });

    card.addEventListener("mouseleave", () => {
      video.pause();
      video.currentTime = 0;
    });
  });
});

//  LOGO MARQUEE CLONE
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("[data-logo-track]").forEach((track) => {
    const logo = track.querySelector("img");
    if (!logo) return;

    const cloneCount = 12;
    for (let i = 0; i < cloneCount; i++) {
      track.appendChild(logo.cloneNode(true));
    }
  });
});

// HEADER ARROW
document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector(".header");
  const arrow = document.querySelector(".header-arrow");

  if (!header || !arrow) return;

  const lockArrowWhenMegaOpen = () => {
    if (header.classList.contains("is-mega-open")) {
      arrow.classList.add("is-open");
      return true;
    }
    return false;
  };
  arrow.addEventListener("click", (e) => {
    if (lockArrowWhenMegaOpen()) {
      e.preventDefault();
      return;
    }

    arrow.classList.toggle("is-open");
  });

  const observer = new MutationObserver(() => {
    lockArrowWhenMegaOpen();
  });

  observer.observe(header, {
    attributes: true,
    attributeFilter: ["class"],
  });
});

// TESTIMONIAL SLIDER
document.addEventListener("DOMContentLoaded", () => {
  const section = document.querySelector(".testimonial-slider");
  if (!section) return;

  const slides = section.querySelectorAll(".testimonial-slide");
  if (!slides.length) return;

  const nextBtn = section.querySelector(".ts-next");
  const prevBtn = section.querySelector(".ts-prev");
  const progressBar = section.querySelector(".ts-progress__bar");

  let current = 0;
  const total = slides.length;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      if (i === index) {
        // Active Slide
        slide.classList.add("opacity-100", "z-10", "is-active");
        slide.classList.remove("opacity-0", "z-0", "pointer-events-none");
      } else {
        // Inactive Slides
        slide.classList.remove("opacity-100", "z-10", "is-active");
        slide.classList.add("opacity-0", "z-0", "pointer-events-none");
      }
    });

    // Cập nhật Progress Bar
    if (progressBar && total > 1) {
      // Tính toán dựa trên chiều rộng container (72px)
      const progressWidth = 100 / total;
      const moveX = index * 100;
      progressBar.style.width = `${progressWidth}%`;
      progressBar.style.transform = `translateX(${moveX}%)`;
      progressBar.style.transition = "transform 0.5s ease";
    }
  }

  // Khởi tạo slide đầu tiên
  showSlide(0);

  nextBtn?.addEventListener("click", (e) => {
    e.preventDefault();
    current = (current + 1) % total;
    showSlide(current);
  });

  prevBtn?.addEventListener("click", (e) => {
    e.preventDefault();
    current = (current - 1 + total) % total;
    showSlide(current);
  });
});
// COLLAPSED AND EXPANEDED
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".split-hover-block").forEach((block) => {
    const leftPanel = block.querySelector(".left-panel");
    const rightPanel = block.querySelector(".right-panel");
    if (!leftPanel || !rightPanel) return;

    const leftVideo = leftPanel.querySelector(".panel-media video");

    leftPanel.classList.add("is-collapsed");
    rightPanel.classList.add("is-expanded");

    leftPanel.addEventListener("mouseenter", () => {
      leftPanel.classList.add("is-expanded");
      leftPanel.classList.remove("is-collapsed");
      rightPanel.classList.add("is-collapsed");
      rightPanel.classList.remove("is-expanded");

      if (leftVideo) {
        leftVideo.currentTime = 0;
        leftVideo.play().catch(() => {});
      }
    });

    rightPanel.addEventListener("mouseenter", () => {
      rightPanel.classList.add("is-expanded");
      rightPanel.classList.remove("is-collapsed");
      leftPanel.classList.add("is-collapsed");
      leftPanel.classList.remove("is-expanded");

      if (leftVideo) {
        leftVideo.pause();
        leftVideo.currentTime = 0;
      }
    });
  });
});
