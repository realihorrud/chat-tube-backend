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
        Schema::table('youtube_videos', function (Blueprint $table) {
            $table->enum('status', ['queued', 'active', 'completed', 'failed'])->nullable();
            $table->string('job_id')->nullable();

            $table->string('vector_store_id')->nullable()->change();
            $table->string('file_id')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('youtube_videos', function (Blueprint $table) {
            $table->dropColumn('job_id');
            $table->dropColumn('status');

            $table->string('vector_store_id')->nullable(false)->change();
            $table->string('file_id')->nullable(false)->change();
        });
    }
};
