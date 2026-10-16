// Gemeinsame Einstellungen für alle Prüfskripte.
export const BASE = process.env.BASE_URL || 'https://designpink.ddev.site:33001';
export const SEITEN = [
  '/', '/barrierefreiheit', '/barrierefreiheit/barrierefreie-dokumente',
  '/barrierefreiheit/leichte-sprache', '/barrierefreiheit/video-untertitel',
  '/barrierefreiheit/gebaerdensprache', '/online-redaktion',
  '/online-redaktion/texte-fuers-web', '/online-redaktion/arbeitshilfe-redaktion',
  '/online-redaktion/social-media', '/web-optimierung',
  '/web-optimierung/informationsarchitektur', '/web-optimierung/seo-geo',
  '/web-optimierung/webanalyse-mit-matomo', '/web-optimierung/fehlermeldungen-bearbeiten', '/web-optimierung/so-ist-diese-website-entstanden', '/schulungen', '/aktuelles', '/aktuelles/europaeische-norm-setzt-jetzt-auf-wcag-2-2', '/aktuelles/ein-jahr-barrierefreiheitsstaerkungsgesetz', '/aktuelles/ki-suche-was-der-ki-modus-von-google-fuer-behoerdenseiten-bedeutet', '/ueber-uns-kontakt',
  '/erklaerung-zur-barrierefreiheit', '/barriere-melden', '/leichte-sprache',
  '/gebaerdensprache', '/impressum', '/datenschutz', '/styleguide', '/gibt-es-nicht',
];
export const VIEWPORTS = {
  desktop: { width: 1280, height: 900 },
  mobil: { width: 375, height: 812 },
};
export const LAUNCH = { channel: 'chrome', headless: true };
export const CONTEXT = { ignoreHTTPSErrors: true, locale: 'de-DE' };
