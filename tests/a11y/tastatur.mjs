// Tastatur-Durchgang: Skip-Link, Tab-Reihenfolge mit sichtbarem Fokus,
// Untermenü (Disclosure), mobiles Menü, Formular "Barriere melden".
// Aufruf: npm run tastatur
import { chromium } from 'playwright';
import { BASE, VIEWPORTS, LAUNCH, CONTEXT } from './seiten.mjs';

let fehler = 0;
const ok = (bed, text) => { console.log(`${bed ? '  ✓' : '  ✗'} ${text}`); if (!bed) fehler++; };

// Infos zum fokussierten Element: Name, Rolle, Fokus sichtbar?
const fokus = (page) => page.evaluate(() => {
  const el = document.activeElement;
  if (!el || el === document.body) return { name: '(body)', sichtbar: false };
  const box = el.getBoundingClientRect();
  const stil = (e) => getComputedStyle(e).outlineStyle !== 'none' && parseFloat(getComputedStyle(e).outlineWidth) >= 2;
  const card = el.closest('.card');
  const name = (el.getAttribute('aria-label') || el.innerText || el.value || el.id || '').trim().replace(/\s+/g, ' ').slice(0, 50);
  return {
    name, tag: el.tagName.toLowerCase(), id: el.id,
    expanded: el.getAttribute('aria-expanded'),
    sichtbar: (stil(el) || (card && stil(card))) && box.width > 0 && box.height > 0,
  };
});

const tab = async (page, n = 1, shift = false) => { for (let i = 0; i < n; i++) await page.keyboard.press(shift ? 'Shift+Tab' : 'Tab'); return fokus(page); };

const browser = await chromium.launch(LAUNCH);

// 1. Desktop: Skip-Link und Tab-Reihenfolge
console.log('\n[Desktop] Skip-Link und Tab-Reihenfolge auf /barrierefreiheit');
let ctx = await browser.newContext({ ...CONTEXT, viewport: VIEWPORTS.desktop });
let page = await ctx.newPage();
await page.goto(BASE + '/barrierefreiheit', { waitUntil: 'networkidle' });
let f = await tab(page);
ok(f.name === 'Direkt zum Inhalt' && f.sichtbar, `1. Tab: Skip-Link „${f.name}“ sichtbar`);
await page.keyboard.press('Enter');
f = await fokus(page);
ok(f.id === 'main-content', `Enter auf Skip-Link → Fokus auf Hauptinhalt (#${f.id})`);

await page.goto(BASE + '/barrierefreiheit', { waitUntil: 'networkidle' });
const reihenfolge = [];
for (let i = 0; i < 40; i++) {
  f = await tab(page);
  if (f.name === '(body)') break; // Ende der Seite: Fokus wechselt in die Browserleiste
  reihenfolge.push(`${f.name}${f.expanded ? ` [aria-expanded=${f.expanded}]` : ''}`);
  if (!f.sichtbar) ok(false, `Fokus nicht sichtbar bei „${f.name}“`);
}
console.log('  Reihenfolge:\n    ' + reihenfolge.join('\n    '));
ok(true, 'Fokus bei allen Schritten sichtbar geprüft');

// 2. Desktop: Untermenü per Tastatur
console.log('\n[Desktop] Untermenü (Disclosure)');
await page.goto(BASE + '/', { waitUntil: 'networkidle' });
const btn = page.getByRole('button', { name: 'Untermenü Barrierefreiheit' });
await btn.focus();
await page.keyboard.press('Enter');
ok(await btn.getAttribute('aria-expanded') === 'true', 'Enter öffnet Untermenü (aria-expanded=true)');
f = await tab(page);
ok(f.name === 'Barrierefreie Dokumente' && f.sichtbar, `Tab führt in das Untermenü: „${f.name}“`);
await page.keyboard.press('Escape');
f = await fokus(page);
ok(await btn.getAttribute('aria-expanded') === 'false' && f.name === 'Untermenü Barrierefreiheit', 'Escape schließt Untermenü, Fokus zurück auf den Button');
await page.keyboard.press(' ');
ok(await btn.getAttribute('aria-expanded') === 'true', 'Leertaste öffnet Untermenü');
await tab(page, 5);
f = await fokus(page);
ok(await btn.getAttribute('aria-expanded') === 'false', `Fokus verlässt Untermenü („${f.name}“) → Untermenü schließt`);
await ctx.close();

// 3. Mobil: Menü-Button
console.log('\n[Mobil 375 px] Menü-Button');
ctx = await browser.newContext({ ...CONTEXT, viewport: VIEWPORTS.mobil });
page = await ctx.newPage();
await page.goto(BASE + '/', { waitUntil: 'networkidle' });
const menue = page.getByRole('button', { name: 'Menü', exact: true });
ok(await page.locator('#hauptnavigation').isHidden(), 'Navigation anfangs eingeklappt');
await menue.focus();
await page.keyboard.press('Enter');
ok(await menue.getAttribute('aria-expanded') === 'true' && await page.locator('#hauptnavigation').isVisible(), 'Enter öffnet Menü (aria-expanded=true)');
f = await tab(page, 3);
ok(f.sichtbar, `Tab führt durch die Navigation („${f.name}“), Fokus sichtbar`);
await page.keyboard.press('Escape');
f = await fokus(page);
ok(await menue.getAttribute('aria-expanded') === 'false' && f.name.includes('Menü'), 'Escape schließt Menü, Fokus zurück auf „Menü“');
const breite = await page.evaluate(() => document.documentElement.scrollWidth);
ok(breite <= 375, `Kein waagerechtes Scrollen (Seitenbreite ${breite} px)`);
await ctx.close();

// 4. Formular
console.log('\n[Desktop] Formular „Barriere melden“');
ctx = await browser.newContext({ ...CONTEXT, viewport: VIEWPORTS.desktop });
page = await ctx.newPage();
await page.goto(BASE + '/barriere-melden', { waitUntil: 'networkidle' });
await page.locator('#edit-seite').focus();
const felder = [(await fokus(page)).id];
for (let i = 0; i < 4; i++) { const t = await tab(page); felder.push(t.id || t.name); }
console.log('  Reihenfolge: ' + felder.join(' → '));
ok(felder.join(',') === 'edit-seite,edit-beschreibung,edit-email,Datenschutzerklärung,edit-actions-submit', 'Felder in logischer Reihenfolge (mit Link zur Datenschutzerklärung), Honeypot-Feld nicht erreichbar');
await page.waitForTimeout(5500);
await page.keyboard.press('Enter');
await page.waitForLoadState('networkidle');
const zusammenfassung = page.locator('[role="alert"] a[href="#edit-seite"]');
await zusammenfassung.first().waitFor({ timeout: 10000 }).catch(() => {});
ok(await zusammenfassung.count() === 1, 'Fehlerliste (role=alert) verlinkt auf das Feld');
await zusammenfassung.focus();
await page.keyboard.press('Enter');
f = await fokus(page);
ok(f.id === 'edit-seite', 'Link in der Fehlerliste setzt den Fokus ins Feld');
const desc = await page.locator('#edit-seite').getAttribute('aria-describedby');
ok(desc.includes('edit-seite--error'), `Feld ist mit der Fehlermeldung verknüpft (aria-describedby="${desc}")`);
await ctx.close();

await browser.close();
console.log(`\n${fehler === 0 ? 'Alle Tastatur-Prüfungen bestanden.' : fehler + ' Tastatur-Prüfung(en) fehlgeschlagen.'}`);
process.exitCode = fehler ? 1 : 0;
