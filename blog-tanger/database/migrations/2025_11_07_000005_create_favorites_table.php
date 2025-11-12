<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->foreignId('article_id')->constrained('articles', 'article_id');
            $table->timestamps();

            $table->primary(['user_id', 'article_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
