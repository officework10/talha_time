<header class="flex items-center justify-between mb-6 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="flex items-center">
        <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
            <span class="sr-only">Open sidebar</span>
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
    </div>
    
    <div class="flex items-center space-x-4">
        <a href="{{ url('admin/logout') }}" class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>
        <div class="flex items-center space-x-3 ps-4 border-s border-gray-200">
            <img class="w-10 h-10 rounded-full border-2 border-indigo-100" src="https://ui-avatars.com/api/?name={{ urlencode($LoginUser['admin_name'] ?? 'Admin') }}&background=6366f1&color=fff" alt="User avatar">
            <div class="hidden md:block">
                <p class="text-sm font-semibold text-gray-800">{{ $LoginUser['admin_name'] ?? 'Admin' }}</p>
                <p class="text-xs text-gray-500">{{ $LoginUser['role'] == 1 ? 'Super Admin' : 'Editor' }}</p>
            </div>
            <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
        </div>
    </div>
</header>
