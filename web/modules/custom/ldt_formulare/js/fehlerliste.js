/**
 * @file
 * Fehlerliste (Inline Form Errors): Fokus ins richtige Feld setzen.
 *
 * Die Links in der Fehlerliste zeigen auf die ID des Formularelements. Bei
 * Feldgruppen (Radio-Knöpfe, Checkboxen) ist das ein <div>, das keinen Fokus
 * annimmt – der Fokus bliebe dann am Link. Dieses Skript setzt ihn stattdessen
 * auf das ausgewählte bzw. erste Eingabefeld der Gruppe.
 * Ohne JavaScript scrollt der Link wie gewohnt zur Gruppe.
 *
 * Außerdem: Nach dem Absenden mit Fehlern bekommt die Fehlerliste den Fokus
 * (Container mit tabindex="-1", siehe status-messages.html.twig im Theme).
 * Tastatur- und Screenreader-Nutzende landen so direkt bei den Links zu den
 * Feldern. Nur wenn die Meldung solche Links enthält, also nicht bei
 * anderen Fehlermeldungen.
 */
((Drupal, once) => {
  Drupal.behaviors.ldtFehlerliste = {
    attach(context) {
      once('ldt-fehlerfokus', '.messages--error[tabindex="-1"]', context).slice(0, 1).forEach((liste) => {
        if (liste.querySelector('a[href^="#"]')) {
          liste.focus();
        }
      });
      once('ldt-fehlerliste', '[role="alert"] a[href^="#"]', context).forEach((link) => {
        link.addEventListener('click', (event) => {
          const ziel = document.getElementById(decodeURIComponent(link.hash.slice(1)));
          if (!ziel || ziel.matches('input, select, textarea, button, [tabindex]')) {
            return;
          }
          const feld = ziel.querySelector('input:checked') || ziel.querySelector('input:not([type="hidden"]), select, textarea');
          if (!feld) {
            return;
          }
          event.preventDefault();
          feld.focus();
        });
      });
    },
  };
})(Drupal, once);
