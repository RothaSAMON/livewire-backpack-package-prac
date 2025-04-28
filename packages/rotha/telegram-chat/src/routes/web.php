<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Rotha\TelegramChat\Models\TelegramUser;
use Rotha\TelegramChat\Models\TelegramMessage;
use Rotha\TelegramChat\Services\TelegramService;

// Admin routes
Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    Route::get('telegram-chat', function () {
        return view('telegram-chat::chat');
    })->name('telegram-chat.index');
});

// Webhook routes
Route::post('/api/telegram/debug-webhook', function (Request $request) {
    $update = Telegram::commandsHandler(true);
    $telegramService = new TelegramService();
    return $telegramService->handleUpdate($update);
});