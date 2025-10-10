<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Telegram\Entities\Update;
use App\Telegram\TelegramBotApi;
use Illuminate\Console\Command;

final class ChooseModeCommand extends Command
{
    protected $signature = 'modes';

    protected $description = 'Choose mode';

    public function handle(Update $update, TelegramBotApi $api): void
    {
        //        $inlineKeyboard = Keyboard::make()->inline();
        //        Mode::all()->each(function (Mode $mode) use ($inlineKeyboard) {
        //            $inlineKeyboard->row([
        //                Keyboard::inlineButton([
        //                    'text' => __("modes.$mode->key"),
        //                    'callback_data' => ChooseModeAction::class.'-'.$mode->key,
        //                ]),
        //            ]);
        //        });
        //
        //        $this->replyWithMessage([
        //            'text' => __('messages.choose_mode'),
        //            'reply_markup' => $inlineKeyboard,
        //        ]);
    }
}
