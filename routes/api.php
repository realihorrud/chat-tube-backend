<?php

declare(strict_types=1);

use App\Http\Middleware\ValidateWebAppData;
use Illuminate\Support\Facades\Route;

Route::middleware(ValidateWebAppData::class)->group(function (): void {
    // Routes go here...
});
