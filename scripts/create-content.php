<?php

/**
 * @file
 * Legt die Seitenstruktur mit Platzhalter-Inhalten und die Menüs an.
 *
 * Einmalig ausführen mit: ddev drush php:script scripts/create-content.php
 *
 * Inhalte in eckigen Klammern sind Hinweise, was dort hingehört.
 * Interne Links werden nicht in Texte geschrieben (sie würden im Unterordner
 * /drupal brechen); die Navigation läuft über die Menüs.
 */

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\node\Entity\Node;

$pages = [
  'start' => [
    'title' => 'Start',
    'body' => '
<p>[Hier: kurze Begrüßung in 2–3 Sätzen – wer Sie sind und wofür diese Website steht.]</p>
<h2>Schwerpunkte</h2>
<ul>
  <li>Barrierefreiheit – [Hier: ein Satz zu diesem Schwerpunkt]</li>
  <li>Online-Redaktion – [Hier: ein Satz zu diesem Schwerpunkt]</li>
  <li>Web &amp; Optimierung – [Hier: ein Satz zu diesem Schwerpunkt]</li>
  <li>Schulungen – [Hier: ein Satz zu diesem Schwerpunkt]</li>
</ul>
<h2>Über diese Website</h2>
<p>[Hier: Hinweis, dass diese Website selbst als Arbeitsprobe nach WCAG 2.1 AA umgesetzt ist, und wo die Erklärung zur Barrierefreiheit zu finden ist.]</p>',
  ],

  // Hauptmenü: Barrierefreiheit.
  'barrierefreiheit' => [
    'title' => 'Barrierefreiheit',
    'menu' => 'main', 'weight' => 1,
    'body' => '
<p>[Hier: Einleitung in 3–4 Sätzen – was digitale Barrierefreiheit für Sie bedeutet und welche Rolle sie in der Online-Redaktion spielt.]</p>
<h2>Rechtlicher Rahmen</h2>
<p>[Hier: kurze Einordnung von BITV 2.0, WCAG 2.1, EN 301 549 und Barrierefreiheitsstärkungsgesetz – in eigenen Worten, mit Quellenangaben.]</p>
<h2>Themen in diesem Bereich</h2>
<ul>
  <li>Barrierefreie Dokumente – [Hier: ein Satz]</li>
  <li>Leichte Sprache – [Hier: ein Satz]</li>
  <li>Video &amp; Untertitel – [Hier: ein Satz]</li>
  <li>Gebärdensprache – [Hier: ein Satz]</li>
</ul>
<h2>Meine Arbeitsweise</h2>
<p>[Hier: wie Sie Barrierefreiheit prüfen – Prüfschritte, Werkzeuge, Tests mit Screenreader. Nur Werkzeuge nennen, mit denen Sie tatsächlich arbeiten.]</p>',
  ],
  'dokumente' => [
    'title' => 'Barrierefreie Dokumente',
    'menu' => 'main', 'parent' => 'barrierefreiheit', 'weight' => 1,
    'body' => '
<p>[Hier: Einleitung – warum Dokumente auf Behördenseiten barrierefrei sein müssen.]</p>
<h2>Vorher – nachher</h2>
<p>[Hier: PDF vorher/nachher + PAC-Prüfbericht]</p>
<h3>Ausgangsdokument</h3>
<p>[Hier: Original-PDF mit kurzer Beschreibung der Barrieren, z. B. fehlende Tags, falsche Lesereihenfolge.]</p>
<h3>Überarbeitetes Dokument</h3>
<p>[Hier: barrierefreies PDF als Download – im Linktext Format und Dateigröße nennen, z. B. „(PDF, 240 KB)“.]</p>
<h3>Prüfbericht</h3>
<p>[Hier: PAC-Prüfbericht als Bild mit Textalternative oder als Datei.]</p>
<h2>Vorgehen</h2>
<p>[Hier: Ihre Arbeitsschritte – Tags, Lesereihenfolge, Alternativtexte, Tabellen, Dokumentsprache, Metadaten.]</p>
<h2>Werkzeuge</h2>
<p>[Hier: Programme, die Sie selbst nutzen.]</p>',
  ],
  'leichte-sprache-fach' => [
    'title' => 'Leichte Sprache',
    'menu' => 'main', 'parent' => 'barrierefreiheit', 'weight' => 2,
    'body' => '
<p>[Hier: was Leichte Sprache ist und wie sie sich von Einfacher Sprache unterscheidet.]</p>
<h2>Arbeitsprobe</h2>
<h3>Ausgangstext</h3>
<p>[Hier: kurzer Text in Standardsprache.]</p>
<h3>Text in Leichter Sprache</h3>
<p>[Hier: Ihre Übertragung desselben Textes in Leichte Sprache.]</p>
<h2>Prüfung</h2>
<p>[Hier: ob und wie der Text von einer Prüfgruppe geprüft wurde – nur wenn das zutrifft.]</p>
<h2>Regelwerk und Quellen</h2>
<p>[Hier: das Regelwerk, auf das Sie sich beziehen, mit Quellenangabe.]</p>',
  ],
  'video' => [
    'title' => 'Video & Untertitel',
    'menu' => 'main', 'parent' => 'barrierefreiheit', 'weight' => 3,
    'body' => '
<p>[Hier: Einleitung – warum Videos Untertitel, Transkript und ggf. Audiodeskription brauchen.]</p>
<h2>Beispielvideo</h2>
<p>[Hier: Video mit Untertiteln – wird über die Felder „Video“ und „Untertitel (WebVTT)“ dieser Seite eingebunden.]</p>
<h2>Transkript</h2>
<p>[Hier: vollständiges Textskript des Videos.]</p>
<h2>Vorgehen</h2>
<p>[Hier: wie Sie Untertitel erstellen – Werkzeuge, Regeln zu Zeilenlänge, Standzeit, Geräuschen und Sprecherkennzeichnung.]</p>
<h2>Audiodeskription</h2>
<p>[Hier: ob das Video eine Audiodeskription braucht und wie Sie damit umgehen.]</p>',
  ],
  'gebaerdensprache-fach' => [
    'title' => 'Gebärdensprache',
    'menu' => 'main', 'parent' => 'barrierefreiheit', 'weight' => 4,
    'body' => '
<p>[Hier: Rolle der Deutschen Gebärdensprache (DGS) für die Barrierefreiheit und Anforderungen der BITV 2.0.]</p>
<h2>Beispiel</h2>
<p>[Hier: DGS-Video mit Untertiteln und Transkript – nur mit den Nutzungsrechten der Beteiligten.]</p>
<h2>Zusammenarbeit</h2>
<p>[Hier: wie Sie Gebärdensprach-Videos planen, beauftragen, abnehmen und einbinden.]</p>',
  ],

  // Hauptmenü: Online-Redaktion.
  'online-redaktion' => [
    'title' => 'Online-Redaktion',
    'menu' => 'main', 'weight' => 2,
    'body' => '
<p>[Hier: Einleitung – Ihr Verständnis von Online-Redaktion im öffentlichen Dienst.]</p>
<h2>Themen in diesem Bereich</h2>
<ul>
  <li>Texte fürs Web – [Hier: ein Satz]</li>
  <li>Arbeitshilfe Redaktion – [Hier: ein Satz]</li>
  <li>Social Media – [Hier: ein Satz]</li>
</ul>
<h2>Redaktionelle Grundsätze</h2>
<p>[Hier: Ihre Grundsätze, z. B. Verständlichkeit, Aktualität, Bürgerorientierung.]</p>',
  ],
  'texte' => [
    'title' => 'Texte fürs Web',
    'menu' => 'main', 'parent' => 'online-redaktion', 'weight' => 1,
    'body' => '
<p>[Hier: Einleitung – wie Menschen im Web lesen und was daraus für Texte folgt.]</p>
<h2>Beispiel: vorher – nachher</h2>
<h3>Ausgangstext</h3>
<p>[Hier: ein Verwaltungstext im Original.]</p>
<h3>Überarbeitete Webfassung</h3>
<p>[Hier: Ihre überarbeitete Fassung.]</p>
<h3>Was sich geändert hat</h3>
<p>[Hier: Stichpunkte – Struktur, Satzlänge, Ansprache, Zwischenüberschriften, Linktexte.]</p>
<h2>Grundsätze</h2>
<p>[Hier: Ihre wichtigsten Regeln für Webtexte.]</p>',
  ],
  'arbeitshilfe' => [
    'title' => 'Arbeitshilfe Redaktion',
    'menu' => 'main', 'parent' => 'online-redaktion', 'weight' => 2,
    'body' => '
<p>[Hier: wofür diese Arbeitshilfe gedacht ist und für wen.]</p>
<h2>Checkliste vor der Veröffentlichung</h2>
<p>[Hier: Ihre Checkliste, z. B. Überschriftenstruktur, Alternativtexte, Linktexte, Tabellen, Kontraste, Dokumente.]</p>
<h2>Download</h2>
<p>[Hier: Arbeitshilfe als barrierefreies PDF – im Linktext Format und Dateigröße nennen.]</p>',
  ],
  'social-media' => [
    'title' => 'Social Media',
    'menu' => 'main', 'parent' => 'online-redaktion', 'weight' => 3,
    'body' => '
<p>[Hier: Einleitung – Social Media in der Behördenkommunikation.]</p>
<h2>Barrierefreie Beiträge</h2>
<p>[Hier: Alternativtexte, Hashtags in CamelCase, sparsamer Einsatz von Emojis, Untertitel in Videos.]</p>
<h2>Beispiele</h2>
<p>[Hier: Beispielbeiträge als Bild mit Textalternative – keine direkte Einbettung von Plattformen ohne Datenschutzlösung.]</p>
<h2>Redaktionsplanung</h2>
<p>[Hier: wie Sie Beiträge planen und abstimmen.]</p>',
  ],

  // Hauptmenü: Web & Optimierung.
  'web-optimierung' => [
    'title' => 'Web & Optimierung',
    'menu' => 'main', 'weight' => 3,
    'body' => '
<p>[Hier: Einleitung – wie Struktur, Auffindbarkeit und Messbarkeit zusammenhängen.]</p>
<h2>Themen in diesem Bereich</h2>
<ul>
  <li>Informationsarchitektur – [Hier: ein Satz]</li>
  <li>SEO &amp; GEO – [Hier: ein Satz]</li>
  <li>Webanalyse mit Matomo – [Hier: ein Satz]</li>
</ul>',
  ],
  'ia' => [
    'title' => 'Informationsarchitektur',
    'menu' => 'main', 'parent' => 'web-optimierung', 'weight' => 1,
    'body' => '
<p>[Hier: was Informationsarchitektur ist und warum sie für Behördenseiten wichtig ist.]</p>
<h2>Ausgangslage</h2>
<p>[Hier: Beispiel – z. B. die Struktur dieser Website und die Überlegungen dahinter.]</p>
<h2>Vorgehen</h2>
<p>[Hier: Methoden, die Sie tatsächlich angewendet haben, z. B. Card Sorting, Tree Testing, Analyse von Suchbegriffen.]</p>
<h2>Ergebnis</h2>
<p>[Hier: Navigationsstruktur als Liste oder als Grafik mit Textalternative.]</p>',
  ],
  'seo-geo' => [
    'title' => 'SEO & GEO',
    'menu' => 'main', 'parent' => 'web-optimierung', 'weight' => 2,
    'body' => '
<p>[Hier: was Suchmaschinenoptimierung (SEO) und Generative Engine Optimization (GEO) bedeuten.]</p>
<h2>Umsetzung auf dieser Website</h2>
<p>[Hier: was hier konkret umgesetzt ist – sprechende URLs, Metadaten, strukturierte Daten nach schema.org, XML-Sitemap.]</p>
<h2>Inhalte für Menschen, Suchmaschinen und KI-Systeme</h2>
<p>[Hier: wie Sie Inhalte so aufbauen, dass sie verständlich und gut auffindbar sind.]</p>',
  ],
  'matomo' => [
    'title' => 'Webanalyse mit Matomo',
    'menu' => 'main', 'parent' => 'web-optimierung', 'weight' => 3,
    'body' => '
<p>[Hier: warum Matomo im öffentlichen Dienst häufig eingesetzt wird.]</p>
<h2>Datenschutzkonforme Einrichtung</h2>
<p>[Hier: Einstellungen wie IP-Anonymisierung, Verzicht auf Cookies, Widerspruchsmöglichkeit.]</p>
<h2>Kennzahlen für Redaktionen</h2>
<p>[Hier: welche Auswertungen Redaktionen wirklich weiterhelfen.]</p>
<h2>Auf dieser Website</h2>
<p>[Hier: ob Matomo auf dieser Website aktiv ist – mit Verweis auf die Datenschutzerklärung.]</p>',
  ],

  // Hauptmenü: Einzelseiten.
  'schulungen' => [
    'title' => 'Schulungen',
    'menu' => 'main', 'weight' => 4,
    'body' => '
<p>[Hier: Einleitung – welche Schulungen Sie anbieten und für wen.]</p>
<h2>Angebote</h2>
<p>[Hier: Schulungsthemen mit Zielgruppe, Dauer und Format.]</p>
<h2>Beispielmaterial</h2>
<p>[Hier: Auszug aus barrierefreien Schulungsunterlagen.]</p>
<h2>Erfahrung</h2>
<p>[Hier: nur Schulungen, die Sie tatsächlich durchgeführt haben.]</p>',
  ],
  'ueber-mich' => [
    'title' => 'Über mich / Kontakt',
    'menu' => 'main', 'weight' => 5,
    'body' => '
<h2>Über mich</h2>
<p>[Hier: Kurzprofil – Ausbildung, berufliche Stationen, Schwerpunkte.]</p>
<h2>Qualifikationen</h2>
<p>[Hier: Zertifikate und Fortbildungen.]</p>
<h2>Kontakt</h2>
<p>[Hier: E-Mail-Adresse als Link und ggf. weitere Kontaktwege.]</p>',
  ],

  // Footer-Menü.
  'erklaerung' => [
    'title' => 'Erklärung zur Barrierefreiheit',
    'menu' => 'footer', 'weight' => 1,
    'body' => '
<p>[Hier: Hinweis, dass diese Website eine private Arbeitsprobe ist und die Erklärung nach dem Muster für öffentliche Stellen aufgebaut ist.]</p>
<h2>Stand der Vereinbarkeit mit den Anforderungen</h2>
<p>[Hier: vollständig, teilweise oder nicht vereinbar – auf Grundlage Ihrer eigenen Prüfung.]</p>
<h2>Nicht barrierefreie Inhalte</h2>
<p>[Hier: bekannte Mängel mit Begründung und ggf. Alternativen.]</p>
<h2>Erstellung dieser Erklärung</h2>
<p>[Hier: Datum der Erstellung und letzten Überprüfung, Prüfmethode (z. B. Selbstbewertung).]</p>
<h2>Feedback und Kontakt</h2>
<p>[Hier: Kontaktangaben und Hinweis auf das Formular „Barriere melden“ im Footer.]</p>
<h2>Schlichtungsverfahren</h2>
<p>[Hier: Hinweis auf die Schlichtungsstelle nach § 16 BGG – bei Behördenseiten Pflicht; hier als Muster kennzeichnen.]</p>',
  ],
  'leichte-sprache' => [
    'title' => 'Leichte Sprache',
    'menu' => 'footer', 'weight' => 3,
    'body' => '
<p>[Hier: alle Texte dieser Seite in Leichter Sprache.]</p>
<h2>Was steht auf dieser Internet-Seite?</h2>
<p>[Hier: Informationen zu den wichtigsten Inhalten der Website.]</p>
<h2>Wie finde ich mich auf der Internet-Seite zurecht?</h2>
<p>[Hier: Hinweise zur Navigation.]</p>
<h2>Was ist die Erklärung zur Barriere-Freiheit?</h2>
<p>[Hier: Erklärung der Erklärung zur Barrierefreiheit.]</p>
<h2>Wo gibt es mehr Infos in Leichter Sprache?</h2>
<p>[Hier: Hinweise auf weitere Informationen in Leichter Sprache.]</p>',
  ],
  'gebaerdensprache' => [
    'title' => 'Gebärdensprache',
    'menu' => 'footer', 'weight' => 4,
    'body' => '
<p>[Hier: kurzer Einleitungssatz – auf dieser Seite gibt es Videos in Deutscher Gebärdensprache.]</p>
<h2>Inhalte dieser Website</h2>
<p>[Hier: DGS-Video mit Untertiteln und kurzem Text darunter.]</p>
<h2>Navigation</h2>
<p>[Hier: DGS-Video mit Untertiteln und kurzem Text darunter.]</p>
<h2>Erklärung zur Barrierefreiheit</h2>
<p>[Hier: DGS-Video mit Untertiteln und kurzem Text darunter.]</p>
<h2>Weitere Informationen in Gebärdensprache</h2>
<p>[Hier: DGS-Video mit Untertiteln und kurzem Text darunter.]</p>',
  ],
  'impressum' => [
    'title' => 'Impressum',
    'menu' => 'footer', 'weight' => 5,
    'body' => '
<h2>Angaben gemäß § 5 DDG</h2>
<p>[Hier: Name und ladungsfähige Anschrift.]</p>
<h2>Kontakt</h2>
<p>[Hier: E-Mail-Adresse und ggf. Telefonnummer.]</p>
<h2>Verantwortlich für den Inhalt</h2>
<p>[Hier: Angabe nach § 18 Abs. 2 MStV, falls zutreffend.]</p>
<p>[Hier: Text rechtlich prüfen lassen oder mit einem seriösen Generator erstellen.]</p>',
  ],
  'datenschutz' => [
    'title' => 'Datenschutz',
    'menu' => 'footer', 'weight' => 6,
    'body' => '
<p>[Hier: Datenschutzerklärung rechtlich prüfen lassen oder mit einem seriösen Generator erstellen.]</p>
<h2>Verantwortliche Stelle</h2>
<p>[Hier: Name und Kontaktdaten.]</p>
<h2>Hosting</h2>
<p>[Hier: Angaben zum Hoster und zum Vertrag zur Auftragsverarbeitung.]</p>
<h2>Server-Logdateien</h2>
<p>[Hier: welche Daten der Server automatisch speichert und wie lange.]</p>
<h2>Formular „Barriere melden“</h2>
<p>[Hier: welche Daten das Formular erhebt, Zweck und Speicherdauer.]</p>
<h2>Webanalyse mit Matomo</h2>
<p>[Hier: nur aufführen, wenn Matomo aktiv ist.]</p>
<h2>Ihre Rechte</h2>
<p>[Hier: Auskunft, Berichtigung, Löschung, Widerspruch, Beschwerde bei der Aufsichtsbehörde.]</p>',
  ],
];

