<?php

declare(strict_types=1);

namespace Drupal\ldt_styleguide\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ThemeExtensionList;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Seite /styleguide: alle Bausteine, Kontraste live aus tokens.css berechnet.
 */
class StyleguideController extends ControllerBase {

  /**
   * Geprüfte Farbkombinationen: [Vordergrund, Hintergrund, Verwendung, Art].
   *
   * Art "text" = mind. 4,5:1, "ui" = Bedienelemente/Fokus mind. 3:1.
   */
  protected const PAIRS = [
    ['--c-text', '--c-bg', 'Fließtext', 'text'],
    ['--c-text', '--c-surface', 'Text auf heller Fläche', 'text'],
    ['--c-text-muted', '--c-bg', 'Gedämpfter Text (Brotkrumen, Hilfetexte)', 'text'],
    ['--c-accent', '--c-bg', 'Links, Akzent', 'text'],
    ['--c-accent', '--c-surface', 'Links auf heller Fläche', 'text'],
    ['--c-accent-dark', '--c-bg', 'Links: Hover und besucht', 'text'],
    ['--c-accent-dark', '--c-accent-soft', 'Hover auf rosa Fläche', 'text'],
    ['--c-text', '--c-accent-soft', 'Text auf rosa Fläche (Karten-Hover)', 'text'],
    ['#ffffff', '--c-accent', 'Button-Text', 'text'],
    ['#ffffff', '--c-accent-dark', 'Button-Text (Hover)', 'text'],
    ['#ffffff', '--c-dark', 'Footer-Text', 'text'],
    ['--c-accent-on-dark', '--c-dark', 'Footer: Hover und Fokus-Rahmen', 'text'],
    ['--c-line-strong', '--c-bg', 'Rahmen von Formularfeldern', 'ui'],
    ['--c-accent', '--c-bg', 'Fokus-Rahmen', 'ui'],
    ['--c-text', '--c-hint-bg', 'Hinweisbalken „Musterseite“', 'text'],
    ['--c-text', '--c-info-bg', 'Hinweisbox Information: Text', 'text'],
    ['--c-info', '--c-info-bg', 'Hinweisbox Information: Rahmen und Icon', 'ui'],
    ['--c-text', '--c-success-bg', 'Hinweisbox Erfolg: Text', 'text'],
    ['--c-success', '--c-success-bg', 'Hinweisbox Erfolg: Rahmen und Icon', 'ui'],
    ['--c-text', '--c-warning-bg', 'Hinweisbox Warnung: Text', 'text'],
    ['--c-warning', '--c-warning-bg', 'Hinweisbox Warnung: Rahmen und Icon', 'ui'],
    ['--c-text', '--c-error-bg', 'Hinweisbox Fehler: Text', 'text'],
    ['--c-error', '--c-error-bg', 'Hinweisbox Fehler: Rahmen und Icon', 'ui'],
    ['--c-error', '--c-bg', 'Fehlermeldung am Formularfeld', 'text'],
  ];

  public function __construct(
    protected ThemeExtensionList $themeList,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): static {
    return new static($container->get('extension.list.theme'));
  }

  /**
   * Baut die Styleguide-Seite.
   */
  public function page(): array {
    $colors = $this->readTokens();
    $pairs = [];
    foreach (self::PAIRS as [$fg, $bg, $usage, $type]) {
      $fg_hex = $colors[$fg] ?? $fg;
      $bg_hex = $colors[$bg] ?? $bg;
      $ratio = $this->contrast($fg_hex, $bg_hex);
      $required = $type === 'text' ? 4.5 : 3.0;
      $pairs[] = [
        'fg' => $fg_hex,
        'bg' => $bg_hex,
        'fg_name' => str_starts_with($fg, '--') ? $fg : '',
        'bg_name' => str_starts_with($bg, '--') ? $bg : '',
        'usage' => $usage,
        'ratio' => number_format($ratio, 2, ',', ''),
        'required' => number_format($required, 1, ',', ''),
        'pass' => $ratio >= $required,
      ];
    }

    return [
      '#theme' => 'ldt_styleguide',
      '#colors' => $colors,
      '#pairs' => $pairs,
      '#attached' => [
        'html_head' => [[
          ['#tag' => 'meta', '#attributes' => ['name' => 'robots', 'content' => 'noindex, nofollow']],
          'ldt_styleguide_robots',
        ]],
      ],
    ];
  }

  /**
   * Liest die Farb-Tokens (--c-*) aus tokens.css des Themes.
   */
  protected function readTokens(): array {
    $file = $this->themeList->getPath('ldt_musterland') . '/css/base/tokens.css';
    $css = is_readable($file) ? file_get_contents($file) : '';
    preg_match_all('/(--c-[a-z-]+):\s*(#[0-9a-fA-F]{6})\b/', $css, $matches, PREG_SET_ORDER);
    $colors = [];
    foreach ($matches as $m) {
      $colors[$m[1]] ??= strtolower($m[2]);
    }
    return $colors;
  }

  /**
   * Kontrastverhältnis nach WCAG 2.1.
   */
  protected function contrast(string $a, string $b): float {
    $la = $this->luminance($a);
    $lb = $this->luminance($b);
    return (max($la, $lb) + 0.05) / (min($la, $lb) + 0.05);
  }

  /**
   * Relative Leuchtdichte einer Hex-Farbe.
   */
  protected function luminance(string $hex): float {
    $hex = ltrim($hex, '#');
    $channels = [];
    foreach ([0, 2, 4] as $i) {
      $c = hexdec(substr($hex, $i, 2)) / 255;
      $channels[] = $c <= 0.04045 ? $c / 12.92 : (($c + 0.055) / 1.055) ** 2.4;
    }
    return 0.2126 * $channels[0] + 0.7152 * $channels[1] + 0.0722 * $channels[2];
  }

}
