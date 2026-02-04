@extends('layouts.admin')

@section('title', 'Ticket Details')
@section('page_title', 'Ticket Details')

@section('content')
    <div class="max-w-6xl mx-auto p-6">
        <!-- Ticket Header -->
        <div class="bg-gradient-to-r from-blue-700 to-blue-600 rounded-2xl shadow-lg p-5 mb-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-white text-sm">Ticket subject</p>
                    <h1 class="text-3xl font-bold mb-3">{{ $ticket->subject }}</h1>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div class="bg-blue-500 bg-opacity-50 rounded-lg p-3">
                            <span class="opacity-75">Ticket ID</span>
                            <p class="font-bold text-lg">#{{ $ticket->id }}</p>
                        </div>
                        <div class="bg-blue-500 bg-opacity-50 rounded-lg p-3">
                            <span class="opacity-75">Status</span>
                            <p class="font-bold">{{ $ticket->status->label() }}</p>
                        </div>
                        <div class="bg-blue-500 bg-opacity-50 rounded-lg p-3">
                            <span class="opacity-75">Priority</span>
                            <p class="font-bold">{{ $ticket->priority->label() }}</p>
                        </div>
                        <div class="bg-blue-500 bg-opacity-50 rounded-lg p-3">
                            <span class="opacity-75">Messages</span>
                            <p class="font-bold">{{ count($ticket->messages) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-blue-100">
                <span>Created: {{ $ticket->created_at->format('d M Y, h:i A') }}</span>
                @if($ticket->closed_at)
                    <span class="ml-4">Closed: {{ $ticket->closed_at->format('d M Y, h:i A') }}</span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <!-- Conversation Section -->
            <div class="col-span-2 rounded-2xl shadow-lg p-8">
                <div class="p-0 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Conversation</h1>
                    <div class="w-full h-px bg-gray-400 mt-2"></div>
                </div>

                <div class="space-y-4 max-h-96 overflow-y-auto pr-4">
                    @foreach ($ticket->messages as $message)
                        @if ($message->user?->isCustomer())
                            <!-- Customer Message -->
                            <div class="flex justify-start">
                                <div
                                    class="max-w-xl bg-white border-l-4 border-gray-400 rounded-2xl p-4 shadow-md hover:shadow-lg transition">
                                    <p class="text-gray-800">{{ $message->message }}</p>
                                    <span
                                        class="text-xs text-gray-500 block mt-2">{{ $message->created_at->format('d M y, h:i A') }}</span>
                                </div>
                            </div>
                        @else
                            <!-- Admin / Agent Message -->
                            <div class="flex justify-end">
                                <div
                                    class="max-w-xl bg-blue-600 border-r-4 border-blue-800 text-white rounded-2xl p-4 shadow-md hover:shadow-lg transition">

                                    <p class="text-white">{{ $message->message }}</p>
                                    <span
                                        class="text-xs text-blue-200 block mt-3 font-medium">{{ $message->created_at->format('d M y, h:i A') }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Reply Section -->
            <div class="rounded-2xl shadow-lg p-8 h-fit">
                <div class="p-0 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Send Reply</h1>
                    <div class="w-full h-px bg-gray-400 mt-2"></div>
                </div>

                @if(!$ticket->isClosed())
                    <form method="POST" action="{{ route('tickets.messages.store', $ticket->id) }}">
                        @csrf
                        <div class="space-y-4">
                            <textarea name="message" rows="5" required
                                      class="w-full rounded-xl border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none"
                                      placeholder="Type your reply..."></textarea>
                            <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium transition">
                                Send Reply
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center text-sm text-gray-500 py-6">
                        <p class="font-medium">This ticket is closed</p>
                        <p class="text-xs mt-2">No further replies are allowed.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
