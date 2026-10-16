// Reflow (WCAG 1.4.10): 320 CSS-Pixel Breite entspricht 1280 px bei 400 % Zoom.
// Prüft jede Seite auf waagerechtes Scrollen (Datentabellen ausgenommen).
import { chromium } from 'playwright';
import { BASE, SEITEN, LAUNCH, CONTEXT } from './seiten.mjs';
const browser = await chromium.launch(LAUNCH);
const ctx = await browser.newContext({ ...CONTEXT, viewport: { width: 320, height: 640 } });
const page = await ctx.newPage();
let fehler = 0;
for (const pfad of SEITEN) {
  await page.goto(BASE + pfad, { waitUntil: 'networkidle' });
  const w = await page.evaluate(() => document.documentElement.scrollWidth);
  const ok = w <= 320;
  if (!ok) fehler++;
  console.log(`${ok ? 'OK    ' : 'FEHLER'} ${pfad} (${w} px)`);
}
await browser.close();
console.log(fehler ? `${fehler} Seite(n) mit waagerechtem Scrollen.` : 'Keine Seite scrollt waagerecht bei 320 px.');
process.exitCode = fehler ? 1 : 0;
