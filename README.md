# designpink – Drupal 11

Drupal-11-Website (Composer-Projekt `drupal/recommended-project`), lokal entwickelt mit DDEV.
Spätere Live-Adresse: **https://designpink.de/drupal** (Strato Shared Hosting).

**Konzept:** Musterseite einer fiktiven Behörde, des *Landesamts für Digitale Teilhabe
Musterland* (LDT Musterland), als Arbeitsprobe für Online-Redaktion und digitale
Barrierefreiheit (Ziel: WCAG 2.1 AA). Ein Hinweis-Balken auf jeder Seite macht klar, dass es
keine echte Behörde ist. Impressum und Datenschutz enthalten die echten Angaben des
tatsächlichen Betreibers.

| | |
|---|---|
| Drupal | 11.x, Sprache Deutsch |
| PHP | 8.3 |
| Datenbank | MariaDB 11.8 (lokal) |
| Öffentlicher Ordner (Docroot) | `web/` |

## Ordnerstruktur

```
.ddev/          DDEV-Konfiguration (lokale Umgebung)
config/sync/    Exportierte Drupal-Konfiguration (drush cex / cim)
vendor/         PHP-Bibliotheken (von Composer, nicht im Git)
web/            Öffentlicher Ordner – nur dieser darf vom Webserver ausgeliefert werden
  modules/custom/   eigene Module
  themes/custom/    eigene Themes
  sites/default/    settings.php (+ settings.local.php auf dem Server)
composer.json   Liste der Abhängigkeiten (Drupal-Kern, Module, Drush)
```

## Was liegt wo?

| Was | Wo gespeichert | Wie kommt es auf Strato? |
|---|---|---|
| Einstellungen (Inhaltstypen, Felder, Menüs, Formulare, Module) | `config/sync/` (Git) | `drush cim` oder mit der Datenbank |
| Seiten, Menüpunkte, eigene Übersetzungen, Formular-Einsendungen | Datenbank | Datenbank-Export/-Import |
| Hochgeladene Dateien (Bilder, PDFs, Videos) | `web/sites/default/files/` | per SFTP hochladen |
| Eigener Code | `web/modules/custom/` (Git) | mit dem Projekt hochladen |

Nach Änderungen im Backend immer `ddev drush cex` ausführen und `config/sync` committen.

## Video mit Untertiteln

Auf jeder Basisseite gibt es die optionalen Felder **Video** (MP4/WebM) und
**Untertitel (WebVTT)**. Das Modul `web/modules/custom/designpink_video` gibt das Video als
`<video>` mit `<track kind="captions">` aus. Das Template `designpink-video.html.twig`
kann im späteren Theme überschrieben werden (gleichnamige Datei im Theme-Ordner `templates/`).

Damit Browser die Untertitel annehmen, muss `.vtt` als `text/vtt` ausgeliefert werden:
lokal über `.ddev/nginx/vtt.conf`, auf Strato über `AddType text/vtt .vtt` in `web/.htaccess`.

## Eigene Module (`web/modules/custom`)

| Modul | Aufgabe |
|---|---|
| `designpink_video` | Video mit WebVTT-Untertiteln als `<track>` |
| `ldt_musterhinweis` | Hinweis-Balken „Musterseite“ (`role="note"`) ganz oben auf jeder Seite; Demo-Hinweis über Formularen, die nichts speichern/versenden |
| `ldt_formulare` | Verknüpft Fehlermeldungen am Feld per `aria-describedby` mit dem Feld |

## Seiten und Texte

Die Platzhalter-Texte stehen in `scripts/pages.php`. Links zwischen Seiten werden mit
Linkit gespeichert (`data-entity-uuid`) und erst beim Ausgeben in die aktuelle URL
umgewandelt – sie funktionieren deshalb auch im Unterordner `/drupal`.
Im Editor: Link-Schaltfläche, dann Seitentitel eintippen und Vorschlag auswählen.

