<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Events\VideoSummarized;
use App\Models\Prompt;
use App\Models\UserVideoRequest;
use App\Supadata\SupadataSDK;
use App\Telegram\TelegramBotApi;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use OpenAI\Client;

final class SummarizeVideoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly UserVideoRequest $userVideoRequest, private readonly Prompt $prompt) {}

    /**
     * Execute the job.
     */
    public function handle(Client $openAI, SupadataSDK $supadataSdk, TelegramBotApi $telegramBotApi): void
    {
        $transcript = $supadataSdk->youtube()->transcript(YoutubeUrl::fromString($this->userVideoRequest->video_url));

        Log::channel('supadata')->info($transcript->content);

        $response = $openAI->responses()->create([
            'model' => config('services.open_ai.model'),
            'instructions' => $this->prompt->value,
            'input' => $transcript->content,
        ]);

        Log::channel('openai')->info($response->outputText);

        $telegramBotApi->sendMessage([
            'chat_id' => $this->userVideoRequest->chat_id,
            'text' => $response->outputText ?? '',
        ]);

        event(VideoSummarized::class);
    }
}
