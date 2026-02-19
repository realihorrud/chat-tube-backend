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
        Schema::table('youtube_videos', function (Blueprint $table) {
            $table->dropForeign('youtube_videos_chat_id_foreign');
            $table->dropColumn('chat_id');

            $table->unsignedBigInteger('chat_id')->nullable();

            $table->foreign('chat_id')
                ->references('id')
                ->on('chats')
                ->cascadeOnDelete();
        });
    }
};
