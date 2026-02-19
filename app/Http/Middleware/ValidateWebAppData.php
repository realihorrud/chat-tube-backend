<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\UsersService;
use App\Telegram\Entities\User;
use Closure;
use Illuminate\Http\Request;
use Nutgram\Laravel\Middleware\ValidateWebAppData as BaseValidateWebAppData;
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
        parent::handle($request, $next);

        /** @var \SergiX44\Nutgram\Telegram\Types\User\User $webAppUser */
        $webAppUser = $request->attributes->get('webAppData')->user;
        $telegramUser = $this->usersService->createOrUpdate(User::from([
            'id' => $webAppUser->id,
            'first_name' => $webAppUser->first_name,
            'last_name' => $webAppUser->last_name,
            'username' => $webAppUser->username,
            'language_code' => $webAppUser->language_code,
            'is_bot' => $webAppUser->is_bot,
        ]));

        $request->attributes->set('telegramUser', $telegramUser);

        return $next($request);
    }
}
