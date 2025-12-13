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
        Schema::create('youtube_videos', function (Blueprint $table) {
            $table->id();

            $table->string('vector_store_id');
            $table->string('file_id');
            $table->string('video_id');
            $table->string('url');
            $table->string('title')->nullable();
            $table->string('description')->nullable();

            $table->jsonb('tags')->default('[]');
            $table->jsonb('additional_data')->default('{}');

            $table->timestamp('uploaded_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('youtube_videos');
    }
};
