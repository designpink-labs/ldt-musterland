<?php

/**
 * @file
 * Meldungen für den Bereich "Aktuelles" (Inhaltstyp "meldung").
 *
 * Wird von scripts/create-meldungen.php gelesen.
 * - datum: Veröffentlichungsdatum des (fiktiven) LDT, nicht das Ereignisdatum.
 * - teaser: Zusammenfassung; Meta-Beschreibung = teaser + " – Musterseite einer
 *   fiktiven Behörde".
 * - body: Marken wie in pages.php ({{link:SCHLÜSSEL|Text}} usw.).
 * - quellen: [Adresse, Linktext, Sprache der Quelle]. Bei 'en' bekommt der
 *   Link lang="en" und hreflang="en", das Template ergänzt "(englisch)".
 */

return [
  'en-301-549' => [
    'title' => 'Europäische Norm setzt jetzt auf WCAG 2.2',
    'datum' => '2026-10-09',
    'teaser' => 'Die überarbeitete Norm EN 301 549 V4.1.1 macht WCAG 2.2 zum Maßstab für barrierefreie Websites und Dokumente. Rechtlich verbindlich ist sie noch nicht. Das LDT empfiehlt trotzdem, schon jetzt danach zu planen.',
    'body' => '
<p>Im September 2026 ist die neue Fassung der europäischen Norm EN 301 549 erschienen. Sie legt fest, was „barrierefrei“ für Websites, Software und digitale Dokumente technisch bedeutet. Die wichtigste Änderung: Statt WCAG 2.1 gilt jetzt WCAG 2.2 als Grundlage.</p>
<h2>Was neu ist</h2>
<p>WCAG 2.2 bringt sechs neue Anforderungen auf den Stufen A und AA:</p>
<ul>
  <li><strong>Fokus nicht vollständig verdeckt:</strong> Das gerade ausgewählte Element darf nicht ganz von Bannern oder fixierten Leisten verdeckt sein.</li>
  <li><strong>Ziehbewegungen:</strong> Was sich nur durch Ziehen bedienen lässt, braucht eine Alternative, etwa einen Knopf.</li>
  <li><strong>Zielgröße:</strong> Klickflächen müssen mindestens 24&nbsp;×&nbsp;24&nbsp;Pixel groß sein oder genug Abstand haben.</li>
  <li><strong>Konsistente Hilfe:</strong> Hilfeangebote stehen auf allen Seiten an derselben Stelle.</li>
  <li><strong>Redundante Eingaben:</strong> Bereits eingegebene Daten muss man nicht noch einmal eintippen.</li>
  <li><strong>Barrierefreie Anmeldung:</strong> Ein Login darf kein Rätsel und kein Merken von Passwörtern verlangen, ohne Alternative.</li>
</ul>
<p>Das veraltete Kriterium 4.1.1 („Syntaxanalyse“) entfällt.</p>
<h2>Was jetzt gilt</h2>
<p>Rechtlich maßgeblich bleibt vorerst die Vorgängerfassung V3.2.1 mit WCAG 2.1. Das ändert sich erst, wenn die EU-Kommission die neue Fassung im Amtsblatt veröffentlicht. Eine neue Frist ist damit nicht verbunden.</p>
<h2>Unsere Empfehlung</h2>
<p>Planen Sie neue Websites und Ausschreibungen schon jetzt nach WCAG 2.2. Die neuen Anforderungen sind überschaubar, und spätere Nacharbeiten kosten mehr. Bei Fragen hilft Ihnen Referat 3 – Beratung und Schulung.</p>',
    'quellen' => [
      ['https://accessible-eu-centre.ec.europa.eu/content-corner/news/european-accessibility-standard-en-301-549-has-been-updated-2026-09-07_en', 'AccessibleEU: The European accessibility standard EN 301 549 has been updated', 'en'],
    ],
  ],
  'bfsg' => [
    'title' => 'Ein Jahr Barrierefreiheitsstärkungsgesetz',
    'datum' => '2026-06-30',
    'teaser' => 'Seit dem 28. Juni 2025 müssen auch Unternehmen viele digitale Angebote barrierefrei gestalten. Was das für die Landesverwaltung bedeutet, obwohl das Gesetz sie nicht direkt betrifft.',
    'body' => '
<p>Das Barrierefreiheitsstärkungsgesetz (BFSG) setzt den <span lang="en">European Accessibility Act</span> der EU in deutsches Recht um. Es gilt seit dem 28. Juni 2025 vor allem für Unternehmen, zum Beispiel für Online-Shops, Banken und Anbieter von E-Books. Maßstab ist wie bei Behörden die Norm EN 301 549 mit WCAG 2.1 in der Stufe AA.</p>
<h2>Wer kontrolliert</h2>
<p>Die Einhaltung überwacht die Marktüberwachungsstelle der Länder für die Barrierefreiheit von Produkten und Dienstleistungen (MLBF) in Magdeburg. Sie ist eine gemeinsame Einrichtung aller Länder und hat im September 2025 ihre Arbeit aufgenommen. Sie ist als Anstalt des öffentlichen Rechts organisiert. Sie geht Beschwerden nach und prüft auch selbst. Bis Juni 2026 gingen bei ihr knapp 700 Meldungen ein. Bei Verstößen drohen Bußgelder bis zu 100.000 Euro.</p>
<h2>Was das für die Landesverwaltung heißt</h2>
<p>Für Behörden gilt weiterhin das Landesrecht zur barrierefreien Informationstechnik. Das BFSG wirkt aber indirekt:</p>
<ul>
  <li>Viele Dienstleister kennen die Anforderungen jetzt besser. Fordern Sie Barrierefreiheit in Ausschreibungen deshalb ausdrücklich und prüfbar ein.</li>
  <li>Bürgerinnen und Bürger erwarten zunehmend, dass digitale Angebote barrierefrei sind, egal ob vom Online-Shop oder vom Amt.</li>
  <li>Auch Dokumente wie Formulare und Bescheide zählen. Barrierefreie PDFs sind kein Sonderfall mehr.</li>
</ul>
<p>Arbeitshilfen dazu finden Sie unter {{link:dokumente|Barrierefreie Dokumente}} und {{link:arbeitshilfe|Arbeitshilfe Redaktion}}.</p>',
    'quellen' => [
      ['https://presse.sachsen-anhalt.de/wp-content/uploads/pdf/ministerium-fur-arbeit-soziales-gesundheit-und-gleichstellung_01_06_2026_Pressemitteilung_zugang-zu-modernen-produkten-und-dienstleistungen-fuer-alle-neue-marktueberwachungsbehoerde-in-magdeburg-formiert-sich.pdf', 'Ministerium für Arbeit, Soziales, Gesundheit und Gleichstellung Sachsen-Anhalt: Neue Marktüberwachungsbehörde in Magdeburg formiert sich (Pressemitteilung, 1. Juni 2026, PDF)', 'de'],
      ['https://www.axes4.com/de/blog/post/2026/bfsg-in-der-praxis-was-sich-seit-dem-stichtag-getan-hat', 'axes4: BFSG in der Praxis – Was sich seit dem Stichtag getan hat (Juni 2026)', 'de'],
    ],
  ],
  'ki-suche' => [
    'title' => 'KI-Suche: Was der KI-Modus von Google für Behördenseiten bedeutet',
    'datum' => '2026-10-14',
    'teaser' => 'Seit einem Jahr antwortet Google in Deutschland auf Wunsch direkt per KI, ohne klassische Trefferliste. Behördenseiten müssen deshalb so geschrieben sein, dass KI-Systeme sie richtig wiedergeben.',
    'body' => '
<p>Seit Oktober 2025 gibt es den KI-Modus der Google-Suche auch auf Deutsch. Statt einer Liste mit Links formuliert eine KI direkt eine Antwort und nennt dazu Quellen. Ähnlich arbeiten Assistenten wie ChatGPT oder Perplexity. Viele Menschen klicken dadurch seltener auf die Websites selbst.</p>
<h2>Warum das Behörden betrifft</h2>
<p>Wer wissen will, wie man Wohngeld beantragt, bekommt die Antwort zunehmend von einer KI. Ob sie stimmt, hängt auch davon ab, wie klar die offizielle Seite geschrieben ist. Veraltete oder widersprüchliche Angaben übernimmt die KI unter Umständen ungeprüft.</p>
<h2>Was Redaktionen tun können</h2>
<ul>
  <li>Die wichtigste Antwort in den ersten Absatz schreiben.</li>
  <li>Fristen, Gebühren und Zuständigkeiten eindeutig und an einer Stelle nennen.</li>
  <li>Seiten mit Datum und „Stand“ versehen und regelmäßig prüfen.</li>
  <li>Ab und zu selbst testen: Was antworten KI-Assistenten auf typische Fragen zu Ihren Leistungen?</li>
</ul>
<p>Vieles davon ist gute Redaktionsarbeit und hilft auch der Barrierefreiheit. Mehr dazu auf unserer Seite {{link:seo-geo|SEO und GEO}}.</p>',
    'quellen' => [
      ['https://onlinemarketing.de/technologie/google-search-ai-mode-startet-in-deutschland', 'onlinemarketing.de: Endlich, oder doch nicht?! Googles AI Mode startet in Deutschland (8. Oktober 2025)', 'de'],
    ],
  ],
];
