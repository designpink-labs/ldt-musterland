// Screenshots ausgewählter Seiten (Desktop und mobil) nach ergebnisse/.
import { chromium } from 'playwright';
import { mkdirSync } from 'node:fs';
import { BASE, VIEWPORTS, LAUNCH, CONTEXT } from './seiten.mjs';

const seiten = process.argv.slice(2).length ? process.argv.slice(2) : ['/', '/barrierefreiheit/leichte-sprache', '/barriere-melden', '/styleguide'];
mkdirSync('ergebnisse', { recursive: true });
const browser = await chromium.launch(LAUNCH);
for (const [name, viewport] of Object.entries(VIEWPORTS)) {
  const page = await browser.newPage({ ...CONTEXT, viewport });
  for (const pfad of seiten) {
    await page.goto(BASE + pfad, { waitUntil: 'networkidle' });
    const datei = `ergebnisse/${name}${pfad.replace(/\//g, '_') || '_start'}.png`;
    await page.screenshot({ path: datei, fullPage: true });
    console.log(datei);
  }
  await page.close();
}
await browser.close();
