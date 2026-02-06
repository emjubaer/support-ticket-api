@php
// Removed inline helper; using a Blade partial for update-status forms.
@endphp



@extends('layouts.admin')

@section('title', 'Tickets')
@section('page_title', 'Tickets')

@section('content')
    <!-- Ticket Table -->
    <div class="bg-white rounded-xl shadow ">
        <div class="p-5 border-b flex justify-between items-center">
            <h2 class="font-semibold">All Tickets</h2>
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
                        <td class="p-3 text-center">
                            @if ($ticket->priority?->value === 'high')
                                <span
                                    class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">{{ $ticket->priority->label() }}</span>
                            @elseif($ticket->priority?->value === 'medium')
                                <span
                                    class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">{{ $ticket->priority->label() }}</span>
                            @elseif($ticket->priority?->value === 'low')
                                <span
                                    class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">{{ $ticket->priority->label() }}</span>
                            @else
                                <span
                                    class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">Unassigned</span>
                            @endif
                        </td>
                        <td class="p-3 text-center">
                            @if ($ticket->isOpen())
                                <span
                                    class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">{{ $ticket->status->label() }}</span>
                            @elseif($ticket->isInProgress())
                                <span
                                    class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">{{ $ticket->status->label() }}</span>
                            @elseif($ticket->isClosed())
                                <span
                                    class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">{{ $ticket->status->label() }}</span>
                            @else
                                <span
                                    class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">{{ $ticket->status->label() }}</span>
                            @endif
                        </td>
                        <td class="p-3 text-center">
                            @if ($ticket->agent)
                                <span
                                    class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">{{ $ticket->agent->name }}</span>
                            @else
                                <span
                                    class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">Unassigned</span>
                            @endif
                        </td>

                        <!-- Action 3 Dot Dropdown -->
                        <td class="p-3 text-center">
                            <div class="relative inline-block">
                                <button id="button-{{ $ticket->id }}"
                                    onclick="toggleDropdown(event, {{ $ticket->id }})"
                                    class="text-gray-600 hover:text-gray-900 font-bold text-lg cursor-pointer">
                                    ⋯
                                </button>
                                <div id="dropDownMenu-{{ $ticket->id }}"
                                    class="hidden absolute right-0 mt-1 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                                    <a href="{{ route('tickets.show', $ticket) }}"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b">
                                        👁️ View Details
                                    </a>
                                    @if ($ticket->isOpen())
                                        @include('admin.tickets.partials.update-status-form', [
                                            'ticket' => $ticket,
                                            'status' => 'in_progress',
                                            'routeName' => 'tickets.updateStatus',
                                            'buttonText' => 'Update to In-Progress'
                                        ])
                                    @elseif($ticket->isInProgress())
                                        @include('admin.tickets.partials.update-status-form', [
                                            'ticket' => $ticket,
                                            'status' => 'resolved',
                                            'routeName' => 'tickets.updateStatus',
                                            'buttonText' => 'Update to Resolved'
                                        ])
                                    @elseif($ticket->isResolved())
                                        @include('admin.tickets.partials.update-status-form', [
                                            'ticket' => $ticket,
                                            'status' => 'closed',
                                            'routeName' => 'tickets.updateStatus',
                                            'buttonText' => 'Update to Closed'
                                        ])
                                    @endif

                                    <button
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b"
                                        onclick="openAgentModal({{ $ticket->id }})">
                                        👤 Assign Agent
                                    </button>
                                    <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        onclick="openPriorityModal({{ $ticket->id }})">
                                        ⚡ Change Priority
                                    </button>
                                </div>
                            </div>
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

<script>
    function toggleDropdown(event, ticketId) {
        event.preventDefault();
        event.stopPropagation();

        const menu = document.getElementById('dropDownMenu-' + ticketId);

        // Close all other menus
        document.querySelectorAll('[id^="dropDownMenu-"]').forEach(m => {
            if (m.id !== 'dropDownMenu-' + ticketId) {
                m.classList.add('hidden');
            }
        });

        // Toggle current menu
        menu.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const isButton = event.target.closest('button[onclick*="toggleDropdown"]');
        if (!isButton) {
            document.querySelectorAll('[id^="dropDownMenu-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });

    function openStatusModal(ticketId) {
        alert('Change Status for Ticket ID: ' + ticketId);
        // TODO: Implement status change modal
    }

    function openAgentModal(ticketId) {
        alert('Assign Agent for Ticket ID: ' + ticketId);
        // TODO: Implement agent assignment modal
    }

    function openPriorityModal(ticketId) {
        alert('Change Priority for Ticket ID: ' + ticketId);
        // TODO: Implement priority change modal
    }
</script>
