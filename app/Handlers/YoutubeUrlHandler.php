<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTOs\ChatState\UpdateOrCreateChatStateDTO;
use App\Enums\State;
use App\Jobs\ProcessVideo;
use App\Models\ChatState;
use App\Services\ChatStatesService;
use App\Telegram\Entities\Update;
use App\Telegram\TelegramBotApi;
use App\ValueObjects\YoutubeUrl;
use InvalidArgumentException;
use Spatie\LaravelData\Optional;
use Throwable;
use Webmozart\Assert\Assert;

final class YoutubeUrlHandler extends Handler
{
    public function __construct(
        private readonly TelegramBotApi $api,
        private readonly ChatStatesService $chatStatesService
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(Update $update, ?ChatState $state): void
    {
        if (! $update->message instanceof Optional) {
            $chatId = $update->message->chat->id;
            $text = $update->message->text;

            Assert::string($text);

            [$question, $youtubeUrl] = $this->parseText($text);

            if (is_null($youtubeUrl)) {
                parent::handle($update, $state);

                return;
            }

            try {
                $this->chatStatesService->updateOrCreateState(UpdateOrCreateChatStateDTO::from([
                    'chat_id' => $chatId,
                    'state' => State::ProcessingVideo,
                    'last_update' => $update,
                ]));

                dispatch(
                    new ProcessVideo(
                        chatId: $chatId,
                        videoUrl: $youtubeUrl,
                        question: mb_trim($question),
                    )
                );
            } catch (InvalidArgumentException $exception) {
                $this->api->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $exception->getMessage(),
                ]);
            }

            return;
        }

        parent::handle($update, $state);
    }

    /**
     * Parses text and returns either questions and YT URL or just YT URL
     *
     * @return array<string|YoutubeUrl|null>
     */
    private function parseText(string $text): array
    {
        $youtubeUrl = null;
        foreach (explode(' ', $text) as $item) {
            if (YoutubeUrl::isValid($item)) {
                $youtubeUrl = YoutubeUrl::fromString($item);
                $text = str_replace($item, '', $text);
            }
        }

        return [$text, $youtubeUrl];
    }
}
