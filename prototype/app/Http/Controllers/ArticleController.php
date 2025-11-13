<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    // LIST + FILTER
    public function index(Request $request, ArticleService $service)
    {
        $categorySlug = $request->query('category');

        $articles = $service->getPaginatedArticles($categorySlug);
        $categories = $service->getCategories();
        $selectedCategory = $categorySlug;

        return view('articles.index', compact(
            'articles',
            'categories',
            'selectedCategory'
        ));
    }

    // DELETE (AJAX)
    public function destroy(Article $article, ArticleService $service)
    {
        $deleted = $service->deleteArticle($article->article_id);

        return response()->json([
            'success' => $deleted,
            'message' => $deleted ? 'Article deleted!' : 'Failed.'
        ]);
    }
}