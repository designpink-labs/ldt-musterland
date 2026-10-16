// Meta-Beschreibungen: höchstens 160 Zeichen (so kürzt Metatag beim Ausgeben)
// und endet auf den Musterseiten-Zusatz. Ausgenommen: Impressum und
// Datenschutz (eigene Texte mit Platzhaltern) sowie der Styleguide (noindex).
import { request } from 'playwright';
import { BASE, SEITEN } from './seiten.mjs';

const MAX = 160;
const ZUSATZ = ' – Musterseite einer fiktiven Behörde';
const AUSGENOMMEN = ['/impressum', '/datenschutz', '/styleguide'];

const entities = { amp: '&', quot: '"', '#039': "'", apos: "'", lt: '<', gt: '>', nbsp: ' ' };
const dekodieren = (s) => s
  .replace(/&#(\d+);/g, (_, n) => String.fromCodePoint(Number(n)))
  .replace(/&([a-z]+|#039);/g, (m, n) => entities[n] ?? m);

const ctx = await request.newContext({ ignoreHTTPSErrors: true });
let fehler = 0;
for (const pfad of SEITEN) {
  if (AUSGENOMMEN.includes(pfad)) continue;
  const antwort = await ctx.get(BASE + pfad);
  if (antwort.status() === 404) continue; // Fehlerseite
  const html = await antwort.text();
  const treffer = html.match(/<meta name="description" content="([^"]*)"/);
  const text = treffer ? dekodieren(treffer[1]) : '';
  const probleme = [];
  if (!text) probleme.push('keine Meta-Beschreibung');
  else {
    if (text.length > MAX) probleme.push(`${text.length} Zeichen (höchstens ${MAX})`);
    if (!text.endsWith(ZUSATZ)) probleme.push('endet nicht auf „– Musterseite einer fiktiven Behörde“');
  }
  if (probleme.length) fehler++;
  console.log(`${probleme.length ? 'FEHLER' : 'OK    '} ${String(text.length).padStart(3)}  ${pfad}${probleme.length ? '  → ' + probleme.join(', ') : ''}`);
}
await ctx.dispose();
console.log(`\n${fehler === 0 ? 'Alle Meta-Beschreibungen in Ordnung.' : fehler + ' Seite(n) mit Problemen.'}`);
process.exitCode = fehler ? 1 : 0;
