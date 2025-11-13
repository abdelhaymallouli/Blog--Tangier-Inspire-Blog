<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
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

    public function delete($id, ArticleService $service)
    {
        $deleted = $service->deleteArticle($id);

        if ($deleted) {
            return redirect('articles')->with('success', 'Article deleted successfully!');
        } else {
            return redirect('articles')->with('error', 'Failed to delete the article.');
        }
    }
}
