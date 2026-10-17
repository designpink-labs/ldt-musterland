<?php

namespace Drupal\ldt_musterland;

use Drupal\Component\Utility\Html;
use Drupal\Core\Security\TrustedCallbackInterface;
use Drupal\image\Entity\ImageStyle;

/**
 * Fotos als WebP in drei Größen (srcset/sizes), selbst gehostet.
 *
 * Die Varianten erzeugt Drupal über die Bildstile bild_640, bild_1280 und
 * bild_1920 (skalieren, in WebP umwandeln) beim ersten Abruf. Gilt für
 * Bilder aus sites/default/files/bilder/:
 * - Kopfbilder (Feld field_kopfbild, siehe LdtMusterlandHooks),
 * - Bilder im Fließtext (#post_render, z. B. Card Sorting).
 *
 * Breite und Höhe bleiben gesetzt (kein Springen beim Laden). Der Ausschnitt
 * (object-position) steht in AUSSCHNITT: Gesichter nicht abschneiden, Text im
 * Bildhintergrund möglichst weglassen.
 */
class BildVarianten implements TrustedCallbackInterface {

  /**
   * Bildstile: Breite in Pixeln.
   */
  const STILE = ['bild_640' => 640, 'bild_1280' => 1280, 'bild_1920' => 1920];

  /**
   * Bildausschnitt je Datei (CSS object-position) für zugeschnittene Bilder.
   */
  const AUSSCHNITT = [
    // Oben im Bild englischer Text auf einem Bildschirm: unten verankern.
    'start.jpg' => '50% 100%',
    'barrierefreiheit.jpg' => '50% 62%',
    'online-redaktion.jpg' => '50% 18%',
    'web-optimierung.jpg' => '50% 40%',
    'schulungen.jpg' => '50% 42%',
  ];

  /**
   * {@inheritdoc}
   */
  public static function trustedCallbacks(): array {
    return ['postRender'];
  }

  /**
   * Attribute für ein <img>: src (1280), srcset, sizes, width, height.
   *
   * @param string $uri
   *   Datei-URI, z. B. public://bilder/start.jpg.
   * @param string $sizes
   *   Wert für sizes.
   */
  public static function attribute(string $uri, string $sizes): array {
    [$breite, $hoehe] = @getimagesize($uri) ?: [0, 0];
    $srcset = [];
    $src = NULL;
    foreach (self::STILE as $stil => $w) {
      $style = ImageStyle::load($stil);
      if (!$style || !$breite) {
        continue;
      }
      $w = min($w, $breite);
      $url = \Drupal::service('file_url_generator')->transformRelative($style->buildUrl($uri));
      $srcset[$w] = $url . ' ' . $w . 'w';
      if ($stil === 'bild_1280') {
        $src = $url;
      }
    }
    $attr = ['src' => $src ?? \Drupal::service('file_url_generator')->generateString($uri), 'sizes' => $sizes];
    if ($srcset) {
      $attr['srcset'] = implode(', ', $srcset);
    }
    if ($breite) {
      $w = min(1920, $breite);
      $attr['width'] = $w;
      $attr['height'] = (int) round($hoehe * $w / $breite);
    }
    if ($pos = self::AUSSCHNITT[basename($uri)] ?? NULL) {
      $attr['style'] = 'object-position: ' . $pos;
    }
    return $attr;
  }

  /**
   * #post_render: Fotos im Fließtext bekommen srcset/sizes (WebP).
   */
  public static function postRender($markup, array $element) {
    $markup = (string) $markup;
    if (!str_contains($markup, '/files/bilder/')) {
      return $markup;
    }
    $dom = Html::load($markup);
    foreach ($dom->getElementsByTagName('img') as $img) {
      if (!preg_match('#/files/(bilder/[^"?]+)#', $img->getAttribute('src'), $m)) {
        continue;
      }
      // Angezeigte Breite (width-Attribut) bestimmt sizes.
      $anzeige = (int) $img->getAttribute('width') ?: 720;
      $attr = self::attribute('public://' . rawurldecode($m[1]), "(min-width: {$anzeige}px) {$anzeige}px, 100vw");
      unset($attr['width'], $attr['height'], $attr['style']);
      foreach ($attr as $name => $wert) {
        $img->setAttribute($name, (string) $wert);
      }
      $img->setAttribute('decoding', 'async');
    }
    return Html::serialize($dom);
  }

}
