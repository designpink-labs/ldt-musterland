<?php

namespace Drupal\ldt_musterland\Hook;

use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\Url;

/**
 * Hook implementations for ldt_musterland.
 */
class LdtMusterlandHooks {

  /**
   * Implements hook_preprocess_image_widget().
   */
  #[Hook('preprocess_image_widget')]
  public function preprocessImageWidget(array &$variables): void {
    $data = &$variables['data'];
    // This prevents image widget templates from rendering preview container
    // HTML to users that do not have permission to access these previews.
    // @todo revisit in https://drupal.org/node/953034
    // @todo revisit in https://drupal.org/node/3114318
    if (isset($data['preview']['#access']) && $data['preview']['#access'] === FALSE) {
      unset($data['preview']);
    }
  }

  /**
   * Implements hook_preprocess_menu().
   *
   * Aktuelle Adresse für aria-current="page" in den Menü-Templates.
   */
  #[Hook('preprocess_menu')]
  public function preprocessMenu(array &$variables): void {
    $variables['current_path'] = $this->currentPath();
    $variables['#cache']['contexts'][] = 'url.path';
  }

  /**
   * Implements hook_preprocess_breadcrumb().
   *
   * - Erster Eintrag heißt "Start" wie im Hauptmenü.
   * - Die aktuelle Seite wird als letzter Eintrag (ohne Link) ergänzt.
   */
  #[Hook('preprocess_breadcrumb')]
  public function preprocessBreadcrumb(array &$variables): void {
    if (empty($variables['breadcrumb'])) {
      return;
    }
    $variables['breadcrumb'][0]['text'] = 'Start';

    $request = \Drupal::request();
    $route = \Drupal::routeMatch()->getRouteObject();
    if ($route) {
      $title = \Drupal::service('title_resolver')->getTitle($request, $route);
      if ($title) {
        $variables['breadcrumb'][] = ['text' => $title];
      }
    }
    $variables['#cache']['contexts'][] = 'url.path';
  }

  /**
   * Gibt die aktuelle Adresse so zurück, wie Menülinks sie erzeugen.
   */
  protected function currentPath(): string {
    if (\Drupal::service('path.matcher')->isFrontPage()) {
      return Url::fromRoute('<front>')->toString();
    }
    return Url::fromRoute('<current>')->toString();
  }

}
