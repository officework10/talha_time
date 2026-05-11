<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Technical Calculator Admin</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind & Flowbite -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 20px 20px;
        }
        .gradient-text {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-pattern antialiased">
    <section class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo Section -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-600 rounded-2xl shadow-xl shadow-primary-200 mb-4 transition-transform hover:scale-105 duration-300">
                    <i class="fa-solid fa-calculator text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Technical <span class="gradient-text">Calculator</span></h1>
                <p class="text-gray-500 mt-2 font-medium">Administrative Control Center</p>
            </div>

            <!-- Main Card -->
            <div class="glass-panel rounded-3xl shadow-2xl shadow-blue-100/50 p-8 border border-white">
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800">Welcome Back</h2>
                    <p class="text-sm text-gray-500 mt-1">Please enter your credentials to access the dashboard.</p>
                </div>

                <!-- Alert Handling -->
                @if($error = Session::get('admin_error'))
                    <div id="alert-login-error" class="flex items-center p-4 mb-6 text-red-800 rounded-xl bg-red-50 border border-red-100" role="alert">
                        <i class="fa-solid fa-circle-exclamation text-lg"></i>
                        <div class="ms-3 text-sm font-medium">{{ $error }}</div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-login-error">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 mb-6 text-red-800 rounded-xl bg-red-50 border border-red-100" role="alert">
                        <div class="flex items-center mb-1">
                            <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                            <span class="text-sm font-bold">Please check the following:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('admin/login') }}" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label for="name" class="block mb-2 text-xs font-bold text-gray-700 uppercase tracking-wider">Username</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none transition-colors group-focus-within:text-primary-600">
                                <i class="fa-solid fa-user-shield text-gray-400 group-focus-within:text-primary-500"></i>
                            </div>
                            <input type="text" name="name" id="name" required class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full ps-10 p-3 transition-all placeholder:text-gray-400" placeholder="e.g. admin_pro">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                            <a href="#" class="text-xs font-semibold text-primary-600 hover:text-primary-700 transition-colors">Forgot Password?</a>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none transition-colors group-focus-within:text-primary-600">
                                <i class="fa-solid fa-lock text-gray-400 group-focus-within:text-primary-500"></i>
                            </div>
                            <input type="password" name="pass" id="password" required class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full ps-10 p-3 transition-all placeholder:text-gray-400" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="remember" type="checkbox" class="w-4 h-4 text-primary-600 bg-gray-50 border-gray-300 rounded focus:ring-primary-500 transition-colors">
                        <label for="remember" class="ms-2 text-sm font-medium text-gray-500">Remember me for 30 days</label>
                    </div>

                    <button type="submit" name="submit" value="Login" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all transform hover:-translate-y-0.5 active:scale-95 shadow-lg shadow-primary-200">
                        SIGN IN TO DASHBOARD
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-400">
                        Protected by AES-256 Encryption & Standard SSL<br>
                        &copy; {{ date('Y') }} Technical Calculator Admin Panel
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>
</html>
