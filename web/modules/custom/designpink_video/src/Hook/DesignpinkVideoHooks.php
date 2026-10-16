<?php

declare(strict_types=1);

namespace Drupal\designpink_video\Hook;

use Drupal\Core\Hook\Attribute\Hook;

/**
 * Hook-Implementierungen für designpink_video.
 */
class DesignpinkVideoHooks {

  /**
   * Implements hook_theme().
   *
   * Das Template kann im Theme durch eine Datei
   * "designpink-video.html.twig" überschrieben werden.
   */
  #[Hook('theme')]
  public function theme(): array {
    return [
      'designpink_video' => [
        'variables' => [
          'video_url' => NULL,
          'video_mime' => NULL,
          'video_size' => NULL,
          'track_url' => NULL,
          'track_srclang' => 'de',
          'track_label' => 'Deutsch',
        ],
      ],
    ];
  }

}
