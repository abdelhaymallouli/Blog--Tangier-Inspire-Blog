<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
    $table->id('article_id');
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('content');
    $table->string('image')->nullable();
    $table->unsignedBigInteger('views')->default(0);
    $table->foreignId('author_id')
          ->constrained('users', 'user_id')
          ->cascadeOnDelete();
    $table->foreignId('category_id')
          ->nullable()
          ->constrained('categories', 'category_id')
          ->nullOnDelete();
    $table->enum('status', ['draft', 'published', 'archived'])->default('draft'); // <-- added
    $table->timestamp('published_at')->nullable();
    $table->boolean('is_moderated')->default(false);
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};