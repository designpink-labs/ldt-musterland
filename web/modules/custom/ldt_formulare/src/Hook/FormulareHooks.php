<?php

declare(strict_types=1);

namespace Drupal\ldt_formulare\Hook;

use Drupal\Core\Hook\Attribute\Hook;

/**
 * Verknüpft Fehlermeldungen am Feld mit dem Feld (aria-describedby).
 *
 * Drupal setzt bei fehlerhaften Feldern aria-invalid="true", verknüpft die
 * Fehlermeldung aber nicht. Screenreader lesen beim Fokus auf das Feld so
 * nur "ungültig" vor, nicht den Grund. Diese Hooks geben der Meldung eine ID
 * ("<feld-id>--error") und hängen sie an aria-describedby des Feldes an.
 */
class FormulareHooks {

  /**
   * Implements hook_preprocess_HOOK() for form_element.
   */
  #[Hook('preprocess_form_element')]
  public function preprocessFormElement(array &$variables): void {
    $id = $variables['element']['#id'] ?? NULL;
    if (!$id || empty($variables['errors'])) {
      return;
    }
    $errors = $variables['errors'];
    $variables['errors'] = [
      '#type' => 'html_tag',
      '#tag' => 'span',
      '#attributes' => ['id' => $id . '--error'],
      'message' => is_array($errors) ? $errors : ['#markup' => $errors],
    ];
  }

  /**
   * Implements hook_preprocess_HOOK() for fieldset.
   *
   * Feldgruppen (Radio-Knöpfe, Checkboxen): Die Fehlermeldung bekommt eine
   * ID und wird an aria-describedby des <fieldset> gehängt. Screenreader
   * lesen sie beim Betreten der Gruppe zusammen mit der Legende vor.
   */
  #[Hook('preprocess_fieldset')]
  public function preprocessFieldset(array &$variables): void {
    $id = $variables['element']['#id'] ?? NULL;
    if (!$id || empty($variables['errors'])) {
      return;
    }
    $errors = $variables['errors'];
    $variables['errors'] = [
      '#type' => 'html_tag',
      '#tag' => 'span',
      '#attributes' => ['id' => $id . '--error'],
      'message' => is_array($errors) ? $errors : ['#markup' => $errors],
    ];
    $described = (string) ($variables['attributes']['aria-describedby'] ?? '');
    $ids = array_filter(array_merge([$id . '--error'], explode(' ', $described)));
    $variables['attributes']['aria-describedby'] = implode(' ', array_unique($ids));
  }

  /**
   * Implements hook_form_alter().
   *
   * Links in der Fehlerliste setzen den Fokus auch bei Feldgruppen ins
   * erste Eingabefeld (js/fehlerliste.js).
   */
  #[Hook('form_alter')]
  public function formAlter(array &$form): void {
    $form['#attached']['library'][] = 'ldt_formulare/fehlerliste';
  }

  /**
   * Implements hook_preprocess_HOOK() for input.
   */
  #[Hook('preprocess_input')]
  public function preprocessInput(array &$variables): void {
    $this->addErrorReference($variables);
  }

  /**
   * Implements hook_preprocess_HOOK() for textarea.
   */
  #[Hook('preprocess_textarea')]
  public function preprocessTextarea(array &$variables): void {
    $this->addErrorReference($variables);
  }

  /**
   * Implements hook_preprocess_HOOK() for select.
   */
  #[Hook('preprocess_select')]
  public function preprocessSelect(array &$variables): void {
    $this->addErrorReference($variables);
  }

  /**
   * Hängt die ID der Fehlermeldung an aria-describedby an.
   */
  protected function addErrorReference(array &$variables): void {
    $element = $variables['element'] ?? [];
    if (empty($element['#errors']) || empty($element['#id']) || !empty($element['#error_no_message'])) {
      return;
    }
    $error_id = $element['#id'] . '--error';
    $described = (string) ($variables['attributes']['aria-describedby'] ?? '');
    $ids = array_filter(array_merge([$error_id], explode(' ', $described)));
    $variables['attributes']['aria-describedby'] = implode(' ', array_unique($ids));
  }

}
