// Erklärvideo "Was macht das LDT?" – komplett lokal erzeugen.
//
//   node scripts/video/erstellen.mjs
//
// Braucht: macOS (say, Stimme "Anna"), ffmpeg/ffprobe, Google Chrome und Playwright aus
// tests/a11y (npm install dort). Schreibt nach web/sites/default/files/:
//   videos/was-macht-das-ldt.mp4        Video (H.264/AAC)
//   untertitel/was-macht-das-ldt.vtt    Untertitel (WebVTT)
//   dokumente/Transkript-Was-macht-das-LDT.txt   Transkript (UTF-8)
// Diese Dateien sind nicht im Git-Repository (siehe README, Upload-Liste).
// Außerdem scripts/video/transkript.html (im Repository) für die Seite
// "Video & Untertitel"; danach create-content.php --overwrite --only=video.
//
// Ablauf: je Abschnitt eine Tonspur mit say, Dauer und Sprechpausen messen
// (ffmpeg silencedetect), Folien aus HTML im Design des Themes als PNG
// (1920×1080), dann zusammensetzen. Die Untertitel-Zeiten kommen aus den
// gemessenen Pausen: Jede Einblendung umfasst n Sprechabschnitte.
import { spawnSync } from 'node:child_process';
import { mkdtempSync, writeFileSync, mkdirSync, readFileSync } from 'node:fs';
import { tmpdir } from 'node:os';
import { join, dirname } from 'node:path';
import { fileURLToPath, pathToFileURL } from 'node:url';

const ROOT = join(dirname(fileURLToPath(import.meta.url)), '..', '..');
const THEME = join(ROOT, 'web/themes/custom/ldt_musterland');
const FILES = join(ROOT, 'web/sites/default/files');
const { chromium } = await import(pathToFileURL(join(ROOT, 'tests/a11y/node_modules/playwright/index.mjs')).href);

const STIMME = 'Anna';
const TEMPO = 165;          // Wörter pro Minute (say -r)
const VORLAUF = 1.5;        // s Titelbild vor dem ersten Satz ("[Synthetische Sprecherstimme]")
const PAUSE = 0.6;          // s zwischen den Abschnitten
const NACHLAUF = 1.0;       // s nach dem letzten Satz
const ABSPANN = 4;          // s Abspann ohne Ton
const FREI_AB = 756;        // px: Folieninhalt endet oberhalb von 70 % der Höhe
const HINWEIS_STIMME = 'Sprecherstimme: synthetische Stimme von macOS.';
const HINWEIS_MUSTER = 'Musterbeitrag einer fiktiven Behörde.';

