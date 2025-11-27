<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use \Illuminate\Database\Eloquent\Collection;

class ArticleService
{
public function getPaginatedArticles(?string $categorySlug = null): LengthAwarePaginator
{
    $query = Article::with(['category', 'author'])
        ->whereNotNull('published_at')
        ->where('is_moderated', true);

    // Apply category filter if exists
    if (!empty($categorySlug)) {
        $query->whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    return $query->latest('published_at')->paginate(5);
}

    public function getCategories(): Collection
    {
        return Category::orderBy('name')->get();
    }

    public function deleteArticle(int $articleId): bool
    {
        $article = Article::findOrFail($articleId);
        return $article->delete();
    }
}