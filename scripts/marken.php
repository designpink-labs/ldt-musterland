<?php

/**
 * @file
 * Gemeinsame Hilfsfunktionen für create-content.php und create-meldungen.php.
 *
 * Marken im Text:
 * - {{link:SCHLÜSSEL|Text}}  Seite aus pages.php (Linkit, pfadunabhängig)
 * - {{link:meldung/SCHLÜSSEL|Text}}  Meldung aus meldungen.php
 * - {{form:WEBFORM_ID|Text}}  Webformular (Linkit)
 * - {{file:DATEINAME|Text}}   Download mit "(FORMAT, N KB)"
 * - {{img:DATEINAME|Alt}}     Bild; {{img:DATEINAME|Alt|400}} mit Anzeigebreite in px
 * Dateien liegen in sites/default/files/dokumente/ (nicht im Git-Repository).
 * Mit Unterordner (z. B. {{file:untertitel/NAME.vtt|Text}}) relativ zu
 * sites/default/files/.
 */

/**
 * Ersetzt alle Marken in $body.
 *
 * Datei- und Bildadressen werden ohne Versionskennung (?v=…) gespeichert:
 * Die hängt Drupal beim Ausgeben an (VersionierteDateiUrls); im gespeicherten
 * Text würde sie den Sicherheitsfilter für Bilder stören.
 *
 * @param string $body
 *   HTML mit Marken.
 * @param \Drupal\node\NodeInterface[] $nodes
 *   Seiten, nach Schlüssel aus pages.php.
 */
function ldt_marken(string $body, array $nodes): string {
  $body = preg_replace_callback('/\{\{link:([a-z0-9\/-]+)\|([^}]+)\}\}/', function ($m) use ($nodes) {
    $target = $nodes[$m[1]] ?? throw new \RuntimeException("Linkziel fehlt: {$m[1]} (Meldungen zuerst mit create-meldungen.php anlegen)");
    return sprintf(
      '<a href="/node/%d" data-entity-type="node" data-entity-uuid="%s" data-entity-substitution="canonical">%s</a>',
      $target->id(), $target->uuid(), $m[2]
    );
  }, $body);
  // {{form:WEBFORM_ID|Text}}: Link auf ein Webformular, ebenfalls im Linkit-Format.
  $body = preg_replace_callback('/\{\{form:([a-z0-9_]+)\|([^}]+)\}\}/', function ($m) {
    $webform = \Drupal\webform\Entity\Webform::load($m[1]);
    return sprintf(
      '<a href="/form/%s" data-entity-type="webform" data-entity-uuid="%s" data-entity-substitution="canonical">%s</a>',
      str_replace('_', '-', $webform->id()), $webform->uuid(), $m[2]
    );
  }, $body);
  // {{file:DATEINAME|Text}}: Download-Link; Format und Größe werden angehängt.
  $body = preg_replace_callback('/\{\{file:([A-Za-z0-9._\/-]+)\|([^}]+)\}\}/', function ($m) {
    $file = ldt_dokument($m[1]);
    $kb = max(1, (int) round($file->getSize() / 1024));
    return sprintf(
      '<a href="%s" data-entity-type="file" data-entity-uuid="%s" data-entity-substitution="file">%s (%s, %d KB)</a>',
      strtok($file->createFileUrl(), "?"), $file->uuid(), $m[2],
      strtoupper(pathinfo($m[1], PATHINFO_EXTENSION)), $kb
    );
  }, $body);
  // {{img:DATEINAME|Alternativtext}}: Bild; die Adresse setzt der Filter
  // editor_file_reference beim Ausgeben anhand der UUID.
  $body = preg_replace_callback('/\{\{img:([A-Za-z0-9._\/-]+)\|([^}|]+)(?:\|(\d+))?\}\}/', function ($m) {
    $file = ldt_dokument($m[1]);
    [$width, $height] = getimagesize($file->getFileUri());
    // Optionale Anzeigebreite: Höhe im Seitenverhältnis mitrechnen.
    if (!empty($m[3])) {
      $height = (int) round($height * $m[3] / $width);
      $width = (int) $m[3];
    }
    return sprintf(
      '<img src="%s" data-entity-type="file" data-entity-uuid="%s" alt="%s" width="%d" height="%d">',
      strtok($file->createFileUrl(), "?"), $file->uuid(), htmlspecialchars($m[2]), $width, $height
    );
  }, $body);
  return $body;
}

/**
 * Datei-Eintrag für public://dokumente/NAME laden oder anlegen.
 *
 * Die Datei selbst muss schon im Ordner sites/default/files/dokumente liegen
 * (sie ist nicht im Git-Repository, siehe README). Namen mit Unterordner
 * (videos/NAME.mp4, untertitel/NAME.vtt) gelten relativ zu
 * sites/default/files/.
 */
function ldt_dokument(string $name): \Drupal\file\FileInterface {
  $pfad = str_contains($name, '/') ? $name : 'dokumente/' . $name;
  $uri = 'public://' . $pfad;
  if (!file_exists($uri)) {
    throw new \RuntimeException("Datei fehlt: sites/default/files/$pfad");
  }
  $storage = \Drupal::entityTypeManager()->getStorage('file');
  $files = $storage->loadByProperties(['uri' => $uri]);
  $file = $files ? reset($files) : $storage->create(['uri' => $uri, 'uid' => 1]);
  $file->setPermanent();
  $file->setFilename(basename($name));
  $file->save();
  return $file;
}
