<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'telegram' => [
        'api_url' => env('TELEGRAM_API_URL').env('TELEGRAM_BOT_TOKEN').'/',
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'mini_app_url' => env('TELEGRAM_MINI_APP_URL', 'https://t.me/chat_tube_dev_bot/App'),
    ],

    'supadata' => [
        'base_uri' => env('SUPADATA_BASE_URI'),
        'api_key' => env('SUPADATA_API_KEY'),
    ],

    'openai' => [
        'model' => env('OPENAI_MODEL', 'gpt-4.1-mini'),
        'vector_stores' => [
            'expires_in_days' => 30,
        ],
    ],
];
