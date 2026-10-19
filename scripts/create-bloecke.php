<?php

/**
 * @file
 * Legt die Inhaltsblöcke aus scripts/bloecke.php an und platziert sie.
 *
 * Anlegen (vorhandene Blöcke bleiben unverändert):
 *   ddev drush php:script scripts/create-bloecke.php
 *
 * Vorhandene Blöcke mit den Werten aus bloecke.php ÜBERSCHREIBEN
 * (im Backend geänderte Angaben gehen verloren):
 *   ddev drush php:script scripts/create-bloecke.php -- --overwrite
 */

use Drupal\block\Entity\Block;
use Drupal\block_content\Entity\BlockContent;

$overwrite = in_array('--overwrite', $extra ?? [], TRUE);
$bloecke = require __DIR__ . '/bloecke.php';
$storage = \Drupal::entityTypeManager()->getStorage('block_content');

foreach ($bloecke as $key => $daten) {
  $vorhanden = $storage->loadByProperties(['uuid' => $daten['uuid']]);
  $block = $vorhanden ? reset($vorhanden) : NULL;
  if ($block && !$overwrite) {
    echo "  $key\t(vorhanden)\n";
  }
  else {
    $block ??= BlockContent::create(['type' => $daten['typ'], 'uuid' => $daten['uuid'], 'langcode' => 'de']);
    $block->set('info', $daten['info']);
    foreach ($daten['felder'] as $feld => $wert) {
      $block->set($feld, $wert);
    }
    $block->save();
    echo "* $key\t" . $block->id() . "\n";
  }

  // Platzierung (steht auch in config/sync; hier für eine frische Installation).
  if (!empty($daten['block_id']) && !Block::load($daten['block_id'])) {
    Block::create([
      'id' => $daten['block_id'],
      'theme' => 'ldt_musterland',
      'region' => $daten['region'],
      'plugin' => 'block_content:' . $daten['uuid'],
      'settings' => ['label' => $daten['info'], 'label_display' => '0', 'provider' => 'block_content'],
      'visibility' => [],
      'weight' => 0,
    ])->save();
  }
}
echo "(* = angelegt oder aktualisiert)\n";
