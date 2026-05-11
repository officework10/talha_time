@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
        <p class="text-gray-500 text-sm">Manage administrative users and their roles</p>
    </div>
    <a href="{{ url('admin/add-user') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 transition-colors">
        <i class="fa-solid fa-user-plus mr-2"></i>
        Add New User
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-200 bg-gray-50">
        <h2 class="font-semibold text-gray-800">All Registered Users</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500" id="myTable">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold">#</th>
                    <th scope="col" class="px-6 py-4 font-bold">Name</th>
                    <th scope="col" class="px-6 py-4 font-bold">Role</th>
                    <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                    <th scope="col" class="px-6 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $index => $row)
                    <tr class="bg-white hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold mr-3 text-xs">
                                    {{ strtoupper(substr($row->admin_name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-900">{{ $row->admin_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded text-xs font-medium {{ $row->role == 1 ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $row->role == 1 ? 'Admin' : 'Editor' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $row->is_active == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <span class="w-2 h-2 mr-1 rounded-full {{ $row->is_active == 1 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $row->is_active == 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ url('admin/edit-user/'.$row->admin_id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary-600 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors">
                                <i class="fa-solid fa-pen-to-square mr-1.5"></i>
                                Edit
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
    } );
</script>
@endsection