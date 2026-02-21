<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\ConversationStatus;
use App\Enums\MessageRole;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use Illuminate\Container\Attributes\Config;
use Illuminate\Support\Facades\DB;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\StreamResponse;
use Throwable;
use Webmozart\Assert\Assert;

final readonly class AskQuestion
{
    private const string INSTRUCTIONS = <<<'EOF'
Answer questions using only the video transcript retrieved from the vector store.

Guidelines:
- Respond in the user’s language.
- Format answers in Markdown.
- If the question is weakly related, unclear, or unrelated, politely decline.
- Do not supplement answers with general knowledge.
- Base every response strictly on transcript content.
- Use markdown formatting for answers.
EOF;

    public function __construct(
        #[Config('services.openai.model')]
        private string $model,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(Conversation $conversation, string $question): StreamResponse
    {
        Assert::same($conversation->status, ConversationStatus::Ready, 'Chat is not ready for questions.');
        Assert::notNull($conversation->youtubeVideo, 'Chat has no associated video.');

        DB::transaction(function () use ($conversation, $question): ConversationMessage {
            $conversationMessage = new ConversationMessage;
            $conversationMessage->role = MessageRole::User;
            $conversationMessage->content = $question;

            $conversation->conversationMessages()->save($conversationMessage);

            return $conversationMessage;
        });

        $video = $conversation->youtubeVideo;

        return OpenAI::responses()->createStreamed([
            'model' => $this->model,
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
