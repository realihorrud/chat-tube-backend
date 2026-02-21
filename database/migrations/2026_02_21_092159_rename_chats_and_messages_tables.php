<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('chats', 'conversations');
        Schema::rename('messages', 'conversation_messages');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('conversations', 'chats');
        Schema::rename('conversation_messages', 'messages');
    }
};
