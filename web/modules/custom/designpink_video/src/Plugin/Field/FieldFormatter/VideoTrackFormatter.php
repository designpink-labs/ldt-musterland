<?php

declare(strict_types=1);

namespace Drupal\designpink_video\Plugin\Field\FieldFormatter;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\ByteSizeMarkup;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\file\FileInterface;
use Drupal\file\Plugin\Field\FieldFormatter\FileFormatterBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Gibt eine Videodatei als <video> mit Untertitel-<track> aus.
 *
 * Die WebVTT-Datei wird aus einem zweiten Dateifeld derselben Entität gelesen.
 */
#[FieldFormatter(
  id: 'designpink_video_track',
  label: new TranslatableMarkup('Video mit Untertiteln'),
  field_types: ['file'],
)]
class VideoTrackFormatter extends FileFormatterBase {

  protected FileUrlGeneratorInterface $fileUrlGenerator;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->fileUrlGenerator = $container->get('file_url_generator');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings(): array {
    return [
      'track_field' => 'field_untertitel',
      'track_label' => 'Deutsch',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state): array {
    $form['track_field'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Maschinenname des Untertitel-Feldes'),
      '#default_value' => $this->getSetting('track_field'),
      '#required' => TRUE,
    ];
    $form['track_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Bezeichnung der Untertitel im Player'),
      '#default_value' => $this->getSetting('track_label'),
      '#required' => TRUE,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary(): array {
    return [
      $this->t('Untertitel aus: @field (@label)', [
        '@field' => $this->getSetting('track_field'),
        '@label' => $this->getSetting('track_label'),
      ]),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $entity = $items->getEntity();
    $cache = new CacheableMetadata();

    $track_url = NULL;
    $track_field = $this->getSetting('track_field');
    if ($entity->hasField($track_field)) {
      $track_file = $entity->get($track_field)->entity;
      if ($track_file instanceof FileInterface && $track_file->access('view')) {
        $track_url = $this->fileUrlGenerator->generateString($track_file->getFileUri());
        $cache->addCacheableDependency($track_file);
      }
    }

    $elements = [];
    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $file) {
      $elements[$delta] = [
        '#theme' => 'designpink_video',
        '#video_url' => $this->fileUrlGenerator->generateString($file->getFileUri()),
        '#video_mime' => $file->getMimeType(),
        '#video_size' => ByteSizeMarkup::create((int) $file->getSize()),
        '#track_url' => $track_url,
        '#track_srclang' => $entity->language()->getId(),
        '#track_label' => $this->getSetting('track_label'),
      ];
      $cache->addCacheableDependency($file)->applyTo($elements[$delta]);
    }
    return $elements;
  }

}
