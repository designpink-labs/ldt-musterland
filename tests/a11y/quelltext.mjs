// Ausgeliefertes HTML, CSS und JS enthalten den Namen "designpink" nicht
// (außer im Hostnamen der Adresse, z. B. im canonical-Link).
// Ausgenommen: Impressum und Datenschutz (dort stehen die echten
// Betreiberangaben).
import { request } from 'playwright';
import { BASE, SEITEN } from './seiten.mjs';

const AUSGENOMMEN = ['/impressum', '/datenschutz'];
const host = new URL(BASE).host.replace(/[.:]/g, (z) => '\\' + z);
// Hostname auch URL-kodiert, z. B. im Link „Barriere melden“ (?seite=https%3A//…).
const ohneHost = (s) => s.replace(/%3A/gi, ':').replace(new RegExp(`https?://${host}`, 'gi'), '');

const ctx = await request.newContext({ ignoreHTTPSErrors: true });
const pfade = [...SEITEN.filter((p) => !AUSGENOMMEN.includes(p)), '/sitemap.xml', '/robots.txt'];
const assets = new Set();
let fehler = 0;
const pruefen = (name, text) => {
  const treffer = [...ohneHost(text).matchAll(/.{0,30}designpink.{0,30}/gi)].map((m) => m[0].trim());
  if (treffer.length) {
    fehler++;
    console.log(`FEHLER ${name}\n  ${treffer.slice(0, 3).join('\n  ')}`);
  }
};
for (const p of pfade) {
  const text = await (await ctx.get(BASE + p)).text();
  pruefen(p, text);
  for (const m of text.matchAll(/(?:href|src)="([^"]*\/files\/(?:css|js)\/[^"]+)"/g)) assets.add(m[1].replace(/&amp;/g, '&'));
}
for (const a of assets) pruefen(a.split('?')[0], await (await ctx.get(new URL(a, BASE).href)).text());
await ctx.dispose();
console.log(`${pfade.length} Seiten und ${assets.size} CSS/JS-Dateien geprüft.`);
console.log(fehler === 0 ? 'Kein „designpink“ im ausgelieferten Quelltext.' : `${fehler} Fundstelle(n).`);
process.exitCode = fehler ? 1 : 0;
