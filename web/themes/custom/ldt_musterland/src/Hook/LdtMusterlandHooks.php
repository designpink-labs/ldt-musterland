<?php

namespace Drupal\ldt_musterland\Hook;

use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Drupal\ldt_musterland\BildVarianten;
use Drupal\ldt_musterland\InterneLinks;
use Drupal\ldt_musterland\TabellenRahmen;

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

    // Seitenfuß: "Barriere melden" übergibt die aktuelle Seite (?seite=…),
    // das Formular füllt damit das Feld "Betroffene Seite" vor
    // (ldt_formulare). Auf der Formularseite selbst kein Parameter.
    if (($variables['menu_name'] ?? '') === 'footer') {
      $route = \Drupal::routeMatch();
      $auf_formular = $route->getRouteName() === 'entity.webform.canonical'
        && $route->getRawParameter('webform') === 'barriere_melden';
      foreach ($variables['items'] as &$item) {
        $url = $item['url'] ?? NULL;
        if (!$auf_formular && $url instanceof Url && $url->isRouted()
          && $url->getRouteName() === 'entity.webform.canonical'
          && ($url->getRouteParameters()['webform'] ?? '') === 'barriere_melden') {
          $item['url'] = (clone $url)->setOption('query', ['seite' => $this->currentPath(TRUE)]);
        }
      }
    }
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
   * Implements hook_preprocess_field().
   *
   * Tabellen in formatierten Textfeldern bekommen einen scrollbaren Rahmen.
   */
  #[Hook('preprocess_field')]
  public function preprocessField(array &$variables): void {
    if (($variables['field_name'] ?? '') === 'field_kopfbild') {
      $this->kopfbild($variables);
      return;
    }
    if (!in_array($variables['field_type'] ?? '', ['text_with_summary', 'text_long', 'text'], TRUE)) {
      return;
    }
    foreach ($variables['items'] as &$item) {
      $item['content']['#post_render'][] = [TabellenRahmen::class, 'postRender'];
      $item['content']['#post_render'][] = [InterneLinks::class, 'postRender'];
      $item['content']['#post_render'][] = [BildVarianten::class, 'postRender'];
    }
  }

  /**
   * Kopfbild als WebP in drei Größen (srcset/sizes), Ausschnitt per CSS.
   *
   * Startseite (Einstieg): sofort laden, hohe Priorität. Sonst lazy.
   * Alternativtext aus dem Feld; leer = Stimmungsbild (alt="").
   */
  protected function kopfbild(array &$variables): void {
    $start = \Drupal::service('path.matcher')->isFrontPage();
    foreach ($variables['items'] as &$item) {
      $feld = $item['content']['#item'] ?? NULL;
      $datei = $feld?->entity;
      if (!$datei) {
        continue;
      }
      $sizes = $start ? '(min-width: 64em) 36rem, calc(100vw - 2rem)' : '(min-width: 75rem) 72rem, calc(100vw - 2rem)';
      $attr = BildVarianten::attribute($datei->getFileUri(), $sizes) + [
        'alt' => (string) $feld->alt,
        'class' => ['kopfbild__img'],
      ];
      $attr += $start ? ['fetchpriority' => 'high', 'decoding' => 'async'] : ['loading' => 'lazy', 'decoding' => 'async'];
      $item['content'] = [
        '#type' => 'html_tag',
        '#tag' => 'img',
        '#attributes' => $attr,
        '#cache' => ['tags' => $datei->getCacheTags(), 'contexts' => ['url.path.is_front']],
      ];
    }
  }

  /**
   * Implements hook_preprocess_page().
   *
   * Startseite mit Leitsatz: Die H1 steht im Einstieg (node--page--full),
   * der Block "Seitentitel" entfällt dort. Der <title> bleibt "Start".
   */
  #[Hook('preprocess_page')]
  public function preprocessPage(array &$variables): void {
    $node = $variables['node'] ?? NULL;
    if ($node instanceof NodeInterface && $node->hasField('field_leitsatz') && !$node->get('field_leitsatz')->isEmpty()) {
      unset($variables['page']['content_above']['ldt_musterland_seitentitel']);
    }
  }

  /**
   * Implements hook_preprocess_block().
   *
   * Startseite: "Unsere Themen" als hellgrauer Abschnitt (Seitenrhythmus).
   */
  #[Hook('preprocess_block')]
  public function preprocessBlock(array &$variables): void {
    if (($variables['elements']['#id'] ?? '') === 'ldt_musterland_startseite_themen') {
      $variables['attributes']['class'][] = 'abschnitt';
      $variables['attributes']['class'][] = 'abschnitt--grau';
    }
  }

  /**
   * Implements hook_preprocess_node().
   *
   * Meldungen: Datum (für <time>) und Quellen für die Templates
   * node--meldung*.html.twig.
   */
  #[Hook('preprocess_node')]
  public function preprocessNode(array &$variables): void {
    $node = $variables['node'];
    if ($node->bundle() === 'page') {
      $this->preprocessSeite($variables);
      return;
    }
    if ($node->bundle() !== 'meldung') {
      return;
    }
    $datum = $node->get('field_datum')->first();
    if ($datum && $datum->date) {
      $variables['datum'] = [
        'iso' => $datum->value,
        'text' => \Drupal::service('date.formatter')->format($datum->date->getTimestamp(), 'ldt_datum'),
      ];
    }
    $variables['quellen'] = [];
    foreach ($node->get('field_quellen') as $item) {
      $variables['quellen'][] = [
        'url' => $item->getUrl()->toString(),
        'title' => $item->title,
        'lang' => $item->options['attributes']['lang'] ?? NULL,
      ];
    }
  }

  /**
   * Basisseiten: Leitsatz/Einleitung (Einstieg), Kopfbild, Kartensymbol.
   */
  protected function preprocessSeite(array &$variables): void {
    $node = $variables['node'];
    if ($node->hasField('field_leitsatz') && !$node->get('field_leitsatz')->isEmpty()) {
      $variables['leitsatz'] = $node->get('field_leitsatz')->value;
      $variables['einleitung'] = $node->get('body')->summary;
    }
    $variables['hat_kopfbild'] = $node->hasField('field_kopfbild') && !$node->get('field_kopfbild')->isEmpty();
    // Themenkarten (Teaser): Linien-Symbol je Übersichtsseite.
    if ($variables['view_mode'] === 'teaser') {
      $symbole = [
        '/barrierefreiheit' => 'barrierefreiheit',
        '/online-redaktion' => 'redaktion',
        '/web-optimierung' => 'web',
        '/schulungen' => 'schulung',
      ];
      $pfad = \Drupal::service('path_alias.manager')->getAliasByPath('/node/' . $node->id());
      $variables['symbol'] = $symbole[$pfad] ?? NULL;
    }
  }

  /**
   * Gibt die aktuelle Adresse so zurück, wie Menülinks sie erzeugen.
   */
  protected function currentPath(bool $absolute = FALSE): string {
    if (\Drupal::service('path.matcher')->isFrontPage()) {
      return Url::fromRoute('<front>', [], ['absolute' => $absolute])->toString();
    }
    return Url::fromRoute('<current>', [], ['absolute' => $absolute])->toString();
  }

}
