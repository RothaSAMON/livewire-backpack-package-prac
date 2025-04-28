<?php

namespace Rotha\TelegramChat;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Rotha\TelegramChat\Http\Livewire\ChatComponent;

class TelegramChatServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'telegram-chat');
        
        Livewire::component('telegram-chat', ChatComponent::class);
        
        $this->publishes([
            __DIR__ . '/config/telegram.php' => config_path('telegram.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/telegram.php', 'telegram'
        );
    }
}