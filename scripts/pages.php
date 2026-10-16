<?php

/**
 * @file
 * Seitenstruktur und Platzhalter-Texte der Musterseite "LDT Musterland".
 *
 * Wird von scripts/create-content.php gelesen.
 *
 * - Texte in eckigen Klammern sind Hinweise, was dort hingehört.
 * - {{link:SCHLÜSSEL|Linktext}} wird beim Anlegen in einen Linkit-Link
 *   umgewandelt (data-entity-uuid), der unabhängig vom Pfad funktioniert.
 * - 'description' wird als Meta-Beschreibung (Feld Metadaten) gesetzt.
 * - Keine festen internen Pfade wie "/impressum" in Texte schreiben.
 */

return [
  'start' => [
    'title' => 'Start',
    'description' => 'Musterseite des fiktiven Landesamts für Digitale Teilhabe Musterland: Barrierefreiheit, Online-Redaktion, Web-Optimierung und Schulungen.',
    'body' => '
<p>[Hier: Begrüßung in 2–3 Sätzen – wofür das Landesamt für Digitale Teilhabe Musterland (LDT Musterland) zuständig ist.]</p>
<h2>Unsere Themen</h2>
<ul>
  <li>{{link:barrierefreiheit|Barrierefreiheit}} – [Hier: ein Satz zum Angebot des Amts]</li>
  <li>{{link:online-redaktion|Online-Redaktion}} – [Hier: ein Satz zum Angebot des Amts]</li>
  <li>{{link:web-optimierung|Web &amp; Optimierung}} – [Hier: ein Satz zum Angebot des Amts]</li>
  <li>{{link:schulungen|Schulungen}} – [Hier: ein Satz zum Angebot des Amts]</li>
</ul>
<h2>Barrierefreiheit dieser Website</h2>
<p>[Hier: kurzer Hinweis, dass das LDT Musterland diese Website nach WCAG 2.1 AA gestaltet.] Einzelheiten stehen in der {{link:erklaerung|Erklärung zur Barrierefreiheit}}. Barrieren können Sie über das Formular „Barriere melden“ im Seitenfuß melden.</p>',
  ],

  // Hauptmenü: Barrierefreiheit.
  'barrierefreiheit' => [
    'title' => 'Barrierefreiheit',
    'description' => 'Digitale Barrierefreiheit in der Landesverwaltung Musterland: rechtlicher Rahmen, Dokumente, Leichte Sprache, Video und Gebärdensprache (Musterseite).',
    'menu' => 'main', 'weight' => 1,
    'body' => '
<p>[Hier: Einleitung – welche Aufgaben das LDT Musterland bei der digitalen Barrierefreiheit der Landesverwaltung übernimmt.]</p>
<h2>Rechtlicher Rahmen</h2>
<p>[Hier: kurze Einordnung von BITV 2.0, WCAG 2.1, EN 301 549 und Barrierefreiheitsstärkungsgesetz, mit Quellenangaben.]</p>
<h2>Themen in diesem Bereich</h2>
<ul>
  <li>{{link:dokumente|Barrierefreie Dokumente}} – [Hier: ein Satz]</li>
  <li>{{link:leichte-sprache-fach|Leichte Sprache}} – [Hier: ein Satz]</li>
  <li>{{link:video|Video &amp; Untertitel}} – [Hier: ein Satz]</li>
  <li>{{link:gebaerdensprache-fach|Gebärdensprache}} – [Hier: ein Satz]</li>
</ul>
<h2>So unterstützen wir die Landesverwaltung</h2>
<p>[Hier: Beratungs- und Prüfangebote des Amts, z. B. Prüfschritte, Werkzeuge, Tests mit Screenreader.]</p>',
  ],
  'dokumente' => [
    'title' => 'Barrierefreie Dokumente',
    'description' => 'Barrierefreie PDF-Dokumente: Beispiel vorher/nachher, Prüfbericht und Arbeitshilfen des LDT Musterland (Musterseite).',
    'menu' => 'main', 'parent' => 'barrierefreiheit', 'weight' => 1,
    'body' => '
<p>[Hier: warum Dokumente auf Websites der Landesverwaltung barrierefrei sein müssen.]</p>
<h2>Beispiel: vorher – nachher</h2>
<p>[Hier: PDF vorher/nachher + PAC-Prüfbericht]</p>
<h3>Ausgangsdokument</h3>
<p>[Hier: Original-PDF mit kurzer Beschreibung der Barrieren, z. B. fehlende Tags, falsche Lesereihenfolge.]</p>
<h3>Überarbeitetes Dokument</h3>
<p>[Hier: barrierefreies PDF als Download – im Linktext Format und Dateigröße nennen, z. B. „(PDF, 240 KB)“.]</p>
<h3>Prüfbericht</h3>
<p>[Hier: PAC-Prüfbericht als Bild mit Textalternative oder als Datei.]</p>
<h2>So gehen wir vor</h2>
<p>[Hier: Arbeitsschritte – Tags, Lesereihenfolge, Alternativtexte, Tabellen, Dokumentsprache, Metadaten.]</p>
<h2>Arbeitshilfen für Dienststellen</h2>
<p>[Hier: Hinweise und Vorlagen, z. B. barrierefreie Dokumentvorlagen.]</p>',
  ],
  'leichte-sprache-fach' => [
    'title' => 'Leichte Sprache',
    'description' => 'Leichte Sprache in der Verwaltung: was sie ausmacht, ein Beispieltext und die Prüfung durch die Zielgruppe (Musterseite).',
    'menu' => 'main', 'parent' => 'barrierefreiheit', 'weight' => 2,
    'body' => '
<p>[Hier: was Leichte Sprache ist, wie sie sich von Einfacher Sprache unterscheidet und warum Behörden sie anbieten.]</p>
<h2>Beispiel</h2>
<h3>Ausgangstext</h3>
<p>[Hier: kurzer Verwaltungstext in Standardsprache.]</p>
<h3>Text in Leichter Sprache</h3>
<p>[Hier: Übertragung desselben Textes in Leichte Sprache.]</p>
<h2>Prüfung durch die Zielgruppe</h2>
<p>[Hier: wie Texte in Leichter Sprache geprüft werden – nur beschreiben, was tatsächlich stattgefunden hat.]</p>
<h2>Regelwerk und Quellen</h2>
<p>[Hier: das Regelwerk, auf das sich das Amt bezieht, mit Quellenangabe.]</p>
<p>Informationen über diese Website in Leichter Sprache finden Sie auf der Seite {{link:leichte-sprache|Leichte Sprache}}.</p>',
  ],
  'video' => [
    'title' => 'Video & Untertitel',
    'description' => 'Videos barrierefrei veröffentlichen: Untertitel im WebVTT-Format, Transkript und Audiodeskription – mit Beispielvideo (Musterseite).',
    'menu' => 'main', 'parent' => 'barrierefreiheit', 'weight' => 3,
    'body' => '
<p>[Hier: warum Videos der Landesverwaltung Untertitel, Transkript und gegebenenfalls Audiodeskription brauchen.]</p>
<h2>Beispielvideo</h2>
<p>[Hier: Video mit Untertiteln – wird über die Felder „Video“ und „Untertitel (WebVTT)“ dieser Seite eingebunden.]</p>
<h2>Transkript</h2>
<p>[Hier: vollständiges Textskript des Videos.]</p>
<h2>So erstellen wir Untertitel</h2>
<p>[Hier: Werkzeuge und Regeln zu Zeilenlänge, Standzeit, Geräuschen und Sprecherkennzeichnung.]</p>
<h2>Audiodeskription</h2>
<p>[Hier: wann ein Video eine Audiodeskription braucht und wie das Amt damit umgeht.]</p>',
  ],
  'gebaerdensprache-fach' => [
    'title' => 'Gebärdensprache',
    'description' => 'Deutsche Gebärdensprache auf Behörden-Websites: Anforderungen der BITV 2.0 und Beauftragung von Videos (Musterseite).',
    'menu' => 'main', 'parent' => 'barrierefreiheit', 'weight' => 4,
    'body' => '
<p><strong>Hinweis: Diese Seite ist ein Muster.</strong> Es sind noch keine Videos in Deutscher Gebärdensprache eingebunden.</p>
<p>[Hier: Rolle der Deutschen Gebärdensprache (DGS) und Anforderungen der BITV 2.0 an Behörden-Websites.]</p>
<h2>Beispiel</h2>
<p>[Hier: DGS-Video mit Untertiteln und Transkript – nur mit den Nutzungsrechten der Beteiligten.]</p>
<h2>Gebärdensprach-Videos beauftragen</h2>
<p>[Hier: Hinweise für Dienststellen – Planung, Beauftragung, Abnahme und Einbindung.]</p>
<p>Informationen über diese Website in Deutscher Gebärdensprache finden Sie auf der Seite {{link:gebaerdensprache|Gebärdensprache}}.</p>',
  ],

  // Hauptmenü: Online-Redaktion.
  'online-redaktion' => [
    'title' => 'Online-Redaktion',
    'description' => 'Online-Redaktion in der Landesverwaltung: Texte fürs Web, Arbeitshilfen und Social Media (Musterseite).',
    'menu' => 'main', 'weight' => 2,
    'body' => '
<p>[Hier: Einleitung – wie das LDT Musterland die Redaktionen der Landesverwaltung unterstützt.]</p>
<h2>Themen in diesem Bereich</h2>
<ul>
  <li>{{link:texte|Texte fürs Web}} – [Hier: ein Satz]</li>
  <li>{{link:arbeitshilfe|Arbeitshilfe Redaktion}} – [Hier: ein Satz]</li>
  <li>{{link:social-media|Social Media}} – [Hier: ein Satz]</li>
</ul>
<h2>Redaktionelle Grundsätze</h2>
<p>[Hier: Grundsätze des Amts, z. B. Verständlichkeit, Aktualität, Bürgerorientierung.]</p>',
  ],
  'texte' => [
    'title' => 'Texte fürs Web',
    'description' => 'Verständliche Webtexte für die Verwaltung: Beispiel vorher/nachher und Empfehlungen für Redaktionen (Musterseite).',
    'menu' => 'main', 'parent' => 'online-redaktion', 'weight' => 1,
    'body' => '
<p>[Hier: wie Menschen im Web lesen und was daraus für Verwaltungstexte folgt.]</p>
<h2>Beispiel: vorher – nachher</h2>
<h3>Ausgangstext</h3>
<p>[Hier: ein Verwaltungstext im Original.]</p>
<h3>Überarbeitete Webfassung</h3>
<p>[Hier: die überarbeitete Fassung.]</p>
<h3>Was sich geändert hat</h3>
<p>[Hier: Stichpunkte – Struktur, Satzlänge, Ansprache, Zwischenüberschriften, Linktexte.]</p>
<h2>Empfehlungen für Redaktionen</h2>
<p>[Hier: die wichtigsten Regeln für Webtexte der Landesverwaltung.]</p>',
  ],
  'arbeitshilfe' => [
    'title' => 'Arbeitshilfe Redaktion',
    'description' => 'Checkliste für Redaktionen: Überschriften, Alternativtexte, Linktexte, Tabellen und Dokumente vor der Veröffentlichung prüfen (Musterseite).',
    'menu' => 'main', 'parent' => 'online-redaktion', 'weight' => 2,
    'body' => '
<p>[Hier: wofür diese Arbeitshilfe für Redaktionen der Landesverwaltung gedacht ist.]</p>
<h2>Checkliste vor der Veröffentlichung</h2>
<p>[Hier: Checkliste, z. B. Überschriftenstruktur, Alternativtexte, Linktexte, Tabellen, Kontraste, Dokumente.]</p>
<h2>Download</h2>
<p>[Hier: Arbeitshilfe als barrierefreies PDF – im Linktext Format und Dateigröße nennen.]</p>',
  ],
  'social-media' => [
    'title' => 'Social Media',
    'description' => 'Barrierefreie Social-Media-Beiträge: Alternativtexte, Hashtags, Emojis und Untertitel (Musterseite).',
    'menu' => 'main', 'parent' => 'online-redaktion', 'weight' => 3,
    'body' => '
<p>[Hier: Social Media in der Kommunikation der Landesverwaltung.]</p>
<h2>Barrierefreie Beiträge</h2>
<p>[Hier: Alternativtexte, Hashtags in CamelCase, sparsamer Einsatz von Emojis, Untertitel in Videos.]</p>
<h2>Beispiele</h2>
<p>[Hier: Beispielbeiträge als Bild mit Textalternative – keine direkte Einbettung von Plattformen ohne Datenschutzlösung.]</p>
<h2>Redaktionsplanung</h2>
<p>[Hier: Empfehlungen zur Planung und Abstimmung von Beiträgen.]</p>',
  ],

  // Hauptmenü: Web & Optimierung.
  'web-optimierung' => [
    'title' => 'Web & Optimierung',
    'description' => 'Struktur, Auffindbarkeit und Messbarkeit von Behörden-Websites: Informationsarchitektur, SEO & GEO, Webanalyse (Musterseite).',
    'menu' => 'main', 'weight' => 3,
    'body' => '
<p>[Hier: Einleitung – wie Struktur, Auffindbarkeit und Messbarkeit von Behörden-Websites zusammenhängen.]</p>
<h2>Themen in diesem Bereich</h2>
<ul>
  <li>{{link:ia|Informationsarchitektur}} – [Hier: ein Satz]</li>
  <li>{{link:seo-geo|SEO &amp; GEO}} – [Hier: ein Satz]</li>
  <li>{{link:matomo|Webanalyse mit Matomo}} – [Hier: ein Satz]</li>
</ul>',
  ],
  'ia' => [
    'title' => 'Informationsarchitektur',
    'description' => 'Informationsarchitektur für Behörden-Websites: Methoden wie Card Sorting und Tree Testing am Beispiel dieser Website (Musterseite).',
    'menu' => 'main', 'parent' => 'web-optimierung', 'weight' => 1,
    'body' => '
<p>[Hier: was Informationsarchitektur ist und warum sie für Behörden-Websites wichtig ist.]</p>
<h2>Beispiel: diese Website</h2>
<p>[Hier: Struktur dieser Website und die Überlegungen dahinter.]</p>
<h2>Methoden</h2>
<p>[Hier: Methoden wie Card Sorting, Tree Testing oder Auswertung von Suchbegriffen – nur beschreiben, was tatsächlich angewendet wurde.]</p>
<h2>Ergebnis</h2>
<p>[Hier: Navigationsstruktur als Liste oder als Grafik mit Textalternative.]</p>',
  ],
  'seo-geo' => [
    'title' => 'SEO & GEO',
    'description' => 'SEO und Generative Engine Optimization für Behörden: Metadaten, strukturierte Daten und verständliche Inhalte (Musterseite).',
    'menu' => 'main', 'parent' => 'web-optimierung', 'weight' => 2,
    'body' => '
<p>[Hier: was Suchmaschinenoptimierung (SEO) und Generative Engine Optimization (GEO) für Behörden bedeuten.]</p>
<h2>Umsetzung auf dieser Website</h2>
<p>[Hier: sprechende URLs, Metadaten, strukturierte Daten nach schema.org, XML-Sitemap. Hinweis: Als Musterseite ist diese Website für Suchmaschinen gesperrt (noindex).]</p>
<h2>Inhalte für Menschen, Suchmaschinen und KI-Systeme</h2>
<p>[Hier: wie Inhalte so aufgebaut werden, dass sie verständlich und gut auffindbar sind.]</p>',
  ],
  'matomo' => [
    'title' => 'Webanalyse mit Matomo',
    'description' => 'Datenschutzkonforme Webanalyse mit Matomo: Einrichtung ohne Cookies und Kennzahlen für Redaktionen (Musterseite).',
    'menu' => 'main', 'parent' => 'web-optimierung', 'weight' => 3,
    'body' => '
<p>[Hier: warum Matomo in der öffentlichen Verwaltung häufig eingesetzt wird.]</p>
<h2>Datenschutzkonforme Einrichtung</h2>
<p>[Hier: Einstellungen wie IP-Anonymisierung, Verzicht auf Cookies, Widerspruchsmöglichkeit.]</p>
<h2>Kennzahlen für Redaktionen</h2>
<p>[Hier: welche Auswertungen Redaktionen wirklich weiterhelfen.]</p>
<h2>Auf dieser Website</h2>
<p>[Hier: ob Matomo auf dieser Website aktiv ist.] Einzelheiten stehen in der {{link:datenschutz|Datenschutzerklärung}}.</p>',
  ],

  // Hauptmenü: Einzelseiten.
  'schulungen' => [
    'title' => 'Schulungen',
    'description' => 'Schulungen zu Barrierefreiheit und Online-Redaktion für Beschäftigte der Landesverwaltung Musterland (Musterseite).',
    'menu' => 'main', 'weight' => 4,
    'body' => '
<p>[Hier: Schulungsangebot des LDT Musterland für Beschäftigte der Landesverwaltung.]</p>
<h2>Angebote</h2>
<p>[Hier: Schulungsthemen mit Zielgruppe, Dauer und Format.]</p>
<h2>Beispielmaterial</h2>
<p>[Hier: Auszug aus barrierefreien Schulungsunterlagen.]</p>
<h2>Anmeldung</h2>
<p>[Hier: wie sich Dienststellen anmelden – im Muster ohne echte Anmeldung.]</p>',
  ],
  'ueber-uns' => [
    'title' => 'Über uns / Kontakt',
    'description' => 'Aufgaben und Kontakt des fiktiven Landesamts für Digitale Teilhabe Musterland – Musterseite, keine echte Behörde.',
    'menu' => 'main', 'weight' => 5,
    'body' => '
<h2>Aufgaben</h2>
<p>[Hier: Aufgaben des Landesamts für Digitale Teilhabe Musterland, z. B. Beratung, Prüfung und Schulung.]</p>
<h2>Organisation</h2>
<p>[Hier: Aufbau des Amts, z. B. Abteilungen oder Referate – fiktiv.]</p>
<h2>Kontakt</h2>
<p><strong>Beispieladresse – fiktive Angaben, keine echte Behörde.</strong></p>
<p>Landesamt für Digitale Teilhabe Musterland<br>Musterstraße 1<br>12345 Musterstadt</p>
<p>Telefon: 0000 000000 (Beispielnummer)<br>E-Mail: poststelle@ldt-musterland.example (Beispieladresse)</p>
<p>Barrieren auf dieser Website können Sie über das Formular „Barriere melden“ im Seitenfuß melden.</p>',
  ],

  // Footer-Menü.
  'erklaerung' => [
    'title' => 'Erklärung zur Barrierefreiheit',
    'description' => 'Muster einer Erklärung zur Barrierefreiheit nach BITV 2.0: Stand der Vereinbarkeit, bekannte Mängel und Feedback.',
    'menu' => 'footer', 'weight' => 1,
    'body' => '
<p><strong>Hinweis: Diese Erklärung ist ein Muster.</strong> Das Landesamt für Digitale Teilhabe Musterland ist eine fiktive Behörde.</p>
<p>[Hier: Einleitungssatz nach der Mustererklärung, z. B. „Das LDT Musterland ist bemüht, seine Website im Einklang mit den Vorgaben der BITV 2.0 barrierefrei zugänglich zu machen.“]</p>
<h2>Stand der Vereinbarkeit mit den Anforderungen</h2>
<p>[Hier: vollständig, teilweise oder nicht vereinbar – auf Grundlage einer tatsächlichen Prüfung.]</p>
<h2>Nicht barrierefreie Inhalte</h2>
<p>[Hier: bekannte Mängel mit Begründung und gegebenenfalls Alternativen.]</p>
<h2>Erstellung dieser Erklärung</h2>
<p>[Hier: Datum der Erstellung und der letzten Überprüfung, Prüfmethode (z. B. Selbstbewertung).]</p>
<h2>Feedback und Kontakt</h2>
<p>Barrieren auf dieser Website können Sie über das Formular „Barriere melden“ im Seitenfuß melden. [Hier: weitere Kontaktangaben – fiktiv.]</p>
<h2>Schlichtungsverfahren</h2>
<p>[Hier: Hinweis auf die zuständige Schlichtungsstelle – bei einer echten Landesbehörde nach dem jeweiligen Landesrecht; hier als Muster.]</p>',
  ],
  'leichte-sprache' => [
    'title' => 'Leichte Sprache',
    'description' => 'Informationen über diese Internet-Seite in Leichter Sprache.',
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
    'description' => 'Informationen über diese Website in Deutscher Gebärdensprache (Muster, noch ohne Videos).',
    'menu' => 'footer', 'weight' => 4,
    'body' => '
<p><strong>Hinweis: Diese Seite ist ein Muster.</strong> Hier stehen später Videos in Deutscher Gebärdensprache. Zurzeit gibt es noch keine Videos.</p>
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
    'description' => 'Impressum: Angaben zum tatsächlichen Betreiber dieser Musterseite.',
    'menu' => 'footer', 'weight' => 5,
    'body' => '
<p>[Hier echte Angaben des tatsächlichen Betreibers]</p>
<h2>Angaben gemäß § 5 DDG</h2>
<p>[Hier echte Angaben des tatsächlichen Betreibers]</p>
<h2>Kontakt</h2>
<p>[Hier echte Angaben des tatsächlichen Betreibers]</p>
<h2>Verantwortlich für den Inhalt</h2>
<p>[Hier echte Angaben des tatsächlichen Betreibers]</p>',
  ],
  'datenschutz' => [
    'title' => 'Datenschutz',
    'description' => 'Datenschutzerklärung: Verarbeitung personenbezogener Daten auf dieser Musterseite.',
    'menu' => 'footer', 'weight' => 6,
    'body' => '
<p>[Hier echte Angaben des tatsächlichen Betreibers]</p>
<h2>Verantwortliche Stelle</h2>
<p>[Hier echte Angaben des tatsächlichen Betreibers]</p>
<h2>Hosting</h2>
<p>[Hier echte Angaben des tatsächlichen Betreibers]</p>
<h2>Server-Logdateien</h2>
<p>[Hier echte Angaben des tatsächlichen Betreibers]</p>
<h2>Formular „Barriere melden“</h2>
<p>[Hier echte Angaben des tatsächlichen Betreibers]</p>
<h2>Ihre Rechte</h2>
<p>[Hier echte Angaben des tatsächlichen Betreibers]</p>',
  ],
];
