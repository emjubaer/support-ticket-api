@extends('layouts.customer')

@section('title', 'My Tickets')
@section('page_title', 'My Tickets')

@section('content')

    <div class="bg-white rounded-xl shadow ">

        <div class="p-5 border-b flex justify-between items-center">
            <h2 class="font-semibold">My Tickets</h2>

            <a href="#" onclick="openCreateTicketModal()"
                class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 text-sm font-medium">

                Create a New Ticket

            </a>
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

                        <td class="p-3">
                            {{ $ticket->id }}
                        </td>

                        <td class="p-3">
                            {{ $ticket->subject }}
                        </td>

                        <!-- Priority -->

                        <td class="p-3 text-center">

                            @if ($ticket->priority?->value === 'high')
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                    {{ $ticket->priority->label() }}
                                </span>
                            @elseif($ticket->priority?->value === 'medium')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                    {{ $ticket->priority->label() }}
                                </span>
                            @elseif($ticket->priority?->value === 'low')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                    {{ $ticket->priority->label() }}
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                                    Not Set
                                </span>
                            @endif

                        </td>

                        <!-- Status -->

                        <td class="p-3 text-center">

                            @if ($ticket->isOpen())
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                    {{ $ticket->status->label() }}
                                </span>
                            @elseif($ticket->isInProgress())
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                    {{ $ticket->status->label() }}
                                </span>
                            @elseif($ticket->isClosed())
                                <span class="px-3 py-1 bg-red-300 text-white rounded-full text-xs font-semibold">
                                    {{ $ticket->status->label() }}
                                </span>
                            @endif

                        </td>

                        <!-- Agent -->

                        <td class="p-3 text-center">

                            @if ($ticket->agent)
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                    {{ $ticket->agent->name }}
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                                    Unassigned
                                </span>
                            @endif

                        </td>

                        <!-- Action -->

                        <td class="p-3 text-center">

                            <a href="{{ route('customer.ticket.show', $ticket) }}"
                                class="text-blue-600 hover:underline text-sm">

                                👁️ View Details

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">
                            No tickets found
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

        <div class="p-4">
            {{ $tickets->links() }}
        </div>

    </div>


    <!-- Create Ticket Modal -->

    <div id="createTicketModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">

        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">

            <div class="px-6 py-4 border-b flex justify-between items-center">

                <h3 class="text-lg font-semibold text-gray-800">
                    Create New Ticket
                </h3>

                <button onclick="closeCreateTicketModal()" class="text-gray-400 hover:text-gray-600">

                    ✕

                </button>

            </div>

            <form action="{{ route('tickets.store') }}" method="POST" class="px-6 py-5 space-y-4">

                @csrf

                <div>
                    <label class="block text-sm text-gray-700 mb-1">
                        Subject
                    </label>

                    <input type="text" name="subject" required class="w-full border rounded-lg p-2 text-sm"
                        placeholder="Enter ticket subject">
                </div>

                <div>

                    <label class="block text-sm text-gray-700 mb-1">
                        Message
                    </label>

                    <textarea name="message" required rows="4" class="w-full border rounded-lg p-2 text-sm"
                        placeholder="Describe the issue">
                </textarea>

                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">

                    <button type="button" onclick="closeCreateTicketModal()"
                        class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100">

                        Cancel

                    </button>

                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">

                        Create Ticket

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection


<script>
    function openCreateTicketModal() {
        document
            .getElementById('createTicketModal')
            .classList
            .remove('hidden');
    }

    function closeCreateTicketModal() {
        document
            .getElementById('createTicketModal')
            .classList
            .add('hidden');
    }
</script>
