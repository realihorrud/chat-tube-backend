<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Jobs\ProcessVideo;
use App\Telegram\Entities\Update;
use App\Telegram\TelegramBotApi;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Spatie\LaravelData\Optional;
use Webmozart\Assert\Assert;

final class YoutubeUrlHandler extends Handler
{
    public function __construct(private readonly TelegramBotApi $api) {}

    public function handle(Update $update): void
    {
        Log::debug(__CLASS__);
        if (! $update->message->text instanceof Optional) {
            Assert::string($update->message->text);

            try {
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

        parent::handle($update);
    }
}
