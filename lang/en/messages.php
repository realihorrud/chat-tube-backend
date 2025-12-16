<?php

declare(strict_types=1);

$startCommand = <<<'EOF'
Hi there! I’m your personal assistant for video summaries. Just send me a YouTube link, and within seconds, I’ll generate a short and clear summary based on its content.

⚡️ Powered by OpenAI + SupaData, so you get the essence without all the noise.
🎯 Ready? Send your first video!
EOF;

return [
    'start' => $startCommand,
    'cleared' => 'Context has been cleared. Now you can upload another video.',
    'video_processing' => '_Video is being processed... It may take up to 30 seconds._',
];
