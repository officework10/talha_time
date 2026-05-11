@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Add New Sub-Category</h1>
    <p class="text-gray-500 text-sm">Deepen your calculator organization within main categories</p>
</div>

@if(isset($status))
    <div id="alert-success" class="flex items-center p-4 mb-6 text-green-800 rounded-lg bg-green-50" role="alert">
        <i class="fa-solid fa-circle-check"></i>
        <div class="ms-3 text-sm font-medium">{{ $status }}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-success" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

@if(isset($error))
    <div id="alert-error" class="flex items-center p-4 mb-6 text-red-800 rounded-lg bg-red-50" role="alert">
        <i class="fa-solid fa-circle-exclamation"></i>
        <div class="ms-3 text-sm font-medium">{{ $error }}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-error" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

<div class="max-w-2xl bg-white border border-gray-200 rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ url()->current() }}" class="space-y-6">
        @csrf
        
        @if(count($cats) > 0)
            <div>
                <label for="cat_parent" class="block mb-2 text-sm font-semibold text-gray-900">Select Main Category</label>
                <select id="cat_parent" name="cat_parent" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                    <option selected disabled>Choose a main category</option>
                    @foreach ($cats as $row)
                        <option value="{{$row->cat_id}}">{{$row->cat_name}}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div>
            <label for="cat_name" class="block mb-2 text-sm font-semibold text-gray-900">Sub-Category Name</label>
            <input type="text" name="cat_name" id="cat_name" value="{{ old('cat_name', request()->cat_name) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="e.g. BMI Calculators">
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" name="subCategory" value="Add Sub Category" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-8 py-2.5 text-center transition-all">
                <i class="fa-solid fa-sitemap mr-2"></i> Save Sub-Category
            </button>
            <a href="{{ url('admin/sub-categories') }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection