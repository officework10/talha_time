@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Media Library</h1>
    <p class="text-gray-500 text-sm">Upload and manage images for your calculators and posts</p>
</div>

@if($status=Session::get('status'))
    <div id="alert-success" class="flex items-center p-4 mb-6 text-green-800 rounded-lg bg-green-50" role="alert">
        <i class="fa-solid fa-circle-check"></i>
        <div class="ms-3 text-sm font-medium">{{ $status }}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-success" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-1">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Upload New Image</h2>
            <form method="post" action="" enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Choose image file</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fa-solid fa-cloud-arrow-up text-gray-400 text-2xl mb-2"></i>
                                <p class="text-xs text-gray-500 font-semibold">Click to upload</p>
                                <p class="text-[10px] text-gray-400">PNG, JPG or WEBP</p>
                            </div>
                            <input id="dropzone-file" type="file" name="image" class="hidden" accept=".png,.jpg,.jpeg,.gif,.webp" />
                        </label>
                    </div>
                </div>
                <button type="submit" name="upload" value="hy" class="w-full flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">
                    <i class="fa-solid fa-upload mr-2"></i> Upload Now
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden h-full">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <h2 class="font-semibold text-gray-800">Media Files</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500" id="myTable">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-4 py-3 font-bold">#</th>
                            <th scope="col" class="px-4 py-3 font-bold">Preview</th>
                            <th scope="col" class="px-4 py-3 font-bold">File URL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $i = 0; @endphp
                        @foreach ($files as $file)
                            @php
                                $extension = pathinfo($file, PATHINFO_EXTENSION);
                                $fileName = pathinfo($file, PATHINFO_BASENAME);
                            @endphp
                            @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                @php $i++; @endphp
                                <tr class="bg-white hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">{{ $i }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ url('images/'.$fileName) }}" class="w-12 h-12 rounded object-cover border border-gray-200" alt="{{ $fileName }}">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <input type="text" readonly value="{{ url('images/'.$fileName) }}" class="bg-gray-50 border border-gray-300 text-gray-400 text-[10px] rounded-lg block w-full p-1 font-mono">
                                            <button onclick="copyToClipboard('{{ url('images/'.$fileName) }}')" class="text-primary-600 hover:text-primary-700 text-xs font-bold" title="Copy URL">
                                                <i class="fa-solid fa-copy"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('URL copied to clipboard!');
        });
    }
    $(document).ready( function () {
        $('#myTable').DataTable({
            "pageLength": 10,
            "ordering": true
        });
    });
</script>
@endsection