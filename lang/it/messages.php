<?php

declare(strict_types=1);

$startCommand = <<<'EOF'
Ciao! Sono il tuo assistente personale per i riassunti video. Inviami semplicemente un link di YouTube e in pochi secondi genererò un riassunto breve e chiaro basato sul suo contenuto.

⚡️ Alimentato da OpenAI + SupaData, ottieni l'essenza senza tutto il rumore.
🎯 Pronto? Invia il tuo primo video!
EOF;

return [
    'start' => $startCommand,
];
