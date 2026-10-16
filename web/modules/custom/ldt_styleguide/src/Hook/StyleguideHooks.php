<?php

declare(strict_types=1);

namespace Drupal\ldt_styleguide\Hook;

use Drupal\Core\Hook\Attribute\Hook;

/**
 * Hook-Implementierungen für ldt_styleguide.
 */
class StyleguideHooks {

  /**
   * Implements hook_theme().
   *
   * Das eigentliche Template liefert das Theme ldt_musterland.
   */
  #[Hook('theme')]
  public function theme(): array {
    return [
      'ldt_styleguide' => [
        'variables' => ['colors' => [], 'pairs' => [], 'zurueck' => NULL],
      ],
    ];
  }

}
