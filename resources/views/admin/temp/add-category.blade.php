@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Add New Category</h1>
    <p class="text-gray-500 text-sm">Organize your calculators into high-level groups</p>
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
    <form method="POST" action="{{ url()->current() }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        @if(count($cats) > 0)
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-900">Existing Categories</label>
                <div class="flex flex-wrap gap-2 p-3 bg-gray-50 rounded-lg border border-gray-100">
                    @foreach ($cats as $row)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-700">
                            {{$row->cat_name}}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <div>
            <label for="cat_name" class="block mb-2 text-sm font-semibold text-gray-900">Category Name</label>
            <input type="text" name="cat_name" id="cat_name" value="{{ old('cat_name', request()->cat_name) }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="e.g. Health & Fitness">
        </div>

        <div>
            <label class="block mb-2 text-sm font-semibold text-gray-900">Category Image</label>
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors relative overflow-hidden">
                    <div id="preview-container" class="flex flex-col items-center justify-center pt-5 pb-6">
                        <i class="fa-solid fa-image text-gray-400 text-3xl mb-3"></i>
                        <p class="mb-2 text-sm text-gray-500 font-semibold text-center px-4">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-400">PNG, JPG or WEBP (MAX. 800x400px)</p>
                    </div>
                    <img id="image-preview" src="#" alt="Preview" class="hidden absolute inset-0 w-full h-full object-cover">
                    <input id="dropzone-file" type="file" name="img" class="hidden" accept=".png,.jpg,.jpeg,.gif,.webp" onchange="previewImage(this)" />
                </label>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" name="addCategory" value="Add Category" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-8 py-2.5 text-center transition-all">
                <i class="fa-solid fa-folder-plus mr-2"></i> Save Category
            </button>
            <a href="{{ url('admin/all-categories') }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('preview-container');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (container) container.classList.add('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection