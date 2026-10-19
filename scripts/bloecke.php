<?php

/**
 * @file
 * Inhaltsblöcke (Daten für scripts/create-bloecke.php).
 *
 * Die UUID ist fest, weil die Blockplatzierung (config/sync/
 * block.block.ldt_musterland_kontakt.yml) über sie auf den Block verweist.
 */

return [
  'kontakt' => [
    'uuid' => '8bd964f7-1ce5-4012-ab3e-854d040280e1',
    'typ' => 'kontakt',
    'info' => 'Kontakt im Seitenfuß',
    'felder' => [
      'field_name' => 'Landesamt für Digitale Teilhabe Musterland',
      'field_anschrift' => "Musterstraße 1\n12345 Musterstadt",
      'field_telefon' => '0000 000000',
      'field_email' => 'poststelle@ldt-musterland.example',
      'field_hinweis' => 'Fiktive Beispieldaten',
    ],
    // Platzierung im Theme ldt_musterland.
    'block_id' => 'ldt_musterland_kontakt',
    'region' => 'footer_kontakt',
  ],
];
