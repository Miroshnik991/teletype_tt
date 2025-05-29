<?php

use App\Infrastructure\Middleware\ValidateRequestCompleteness;
use App\UI\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::controller(MessageController::class)->group(function () {
    Route::post('/message', 'createMessage')->middleware(ValidateRequestCompleteness::class);
});

