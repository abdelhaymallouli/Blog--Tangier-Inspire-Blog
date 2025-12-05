<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');

Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');

Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');

Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');

Route::get('/articles/delete/{id}', [ArticleController::class, 'delete'])->name('articles.delete');
