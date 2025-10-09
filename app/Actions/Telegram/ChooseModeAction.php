<?php

declare(strict_types=1);

namespace App\Actions\Telegram;

use App\DTOs\ChooseModeDTO;
use App\Models\Mode;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

final class ChooseModeAction
{
    /**
     * @throws Throwable
     */
    public function run(ChooseModeDTO $dto): string
    {
        return DB::transaction(function () use ($dto) {
            [, $mode] = explode('-', $dto->data);
            $mode = Mode::query()->firstWhere('key', $mode);
            if (blank($mode)) {
                throw new RuntimeException('Unknown mode: '.$mode);
            }

            $user = User::firstWhere('telegram_id', $dto->telegram_id);

            // refactor this code:
            $settings = $user->settings()->first() ?? new UserSetting();
            $settings->mode()->associate($mode);
            $user->settings()->save($settings);

            Log::info('User '.$dto->telegram_id.' changed mode to '.$mode->key);

            return __('messages.choose_mode_saved');
        });
    }
}
