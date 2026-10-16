<?php

namespace Drupal\ldt_musterland;

use Drupal\Component\Utility\Html;
use Drupal\Core\Security\TrustedCallbackInterface;

/**
 * Legt um jede Tabelle im Fließtext einen scrollbaren Rahmen.
 *
 * Unter 40 rem stellt ldt-tabellen.css jede Zeile als Karte dar. Dafür
 * bekommt jede Datenzelle ihren Spaltenkopf als data-label (sichtbare
 * Beschriftung per CSS), und alle Tabellenelemente bekommen ihre Rolle
 * ausdrücklich (role="table", "row", "columnheader", "rowheader", "cell"):
 * Mit display:block verlieren Browser sonst die Tabellen-Semantik.
 *
 * Der Rahmen bleibt als Sicherheitsnetz für sehr breite Tabellen: Er scrollt
 * für sich (nie die Seite, WCAG 1.4.10), ist per Tastatur erreichbar
 * (tabindex="0") und mit der Tabellenüberschrift (<caption>) beschriftet:
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
      self::rollenUndBeschriftungen($table);
      $parent->replaceChild($rahmen, $table);
      $rahmen->appendChild($table);
    }
    return Html::serialize($dom);
  }

  /**
   * Setzt ARIA-Rollen und data-label (Spaltenköpfe) für die Kartenansicht.
   */
  protected static function rollenUndBeschriftungen(\DOMElement $table): void {
    $table->setAttribute('role', 'table');
    $koepfe = [];
    foreach ($table->getElementsByTagName('thead') as $thead) {
      foreach ($thead->getElementsByTagName('th') as $i => $th) {
        $koepfe[$i] = trim($th->textContent);
      }
    }
    foreach (['thead', 'tbody', 'tfoot'] as $gruppe) {
      foreach ($table->getElementsByTagName($gruppe) as $element) {
        $element->setAttribute('role', 'rowgroup');
      }
    }
    foreach ($table->getElementsByTagName('tr') as $tr) {
      $tr->setAttribute('role', 'row');
      $im_kopf = $tr->parentNode->nodeName === 'thead';
      $spalte = 0;
      foreach ($tr->childNodes as $zelle) {
        if (!$zelle instanceof \DOMElement) {
          continue;
        }
        if ($zelle->nodeName === 'th') {
          $zelle->setAttribute('role', $im_kopf || $zelle->getAttribute('scope') === 'col' ? 'columnheader' : 'rowheader');
        }
        else {
          $zelle->setAttribute('role', 'cell');
          if (isset($koepfe[$spalte])) {
            $zelle->setAttribute('data-label', $koepfe[$spalte]);
          }
        }
        $spalte += max(1, (int) $zelle->getAttribute('colspan'));
      }
    }
  }

}
