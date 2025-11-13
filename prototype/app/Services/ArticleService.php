<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleService
{
    public function getPaginatedArticles(?string $categorySlug = null, int $perPage = 5): LengthAwarePaginator
    {
        $query = Article::with(['category', 'author'])
            ->when($categorySlug, fn($q) => $q->whereHas('category', fn($c) => $c->where('slug', $categorySlug)))
            ->whereNotNull('published_at')
            ->where('is_moderated', true)
            ->latest('published_at');

        return $query->paginate($perPage);
    }

    public function getCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return Category::orderBy('name')->get();
    }

    public function deleteArticle(int $articleId): bool
    {
        $article = Article::findOrFail($articleId);
        return $article->delete();
    }
}