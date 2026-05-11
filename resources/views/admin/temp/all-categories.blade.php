@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Category Management</h1>
        <p class="text-gray-500 text-sm">Organize your calculators into logical groups</p>
    </div>
    <a href="{{ url('admin/add-category') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 transition-colors">
        <i class="fa-solid fa-folder-plus mr-2"></i>
        Add New Category
    </a>
</div>


<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-200 bg-gray-50">
        <h2 class="font-semibold text-gray-800">All Categories</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500" id="myTable">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold">#</th>
                    <th scope="col" class="px-6 py-4 font-bold">Category Name</th>
                    <th scope="col" class="px-6 py-4 font-bold">Created Date</th>
                    <th scope="col" class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($cats as $index => $row)
                    <tr class="bg-white hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-2 h-2 rounded-full bg-primary-500 mr-3"></div>
                                <span class="font-bold text-gray-900">{{ $row->cat_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ \Carbon\Carbon::parse($row->cat_time)->format('h:i A, d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ url('admin/edit-category/'.$row->cat_id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                <i class="fa-solid fa-pen mr-1.5"></i>
                                Edit
                            </a>
                            <a href="{{ url('admin/delete-category/'.$row->cat_id) }}" onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone.')" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                <i class="fa-solid fa-trash mr-1.5"></i>
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    });
</script>
@endsection
