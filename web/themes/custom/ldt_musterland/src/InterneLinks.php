<?php

namespace Drupal\ldt_musterland;

use Drupal\Core\Security\TrustedCallbackInterface;

/**
 * Macht feste interne Links im Fließtext unterordner-fest.
 *
 * Links auf Inhalte speichert Linkit mit Kennung (data-entity-uuid); Drupal
 * setzt die Adresse beim Ausgeben, auch mit Unterordner. Links auf andere
 * Seiten, etwa /styleguide, stehen dagegen als feste Adresse im Text. Läuft
 * die Website in einem Unterordner (Strato: /drupal), bekommen solche Links
 * hier den Basis-Pfad vorangestellt: /styleguide → /drupal/styleguide.
 * Ohne Unterordner (lokal) bleibt alles unverändert.
 *
 * @see \Drupal\ldt_musterland\Hook\LdtMusterlandHooks::preprocessField()
 */
class InterneLinks implements TrustedCallbackInterface {

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
    return self::mitBasispfad((string) $markup, \Drupal::request()->getBasePath() . '/');
  }

  /**
   * Stellt $basis vor href="/…" in Links ohne Linkit-Kennung.
   */
  public static function mitBasispfad(string $markup, string $basis): string {
    if ($basis === '/' || !str_contains($markup, 'href="/')) {
      return $markup;
    }
    return preg_replace_callback('/<a\b[^>]*>/i', function (array $m) use ($basis) {
      $tag = $m[0];
      if (str_contains($tag, 'data-entity-uuid')) {
        return $tag;
      }
      return preg_replace_callback('/\bhref="(\/[^"]*)"/', function (array $h) use ($basis) {
        $href = $h[1];
        // Schon mit Basis-Pfad oder protokoll-relativ (//host): unverändert.
        if (str_starts_with($href, $basis) || str_starts_with($href, '//')) {
          return $h[0];
        }
        return 'href="' . $basis . ltrim($href, '/') . '"';
      }, $tag);
    }, $markup);
  }

}
