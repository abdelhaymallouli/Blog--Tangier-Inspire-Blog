<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-published { color: green; font-weight: bold; }
        .status-draft     { color: orange; font-weight: bold; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4">All Articles</h1>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter -->
    <form method="GET" class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label class="col-form-label">Category:</label>
            </div>
            <div class="col-auto">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ $selectedCategory == $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr>
                            <td>{{ $article->article_id }}</td>
                            <td>
                                <a href="{{ route('articles.index', $article) }}" target="_blank">
                                    {{ Str::limit($article->title, 50) }}
                                </a>
                            </td>
                            <td>{{ $article->category?->name ?? '—' }}</td>
                            <td>
                                @if($article->status === 'published')
                                    <span class="status-published">Published</span>
                                @elseif($article->status === 'draft')
                                    <span class="status-draft">Draft</span>
                                @else
                                    <span>{{ ucfirst($article->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $article->published_at->format('M d, Y') }}</td>
                            <td>
                                <button 
                                    class="btn btn-danger btn-sm delete-btn"
                                    data-id="{{ $article->article_id }}"
                                    data-title="{{ $article->title }}"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No articles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $articles->appends(request()->query())->links() }}
    </div>
</div>

<!-- JS -->
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const title = this.dataset.title;

        if (confirm(`Are you sure you want to delete "${title}"?`)) {
            // Redirect to the delete route
            window.location.href = `/articles/delete/${id}`;
        }
    });
});
</script>

<!-- Bootstrap JS (for alert dismiss) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
