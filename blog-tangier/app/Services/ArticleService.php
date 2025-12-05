<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ArticleService
{
    protected User $admin;

    public function __construct()
    {
        $this->admin = User::where('role', 'admin')->firstOrFail();
    }

    public function getPaginatedArticles(?string $categorySlug = null, ?string $search = null, ?string $status = null): LengthAwarePaginator
    {
        $query = Article::with(['category', 'author']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($status && in_array($status, ['draft', 'published', 'archived'])) {
            $query->where('status', $status);
        }

        return $query->latest('published_at')->paginate(6);
    }

    public function getCategories(): Collection
    {
        return Category::orderBy('name')->get();
    }

public function createArticle(array $data): Article
{
    // Auto-generate slug from title
    $baseSlug = Str::slug($data['title']);
    $slug = $baseSlug;
    $count = 1;

    // Make sure slug is unique
    while (Article::where('slug', $slug)->exists()) {
        $slug = $baseSlug . '-' . $count;
        $count++;
    }

    $data['slug'] = $slug;
    $data['author_id'] = $this->admin->user_id;
    $data['is_moderated'] = true;

    if ($data['status'] === 'published') {
        $data['published_at'] = now();
    }

    return Article::create($data);
}

public function updateArticle(Article $article, array $data): bool
{
    // Update slug if title changed
    if (isset($data['title']) && $data['title'] !== $article->title) {
        $baseSlug = Str::slug($data['title']);
        $slug = $baseSlug;
        $count = 1;

        while (Article::where('slug', $slug)->where('article_id', '!=', $article->article_id)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }
        $data['slug'] = $slug;
    }

    if ($data['status'] === 'published' && !$article->published_at) {
        $data['published_at'] = now();
    }

    return $article->update($data);
}

    public function deleteArticle(int $articleId): bool
    {
        $article = Article::findOrFail($articleId);
        return $article->delete();
    }
}