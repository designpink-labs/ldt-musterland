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
 * Welche Seite zu welchem Schlüssel gehört, merkt sich das Skript im
 * State-Eintrag "ldt.page_nids".
 */

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\node\Entity\Node;

$overwrite = in_array('--overwrite', $extra ?? [], TRUE);
$pages = require __DIR__ . '/pages.php';
$state = \Drupal::state();
$map = $state->get('ldt.page_nids', []);
$link_storage = \Drupal::entityTypeManager()->getStorage('menu_link_content');

// 1. Seiten anlegen oder aktualisieren.
$nodes = [];
$changed = [];
foreach ($pages as $key => $page) {
  $node = isset($map[$key]) ? Node::load($map[$key]) : NULL;
  if ($node && !$overwrite) {
    $nodes[$key] = $node;
    continue;
  }
  $node ??= Node::create(['type' => 'page', 'langcode' => 'de', 'uid' => 1, 'status' => 1]);
  $node->setTitle($page['title']);
  $node->set('body', ['value' => trim($page['body']), 'format' => 'basic_html']);
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
foreach (array_keys($changed) as $key) {
  $node = $nodes[$key];
  $body = preg_replace_callback('/\{\{link:([a-z0-9-]+)\|([^}]+)\}\}/', function ($m) use ($nodes) {
    $target = $nodes[$m[1]];
    return sprintf(
      '<a href="/node/%d" data-entity-type="node" data-entity-uuid="%s" data-entity-substitution="canonical">%s</a>',
      $target->id(), $target->uuid(), $m[2]
    );
  }, $node->get('body')->value);
  $node->set('body', ['value' => $body, 'format' => 'basic_html']);
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
