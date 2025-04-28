<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Rotha\TelegramChat\Models\TelegramUser;
use Rotha\TelegramChat\Models\TelegramMessage;

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
    
    // Get the message
    $message = $update->getMessage();
    $chat = $message->getChat();
    
    // Store or update user
    $user = TelegramUser::updateOrCreate(
        ['telegram_id' => $chat->getId()],
        [
            'username' => $chat->getUsername(),
            'first_name' => $chat->getFirstName(),
            'last_name' => $chat->getLastName(),
        ]
    );
    
    // Store message
    TelegramMessage::create([
        'telegram_user_id' => $user->id,
        'message_id' => $message->getMessageId(),
        'content' => $message->getText(),
        'is_from_admin' => false,
        'sent_at' => now(),
    ]);
    
    return response()->json(['status' => 'success']);
});