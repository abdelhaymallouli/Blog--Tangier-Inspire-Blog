<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .status-published { color: #16a34a; font-weight: 600; }
        .status-draft { color: #f97316; font-weight: 600; }
    </style>
</head>

<body class="bg-gray-100">

<div class="max-w-6xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">All Articles</h1>

    <!-- Success message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-4 relative">
            {{ session('success') }}
            <button onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-green-700 font-bold">×</button>
        </div>
    @endif

    <!-- Filter -->
    <form method="GET" class="mb-6">
        <div class="flex items-center space-x-3">
            <label class="text-gray-700 font-medium">Category:</label>

            <select name="category"
                    onchange="this.form.submit()"
                    class="border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                <option value="">All Categories</option>

                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ $selectedCategory == $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-200">
                <tr class="text-gray-700 uppercase text-sm">
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse($articles as $article)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $article->article_id }}</td>

                        <td class="px-4 py-3">
                            <a href="{{ route('articles.index', $article) }}"
                               target="_blank"
                               class="text-blue-600 hover:underline">
                                {{ Str::limit($article->title, 50) }}
                            </a>
                        </td>

                        <td class="px-4 py-3">{{ $article->category?->name ?? '—' }}</td>

                        <td class="px-4 py-3">
                            @if($article->status === 'published')
                                <span class="status-published">Published</span>
                            @elseif($article->status === 'draft')
                                <span class="status-draft">Draft</span>
                            @else
                                <span>{{ ucfirst($article->status) }}</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            {{ $article->published_at->format('M d, Y') }}
                        </td>

                        <td class="px-4 py-3">
                            <button 
                                class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 delete-btn"
                                data-id="{{ $article->article_id }}"
                                data-title="{{ $article->title }}"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-6">
                            No articles found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $articles->appends(request()->query())->links() }}
    </div>
</div>

<!-- JS: Delete Confirmation -->
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const title = this.dataset.title;

        if (confirm(`Are you sure you want to delete "${title}"?`)) {
            window.location.href = `/articles/delete/${id}`;
        }
    });
});
</script>

</body>
</html>
