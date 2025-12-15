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
        Schema::dropIfExists('user_states');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('user_states', function (Blueprint $table) {
            $table->id();

            $table->enum('state', ['waiting_custom_prompt']);

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }
};
