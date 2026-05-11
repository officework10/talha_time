@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Edit Calculator</h1>
    <p class="text-gray-500 text-sm">Update configuration for: <span class="text-primary-600">{{ $page->cal_title }}</span></p>
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

<form method="POST" action="{{ url('admin/edit-calculator/'.$page->cal_id) }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="cal_cat" id="cayegoryName" value="{{$page->cal_cat}}">
    <input type="hidden" name="is_calculator" value="Calculator">
    @php $related = json_decode($page->related_cal, true); @endphp
    <input type="hidden" name="count_rel" value="{{ is_array($related) ? count($related)-1 : 0 }}" class="count_rel">
    <input type="hidden" id="key_token" value="{{ csrf_token() }}">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Configuration (Left Column) -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Basic Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="cat_cal" class="block mb-2 text-sm font-semibold text-gray-900">Category</label>
                        <select id="cat_cal" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            @foreach ($get_cats as $item)
                                <option value="{{$item->cat_id}}" {{$item->cat_name == $page->cal_cat ? 'selected' : ''}}>{{$item->cat_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="cal_sub_cat" class="block mb-2 text-sm font-semibold text-gray-900">Sub-Category</label>
                        <select id="cal_sub_cat" name="cal_sub_cat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option selected disabled>Select Sub-Category</option>
                            @foreach ($get_subcats as $item)
                                <option value="{{ $item->cat_id }}" {{ isset($get_sub) && $get_sub->cat_id == $item->cat_id ? 'selected' : '' }}>{{ $item->cat_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="naam" class="block mb-2 text-sm font-semibold text-gray-900">Calculator Title</label>
                    <input type="text" name="cal_title" id="naam" value="{{$page->cal_title}}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                </div>

                <div>
                    <label for="cal_url" class="block mb-2 text-sm font-semibold text-gray-900">Page URL</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md font-mono">/</span>
                        <input type="text" name="cal_url" id="cal_url" value="{{$page->cal_link}}" required class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-primary-500 focus:border-primary-500 block flex-1 min-w-0 w-full p-2.5 text-sm font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="parent" class="block mb-2 text-sm font-semibold text-gray-900">Parent Calculator</label>
                        <input type="text" name="parent" list="p" id="parent" value="{{$page->parent}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                        <datalist id="p">
                            @foreach($parent as $value)
                                @php $url_parts = explode('/', $value->cal_link); @endphp
                                @if(count($url_parts) === 1)
                                    <option value="{{$value->cal_title}}">{{$value->cal_title}}</option>
                                @endif
                            @endforeach
                        </datalist>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Content & Media</h2>
                
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-900">Page Content</label>
                    <textarea class="ckeditor" name="content" id="ckeditor_content" required>{!! $page->content !!}</textarea>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-900">Short Description</label>
                    <textarea name="cal_des" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">{{ $page->cal_detail }}</textarea>
                </div>


            </div>
        </div>

        <!-- Settings & Keys (Right Column) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Visibility & SEO</h2>
                
                <div class="flex flex-col gap-4">
                    <label class="inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="noindex" {{ $page->no_index == 1 ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-green-500 relative
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border
                                    after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Index (SEO)</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="show_hide" {{ $page->show_hide == 1 ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-green-500 relative
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border
                                    after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Show Calculator</span>
                    </label>
                </div>

                <hr>

                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900">Meta Title</label>
                        <input type="text" name="meta_title" value="{{$page->meta_title}}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900">Meta Description</label>
                        <input type="text" name="meta_des" value="{{$page->meta_des}}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Page Keys</h2>
                <div class="add_keys space-y-3">
                    @php $keys = json_decode($page->lang_keys); @endphp
                    @foreach ($keys as $key => $value)
                    <div class="flex gap-2">
                        <input type="text" name="keyname[]" value="{{$key}}" class="bg-gray-100 border border-gray-300 text-gray-500 text-[10px] rounded-lg block w-1/3 p-2 font-mono" placeholder="Key Name">
                        <input type="text" name="keyvalue[]" value="{{$value}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg block w-2/3 p-2">
                    </div>
                    @endforeach
                </div>
                <button type="button" onclick="addCustomKeyField()" class="w-full mt-4 flex items-center justify-center px-4 py-3 text-sm font-bold text-primary-600 bg-white border-2 border-primary-600 rounded-xl hover:bg-primary-50 transition-all">
                    <i class="fa-solid fa-plus mr-2"></i> Add Custom Key
                </button>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Related Calculators</h2>
                <div class="space-y-3">
                    <select class="select2-multiple block w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg p-2.5" name="related_cal[]" multiple>
                        @php $related_ids = is_array($related) ? array_filter($related, 'is_numeric') : []; @endphp
                        @foreach ($parent as $v)
                            <option {{ in_array($v->cal_id, $related_ids) ? 'selected' : '' }} value="{{ $v->cal_id }}">{{ $v->cal_title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" name="add_calculator" value="Update Calculator" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-bold rounded-xl text-sm px-5 py-4 text-center shadow-lg transition-all transform hover:-translate-y-1">
                    UPDATE CALCULATOR
                </button>
            </div>
        </div>
    </div>
</form>

<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script>
    function addCustomKeyField() {
        var html = '<div class="flex gap-2 animate-fadeIn mb-3">' +
            '<input type="text" name="keyname[]" class="bg-gray-100 border border-gray-300 text-gray-500 text-[10px] rounded-lg block w-1/3 p-2 font-mono" placeholder="Key Name">' +
            '<input type="text" name="keyvalue[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg block w-2/3 p-2" placeholder="Key Value">' +
            '</div>';
        $('.add_keys').append(html);
    }

    $(document).ready(function(){
        "use strict";
        
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.disableAutoInline = true;
            CKEDITOR.replace('ckeditor_content');
        }

        $('#cat_cal').change(function(){
            var cal_id=$(this).val();
            var token=$('#key_token').val();
            $.ajax({
                type: "post",
                url: "{{URL::to('admin/search-subcategory')}}",
                data: { cal_id : cal_id, _token : token },
                success: function(data){
                    var html = '<option value="">Select Subcategory</option>'; 
                    $.each(data.data, function(index, value) {
                        html += '<option value="' + value.cat_id + '">' + value.cat_name + '</option>';
                    });
                    $('#cayegoryName').val(data.categoriesName);
                    $('#cal_sub_cat').html(html);
                }
            });
        });
    });
</script>
@endsection