import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
  // ── Nav toggle ──
  const header = document.querySelector('.header');
  if (!header) return;
  const toggle = header.querySelector('.nav-toggle');
  const nav    = header.querySelector('.nav');
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const isOpen = header.dataset.navOpen === 'true';
      header.dataset.navOpen = isOpen ? 'false' : 'true';
      toggle.setAttribute('aria-expanded', String(!isOpen));
    });
    nav.addEventListener('click', (e) => {
      if (e.target.closest('a')) {
        header.dataset.navOpen = 'false';
        toggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  // ── Hero Slider ──
  const slider = document.getElementById('hero-slider');
  if (slider) {
    const track  = document.getElementById('hero-track');
    const slides = slider.querySelectorAll('.hero-slide');
    const dots   = slider.querySelectorAll('.hero-dot');
    let current  = 0;
    let timer;

    function goTo(idx) {
      dots[current]?.classList.remove('active');
      current = (idx + slides.length) % slides.length;
      track.style.transform = `translateX(-${current * 100}%)`;
      dots[current]?.classList.add('active');
    }

    function startTimer() {
      clearInterval(timer);
      timer = setInterval(() => goTo(current + 1), 20000);
    }

    document.getElementById('hero-prev')?.addEventListener('click', () => { goTo(current - 1); startTimer(); });
    document.getElementById('hero-next')?.addEventListener('click', () => { goTo(current + 1); startTimer(); });
    dots.forEach(dot => dot.addEventListener('click', () => { goTo(+dot.dataset.index); startTimer(); }));

    if (slides.length > 1) startTimer();
  }

  // ── Search icon toggle (desktop) ──
  const searchToggle = document.getElementById('search-toggle');
  const searchForm   = document.getElementById('search-form');
  const searchInput  = document.getElementById('search-input');

  if (searchToggle && searchForm) {
    searchToggle.addEventListener('click', () => {
      searchForm.classList.toggle('open');
      if (searchForm.classList.contains('open')) {
        searchInput?.focus();
      }
    });

    // 點擊外部關閉
    document.addEventListener('click', (e) => {
      if (!document.getElementById('header-search').contains(e.target)) {
        searchForm.classList.remove('open');
      }
    });

    // ESC 關閉
    searchInput?.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') searchForm.classList.remove('open');
    });
  }
});
