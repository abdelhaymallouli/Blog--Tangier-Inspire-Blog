<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


class ArticleService
{
    public function getPaginatedArticles(): LengthAwarePaginator
    {
        return Article::with(['category', 'author'])
            ->whereNotNull('published_at')
            ->where('is_moderated', true)
            ->latest('published_at')
            ->paginate(5);
    }

    public function getCategories() : Collection
    {
        return Category::orderBy('name')->get();
    }

    public function deleteArticle(int $articleId): bool
    {
        $article = Article::findOrFail($articleId);
        return $article->delete();
    }
}