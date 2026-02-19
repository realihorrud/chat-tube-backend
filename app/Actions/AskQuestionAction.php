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
use OpenAI\Laravel\Facades\OpenAI;
use Throwable;
use Webmozart\Assert\Assert;

final readonly class AskQuestionAction
{
    private const string INSTRUCTIONS = 'Answer questions in user\'s language based on the video transcript from vector file store. Prefer markdown style. Answer only on questions related to video\'s transcript.';

    public function __construct(private ResponseService $responseService) {}

    /**
     * @throws Throwable
     */
    public function handle(Chat $chat, string $question): Message
    {
        Assert::same($chat->status, ChatStatus::Ready, 'Chat is not ready for questions.');
        Assert::notNull($chat->youtubeVideo, 'Chat has no associated video.');

        $userMessage = DB::transaction(function () use ($chat, $question): Message {
            $message = new Message;
            $message->chat_id = $chat->id;
            $message->role = MessageRole::User;
            $message->content = $question;
            $message->save();

            return $message;
        });

        $video = $chat->youtubeVideo;

        $response = OpenAI::responses()->create([
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

        Assert::string($response->outputText);

        $answerContent = $this->responseService->linkTimestamps(
            $response->outputText,
            YoutubeUrl::fromString($video->url),
        );

        return DB::transaction(function () use ($chat, $answerContent): Message {
            $message = new Message;
            $message->chat_id = $chat->id;
            $message->role = MessageRole::Assistant;
            $message->content = $answerContent;
            $message->save();

            return $message;
        });
    }
}