$nodes = [];
$links = [];
foreach ($pages as $key => $page) {
  $node = Node::create([
    'type' => 'page',
    'langcode' => 'de',
    'title' => $page['title'],
    'body' => ['value' => trim($page['body']), 'format' => 'basic_html'],
    'status' => 1,
    'uid' => 1,
  ]);
  $node->save();
  $nodes[$key] = $node;

  if (!empty($page['menu'])) {
    $link = MenuLinkContent::create([
      'title' => $page['title'],
      'link' => ['uri' => 'entity:node/' . $node->id()],
      'menu_name' => $page['menu'],
      'parent' => !empty($page['parent']) ? $links[$page['parent']]->getPluginId() : '',
      'weight' => $page['weight'],
      'expanded' => TRUE,
      'langcode' => 'de',
    ]);
    $link->save();
    $links[$key] = $link;
  }
}

// Menüpunkt "Start" zeigt auf die Startseite (/), nicht auf /start.
MenuLinkContent::create([
  'title' => 'Start',
  'link' => ['uri' => 'internal:/'],
  'menu_name' => 'main',
  'weight' => 0,
  'langcode' => 'de',
])->save();

// Aliase erst jetzt erzeugen, wenn die Menüpunkte existieren.
foreach ($nodes as $node) {
  $node->path->pathauto = 1;
  $node->save();
}

// Seite "Start" als Startseite der Website.
\Drupal::configFactory()->getEditable('system.site')
  ->set('page.front', '/node/' . $nodes['start']->id())
  ->save();

foreach ($nodes as $node) {
  echo $node->id() . "\t" . $node->toUrl()->toString() . "\t" . $node->label() . "\n";
}
