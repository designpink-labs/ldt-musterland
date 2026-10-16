<?php

/**
 * @file
 * Seitenstruktur und Texte der Musterseite "LDT Musterland".
 *
 * Wird von scripts/create-content.php gelesen.
 *
 * - {{link:SCHLÜSSEL|Linktext}} wird beim Anlegen in einen Linkit-Link
 *   umgewandelt (data-entity-uuid), der unabhängig vom Pfad funktioniert.
 * - 'summary': Zusammenfassung (Kartentext auf der Startseite). Die
 *   Meta-Beschreibung ist 'summary' plus " – Musterseite einer fiktiven
 *   Behörde", außer 'description' ist ausdrücklich gesetzt.
 * - 'promote' => TRUE: Seite erscheint als Karte auf der Startseite.
 * - Hinweisboxen: <div class="hinweis hinweis--info">…</div> (einzige
 *   erlaubte Klasse im Textformat).
 * - Keine festen internen Pfade wie "/impressum" in Texte schreiben.
 */

return [
  'start' => [
    'title' => 'Start',
    'summary' => 'Das Landesamt für Digitale Teilhabe Musterland: Barrierefreiheit, Online-Redaktion, Web-Optimierung und Schulungen.',
    'body' => '
<p>Willkommen beim Landesamt für Digitale Teilhabe Musterland (LDT). Wir sorgen dafür, dass alle Menschen die digitalen Angebote der Landesverwaltung nutzen können – unabhängig davon, ob sie gut sehen, hören oder lesen können.</p>
<p>Dafür beraten wir die Dienststellen des Landes, prüfen ihre Websites und Dokumente und schulen ihre Beschäftigten.</p>
<h2>Barrierefreiheit dieser Website</h2>
<p>Auch diese Website soll für alle zugänglich sein. Sie richtet sich nach den <span lang="en">Web Content Accessibility Guidelines</span> (WCAG) 2.1 in der Stufe AA. Was schon erfüllt ist und was noch fehlt, steht in unserer {{link:erklaerung|Erklärung zur Barrierefreiheit}}.</p>
<p>Wenn Sie auf ein Hindernis stoßen, melden Sie es uns bitte über das Formular {{form:barriere_melden|Barriere melden}}.</p>',
  ],

  // Hauptmenü: Barrierefreiheit.
  'barrierefreiheit' => [
    'title' => 'Barrierefreiheit',
    'promote' => TRUE,
    'summary' => 'Digitale Barrierefreiheit in der Landesverwaltung: Rechtsrahmen, Dokumente, Leichte Sprache, Video und Gebärdensprache.',
    'menu' => 'main', 'weight' => 1,
    'body' => '
<p>Digitale Barrierefreiheit bedeutet: Alle Menschen können Websites, Apps und Dokumente der Verwaltung ohne fremde Hilfe nutzen. Das betrifft zum Beispiel Menschen, die nicht oder wenig sehen oder hören, Menschen, die keine Maus bedienen können, und Menschen, die Texte schwer verstehen. Barrierefreiheit hilft aber allen: Klare Strukturen und verständliche Texte machen jedes Angebot besser.</p>
<p>Das Landesamt für Digitale Teilhabe Musterland (LDT) berät die Dienststellen der Landesverwaltung, prüft ihre digitalen Angebote und schult ihre Beschäftigten.</p>
<h2>Warum Barrierefreiheit für Behörden Pflicht ist</h2>
<p>Öffentliche Stellen müssen ihre Websites, mobilen Anwendungen und elektronischen Dokumente barrierefrei gestalten. Grundlage ist die EU-Richtlinie 2016/2102. Im Bund setzen das Behindertengleichstellungsgesetz (BGG) und die Barrierefreie-Informationstechnik-Verordnung (BITV 2.0) diese Richtlinie um, im Musterland das Landesrecht zur barrierefreien Informationstechnik.</p>
<p>Was „barrierefrei“ technisch heißt, legt die europäische Norm EN 301 549 fest. Für Webinhalte verweist sie auf die <span lang="en">Web Content Accessibility Guidelines</span> (WCAG) – die internationalen Richtlinien des <span lang="en">World Wide Web Consortium</span> (W3C). Maßgeblich ist die Version WCAG 2.1 in der Konformitätsstufe AA. Die neuere WCAG 2.2 empfehlen wir schon heute als Orientierung.</p>
<p>Zur Pflicht gehören außerdem:</p>
<ul>
  <li>eine Erklärung zur Barrierefreiheit mit einer Möglichkeit, Barrieren zu melden,</li>
  <li>Informationen in Deutscher Gebärdensprache und in Leichter Sprache.</li>
</ul>
<p>Seit dem 28. Juni 2025 gilt zusätzlich das Barrierefreiheitsstärkungsgesetz (BFSG). Es verpflichtet vor allem Unternehmen, zum Beispiel Online-Shops und Banken. Für Behörden bleibt das Landesrecht maßgeblich.</p>
<h2>Unsere Themen</h2>
<ul>
  <li>{{link:dokumente|Barrierefreie Dokumente}}: PDF- und Office-Dateien, die alle lesen können</li>
  <li>{{link:leichte-sprache-fach|Leichte Sprache}}: Texte für Menschen mit Lernschwierigkeiten</li>
  <li>{{link:video|Video und Untertitel}}: Videos für Menschen, die nicht hören oder nicht sehen</li>
  <li>{{link:gebaerdensprache-fach|Gebärdensprache}}: Informationen in Deutscher Gebärdensprache</li>
</ul>
<h2>So unterstützen wir Dienststellen</h2>
<ul>
  <li><strong>Beratung:</strong> Wir helfen Ihnen, Barrierefreiheit von Anfang an einzuplanen, zum Beispiel in Ausschreibungen für neue Websites.</li>
  <li><strong>Prüfung:</strong> Wir prüfen Websites und Dokumente nach den Anforderungen der WCAG und der EN 301 549. Dazu gehören automatische Tests, die Bedienung nur mit der Tastatur und Tests mit Screenreadern. Ein Screenreader ist eine Software, die Bildschirminhalte vorliest.</li>
  <li><strong>Schulung:</strong> In unseren {{link:schulungen|Schulungen zur Barrierefreiheit}} lernen Redaktionen, barrierefreie Inhalte zu erstellen.</li>
  <li><strong>Arbeitshilfen:</strong> Checklisten und Vorlagen finden Sie in der {{link:arbeitshilfe|Arbeitshilfe für Redaktionen}}.</li>
</ul>
<h2>Barriere gefunden?</h2>
<p>Wenn Sie auf dieser Website auf ein Hindernis stoßen, melden Sie es uns über das Formular {{form:barriere_melden|Barriere melden}}. Wie barrierefrei diese Website ist, steht in unserer {{link:erklaerung|Erklärung zur Barrierefreiheit}}.</p>',
  ],
  'dokumente' => [
    'title' => 'Barrierefreie Dokumente',
    'summary' => 'Barrierefreie PDF-Dokumente nach PDF/UA: Merkmale, Prüfung mit PAC und Tipps für barrierefreie Word-Dokumente.',
    'menu' => 'main', 'parent' => 'barrierefreiheit', 'weight' => 1,
    'body' => '
<p>Anträge, Merkblätter und Berichte veröffentlicht die Verwaltung oft als PDF. Ein barrierefreies PDF können alle Menschen lesen – auch wenn sie einen Screenreader nutzen oder die Schrift stark vergrößern.</p>
<h2>Was ein barrierefreies PDF ausmacht</h2>
<p>Der internationale Standard für barrierefreie PDF-Dateien heißt PDF/UA (ISO 14289, „<span lang="en">Universal Accessibility</span>“). Ein PDF nach PDF/UA hat unter anderem:</p>
<ul>
  <li><strong>Tags:</strong> unsichtbare Strukturinformationen, die Überschriften, Absätze, Listen und Tabellen kennzeichnen,</li>
  <li>eine <strong>logische Lesereihenfolge</strong>,</li>
  <li><strong>Alternativtexte</strong> für alle Bilder und Grafiken, die etwas aussagen – reine Schmuckelemente werden als „Artefakt“ ausgeblendet,</li>
  <li><strong>Tabellen mit Kopfzellen</strong>, damit Screenreader die Zuordnung vorlesen können,</li>
  <li>einen <strong>Dokumenttitel</strong> und die <strong>Dokumentsprache</strong> in den Metadaten,</li>
  <li><strong>Lesezeichen</strong> bei längeren Dokumenten,</li>
  <li><strong>beschriftete Formularfelder</strong>, wenn man das PDF ausfüllen kann.</li>
</ul>
<h2>Prüfen mit PAC</h2>
<p>Mit dem kostenlosen <span lang="en">PDF Accessibility Checker</span> (PAC) prüfen Sie, ob ein PDF die technischen Anforderungen von PDF/UA erfüllt. PAC findet aber nicht alles: Ob ein Alternativtext sinnvoll ist oder die Lesereihenfolge stimmt, muss ein Mensch beurteilen. Wir prüfen deshalb zusätzlich mit einem Screenreader.</p>
<h2>Barrierefreiheit beginnt im Ausgangsdokument</h2>
<p>Ein PDF wird am einfachsten barrierefrei, wenn schon die Word-Datei sauber aufgebaut ist:</p>
<ul>
  <li>Nutzen Sie Formatvorlagen für Überschriften, statt Text nur fett und groß zu setzen.</li>
  <li>Hinterlegen Sie Alternativtexte für Bilder direkt in Word.</li>
  <li>Legen Sie bei Tabellen eine Kopfzeile fest.</li>
  <li>Exportieren Sie das PDF mit Strukturinformationen: Unter Windows aktivieren Sie in den PDF-Optionen „Dokumentstrukturtags für Barrierefreiheit“. Auf dem Mac wählen Sie beim Speichern als PDF „Am besten für elektronische Verteilung und Barrierefreiheit“.</li>
</ul>
<h2>Beispiel: vorher und nachher</h2>
<p>Das Merkblatt „Barrierefreie Dokumente erstellen“ gibt es hier in zwei Fassungen. Der Inhalt ist gleich, nur der technische Aufbau unterscheidet sich. Die Grafiken zeigen, welche Struktur ein Screenreader jeweils vorfindet.</p>
<h3>Vorher: einfacher Export ohne Tags</h3>
<p><strong>Achtung:</strong> Diese Fassung ist absichtlich nicht barrierefrei. Sie dient nur als Beispiel für typische Fehler.</p>
{{img:Struktur-vorher.png|Vorher: Das PDF hat keine Tags, keine Lesezeichen, keinen Titel und die falsche Sprache Englisch. Screenreader erkennen darin keine Überschriften, Listen oder Tabellen.}}
<ul>
  <li>{{file:Merkblatt-vorher.pdf|Merkblatt Barrierefreie Dokumente, nicht barrierefreies Beispiel}}</li>
</ul>
<h3>Nachher: überarbeitet nach PDF/UA</h3>
{{img:Struktur-nachher.png|Nachher: Das PDF ist vollständig getaggt – mit einer Hauptüberschrift H1 und vier Zwischenüberschriften H2, einer Liste, einer Abbildung mit Alternativtext, einer Tabelle mit Kopfzeile und einem Link. Die Sprache ist Deutsch, Titel und Lesezeichen sind vorhanden.}}
<ul>
  <li>{{file:Merkblatt-nachher.pdf|Merkblatt Barrierefreie Dokumente, barrierefrei}}</li>
</ul>
<h3>Ergebnis der Prüfung</h3>
<p>Beide Fassungen wurden mit dem freien Prüfprogramm veraPDF (Version 1.30) gegen PDF/UA-1 geprüft. Die Vorher-Fassung fällt durch: 61 Inhaltselemente sind weder getaggt noch als Artefakt gekennzeichnet, außerdem fehlen Strukturbaum, Metadaten und die Anzeige des Dokumenttitels. Die Nachher-Fassung besteht alle 106 Prüfregeln ohne einen einzigen Fehler.</p>
<h2>Braucht es überhaupt ein PDF?</h2>
<p>Inhalte, die Menschen am Bildschirm lesen, gehören besser direkt auf eine Webseite. PDF eignet sich für Dokumente zum Ausdrucken oder Archivieren. Wenn Sie ein PDF verlinken, nennen Sie Format und Größe im Linktext, zum Beispiel „Merkblatt Barrierefreiheit (PDF, 240 KB)“.</p>
<p>Eine barrierefreie Word-Vorlage finden Sie in der {{link:arbeitshilfe|Arbeitshilfe für Redaktionen}}.</p>',
  ],
  'leichte-sprache-fach' => [
    'title' => 'Leichte Sprache',
    'summary' => 'Leichte Sprache in der Verwaltung: Unterschied zur Einfachen Sprache, wichtigste Regeln und Prüfung durch die Zielgruppe.',
    'menu' => 'main', 'parent' => 'barrierefreiheit', 'weight' => 2,
    'body' => '
<p>Leichte Sprache ist eine besonders verständliche Form des Deutschen. Sie richtet sich vor allem an Menschen mit Lernschwierigkeiten. Sie hilft aber auch Menschen mit Demenz, Menschen, die noch wenig Deutsch können, und allen, die einen Text schnell erfassen wollen.</p>
<h2>Leichte Sprache und Einfache Sprache</h2>
<p>Die beiden Begriffe klingen ähnlich, meinen aber Verschiedenes:</p>
<ul>
  <li><strong>Leichte Sprache</strong> folgt festen Regeln. Ein Text in Leichter Sprache ist erst fertig, wenn Menschen aus der Zielgruppe ihn geprüft haben. Verbreitet sind die Regeln des Netzwerks Leichte Sprache. Empfehlungen enthält auch die DIN SPEC 33429.</li>
  <li><strong>Einfache Sprache</strong> ist weniger streng. Sie liegt näher an der Standardsprache und richtet sich an ein breites Publikum. Die Norm DIN ISO 24495-1 beschreibt Grundsätze dafür.</li>
</ul>
<h2>Die wichtigsten Regeln</h2>
<ul>
  <li>Schreiben Sie kurze Sätze. Jeder Satz enthält nur eine Aussage.</li>
  <li>Benutzen Sie bekannte Wörter. Erklären Sie schwierige Wörter.</li>
  <li>Trennen Sie lange Wörter mit einem Bindestrich oder einem Mediopunkt, zum Beispiel „Bundes-Tag“ oder „Bundes·tag“.</li>
  <li>Schreiben Sie aktiv und benutzen Sie Verben statt Hauptwörter.</li>
  <li>Vermeiden Sie den Genitiv, den Konjunktiv und Verneinungen.</li>
  <li>Schreiben Sie Zahlen als Ziffern.</li>
  <li>Beginnen Sie jeden Satz in einer neuen Zeile. Bilder können beim Verstehen helfen.</li>
</ul>
<h2>Prüfung durch die Zielgruppe</h2>
<p>Die Prüfung ist das wichtigste Qualitätsmerkmal. Menschen mit Lernschwierigkeiten lesen den Text und sagen, was sie nicht verstehen. Erst dann wird er veröffentlicht. Das LDT vermittelt Dienststellen Kontakte zu Büros für Leichte Sprache, die mit Prüfgruppen arbeiten.</p>
<h2>Pflicht für Behörden-Websites</h2>
<p>Nach der BITV 2.0 des Bundes müssen Behörden auf ihrer Website in Leichter Sprache erklären:</p>
<ul>
  <li>was auf der Website steht,</li>
  <li>wie man sich auf der Website zurechtfindet,</li>
  <li>was in der Erklärung zur Barrierefreiheit steht,</li>
  <li>wo es weitere Informationen in Leichter Sprache gibt.</li>
</ul>
<p>Das Landesrecht vieler Länder sieht das ebenso vor. Unsere eigenen Informationen finden Sie auf der Seite {{link:leichte-sprache|Informationen in Leichter Sprache}}.</p>
<h2>Beispiel</h2>
<p>Der Ausgangstext ist ein Abschnitt aus einem fiktiven Merkblatt „Barrieren melden“. Er richtet sich an Bürgerinnen und Bürger – für sie wird Leichte Sprache gemacht.</p>
<div class="sprachvergleich">
<div>
<h3>Standardsprache</h3>
<p>Sofern Ihnen bei der Nutzung von Internetauftritten oder mobilen Anwendungen öffentlicher Stellen des Musterlandes Mängel hinsichtlich der barrierefreien Zugänglichkeit auffallen, haben Sie die Möglichkeit, diese der jeweiligen öffentlichen Stelle über den in der Erklärung zur Barrierefreiheit bereitgestellten Feedback-Mechanismus mitzuteilen. Die öffentliche Stelle ist verpflichtet, Ihnen innerhalb einer angemessenen Frist eine Rückmeldung zu erteilen. Erfolgt keine oder keine zufriedenstellende Rückmeldung, steht Ihnen die Durchführung eines Schlichtungsverfahrens bei der Schlichtungsstelle bei der oder dem Landesbeauftragten für die Belange von Menschen mit Behinderungen offen. Das Verfahren ist für Sie kostenfrei; die Beauftragung eines Rechtsbeistands ist nicht erforderlich.</p>
</div>
<div>
<h3>Leichte Sprache</h3>
<p><strong>Sie haben ein Problem mit einer Internet·seite?<br>Das können Sie tun.</strong></p>
<p>Sie benutzen eine Internet·seite von einem Amt im Musterland.<br>Die Internet·seite soll barriere·frei sein.<br>Barriere·frei heißt:<br>Alle Menschen können die Internet·seite benutzen.<br>Ohne Hilfe.</p>
<p>Sie haben ein Problem mit der Internet·seite?<br>Zum Beispiel:<br>Sie können einen Text schlecht lesen.<br>Oder ein Knopf funktioniert mit der Tastatur nicht.</p>
<p>Dann sagen Sie es dem Amt.<br>Jede Internet·seite von einem Amt hat eine Erklärung zur Barriere·freiheit.<br>Dort steht: So erreichen Sie das Amt.<br>Zum Beispiel mit einem Formular.<br>Das Amt muss Ihnen dann antworten.</p>
<p>Das Amt antwortet nicht?<br>Oder die Antwort hilft Ihnen nicht?<br>Dann können Sie sich bei der Schlichtungs·stelle melden.<br>Die Schlichtungs·stelle hilft Ihnen und dem Amt.<br>Sie suchen zusammen eine Lösung.</p>
<p><strong>Wichtig:</strong><br>Die Schlichtungs·stelle ist kosten·los.<br>Sie brauchen dafür keinen Anwalt und keine Anwältin.</p>
</div>
</div>
<h3>Welche Regeln angewendet wurden</h3>
<ul>
  <li>Ein Gedanke pro Satz, jeder Satz in einer neuen Zeile: Aus 4 langen Sätzen wurden 23 kurze.</li>
  <li>Fachwörter ersetzt oder erklärt: Aus „Feedback-Mechanismus“ wird „Formular“, „barriere·frei“ und „Schlichtungs·stelle“ werden im Text erklärt.</li>
  <li>Lange Wörter gegliedert mit dem Mediopunkt: Internet·seite, Schlichtungs·stelle.</li>
  <li>Direkte Ansprache und Fragen statt Bedingungssätzen („Sofern …“, „Erfolgt keine …“).</li>
  <li>Bewusst weggelassen: die „angemessene Frist“ und die genaue Zuständigkeit der oder des Landesbeauftragten. Leichte Sprache heißt auch, auf das zu reduzieren, was Leserinnen und Leser zum Handeln brauchen. Diese Auswahl muss die Fachabteilung mittragen.</li>
</ul>
<div class="hinweis hinweis--info">
<p><strong>Hinweis:</strong> Dieser Text wurde nicht von einer Prüfgruppe geprüft.</p>
</div>',
  ],
  'video' => [
    'title' => 'Video & Untertitel',
    'summary' => 'Videos barrierefrei veröffentlichen: Untertitel im WebVTT-Format, Transkript und Audiodeskription.',
    'menu' => 'main', 'parent' => 'barrierefreiheit', 'weight' => 3,
    'body' => '
<p>Videos erreichen viele Menschen. Barrierefrei sind sie aber erst, wenn alle sie nutzen können: Gehörlose und schwerhörige Menschen brauchen Untertitel. Blinde Menschen brauchen eine Beschreibung dessen, was im Bild passiert.</p>
<h2>Was die WCAG verlangen</h2>
<p>Für aufgezeichnete Videos fordern die WCAG 2.1 auf Stufe AA:</p>
<ul>
  <li><strong>Untertitel</strong> für alles Gesprochene und für wichtige Geräusche (Kriterium 1.2.2),</li>
  <li>eine <strong>Audiodeskription</strong>: Eine Sprecherstimme beschreibt in Sprechpausen wichtige Bildinhalte (Kriterien 1.2.3 und 1.2.5).</li>
</ul>
<p>Live-Videos brauchen Live-Untertitel (Kriterium 1.2.4). Startet ein Video automatisch mit Ton, muss man den Ton anhalten können (Kriterium 1.4.2). Am besten startet es gar nicht von selbst.</p>
<h2>Untertitel richtig erstellen</h2>
<p>Gute Untertitel geben nicht nur wieder, was gesprochen wird. Sie kennzeichnen auch, wer spricht, und beschreiben wichtige Geräusche, zum Beispiel „[Telefon klingelt]“. Zeigen Sie höchstens zwei Zeilen gleichzeitig, und lassen Sie jede Einblendung lange genug stehen.</p>
<p>Auf Websites ist das Format WebVTT üblich (<span lang="en">Web Video Text Tracks</span>, Dateiendung .vtt). Der Browser zeigt die Untertitel dann im Videoplayer an, und man kann sie ein- und ausschalten. Automatisch erzeugte Untertitel sind nur ein Entwurf: Prüfen und korrigieren Sie sie immer.</p>
<h2>Transkript</h2>
<p>Ein Transkript ist die vollständige Textfassung eines Videos, mit Geräuschen und Bildbeschreibungen. Es hilft Menschen, die taubblind sind oder lieber lesen. Suchmaschinen können es außerdem finden.</p>
<h2>Audiodeskription einplanen</h2>
<p>Am einfachsten planen Sie ein Video so, dass alles Wichtige auch gesagt wird. Ein Beispiel: Die Sprecherin nennt die Adresse, statt sie nur einzublenden. Dann braucht das Video oft keine zusätzliche Audiodeskription.</p>
<h2>Beispielvideo</h2>
<div class="hinweis hinweis--info">
<p><strong>Hinweis:</strong> Das Beispiel wird hier ergänzt.</p>
<p>Gezeigt wird ein kurzes Erklärvideo von ein bis zwei Minuten: „Was macht das LDT?“. Es hat Untertitel im WebVTT-Format mit Sprecher- und Geräuschangaben, darunter steht das vollständige Transkript. Das Video startet nicht von selbst und lässt sich mit der Tastatur bedienen.</p>
</div>',
  ],
  'gebaerdensprache-fach' => [
    'title' => 'Gebärdensprache',
    'summary' => 'Deutsche Gebärdensprache auf Behörden-Websites: rechtliche Anforderungen und Tipps für gute Gebärdensprach-Videos.',
    'menu' => 'main', 'parent' => 'barrierefreiheit', 'weight' => 4,
    'body' => '
<p><strong>Hinweis: Diese Seite ist ein Muster.</strong> Auf dieser Website gibt es noch keine Videos in Deutscher Gebärdensprache.</p>
<p>Die Deutsche Gebärdensprache (DGS) ist eine eigenständige Sprache mit eigener Grammatik. Seit 2002 ist sie in Deutschland gesetzlich als Sprache anerkannt. Für viele gehörlose Menschen ist sie die Muttersprache. Geschriebenes Deutsch ist für sie eine Fremdsprache. Untertitel allein reichen deshalb oft nicht aus.</p>
<h2>Was Behörden-Websites bieten müssen</h2>
<p>Nach der BITV 2.0 des Bundes erklären Behörden auf ihrer Website in DGS:</p>
<ul>
  <li>was auf der Website steht,</li>
  <li>wie man sich auf der Website zurechtfindet,</li>
  <li>was in der Erklärung zur Barrierefreiheit steht,</li>
  <li>wo es weitere Informationen in Gebärdensprache gibt.</li>
</ul>
<p>Das Landesrecht vieler Länder sieht das ebenso vor. Die Videos sind über einen gut sichtbaren Link auf der Startseite erreichbar.</p>
<h2>So sieht ein gutes Gebärdensprach-Video aus</h2>
<ul>
  <li>Gebärdet wird von gehörlosen Gebärdensprachlerinnen und -sprachlern oder von qualifizierten Dolmetscherinnen und Dolmetschern.</li>
  <li>Gesicht und Hände sind gut sichtbar. Die Mimik gehört zur Grammatik der DGS.</li>
  <li>Der Hintergrund ist ruhig und einfarbig, die Kleidung hebt sich deutlich davon ab.</li>
  <li>Jedes Video hat einen eindeutigen Titel und lässt sich mit der Tastatur starten.</li>
</ul>
<h2>Gebärdensprach-Videos beauftragen</h2>
<ol>
  <li>Fassen Sie die Inhalte zuerst in klarer Standardsprache zusammen.</li>
  <li>Beauftragen Sie ein Übersetzungsteam, in dem gehörlose Fachleute mitarbeiten.</li>
  <li>Lassen Sie die Videos von gehörlosen Menschen abnehmen.</li>
  <li>Klären Sie die Bildrechte der Personen, die im Video zu sehen sind.</li>
</ol>
<h2>Beispiel</h2>
<div class="hinweis hinweis--info">
<p><strong>Hinweis:</strong> Das Beispiel wird hier ergänzt.</p>
<p>Gezeigt wird ein kurzes DGS-Video, in dem eine gehörlose Person die Aufgaben des LDT erklärt. Darunter steht der Inhalt als Text.</p>
</div>
<p>Unsere Informationen in Gebärdensprache finden Sie auf der Seite {{link:gebaerdensprache|Informationen in Gebärdensprache}}.</p>',
  ],

  // Hauptmenü: Online-Redaktion.
  'online-redaktion' => [
    'title' => 'Online-Redaktion',
    'promote' => TRUE,
    'summary' => 'Gute Texte, klare Seiten, barrierefreie Beiträge: So unterstützt das LDT die Online-Redaktionen der Landesverwaltung.',
    'menu' => 'main', 'weight' => 2,
    'body' => '
<p>Für viele Menschen ist die Website der erste Kontakt mit einer Behörde. Gute Online-Redaktion sorgt dafür, dass sie dort schnell finden, was sie suchen – und es auch verstehen.</p>
<p>Das LDT unterstützt die Online-Redaktionen der Dienststellen mit Leitlinien, Arbeitshilfen und Schulungen. Außerdem koordiniert es das Redaktionsnetzwerk der Landesverwaltung, das sich einmal im Quartal austauscht.</p>
<h2>Unsere Themen</h2>
<ul>
  <li>{{link:texte|Texte fürs Web}}: verständlich schreiben für Menschen, die am Bildschirm lesen</li>
  <li>{{link:arbeitshilfe|Arbeitshilfe für Redaktionen}}: Checkliste vor der Veröffentlichung</li>
  <li>{{link:social-media|Barrierefreie Social-Media-Beiträge}}: Bilder, Videos und Hashtags für alle</li>
</ul>
<h2>Vier Grundsätze für Behörden-Websites</h2>
<ul>
  <li><strong>Von den Nutzenden her denken:</strong> Fragen Sie sich bei jeder Seite, mit welcher Frage jemand hierherkommt. Beantworten Sie diese Frage zuerst.</li>
  <li><strong>Verständlich schreiben:</strong> Nutzen Sie Alltagssprache und erklären Sie Fachbegriffe beim ersten Vorkommen.</li>
  <li><strong>Aktuell bleiben:</strong> Jede Seite hat eine verantwortliche Person und ein Datum, an dem sie wieder geprüft wird.</li>
  <li><strong>Barrierefrei veröffentlichen:</strong> Überschriften, Alternativtexte und aussagekräftige Linktexte gehören zu jeder Veröffentlichung – nicht erst zur Nacharbeit.</li>
</ul>
<h2>Weiterlernen</h2>
<p>In unseren {{link:schulungen|Schulungen für Online-Redaktionen}} üben Sie das Schreiben fürs Web an eigenen Texten.</p>',
  ],
  'texte' => [
    'title' => 'Texte fürs Web',
    'summary' => 'Verständliche Webtexte für die Verwaltung: das Wichtigste zuerst, kurze Sätze, klare Gliederung – mit Beispiel.',
    'menu' => 'main', 'parent' => 'online-redaktion', 'weight' => 1,
    'body' => '
<p>Im Web lesen Menschen anders als auf Papier. Sie überfliegen die Seite, suchen nach Stichwörtern und springen zu dem Abschnitt, der sie betrifft. Gute Texte für Behörden-Websites nehmen darauf Rücksicht.</p>
<h2>Das Wichtigste zuerst</h2>
<p>Beginnen Sie mit der Antwort, nicht mit der Vorgeschichte. Was muss jemand tun, bis wann und wie? Hintergründe und Rechtsgrundlagen folgen danach. Dieses Prinzip heißt „umgekehrte Pyramide“.</p>
<h2>Kurz und klar</h2>
<ul>
  <li>Schreiben Sie Sätze mit höchstens 15 bis 20 Wörtern.</li>
  <li>Behandeln Sie in jedem Absatz nur einen Gedanken.</li>
  <li>Schreiben Sie aktiv: „Wir prüfen Ihren Antrag“ statt „Ihr Antrag wird geprüft“.</li>
  <li>Nutzen Sie Verben statt Hauptwörter: „beantragen“ statt „die Beantragung vornehmen“.</li>
  <li>Sprechen Sie Ihre Leserinnen und Leser direkt mit „Sie“ an.</li>
</ul>
<h2>Gut gliedern</h2>
<p>Zwischenüberschriften sagen, worum es im nächsten Abschnitt geht. Viele Menschen mit Screenreader springen von Überschrift zu Überschrift. Halten Sie deshalb die Reihenfolge der Ebenen ein und überspringen Sie keine. Aufzählungen machen Schritte und Voraussetzungen übersichtlich.</p>
<h2>Linktexte, die für sich stehen</h2>
<p>Ein Link sagt, wohin er führt: „Antrag auf Erstattung der Reisekosten (PDF, 120 KB)“ statt „hier klicken“. Screenreader können alle Links einer Seite als Liste vorlesen. Dann muss jeder Link auch ohne den umgebenden Text verständlich sein.</p>
<h2>Beispiel: vorher und nachher</h2>
<p><strong>Vorher:</strong> „Die Beantragung der Erstattung der Reisekosten hat unter Verwendung des hierfür vorgesehenen Vordrucks innerhalb einer Ausschlussfrist von sechs Monaten nach Beendigung der Dienstreise zu erfolgen.“</p>
<p><strong>Nachher:</strong> „Beantragen Sie die Erstattung Ihrer Reisekosten spätestens 6 Monate nach Ende der Dienstreise. Nutzen Sie dafür das Formular ‚Reisekostenabrechnung‘. Anträge, die später eingehen, können wir nicht mehr bearbeiten.“</p>
<p>Was sich geändert hat:</p>
<ul>
  <li>Die Handlung steht am Anfang, die Leserin wird direkt angesprochen.</li>
  <li>Ein langer Satz wurde zu drei kurzen Sätzen.</li>
  <li>„Beantragung“ wurde zum Verb „beantragen“, „Ausschlussfrist“ wird durch die Folge erklärt.</li>
</ul>
<p>Das Beispiel ist für diese Musterseite formuliert.</p>',
  ],
  'arbeitshilfe' => [
    'title' => 'Arbeitshilfe Redaktion',
    'summary' => 'Checkliste für Redaktionen: Struktur, Text, Links, Bilder und Dokumente vor der Veröffentlichung prüfen.',
    'menu' => 'main', 'parent' => 'online-redaktion', 'weight' => 2,
    'body' => '
<p>Diese Checkliste hilft den Redaktionen der Landesverwaltung, vor jeder Veröffentlichung die wichtigsten Punkte zu prüfen. Sie ersetzt keine vollständige Prüfung nach den WCAG, verhindert aber die häufigsten Barrieren.</p>
<h2>Checkliste vor der Veröffentlichung</h2>
<h3>Struktur</h3>
<ul>
  <li>Die Seite hat genau eine Hauptüberschrift, den Seitentitel.</li>
  <li>Die Zwischenüberschriften folgen in der richtigen Reihenfolge, ohne Ebenen zu überspringen.</li>
  <li>Aufzählungen sind als echte Listen formatiert, nicht mit Bindestrichen getippt.</li>
  <li>Tabellen enthalten nur Daten und haben eine Kopfzeile.</li>
</ul>
<h3>Text</h3>
<ul>
  <li>Das Wichtigste steht am Anfang.</li>
  <li>Abkürzungen sind beim ersten Vorkommen ausgeschrieben.</li>
  <li>Fremdsprachige Begriffe und Zitate sind mit ihrer Sprache gekennzeichnet.</li>
</ul>
<h3>Links</h3>
<ul>
  <li>Jeder Linktext ist auch ohne Zusammenhang verständlich.</li>
  <li>Links auf Dateien nennen Format und Größe.</li>
  <li>Links öffnen sich im selben Fenster.</li>
</ul>
<h3>Bilder</h3>
<ul>
  <li>Jedes Bild, das etwas aussagt, hat einen Alternativtext, der diese Aussage wiedergibt.</li>
  <li>Reine Schmuckbilder haben einen leeren Alternativtext, damit Screenreader sie überspringen.</li>
  <li>Text steht nicht in Bildern. Diagramme werden zusätzlich im Text erklärt.</li>
</ul>
<h3>Dokumente und Medien</h3>
<ul>
  <li>PDF-Dateien erfüllen PDF/UA. Mehr dazu auf der Seite {{link:dokumente|Barrierefreie Dokumente}}.</li>
  <li>Videos haben Untertitel und ein Transkript. Mehr dazu auf der Seite {{link:video|Video und Untertitel}}.</li>
</ul>
<h3>Zum Schluss</h3>
<ul>
  <li>Sehen Sie sich die Hinweise der automatischen Prüfung im Redaktionssystem an. Auf dieser Website prüft das Werkzeug Editoria11y die Seite schon beim Schreiben.</li>
  <li>Gehen Sie die Seite einmal nur mit der Tabulatortaste durch.</li>
</ul>
<h2>Downloads</h2>
<p>Die Checkliste gibt es auch als barrierefreies PDF auf einer DIN-A4-Seite, zum Ausdrucken oder Weitergeben. Die Dokumentvorlagen enthalten fertige Formatvorlagen für Überschriften, Listen, Tabellen und Hinweise. Die Dokumentsprache ist auf Deutsch eingestellt.</p>
<ul>
  <li>{{file:Checkliste-Redaktion.pdf|Checkliste vor der Veröffentlichung, barrierefrei}}</li>
  <li>{{file:LDT-Vorlage.dotx|Dokumentvorlage LDT Musterland für Microsoft Word}}</li>
  <li>{{file:LDT-Vorlage.ott|Dokumentvorlage LDT Musterland für LibreOffice Writer}}</li>
</ul>',
  ],
  'social-media' => [
    'title' => 'Social Media',
    'summary' => 'Barrierefreie Social-Media-Beiträge: Alternativtexte, Hashtags, Emojis, Untertitel und Datenschutz.',
    'menu' => 'main', 'parent' => 'online-redaktion', 'weight' => 3,
    'body' => '
<p>Über soziale Netzwerke erreicht die Verwaltung Menschen dort, wo sie sich ohnehin informieren. Auch dort gilt: Beiträge sollen alle verstehen und nutzen können.</p>
<h2>Barrierefreie Beiträge</h2>
<ul>
  <li><strong>Alternativtexte:</strong> Alle großen Plattformen haben ein eigenes Feld für die Bildbeschreibung. Füllen Sie es bei jedem Bild aus.</li>
  <li><strong>Hashtags in Binnenmajuskeln:</strong> Schreiben Sie #DigitaleTeilhabe statt #digitaleteilhabe. Dann lesen Screenreader die einzelnen Wörter richtig vor.</li>
  <li><strong>Emojis sparsam:</strong> Screenreader lesen jedes Emoji mit seinem Namen vor. Setzen Sie Emojis deshalb ans Ende eines Satzes und nicht als Aufzählungszeichen.</li>
  <li><strong>Keine Zierschriften:</strong> Fett oder kursiv wirkende Sonderzeichen sehen nur aus wie Buchstaben. Screenreader lesen sie nicht oder als einzelne Zeichen vor.</li>
  <li><strong>Videos mit Untertiteln:</strong> Viele Menschen sehen Videos ohne Ton. Untertitel helfen ihnen und allen, die nicht hören.</li>
  <li><strong>Text in Grafiken:</strong> Wiederholen Sie wichtige Aussagen einer Grafik im Beitragstext.</li>
</ul>
<h2>Unser Rahmen für Social Media</h2>
<p><strong>Ziele:</strong> Wir informieren über digitale Barrierefreiheit in der Landesverwaltung, machen Arbeitshilfen bekannt und laden zu Schulungen ein. Unsere Beiträge verweisen immer auf die ausführliche Information auf unserer Website.</p>
<p><strong>Zielgruppen:</strong> Beschäftigte der Landesverwaltung, insbesondere Redaktionen und IT, sowie interessierte Bürgerinnen und Bürger.</p>
<table>
  <caption>Kanäle und Formate</caption>
  <thead>
    <tr><th scope="col">Kanal</th><th scope="col">Wofür</th><th scope="col">Format</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Instagram</th><td>Wissen anschaulich vermitteln</td><td>Infografik oder kurzes Video mit Untertiteln</td></tr>
    <tr><th scope="row">Facebook</th><td>Ausführlichere Hinweise, Veranstaltungen</td><td>Text mit Link und Bild</td></tr>
    <tr><th scope="row">X</th><td>Kurze Hinweise auf Neues</td><td>Kurztext mit Link, höchstens 280 Zeichen</td></tr>
  </tbody>
</table>
<p><strong>Redaktionsplan:</strong> Wir planen Beiträge einen Monat im Voraus. Jeder Beitrag wird von einer zweiten Person gegengelesen. Kurzfristige Meldungen sind jederzeit möglich.</p>
<p><strong>Erfolg messen:</strong> Uns interessieren nicht Likes, sondern ob Menschen die Information finden. Wir schauen deshalb vor allem auf Klicks zur Website und Rückfragen.</p>
<p><strong>Datenschutz:</strong> Datenschutzaufsichtsbehörden sehen den Betrieb von Behördenseiten in sozialen Netzwerken teils kritisch. Stimmen Sie den Betrieb jedes Kanals mit Ihrer oder Ihrem Datenschutzbeauftragten ab. Wichtige Informationen stehen bei uns immer auch auf der Website, damit niemand ein Netzwerk nutzen muss.</p>
<h2>Beispiel: eine Meldung, drei Kanäle</h2>
<p>Dieselbe Information braucht in jedem Kanal eine andere Form. Als Beispiel dient unsere Meldung „{{link:meldung/en-301-549|Europäische Norm setzt jetzt auf WCAG 2.2}}“. Die Beiträge sind Muster und wurden nicht veröffentlicht.</p>
<h3>Instagram</h3>
{{img:sharepic-wcag22.png|Infografik: WCAG 2.2 – 6 neue Anforderungen. 1. Fokus nicht vollständig verdeckt. 2. Ziehbewegungen brauchen eine Alternative. 3. Klickflächen mindestens 24 × 24 Pixel. 4. Hilfe immer an derselben Stelle. 5. Eingaben nicht doppelt verlangen. 6. Anmeldung ohne Rätsel und Merkaufgaben.|432}}
<blockquote>
<p>Barrierefreiheit hat einen neuen Maßstab: WCAG 2.2.</p>
<p>Die europäische Norm EN 301 549 setzt jetzt auf die neue Version. Das sind die 6 neuen Anforderungen:</p>
<p>Der Fokus darf nicht vollständig verdeckt sein.<br>Ziehbewegungen brauchen eine Alternative.<br>Klickflächen sind mindestens 24&nbsp;×&nbsp;24&nbsp;Pixel groß.<br>Hilfe steht immer an derselben Stelle.<br>Bereits gemachte Eingaben werden nicht noch einmal verlangt.<br>Eine Anmeldung kommt ohne Rätsel und Merkaufgaben aus, oder es gibt eine Alternative.</p>
<p>Rechtlich gilt vorerst noch WCAG 2.1. Planen Sie neue Projekte trotzdem schon nach 2.2.<br>Mehr dazu: Link in der Bio</p>
<p>#DigitaleBarrierefreiheit #WCAG #Barrierefreiheit</p>
</blockquote>
<p><strong>Was ihn barrierefrei macht:</strong> Die Infografik hat einen Alternativtext mit allen sechs Punkten, und der Beitragstext wiederholt ihre Aussage vollständig. Die Hashtags stehen am Ende und in Binnenmajuskeln, es gibt keine Emojis als Aufzählungszeichen.</p>
<h3>Facebook</h3>
<blockquote>
<p><strong>Neue Fassung der europäischen Norm für Barrierefreiheit</strong></p>
<p>Im September 2026 ist die Norm EN 301 549 in einer neuen Fassung erschienen. Sie legt fest, wann Websites, Software und digitale Dokumente barrierefrei sind. Maßstab ist jetzt WCAG 2.2 statt 2.1. Neu sind zum Beispiel Mindestgrößen für Klickflächen und Regeln für barrierefreie Anmeldungen.</p>
<p>Rechtlich gilt die neue Fassung erst, wenn die EU-Kommission sie im Amtsblatt veröffentlicht. Wir empfehlen trotzdem, neue Websites und Ausschreibungen schon jetzt nach WCAG 2.2 zu planen.</p>
<p>Alle sechs neuen Anforderungen und unsere Empfehlung: {{link:meldung/en-301-549|Europäische Norm setzt jetzt auf WCAG 2.2}}</p>
</blockquote>
<p><strong>Was ihn barrierefrei macht:</strong> Er ist in kurze Absätze gegliedert, Fachbegriffe werden erklärt, und der Linktext sagt, wohin er führt.</p>
<h3>X</h3>
<p>Länge: 253 von 280 Zeichen (ein Link zählt bei X immer 23 Zeichen).</p>
<blockquote>
<p>Neue Fassung der Norm EN 301 549: Maßstab für barrierefreie Websites ist jetzt WCAG 2.2. Rechtlich gilt vorerst noch WCAG 2.1 – planen Sie neue Projekte trotzdem schon nach 2.2.</p>
<p>Die 6 neuen Anforderungen: {{link:meldung/en-301-549|Europäische Norm setzt jetzt auf WCAG 2.2}} #Barrierefreiheit #WCAG</p>
</blockquote>
<p><strong>Was ihn barrierefrei macht:</strong> Die wichtigste Aussage steht im ersten Satz, und es gibt kein Bild, das eine Beschreibung bräuchte.</p>
<h2>Community Management</h2>
<p>Kommentare und Nachrichten beantworten wir werktags innerhalb von 24 Stunden. Für den Umgang miteinander gilt unsere Netiquette: Wir löschen Beiträge, die beleidigen, diskriminieren, zu Gewalt aufrufen oder Werbung enthalten.</p>
<table>
  <caption>Antwortbausteine</caption>
  <thead>
    <tr><th scope="col">Situation</th><th scope="col">So reagieren wir</th><th scope="col">Beispiel</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Sachliche Frage</th><td>Kurz beantworten, auf die Website verlinken</td><td>„Danke für Ihre Frage! Die Pflicht gilt für öffentliche Stellen. Mehr dazu finden Sie hier: {{link:barrierefreiheit|Barrierefreiheit}}“</td></tr>
    <tr><th scope="row">Kritik oder Beschwerde</th><td>Ernst nehmen, nicht rechtfertigen, Lösung anbieten</td><td>„Danke für den Hinweis, das hätte nicht passieren dürfen. Wir geben das an die zuständige Stelle weiter. Möchten Sie die Barriere auch über unser Formular melden? {{form:barriere_melden|Barriere melden}}“</td></tr>
    <tr><th scope="row">Persönliches Anliegen mit eigenen Daten</th><td>Nicht öffentlich besprechen, sicheren Kontaktweg nennen</td><td>„Bitte schreiben Sie uns dazu keine persönlichen Daten in die Kommentare. Am besten erreichen Sie uns über unsere {{link:ueber-uns|Kontaktseite}}.“</td></tr>
    <tr><th scope="row">Falsche Information</th><td>Sachlich richtigstellen, mit Quelle</td><td>„Kurze Ergänzung: Rechtlich gilt derzeit noch WCAG 2.1. Die Quelle finden Sie hier: {{link:meldung/en-301-549|Europäische Norm setzt jetzt auf WCAG 2.2}}“</td></tr>
    <tr><th scope="row">Beleidigung, Hassrede</th><td>Nicht diskutieren. Nach Netiquette verbergen oder löschen, dokumentieren, bei strafbaren Inhalten an die zuständige Stelle melden</td><td>(keine öffentliche Antwort, ggf. Hinweis auf die Netiquette)</td></tr>
  </tbody>
</table>
<div class="hinweis hinweis--info">
<p><strong>Wichtig:</strong> Fragen zu konkreten Verfahren beantworten wir nicht in den Kommentaren, sondern verweisen auf die zuständige Stelle. So bleiben Auskünfte verlässlich und vertraulich.</p>
</div>
<h2>Datenschutz beachten</h2>
<p>Binden Sie Beiträge von Plattformen nicht direkt in die Website ein. Eingebettete Inhalte übertragen oft schon beim Laden der Seite Daten an die Plattform. Verlinken Sie stattdessen auf den Beitrag oder zeigen Sie ein Bildschirmfoto mit Alternativtext.</p>',
  ],

  // Hauptmenü: Web & Optimierung.
  'web-optimierung' => [
    'title' => 'Web & Optimierung',
    'promote' => TRUE,
    'summary' => 'Struktur, Auffindbarkeit und Messbarkeit von Behörden-Websites: Informationsarchitektur, SEO und GEO, Webanalyse.',
    'menu' => 'main', 'weight' => 3,
    'body' => '
<p>Eine gute Behörden-Website erfüllt drei Aufgaben: Menschen finden sich auf ihr zurecht. Suchmaschinen und KI-Assistenten finden ihre Inhalte. Und die Redaktion weiß, welche Inhalte gebraucht werden. Das LDT berät die Dienststellen der Landesverwaltung in allen drei Bereichen.</p>
<h2>Unsere Themen</h2>
<ul>
  <li>{{link:ia|Informationsarchitektur}}: Inhalte so ordnen, dass Menschen sie finden</li>
  <li>{{link:seo-geo|SEO und GEO}}: in Suchmaschinen und KI-Assistenten auffindbar sein</li>
  <li>{{link:matomo|Webanalyse mit Matomo}}: datenschutzfreundlich messen, was gebraucht wird</li>
  <li>{{link:fehlermeldungen|Fehlermeldungen bearbeiten}}: Meldungen zu Barrieren und Störungen prüfen und weitergeben</li>
</ul>
<h2>Erst die Struktur, dann die Optimierung</h2>
<p>Viele Probleme, die nach schlechter Auffindbarkeit aussehen, sind in Wahrheit Strukturprobleme: Seiten heißen wie Abteilungen statt wie Anliegen, oder dasselbe Thema steht an drei Stellen. Wir beginnen deshalb immer mit der Struktur. Webanalyse zeigt danach, ob die Änderungen wirken.</p>
<h2>Unser Angebot</h2>
<ul>
  <li><strong>Neue Website:</strong> Wir beraten Sie vor einem Neuaufbau zu Struktur, Technik und Ausschreibung.</li>
  <li><strong>Bestehende Website:</strong> Wir analysieren Navigation, Suchbegriffe und Nutzungsdaten und schlagen konkrete Verbesserungen vor.</li>
  <li><strong>Schulung:</strong> In unseren {{link:schulungen|Schulungen für Online-Redaktionen}} lernen Sie, Inhalte gut auffindbar zu machen.</li>
</ul>',
  ],
  'ia' => [
    'title' => 'Informationsarchitektur',
    'summary' => 'Informationsarchitektur für Behörden-Websites: nach Anliegen ordnen, mit Card Sorting und Tree Testing prüfen.',
    'menu' => 'main', 'parent' => 'web-optimierung', 'weight' => 1,
    'body' => '
<p>Informationsarchitektur beschreibt, wie die Inhalte einer Website geordnet, benannt und miteinander verknüpft sind. Eine gute Informationsarchitektur merkt man kaum: Menschen finden, was sie suchen – ohne den Aufbau der Behörde kennen zu müssen.</p>
<h2>Nach Anliegen ordnen, nicht nach Zuständigkeit</h2>
<p>Bürgerinnen und Bürger suchen „Wohngeld beantragen“, nicht „Referat 23“. Ordnen Sie Inhalte deshalb nach den Anliegen der Menschen und nicht nach dem Organigramm. Benennen Sie Menüpunkte in Alltagssprache, kurz und eindeutig.</p>
<h2>Methoden</h2>
<ul>
  <li><strong>Daten auswerten:</strong> Suchbegriffe der Website-Suche, häufige Fragen am Telefon und die Webanalyse zeigen, was Menschen suchen und nicht finden.</li>
  <li><strong>Card Sorting:</strong> Teilnehmende sortieren Karten mit Themen in Gruppen und benennen diese Gruppen. So sehen Sie, wie Ihre Zielgruppe Inhalte ordnet.</li>
  <li><strong>Tree Testing:</strong> Teilnehmende lösen Aufgaben wie „Wo finden Sie die Erklärung zur Barrierefreiheit?“ in einer reinen Textfassung der Navigation, ganz ohne Gestaltung. So prüfen Sie eine Struktur, bevor sie umgesetzt wird.</li>
</ul>
<h2>Beispiel: diese Website</h2>
<p>Diese Website ordnet ihre Inhalte so:</p>
<ul>
  <li>Startseite</li>
  <li>Barrierefreiheit: Barrierefreie Dokumente, Leichte Sprache, Video und Untertitel, Gebärdensprache</li>
  <li>Online-Redaktion: Texte fürs Web, Arbeitshilfe Redaktion, Social Media</li>
  <li>Web und Optimierung: Informationsarchitektur, SEO und GEO, Webanalyse mit Matomo</li>
  <li>Schulungen</li>
  <li>Über uns und Kontakt</li>
</ul>
<p>Die Navigation hat höchstens zwei Ebenen. Jede Übersichtsseite verlinkt ihre Unterseiten. Die Seiten, die jede Behörde anbieten muss, stehen gesammelt im Seitenfuß: Erklärung zur Barrierefreiheit, Barriere melden, Leichte Sprache, Gebärdensprache, Impressum und Datenschutz. Die Links zu Leichter Sprache und Gebärdensprache stehen zusätzlich gut sichtbar im Kopfbereich.</p>
<p>Eine Pfadnavigation („Sie sind hier“) zeigt auf jeder Seite, wo man sich befindet. Auch die Internetadressen folgen der Struktur.</p>
<p>Bei einer echten Behörden-Website würden wir diese Struktur vor der Umsetzung mit einem Tree Test prüfen.</p>',
  ],
  'seo-geo' => [
    'title' => 'SEO & GEO',
    'summary' => 'Auffindbar in Suchmaschinen und KI-Assistenten: SEO und GEO für Behörden-Websites, mit Umsetzung auf dieser Website.',
    'menu' => 'main', 'parent' => 'web-optimierung', 'weight' => 2,
    'body' => '
<p>Viele Menschen suchen Verwaltungsleistungen zuerst über eine Suchmaschine – und immer mehr fragen dafür einen KI-Assistenten. In beiden Fällen sollen Behörden-Websites als verlässliche Quelle erscheinen.</p>
<h2>Was SEO bedeutet</h2>
<p>Suchmaschinenoptimierung (englisch: <span lang="en">Search Engine Optimization</span>, SEO) heißt: Inhalte und Technik so gestalten, dass Suchmaschinen eine Seite finden, verstehen und passend anzeigen. Für Behörden geht es dabei nicht um Werbung, sondern darum, dass Menschen die richtige, offizielle Information finden.</p>
<h2>Was GEO bedeutet</h2>
<p><span lang="en">Generative Engine Optimization</span> (GEO) heißt: Inhalte so aufbereiten, dass KI-gestützte Such- und Antwortsysteme sie richtig erfassen, korrekt zusammenfassen und als Quelle nennen. Der Begriff ist noch jung, die Methoden entwickeln sich weiter. Vieles davon deckt sich mit guter Redaktionsarbeit und mit Barrierefreiheit.</p>
<h2>Was beiden hilft</h2>
<ul>
  <li>Überschriften, die sagen, worum es geht – gern als Frage, wie Menschen sie stellen</li>
  <li>ein erster Absatz, der die wichtigste Antwort enthält</li>
  <li>eindeutige Begriffe, die beim ersten Vorkommen erklärt werden</li>
  <li>Angaben mit Stand und Quelle, zum Beispiel „Stand: Oktober 2026“</li>
  <li>sauberer, barrierefreier Seitenaufbau: Was Screenreader verstehen, verstehen auch Maschinen</li>
  <li>regelmäßig geprüfte, aktuelle Inhalte</li>
</ul>
<h2>KI-Crawler zulassen oder sperren?</h2>
<p>In der Datei robots.txt legt eine Website fest, welche automatischen Programme, sogenannte Crawler, ihre Seiten auslesen sollen. Viele Anbieter von KI-Assistenten nutzen eigene Crawler. Behörden sollten bewusst entscheiden, ob sie diese zulassen.</p>
<p>Beides hat Folgen: Wer KI-Crawler pauschal sperrt, kann von KI-Assistenten nicht als offizielle Quelle genutzt werden. Die Antworten stützen sich dann womöglich auf weniger verlässliche Seiten. Wer sie zulässt, gibt die Inhalte zur Auswertung durch Dritte frei und hat keinen Einfluss darauf, wie sie zusammengefasst werden. Die robots.txt ist zudem nur eine Bitte an die Crawler, keine technische Sperre. Stimmen Sie die Entscheidung in Ihrer Dienststelle ab und überprüfen Sie sie regelmäßig.</p>
<h2>Umsetzung auf dieser Website</h2>
<ul>
  <li>Die Internetadressen sind lesbar und folgen der Struktur, zum Beispiel …/barrierefreiheit/leichte-sprache.</li>
  <li>Jede Seite hat einen eigenen Seitentitel und eine eigene Beschreibung für die Trefferliste.</li>
  <li>Strukturierte Daten nach schema.org beschreiben das Amt (GovernmentOrganization), jede Seite (WebPage) und ihre Position in der Struktur (BreadcrumbList). Diese Angaben stehen maschinenlesbar im Quelltext, im Format JSON-LD.</li>
  <li>Eine XML-Sitemap listet alle Seiten für Suchmaschinen auf.</li>
</ul>
<p>Als Musterseite ist die veröffentlichte Website für Suchmaschinen gesperrt („noindex“). Die Technik ist trotzdem vollständig eingerichtet.</p>
<h2>Was wir nicht empfehlen</h2>
<p>Häufen Sie keine Suchbegriffe an, und schreiben Sie keine Texte nur für Maschinen. Gute Inhalte für Menschen sind die Grundlage für jede Auffindbarkeit.</p>',
  ],
  'matomo' => [
    'title' => 'Webanalyse mit Matomo',
    'summary' => 'Webanalyse mit Matomo: datenschutzfreundlich einrichten und Kennzahlen nutzen, die Redaktionen weiterhelfen.',
    'menu' => 'main', 'parent' => 'web-optimierung', 'weight' => 3,
    'body' => '
<p>Webanalyse zeigt, wie Menschen eine Website nutzen: welche Seiten sie aufrufen, wonach sie suchen und wo sie abbrechen. Viele öffentliche Stellen nutzen dafür Matomo – eine quelloffene Software, die eine Behörde auf eigenen Servern betreiben kann. Die Daten bleiben dann bei der Behörde und gehen nicht an Dritte.</p>
<h2>Datenschutzfreundlich einrichten</h2>
<ul>
  <li><strong>IP-Adressen kürzen:</strong> Matomo kann die letzten Stellen jeder IP-Adresse entfernen, bevor es Daten speichert.</li>
  <li><strong>Ohne Cookies messen:</strong> Matomo lässt sich so einstellen, dass es keine Cookies setzt.</li>
  <li><strong>Widerspruch ermöglichen:</strong> Bieten Sie in der Datenschutzerklärung eine einfache Möglichkeit an, der Messung zu widersprechen.</li>
  <li><strong>Wenig speichern:</strong> Löschen Sie die Rohdaten nach kurzer Frist und bewahren Sie nur zusammengefasste Berichte auf.</li>
</ul>
<p>Ob Sie für die Messung eine Einwilligung brauchen, hängt von den Einstellungen und der Rechtslage ab, insbesondere von der Datenschutz-Grundverordnung und dem Telekommunikation-Digitale-Dienste-Datenschutz-Gesetz (TDDDG). Stimmen Sie die Einrichtung immer mit Ihrer oder Ihrem Datenschutzbeauftragten ab.</p>
<h2>Kennzahlen, die Redaktionen weiterhelfen</h2>
<ul>
  <li><strong>Suchbegriffe der Website-Suche</strong> zeigen, was Menschen erwarten und vielleicht nicht finden.</li>
  <li><strong>Einstiegsseiten:</strong> Viele Menschen kommen nicht über die Startseite, sondern direkt über eine Suchmaschine auf eine Unterseite.</li>
  <li><strong>Abbrüche:</strong> Wo verlassen Menschen ein Formular oder einen Ablauf?</li>
  <li><strong>Downloads:</strong> Welche Dokumente werden wirklich gebraucht?</li>
</ul>
<p>Reine Seitenaufrufe sagen wenig. Fragen Sie immer: Konnte die Person ihr Anliegen erledigen?</p>
<h2>Auf dieser Website</h2>
<p>Matomo ist auf dieser Website vorbereitet, aber nicht aktiv. Es werden keine Nutzungsdaten erhoben. Sollte sich das ändern, steht es in der {{link:datenschutz|Datenschutzerklärung}}.</p>',
  ],

  'fehlermeldungen' => [
    'title' => 'Fehlermeldungen bearbeiten',
    'summary' => 'So prüft, ordnet und gibt das LDT Meldungen zu Barrieren und Störungen weiter, damit sie schnell bei der richtigen Stelle ankommen.',
    'menu' => 'main', 'parent' => 'web-optimierung', 'weight' => 4,
    'body' => '
<p>Meldungen über Barrieren oder Störungen kommen oft knapp und ohne technische Details. Bevor wir sie weitergeben, qualifizieren wir sie vor: Wir stellen das Problem nach, ordnen es ein und ergänzen, was die zuständige Stelle zum Beheben braucht. So muss niemand nachfragen, und die Meldenden bekommen schneller eine Antwort.</p>
<h2>Der Ablauf</h2>
<ol>
  <li><strong>Eingang:</strong> Die Meldung kommt über das {{form:barriere_melden|Formular „Barriere melden“}}, per E-Mail oder über Social Media.</li>
  <li><strong>Nachstellen:</strong> Wir rufen die Seite auf und versuchen, das Problem nachzustellen, wenn möglich mit dem genannten Hilfsmittel.</li>
  <li><strong>Einordnen:</strong> Wir legen Kategorie und Priorität fest, prüfen, ob das Problem schon gemeldet wurde, und benennen das betroffene WCAG-Kriterium.</li>
  <li><strong>Weitergeben:</strong> Die Meldung geht vollständig beschrieben an die zuständige Stelle: Redaktion, IT-Dienstleister oder die Verantwortlichen für das Dokument.</li>
  <li><strong>Rückmelden und abschließen:</strong> Wir informieren die meldende Person. Bleibt eine Barriere länger bestehen, nehmen wir sie in die {{link:erklaerung|Erklärung zur Barrierefreiheit}} auf.</li>
</ol>
<h2>Prioritäten</h2>
<table>
  <caption>Prioritäten und Fristen für die Weitergabe</caption>
  <thead>
    <tr><th scope="col">Priorität</th><th scope="col">Wann</th><th scope="col">Beispiel</th><th scope="col">Weitergabe</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Hoch</th><td>Eine wichtige Funktion ist für eine Gruppe von Menschen nicht nutzbar</td><td>Formular lässt sich nicht absenden, Menü nicht bedienbar, Seite nicht erreichbar</td><td>am selben Werktag</td></tr>
    <tr><th scope="row">Mittel</th><td>Nutzung ist erschwert, es gibt aber einen Umweg</td><td>Grafik ohne Alternativtext, zu schwacher Kontrast</td><td>innerhalb von 2 Werktagen</td></tr>
    <tr><th scope="row">Niedrig</th><td>Kleiner Mangel ohne echte Barriere</td><td>Tippfehler, unklare Formulierung</td><td>mit der nächsten Überarbeitung</td></tr>
  </tbody>
</table>
<h2>Beispiel: aus einer Nachricht wird eine Meldung</h2>
<p>So kam die Nachricht an:</p>
<blockquote>
<p>Hallo, auf eurer Seite kann ich das Menü auf dem Handy nicht aufmachen. Da passiert einfach nichts. Bitte reparieren.</p>
</blockquote>
<p>So geben wir sie weiter:</p>
<table>
  <caption>Meldung 2026-0142 nach der Vorqualifizierung</caption>
  <thead>
    <tr><th scope="col">Feld</th><th scope="col">Inhalt</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Meldung</th><td>2026-0142</td></tr>
    <tr><th scope="row">Kategorie</th><td>Bedienung</td></tr>
    <tr><th scope="row">Priorität</th><td>Hoch: Die Navigation ist für Betroffene nicht nutzbar</td></tr>
    <tr><th scope="row">Betroffene Seite</th><td>alle Seiten, Hauptnavigation</td></tr>
    <tr><th scope="row">Gerät und Hilfsmittel</th><td>iPhone, Safari, VoiceOver (laut Rückfrage)</td></tr>
    <tr><th scope="row">Schritte zum Nachstellen</th><td><ol><li>Seite auf dem iPhone öffnen.</li><li>VoiceOver einschalten.</li><li>Zum Knopf „Menü“ wischen und doppeltippen.</li></ol></td></tr>
    <tr><th scope="row">Erwartet</th><td>Das Menü öffnet sich, VoiceOver sagt „erweitert“.</td></tr>
    <tr><th scope="row">Tatsächlich</th><td>Nichts passiert, VoiceOver sagt weiterhin „reduziert“.</td></tr>
    <tr><th scope="row">WCAG-Kriterium</th><td>2.1.1 Tastatur, 4.1.2 Name, Rolle, Wert</td></tr>
    <tr><th scope="row">Zuständig</th><td>IT-Dienstleister Webportal</td></tr>
    <tr><th scope="row">Rückmeldung an Meldende</th><td>Eingang bestätigt, Weitergabe mitgeteilt</td></tr>
  </tbody>
</table>
<p>Das Beispiel ist erfunden. Auf dieser Website funktioniert das Menü.</p>
<p>Gute Meldungen erkennen Sie daran, dass jemand anderes das Problem allein mit den Angaben nachstellen kann.</p>',
  ],

  // Hauptmenü: Einzelseiten.
  'schulungen' => [
    'title' => 'Schulungen',
    'promote' => TRUE,
    'summary' => 'Kostenfreie Schulungen zu Barrierefreiheit, Dokumenten und Webtexten für Beschäftigte der Landesverwaltung.',
    'menu' => 'main', 'weight' => 4,
    'body' => '
<p>Das LDT bietet den Beschäftigten der Landesverwaltung kostenfreie Schulungen an. Sie finden online oder in unseren Schulungsräumen in Musterstadt statt.</p>
<h2>Unser Angebot</h2>
<ul>
  <li><strong>Grundlagen der digitalen Barrierefreiheit</strong> – für alle Beschäftigten, 3 Stunden, online</li>
  <li><strong>Barrierefreie Dokumente mit Word und PDF</strong> – für Sachbearbeitung und Redaktionen, 1 Tag, in Präsenz</li>
  <li><strong>Texte fürs Web und Einfache Sprache</strong> – für Online-Redaktionen, 1 Tag, in Präsenz</li>
  <li><strong>Barrierefreiheit prüfen nach WCAG und EN 301 549</strong> – für Webverantwortliche und IT, 2 Tage, in Präsenz</li>
  <li><strong>Barrierefreie Social-Media-Beiträge</strong> – für Social-Media-Teams, 3 Stunden, online</li>
</ul>
<h2>So arbeiten wir</h2>
<ul>
  <li>Sie üben an eigenen Dokumenten und Texten. Bringen Sie gern Beispiele aus Ihrer Arbeit mit.</li>
  <li>Alle Unterlagen sind barrierefrei und stehen nach der Schulung zum Download bereit.</li>
  <li>Für Online-Schulungen bieten wir auf Wunsch Live-Untertitel an.</li>
  <li>Gebärdensprachdolmetschen und weitere Unterstützung organisieren wir, wenn Sie es bei der Anmeldung angeben.</li>
</ul>
<h2>Anmeldung</h2>
<p>Sie melden sich über die Fortbildungsbeauftragten Ihrer Dienststelle an. Für Teams ab acht Personen bieten wir auch Schulungen direkt in Ihrer Dienststelle an.</p>
<p>Auf dieser Musterseite ist keine Anmeldung möglich.</p>
<h2>Beispielmaterial</h2>
<div class="hinweis hinweis--info">
<p><strong>Hinweis:</strong> Das Beispiel wird hier ergänzt.</p>
<p>Hier steht ein Auszug aus den Unterlagen zur Schulung „Grundlagen der digitalen Barrierefreiheit“: einige Folien als barrierefreies PDF und ein Übungsblatt, mit dem Teilnehmende eine Website mit der Tastatur prüfen.</p>
</div>',
  ],
  'ueber-uns' => [
    'title' => 'Über uns / Kontakt',
    'summary' => 'Aufgaben, Organisation und Kontakt des Landesamts für Digitale Teilhabe Musterland.',
    'menu' => 'main', 'weight' => 6, // 5 = "Aktuelles" (create-meldungen.php)
    'body' => '
<h2>Wer wir sind</h2>
<p>Das Landesamt für Digitale Teilhabe Musterland (LDT) ist die zentrale Fachstelle des Landes für digitale Barrierefreiheit und verständliche Verwaltungskommunikation. Es gehört zum Geschäftsbereich des Ministeriums für Digitales des Musterlands.</p>
<h2>Unsere Aufgaben</h2>
<ul>
  <li><strong>Beraten:</strong> Wir beraten Dienststellen des Landes, wenn sie Websites, Apps oder Fachverfahren planen, ausschreiben oder überarbeiten.</li>
  <li><strong>Prüfen und überwachen:</strong> Als Überwachungsstelle des Landes prüfen wir regelmäßig eine Stichprobe von Websites und mobilen Anwendungen öffentlicher Stellen und berichten über die Ergebnisse.</li>
  <li><strong>Schulen:</strong> Wir bieten {{link:schulungen|Schulungen für Beschäftigte der Landesverwaltung}} an.</li>
  <li><strong>Vernetzen:</strong> Wir koordinieren das Redaktionsnetzwerk der Landesverwaltung und stellen {{link:arbeitshilfe|Arbeitshilfen für Redaktionen}} bereit.</li>
</ul>
<h2>Organisation</h2>
<p>Das LDT gliedert sich in vier Referate:</p>
<ul>
  <li>Referat 1: Grundsatzfragen und Recht</li>
  <li>Referat 2: Prüfung und Überwachung</li>
  <li>Referat 3: Beratung und Schulung</li>
  <li>Referat 4: Verständliche Kommunikation, Leichte Sprache und Gebärdensprache</li>
</ul>
<h2>Kontakt</h2>
<p><strong>Beispieladresse – fiktive Angaben, keine echte Behörde.</strong></p>
<p>Landesamt für Digitale Teilhabe Musterland<br>Musterstraße 1<br>12345 Musterstadt</p>
<p>Telefon: 0000 000000 (Beispielnummer)<br>E-Mail: poststelle@ldt-musterland.example (Beispieladresse)</p>
<p>Barrieren auf dieser Website können Sie über das Formular {{form:barriere_melden|Barriere melden}} melden.</p>',
  ],

  // Footer-Menü.
  'erklaerung' => [
    'title' => 'Erklärung zur Barrierefreiheit',
    'summary' => 'Erklärung zur Barrierefreiheit dieser Website: Stand der Vereinbarkeit, bekannte Mängel und Feedback.',
    'menu' => 'footer', 'weight' => 1,
    'body' => '
<p><strong>Hinweis: Diese Erklärung ist ein Muster.</strong> Das Landesamt für Digitale Teilhabe Musterland ist eine fiktive Behörde. Die Prüfergebnisse in dieser Erklärung stammen aber aus echten Tests dieser Website.</p>
<p>Das Landesamt für Digitale Teilhabe Musterland ist bemüht, seine Website im Einklang mit dem Landesrecht zur barrierefreien Informationstechnik barrierefrei zugänglich zu machen. Diese Erklärung gilt für diese Website.</p>
<p>Die wichtigsten Inhalte dieser Erklärung finden Sie auch {{link:leichte-sprache|in Leichter Sprache}}.</p>
<h2>Stand der Vereinbarkeit mit den Anforderungen</h2>
<p>Diese Website ist mit den Anforderungen der WCAG 2.1 in der Stufe AA <strong>teilweise vereinbar</strong>. Die Gründe stehen im nächsten Abschnitt.</p>
<h2>Nicht barrierefreie Inhalte</h2>
<ul>
  <li><strong>Gebärdensprache:</strong> Es gibt noch keine Videos in Deutscher Gebärdensprache. Die Seite {{link:gebaerdensprache|Informationen in Gebärdensprache}} beschreibt, welche Inhalte die Videos haben werden.</li>
  <li><strong>Leichte Sprache:</strong> Der Text in Leichter Sprache wurde nicht von einer Prüfgruppe geprüft.</li>
  <li><strong>Screenreader:</strong> Die Website wurde bisher in einer Grundprüfung mit VoiceOver unter macOS getestet. Tests mit den Screenreadern NVDA und JAWS unter Windows stehen noch aus. Barrieren bei der Sprachausgabe in diesen Screenreadern können wir deshalb nicht ausschließen.</li>
  <li><strong>Weitere Prüfungen:</strong> Noch nicht geprüft sind die reine Textvergrößerung ohne Zoom, der Kontrastmodus von Windows und die Bedienung mit Sprachsteuerung.</li>
  <li><strong>Videoplayer:</strong> Videos nutzen den Player des Browsers. Wie gut er sich mit der Tastatur und mit Screenreadern bedienen lässt, hängt vom Browser ab.</li>
</ul>
<h2>Erstellung dieser Erklärung zur Barrierefreiheit</h2>
<p>Diese Erklärung wurde am 16. Oktober 2026 erstellt und zuletzt am 16. Oktober 2026 überprüft.</p>
<p>Grundlage ist eine Selbstbewertung mit diesen Prüfungen:</p>
<ul>
  <li><strong>Automatische Prüfung</strong> mit axe-core 4.14 nach WCAG 2.0 und 2.1, Stufen A und AA: 24 Seiten, jeweils in der Desktop-Ansicht und 375 Pixel breit, dazu geöffnetes Menü und Formular mit Fehlermeldungen. Ergebnis: keine Verstöße.</li>
  <li><strong>Tastaturbedienung:</strong> Link „Direkt zum Inhalt“, Reihenfolge und Sichtbarkeit des Fokus, Hauptmenü mit Untermenüs, mobiles Menü und Formular „Barriere melden“. Ergebnis: bestanden.</li>
  <li><strong>Screenreader:</strong> Grundprüfung mit VoiceOver in Safari unter macOS: Orientierungspunkte (Landmarks), Überschriften, Hauptmenü mit Untermenüs und Formular „Barriere melden“.</li>
  <li><strong>Umbruch bei Vergrößerung:</strong> Alle Seiten bei 320 Pixel Breite, das entspricht 400 Prozent Zoom. Ergebnis: kein waagerechtes Scrollen.</li>
  <li><strong>Kontraste:</strong> Alle verwendeten Farbkombinationen. Ergebnis: mindestens 4,5:1 für Text und 3:1 für Bedienelemente.</li>
</ul>
<h2>Barrieren melden: Kontakt</h2>
<p>Sind Ihnen Mängel beim barrierefreien Zugang zu Inhalten dieser Website aufgefallen? Dann melden Sie sich bitte über das Formular {{form:barriere_melden|Barriere melden}} oder per E-Mail an poststelle@ldt-musterland.example (Beispieladresse).</p>
<p>Auf der veröffentlichten Musterseite läuft das Formular im Demo-Modus: Meldungen werden dort weder gespeichert noch versendet.</p>
<h2>Schlichtungsverfahren</h2>
<p>Wenn Sie auch nach Ihrer Meldung keine zufriedenstellende Lösung erhalten, können Sie sich an die Schlichtungsstelle wenden, die nach dem Landesrecht zur barrierefreien Informationstechnik zuständig ist. Im Musterland ist das die – ebenfalls fiktive – Schlichtungsstelle bei der oder dem Landesbeauftragten für die Belange von Menschen mit Behinderungen. Das Verfahren ist kostenlos, und Sie brauchen keinen Rechtsbeistand.</p>',
  ],
  'leichte-sprache' => [
    'title' => 'Leichte Sprache',
    'summary' => 'Informationen über diese Internet-Seite in Leichter Sprache.',
    'menu' => 'footer', 'weight' => 3,
    'body' => '
<p><strong>Wichtig: Diese Internet·seite ist ein Beispiel.</strong></p>
<p>Das Amt auf dieser Seite gibt es nicht in echt.</p>
<p>Eine Prüf·gruppe hat diesen Text nicht geprüft.</p>
<p>Eine Prüf·gruppe sind Menschen mit Lern·schwierigkeiten.<br>Sie lesen Texte in Leichter Sprache.<br>Und sie sagen: Das verstehe ich.<br>Oder: Das verstehe ich nicht.</p>
<h2>Wer sind wir?</h2>
<p>Wir sind ein Amt.<br>Unser Name ist: Landes·amt für Digitale Teilhabe Musterland.<br>Die Abkürzung ist: L-D-T.</p>
<p>Wir arbeiten für die Ämter im Musterland.<br>Wir helfen den Ämtern bei ihren Internet·seiten.<br>Damit alle Menschen die Internet·seiten benutzen können.<br>Auch Menschen mit Behinderung.</p>
<h2>Was steht auf dieser Internet·seite?</h2>
<p>Auf dieser Internet·seite finden Sie Infos zu diesen Themen:</p>
<ul>
  <li>Barriere·freiheit.<br>Barriere·frei heißt: Alle Menschen können etwas benutzen.<br>Ohne Hilfe.</li>
  <li>Gute Texte für das Internet.</li>
  <li>Wie man Internet·seiten besser macht.</li>
  <li>Kurse für Menschen, die in Ämtern arbeiten.</li>
</ul>
<h2>Wie finde ich mich zurecht?</h2>
<p>Ganz oben ist ein gelber Kasten.<br>Dort steht: Die Seite ist ein Beispiel.</p>
<p>Darunter steht der Name vom Amt.<br>Daneben sind 2 Links:<br>Leichte Sprache und Gebärden·sprache.</p>
<p>Darunter ist das Menü.<br>Im Menü finden Sie alle Themen.</p>
<p>Benutzen Sie ein Handy?<br>Dann drücken Sie auf das Wort: Menü.<br>Dann sehen Sie alle Themen.</p>
<p>Ganz unten auf jeder Seite sind noch mehr Links.<br>Zum Beispiel ein Link zu dieser Seite.</p>
<p>Sie können die Seite auch mit der Tastatur benutzen.<br>Mit der Taste: Tab.</p>
<h2>Was ist die Erklärung zur Barriere·freiheit?</h2>
<p>Auf dieser Internet·seite gibt es eine Erklärung zur Barriere·freiheit.<br>Dort steht:<br>Was auf der Internet·seite schon gut ist.<br>Und was noch nicht gut ist.</p>
<p>Zum Beispiel:<br>Es gibt noch keine Filme in Gebärden·sprache.</p>
<p>Die Erklärung ist in schwerer Sprache.<br>Hier ist der Link: {{link:erklaerung|Erklärung zur Barriere·freiheit}}</p>
<h2>Haben Sie ein Problem mit der Internet·seite?</h2>
<p>Dann können Sie uns schreiben.<br>Ganz unten auf der Seite ist dafür ein Link.<br>Der Link heißt: Barriere melden.</p>
<h2>Gibt es noch mehr Infos in Leichter Sprache?</h2>
<p>Im Moment gibt es nur diese Seite in Leichter Sprache.</p>',
  ],
  'gebaerdensprache' => [
    'title' => 'Gebärdensprache',
    'summary' => 'Informationen über diese Website in Deutscher Gebärdensprache: welche Inhalte die Videos zeigen werden.',
    'menu' => 'footer', 'weight' => 4,
    'body' => '
<p><strong>Hinweis: Diese Seite ist ein Muster.</strong> Hier stehen später Videos in Deutscher Gebärdensprache (DGS). Zurzeit gibt es noch keine Videos.</p>
<p>Auf dieser Seite erklären vier Videos in DGS, was Sie auf dieser Website finden. Unter jedem Video steht der Inhalt zusätzlich als kurzer Text.</p>
<div class="hinweis hinweis--info">
<p><strong>Hinweis:</strong> Die Videos werden hier ergänzt.</p>
<p>Jedes Video ist etwa eine Minute lang, hat einen eindeutigen Titel und lässt sich mit der Tastatur starten. Gebärdet wird von einer gehörlosen Person vor einem ruhigen, einfarbigen Hintergrund.</p>
</div>
<h2>Video 1: Das LDT und diese Website</h2>
<p>Das Video stellt das Landesamt für Digitale Teilhabe Musterland vor: Es berät die Ämter des Landes, prüft ihre Websites und bietet Schulungen an. Es erklärt auch, dass diese Website eine Musterseite ist und das Amt nicht wirklich existiert.</p>
<h2>Video 2: So finden Sie sich zurecht</h2>
<p>Das Video zeigt den Aufbau der Website: den gelben Hinweis ganz oben, die Links zu Leichter Sprache und Gebärdensprache, das Hauptmenü mit den Themen und die Links im Seitenfuß. Es erklärt auch, wie man das Menü auf dem Handy öffnet.</p>
<h2>Video 3: Erklärung zur Barrierefreiheit</h2>
<p>Das Video fasst die {{link:erklaerung|Erklärung zur Barrierefreiheit}} zusammen: Was auf dieser Website schon barrierefrei ist, was noch fehlt und wie Sie uns eine Barriere melden können.</p>
<h2>Video 4: Weitere Informationen in Gebärdensprache</h2>
<p>Das Video erklärt, dass es auf dieser Website zurzeit keine weiteren Inhalte in Gebärdensprache gibt. Allgemeine Informationen zur Gebärdensprache in der Verwaltung stehen auf der Seite {{link:gebaerdensprache-fach|Gebärdensprache auf Behörden-Websites}}.</p>',
  ],

  // Impressum und Datenschutz: echte Angaben liefert der Betreiber.
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
