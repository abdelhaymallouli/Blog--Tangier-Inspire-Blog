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
            $table->integer('views')->default(0);
            $table->integer('shares')->default(0);
            $table->enum('status', ['Draft', 'Published', 'Archived']);
            $table->foreignId('author_id')->constrained('users', 'user_id');
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
