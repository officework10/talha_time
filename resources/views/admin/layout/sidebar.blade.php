<aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-white border-r border-gray-200" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white">
        <div class="flex items-center ps-2.5 mb-8">
            <div class="p-2 bg-indigo-600 rounded-lg me-3">
                <i class="fa-solid fa-calculator text-white text-xl"></i>
            </div>
            <span class="self-center text-xl font-bold whitespace-nowrap text-gray-800">Time Calculator <br><span class="text-sm font-normal text-gray-500">Calculator Panel</span></span>
        </div>
        
        <p class="px-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu</p>
        
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ url('admin/dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ Request::is('admin/dashboard') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <i class="fa-solid fa-gauge-high w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ Request::is('admin/dashboard') ? 'text-indigo-600' : '' }}"></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/calculators') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ Request::is('admin/calculators') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <i class="fa-solid fa-calculator w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ Request::is('admin/calculators') ? 'text-indigo-600' : '' }}"></i>
                    <span class="ms-3">Calculators</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/posts') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ Request::is('admin/posts') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <i class="fa-solid fa-newspaper w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ Request::is('admin/posts') ? 'text-indigo-600' : '' }}"></i>
                    <span class="ms-3">Blogs / Posts</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/media') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ Request::is('admin/media') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <i class="fa-solid fa-photo-film w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ Request::is('admin/media') ? 'text-indigo-600' : '' }}"></i>
                    <span class="ms-3">Media Library</span>
                </a>
            </li>
            @if (isset($LoginUser) && $LoginUser['role'] == 1)
            <li class="pt-4 pb-1">
                <p class="px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Management</p>
            </li>
            <li>
                <a href="{{ url('admin/users') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ Request::is('admin/users') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <i class="fa-solid fa-users-gear w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ Request::is('admin/users') ? 'text-indigo-600' : '' }}"></i>
                    <span class="ms-3">User Control</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/categories') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ Request::is('admin/categories') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <i class="fa-solid fa-layer-group w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ Request::is('admin/categories') ? 'text-indigo-600' : '' }}"></i>
                    <span class="ms-3">Categories</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/sub-categories') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ Request::is('admin/sub-categories') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                    <i class="fa-solid fa-sitemap w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ Request::is('admin/sub-categories') ? 'text-indigo-600' : '' }}"></i>
                    <span class="ms-3">Sub-Categories</span>
                </a>
            </li>
            @endif
        </ul>
        
        <div class="pt-4 mt-4 border-t border-gray-200">
            <a href="{{ url('admin/logout') }}" class="flex items-center p-2 text-red-600 rounded-lg hover:bg-red-50 group">
                <i class="fa-solid fa-right-from-bracket w-5 h-5 text-red-500 transition duration-75 group-hover:text-red-700"></i>
                <span class="ms-3">Logout</span>
            </a>
        </div>
    </div>
</aside>
