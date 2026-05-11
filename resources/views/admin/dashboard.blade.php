@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
    <p class="text-gray-500 mt-1">Complete statistics and analytics of your Technical Calculator system</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Calculators Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Calculators</p>
                <h3 class="text-4xl font-bold text-indigo-600 mt-1">{{ $stats['calculators']['total'] }}</h3>
            </div>
            <div class="p-3 bg-indigo-50 rounded-xl">
                <i class="fa-solid fa-calculator text-indigo-600 text-xl"></i>
            </div>
        </div>
        <div class="space-y-2 pt-4 border-t border-gray-50">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Normal:</span>
                <span class="font-semibold text-gray-700">{{ $stats['calculators']['normal'] }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Language:</span>
                <span class="font-semibold text-gray-700">{{ $stats['calculators']['language'] }}</span>
            </div>
            <div class="flex justify-between text-sm pt-1">
                <span class="text-green-600">Indexed:</span>
                <span class="font-semibold text-green-600">{{ $stats['calculators']['indexed'] }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-red-500">No-Index:</span>
                <span class="font-semibold text-red-500">{{ $stats['calculators']['no_index'] }}</span>
            </div>
        </div>
    </div>


    <!-- Posts Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Posts/Blogs</p>
                <h3 class="text-4xl font-bold text-amber-600 mt-1">{{ $stats['posts']['total'] }}</h3>
            </div>
            <div class="p-3 bg-amber-50 rounded-xl">
                <i class="fa-solid fa-newspaper text-amber-600 text-xl"></i>
            </div>
        </div>
        <div class="space-y-2 pt-4 border-t border-gray-50">
            <div class="flex justify-between text-sm pt-1">
                <span class="text-emerald-600">Indexed:</span>
                <span class="font-semibold text-emerald-600">{{ $stats['posts']['indexed'] }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-red-500">No-Index:</span>
                <span class="font-semibold text-red-500">{{ $stats['posts']['no_index'] }}</span>
            </div>
        </div>
    </div>

</div>

<!-- Second Row of Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Categories Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-blue-50 rounded-xl">
                <i class="fa-solid fa-tags text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Categories</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['categories'] }}</h3>
                <p class="text-xs text-gray-400">Main categories</p>
            </div>
        </div>
    </div>

    <!-- Sub-Categories Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-pink-50 rounded-xl">
                <i class="fa-solid fa-sitemap text-pink-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Sub-Categories</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['sub_categories'] }}</h3>
                <p class="text-xs text-gray-400">Total sub-categories</p>
            </div>
        </div>
    </div>

    <!-- Users Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-cyan-50 rounded-xl">
                <i class="fa-solid fa-users text-cyan-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Users</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['users']['total'] }}</h3>
                <div class="flex space-x-2 text-[10px]">
                    <span class="text-emerald-500 font-bold">Active: {{ $stats['users']['active'] }}</span>
                    <span class="text-red-400 font-bold">Inactive: {{ $stats['users']['inactive'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Images Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-rose-50 rounded-xl">
                <i class="fa-solid fa-image text-rose-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Images</p>
                <h3 class="text-2xl font-bold text-rose-600">{{ $stats['images'] }}</h3>
                <p class="text-xs text-gray-400">Media library images</p>
            </div>
        </div>
    </div>
</div>

<!-- Category-wise Statistics Placeholder -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Category-wise Calculator Statistics</h2>
    <div class="flex items-center justify-center h-48 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
        <p class="text-gray-400 italic">Detailed charts and category breakdowns will appear here</p>
    </div>
</div>
@endsection
