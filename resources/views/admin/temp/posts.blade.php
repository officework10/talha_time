@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Post Management</h1>
        <p class="text-gray-500 text-sm">Manage your blog posts and articles</p>
    </div>
    <a href="{{ url('admin/add-post') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 transition-colors">
        <i class="fa-solid fa-plus mr-2"></i>
        Add New Post
    </a>
</div>


<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-200 bg-gray-50">
        <h2 class="font-semibold text-gray-800">All Posts</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500" id="myTable">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold">Date</th>
                    <th scope="col" class="px-6 py-4 font-bold">Title</th>
                    <th scope="col" class="px-6 py-4 font-bold">Category</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                    <th scope="col" class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($posts as $row)
                    <tr class="bg-white hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                            {{ date("d M, Y", strtotime($row->post_time)) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-900 line-clamp-1">{{ $row->post_title }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-gray-500">
                            {{ $row->post_cat }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase {{ $row->show_hide == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $row->show_hide == 1 ? 'Show' : 'Hide' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-1.5 whitespace-nowrap">
                            <a href="{{ url('blog/'.$row->post_url.'/') }}" class="inline-flex items-center px-2 py-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 rounded hover:bg-emerald-100 transition-colors" target="_blank">
                                <i class="fa-solid fa-eye mr-1"></i> VIEW
                            </a>
                            <a href="{{ url('admin/edit-post/'.$row->post_id) }}" class="inline-flex items-center px-2 py-1 text-[10px] font-bold text-blue-600 bg-blue-50 rounded hover:bg-blue-100 transition-colors">
                                <i class="fa-solid fa-pen mr-1"></i> EDIT
                            </a>
                            <button onclick="deletePost('{{ url('admin/delete-post/'.$row->post_id) }}')" class="inline-flex items-center px-2 py-1 text-[10px] font-bold text-red-600 bg-red-50 rounded hover:bg-red-100 transition-colors">
                                <i class="fa-solid fa-trash mr-1"></i> DELETE
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function deletePost(link){
        if (confirm("Are you sure you want to delete this post? This cannot be undone.") == true) {
            window.location = link;
        }
    }
    $(document).ready( function () {
        $('#myTable').DataTable({
            "pageLength": 25,
            "ordering": true
        });
    });
</script>
@endsection
