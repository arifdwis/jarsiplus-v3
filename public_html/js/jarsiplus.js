/**
 * JARSIPLUS 2026 — Frontend behaviour (portal publik & pemohon)
 * Vanilla JS, tanpa dependensi eksternal.
 *
 * Catatan: selector di bawah menyesuaikan markup komponen Blade yang
 * sebenarnya (jp-carousel__track, jp-toast__close, dst). Sebelumnya sebagian
 * selector memakai penamaan lama sehingga carousel & toast tidak pernah aktif.
 */

document.addEventListener('DOMContentLoaded', () => {
  /* ---------------------------------------------
   * 1. Bayangan header saat halaman digulir
   * --------------------------------------------- */
  const header = document.querySelector('.jp-header');
  if (header) {
    const syncHeader = () => header.classList.toggle('is-scrolled', window.scrollY > 8);
    syncHeader();
    window.addEventListener('scroll', syncHeader, { passive: true });
  }

  /* ---------------------------------------------
   * 2. Drawer navigasi mobile
   * --------------------------------------------- */
  const menuToggle = document.querySelector('.jp-menu-toggle');
  const drawerNav = document.querySelector('.jp-drawer');
  const drawerOverlay = document.querySelector('.jp-drawer-overlay');
  const drawerClose = document.querySelector('.jp-drawer-close');

  const openDrawer = () => {
    if (!drawerNav) return;
    drawerNav.classList.add('is-open');
    if (drawerOverlay) drawerOverlay.classList.add('is-open');
    if (menuToggle) menuToggle.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  };

  const closeDrawer = () => {
    if (!drawerNav) return;
    drawerNav.classList.remove('is-open');
    if (drawerOverlay) drawerOverlay.classList.remove('is-open');
    if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  };

  if (menuToggle) menuToggle.addEventListener('click', openDrawer);
  if (drawerClose) drawerClose.addEventListener('click', closeDrawer);
  if (drawerOverlay) drawerOverlay.addEventListener('click', closeDrawer);

  /* ---------------------------------------------
   * 2b. Dropdown akun pengguna
   * --------------------------------------------- */
  const userToggle = document.getElementById('userMenuBtn');
  const userDropdown = document.getElementById('userMenuDropdown');
  if (userToggle && userDropdown) {
    userToggle.addEventListener('click', (e) => {
      e.stopPropagation();
      const open = userDropdown.classList.toggle('is-open');
      userToggle.setAttribute('aria-expanded', String(open));
    });

    document.addEventListener('click', (e) => {
      if (!userDropdown.contains(e.target) && !userToggle.contains(e.target)) {
        userDropdown.classList.remove('is-open');
        userToggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    closeDrawer();
    if (userDropdown) {
      userDropdown.classList.remove('is-open');
      if (userToggle) userToggle.setAttribute('aria-expanded', 'false');
    }
  });

  /* ---------------------------------------------
   * 3. Accordion — mendukung dua penamaan markup
   *    (.jp-accordion-header dan .jp-accordion__trigger)
   * --------------------------------------------- */
  const accordionTriggers = document.querySelectorAll(
    '.jp-accordion-header, .jp-accordion__trigger, .jp-faq-trigger'
  );

  accordionTriggers.forEach((btn) => {
    btn.addEventListener('click', () => {
      const item = btn.closest('.jp-accordion-item, .jp-accordion__item, .jp-faq-item');
      const group = btn.closest('.jp-accordion, .jp-faq-list');
      const expanded = btn.getAttribute('aria-expanded') === 'true';

      if (group) {
        group.querySelectorAll('.jp-accordion-header, .jp-accordion__trigger, .jp-faq-trigger')
          .forEach((other) => {
            if (other === btn) return;
            other.setAttribute('aria-expanded', 'false');
            const otherItem = other.closest('.jp-accordion-item, .jp-accordion__item, .jp-faq-item');
            if (otherItem) {
              otherItem.classList.remove('is-active');
              otherItem.removeAttribute('data-open');
            }
          });
      }

      btn.setAttribute('aria-expanded', String(!expanded));
      if (item) {
        item.classList.toggle('is-active', !expanded);
        if (expanded) item.removeAttribute('data-open');
        else item.setAttribute('data-open', '');
      }
    });
  });

  /* ---------------------------------------------
   * 4. Carousel — geser track, tombol prev/next, dot, autoplay
   * --------------------------------------------- */
  document.querySelectorAll('.jp-carousel').forEach((carousel) => {
    const track = carousel.querySelector('.jp-carousel__track');
    const slides = carousel.querySelectorAll('.jp-carousel__slide');
    const prevBtn = carousel.querySelector('.jp-carousel__prev');
    const nextBtn = carousel.querySelector('.jp-carousel__next');
    const dots = carousel.querySelectorAll('.jp-carousel__dot');

    if (!track || slides.length === 0) return;

    let index = 0;

    const goTo = (next) => {
      index = (next + slides.length) % slides.length;
      track.style.transform = `translateX(-${index * 100}%)`;
      slides.forEach((s, i) => s.classList.toggle('is-active', i === index));
      dots.forEach((d, i) => d.classList.toggle('is-active', i === index));
    };

    if (prevBtn) prevBtn.addEventListener('click', () => goTo(index - 1));
    if (nextBtn) nextBtn.addEventListener('click', () => goTo(index + 1));
    dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)));

    goTo(0);

    // Autoplay berhenti saat kursor/fokus berada di dalam carousel.
    if (slides.length > 1 && carousel.dataset.autoplay !== 'off') {
      const delay = parseInt(carousel.dataset.interval, 10) || 6000;
      let timer = setInterval(() => goTo(index + 1), delay);
      const stop = () => clearInterval(timer);
      const start = () => { stop(); timer = setInterval(() => goTo(index + 1), delay); };
      carousel.addEventListener('mouseenter', stop);
      carousel.addEventListener('mouseleave', start);
      carousel.addEventListener('focusin', stop);
      carousel.addEventListener('focusout', start);
    }
  });

  /* ---------------------------------------------
   * 5. Toast — mendukung .jp-toast-dismiss dan .jp-toast__close
   * --------------------------------------------- */
  document.querySelectorAll('.jp-toast').forEach((toast) => {
    const dismissBtn = toast.querySelector('.jp-toast-dismiss, .jp-toast__close');

    const dismiss = () => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(8px)';
      setTimeout(() => {
        if (typeof toast.close === 'function' && toast.open) toast.close();
        toast.remove();
      }, 240);
    };

    if (dismissBtn) dismissBtn.addEventListener('click', dismiss);

    const duration = parseInt(toast.dataset.duration, 10) || 5000;
    setTimeout(dismiss, duration);
  });

  /* ---------------------------------------------
   * 6. Pencarian FAQ sisi klien
   * --------------------------------------------- */
  const faqSearch = document.getElementById('faqSearchInput');
  if (faqSearch) {
    const emptyNote = document.getElementById('faqSearchEmpty');
    faqSearch.addEventListener('input', (e) => {
      const term = e.target.value.toLowerCase().trim();
      const items = document.querySelectorAll('.jp-faq-item, .jp-accordion-item');
      let visible = 0;

      items.forEach((item) => {
        const match = item.textContent.toLowerCase().includes(term);
        item.style.display = match ? '' : 'none';
        if (match) visible++;
      });

      if (emptyNote) emptyNote.style.display = visible === 0 ? '' : 'none';
    });
  }

  /* ---------------------------------------------
   * 7. Animasi angka statistik ([data-count])
   * --------------------------------------------- */
  const counters = document.querySelectorAll('[data-count]');
  if (counters.length) {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const animate = (el) => {
      const target = parseInt(el.getAttribute('data-count'), 10);
      if (isNaN(target)) return;

      if (reduceMotion) {
        el.textContent = target.toLocaleString('id-ID');
        return;
      }

      const duration = 900;
      const startTime = performance.now();

      const tick = (now) => {
        const progress = Math.min((now - startTime) / duration, 1);
        // ease-out cubic
        const eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.round(target * eased).toLocaleString('id-ID');
        if (progress < 1) requestAnimationFrame(tick);
      };

      requestAnimationFrame(tick);
    };

    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          animate(entry.target);
          observer.unobserve(entry.target);
        });
      }, { threshold: 0.35 });
      counters.forEach((el) => observer.observe(el));
    } else {
      counters.forEach(animate);
    }
  }

  /* ---------------------------------------------
   * 8. File drop — umpan balik saat berkas diseret
   * --------------------------------------------- */
  document.querySelectorAll('.jp-file-drop').forEach((drop) => {
    const input = drop.querySelector('.jp-file-drop__input');
    const text = drop.querySelector('.jp-file-drop__text');
    if (!input) return;

    ['dragenter', 'dragover'].forEach((evt) =>
      drop.addEventListener(evt, (e) => {
        e.preventDefault();
        drop.classList.add('is-dragover');
      })
    );

    ['dragleave', 'drop'].forEach((evt) =>
      drop.addEventListener(evt, (e) => {
        e.preventDefault();
        drop.classList.remove('is-dragover');
      })
    );

    drop.addEventListener('drop', (e) => {
      if (e.dataTransfer && e.dataTransfer.files.length) {
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event('change', { bubbles: true }));
      }
    });

    input.addEventListener('change', () => {
      if (!text || !input.files.length) return;
      text.textContent = input.files.length === 1
        ? input.files[0].name
        : `${input.files.length} berkas dipilih`;
    });
  });
});
