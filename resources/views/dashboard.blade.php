@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white shadow-lg rounded-lg p-6">

            <!-- Navigation -->
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h1 class="text-2xl font-semibold">Dashboard</h1>
                <div class="space-x-4">
                    <a href="{{ route('logs.index') }}" class="text-blue-500 hover:underline">Logs</a>
                    <a href="{{ route('employee.index') }}" class="text-blue-500 hover:underline">Employees</a>
                    <a href="{{ route('profile.show') }}" class="text-blue-500 hover:underline">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:underline">Log Out</button>
                    </form>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Profile Information</h2>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input id="name" name="name" type="text" value="{{ auth()->user()->name }}" class="w-full p-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ auth()->user()->email }}" class="w-full p-2 border rounded">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </form>
            </div>

            <!-- Update Password -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Update Password</h2>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input id="current_password" name="current_password" type="password" class="w-full p-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input id="password" name="password" type="password" class="w-full p-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="w-full p-2 border rounded">
                    </div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
                </form>
            </div>

            <!-- Delete Account -->
            <div>
                <h2 class="text-lg font-semibold mb-2 text-red-600">Delete Account</h2>
                <p class="text-sm text-gray-600 mb-4">
                    Once your account is deleted, all of its resources and data will be permanently removed. Please back up any data you wish to keep.
                </p>
                <form method="POST" action="{{ route('account.delete') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete Account</button>
                </form>
            </div>

        </div>
    </div>
@endsection
