<?php

declare(strict_types=1);

namespace App\Strategies;

use App\Actions\Telegram\ChooseModeAction;
use App\DTOs\ChooseModeDTO;
use LogicException;
use Telegram\Bot\Objects\CallbackQuery;
use Throwable;

final readonly class CallbackActionStrategy
{
    public function __construct(

        private ChooseModeAction $chooseModeAction
    ) {}

    /**
     * @throws Throwable
     */
    public function run(CallbackQuery $callbackQuery): string
    {
        [$actionClass] = explode('-', $callbackQuery->data);

        return match ($actionClass) {
            ChooseModeAction::class => $this->chooseModeAction->run(ChooseModeDTO::fromCallbackQuery($callbackQuery)),
            default => throw new LogicException('Unknown action class: '.$actionClass),
        };
    }
}
