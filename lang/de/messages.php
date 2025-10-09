<?php

declare(strict_types=1);

$startCommand = <<<'EOF'
Hallo! Ich bin dein persönlicher Assistent für Video-Zusammenfassungen. Schicke mir einfach einen YouTube-Link und ich erstelle dir innerhalb von Sekunden eine kurze und klare Zusammenfassung basierend auf dem Inhalt.

⚡️ Angetrieben von OpenAI + SupaData, erhältst du das Wesentliche ohne den ganzen Lärm.
🎯 Bereit? Schicke dein erstes Video!
EOF;

return [
    'start' => $startCommand,
];
