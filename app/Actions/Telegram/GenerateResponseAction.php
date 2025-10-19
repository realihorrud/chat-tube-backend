<?php

declare(strict_types=1);

namespace App\Actions\Telegram;

use App\DTOs\GenerateResponseDTO;
use App\Events\VideoSummarized;
use App\Exceptions\CouldNotGenerateResponseException;
use App\Models\User;
use App\Supadata\SupadataSdk;
use App\ValueObjects\YoutubeUrl;
use Exception;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use OpenAI\Client;
use RuntimeException;

final readonly class GenerateResponseAction
{
    public function __construct(private SupadataSdk $supadataSDK, private Client $client) {}

    public function run(GenerateResponseDTO $dto): ?string
    {
        try {
            $url = YoutubeUrl::fromString($dto->text);
        } catch (InvalidArgumentException) {
            throw CouldNotGenerateResponseException::becauseYoutubeUrlIsNotValid($dto->chat_id);
        }

        /** @var User $user */
        $user = User::query()->firstWhere('telegram_id', $dto->telegram_id);

        // To middleware, because we do not need to go so deep in order to understand that user cannot perform a request
        // $user->requests()->where('created_at', '')->count();
        // TODO: check limits for specific user... should be in gate obviously

        try {
            $response = $this->supadataSDK->youtube()->transcript($url);
        } catch (RuntimeException $e) {
            throw CouldNotGenerateResponseException::becauseOfSupadataError($dto->chat_id, $e->getMessage());
        }

        $text = $response->text();

        Log::channel('api')->info($text);

        try {
            $response = $this->client->responses()->create([
                'model' => config('services.open_ai.model'),
                'instructions' => $user->settings->mode->value,
                'input' => $text,
            ]);
        } catch (Exception $e) {
            Log::channel('api')->info($e->getMessage());

            return 'Something went wrong...';
        }

        event(new VideoSummarized($dto->telegram_id));

        return $response->outputText;
    }
}
