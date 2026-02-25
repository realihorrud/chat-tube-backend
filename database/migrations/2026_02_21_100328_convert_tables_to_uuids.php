<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop all foreign keys first
        Schema::table('conversation_messages', function (Blueprint $table): void {
            $table->dropForeign('messages_chat_id_foreign');
        });

        Schema::table('youtube_videos', function (Blueprint $table): void {
            $table->dropForeign('youtube_videos_chat_id_foreign');
        });

        Schema::table('conversations', function (Blueprint $table): void {
            $table->dropForeign('conversations_telegram_user_id_foreign');
            $table->dropForeign('conversations_youtube_video_id_foreign');
        });

        Schema::table('youtube_video_authors', function (Blueprint $table): void {
            $table->dropForeign(['youtube_video_id']);
        });

        Schema::table('youtube_video_stats', function (Blueprint $table): void {
            $table->dropForeign(['youtube_video_id']);
        });

        Schema::table('youtube_video_media', function (Blueprint $table): void {
            $table->dropForeign(['youtube_video_id']);
        });

        Schema::table('sessions', function (Blueprint $table): void {
            $table->dropIndex('sessions_user_id_index');
        });

        // Convert primary key columns from bigint to uuid
        $tables = [
            'users',
            'telegram_users',
            'youtube_videos',
            'youtube_video_authors',
            'youtube_video_stats',
            'youtube_video_media',
            'conversations',
            'conversation_messages',
        ];

        foreach ($tables as $table) {
            DB::statement("ALTER TABLE {$table} ALTER COLUMN id DROP DEFAULT");
            DB::statement("ALTER TABLE {$table} ALTER COLUMN id SET DATA TYPE uuid USING gen_random_uuid()");
            DB::statement("ALTER TABLE {$table} ALTER COLUMN id SET DEFAULT gen_random_uuid()");
            DB::statement("DROP SEQUENCE IF EXISTS {$table}_id_seq CASCADE");
        }

        // Convert foreign key columns from bigint to uuid
        $foreignKeyColumns = [
            ['youtube_video_authors', 'youtube_video_id'],
            ['youtube_video_stats', 'youtube_video_id'],
            ['youtube_video_media', 'youtube_video_id'],
            ['conversations', 'telegram_user_id'],
            ['conversations', 'youtube_video_id'],
            ['conversation_messages', 'chat_id'],
            ['youtube_videos', 'chat_id'],
            ['sessions', 'user_id'],
        ];

        foreach ($foreignKeyColumns as [$table, $column]) {
            DB::statement("ALTER TABLE {$table} ALTER COLUMN {$column} SET DATA TYPE uuid USING CASE WHEN {$column} IS NOT NULL THEN gen_random_uuid() ELSE NULL END");
        }

        // Truncate all tables (children first) to avoid FK violations when re-adding constraints
        DB::statement('TRUNCATE TABLE conversation_messages, youtube_video_authors, youtube_video_stats, youtube_video_media, conversations, youtube_videos, telegram_users, users CASCADE');

        // Re-add foreign keys
        Schema::table('youtube_video_authors', function (Blueprint $table): void {
            $table->foreign('youtube_video_id')->references('id')->on('youtube_videos')->cascadeOnDelete();
        });

        Schema::table('youtube_video_stats', function (Blueprint $table): void {
            $table->foreign('youtube_video_id')->references('id')->on('youtube_videos')->cascadeOnDelete();
        });

        Schema::table('youtube_video_media', function (Blueprint $table): void {
            $table->foreign('youtube_video_id')->references('id')->on('youtube_videos')->cascadeOnDelete();
        });

        Schema::table('conversations', function (Blueprint $table): void {
            $table->foreign('telegram_user_id')->references('id')->on('telegram_users')->cascadeOnDelete();
            $table->foreign('youtube_video_id')->references('id')->on('youtube_videos')->nullOnDelete();
        });

        Schema::table('conversation_messages', function (Blueprint $table): void {
            $table->foreign('chat_id')->references('id')->on('conversations')->cascadeOnDelete();
        });

        Schema::table('youtube_videos', function (Blueprint $table): void {
            $table->foreign('chat_id')->references('id')->on('conversations')->cascadeOnDelete();
        });

        Schema::table('sessions', function (Blueprint $table): void {
            $table->index('user_id');
        });
    }
};
