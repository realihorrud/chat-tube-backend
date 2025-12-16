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
        Schema::table('youtube_video_media', function (Blueprint $table) {
            $table->enum('type', ['post', 'image', 'video', 'carousel']);
            $table->unsignedInteger('duration')->nullable()->change();
            $table->string('thumbnail_url')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->jsonb('items')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('youtube_video_media', function (Blueprint $table) {
            $table->unsignedInteger('duration')->change();
            $table->string('thumbnail_url')->change();
            $table->string('url')->change();
            $table->jsonb('items')->change();
            $table->dropColumn('type');
        });
    }
};
