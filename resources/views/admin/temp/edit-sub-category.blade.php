@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Edit Sub-Category</h1>
    <p class="text-gray-500 text-sm">Update organizational group: <span class="text-primary-600 font-semibold">{{ $cat_detail->cat_name }}</span></p>
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
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-error" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

<div class="max-w-2xl bg-white border border-gray-200 rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ url()->current() }}" class="space-y-6">
        @csrf
        
        @if(count($cats) > 0)
            <div>
                <label for="cat_parent" class="block mb-2 text-sm font-semibold text-gray-900">Main Category</label>
                <select id="cat_parent" name="cat_parent" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                    @foreach ($cats as $row)
                        <option value="{{$row->cat_id}}" {{$cat_detail->cat_parent == $row->cat_id ? 'selected' : ''}}>{{$row->cat_name}}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div>
            <label for="cat_name" class="block mb-2 text-sm font-semibold text-gray-900">Sub-Category Name</label>
            <input type="text" name="cat_name" id="cat_name" value="{{$cat_detail->cat_name}}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <button type="submit" name="updateCategory" value="Update Category" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-8 py-2.5 text-center transition-all">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Update Sub-Category
            </button>
            <a href="{{ url('admin/sub-categories') }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection