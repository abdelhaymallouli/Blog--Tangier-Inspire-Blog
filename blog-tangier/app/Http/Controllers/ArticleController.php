<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $service;

    public function __construct(ArticleService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        $search = $request->query('search');
        $status = $request->query('status');

        $articles = $this->service->getPaginatedArticles($categorySlug, $search, $status);
        $categories = $this->service->getCategories();
        $selectedCategory = $categorySlug;

        return view('articles.index', compact('articles', 'categories', 'selectedCategory'));
    }

    public function create()
    {
        $categories = $this->service->getCategories();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_id' => 'required|exists:categories,category_id',
            'status'      => 'required|in:draft,published',
        ]);

        $this->service->createArticle($request->all());

        return redirect('/articles')->with('success', 'Article created successfully!');
    }

    public function edit(Article $article)
    {
        $categories = $this->service->getCategories();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_id' => 'required|exists:categories,category_id',
            'status'      => 'required|in:draft,published,archived',
        ]);

        $this->service->updateArticle($article, $request->all());

        return redirect('/articles')->with('success', 'Article updated successfully!');
    }

    public function delete($id)
    {
        $this->service->deleteArticle($id);
        return redirect('/articles')->with('success', 'Article deleted successfully!');
    }
}