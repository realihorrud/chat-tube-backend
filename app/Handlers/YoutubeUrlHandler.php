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
        if (! $update->message instanceof Optional && YoutubeUrl::isValid($update->message->text)) {
            Assert::string($update->message->text);

            try {
                $this->chatStatesService->updateOrCreateState(UpdateOrCreateChatStateDTO::from([
                    'chat_id' => $update->message->chat->id,
                    'state' => State::ProcessingVideo,
                    'last_update' => $update,
                ]));

                $this->api->sendMessage([
                    'chat_id' => $update->message->chat->id,
                    'text' => __('messages.video_processing'),
                    'parse_mode' => 'Markdown',
                ]);

                dispatch(
                    new ProcessVideo(
                        chatId: $update->message->chat->id,
                        videoUrl: YoutubeUrl::fromString($update->message->text),
                    )
                );
            } catch (InvalidArgumentException $exception) {
                $this->api->sendMessage([
                    'chat_id' => $update->message->chat->id,
                    'text' => $exception->getMessage(),
                ]);
            }

            return;
        }

        parent::handle($update, $state);
    }
}
