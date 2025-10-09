<?php

declare(strict_types=1);

$startCommand = <<<'EOF'
Olá! Sou seu assistente pessoal para resumos de vídeos. Apenas me envie um link do YouTube e em segundos criarei um resumo curto e claro baseado no seu conteúdo.

⚡️ Powered by OpenAI + SupaData, então você recebe a essência sem todo o ruído.
🎯 Pronto? Envie seu primeiro vídeo!
EOF;

return [
    'start' => $startCommand,
];
