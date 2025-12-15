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
        Schema::table('users', function (Blueprint $table) {
            $table->unique('telegram_id');

            $table->unsignedBigInteger('telegram_id')->change();
        });

        Schema::table('chat_states', function (Blueprint $table) {
            $table->unsignedBigInteger('chat_id');

            $table->foreign('chat_id')
                ->references('telegram_id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_states', function (Blueprint $table) {
            $table->dropForeign('chat_states_chat_id_foreign');
            $table->dropColumn('chat_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_telegram_id_unique');
            $table->bigInteger('telegram_id')->change();
        });
    }
};
