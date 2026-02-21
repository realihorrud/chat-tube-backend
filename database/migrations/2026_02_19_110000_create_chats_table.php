<?php

declare(strict_types=1);

use App\Enums\ConversationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('telegram_user_id')->constrained('telegram_users')->cascadeOnDelete();
            $table->foreignId('youtube_video_id')->nullable()->constrained('youtube_videos')->nullOnDelete();
            $table->string('title')->nullable();
            $table->string('status')->default(ConversationStatus::Pending->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