// Abschnitte: gesprochener Text, Untertitel (Zeilen mit \n, n = Anzahl der
// Sprechabschnitte zwischen zwei gemessenen Pausen), Folie, Bildbeschreibung.
const ABSCHNITTE = [
  {
    text: 'Was macht das Landesamt für Digitale Teilhabe Musterland? In einer Minute erklärt.',
    cues: [['Was macht das Landesamt für Digitale\nTeilhabe Musterland?', 1], ['In einer Minute erklärt.', 1]],
    bild: 'Titelfolie: groß der Titel „Was macht das LDT?“, darunter die Langform „Landesamt für Digitale Teilhabe Musterland“.',
    folie: `<h1 class="titel">Was macht das LDT?</h1>
      <p class="lang">Landesamt für Digitale Teilhabe Musterland</p>`,
  },
  {
    text: 'Unser Ziel ist einfach: Alle Menschen sollen die digitalen Angebote der Landesverwaltung nutzen können. Auch wer nicht gut sieht, hört oder liest.',
    cues: [['Unser Ziel ist einfach:', 1], ['Alle Menschen sollen die digitalen Angebote\nder Landesverwaltung nutzen können.', 1], ['Auch wer nicht gut sieht, hört oder liest.', 2]],
    bild: 'Folie „Unser Ziel“: Symbol einer Person mit Laptop, daneben der Satz „Alle Menschen sollen die digitalen Angebote der Landesverwaltung nutzen können.“',
    folie: `<h2>Unser Ziel</h2>
      <div class="reihe">${symbol('person')}<p class="gross">Alle Menschen sollen die digitalen Angebote der Landesverwaltung nutzen können.</p></div>`,
  },
  {
    text: 'Wir beraten die Dienststellen des Landes, wenn sie neue Websites oder Apps planen. So wird Barrierefreiheit von Anfang an mitgedacht.',
    cues: [['Wir beraten die Dienststellen des Landes,\nwenn sie neue Websites oder Apps planen.', 2], ['So wird Barrierefreiheit\nvon Anfang an mitgedacht.', 1]],
    bild: 'Folie „Beraten“: Liste mit drei Punkten: Websites, Apps, Ausschreibungen.',
    folie: `<h2>Beraten</h2>
      <ul class="liste"><li>Websites</li><li>Apps</li><li>Ausschreibungen</li></ul>`,
  },
  {
    text: 'Wir prüfen Websites, Apps und Dokumente. Mit Prüfwerkzeugen, mit der Tastatur und mit Screenreadern, also Programmen, die Bildschirminhalte vorlesen.',
    cues: [['Wir prüfen Websites, Apps und Dokumente.', 2], ['Mit Prüfwerkzeugen, mit der Tastatur\nund mit Screenreadern,', 2], ['also Programmen,\ndie Bildschirminhalte vorlesen.', 2]],
    bild: 'Folie „Prüfen“: drei Symbole nebeneinander mit Beschriftung: eine Tastatur („Tastatur“), ein Bildschirm mit Lautsprecher („Screenreader“) und eine Lupe („Prüfwerkzeuge“).',
    folie: `<h2>Prüfen</h2>
      <ul class="symbole">
        <li>${symbol('tastatur')}<span>Tastatur</span></li>
        <li>${symbol('screenreader')}<span>Screenreader</span></li>
        <li>${symbol('lupe')}<span>Prüfwerkzeuge</span></li>
      </ul>`,
  },
  {
    text: 'Wir schulen die Beschäftigten der Landesverwaltung. Zum Beispiel darin, barrierefreie Dokumente zu erstellen und verständliche Texte zu schreiben.',
    cues: [['Wir schulen die Beschäftigten\nder Landesverwaltung.', 1], ['Zum Beispiel darin,', 1], ['barrierefreie Dokumente zu erstellen\nund verständliche Texte zu schreiben.', 1]],
    bild: 'Folie „Schulen“: Ausschnitt aus der Terminliste „Nächste Termine“: 12. November 2026, Grundlagen der digitalen Barrierefreiheit; 19. November 2026, Barrierefreie Dokumente mit Word und PDF; 26. November 2026, Texte fürs Web und Einfache Sprache.',
    folie: `<h2>Schulen</h2>
      <div class="termine">
        <p class="termine__titel">Nächste Termine</p>
        <dl>
          <div><dt>12. November 2026</dt><dd>Grundlagen der digitalen Barrierefreiheit</dd></div>
          <div><dt>19. November 2026</dt><dd>Barrierefreie Dokumente mit Word und PDF</dd></div>
          <div><dt>26. November 2026</dt><dd>Texte fürs Web und Einfache Sprache</dd></div>
        </dl>
      </div>`,
  },
  {
    text: 'Sie finden eine Barriere auf einer Website des Landes? Melden Sie sie uns über das Formular „Barriere melden“. Mehr erfahren Sie auf unserer Website.',
    cues: [['Sie finden eine Barriere\nauf einer Website des Landes?', 1], ['Melden Sie sie uns über das Formular\n„Barriere melden“.', 1], ['Mehr erfahren Sie auf unserer Website.', 1]],
    bild: 'Folie „Kontakt“: die Adresse der Website „designpink.de/drupal“ und darunter eine Schaltfläche „Barriere melden“.',
    folie: `<h2>Kontakt</h2>
      <p class="adresse">designpink.de/drupal</p>
      <p><span class="knopf">Barriere melden</span></p>`,
  },
];
const ABSPANN_FOLIE = {
  bild: `Abspann ohne Ton: „${HINWEIS_MUSTER} ${HINWEIS_STIMME}“`,
  folie: `<div class="abspann"><p>${HINWEIS_MUSTER}</p><p>${HINWEIS_STIMME}</p></div>`,
};

