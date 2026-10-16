<?php

declare(strict_types=1);

namespace Drupal\ldt_musterhinweis\Hook;

use Drupal\Core\Block\BlockManagerInterface;
use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\Routing\AdminContext;

/**
 * Hook-Implementierungen für ldt_musterhinweis.
 */
class MusterhinweisHooks {

  public function __construct(
    protected BlockManagerInterface $blockManager,
    protected AdminContext $adminContext,
  ) {}

  /**
   * Implements hook_theme().
   */
  #[Hook('theme')]
  public function theme(): array {
    return [
      'ldt_musterhinweis' => [
        'variables' => [],
      ],
    ];
  }

  /**
   * Implements hook_page_top().
   *
   * page_top wird in jedem Theme direkt nach dem Skip-Link ausgegeben,
   * also vor dem Kopfbereich. Im Verwaltungsbereich entfällt der Hinweis.
   */
  #[Hook('page_top')]
  public function pageTop(array &$page_top): void {
    $page_top['#cache']['contexts'][] = 'route';
    if ($this->adminContext->isAdminRoute()) {
      return;
    }
    $page_top['ldt_musterhinweis'] = $this->blockManager
      ->createInstance('ldt_musterhinweis')
      ->build();
    $page_top['ldt_musterhinweis']['#weight'] = -1000;
  }

}
