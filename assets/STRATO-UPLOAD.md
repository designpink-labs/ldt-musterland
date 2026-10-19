# Strato-Upload: LDT Musterland

Dieser Ordner wurde mit `scripts/strato-build.sh` erzeugt. Er enthält **keine Zugangsdaten**.
Alles, was Sie eintragen müssen, steht hier als Platzhalter in GROSSBUCHSTABEN.

```
strato-upload/
├── designpink/            → per SFTP nach /designpink/          (Domain designpink.de, „Intern“)
│   ├── index.html             Platzhalter für designpink.de
│   └── drupal/                Drupal (Inhalt von web/)  → https://designpink.de/drupal
├── drupal-projekt/        → per SFTP nach /drupal-projekt/      (außerhalb der Domain)
│   ├── vendor/  config/sync/  private/  composer.json  composer.lock
├── ldt.sql                → NICHT hochladen, nur über phpMyAdmin importieren
└── STRATO-UPLOAD.md       → NICHT hochladen
```

## 1. Vorbereitung im Strato-Kundenbereich

1. Domain `designpink.de` zeigt per „Intern“ auf den Ordner `/designpink`.
2. PHP-Version für die Domain auf **8.3** stellen.
3. Eine **MySQL/MariaDB-Datenbank** anlegen. Datenbankname, Benutzer, Passwort und
   Hostname notieren – nur im Passwortmanager, nicht in Dateien des Repositorys.

## 2. Dateien per SFTP hochladen

Im SFTP-Programm **versteckte Dateien anzeigen** (die `.htaccess`-Dateien müssen mit).

| Lokal | Ziel auf dem Webspace |
|---|---|
| `strato-upload/designpink/` (Inhalt) | `/designpink/` |
| `strato-upload/drupal-projekt/` (Inhalt) | `/drupal-projekt/` |

`vendor/` hat viele tausend Dateien; der Upload dauert. Vorhandene Dateien in `/designpink/`
vorher sichern, falls dort schon etwas liegt.

## 3. Datenbank importieren (phpMyAdmin)

1. Kundenbereich → Datenbanken → **phpMyAdmin** öffnen und links die neue Datenbank wählen.
2. Reiter **Importieren** → Datei `ldt.sql` wählen, Zeichensatz `utf-8` → **Importieren**.
3. Ist die Datei für das Upload-Limit zu groß: lokal `gzip -k ldt.sql` und `ldt.sql.gz`
   importieren (phpMyAdmin entpackt selbst).

## 4. settings.local.php anlegen

1. Lokal (nicht im Projektordner!) eine Kopie von
   `designpink/drupal/sites/default/example.settings.local.php` anlegen und in
   `settings.local.php` umbenennen.
2. Eintragen:
   - **Datenbank:** `DATENBANKNAME`, `DATENBANKBENUTZER`, `DATENBANKPASSWORT`,
     `DATENBANKHOST` aus dem Kundenbereich.
   - **hash_salt:** `HIER_EINE_LANGE_ZUFALLSZEICHENKETTE` durch eine **neue** Zeichenkette
     ersetzen, z. B. lokal erzeugt mit `openssl rand -base64 55`.
   - **trusted_host_patterns:** steht schon auf `designpink.de` und `www.designpink.de`.
   - **Update-E-Mail:** `IHRE-ADRESSE@example.org` durch die echte Adresse ersetzen.
   - `config_sync_directory` und `file_private_path` sind schon auf
     `../../drupal-projekt/…` gesetzt – nichts ändern.
   - Den Block **MUSTERSEITEN-SCHUTZ** unverändert lassen (noindex, Demo-Modus des Formulars).
3. Hochladen nach `/designpink/drupal/sites/default/settings.local.php`.

## 5. Passwortschutz (.htpasswd)

1. **Absoluten Serverpfad ermitteln:** eine Datei `pfad.php` mit dem Inhalt
   `<?php echo __DIR__;` nach `/designpink/` hochladen, `https://designpink.de/pfad.php`
   aufrufen und **die Datei sofort wieder löschen**. Angezeigt wird der Pfad zu
   `/designpink`; der Projektordner liegt daneben, also `…/drupal-projekt`.
2. **Zugang erzeugen** (lokal im Terminal, fragt das Passwort ab):
   `htpasswd -n -B BENUTZERNAME` – die ausgegebene Zeile in eine Datei `.htpasswd`
   schreiben und nach `/drupal-projekt/.htpasswd` hochladen.
3. In `/designpink/drupal/.htaccess` ganz oben den Platzhalter
   `/ABSOLUTER/PFAD/AUF/DEM/SERVER/drupal-projekt/.htpasswd` durch den echten Pfad ersetzen.
   Solange der Platzhalter dort steht, antwortet `/drupal` mit Fehler 500.

## 6. Dateirechte

Im SFTP-Programm (Dateiattribute) bzw. per SSH:

| Was | Rechte |
|---|---|
| Ordner | 755 |
| Dateien | 644 |
| `designpink/drupal/sites/default/settings.php` und `settings.local.php` | 444 |

Die Rechte 755/644 sind im Upload-Ordner schon gesetzt; manche SFTP-Programme übernehmen
sie nicht – dann nach dem Upload prüfen (Dateien mit 600 liefert der Server nicht aus).

## 7. Cache

`/drupal/update.php` ist **nicht** nötig (gleiche Code- und Datenbankversion wie lokal).
Die Caches wurden vor dem Export geleert; Drupal baut sie beim ersten Aufruf neu auf.
Falls die Seite danach fehlerhaft aussieht oder eine Fehlermeldung zeigt:

- **Ohne SSH:** in `settings.local.php` vorübergehend `$settings['rebuild_access'] = TRUE;`
  ergänzen (Datei dafür kurz auf 644), `https://designpink.de/drupal/core/rebuild.php`
  aufrufen, die Zeile **wieder entfernen** und die Datei zurück auf 444 setzen.
- **Mit SSH:**
  `cd drupal-projekt && vendor/bin/drush --root=../designpink/drupal --uri=https://designpink.de/drupal cr`

## 8. Nach dem Upload prüfen

- `https://designpink.de` zeigt „designpink.de – diese Seite befindet sich im Aufbau.“
- `https://designpink.de/drupal` fragt nach Benutzername und Passwort, danach erscheint die Startseite.
- **Passwort von „admin“ sofort ändern:** Die Datenbank enthält das lokale Konto mit dem
  lokalen Passwort (`/drupal/user/login`, dann *Konto bearbeiten*).
- Seitenquelltext enthält `<meta name="robots" content="noindex, nofollow" />`; die
  Antwort hat den Header `X-Robots-Tag: noindex, nofollow`.
- `/drupal/barriere-melden` zeigt den gelben Demo-Hinweis über dem Formular.
- Downloads, Fotos, Video und Untertitel laden (sonst Dateirechte prüfen).
- *Berichte → Statusbericht:* Dateisystem, privates Verzeichnis, Cron, „Vertrauenswürdige Hostnamen“.