function symbol(name) {
  const pfade = {
    person: '<circle cx="32" cy="14" r="7"/><path d="M18 40c0-8 6-13 14-13s14 5 14 13"/><rect x="14" y="40" width="36" height="14" rx="2"/><path d="M8 58h48"/>',
    tastatur: '<rect x="4" y="16" width="56" height="32" rx="4"/><path d="M12 25h4M22 25h4M32 25h4M42 25h4M52 25h0M12 33h4M22 33h4M32 33h4M42 33h8M18 41h28"/>',
    screenreader: '<rect x="4" y="8" width="38" height="28" rx="3"/><path d="M16 44h14M23 36v8"/><path d="M48 26h4l6-6v24l-6-6h-4z"/>',
    lupe: '<circle cx="26" cy="26" r="16"/><path d="M38 38l18 18"/>',
  };
  return `<svg class="symbol" viewBox="0 0 64 64" aria-hidden="true">${pfade[name]}</svg>`;
}


const ZEILE_MAX = 43;       // Zeichen je Untertitelzeile (Richtwert 42)
const run = (cmd, args) => {
  const r = spawnSync(cmd, args, { encoding: 'utf8' });
  if (r.status !== 0) throw new Error(`${cmd} fehlgeschlagen:\n${r.stderr}`);
  return r;
};
const dauer = (datei) => Number(run('ffprobe', ['-v', 'error', '-show_entries', 'format=duration', '-of', 'csv=p=0', datei]).stdout.trim());

// Sprechabschnitte [start, ende] zwischen Pausen von mindestens 0,12 s.
function sprechabschnitte(datei, gesamt) {
  const log = run('ffmpeg', ['-hide_banner', '-nostats', '-i', datei, '-af', 'silencedetect=noise=-40dB:d=0.12', '-f', 'null', '-']).stderr;
  const starts = [...log.matchAll(/silence_start: ([\d.]+)/g)].map((m) => Number(m[1]));
  const ends = [...log.matchAll(/silence_end: ([\d.]+)/g)].map((m) => Number(m[1]));
  const segmente = [];
  let von = 0;
  starts.forEach((s, k) => {
    if (s > von + 0.05) segmente.push([von, s]);
    von = ends[k] ?? gesamt;
  });
  if (von < gesamt - 0.05) segmente.push([von, gesamt]);
  return segmente;
}

