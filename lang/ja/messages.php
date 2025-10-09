<?php

declare(strict_types=1);

$startCommand = <<<'EOF'
こんにちは！私はあなたの動画要約アシスタントです。YouTubeリンクを送るだけで、数秒でコンテンツに基づいた短く明確な要約を生成します。

⚡️ OpenAI + SupaDataを搭載しているので、ノイズなしで本質を得られます。
🎯 準備はいいですか？最初の動画を送ってください！
EOF;

return [
    'start' => $startCommand,
];
