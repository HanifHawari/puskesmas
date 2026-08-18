// ============================================================
// MAIN.JS — SIPP UPTD PUSKESMAS IPUH
// Global scripts: navbar, toast, animations
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

  // ---- Navbar Scroll Effect --------------------------------
  const navbar = document.getElementById('mainNavbar');
  if (navbar) {
    const onScroll = () => {
      navbar.classList.toggle('scrolled', window.scrollY > 30);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // run on load
  }

  // ---- Hamburger Menu (Mobile) ----------------------------
  const hamburger  = document.getElementById('hamburgerBtn');
  const navMenu    = document.getElementById('navMenu');
  const navOverlay = document.getElementById('navOverlay');

  if (hamburger && navMenu && navOverlay) {
    const openMenu = () => {
      navMenu.classList.add('open');
      navOverlay.classList.add('open');
      hamburger.classList.add('open');
      hamburger.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
    };
    const closeMenu = () => {
      navMenu.classList.remove('open');
      navOverlay.classList.remove('open');
      hamburger.classList.remove('open');
      hamburger.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    };
    hamburger.addEventListener('click', () => {
      navMenu.classList.contains('open') ? closeMenu() : openMenu();
    });
    navOverlay.addEventListener('click', closeMenu);
    // Close on nav link click
    navMenu.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', closeMenu);
    });
  }

  // ---- Reveal on Scroll (Intersection Observer) -----------
  const revealEls = document.querySelectorAll('.reveal');
  if (revealEls.length) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
          setTimeout(() => entry.target.classList.add('visible'), i * 80);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(el => observer.observe(el));
  }

  // ---- Number Counter Animation (Stats) -------------------
  const counters = document.querySelectorAll('[data-count]');
  if (counters.length) {
    const counterObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          animateCount(entry.target);
          counterObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });
    counters.forEach(el => counterObserver.observe(el));
  }

  function animateCount(el) {
    const target   = parseInt(el.dataset.count, 10);
    const suffix   = el.dataset.suffix || '';
    const duration = 1500;
    const start    = performance.now();
    const step = (timestamp) => {
      const progress = Math.min((timestamp - start) / duration, 1);
      const eased    = 1 - Math.pow(1 - progress, 3); // ease-out-cubic
      el.textContent = Math.floor(eased * target) + suffix;
      if (progress < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  }

  
  // ---- Hero Image Slider -----------------------------------
  const slides = document.querySelectorAll(".hero-slide");
  const btnNext = document.querySelector(".slider-btn.next");
  const btnPrev = document.querySelector(".slider-btn.prev");
  let currentSlide = 0;
  let slideInterval;

  if (slides.length > 0) {
    const showSlide = (index) => {
      slides.forEach(s => s.classList.remove("active"));
      slides[index].classList.add("active");
    };

    const nextSlide = () => {
      currentSlide = (currentSlide + 1) % slides.length;
      showSlide(currentSlide);
    };

    const prevSlide = () => {
      currentSlide = (currentSlide - 1 + slides.length) % slides.length;
      showSlide(currentSlide);
    };

    const startSlider = () => {
      slideInterval = setInterval(nextSlide, 3000);
    };

    const resetSlider = () => {
      clearInterval(slideInterval);
      startSlider();
    };

    if (btnNext) btnNext.addEventListener("click", () => { nextSlide(); resetSlider(); });
    if (btnPrev) btnPrev.addEventListener("click", () => { prevSlide(); resetSlider(); });

    startSlider();
  }

  // ---- Smooth Scroll for Anchors --------------------------
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', e => {
      const target = document.querySelector(anchor.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const offset = 80;
        window.scrollTo({
          top: target.getBoundingClientRect().top + window.scrollY - offset,
          behavior: 'smooth'
        });
      }
    });
  });

  // ---- Hero Scroll Button ---------------------------------
  const scrollBtn = document.querySelector('.hero-scroll');
  if (scrollBtn) {
    scrollBtn.addEventListener('click', () => {
      const next = document.querySelector('.section, main > section');
      if (next) next.scrollIntoView({ behavior: 'smooth' });
    });
  }

  // ---- Tab Component (for Profil page) --------------------
  const tabBtns = document.querySelectorAll('[data-tab-btn]');
  const tabPanes = document.querySelectorAll('[data-tab-pane]');
  if (tabBtns.length) {
    tabBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.dataset.tabBtn;
        tabBtns.forEach(b => b.classList.remove('active'));
        tabPanes.forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.querySelector(`[data-tab-pane="${target}"]`)?.classList.add('active');
      });
    });
  }

  // ---- Drag to Scroll for Horizontal Grids (Mobile/Desktop) -----
  const scrollGrids = document.querySelectorAll('.quick-nav-grid, .poli-dashboard-grid, .fasilitas-grid');
  scrollGrids.forEach(slider => {
    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener('mousedown', (e) => {
      isDown = true;
      slider.classList.add('grabbing');
      startX = e.pageX - slider.offsetLeft;
      scrollLeft = slider.scrollLeft;
    });
    slider.addEventListener('mouseleave', () => {
      isDown = false;
      slider.classList.remove('grabbing');
    });
    slider.addEventListener('mouseup', () => {
      isDown = false;
      slider.classList.remove('grabbing');
    });
    slider.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - slider.offsetLeft;
      const walk = (x - startX) * 2; // scroll-fast multiplier
      slider.scrollLeft = scrollLeft - walk;
    });
  });

});

// ============================================================
// TOAST NOTIFICATION (Global Utility)
// Usage: showToast('Berhasil!', 'success')
// Types: 'success' | 'error' | 'warning' | 'info'
// ============================================================
function showToast(message, type = 'info', duration = 4000) {
  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }

  const icons = {
    success: '<i class="fas fa-check-circle" style="color:var(--clr-success)"></i>',
    error:   '<i class="fas fa-times-circle" style="color:var(--clr-danger)"></i>',
    warning: '<i class="fas fa-exclamation-triangle" style="color:var(--clr-warning)"></i>',
    info:    '<i class="fas fa-info-circle" style="color:var(--clr-info)"></i>',
  };

  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `
    <span class="toast-icon">${icons[type] || icons.info}</span>
    <span class="toast-text">${message}</span>
    <button class="toast-close" aria-label="Tutup">
      <i class="fas fa-times"></i>
    </button>
  `;

  const close = () => {
    toast.style.animation = 'slideInRight 0.3s ease reverse';
    setTimeout(() => toast.remove(), 280);
  };

  toast.querySelector('.toast-close').addEventListener('click', close);
  container.appendChild(toast);
  setTimeout(close, duration);
}

// ============================================================
// FORM UTILITIES
// ============================================================
function validateNIK(nik) {
  return /^\d{16}$/.test(nik);
}

function validatePhone(phone) {
  return /^(\+62|62|0)8[1-9][0-9]{7,11}$/.test(phone.replace(/\s/g, ''));
}

function setLoading(btn, isLoading) {
  if (isLoading) {
    btn.dataset.originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner"></span> Memproses...';
    btn.disabled = true;
  } else {
    btn.innerHTML = btn.dataset.originalText || btn.innerHTML;
    btn.disabled = false;
  }
}