const zeit = (s) => {
  const ms = Math.round(s * 1000);
  const h = Math.floor(ms / 3600000), m = Math.floor(ms / 60000) % 60, sec = Math.floor(ms / 1000) % 60;
  return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(sec).padStart(2, '0')}.${String(ms % 1000).padStart(3, '0')}`;
};
const minSek = (s) => `${Math.floor(s / 60)}:${String(Math.floor(s % 60)).padStart(2, '0')}`;

const tmp = mkdtempSync(join(tmpdir(), 'ldt-video-'));

// 1. Ton je Abschnitt; Dauer und Sprechabschnitte messen.
let t = 0;
for (const [i, a] of ABSCHNITTE.entries()) {
  a.ton = join(tmp, `ton${i + 1}.aiff`);
  run('say', ['-v', STIMME, '-r', String(TEMPO), '-o', a.ton, a.text]);
  a.dauer = dauer(a.ton);
  a.segmente = sprechabschnitte(a.ton, a.dauer);
  const n = a.cues.reduce((s, [, m]) => s + m, 0);
  if (n !== a.segmente.length) {
    throw new Error(`Abschnitt ${i + 1}: ${a.segmente.length} Sprechabschnitte gemessen, Untertitel erwarten ${n}.`);
  }
  // Folie: Vorlauf (nur erste), Ton, danach Pause bzw. Nachlauf.
  a.vor = i === 0 ? VORLAUF : 0;
  a.nach = i === ABSCHNITTE.length - 1 ? NACHLAUF : PAUSE;
  a.start = t;
  a.tonStart = t + a.vor;
  a.folienDauer = a.vor + a.dauer + a.nach;
  t += a.folienDauer;
}
const gesamt = t + ABSPANN;

// 2. Untertitel aus den gemessenen Zeiten.
const cues = [{ von: 0, bis: VORLAUF, text: '[Synthetische Sprecherstimme]' }];
for (const a of ABSCHNITTE) {
  let k = 0;
  for (const [text, n] of a.cues) {
    cues.push({ von: a.tonStart + a.segmente[k][0], bis: a.tonStart + a.segmente[k + n - 1][1], text });
    k += n;
  }
}
// Kurze Lücken (< 1 s) schließen, damit die Untertitel nicht flackern.
cues.forEach((c, k) => {
  const next = cues[k + 1];
  if (next && next.von - c.bis < 1) c.bis = next.von;
  else if (!next) c.bis = Math.min(c.bis + 0.5, gesamt);
});
const probleme = [];
cues.forEach((c, k) => {
  const d = c.bis - c.von;
  if (d < 1 || d > 6) probleme.push(`Einblendung ${k + 1}: ${d.toFixed(2)} s`);
  const zeilen = c.text.split('\n');
  if (zeilen.length > 2) probleme.push(`Einblendung ${k + 1}: ${zeilen.length} Zeilen`);
  zeilen.forEach((z) => z.length > ZEILE_MAX && probleme.push(`Einblendung ${k + 1}: ${z.length} Zeichen „${z}“`));
});
if (probleme.length) throw new Error('Untertitel:\n' + probleme.join('\n'));
const vtt = 'WEBVTT\n\n' + cues.map((c, k) => `${k + 1}\n${zeit(c.von)} --> ${zeit(c.bis)}\n${c.text}\n`).join('\n');

// 3. Folien als PNG (1920×1080) im Design des Themes.
// Schrift als data:-URL: Eine per setContent geladene Seite darf nicht auf file:// zugreifen.
const font = (w) => 'data:font/woff2;base64,' + readFileSync(join(THEME, `fonts/atkinson-hyperlegible-latin-${w}-normal.woff2`)).toString('base64');
const css = `
@font-face { font-family: "Atkinson Hyperlegible"; font-weight: 400; src: url("${font(400)}") format("woff2"); }
@font-face { font-family: "Atkinson Hyperlegible"; font-weight: 700; src: url("${font(700)}") format("woff2"); }
:root { --c-text: #1d1b20; --c-text-muted: #57525e; --c-accent: #b3145c; --c-accent-dark: #8c0f48;
  --c-accent-soft: #fde7f1; --c-hint-bg: #fff3b0; --c-surface: #f6f4f7; --c-line: #d9d4dd; }
* { box-sizing: border-box; margin: 0; }
html, body { width: 1920px; height: 1080px; overflow: hidden; }
body { font-family: "Atkinson Hyperlegible", sans-serif; color: var(--c-text); background: #fff; font-size: 56px; line-height: 1.3; }
.bar { display: flex; align-items: center; gap: 24px; padding: 20px 96px; background: var(--c-hint-bg);
  border-bottom: 6px solid var(--c-text); font-size: 48px; }
.bar svg { width: 52px; height: 52px; flex: none; }
.kopf { padding: 28px 96px 0; }
.wortmarke { font-size: 56px; font-weight: 700; line-height: 1.15; }
.wortmarke::after { content: ""; display: block; width: 88px; height: 9px; margin-top: 10px; background: var(--c-accent); }
main { padding: 36px 96px 0; }
h1.titel { font-size: 136px; line-height: 1.1; margin-top: 60px; }
.lang { margin-top: 32px; color: var(--c-text-muted); font-size: 64px; }
h2 { font-size: 88px; line-height: 1.1; margin-bottom: 36px; }
.reihe { display: flex; gap: 72px; align-items: center; }
.symbol { width: 200px; height: 200px; flex: none; fill: none; stroke: var(--c-accent); stroke-width: 3.2; stroke-linecap: round; stroke-linejoin: round; }
.gross { font-size: 68px; max-width: 1250px; }
.liste { list-style: none; padding: 0; font-size: 64px; }
.liste li { display: flex; align-items: center; gap: 36px; margin-bottom: 12px; }
.liste li::before { content: ""; width: 32px; height: 32px; background: var(--c-accent); flex: none; }
.symbole { list-style: none; padding: 0; display: flex; gap: 120px; }
.symbole li { display: flex; flex-direction: column; align-items: center; gap: 16px; font-size: 56px; font-weight: 700; }
.termine { border: 4px solid var(--c-line); border-left: 16px solid var(--c-accent); background: var(--c-surface); padding: 20px 40px; max-width: 1728px; }
.termine__titel { font-weight: 700; margin-bottom: 8px; font-size: 52px; }
.termine dl > div { display: flex; gap: 48px; padding: 6px 0; border-top: 3px solid var(--c-line); font-size: 48px; }
.termine dt { font-weight: 700; width: 480px; flex: none; }
.adresse { font-size: 88px; font-weight: 700; color: var(--c-accent-dark); margin-bottom: 48px; }
.knopf { display: inline-block; padding: 28px 64px; background: var(--c-accent); color: #fff; font-weight: 700; font-size: 68px; border-radius: 8px; }
.abspann { margin-top: 80px; font-size: 64px; }
.abspann p + p { margin-top: 32px; }
`;
const info = '<svg viewBox="0 0 24 24" fill="none" stroke="#1d1b20" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9.5"/><path d="M12 11v6"/><path d="M12 7.5h.01" stroke-width="2.5"/></svg>';
const seite = (inhalt) => `<!doctype html><html lang="de"><meta charset="utf-8"><style>${css}</style>
<div class="bar">${info}<p><strong>Musterbeitrag – keine echte Behörde.</strong></p></div>
<div class="kopf"><p class="wortmarke">LDT Musterland</p></div>
<main>${inhalt}</main></html>`;

const folien = [...ABSCHNITTE, ABSPANN_FOLIE];
const browser = await chromium.launch({ channel: 'chrome', headless: true }); // installiertes Chrome wie in tests/a11y
const page = await browser.newPage({ viewport: { width: 1920, height: 1080 }, deviceScaleFactor: 1 });
for (const [i, f] of folien.entries()) {
  f.png = join(tmp, `folie${i + 1}.png`);
  await page.setContent(seite(f.folie), { waitUntil: 'load' });
  const schrift = await page.evaluate(async () => { await document.fonts.ready; return document.fonts.check('700 56px "Atkinson Hyperlegible"') && [...document.fonts].every((f) => f.status === 'loaded'); });
  if (!schrift) throw new Error('Schrift Atkinson Hyperlegible nicht geladen.');
  // Unteres Drittel frei lassen: Dort blendet der Player Untertitel und
  // Steuerleiste ein, sie sollen keinen Folientext verdecken.
  const unten = await page.evaluate(() => Math.max(...[...document.querySelectorAll('main *')].map((e) => e.getBoundingClientRect().bottom)));
  console.log(`Folie ${i + 1}: Inhalt endet bei ${Math.round(unten)} px (${Math.round(unten / 10.8)} %)`);
  if (unten > FREI_AB) throw new Error(`Folie ${i + 1}: Inhalt reicht bis ${Math.round(unten)} px, erlaubt sind ${FREI_AB} px.`);
  await page.screenshot({ path: f.png });
}
await browser.close();
ABSPANN_FOLIE.folienDauer = ABSPANN;

// 4. Zusammensetzen: Bilder je Folie so lange wie ihr Abschnitt, Ton mit Pausen.
const stille = (s, name) => {
  const datei = join(tmp, name);
  run('ffmpeg', ['-y', '-f', 'lavfi', '-i', 'anullsrc=r=48000:cl=mono', '-t', s.toFixed(3), datei]);
  return datei;
};
const tonteile = [stille(VORLAUF, 'vorlauf.wav')];
ABSCHNITTE.forEach((a, i) => {
  tonteile.push(a.ton);
  tonteile.push(stille(a.nach + (i === ABSCHNITTE.length - 1 ? ABSPANN : 0), `pause${i + 1}.wav`));
});
const args = ['-y'];
folien.forEach((f) => args.push('-loop', '1', '-framerate', '25', '-t', f.folienDauer.toFixed(3), '-i', f.png));
tonteile.forEach((d) => args.push('-i', d));
const v = folien.map((_, i) => `[${i}:v]`).join('');
const a = tonteile.map((_, i) => `[${folien.length + i}:a]aresample=48000,aformat=channel_layouts=mono[a${i}]`).join(';');
const filter = `${v}concat=n=${folien.length}:v=1:a=0,format=yuv420p[v];${a};${tonteile.map((_, i) => `[a${i}]`).join('')}concat=n=${tonteile.length}:v=0:a=1,aformat=channel_layouts=stereo[a]`;
mkdirSync(join(FILES, 'videos'), { recursive: true });
mkdirSync(join(FILES, 'untertitel'), { recursive: true });
mkdirSync(join(FILES, 'dokumente'), { recursive: true });
const mp4 = join(FILES, 'videos/was-macht-das-ldt.mp4');
run('ffmpeg', [...args, '-filter_complex', filter, '-map', '[v]', '-map', '[a]',
  '-c:v', 'libx264', '-preset', 'slow', '-crf', '20', '-tune', 'stillimage', '-r', '25',
  '-c:a', 'aac', '-b:a', '128k', '-movflags', '+faststart',
  '-metadata', 'title=Was macht das LDT?', '-metadata:s:a:0', 'language=deu', mp4]);
writeFileSync(join(FILES, 'untertitel/was-macht-das-ldt.vtt'), vtt);

// 5. Transkript: gesprochener Text und Bildbeschreibung je Folie – als
// Textdatei zum Herunterladen und als HTML für die Seite (pages.php bindet
// scripts/video/transkript.html in den aufklappbaren Bereich ein).
const esc = (s) => s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
const kopf = [
  `Dauer: ${Math.round(dauer(mp4))} Sekunden. ${HINWEIS_MUSTER}`,
  `${HINWEIS_STIMME} Im Video gibt es keine Geräusche und keine Musik.`,
  'Auf allen Folien steht oben ein gelber Hinweis „Musterbeitrag – keine echte Behörde.“ und darunter die Wortmarke „LDT Musterland“.',
];
const abschnitte = [
  ...ABSCHNITTE.map((a, i) => ({ titel: `Abschnitt ${i + 1} (ab ${minSek(a.start)})`, bild: a.bild, text: a.text })),
  { titel: `Abspann (ab ${minSek(t)})`, bild: ABSPANN_FOLIE.bild },
];
const txt = ['Was macht das LDT? – Transkript des Erklärvideos', '', ...kopf, ''];
const html = kopf.map((z) => `<p>${esc(z)}</p>`);
for (const a of abschnitte) {
  txt.push(a.titel, `Bild: ${a.bild}`, ...(a.text ? [`Sprecherstimme: ${a.text}`] : []), '');
  html.push(`<h3>${esc(a.titel)}</h3>`, `<p><strong>Bild:</strong> ${esc(a.bild)}</p>`, ...(a.text ? [`<p><strong>Sprecherstimme:</strong> ${esc(a.text)}</p>`] : []));
}
writeFileSync(join(FILES, 'dokumente/Transkript-Was-macht-das-LDT.txt'), '\uFEFF' + txt.join('\n'));
writeFileSync(join(ROOT, 'scripts/video/transkript.html'), html.join('\n') + '\n');

console.log(`Video: ${dauer(mp4).toFixed(2)} s, ${cues.length} Untertitel-Einblendungen`);
ABSCHNITTE.forEach((a, i) => console.log(`  Abschnitt ${i + 1}: ab ${a.start.toFixed(2)} s, Ton ${a.dauer.toFixed(2)} s`));
console.log(`  Abspann: ab ${t.toFixed(2)} s, ${ABSPANN} s`);
console.log('Arbeitsordner (Folien, Ton):', tmp);
