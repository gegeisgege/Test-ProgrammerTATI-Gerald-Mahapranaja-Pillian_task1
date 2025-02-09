@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Daily Logs
                </h1>
                @if(isset($employee))
                    <p class="text-gray-600">
                        <span class="font-medium">Employee:</span> {{ $employee->name }}
                    </p>
                @else
                    <div class="inline-flex items-center px-4 py-2 rounded-md bg-red-50 text-red-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>No employee record found</span>
                    </div>
                @endif
            </div>
            
            <a href="{{ route('logs.create') }}" 
                 class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-sm">
                     <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Log
            </a>
        </div>
    </div>

    <!-- Logs Table Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        @if(isset($dailyLogs) && $dailyLogs->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Log</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($dailyLogs as $log)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ optional($log->created_at)->format('M d, Y') ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $log->description ?? 'No log description' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-medium rounded-full 
                                    {{ $log->status === 'Approved' ? 'bg-green-100 text-green-800' : 
                                       ($log->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        'bg-red-100 text-red-800') }}">
                                    {{ $log->status ?? 'Unknown' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($log->status === 'Pending')
                                    <div class="flex space-x-2">
                                        <form action="{{ route('logs.approve', $log->id) }}" method="POST" class="approve-form">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 approve-btn">
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('logs.reject', $log->id) }}" method="POST" class="reject-form">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 reject-btn">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-medium rounded-full 
                                        {{ $log->status === 'Approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-4 text-gray-600">No logs available</p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".approve-form, .reject-form").forEach(form => {
            form.addEventListener("submit", function () {
                this.querySelector("button").disabled = true;
                this.querySelector("button").textContent = "Processing...";
            });
        });
    });
</script>
@endsection
