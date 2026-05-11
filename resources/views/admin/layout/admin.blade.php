<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Time Calculator</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        .sidebar-active {
            background-color: #f3f4f6;
            color: #4f46e5;
            border-right: 4px solid #4f46e5;
        }
        /* Select2 Custom Styling to match your screenshot */
        .select2-container--default .select2-selection--multiple {
            border-color: #d1d5db;
            border-radius: 0.5rem;
            padding: 0.25rem;
            background-color: #f9fafb;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #3b82f6;
            ring: 2px;
            ring-color: #93c5fd;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #eff6ff;
            border: 1px solid #dbeafe;
            color: #1e40af;
            border-radius: 0.375rem;
            padding: 2px 8px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #1e40af;
            margin-right: 5px;
            border-right: none;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            background-color: transparent;
            color: #1d4ed8;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased">
    
    <!-- Navigation Sidebar -->
    @include('admin.layout.sidebar')

    <!-- Main Content Area -->
    <div class="p-4 sm:ml-64">
        <!-- Top Header -->
        @include('admin.layout.header')

        <!-- Dynamic Content -->
        <main>
            @if(session('status'))
                <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <span class="sr-only">Success</span>
                    <div class="ms-3 text-sm font-medium">
                        {{ session('status') }}
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-3" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
        
        @include('admin.layout.footer')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.select2-multiple').select2({
                placeholder: "Select Related Calculators",
                allowClear: true
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
