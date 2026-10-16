<?php

declare(strict_types=1);

namespace Drupal\ldt_musterhinweis\Hook;

use Drupal\Core\Block\BlockManagerInterface;
use Drupal\Core\Form\FormStateInterface;
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

  /**
   * Implements hook_webform_submission_form_alter().
   *
   * Demo-Modus: Speichert ein Webformular nichts und ist kein Handler aktiv
   * (live per settings.local.php), steht das vor dem Ausfüllen über dem
   * Formular. Der Hinweis folgt aus der tatsächlichen Einstellung.
   */
  #[Hook('webform_submission_form_alter')]
  public function webformSubmissionFormAlter(array &$form, FormStateInterface $form_state, string $form_id): void {
    $webform = $form_state->getFormObject()->getEntity()->getWebform();
    if (!$webform->getSetting('results_disabled')) {
      return;
    }
    foreach ($webform->getHandlers() as $handler) {
      if ($handler->isEnabled()) {
        return;
      }
    }
    $form['ldt_demo_hinweis'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#attributes' => [
        'class' => ['ldt-demo-hinweis'],
        'role' => 'note',
        'aria-label' => 'Hinweis zum Formular',
      ],
      'text' => [
        '#markup' => '<p><strong>Demo-Modus:</strong> Dies ist eine Musterseite. Meldungen über dieses Formular werden weder gespeichert noch versendet.</p>',
      ],
      '#weight' => -1000,
    ];
    $form['#attached']['library'][] = 'ldt_musterhinweis/musterhinweis';
  }

}
