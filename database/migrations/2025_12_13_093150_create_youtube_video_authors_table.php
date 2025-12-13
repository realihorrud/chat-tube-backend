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
        Schema::create('youtube_video_authors', function (Blueprint $table) {
            $table->id();

            $table->string('display_name');
            $table->string('username');
            $table->string('avatar_url');
            $table->boolean('verified');

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
        Schema::dropIfExists('youtube_video_authors');
    }
};
