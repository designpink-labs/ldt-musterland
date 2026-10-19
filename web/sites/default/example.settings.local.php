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
  // Von Drupal empfohlen (Statusbericht „Transaktions-Isolationsebene“):
  // weniger Sperren und Deadlocks als REPEATABLE READ.
  'init_commands' => [
    'isolation_level' => 'SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED',
  ],
];

// Geheimer Schlüssel: einmalig eine lange Zufallszeichenkette erzeugen,
// z. B. lokal mit: ddev drush php:eval "echo \Drupal\Component\Utility\Crypt::randomBytesBase64(55);"
$settings['hash_salt'] = 'HIER_EINE_LANGE_ZUFALLSZEICHENKETTE';

// Ordner außerhalb der Domain (Aufteilung auf dem Webspace, siehe STRATO-UPLOAD.md):
//   /designpink/drupal/   = Inhalt von web/ (DRUPAL_ROOT)
//   /drupal-projekt/      = vendor/, config/sync/, private/
// Relative Pfade gelten ab DRUPAL_ROOT.
$settings['config_sync_directory'] = '../../drupal-projekt/config/sync';
$settings['file_private_path'] = '../../drupal-projekt/private';

// Nur diese Hostnamen dürfen die Seite ausliefern (Schutz vor Host-Header-Angriffen).
$settings['trusted_host_patterns'] = [
  '^designpink\.de$',
  '^www\.designpink\.de$',
];

// Auf dem Live-Server keine Fehlermeldungen anzeigen.
$config['system.logging']['error_level'] = 'hide';

// E-Mail-Hinweise auf Sicherheits-Updates: echte Adresse nur hier eintragen
// (im Repository steht der Platzhalter updates@ldt-musterland.example).
$config['update.settings']['notification']['emails'] = ['IHRE-ADRESSE@example.org'];

// Matomo-Webanalyse nur live aktivieren (lokal bleibt sie leer und inaktiv).
// Werte aus der eigenen Matomo-Installation eintragen.
// $config['matomo.settings']['site_id'] = 'SITE_ID';
// $config['matomo.settings']['url_http'] = 'http://MATOMO-ADRESSE/';
// $config['matomo.settings']['url_https'] = 'https://MATOMO-ADRESSE/';

// ============================================================================
// MUSTERSEITEN-SCHUTZ (live) – vor dem Hochladen prüfen!
// Lokal gibt es keine settings.local.php, daher ist hier lokal nichts aktiv.
// ============================================================================

// 1. Suchmaschinen: alle Seiten mit <meta name="robots" content="noindex, nofollow">.
//    Prüfen: Seitenquelltext oder
//    drush cget metatag.metatag_defaults.global tags --include-overridden
$config['metatag.metatag_defaults.global']['tags']['robots'] = 'noindex, nofollow';

// 2. Formular "Barriere melden" im Demo-Modus:
//    nichts speichern, nichts versenden, nur Bestätigung anzeigen.
//    Über dem Formular erscheint dann automatisch ein Demo-Hinweis
//    (Modul ldt_musterhinweis).
$config['webform.webform.barriere_melden']['settings']['results_disabled'] = TRUE;
$config['webform.webform.barriere_melden']['settings']['results_disabled_ignore'] = TRUE;
$config['webform.webform.barriere_melden']['handlers']['benachrichtigung']['status'] = FALSE;
$config['webform.webform.barriere_melden']['settings']['confirmation_message'] = '<p><strong>Demo-Modus:</strong> Vielen Dank! Dies ist eine Musterseite. Ihre Meldung wurde nicht gespeichert und nicht versendet.</p>';

// 3. Passwortschutz: in designpink/drupal/.htaccess (AuthUserFile) und
//    drupal-projekt/.htpasswd – siehe STRATO-UPLOAD.md, Schritt 5.
