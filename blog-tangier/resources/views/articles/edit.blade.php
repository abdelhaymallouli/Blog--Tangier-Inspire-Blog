@extends('layouts.app')
@section('title', 'Edit Article')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-8">
    <!-- Header -->
    <div class="mb-8 border-b border-gray-200 pb-6">
        <h2 class="text-2xl font-bold text-gray-900">Edit Article</h2>
        <p class="text-gray-500 mt-1">Update the article information below</p>
    </div>

    <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf 
        @method('PUT')

        <!-- Basic Information -->
        <div class="space-y-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Basic Information
            </h3>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Article Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           value="{{ old('title', $article->title) }}" 
                           required
                           placeholder="Enter article title..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" 
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                        <option value="">Select a category</option>
                        @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                            <option value="{{ $cat->category_id }}" 
                                    {{ old('category_id', $article->category_id) == $cat->category_id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status', $article->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

            </div>
        </div>

        <!-- Content Editor -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Article Content <span class="text-red-500">*</span>
            </h3>
            <textarea name="content" 
                      id="content-edit" 
                      class="@error('content') border-red-500 @enderror">{!! old('content', $article->content) !!}</textarea>
            @error('content')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Article Metadata -->
        <div class="mb-8 bg-gray-50 rounded-lg p-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Article Information</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Created:</span>
                    <p class="font-medium text-gray-900">{{ $article->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Last Updated:</span>
                    <p class="font-medium text-gray-900">{{ $article->updated_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Article ID:</span>
                    <p class="font-medium text-gray-900">#{{ $article->article_id }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Published:</span>
                    <p class="font-medium text-gray-900">
                        {{ $article->published_at ? $article->published_at->format('M d, Y') : 'Not yet' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('articles.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Cancel
            </a>
            <div class="flex gap-3">
                <button type="submit" 
                        class="inline-flex items-center px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Article
                </button>
            </div>
        </div>
    </form>
</div>
@endsection