```bash
ddev drush php:script scripts/create-content.php                 # fehlende Seiten anlegen
ddev drush php:script scripts/create-content.php -- --overwrite  # ACHTUNG: überschreibt Texte
```

## Lokale Umgebung

Voraussetzung: Docker Desktop läuft.

```bash
ddev start        # Umgebung starten
ddev stop         # Umgebung stoppen (Daten bleiben erhalten)
ddev restart      # neu starten, z. B. nach Änderungen in .ddev/
ddev describe     # Übersicht: URLs, Ports, Datenbank-Zugang
```

### Seite öffnen

```bash
ddev launch                 # öffnet die Startseite im Browser
ddev drush uli              # erzeugt einen Einmal-Login-Link für "admin"
```

Lokale URL: **https://designpink.ddev.site:33001**
(Port 33001, weil Port 443 auf diesem Mac schon belegt ist. Die aktuelle URL zeigt immer `ddev describe`.)

Admin-Login: `/user/login`, Benutzer `admin`. Das Passwort steht in keiner Datei –
bei Verlust: `ddev drush user:password admin "NEUES-PASSWORT"`.

> Hinweis: Die FRITZ!Box blockiert per DNS-Rebind-Schutz Adressen, die auf 127.0.0.1 zeigen.
> Deshalb steht `designpink.ddev.site` in `/etc/hosts`.

### Häufige Drush-Befehle

```bash
ddev drush cr               # Cache leeren (hilft bei fast allem)
ddev drush status           # Zustand der Installation
ddev drush cex              # Konfiguration nach config/sync exportieren (dann committen)
ddev drush cim              # Konfiguration aus config/sync importieren
ddev composer require drupal/MODULNAME   # Modul hinzufügen
ddev drush en MODULNAME     # Modul aktivieren
```

### Datenbank exportieren / importieren

```bash
mkdir -p backups
ddev export-db --file=backups/designpink-$(date +%Y-%m-%d).sql.gz   # Export (gzip)
ddev import-db --file=backups/DATEINAME.sql.gz                      # Import
ddev snapshot               # schneller Sicherungspunkt (nur lokal)
ddev snapshot restore --latest
```

`backups/` und `*.sql*` sind in `.gitignore` – Datenbank-Dumps kommen nie ins Repository.

## Später: Deployment zu Strato

Checkliste für den ersten Upload auf den Strato-Webspace:

1. **`web` als öffentliches Verzeichnis.**
   Nur der Inhalt von `web/` darf über die URL erreichbar sein; `vendor/`, `config/`,
   `composer.json` usw. gehören außerhalb des öffentlich erreichbaren Bereichs.
   Empfohlene Struktur auf dem Webspace:
   ```
   /drupal-projekt/            ← komplettes Projekt (vendor, config, web, …)
   /<Domain-Ordner>/drupal  →  Verweis (Symlink) auf /drupal-projekt/web
   ```
   Der Symlink lässt sich per SSH anlegen (`ln -s`). Prüfen, ob das Strato-Paket SSH
   enthält. Ohne SSH: mit dem Strato-Support klären, wie `web/` als Ordner
   `/drupal` eingebunden werden kann.

2. **Unterordner `/drupal`.**
   In `web/.htaccess` die Zeile `# RewriteBase /drupal` aktivieren (das `#` entfernen),
   falls saubere URLs (`/drupal/user/login`) nicht funktionieren.
   Achtung: `composer update` des Drupal-Kerns kann `web/.htaccess` überschreiben –
   danach mit `git diff web/.htaccess` prüfen und die Änderung wiederherstellen.
   Drupal erkennt den Unterordner ansonsten selbst; im Code nie absolute Pfade wie
   `/sites/...` fest eintragen, sondern Drupals URL-Funktionen verwenden.

3. **PHP-Abhängigkeiten.**
   Auf Strato `composer install --no-dev` ausführen (per SSH) oder lokal ausführen
   und den Ordner `vendor/` mit hochladen. PHP-Version im Strato-Kundenbereich auf 8.3 stellen.

