<?php

declare(strict_types=1);

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
        Schema::create('youtube_video_stats', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('views');
            $table->unsignedBigInteger('likes');
            $table->unsignedBigInteger('shares')->nullable();
            $table->unsignedBigInteger('comments')->nullable();

            $table->foreignId('youtube_video_id')
                ->constrained('youtube_videos')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_video_stats');
    }
};
