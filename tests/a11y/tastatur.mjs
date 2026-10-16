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
// So oft Tab, wie das Untermenü Links hat, plus einmal: dann ist der Fokus draußen.
const unterlinks = await page.locator('#' + await btn.getAttribute('aria-controls') + ' a').count();
await tab(page, unterlinks + 1);
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
await page.locator('#edit-problem-inhalt').focus();
const felder = [(await fokus(page)).id];
for (let i = 0; i < 12; i++) { const t = await tab(page); felder.push(t.id || t.name); }
console.log('  Reihenfolge: ' + felder.join(' → '));
const erwartet = ['edit-problem-inhalt', 'edit-seite', 'edit-beschreibung',
  'edit-hilfsmittel-screenreader', 'edit-hilfsmittel-vergroesserung', 'edit-hilfsmittel-tastatur',
  'edit-hilfsmittel-sprachsteuerung', 'edit-hilfsmittel-keine-angabe', 'edit-geraet', 'edit-email',
  'Datenschutzerklärung', 'edit-actions-submit', 'Erklärung zur Barrierefreiheit'];
ok(felder.join(',') === erwartet.join(','), 'Felder in logischer Reihenfolge: Radio-Gruppe = ein Tab-Stopp, Checkboxen einzeln, Honeypot nicht erreichbar, danach „So geht es weiter“');
await tab(page, 1, true); // zurück zum Absende-Knopf
await page.waitForTimeout(5500);
await page.keyboard.press('Enter');
await page.waitForLoadState('networkidle');
await page.waitForTimeout(300);
const aufListe = await page.evaluate(() => {
  const el = document.activeElement;
  return { liste: el.matches('.messages--error[tabindex="-1"]'), text: (el.innerText || '').trim().replace(/\s+/g, ' ').slice(0, 60) };
});
ok(aufListe.liste, `Nach dem Absenden steht der Fokus auf der Fehlerliste („${aufListe.text}…“)`);
f = await tab(page);
ok(f.name.startsWith('Was ist das Problem'), `Nächster Tab führt zum ersten Fehler-Link („${f.name}“)`);
const zuGruppe = page.locator('[role="alert"] a[href="#edit-problem"]');
await zuGruppe.first().waitFor({ timeout: 10000 }).catch(() => {});
ok(await zuGruppe.count() === 1, 'Fehlerliste (role=alert) verlinkt auf die Radio-Gruppe');
await zuGruppe.focus();
await page.keyboard.press('Enter');
f = await fokus(page);
ok(f.id === 'edit-problem-inhalt', `Link zur Radio-Gruppe setzt den Fokus auf den ersten Radio-Knopf (${f.id})`);
const gruppe = await page.locator('#edit-problem--wrapper').evaluate((e) => ({ desc: e.getAttribute('aria-describedby') || '', fehler: document.getElementById('edit-problem--error')?.textContent.trim() }));
ok(gruppe.desc.includes('edit-problem--error') && !!gruppe.fehler, `Radio-Gruppe (fieldset) ist mit der Fehlermeldung verknüpft (aria-describedby="${gruppe.desc}": „${gruppe.fehler}“)`);
ok(await page.locator('#edit-problem-inhalt').getAttribute('required') !== null, 'Radio-Knöpfe sind als Pflicht gekennzeichnet (required)');
await page.keyboard.press('ArrowDown');
f = await fokus(page);
ok(f.id === 'edit-problem-bedienung' && await page.locator('#edit-problem-bedienung').isChecked(), 'Pfeiltaste wählt die nächste Option aus');
const zusammenfassung = page.locator('[role="alert"] a[href="#edit-seite"]');
// (Fokus-Prüfung der Fehlerliste steht oben, direkt nach dem Absenden.)
ok(await zusammenfassung.count() === 1, 'Fehlerliste verlinkt auf das Feld „Seite“');
await zusammenfassung.focus();
await page.keyboard.press('Enter');
f = await fokus(page);
ok(f.id === 'edit-seite', 'Link in der Fehlerliste setzt den Fokus ins Feld');
const desc = await page.locator('#edit-seite').getAttribute('aria-describedby');
ok(desc.includes('edit-seite--error'), `Feld ist mit der Fehlermeldung verknüpft (aria-describedby="${desc}")`);
await ctx.close();

// 5. Formular aus dem Seitenfuß: Feld "Betroffene Seite" ist vorausgefüllt
console.log('\n[Desktop] „Barriere melden“ aus dem Seitenfuß');
ctx = await browser.newContext({ ...CONTEXT, viewport: VIEWPORTS.desktop });
page = await ctx.newPage();
await page.goto(BASE + '/impressum', { waitUntil: 'networkidle' });
const fussLink = page.locator('footer a', { hasText: 'Barriere melden' });
const href = await fussLink.getAttribute('href');
ok(href.includes('?seite='), `Link im Seitenfuß übergibt die Seite (${decodeURIComponent(href)})`);
await fussLink.focus();
await page.keyboard.press('Enter');
await page.waitForLoadState('networkidle');
const vorausgefuellt = await page.locator('#edit-seite').inputValue();
ok(vorausgefuellt === BASE + '/impressum', `Feld „Betroffene Seite“ ist vorausgefüllt („${vorausgefuellt}“)`);
const hrefAufFormular = await page.locator('footer a', { hasText: 'Barriere melden' }).getAttribute('href');
ok(!hrefAufFormular.includes('?'), `Auf der Formularseite selbst kein Parameter (${hrefAufFormular})`);
await page.goto(BASE + '/barriere-melden?seite=' + encodeURIComponent('<b>/impressum</b>\n\t'), { waitUntil: 'networkidle' });
const bereinigt = await page.locator('#edit-seite').inputValue();
ok(bereinigt === '/impressum', `Parameter wird bereinigt (HTML und Steuerzeichen entfernt: „${bereinigt}“)`);
await page.goto(BASE + '/barriere-melden', { waitUntil: 'networkidle' });
ok(await page.locator('#edit-seite').inputValue() === '', 'Ohne Parameter bleibt das Feld leer');
await ctx.close();

await browser.close();
console.log(`\n${fehler === 0 ? 'Alle Tastatur-Prüfungen bestanden.' : fehler + ' Tastatur-Prüfung(en) fehlgeschlagen.'}`);
process.exitCode = fehler ? 1 : 0;
