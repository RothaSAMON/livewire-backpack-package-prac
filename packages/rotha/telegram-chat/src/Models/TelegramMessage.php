<?php

namespace Rotha\TelegramChat\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    protected $fillable = [
        'telegram_user_id',
        'message_id',
        'content',
        'is_from_admin',
        'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'is_from_admin' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(TelegramUser::class, 'telegram_user_id');
    }
}