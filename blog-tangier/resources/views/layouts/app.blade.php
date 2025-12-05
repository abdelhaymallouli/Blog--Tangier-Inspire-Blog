<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Article Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Preline UI -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/preline@2.3.0/dist/preline.css">
    
    <!-- jQuery REQUIRED for Summernote -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    
    <style>
        .note-editor.note-frame {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
        }
        .note-toolbar {
            background-color: #f9fafb !important;
            border-bottom: 1px solid #e5e7eb !important;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Article Management System</h1>
                    <p class="text-sm text-gray-500 mt-1">Dashboard & Content Manager</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-12 border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-6 py-6 text-center text-gray-500 text-sm">
            Article Management System &copy; {{ date('Y') }}
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/preline@2.3.0/dist/preline.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Initialize Summernote for create page
        if ($('#content-create').length) {
            $('#content-create').summernote({
                placeholder: 'Write your article content here...',
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        }

        // Initialize Summernote for edit page
        if ($('#content-edit').length) {
            $('#content-edit').summernote({
                placeholder: 'Edit article content...',
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        }
    });
    </script>
</body>
</html>