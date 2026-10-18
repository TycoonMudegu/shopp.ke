const menuButton = document.querySelector('.menu-toggle');
const mobileMenu = document.querySelector('#mobile-menu');
function closeMenu() {
  if (!menuButton || !mobileMenu) return;
  menuButton.setAttribute('aria-expanded', 'false');
  menuButton.setAttribute('aria-label', 'Open menu');
  mobileMenu.hidden = true;
}
menuButton?.addEventListener('click', () => {
  const open = menuButton.getAttribute('aria-expanded') !== 'true';
  menuButton.setAttribute('aria-expanded', String(open));
  menuButton.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
  mobileMenu.hidden = !open;
});
document.addEventListener('keydown', event => {
  if (event.key === 'Escape' && menuButton?.getAttribute('aria-expanded') === 'true') {
    closeMenu();
    menuButton.focus();
  }
});
document.addEventListener('click', event => {
  if (!event.target.closest('.site-header')) closeMenu();
});
matchMedia('(min-width: 1001px)').addEventListener('change', event => { if (event.matches) closeMenu(); });

document.querySelectorAll('[data-back-top]').forEach(link => link.addEventListener('click', event => {
  event.preventDefault();
  window.scrollTo({ top: 0, behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth' });
}));

const tabs = [...document.querySelectorAll('[data-tab]')];
function activateTab(tab) {
  tabs.forEach(item => {
    const active = item === tab;
    item.setAttribute('aria-selected', String(active));
    item.tabIndex = active ? 0 : -1;
  });
  document.querySelectorAll('[data-panel]').forEach(panel => { panel.hidden = panel.dataset.panel !== tab.dataset.tab; });
}
tabs.forEach((tab, index) => {
  tab.addEventListener('click', () => activateTab(tab));
  tab.addEventListener('keydown', event => {
    let next;
    if (['ArrowDown', 'ArrowRight'].includes(event.key)) next = (index + 1) % tabs.length;
    if (['ArrowUp', 'ArrowLeft'].includes(event.key)) next = (index + tabs.length - 1) % tabs.length;
    if (event.key === 'Home') next = 0;
    if (event.key === 'End') next = tabs.length - 1;
    if (next === undefined) return;
    event.preventDefault();
    activateTab(tabs[next]);
    tabs[next].focus();
  });
});

const filters = [...document.querySelectorAll('[data-filter]')];
const storyCards = [...document.querySelectorAll('[data-category]')];
filters.forEach(button => button.addEventListener('click', () => {
  filters.forEach(item => item.setAttribute('aria-pressed', String(item === button)));
  let visible = 0;
  storyCards.forEach(card => {
    card.hidden = button.dataset.filter !== 'all' && button.dataset.filter !== card.dataset.category;
    if (!card.hidden) visible++;
  });
  const count = document.querySelector('#filter-status');
  if (count) count.textContent = visible + (visible === 1 ? ' field note' : ' field notes');
}));

const coverageForm = document.querySelector('#coverage-form');
coverageForm?.addEventListener('submit', event => {
  event.preventDefault();
  const area = new FormData(coverageForm).get('area');
  const result = document.querySelector('#coverage-result');
  if (!area) return;
  result.hidden = false;
  result.querySelector('strong').textContent = area === 'Other' ? 'Let\'s check your route.' : 'Let\'s plan your delivery.';
  result.querySelector('p').textContent = area === 'Other'
    ? 'Tell us where you collect and deliver. We will confirm availability before you book.'
    : 'Coverage and timing depend on your pickup point and destination. Ask us for a route-specific quote.';
  result.querySelector('a').href = '/reach-out?topic=Delivery&area=' + encodeURIComponent(area);
});

document.querySelectorAll('form[method="post"]').forEach(form => form.addEventListener('submit', () => {
  if (!form.checkValidity()) return;
  const button = form.querySelector('button[type="submit"]');
  if (button) {
    button.disabled = true;
    button.setAttribute('aria-busy', 'true');
  }
}));
document.querySelector('#form-notice')?.focus({ preventScroll: false });

window.addEventListener('pageshow', () => {
  document.querySelectorAll('button[aria-busy="true"]').forEach(button => {
    button.disabled = false;
    button.removeAttribute('aria-busy');
  });
});

document.querySelector('[data-share]')?.addEventListener('click', async event => {
  const button = event.currentTarget;
  const status = document.querySelector('#share-status');
  try {
    await navigator.clipboard.writeText(location.href);
    status.textContent = 'Link copied.';
  } catch {
    status.textContent = 'Copy this link: ' + location.href;
  }
  button.setAttribute('aria-label', 'Copy article link');
});
