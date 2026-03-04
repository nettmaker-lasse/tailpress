(() => {
  document.documentElement.classList.add('js');
  const html = document.documentElement;
  const themeToggle = document.querySelector('[data-theme-toggle]');
  const themeKey = 'tailpress-theme';

  function getPreferredTheme() {
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      return 'dark';
    }

    return 'light';
  }

  function applyTheme(theme) {
    const resolvedTheme = theme === 'dark' ? 'dark' : 'light';
    html.classList.toggle('dark', resolvedTheme === 'dark');

    if (themeToggle) {
      themeToggle.setAttribute('aria-pressed', resolvedTheme === 'dark' ? 'true' : 'false');
      themeToggle.setAttribute(
        'aria-label',
        resolvedTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'
      );
    }
  }

  function setTheme(theme) {
    applyTheme(theme);
    try {
      window.localStorage.setItem(themeKey, theme);
    } catch (error) {
      // Ignore storage errors from private browsing restrictions.
    }
  }

  let initialTheme = getPreferredTheme();
  try {
    const storedTheme = window.localStorage.getItem(themeKey);
    if (storedTheme === 'dark' || storedTheme === 'light') {
      initialTheme = storedTheme;
    }
  } catch (error) {
    // Ignore storage errors from private browsing restrictions.
  }

  applyTheme(initialTheme);

  if (themeToggle) {
    themeToggle.addEventListener('click', () => {
      const nextTheme = html.classList.contains('dark') ? 'light' : 'dark';
      setTheme(nextTheme);
    });
  }

  const siteMenu = document.getElementById('site-menu');
  const menuToggle = document.querySelector('.menu-toggle');
  const menuClose = document.querySelector('.menu-close');
  const submenuToggles = Array.from(document.querySelectorAll('.submenu-toggle'));
  const submenuItems = Array.from(document.querySelectorAll('.menu-item-has-children'));
  const desktopMedia = window.matchMedia('(min-width: 1024px)');
  let previousFocus = null;

  if (!siteMenu || !menuToggle || !menuClose) {
    return;
  }

  const focusableSelector =
    'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

  function isDesktop() {
    return desktopMedia.matches;
  }

  function isMenuOpen() {
    return siteMenu.getAttribute('data-menu-open') === 'true';
  }

  function setSubmenuState(toggle, expanded) {
    const submenuId = toggle.getAttribute('aria-controls');
    const submenu = submenuId ? document.getElementById(submenuId) : null;

    toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    if (submenu) {
      submenu.hidden = !expanded;
    }
  }

  function closeAllSubmenus() {
    submenuToggles.forEach((toggle) => setSubmenuState(toggle, false));
  }

  function setMenuState(open) {
    siteMenu.setAttribute('data-menu-open', open ? 'true' : 'false');
    menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    menuClose.setAttribute('aria-expanded', open ? 'true' : 'false');
    document.body.classList.toggle('menu-open', open);

    if (!open) {
      closeAllSubmenus();
    }
  }

  function getFocusableElements() {
    return Array.from(siteMenu.querySelectorAll(focusableSelector)).filter((el) => {
      return el.offsetParent !== null || el === document.activeElement;
    });
  }

  function openMenu() {
    previousFocus = document.activeElement;
    setMenuState(true);

    const focusables = getFocusableElements();
    if (focusables.length > 0) {
      focusables[0].focus();
    }
  }

  function closeMenu({ restoreFocus = true } = {}) {
    setMenuState(false);
    if (restoreFocus && previousFocus instanceof HTMLElement) {
      previousFocus.focus();
    }
    previousFocus = null;
  }

  function onMenuKeyDown(event) {
    if (event.key === 'Escape') {
      const expandedToggle = submenuToggles.find((toggle) => toggle.getAttribute('aria-expanded') === 'true');

      if (expandedToggle) {
        setSubmenuState(expandedToggle, false);
        expandedToggle.focus();
        return;
      }

      if (!isDesktop() && isMenuOpen()) {
        closeMenu();
      }
      return;
    }

    if (event.key !== 'Tab' || isDesktop() || !isMenuOpen()) {
      return;
    }

    const focusables = getFocusableElements();
    if (!focusables.length) {
      return;
    }

    const first = focusables[0];
    const last = focusables[focusables.length - 1];

    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
      return;
    }

    if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  }

  function onResizeChange(event) {
    if (event.matches) {
      setMenuState(false);
    }
  }

  menuToggle.addEventListener('click', () => {
    if (isMenuOpen()) {
      closeMenu();
      return;
    }

    openMenu();
  });

  menuClose.addEventListener('click', () => closeMenu());

  submenuToggles.forEach((toggle) => {
    toggle.addEventListener('click', (event) => {
      event.preventDefault();
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      setSubmenuState(toggle, !expanded);
    });

    toggle.addEventListener('keydown', (event) => {
      if (event.key !== 'Enter' && event.key !== ' ') {
        return;
      }

      event.preventDefault();
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      setSubmenuState(toggle, !expanded);
    });
  });

  submenuItems.forEach((item) => {
    const toggle = item.querySelector(':scope > .submenu-toggle');
    if (!toggle) {
      return;
    }

    item.addEventListener('mouseenter', () => {
      if (isDesktop()) {
        setSubmenuState(toggle, true);
      }
    });

    item.addEventListener('mouseleave', () => {
      if (isDesktop()) {
        setSubmenuState(toggle, false);
      }
    });

    item.addEventListener('focusin', () => {
      if (isDesktop()) {
        setSubmenuState(toggle, true);
      }
    });

    item.addEventListener('focusout', (event) => {
      if (!isDesktop()) {
        return;
      }

      const next = event.relatedTarget;
      if (next instanceof Node && item.contains(next)) {
        return;
      }

      setSubmenuState(toggle, false);
    });
  });

  siteMenu.addEventListener('keydown', onMenuKeyDown);
  desktopMedia.addEventListener('change', onResizeChange);

  setMenuState(false);
})();
