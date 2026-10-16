// axe-core-Prüfung aller Seiten (Desktop und 375 px) plus Sonderzustände.
// Aufruf: npm run axe   (Ergebnis zusätzlich in ergebnisse/axe.json)
import { chromium } from 'playwright';
import AxeBuilder from '@axe-core/playwright';
import { mkdirSync, writeFileSync } from 'node:fs';
import { BASE, SEITEN, VIEWPORTS, LAUNCH, CONTEXT } from './seiten.mjs';

const TAGS = ['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa', 'best-practice'];
const ergebnisse = [];

async function pruefe(page, name) {
  const r = await new AxeBuilder({ page }).withTags(TAGS).analyze();
  ergebnisse.push({ name, violations: r.violations, incomplete: r.incomplete.map((i) => ({ id: i.id, help: i.help, nodes: i.nodes.length })) });
  const n = r.violations.reduce((s, v) => s + v.nodes.length, 0);
  console.log(`${n === 0 ? 'OK    ' : 'FEHLER'} ${name}${n ? ` – ${r.violations.map((v) => `${v.id} (${v.impact}, ${v.nodes.length}×)`).join(', ')}` : ''}`);
}

const browser = await chromium.launch(LAUNCH);
for (const [vp, viewport] of Object.entries(VIEWPORTS)) {
  const ctx = await browser.newContext({ ...CONTEXT, viewport });
  const page = await ctx.newPage();
  for (const pfad of SEITEN) {
    await page.goto(BASE + pfad, { waitUntil: 'networkidle' });
    await pruefe(page, `${vp.padEnd(7)} ${pfad}`);
  }

  // Sonderzustände
  await page.goto(BASE + '/barrierefreiheit', { waitUntil: 'networkidle' });
  if (vp === 'mobil') {
    await page.getByRole('button', { name: 'Menü', exact: true }).click();
  }
  await page.getByRole('button', { name: 'Untermenü Barrierefreiheit' }).click();
  await page.waitForTimeout(400); // Farbübergänge abwarten
  await pruefe(page, `${vp.padEnd(7)} Zustand: Menü/Untermenü offen`);

  await page.goto(BASE + '/barriere-melden', { waitUntil: 'networkidle' });
  await page.waitForTimeout(5500); // Honeypot-Zeitsperre
  await page.getByRole('button', { name: 'Meldung absenden' }).click();
  await page.waitForLoadState('networkidle');
  await pruefe(page, `${vp.padEnd(7)} Zustand: Formular mit Fehlern`);
  await ctx.close();
}
await browser.close();

mkdirSync('ergebnisse', { recursive: true });
writeFileSync('ergebnisse/axe.json', JSON.stringify(ergebnisse, null, 2));
const fehler = ergebnisse.filter((e) => e.violations.length);
console.log(`\n${ergebnisse.length} Prüfungen, ${fehler.length} mit Verstößen.`);
const offen = {};
ergebnisse.forEach((e) => e.incomplete.forEach((i) => { offen[i.id] = (offen[i.id] || 0) + i.nodes; }));
console.log('Manuell zu prüfen (axe "incomplete"):', JSON.stringify(offen));
process.exitCode = fehler.length ? 1 : 0;
