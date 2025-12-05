@extends('layouts.app')
@section('title', 'Create Article')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-10">
    <h2 class="text-3xl font-bold mb-8 text-gray-800">Create New Article</h2>

    <form action="{{ route('articles.store') }}" method="POST">
        @csrf

        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <div>
                <label class="block text-lg font-medium mb-2">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-lg font-medium mb-2">Category</label>
                <select name="category_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    <option value="">Select Category</option>
                    @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                        <option value="{{ $cat->category_id }}" {{ old('category_id') == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-lg font-medium mb-2">Status</label>
                <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-lg font-medium mb-3">Content</label>
<textarea name="content" id="content-create">{{ old('content') }}</textarea>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('articles.index') }}" class="px-8 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                Cancel
            </a>
            <button type="submit" class="px-10 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-lg font-medium">
                Save Article
            </button>
        </div>
    </form>
</div>


@endsection