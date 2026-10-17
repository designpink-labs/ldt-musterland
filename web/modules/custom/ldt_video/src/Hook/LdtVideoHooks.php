<?php

declare(strict_types=1);

namespace Drupal\ldt_video\Hook;

use Drupal\Core\Hook\Attribute\Hook;

/**
 * Hook-Implementierungen für ldt_video.
 */
class LdtVideoHooks {

  /**
   * Implements hook_theme().
   *
   * Das Template kann im Theme durch eine Datei
   * "ldt-video.html.twig" überschrieben werden.
   */
  #[Hook('theme')]
  public function theme(): array {
    return [
      'ldt_video' => [
        'variables' => [
          'video_url' => NULL,
          'video_mime' => NULL,
          'video_size' => NULL,
          'track_url' => NULL,
          'track_srclang' => 'de',
          'track_label' => 'Deutsch',
          'caption' => NULL,
          'caption_id' => NULL,
        ],
      ],
    ];
  }

}
