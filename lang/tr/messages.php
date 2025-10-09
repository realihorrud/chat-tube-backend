<?php

declare(strict_types=1);

$startCommand = <<<'EOF'
Merhaba! Video özetleri için kişisel asistanınızım. Sadece bana bir YouTube linki gönderin, saniyeler içinde içeriğine dayalı kısa ve net bir özet oluştururum.

⚡️ OpenAI + SupaData ile güçlendirilmiş, gürültü olmadan özü alıyorsunuz.
🎯 Hazır mısınız? İlk videonuzu gönderin!
EOF;

return [
    'start' => $startCommand,
];
