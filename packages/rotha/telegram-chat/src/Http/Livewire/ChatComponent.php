<?php

namespace Rotha\TelegramChat\Http\Livewire;

use Livewire\Component;
use Rotha\TelegramChat\Models\TelegramUser;
use Rotha\TelegramChat\Models\TelegramMessage;
use Telegram\Bot\Laravel\Facades\Telegram;

class ChatComponent extends Component
{
    public $selectedUser = null;
    public $message = '';
    public $messages = [];
    
    protected $listeners = ['messageReceived' => '$refresh'];

    public function mount()
    {
        if ($this->selectedUser) {
            $this->loadMessages();
        }
    }

    public function selectUser($userId)
    {
        $this->selectedUser = TelegramUser::find($userId);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if ($this->selectedUser) {
            $this->messages = $this->selectedUser->messages()
                ->orderBy('sent_at', 'desc')
                ->get();
        }
    }

    public function sendMessage()
    {
        if (!$this->selectedUser || empty($this->message)) {
            return;
        }

        try {
            // Send message via Telegram Bot API
            $response = Telegram::sendMessage([
                'chat_id' => $this->selectedUser->telegram_id,
                'text' => $this->message,
            ]);

            // Store message in database
            TelegramMessage::create([
                'telegram_user_id' => $this->selectedUser->id,
                'message_id' => $response->getMessageId(),
                'content' => $this->message,
                'is_from_admin' => true,
                'sent_at' => now(),
            ]);

            $this->message = '';
            $this->loadMessages();
        } catch (\Exception $e) {
            $this->addError('message', 'Failed to send message: ' . $e->getMessage());
        }
    }

    public function deleteMessage($messageId)
    {
        try {
            $message = TelegramMessage::findOrFail($messageId);
            
            // Delete message from Telegram
            Telegram::deleteMessage([
                'chat_id' => $message->user->telegram_id,
                'message_id' => $message->message_id,
            ]);

            // Delete from database
            $message->delete();
            
            $this->loadMessages();
        } catch (\Exception $e) {
            $this->addError('delete', 'Failed to delete message: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $users = TelegramUser::with('messages')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('telegram-chat::livewire.chat-component', [
            'users' => $users
        ]);
    }
}