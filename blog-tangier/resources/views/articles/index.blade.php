@extends('layouts.app')
@section('title', 'Articles Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header with Stats -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Articles Dashboard</h2>
                <p class="text-gray-500 mt-1">Manage and organize your content</p>
            </div>
            <a href="{{ route('articles.create') }}" 
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Article
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                <div class="text-blue-600 text-sm font-medium">Total Articles</div>
                <div class="text-2xl font-bold text-blue-900 mt-1">{{ $articles->total() }}</div>
            </div>
            <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                <div class="text-green-600 text-sm font-medium">Published</div>
                <div class="text-2xl font-bold text-green-900 mt-1">
                    {{ \App\Models\Article::where('status', 'published')->count() }}
                </div>
            </div>
            <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                <div class="text-yellow-600 text-sm font-medium">Drafts</div>
                <div class="text-2xl font-bold text-yellow-900 mt-1">
                    {{ \App\Models\Article::where('status', 'draft')->count() }}
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="text-gray-600 text-sm font-medium">Archived</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">
                    {{ \App\Models\Article::where('status', 'archived')->count() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Live Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Articles</label>
                <div class="relative">
                    <input type="text" 
                           id="searchInput"
                           value="{{ request('search') }}" 
                           placeholder="Type to search..." 
                           class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select id="categoryFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
        </div>

        <!-- Active Filters Display -->
        @if(request('search') || request('category') || request('status'))
            <div class="mt-4 flex items-center gap-2">
                <span class="text-sm text-gray-600">Active filters:</span>
                @if(request('search'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Search: "{{ request('search') }}"
                        <a href="{{ route('articles.index', array_filter(['category' => request('category'), 'status' => request('status')])) }}" class="ml-1 hover:text-blue-900">×</a>
                    </span>
                @endif
                @if(request('category'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        Category: {{ $categories->firstWhere('slug', request('category'))->name ?? request('category') }}
                        <a href="{{ route('articles.index', array_filter(['search' => request('search'), 'status' => request('status')])) }}" class="ml-1 hover:text-purple-900">×</a>
                    </span>
                @endif
                @if(request('status'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Status: {{ ucfirst(request('status')) }}
                        <a href="{{ route('articles.index', array_filter(['search' => request('search'), 'category' => request('category')])) }}" class="ml-1 hover:text-green-900">×</a>
                    </span>
                @endif
                <a href="{{ route('articles.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium ml-2">Clear all</a>
            </div>
        @endif
    </div>

    <!-- Articles Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-12">
                            ID
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Title
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Category
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Published Date
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($articles as $article)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                #{{ $article->article_id }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ Str::limit($article->title, 60) }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    {{ Str::limit(strip_tags($article->content), 100) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $article->category?->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 
                                       ($article->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $article->published_at?->format('M d, Y') ?? 'Not published' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('articles.edit', $article) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-xs">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <button onclick="confirmDelete('{{ $article->article_id }}')"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-xs">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                    <form id="delete-form-{{ $article->article_id }}" 
                                          action="{{ route('articles.delete', $article->article_id) }}" 
                                          method="GET" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-gray-900">No articles found</h3>
                                <p class="mt-2 text-sm text-gray-500">Get started by creating a new article.</p>
                                <div class="mt-6">
                                    <a href="{{ route('articles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Create Article
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $articles->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<script>
// Live Search Functionality
let searchTimeout;
const searchInput = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const statusFilter = document.getElementById('statusFilter');

searchInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilters();
    }, 1000); // Wait 500ms after user stops typing
});

categoryFilter.addEventListener('change', applyFilters);
statusFilter.addEventListener('change', applyFilters);

function applyFilters() {
    const search = searchInput.value;
    const category = categoryFilter.value;
    const status = statusFilter.value;
    
    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (category) params.append('category', category);
    if (status) params.append('status', status);
    
    const queryString = params.toString();
    window.location.href = "{{ route('articles.index') }}" + (queryString ? '?' + queryString : '');
}

function confirmDelete(articleId) {
    if (confirm('Are you sure you want to delete this article? This action cannot be undone.')) {
        document.getElementById('delete-form-' + articleId).submit();
    }
}
</script>
@endsection