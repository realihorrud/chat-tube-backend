<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Events\AIAnsweredQuestion;
use App\Models\YoutubeVideo;
use App\Services\ResponseService;
use App\Telegram\TelegramBotApi;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use OpenAI\Laravel\Facades\OpenAI;
use Webmozart\Assert\Assert;

final class AskQuestionAboutYoutubeVideo implements ShouldQueue
{
    use Queueable;

    private const string INSTRUCTIONS = 'Answer questions in user\'s language based on the video transcript from vector file store. First answer, then add evidence from transcript with timestamps if applicable, if not just answer. Prefer markdown style, but without headings, because it\'s intended for Telegram. Answer only on questions related to video\'s transcript';

    public int $timeout = 180;

    public function __construct(
        public readonly int $chatId,
        public readonly string $text,
    ) {}

    public function handle(TelegramBotApi $api, ResponseService $responseService): void
    {
        $api->sendMessage([
            'chat_id' => $this->chatId,
            'text' => '_Loading answer..._',
            'parse_mode' => 'Markdown',
        ]);

        $video = YoutubeVideo::latestUploadedVideo($this->chatId)->first();

        $response = OpenAI::responses()->create([
            'model' => 'gpt-5',
            'instructions' => self::INSTRUCTIONS,
            'input' => $this->text,
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

        $api->sendMessage([
            'chat_id' => $this->chatId,
            'text' => $responseService->linkTimestamps($response->outputText, YoutubeUrl::fromString($video->url)),
            'reply_markup' => [
                'inline_keyboard' => [
                    [['text' => 'Without timestamps', 'callback_data' => 'without_timestamps']],
                ],
            ],
            'parse_mode' => 'Markdown',
            'link_preview_options' => [
                'is_disabled' => true,
            ],
        ]);

        event(new AIAnsweredQuestion($this->chatId));
    }
}
