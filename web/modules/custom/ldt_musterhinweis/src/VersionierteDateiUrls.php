<?php

declare(strict_types=1);

namespace Drupal\ldt_musterhinweis;

use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Url;

/**
 * Hängt an Adressen öffentlicher Dateien eine Versionskennung (?v=…) an.
 *
 * Der Server erlaubt Browsern, Dateien sehr lange zwischenzuspeichern
 * (Cache-Control: max-age bis zu 10 Jahre). Wird eine Datei unter gleichem
 * Namen ersetzt (Video, Untertitel, PDF …), zeigt der Browser sonst weiter
 * die alte Fassung – beim Video passen Bild und Untertitel dann nicht mehr
 * zusammen. Die Kennung wird aus Änderungszeit und Größe der Datei gebildet:
 * Ändert sich die Datei, ändert sich die Adresse, und der Browser lädt neu.
 *
 * Gilt für alle Wege, auf denen Drupal Dateiadressen erzeugt: Linkit-Links
 * im Text, Bilder im Editor, Dateifelder, das Video samt Untertiteln.
 * Ausgenommen: zusammengefasste CSS/JS-Dateien (eigene Kennung im Namen).
 *
 * Wichtig: Nach dem Ersetzen einer Datei per SFTP den Cache leeren
 * (drush cr), sonst enthalten zwischengespeicherte Seiten noch die alte
 * Kennung. Bei Fotos zusätzlich die Bildvarianten neu erzeugen lassen
 * (drush image:flush --all), sonst liefert der Server die alten aus.
 */
class VersionierteDateiUrls implements FileUrlGeneratorInterface {

  public function __construct(
    protected FileUrlGeneratorInterface $inner,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function generateString(string $uri): string {
    return $this->mitVersion($this->inner->generateString($uri), $uri);
  }

  /**
   * {@inheritdoc}
   */
  public function generateAbsoluteString(string $uri): string {
    return $this->mitVersion($this->inner->generateAbsoluteString($uri), $uri);
  }

  /**
   * {@inheritdoc}
   */
  public function generate(string $uri): Url {
    $url = $this->inner->generate($uri);
    if ($v = $this->version($uri)) {
      $url->setOption('query', ($url->getOption('query') ?? []) + ['v' => $v]);
    }
    return $url;
  }

  /**
   * {@inheritdoc}
   */
  public function transformRelative(string $file_url, bool $root_relative = TRUE): string {
    return $this->inner->transformRelative($file_url, $root_relative);
  }

  /**
   * Hängt ?v=… bzw. &v=… an, wenn es für die Datei eine Kennung gibt.
   */
  protected function mitVersion(string $url, string $uri): string {
    $v = $this->version($uri);
    return $v ? $url . (str_contains($url, '?') ? '&' : '?') . 'v=' . $v : $url;
  }

  /**
   * Kennung aus Änderungszeit und Größe, nur für vorhandene öffentliche Dateien.
   */
  protected function version(string $uri): ?string {
    if (!str_starts_with($uri, 'public://') || preg_match('#^public://(css|js|php)/#', $uri)) {
      return NULL;
    }
    // Bildstil-Varianten (public://styles/STIL/public/PFAD[.webp]): Kennung
    // der Originaldatei – so steht sie schon in der Adresse, bevor die
    // Variante erzeugt ist, und ändert sich mit dem Original.
    if (preg_match('#^public://styles/[^/]+/public/(.+?)(\.webp)?$#', $uri, $m)) {
      $original = 'public://' . $m[1];
      if (is_file($original)) {
        $uri = $original;
      }
    }
    if (!is_file($uri)) {
      return NULL;
    }
    return substr(md5(filemtime($uri) . '-' . filesize($uri)), 0, 8);
  }

}
