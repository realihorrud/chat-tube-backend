<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\ChatStatus;
use App\Enums\MessageRole;
use App\Models\Chat;
use App\Models\Message;
use App\Services\ResponseService;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\StreamResponse;
use Throwable;
use Webmozart\Assert\Assert;

final readonly class AskQuestion
{
    private const string INSTRUCTIONS = <<<EOF
Answer questions using only the video transcript retrieved from the vector store.

Guidelines:
- Respond in the user’s language.
- Format answers in Markdown.
- If the question is weakly related, unclear, or unrelated, politely decline.
- Do not supplement answers with general knowledge.
- Base every response strictly on transcript content.
EOF;

    /**
     * @throws Throwable
     */
    public function handle(Chat $chat, string $question): StreamResponse
    {
        Assert::same($chat->status, ChatStatus::Ready, 'Chat is not ready for questions.');
        Assert::notNull($chat->youtubeVideo, 'Chat has no associated video.');

        DB::transaction(function () use ($chat, $question): Message {
            $message = new Message;
            $message->role = MessageRole::User;
            $message->content = $question;

            $chat->messages()->save($message);

            return $message;
        });

        $video = $chat->youtubeVideo;

        return OpenAI::responses()->createStreamed([
            'model' => 'gpt-5',
            'instructions' => self::INSTRUCTIONS,
            'input' => $question,
            'tools' => [
                [
                    'type' => 'file_search',
                    'vector_store_ids' => [
                        $video->vector_store_id,
                    ],
                ],
            ],
        ]);
    }
}
