@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <!-- Ticket Header -->
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $ticket->subject }}</h1>
        <div class="text-sm text-gray-500 flex flex-wrap gap-4">
            <span><strong>Ticket ID:</strong> #{{ $ticket->id }}</span>
            <span><strong>Status:</strong> {{ $ticket->status->label() }}</span>
            <span><strong>Priority:</strong> {{ $ticket->priority->label() }}</span>
            <span><strong>Created:</strong> {{ $ticket->created_at->format('d M Y, h:i A') }}</span>
        </div>
    </div>

    <!-- Conversation Section -->
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Conversation</h2>

        <div class="space-y-4">
            @foreach($ticket->messages as $message)
                @if($message->user->role === 'customer')
                    <!-- Customer Message -->
                    <div class="flex justify-start">
                        <div class="max-w-xl bg-gray-100 rounded-2xl p-4">
                            <p class="text-gray-800">{{ $message->message }}</p>
                            <span class="text-xs text-gray-500 block mt-2">{{ $message->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>
                @else
                    <!-- Admin / Agent Message -->
                    <div class="flex justify-end">
                        <div class="max-w-xl bg-blue-600 text-white rounded-2xl p-4">
                            <p>{{ $message->message }}</p>
                            <span class="text-xs text-blue-200 block mt-2">{{ $message->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
