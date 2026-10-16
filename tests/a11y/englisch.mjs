// Sucht englische Reste in sichtbarem Text und in Screenreader-Texten.
import { chromium } from 'playwright';
import { BASE, SEITEN, LAUNCH, CONTEXT } from './seiten.mjs';
const WOERTER = /\b(the|and|of|to|skip|main|content|menu|navigation|home|log ?in|log ?out|user|account|powered|search|submit|read more|toggle|close|open|breadcrumb|footer|header|status|message|error|warning|page|next|previous|first|last|show|hide|loading|field|required|select|none|more)\b/i;
const browser = await chromium.launch(LAUNCH);
const ctx = await browser.newContext({ ...CONTEXT, viewport: { width: 1280, height: 900 } });
const page = await ctx.newPage();
const funde = new Map();
for (const pfad of [...SEITEN, '/user/login']) {
  await page.goto(BASE + pfad, { waitUntil: 'networkidle' });
  const texte = await page.evaluate(() => {
    const out = [];
    document.querySelectorAll('[aria-label],[title],[alt],[placeholder],[aria-roledescription]').forEach((e) => {
      ['aria-label', 'title', 'alt', 'placeholder', 'aria-roledescription'].forEach((a) => e.getAttribute(a) && out.push(`${a}: ${e.getAttribute(a)}`));
    });
    const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
    while (walker.nextNode()) {
      const t = walker.currentNode.textContent.trim();
      const p = walker.currentNode.parentElement;
      if (t && p && !p.closest('script,style,code,.styleguide code')) out.push(t);
    }
    document.querySelectorAll('input[type=submit],button').forEach((b) => out.push(`button: ${b.value || b.innerText}`));
    return out;
  });
  texte.filter((t) => WOERTER.test(t)).forEach((t) => funde.set(t.slice(0, 100), [...(funde.get(t.slice(0, 100)) || []), pfad]));
}
await browser.close();
for (const [t, p] of funde) console.log(`„${t}“  (${p.length}×, z. B. ${p[0]})`);
console.log(funde.size ? `\n${funde.size} Verdachtsfälle – bitte prüfen.` : 'Keine englischen Reste gefunden.');
