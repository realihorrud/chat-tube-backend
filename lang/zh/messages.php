<?php

declare(strict_types=1);

$startCommand = <<<'EOF'
你好！我是你的个人视频摘要助手。只需发送YouTube链接，我就能在几秒钟内基于视频内容生成简短清晰的摘要。

⚡️ 基于OpenAI + SupaData技术，为你提取精华，去除噪音。
🎯 准备好了吗？发送你的第一个视频！
EOF;

return [
    'start' => $startCommand,
];
