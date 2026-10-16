<?php

declare(strict_types=1);

namespace Drupal\ldt_musterhinweis\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Hinweis-Balken: Musterseite, keine echte Behörde.
 */
#[Block(
  id: 'ldt_musterhinweis',
  admin_label: new TranslatableMarkup('Musterseiten-Hinweis'),
)]
class MusterhinweisBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return [
      '#theme' => 'ldt_musterhinweis',
      '#attached' => ['library' => ['ldt_musterhinweis/musterhinweis']],
    ];
  }

}
