#!/usr/bin/env bash
#
# Baut den Upload-Ordner für Strato (Produktions-Build, ohne Zugangsdaten).
#
#   scripts/strato-build.sh [ZIELORDNER]      Standard: ~/Documents/Claude/strato-upload
#
# Ergebnis (Aufteilung auf dem Webspace, siehe STRATO-UPLOAD.md im Zielordner):
#   designpink/index.html        Platzhalter für designpink.de
#   designpink/drupal/           Inhalt von web/ (designpink.de/drupal)
#   drupal-projekt/              vendor/, config/sync/, composer.json/.lock, private/
#   ldt.sql                      Datenbank-Export (für phpMyAdmin)
#
# Grundlage ist der letzte Commit (git archive): nicht committete Änderungen
# fehlen, lokale Einstellungen (settings.local.php, settings.ddev.php), Tests,
# node_modules, .git und .ddev kommen nicht mit. Composer läuft in einem
# eigenen Container aus dem DDEV-Webserver-Image (PHP 8.3); die laufende
# DDEV-Umgebung bleibt unverändert. Nur der Datenbank-Export nutzt sie.

set -euo pipefail

PROJEKT="$(cd "$(dirname "$0")/.." && pwd)"
ZIEL="${1:-$HOME/Documents/Claude/strato-upload}"
WEB="$ZIEL/designpink/drupal"
BASIS="$ZIEL/drupal-projekt"
IMAGE="${DDEV_WEB_IMAGE:-$(docker images --format '{{.Repository}}:{{.Tag}}' | grep -m1 'ddev-webserver.*-built' || true)}"

if [ -e "$ZIEL" ]; then
  echo "Zielordner existiert schon: $ZIEL – bitte vorher umbenennen oder löschen." >&2
  exit 1
fi
if [ -z "$IMAGE" ]; then
  echo "Kein DDEV-Webserver-Image gefunden (einmal 'ddev start' ausführen)." >&2
  exit 1
fi
if [ -n "$(git -C "$PROJEKT" status --porcelain)" ]; then
  echo "Hinweis: Es gibt nicht committete Änderungen – sie kommen NICHT mit." >&2
fi

echo "1/6 Dateien aus dem letzten Commit"
mkdir -p "$BASIS" "$WEB"
git -C "$PROJEKT" archive HEAD composer.json composer.lock config/sync assets | tar -x -C "$BASIS"
git -C "$PROJEKT" archive HEAD:web | tar -x -C "$WEB"
mkdir -p "$BASIS/private"

echo "2/6 composer.json: Web-Root ../designpink/drupal/"
# Composer schreibt die Pfade in autoload.php und vendor/composer/ dann
# passend zur Aufteilung (kein Symlink nötig).
python3 - "$BASIS/composer.json" <<'PY'
import json, sys
p = sys.argv[1]
d = json.load(open(p))
d['extra']['drupal-scaffold']['locations']['web-root'] = '../designpink/drupal/'
d['extra']['installer-paths'] = {
    (k.replace('web/', '../designpink/drupal/', 1) if k.startswith('web/') else k): v
    for k, v in d['extra']['installer-paths'].items()
}
open(p, 'w').write(json.dumps(d, indent=4, ensure_ascii=False) + '\n')
PY

echo "3/6 composer install --no-dev --optimize-autoloader (PHP 8.3, $IMAGE)"
docker run --rm -u "$(id -u):$(id -g)" -e COMPOSER_HOME=/tmp/composer \
  -v "$ZIEL":/build -w /build/drupal-projekt --entrypoint php8.3 "$IMAGE" \
  /usr/local/bin/composer install --no-dev --optimize-autoloader --no-interaction --no-progress
rm -rf "$BASIS/assets"

echo "4/6 .htaccess für Strato (RewriteBase /drupal, Passwortschutz, noindex)"
sed -i '' 's|^  # RewriteBase /drupal$|  RewriteBase /drupal|' "$WEB/.htaccess"
grep -q '^  RewriteBase /drupal$' "$WEB/.htaccess" || { echo "RewriteBase nicht gesetzt" >&2; exit 1; }
cat "$PROJEKT/assets/htaccess-strato.txt" "$WEB/.htaccess" > "$WEB/.htaccess.neu"
mv "$WEB/.htaccess.neu" "$WEB/.htaccess"

echo "5/6 Hochgeladene Dateien (ohne erzeugte Ordner css, js, php, styles)"
rsync -a --exclude '/css/' --exclude '/js/' --exclude '/php/' --exclude '/styles/' --exclude '/sync/' --exclude '.DS_Store' \
  "$PROJEKT/web/sites/default/files/" "$WEB/sites/default/files/"

cat > "$ZIEL/designpink/index.html" <<'HTML'
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>designpink.de – im Aufbau</title>
  <style>
    body { margin: 0; padding: 2rem 1rem; font-family: system-ui, sans-serif; line-height: 1.5; color: #1d1b20; background: #fff; }
    main { max-width: 40rem; margin: 0 auto; }
    h1 { font-size: 1.75rem; }
  </style>
</head>
<body>
  <main>
    <h1>designpink.de – diese Seite befindet sich im Aufbau.</h1>
  </main>
</body>
</html>
HTML

cp "$PROJEKT/assets/STRATO-UPLOAD.md" "$ZIEL/"

# Rechte: Ordner 755, Dateien 644; ausführbare Dateien (z. B. Drush) behalten
# ihr x (755). settings*.php setzt man auf dem Server auf 444.
chmod -R u+rwX,go+rX,go-w "$ZIEL"

echo "6/6 Datenbank-Export (Caches vorher leeren)"
(cd "$PROJEKT" && ddev drush cr && ddev export-db --gzip=false --file="$ZIEL/ldt.sql")
chmod 644 "$ZIEL/ldt.sql"

# Kontrolle: nichts Lokales oder Geheimes im Upload.
# Fremder Code (vendor/, core/) bringt eigene Beispiel- und Testdateien mit
# (z. B. core/.env.example) – die sind hier nicht gemeint.
FUNDE="$(find "$ZIEL" \( -path "$BASIS/vendor" -o -path "$WEB/core" \) -prune -o \( -name settings.local.php -o -name settings.ddev.php -o -name '.env' -o -name '.env.*' \
  -o -name node_modules -o -name .git -o -name .ddev -o -name .htpasswd -o -path '*/tests/a11y' \) -print)"
if [ -n "$FUNDE" ]; then
  echo "FEHLER – gehört nicht in den Upload:" >&2
  echo "$FUNDE" >&2
  exit 1
fi
echo "Fertig: $ZIEL"
