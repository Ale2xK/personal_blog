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
        // 1. Удаляем ТОЛЬКО title и body из таблицы posts (user_id не трогаем)
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['title', 'body']);
        });

        // 2. Создаем новую таблицу для текстов
        Schema::create('post_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');

            // Связываем текст с ID поста
            $table->foreignId('post_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_contents');

        Schema::table('posts', function (Blueprint $table) {
            $table->string('title');
            $table->text('body');
        });
    }
};
