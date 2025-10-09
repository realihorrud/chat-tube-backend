<?php

declare(strict_types=1);

$startCommand = <<<'EOF'
Bonjour ! Je suis votre assistant personnel pour les résumés de vidéos. Envoyez-moi simplement un lien YouTube et en quelques secondes, je générerai un résumé court et clair basé sur son contenu.

⚡️ Alimenté par OpenAI + SupaData, vous obtenez l'essentiel sans tout le bruit.
🎯 Prêt ? Envoyez votre première vidéo !
EOF;

return [
    'start' => $startCommand,
];
