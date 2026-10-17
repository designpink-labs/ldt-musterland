<?php

/**
 * @file
 * Legt die Seiten aus scripts/pages.php samt Menüpunkten an.
 *
 * Anlegen (vorhandene Seiten bleiben unverändert):
 *   ddev drush php:script scripts/create-content.php
 *
 * Vorhandene Seiten mit den Texten aus pages.php ÜBERSCHREIBEN
 * (Achtung: im Backend geänderte Texte gehen verloren):
 *   ddev drush php:script scripts/create-content.php -- --overwrite
 *
 * Nur bestimmte Seiten überschreiben (Schlüssel aus pages.php):
 *   ddev drush php:script scripts/create-content.php -- --overwrite --only=video,schulungen
 *
 * Zusammenfassung (Kartentext) = 'summary'; Meta-Beschreibung = 'meta' (kurze
 * Fassung, falls der Teaser zu lang ist) oder 'summary', jeweils plus
 * " – Musterseite einer fiktiven Behörde"; 'description' ersetzt das ganz.
 * Höchstens 160 Zeichen inklusive Zusatz (Test: tests/a11y/meta.mjs).
 *
 * Marken in Texten: {{link:SCHLÜSSEL|Text}} (Seite), {{form:WEBFORM_ID|Text}}
 * (Webformular) – beide werden zu Linkit-Links (pfadunabhängig).
 * {{file:DATEINAME|Text}} wird zum Download-Link mit "(FORMAT, N KB)",
 * {{img:DATEINAME|Alternativtext}} zum Bild – beide für Dateien aus
 * sites/default/files/dokumente/ (nicht im Git-Repository).
 *
 * Welche Seite zu welchem Schlüssel gehört, merkt sich das Skript im
 * State-Eintrag "ldt.page_nids".
 *
 * Video (optional): 'video' => 'videos/NAME.mp4', 'untertitel' =>
 * 'untertitel/NAME.vtt' (Dateien unter sites/default/files/, nicht im Git),
 * 'unter_video' => HTML für das Feld "Text unter dem Video" (mit Marken).
 */

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\node\Entity\Node;

require_once __DIR__ . '/marken.php';

$overwrite = in_array('--overwrite', $extra ?? [], TRUE);
$only = [];
foreach ($extra ?? [] as $arg) {
  if (str_starts_with($arg, '--only=')) {
    $only = array_filter(explode(',', substr($arg, 7)));
  }
}
const LDT_META_SUFFIX = ' – Musterseite einer fiktiven Behörde';
$pages = require __DIR__ . '/pages.php';
$state = \Drupal::state();
$map = $state->get('ldt.page_nids', []);
$link_storage = \Drupal::entityTypeManager()->getStorage('menu_link_content');

// 1. Seiten anlegen oder aktualisieren.
$nodes = [];
$changed = [];
foreach ($pages as $key => $page) {
  $node = isset($map[$key]) ? Node::load($map[$key]) : NULL;
  if ($node && (!$overwrite || ($only && !in_array($key, $only, TRUE)))) {
    $nodes[$key] = $node;
    continue;
  }
  $node ??= Node::create(['type' => 'page', 'langcode' => 'de', 'uid' => 1, 'status' => 1]);
  $node->setTitle($page['title']);
  $node->set('body', [
    'value' => trim($page['body']),
    'summary' => $page['summary'] ?? '',
    'format' => 'basic_html',
  ]);
  $node->set('promote', !empty($page['promote']));
  foreach (['video' => 'field_video', 'untertitel' => 'field_untertitel'] as $schluessel => $feld) {
    $node->set($feld, !empty($page[$schluessel]) ? ['target_id' => ldt_dokument($page[$schluessel])->id(), 'display' => 1] : NULL);
  }
  $node->set('field_text_unter_video', !empty($page['unter_video']) ? ['value' => trim($page['unter_video']), 'format' => 'basic_html'] : NULL);
  $kurz = $page['meta'] ?? $page['summary'] ?? NULL;
  $description = $page['description'] ?? ($kurz ? $kurz . LDT_META_SUFFIX : '');
  if ($description && $node->hasField('field_metatag')) {
    $node->set('field_metatag', json_encode(['description' => $description]));
  }
  $node->save();
  $nodes[$key] = $node;
  $changed[$key] = TRUE;
  $map[$key] = (int) $node->id();
}
$state->set('ldt.page_nids', $map);

// 2. Menüpunkte anlegen oder aktualisieren.
$links = [];
foreach ($pages as $key => $page) {
  if (empty($page['menu'])) {
    continue;
  }
  $existing = $link_storage->loadByProperties(['link.uri' => 'entity:node/' . $nodes[$key]->id()]);
  $link = $existing ? reset($existing) : MenuLinkContent::create(['langcode' => 'de', 'expanded' => TRUE]);
  if (!$link->isNew() && empty($changed[$key])) {
    $links[$key] = $link;
    continue;
  }
  $link->set('title', $page['title']);
  $link->set('link', ['uri' => 'entity:node/' . $nodes[$key]->id()]);
  $link->set('menu_name', $page['menu']);
  $link->set('parent', !empty($page['parent']) ? $links[$page['parent']]->getPluginId() : '');
  $link->set('weight', $page['weight']);
  $link->save();
  $links[$key] = $link;
}

// Menüpunkt "Start" zeigt auf die Startseite (/), nicht auf /start.
if (!$link_storage->loadByProperties(['link.uri' => 'internal:/', 'menu_name' => 'main'])) {
  MenuLinkContent::create([
    'title' => 'Start',
    'link' => ['uri' => 'internal:/'],
    'menu_name' => 'main',
    'weight' => 0,
    'langcode' => 'de',
  ])->save();
}

// 3. {{link:SCHLÜSSEL|Text}} in Linkit-Links umwandeln und Aliase erzeugen.
// Linkziele: Seiten (SCHLÜSSEL) und Meldungen (meldung/SCHLÜSSEL).
$ziele = $nodes;
foreach ($state->get('ldt.meldung_nids', []) as $mkey => $nid) {
  $ziele['meldung/' . $mkey] = Node::load($nid);
}
foreach (array_keys($changed) as $key) {
  $node = $nodes[$key];
  $body = ldt_marken($node->get('body')->value, $ziele);
  $node->set('body', ['value' => $body, 'summary' => $node->get('body')->summary, 'format' => 'basic_html']);
  if (!$node->get('field_text_unter_video')->isEmpty()) {
    $node->set('field_text_unter_video', ['value' => ldt_marken($node->get('field_text_unter_video')->value, $ziele), 'format' => 'basic_html']);
  }
  $node->path->pathauto = 1;
  $node->save();
}

// Seite "Start" als Startseite der Website.
\Drupal::configFactory()->getEditable('system.site')
  ->set('page.front', '/node/' . $nodes['start']->id())
  ->save();


foreach ($nodes as $key => $node) {
  echo (isset($changed[$key]) ? '* ' : '  ') . $node->id() . "\t" . $node->toUrl()->toString() . "\t" . $node->label() . "\n";
}
echo "(* = angelegt oder aktualisiert)\n";
