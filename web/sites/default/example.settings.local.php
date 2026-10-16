<?php

/**
 * @file
 * Vorlage für die Live-Einstellungen auf dem Strato-Webspace.
 *
 * NUR AUF DEM SERVER verwenden:
 * 1. Datei auf dem Server nach "settings.local.php" (gleicher Ordner) kopieren.
 * 2. Platzhalter durch die echten Werte ersetzen.
 * 3. Die echte settings.local.php niemals ins Git-Repository legen
 *    (sie steht in .gitignore).
 *
 * Lokal unter DDEV wird diese Datei nicht benötigt.
 */

// Datenbank-Zugangsdaten aus dem Strato-Kundenbereich (Datenbankverwaltung).
$databases['default']['default'] = [
  'database' => 'DATENBANKNAME',
  'username' => 'DATENBANKBENUTZER',
  'password' => 'DATENBANKPASSWORT',
  'host' => 'DATENBANKHOST',
  'port' => '3306',
  'driver' => 'mysql',
  'prefix' => '',
  'collation' => 'utf8mb4_general_ci',
];

// Geheimer Schlüssel: einmalig eine lange Zufallszeichenkette erzeugen,
// z. B. lokal mit: ddev drush php:eval "echo \Drupal\Component\Utility\Crypt::randomBytesBase64(55);"
$settings['hash_salt'] = 'HIER_EINE_LANGE_ZUFALLSZEICHENKETTE';

// Nur diese Hostnamen dürfen die Seite ausliefern (Schutz vor Host-Header-Angriffen).
$settings['trusted_host_patterns'] = [
  '^designpink\.de$',
  '^www\.designpink\.de$',
];

// Auf dem Live-Server keine Fehlermeldungen anzeigen.
$config['system.logging']['error_level'] = 'hide';

// Matomo-Webanalyse nur live aktivieren (lokal bleibt sie leer und inaktiv).
// Werte aus der eigenen Matomo-Installation eintragen.
// $config['matomo.settings']['site_id'] = 'SITE_ID';
// $config['matomo.settings']['url_http'] = 'http://MATOMO-ADRESSE/';
// $config['matomo.settings']['url_https'] = 'https://MATOMO-ADRESSE/';
