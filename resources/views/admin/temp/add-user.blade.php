@extends('admin.layout.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Add New User</h1>
    <p class="text-gray-500 text-sm">Create a new administrative account</p>
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

@if ($errors->any())
    <div class="p-4 mb-6 text-red-800 rounded-lg bg-red-50" role="alert">
        <div class="flex items-center mb-2">
            <i class="fa-solid fa-circle-exclamation mr-2"></i>
            <span class="font-bold">Please fix the following errors:</span>
        </div>
        <ul class="mt-1.5 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-2xl bg-white border border-gray-200 rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ url('admin/add-user') }}">
        @csrf
        <div class="grid gap-6 mb-6">
            <div>
                <label for="naam" class="block mb-2 text-sm font-semibold text-gray-900">Username</label>
                <input type="text" name="name" id="naam" value="{{old('name')}}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 transition-all" placeholder="Enter username">
            </div>
            
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="password" class="block mb-2 text-sm font-semibold text-gray-900">Password</label>
                    <input type="password" name="password" id="password" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 transition-all" placeholder="••••••••">
                </div>
                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-semibold text-gray-900">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 transition-all" placeholder="••••••••">
                </div>
            </div>

            <div>
                <label for="role" class="block mb-2 text-sm font-semibold text-gray-900">User Role</label>
                <select id="role" name="role" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 transition-all">
                    <option selected disabled>Select User Role</option>
                    <option value="1">Admin</option>
                    <option value="2">Editor</option>
                </select>
            </div>

            <div class="flex items-center">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="active" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-900">Account Active</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" name="add_user" value="Add User" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all">
                <i class="fa-solid fa-user-plus mr-2"></i> Create User
            </button>
            <a href="{{ url('admin/users') }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection