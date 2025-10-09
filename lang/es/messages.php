<?php

declare(strict_types=1);

$startCommand = <<<'EOF'
¡Hola! Soy tu asistente personal para resúmenes de videos. Solo envíame un enlace de YouTube y en segundos generaré un resumen corto y claro basado en su contenido.

⚡️ Impulsado por OpenAI + SupaData, obtienes la esencia sin todo el ruido.
🎯 ¿Listo? ¡Envía tu primer video!
EOF;

return [
    'start' => $startCommand,
];
