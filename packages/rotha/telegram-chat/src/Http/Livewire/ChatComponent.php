<?php

namespace Rotha\TelegramChat\Http\Livewire;

use Livewire\Component;
use Rotha\TelegramChat\Models\TelegramUser;
use Rotha\TelegramChat\Models\TelegramMessage;
use Rotha\TelegramChat\Services\TelegramService;

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
        
        // Mark all unread messages from this user as read
        if ($this->selectedUser) {
            $this->selectedUser->messages()
                ->where('is_from_admin', false)
                ->where('read', false)
                ->update(['read' => true]);
                
            $this->loadMessages();
        }
    }

    public function loadMessages()
    {
        if ($this->selectedUser) {
            $this->messages = $this->selectedUser->messages()
                ->orderBy('sent_at', 'desc')
                ->get();
        }
    }

    protected $telegramService;

    public function boot()
    {
        $this->telegramService = new TelegramService();
    }

    public function sendMessage()
    {
        if (!$this->selectedUser || empty($this->message)) {
            return;
        }

        try {
            $response = $this->telegramService->sendMessage(
                $this->selectedUser->telegram_id,
                $this->message
            );

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
            
            $this->telegramService->deleteMessage(
                $message->user->telegram_id,
                $message->message_id
            );

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