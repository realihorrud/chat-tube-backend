<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use App\Telegram\Entities\CallbackQuery;
use App\Telegram\Entities\Message;
use App\Telegram\Entities\Update;
use App\Telegram\Entities\User as TelegramUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

final class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $update = Update::from($request->all());
        if ($update->callback_query instanceof CallbackQuery) {
            return $next($request);
        }

        if ($update->message instanceof Message) {
            $user = User::query()
                ->where('telegram_id', $update->message->chat->id)
                ->first();

            $language = 'en';
            if ($update->message->from instanceof TelegramUser) {
                $language = $update->message->from->language_code;
            }

            App::setLocale($user->language_code ?? $language);
        }

        return $next($request);
    }
}
