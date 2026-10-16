<?php

namespace Drupal\ldt_musterland;

use Drupal\Component\Utility\Html;
use Drupal\Core\Security\TrustedCallbackInterface;

/**
 * Legt um jede Tabelle im Fließtext einen scrollbaren Rahmen.
 *
 * Auf schmalen Bildschirmen scrollt dann nur die Tabelle, nicht die ganze
 * Seite (WCAG 1.4.10). Der Rahmen ist per Tastatur erreichbar
 * (tabindex="0", scrollt mit den Pfeiltasten) und als Bereich mit der
 * Tabellenüberschrift (<caption>) beschriftet:
 *
 *   <div class="tabelle" role="region" tabindex="0" aria-labelledby="…">
 *     <table><caption id="…">…</caption>…</table>
 *   </div>
 *
 * @see \Drupal\ldt_musterland\Hook\LdtMusterlandHooks::preprocessField()
 */
class TabellenRahmen implements TrustedCallbackInterface {

  /**
   * {@inheritdoc}
   */
  public static function trustedCallbacks(): array {
    return ['postRender'];
  }

  /**
   * #post_render-Callback für Textfelder.
   */
  public static function postRender($markup, array $element) {
    if (!str_contains((string) $markup, '<table')) {
      return $markup;
    }
    $dom = Html::load((string) $markup);
    foreach (iterator_to_array($dom->getElementsByTagName('table')) as $table) {
      $parent = $table->parentNode;
      if ($parent instanceof \DOMElement && $parent->getAttribute('class') === 'tabelle') {
        continue;
      }
      $rahmen = $dom->createElement('div');
      $rahmen->setAttribute('class', 'tabelle');
      $rahmen->setAttribute('role', 'region');
      $rahmen->setAttribute('tabindex', '0');
      $caption = $table->getElementsByTagName('caption')->item(0);
      if ($caption) {
        if (!$caption->getAttribute('id')) {
          $caption->setAttribute('id', 'tabelle-' . substr(md5($caption->textContent), 0, 8));
        }
        $rahmen->setAttribute('aria-labelledby', $caption->getAttribute('id'));
      }
      else {
        $rahmen->setAttribute('aria-label', 'Tabelle');
      }
      $parent->replaceChild($rahmen, $table);
      $rahmen->appendChild($table);
    }
    return Html::serialize($dom);
  }

}
