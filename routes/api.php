<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Nutgram\Laravel\Middleware\ValidateWebAppData;

Route::middleware(ValidateWebAppData::class)->group(function () {
    // Routes go here...
});
