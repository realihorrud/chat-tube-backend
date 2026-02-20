<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\UsersService;
use App\Telegram\Entities\User;
use Closure;
use Illuminate\Http\Request;
use Nutgram\Laravel\Middleware\ValidateWebAppData as BaseValidateWebAppData;
use SergiX44\Nutgram\Exception\InvalidDataException;
use SergiX44\Nutgram\Nutgram;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ValidateWebAppData extends BaseValidateWebAppData
{
    public function __construct(protected Nutgram $bot, private UsersService $usersService)
    {
        parent::__construct($bot);
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     *
     * @throws Throwable
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $initData = explode(' ', $request->headers->get('Authorization', ''));
            if (count($initData) < 2) {
                $initData = '';
            } else {
                $initData = $initData[count($initData) - 1];
            }
            $data = $this->bot->validateWebAppData($initData);

            $request->attributes->add(['webAppData' => $data]);

            $telegramUser = $this->usersService->createOrUpdate(User::from([
                'id' => $data->user->id,
                'first_name' => $data->user->first_name,
                'last_name' => $data->user->last_name,
                'username' => $data->user->username,
                'language_code' => $data->user->language_code,
                'is_bot' => $data->user->is_bot,
            ]));

            $request->attributes->set('telegramUser', $telegramUser);

            return $next($request);
        } catch (InvalidDataException) {
            return $this->handleInvalidData($request, $next);
        }
    }
}
