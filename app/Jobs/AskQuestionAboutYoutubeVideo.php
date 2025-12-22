<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Events\AIAnsweredQuestion;
use App\Models\ChatState;
use App\Models\YoutubeVideo;
use App\Services\LoadersService;
use App\Services\ResponseService;
use App\Telegram\TelegramBotApi;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use OpenAI\Laravel\Facades\OpenAI;
use Throwable;
use Webmozart\Assert\Assert;

final class AskQuestionAboutYoutubeVideo implements ShouldQueue
{
    use Queueable;

    private const string INSTRUCTIONS = 'Answer questions in user\'s language based on the video transcript from vector file store. First answer, then add evidence from transcript with timestamps if applicable, if not just answer. Prefer markdown style, but without headings, because it\'s intended for Telegram. Answer only on questions related to video\'s transcript';

    public int $timeout = 180;

    public function __construct(
        public readonly int $chatId,
        public readonly string $text,
        public readonly bool $askedImmediately = false,
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(TelegramBotApi $api, ResponseService $responseService, LoadersService $loaderService): void
    {
        $chatState = ChatState::byChatId($this->chatId)->first();

        $loaderService->startProgress('Answering your question', $this->chatId, ! $this->askedImmediately);

        $video = YoutubeVideo::latestUploadedVideo($this->chatId)->first();

        $loaderService->incrementLoadingBy($this->chatId, by: 6, times: 9);

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

        $loaderService->incrementLoadingBy($this->chatId, by: 6);

        Assert::string($response->outputText);

        $loaderService->incrementLoadingBy($this->chatId, times: 3);

        $chatState->refresh();

        $api->editMessageText([
            'message_id' => (int) $chatState->last_message_id,
            'chat_id' => $this->chatId,
            'text' => $responseService->linkTimestamps($response->outputText, YoutubeUrl::fromString($video->url)),
            'parse_mode' => 'Markdown',
            'link_preview_options' => [
                'is_disabled' => true,
            ],
            'reply_markup' => [
                'inline_keyboard' => [
                    [['text' => 'Without timestamps', 'callback_data' => 'without_timestamps']],
                ],
            ],
        ]);

        AIAnsweredQuestion::dispatch($this->chatId);
    }
}
