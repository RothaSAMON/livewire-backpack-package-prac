<?php

namespace Rotha\TelegramChat\Services;

use Telegram\Bot\Laravel\Facades\Telegram;
use Rotha\TelegramChat\Models\TelegramUser;
use Rotha\TelegramChat\Models\TelegramMessage;

class TelegramService
{
    public function handleUpdate($update)
    {
        if ($update->editedMessage) {
            return $this->handleEditedMessage($update->editedMessage);
        }
        
        return $this->handleNewMessage($update->getMessage());
    }

    protected function handleEditedMessage($editedMessage)
    {
        $chat = $editedMessage->getChat();
        $user = TelegramUser::where('telegram_id', $chat->getId())->first();
        
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }

        $message = TelegramMessage::where('telegram_user_id', $user->id)
                                ->where('message_id', $editedMessage->getMessageId())
                                ->first();
        
        if ($message) {
            $message->update([
                'content' => $editedMessage->getText(),
            ]);
            
            return response()->json(['status' => 'success', 'type' => 'edit']);
        }

        return response()->json(['status' => 'error', 'message' => 'Message not found']);
    }

    protected function handleNewMessage($message)
    {
        $chat = $message->getChat();
        
        $user = TelegramUser::updateOrCreate(
            ['telegram_id' => $chat->getId()],
            [
                'username' => $chat->getUsername(),
                'first_name' => $chat->getFirstName(),
                'last_name' => $chat->getLastName(),
            ]
        );
        
        TelegramMessage::create([
            'telegram_user_id' => $user->id,
            'message_id' => $message->getMessageId(),
            'content' => $message->getText(),
            'is_from_admin' => false,
            'sent_at' => now(),
        ]);
        
        return response()->json(['status' => 'success', 'type' => 'new']);
    }

    public function sendMessage($chatId, $text)
    {
        return Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }

    public function deleteMessage($chatId, $messageId)
    {
        return Telegram::deleteMessage([
            'chat_id' => $chatId,
            'message_id' => $messageId,
        ]);
    }
}