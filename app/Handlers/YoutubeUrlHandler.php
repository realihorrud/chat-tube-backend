<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTOs\ChatState\UpdateOrCreateChatStateDTO;
use App\Enums\State;
use App\Jobs\ProcessYoutubeVideo;
use App\Models\ChatState;
use App\Services\ChatStatesService;
use App\Telegram\Entities\Update;
use App\ValueObjects\YoutubeUrl;
use Spatie\LaravelData\Optional;
use Throwable;
use Webmozart\Assert\Assert;

final class YoutubeUrlHandler extends Handler
{
    public function __construct(
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

            $this->chatStatesService->updateOrCreateState(UpdateOrCreateChatStateDTO::from([
                'chat_id' => $chatId,
                'state' => State::ProcessingVideo,
                'last_update' => $update,
            ]));

            dispatch(
                new ProcessYoutubeVideo(
                    chatId: $chatId,
                    videoUrl: $youtubeUrl,
                    question: mb_trim($question),
                )
            );

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