4. **Datenbank-Import.**
   Im Strato-Kundenbereich eine MySQL/MariaDB-Datenbank anlegen.
   Lokal exportieren (`ddev export-db --file=backups/live.sql.gz`) und über
   phpMyAdmin bei Strato (oder per SSH mit `mysql`) importieren.
   Dateien aus `web/sites/default/files/` (Bilder, Uploads) separat per SFTP hochladen.

5. **settings.php / settings.local.php.**
   `settings.php` ist im Repository und enthält keine Zugangsdaten. Sie bindet automatisch
   `settings.local.php` ein, falls vorhanden. Auf dem Server:
   `web/sites/default/example.settings.local.php` nach `settings.local.php` kopieren
   und Datenbank-Zugangsdaten sowie einen neuen `hash_salt` eintragen.
   Strato-Zugangsdaten niemals ins Git-Repository!
   Danach `settings.php` und `settings.local.php` schreibschützen (Rechte 444).

6. **trusted_host_patterns.**
   Schon in der Vorlage enthalten: nur `designpink.de` und `www.designpink.de` erlauben.
   Fehlt die Einstellung, zeigt der Statusbericht eine Warnung; ist sie falsch,
   erscheint „The provided host name is not valid for this server“.

7. **Nach dem Upload.**
   `drush cr` (per SSH) bzw. `/drupal/update.php` aufrufen, dann den Statusbericht unter
   *Berichte → Statusbericht* prüfen (Dateirechte für `sites/default/files`, Cron usw.).

8. **Musterseiten-Schutz prüfen (vor dem Hochladen!).**
   In `example.settings.local.php` steht der Block „MUSTERSEITEN-SCHUTZ (live)“. Er wird mit
   in die `settings.local.php` auf dem Server übernommen und schaltet live ein:
   - `noindex, nofollow` auf allen Seiten (Metatag),
   - Demo-Modus für „Barriere melden“: nichts speichern, nichts versenden, nur Bestätigung;
     über dem Formular erscheint automatisch ein Demo-Hinweis.

   Nach dem Upload prüfen:
   - Seitenquelltext enthält `<meta name="robots" content="noindex, nofollow" />`
   - `/drupal/barriere-melden` zeigt den gelben Demo-Hinweis über dem Formular
   - per SSH: `drush cget metatag.metatag_defaults.global tags --include-overridden`

## Passwortschutz (optional)

Solange die Seite nicht öffentlich sein soll, kann sie per HTTP-Basic-Auth geschützt
werden. Vorlage (auskommentiert) – an den **Anfang** von `web/.htaccess` auf dem Server:

```apache
# --- Passwortschutz Musterseite ---------------------------------------------
# AuthType Basic
# AuthName "Musterseite - Zugang nur mit Passwort"
# AuthUserFile /ABSOLUTER/PFAD/AUF/DEM/SERVER/drupal-projekt/.htpasswd
# Require valid-user
# ----------------------------------------------------------------------------
```

- `AuthUserFile` braucht den **absoluten Serverpfad**. Er lässt sich bei Strato im
  Kundenbereich bzw. per SSH mit `pwd` im Projektordner ermitteln. Diesen Pfad nur auf dem
  Server eintragen, nicht ins Repository.
- `.htpasswd` **außerhalb von `web/`** ablegen (z. B. im Projektordner), nie ins Repository.
- Datei erzeugen (fragt das Passwort ab, es landet nicht im Shell-Verlauf):
  `htpasswd -c -B /PFAD/.htpasswd BENUTZERNAME`
  (ohne SSH: lokal mit `htpasswd -n -B BENUTZERNAME` erzeugen und die Ausgabezeile per SFTP
  in die Datei `.htpasswd` schreiben).
- Nur über HTTPS nutzen – Basic-Auth überträgt das Passwort sonst lesbar.
- Achtung: `composer update` kann `web/.htaccess` überschreiben (siehe Punkt 2).
