<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('telegram_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('telegram_user_id')->constrained('telegram_users')->onDelete('cascade');
            $table->string('message_id');
            $table->text('content');
            $table->boolean('is_from_admin')->default(false);
            $table->timestamp('sent_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('telegram_messages');
    }
};