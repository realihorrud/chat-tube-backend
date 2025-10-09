<?php

declare(strict_types=1);

$startCommand = <<<'EOF'
Cześć! Jestem twoim osobistym asystentem do streszczeń wideo. Wyślij mi po prostu link z YouTube, a w ciągu kilku sekund wygeneruję krótkie i przejrzyste streszczenie na podstawie jego treści.

⚡️ Zasilany przez OpenAI + SupaData, więc otrzymujesz esencję bez całego szumu.
🎯 Gotowy? Wyślij swoje pierwsze wideo!
EOF;

return [
    'start' => $startCommand,
];
