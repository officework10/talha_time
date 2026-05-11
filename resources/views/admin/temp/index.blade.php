@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Add New Calculator</h1>
    <p class="text-gray-500 text-sm">Create and configure a new calculator page</p>
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

<form method="POST" action="{{ url('admin/add-calculator') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="cal_cat" id="cayegoryName" value="">
    <input type="hidden" name="is_calculator" value="Calculator">
    <input type="hidden" name="count_rel" value="0" class="count_rel">
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
                            <option selected disabled>Select Category</option>
                            @foreach ($get_cats as $item)
                                <option value="{{$item->cat_id}}">{{$item->cat_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="cal_sub_cat" class="block mb-2 text-sm font-semibold text-gray-900">Sub-Category</label>
                        <select id="cal_sub_cat" name="cal_sub_cat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                        </select>
                    </div>
                </div>

                <div>
                    <label for="naam" class="block mb-2 text-sm font-semibold text-gray-900">Calculator Title</label>
                    <input type="text" name="cal_title" id="naam" value="{{old('cal_title')}}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="e.g. Time Duration Calculator">
                </div>

                <div>
                    <label for="cal_url" class="block mb-2 text-sm font-semibold text-gray-900">Page URL</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md font-mono">/</span>
                        <input type="text" name="cal_url" id="cal_url" value="{{old('cal_url')}}" required class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-primary-500 focus:border-primary-500 block flex-1 min-w-0 w-full p-2.5 text-sm font-mono" placeholder="time-duration-calculator">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="parent" class="block mb-2 text-sm font-semibold text-gray-900">Parent Calculator</label>
                        <input type="text" name="parent" list="p" id="parent" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
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
                    <textarea class="ckeditor" name="content" id="ckeditor_content" required>{{old('content')}}</textarea>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-900">Short Description</label>
                    <textarea name="cal_des" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"></textarea>
                </div>


            </div>
        </div>

        <!-- Settings & Keys (Right Column) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Visibility & SEO</h2>
                
                <div class="flex flex-col gap-4">
                    <label class="inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="noindex" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-green-500 relative
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border
                                    after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Index (SEO)</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="show_hide" checked class="sr-only peer">
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
                        <input type="text" name="meta_title" value="{{old('meta_title')}}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900">Meta Description</label>
                        <input type="text" name="meta_des" value="{{old('meta_des')}}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Page Keys</h2>
                <div class="add_keys space-y-3">
                    @php
                        $defaultKeys = [
                            'calculate' => 'Calculate',
                            'reset' => 'RE-CALCULATE',
                            'res' => 'Result',
                            'related_cal' => 'Related',
                            'more_cal' => 'More --',
                            'get' => 'Get The',
                            'widget' => 'Widget!',
                            'widget_content' => 'Add -- to your website to get the ease of using this calculator directly. Feel hassle-free to account this widget as it is 100% free, simple to use, and you can add it on multiple online platforms.',
                            'add_site' => 'ADD THIS CALCULATOR ON YOUR WEBSITE:',
                            'calculator' => 'Calculator',
                            'ave' => 'Available',
                            'on' => 'on App',
                            'app_note' => 'Download -- App for Your Mobile, So you can calculate your values in your hand.',
                            'get_code' => 'Get Code'
                        ];
                    @endphp
                    @foreach($defaultKeys as $key => $val)
                    <div class="flex gap-2">
                        <input type="text" name="keyname[]" readonly value="{{ $key }}" class="bg-gray-100 border border-gray-300 text-gray-500 text-[10px] rounded-lg block w-1/3 p-2 font-mono">
                        <input type="text" name="keyvalue[]" id="{{ $key == 'more_cal' ? 'cat_change' : ($key == 'widget_content' ? 'name_change' : ($key == 'app_note' ? 'name_change1' : '')) }}" value="{{ $val }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg block w-2/3 p-2">
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
                        @foreach ($parent as $v)
                            <option value="{{ $v->cal_id }}">{{ $v->cal_title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" name="add_calculator" value="Add Calculator" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-bold rounded-xl text-sm px-5 py-4 text-center shadow-lg transition-all transform hover:-translate-y-1">
                    SAVE CALCULATOR
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
        
        // CKEditor initialization
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('ckeditor_content');
        }

        $('#naam').on("focusout",function(){
            var naam=$(this).val();
            var name_change=$('#name_change').val();
            var name_change1=$('#name_change1').val();
            if(name_change) $('#name_change').val(name_change.replace("--",naam));
            if(name_change1) $('#name_change1').val(name_change1.replace("--",naam));
        });

        $('#cat_cal').on("change",function(){
            var cat_cal=$(this).find('option:selected').text();
            var cat_change=$('#cat_change').val();
            if(cat_change) $('#cat_change').val(cat_change.replace("--",cat_cal));
        });

        $('#cat_cal').change(function(){
            var cal_id=$(this).val();
            var token=$('#key_token').val();
            $.ajax({
                type: "post",
                url: "{{URL::to('admin/search-subcategory')}}/",
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