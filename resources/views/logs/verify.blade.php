@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Verify Subordinate Logs</h1>

    @foreach($subordinateLogs as $log)
    <div class="p-4 border rounded-lg mb-4 bg-white">
        <p><strong>{{ $log->employee->name }}</strong> - {{ $log->created_at->format('M d, Y') }}</p>
        <p>{{ $log->description }}</p>
        
        <form action="{{ route('logs.approve', $log->id) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-md">Approve</button>
        </form>

        <form action="{{ route('logs.reject', $log->id) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md">Reject</button>
        </form>
    </div>
    @endforeach
</div>
@endsection
