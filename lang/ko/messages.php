<?php

declare(strict_types=1);

$startCommand = <<<'EOF'
안녕하세요! 저는 당신의 개인 비디오 요약 도우미입니다. YouTube 링크만 보내주시면 몇 초 내에 콘텐츠를 바탕으로 한 짧고 명확한 요약을 생성해드립니다.

⚡️ OpenAI + SupaData로 구동되므로 잡음 없이 핵심만 얻을 수 있습니다.
🎯 준비되셨나요? 첫 번째 비디오를 보내주세요!
EOF;

return [
    'start' => $startCommand,
];
