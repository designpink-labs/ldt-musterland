<?php

/**
 * @file
 * Legt die Meldungen aus scripts/meldungen.php an (Inhaltstyp "meldung")
 * und den Menüpunkt "Aktuelles" (/aktuelles) in der Hauptnavigation.
 *
 *   ddev drush php:script scripts/create-meldungen.php
 *   ddev drush php:script scripts/create-meldungen.php -- --overwrite
 *
 * Ohne --overwrite bleiben vorhandene Meldungen unverändert. Welche Meldung
 * zu welchem Schlüssel gehört, steht im State-Eintrag "ldt.meldung_nids".
 * Voraussetzung: Seiten aus create-content.php (für {{link:…}}).
 */

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\node\Entity\Node;

require_once __DIR__ . '/marken.php';

$overwrite = in_array('--overwrite', $extra ?? [], TRUE);
$meldungen = require __DIR__ . '/meldungen.php';
$state = \Drupal::state();
$map = $state->get('ldt.meldung_nids', []);
$pages = Node::loadMultiple($state->get('ldt.page_nids', []));
$pages_by_key = [];
foreach ($state->get('ldt.page_nids', []) as $key => $nid) {
  $pages_by_key[$key] = $pages[$nid];
}

foreach ($meldungen as $key => $m) {
  $node = isset($map[$key]) ? Node::load($map[$key]) : NULL;
  if ($node && !$overwrite) {
    echo "  {$node->id()}\t{$node->toUrl()->toString()}\n";
    continue;
  }
  $node ??= Node::create(['type' => 'meldung', 'langcode' => 'de', 'uid' => 1, 'status' => 1]);
  $node->setTitle($m['title']);
  $node->set('field_datum', $m['datum']);
  // Erstellungsdatum = Veröffentlichungsdatum (12 Uhr), z. B. für die Sitemap.
  $node->setCreatedTime((new \DateTime($m['datum'] . ' 12:00', new \DateTimeZone('Europe/Berlin')))->getTimestamp());
  $node->set('body', [
    'value' => ldt_marken(trim($m['body']), $pages_by_key),
    'summary' => $m['teaser'],
    'format' => 'basic_html',
  ]);
  $node->set('field_quellen', array_map(fn($q) => [
    'uri' => $q[0],
    'title' => $q[1],
    'options' => $q[2] !== 'de' ? ['attributes' => ['lang' => $q[2], 'hreflang' => $q[2]]] : [],
  ], $m['quellen']));
  $node->set('field_metatag', json_encode(['description' => $m['teaser'] . ' – Musterseite einer fiktiven Behörde']));
  $node->path->pathauto = 1;
  $node->save();
  $map[$key] = (int) $node->id();
  echo "* {$node->id()}\t{$node->toUrl()->toString()}\n";
}
$state->set('ldt.meldung_nids', $map);

// Menüpunkt "Aktuelles" vor "Über uns / Kontakt" (Gewicht 6 in pages.php).
$storage = \Drupal::entityTypeManager()->getStorage('menu_link_content');
if (!$storage->loadByProperties(['link.uri' => 'internal:/aktuelles', 'menu_name' => 'main'])) {
  MenuLinkContent::create([
    'title' => 'Aktuelles',
    'link' => ['uri' => 'internal:/aktuelles'],
    'menu_name' => 'main',
    'weight' => 5,
    'langcode' => 'de',
  ])->save();
  echo "Menüpunkt „Aktuelles“ angelegt.\n";
}
