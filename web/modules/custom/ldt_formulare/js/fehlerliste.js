/**
 * @file
 * Fehlerliste (Inline Form Errors): Fokus ins richtige Feld setzen.
 *
 * Die Links in der Fehlerliste zeigen auf die ID des Formularelements. Bei
 * Feldgruppen (Radio-Knöpfe, Checkboxen) ist das ein <div>, das keinen Fokus
 * annimmt – der Fokus bliebe dann am Link. Dieses Skript setzt ihn stattdessen
 * auf das ausgewählte bzw. erste Eingabefeld der Gruppe.
 * Ohne JavaScript scrollt der Link wie gewohnt zur Gruppe.
 */
((Drupal, once) => {
  Drupal.behaviors.ldtFehlerliste = {
    attach(context) {
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
