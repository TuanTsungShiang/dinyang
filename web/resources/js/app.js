import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
  const header = document.querySelector('.header');
  if (!header) return;
  const toggle = header.querySelector('.nav-toggle');
  const nav = header.querySelector('.nav');
  if (!toggle || !nav) return;

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
});
