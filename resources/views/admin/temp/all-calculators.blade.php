@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ $is }} Management</h1>
        <p class="text-gray-500 text-sm">Overview and stats for all {{ strtolower($is) }}s</p>
    </div>
    <a href="{{ url('admin/add-'. strtolower($is)) }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 transition-colors">
        <i class="fa-solid fa-plus mr-2"></i>
        Add New {{ $is }}
    </a>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-xs font-semibold text-gray-500 uppercase">Total</p>
        <p class="text-xl font-bold text-gray-900">{{ $total }}</p>
    </div>
    <div class="bg-green-50 p-4 rounded-xl border border-green-100 shadow-sm">
        <p class="text-xs font-semibold text-green-600 uppercase">Indexed</p>
        <p class="text-xl font-bold text-green-700">{{ $indexcount }}</p>
    </div>
    <div class="bg-red-50 p-4 rounded-xl border border-red-100 shadow-sm">
        <p class="text-xs font-semibold text-red-600 uppercase">No-Index</p>
        <p class="text-xl font-bold text-red-700">{{ $noindexcount }}</p>
    </div>
</div>



<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-200 bg-gray-50">
        <h2 class="font-semibold text-gray-800">All Pages</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500" id="myTable">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-4 py-3 font-bold">#</th>
                    <th scope="col" class="px-4 py-3 font-bold">Page Title</th>
                    <th scope="col" class="px-4 py-3 font-bold">Parent</th>
                    <th scope="col" class="px-4 py-3 font-bold">Link</th>
                    <th scope="col" class="px-4 py-3 font-bold text-center">Index</th>
                    <th scope="col" class="px-4 py-3 font-bold text-center">Status</th>
                    <th scope="col" class="px-4 py-3 font-bold">Category</th>
                    <th scope="col" class="px-4 py-3 font-bold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($pages as $index => $row)
                    <tr class="bg-white hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $row->cal_title }}</td>
                        <td class="px-4 py-3 text-xs text-gray-500">{{ $row->parent ?: $row->cal_title }}</td>
                        <td class="px-4 py-3 text-xs font-mono text-gray-400">{{ $row->cal_link }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $row->no_index == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $row->no_index == 1 ? 'Index' : 'No Index' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $row->show_hide == 1 ? 'bg-emerald-100 text-emerald-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $row->show_hide == 1 ? 'Show' : 'Hide' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs">{{ $row->cal_cat }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ url('admin/edit-'.strtolower($is).'/'.$row->cal_id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary-600 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors">
                                <i class="fa-solid fa-eye mr-1.5"></i>
                                View
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
        $('#myTable').DataTable({
            "pageLength": 25,
            "ordering": true,
            "info": true
        });
    });
</script>
@endsection
