@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-sm text-gray-500">Total Tickets</p>
        <p class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</p>
    </div>
    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-sm text-gray-500">Open</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['open'] ?? 0 }}</p>
    </div>
    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-sm text-gray-500">In Progress</p>
        <p class="text-2xl font-bold text-yellow-500">{{ $stats['in_progress'] ?? 0 }}</p>
    </div>
    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-sm text-gray-500">Closed</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['closed'] ?? 0 }}</p>
    </div>
</div>

<!-- Ticket Table -->
<div class="bg-white rounded-xl shadow">
    <div class="p-5 border-b flex justify-between items-center">
        <h2 class="font-semibold">Recent Tickets</h2>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="p-3 text-left">#</th>
                <th class="p-3 text-left">Subject</th>
                <th class="p-3">Priority</th>
                <th class="p-3">Status</th>
                <th class="p-3">Agent</th>
                <th class="p-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
                <tr class="border-t">
                    <td class="p-3">{{ $ticket->id }}</td>
                    <td class="p-3">{{ $ticket->subject }}</td>
                    <td class="p-3 text-center">{{ ucfirst($ticket->priority) }}</td>
                    <td class="p-3 text-center">{{ ucfirst($ticket->status) }}</td>
                    <td class="p-3 text-center">{{ $ticket->agent->name ?? 'Unassigned' }}</td>
                    <td class="p-3 text-center">
                        <a href="/admin/tickets/{{ $ticket->id }}" class="text-blue-600">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-gray-500">No tickets found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
