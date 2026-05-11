@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Edit Post</h1>
    <p class="text-gray-500 text-sm">Modify article: <span class="text-primary-600">{{ $post->post_title }}</span></p>
</div>


@if ($errors->any())
    <div class="p-4 mb-6 text-red-800 rounded-lg bg-red-50" role="alert">
        <div class="flex items-center mb-2">
            <i class="fa-solid fa-circle-exclamation mr-2"></i>
            <span class="font-bold">Validation Errors:</span>
        </div>
        <ul class="mt-1.5 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ url('admin/edit-post/'.$post->post_id) }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Content Area (Left) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Post Content</h2>
                
                <div>
                    <label for="naam" class="block mb-2 text-sm font-semibold text-gray-900">Post Title</label>
                    <input type="text" name="title" id="naam" value="{{$post->post_title}}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                </div>

                <div>
                    <label for="post_url" class="block mb-2 text-sm font-semibold text-gray-900">Post URL Slug</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md font-mono">/</span>
                        <input type="text" name="post_url" id="post_url" value="{{$post->post_url}}" required class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-primary-500 focus:border-primary-500 block flex-1 min-w-0 w-full p-2.5 text-sm font-mono">
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-900">Short Description</label>
                    <textarea name="short_des" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">{{$post->short_des}}</textarea>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-900">Full Content</label>
                    <textarea class="ckeditor" name="des" id="ckeditor_content" required>{{$post->post_des}}</textarea>
                </div>
            </div>
        </div>

        <!-- Settings Area (Right) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Organization & SEO</h2>
                
                <div>
                    <label for="cat" class="block mb-2 text-sm font-semibold text-gray-900">Category</label>
                    <select id="cat" name="cat" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                        <option value="Date" {{$post->post_cat=='Date'?'selected':''}}>Date</option>
                        <option value="Time" {{$post->post_cat=='Time'?'selected':''}}>Time</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-900">Related Calculators</label>
                    <select class="select2-multiple block w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg p-2.5" name="related_cal[]" multiple>
                        @php $related = json_decode($post->related_cal, true) ?? []; @endphp
                        @foreach ($calculators as $value)
                            <option {{ in_array($value->cal_id, $related) ? 'selected' : '' }} value="{{ $value->cal_id }}">{{ $value->cal_title }}</option>
                        @endforeach
                    </select>
                </div>

                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-900">Featured Image</label>
                        <div class="relative group w-full h-40 mb-2 overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                            <img id="image-preview" src="{{ $post->post_img ? url('images/'.$post->post_img) : '#' }}" class="w-full h-full object-cover {{ $post->post_img ? '' : 'hidden' }}">
                            @if($post->post_img)
                                <div id="current-badge" class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="text-white text-xs font-bold uppercase">Current Image</span>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="post_img" onchange="previewImage(this)" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" accept=".png,.jpg,.jpeg,.gif,.webp">
                    </div>

                <hr class="my-4">

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-900">Meta Title</label>
                    <input type="text" name="meta_title" value="{{$post->meta_title}}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-900">Meta Description</label>
                    <textarea name="meta_des" rows="3" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">{{$post->meta_des}}</textarea>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Status & Visibility</h2>
                
                <div class="flex flex-col gap-4">
                    <label class="inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="show_hide" {{ $post->show_hide == 1 ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-green-500 relative
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border
                                    after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Show and Hide Post</span>
                    </label>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <button type="submit" name="add_post" value="Update Post" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-bold rounded-xl text-sm px-5 py-4 text-center shadow-lg transition-all transform hover:-translate-y-1">
                        SAVE CHANGES
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script>
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.disableAutoInline = true;
        CKEDITOR.replace('ckeditor_content');
    }

    $(document).ready(function(){
        // Select2 is initialized in the main layout
    });
</script>
@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const badge = document.getElementById('current-badge');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (badge) badge.classList.add('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection