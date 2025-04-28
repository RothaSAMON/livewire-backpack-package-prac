<?php

namespace Rotha\TelegramChat\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class TelegramUser extends Model
{
    use CrudTrait;

    protected $fillable = [
        'telegram_id',
        'username',
        'first_name',
        'last_name'
    ];

    public function messages()
    {
        return $this->hasMany(TelegramMessage::class);
    }
}