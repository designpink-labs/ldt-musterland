/**
 * @file
 * Hauptnavigation: Menü-Button (mobil) und Untermenüs (Disclosure-Muster).
 *
 * - Buttons schalten aria-expanded; CSS blendet anhand dessen ein/aus.
 * - Escape schließt das offene Untermenü bzw. das mobile Menü und setzt
 *   den Fokus auf den auslösenden Button zurück.
 * - Desktop: nur ein Untermenü gleichzeitig; Klick außerhalb oder Fokus
 *   außerhalb schließt es.
 * - Ohne JavaScript bleibt die Navigation als normale Liste nutzbar.
 */
((Drupal, once) => {
  const desktop = window.matchMedia('(min-width: 64em)');

  function setExpanded(button, expanded) {
    button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
  }

  function closeAllSubmenus(except) {
    document
      .querySelectorAll('.main-nav__toggle[aria-expanded="true"]')
      .forEach((button) => {
        if (button !== except) {
          setExpanded(button, false);
        }
      });
  }

  Drupal.behaviors.ldtNavigation = {
    attach(context) {
      // Menü-Button (mobil).
      once('ldt-menu-toggle', '.menu-toggle', context).forEach((button) => {
        const nav = document.getElementById(button.getAttribute('aria-controls'));
        if (!nav) {
          return;
        }
        button.hidden = false;
        button.addEventListener('click', () => {
          const open = button.getAttribute('aria-expanded') !== 'true';
          setExpanded(button, open);
          nav.classList.toggle('is-open', open);
        });
      });

      // Untermenü-Buttons.
      once('ldt-submenu', '.main-nav__toggle', context).forEach((button) => {
        button.addEventListener('click', () => {
          const open = button.getAttribute('aria-expanded') !== 'true';
          if (open && desktop.matches) {
            closeAllSubmenus(button);
          }
          setExpanded(button, open);
        });

        // Desktop: Untermenü schließen, wenn der Fokus den Bereich verlässt.
        const item = button.closest('.main-nav__item');
        item.addEventListener('focusout', (event) => {
          if (desktop.matches && !item.contains(event.relatedTarget)) {
            setExpanded(button, false);
          }
        });
      });

      once('ldt-nav-global', 'html', context).forEach(() => {
        document.addEventListener('keydown', (event) => {
          if (event.key !== 'Escape') {
            return;
          }
          const openSub = document.querySelector('.main-nav__toggle[aria-expanded="true"]');
          if (openSub) {
            setExpanded(openSub, false);
            openSub.focus();
            return;
          }
          const menuButton = document.querySelector('.menu-toggle[aria-expanded="true"]');
          if (menuButton) {
            menuButton.click();
            menuButton.focus();
          }
        });

        document.addEventListener('click', (event) => {
          if (desktop.matches && !event.target.closest('.main-nav')) {
            closeAllSubmenus();
          }
        });
      });
    },
  };
})(Drupal, once);
