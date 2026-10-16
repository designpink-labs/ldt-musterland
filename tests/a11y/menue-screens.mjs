// Screenshots mit geöffnetem Menü (mobil) und geöffnetem Untermenü (Desktop).
import { chromium } from 'playwright';
import { BASE, VIEWPORTS, LAUNCH, CONTEXT } from './seiten.mjs';
const browser = await chromium.launch(LAUNCH);
let page = await browser.newPage({ ...CONTEXT, viewport: VIEWPORTS.mobil });
await page.goto(BASE + '/barrierefreiheit', { waitUntil: 'networkidle' });
await page.getByRole('button', { name: 'Menü', exact: true }).click();
await page.getByRole('button', { name: 'Untermenü Barrierefreiheit' }).click();
await page.screenshot({ path: 'ergebnisse/mobil_menue-offen.png', fullPage: false });
await page.close();
page = await browser.newPage({ ...CONTEXT, viewport: VIEWPORTS.desktop });
await page.goto(BASE + '/barrierefreiheit/leichte-sprache', { waitUntil: 'networkidle' });
await page.getByRole('button', { name: 'Untermenü Barrierefreiheit' }).focus();
await page.keyboard.press('Enter');
await page.keyboard.press('Tab');
await page.screenshot({ path: 'ergebnisse/desktop_untermenue-offen.png', clip: { x: 0, y: 0, width: 1280, height: 520 } });
await browser.close();
