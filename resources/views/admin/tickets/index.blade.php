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
                                    class="px-3 py-1 bg-red-300 text-white rounded-full text-xs font-semibold">{{ $ticket->status->label() }}</span>
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
                                            'buttonText' => 'Update to In-Progress',
                                        ])
                                    @elseif($ticket->isInProgress())
                                        @include('admin.tickets.partials.update-status-form', [
                                            'ticket' => $ticket,
                                            'status' => 'resolved',
                                            'routeName' => 'tickets.updateStatus',
                                            'buttonText' => 'Update to Resolved',
                                        ])
                                    @elseif($ticket->isResolved())
                                        @include('admin.tickets.partials.update-status-form', [
                                            'ticket' => $ticket,
                                            'status' => 'closed',
                                            'routeName' => 'tickets.updateStatus',
                                            'buttonText' => 'Update to Closed',
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

    <!-- Assign Agent Modal -->
    <div id="agentModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    👤 Assign Agent
                </h3>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('assignAgent') }}" id="agentForm" method="POST" class="px-6 py-4">
                @csrf
                @method('PATCH')
                <input type="hidden" id="agentTicketId" name="ticket_id">

                <div class="mb-4">
                    <label for="agentSelect" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Agent
                    </label>
                    <select id="agentSelect" name="agent_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Unassigned --</option>
                        @forelse($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                        @empty
                            <option disabled>No agents available</option>
                        @endforelse
                    </select>
                </div>

                <p class="text-sm text-gray-500 mb-4">
                    Select an agent to assign this ticket to them.
                </p>


                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                    <button onclick="closeAgentModal()"
                        class="px-4 py-2 text-gray-700 font-medium hover:bg-gray-100 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                        Assign
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Priority Modal -->
    <div id="priorityModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    ⚡ Change Priority
                </h3>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('changePriority') }}" id="priorityForm" method="POST" class="px-6 py-4">
                @csrf
                @method('PATCH')
                <input type="hidden" id="priorityTicketId" name="ticket_id">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Select Priority Level
                    </label>
                    <div class="space-y-2">
                        <label
                            class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="priority" value="low" class="accent-green-500">
                            <span class="ml-3">
                                <span class="font-medium">Low</span>
                                <span class="text-gray-500 text-sm block">Non-urgent issues</span>
                            </span>
                        </label>
                        <label
                            class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="priority" value="medium" class="accent-yellow-500">
                            <span class="ml-3">
                                <span class="font-medium">Medium</span>
                                <span class="text-gray-500 text-sm block">Standard issues</span>
                            </span>
                        </label>
                        <label
                            class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="priority" value="high" class="accent-red-500">
                            <span class="ml-3">
                                <span class="font-medium">High</span>
                                <span class="text-gray-500 text-sm block">Urgent issues</span>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                    <button onclick="closePriorityModal()"
                        class="px-4 py-2 text-gray-700 font-medium hover:bg-gray-100 rounded-lg transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                        Update Priority
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

<script>
    // ===== Dropdown Toggle Function =====
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

    // ===== Agent Modal Functions =====
    function openAgentModal(ticketId) {
        const modal = document.getElementById('agentModal');
        document.getElementById('agentTicketId').value = ticketId;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeAgentModal() {
        const modal = document.getElementById('agentModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // function submitAgentForm() {
    //     const ticketId = document.getElementById('agentTicketId').value;
    //     const agentId = document.getElementById('agentSelect').value;
    //     const url = `/tickets/${ticketId}/assignAgent`;

    //     fetch(url, {
    //             method: 'PATCH',
    //             headers: {
    //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
    //                 'Content-Type': 'application/x-www-form-urlencoded',
    //             },
    //             body: new URLSearchParams({
    //                 agent_id: agentId,
    //                 _method: 'PATCH'
    //             })
    //         })
    //         .then(response => {
    //             if (response.ok) {
    //                 closeAgentModal();
    //                 location.reload();
    //             } else {
    //                 alert('Error assigning agent');
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //             alert('Error assigning agent');
    //         });
    // }

    // ===== Priority Modal Functions =====
    function openPriorityModal(ticketId) {
        const modal = document.getElementById('priorityModal');
        document.getElementById('priorityTicketId').value = ticketId;
        // Reset form
        document.querySelectorAll('input[name="priority"]').forEach(r => r.checked = false);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closePriorityModal() {
        const modal = document.getElementById('priorityModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // function submitPriorityForm() {
    //     const ticketId = document.getElementById('priorityTicketId').value;
    //     const priority = document.querySelector('input[name="priority"]:checked');

    //     if (!priority) {
    //         alert('Please select a priority level');
    //         return;
    //     }

    //     const url = `/tickets/${ticketId}/assignPriority`;

    //     fetch(url, {
    //             method: 'PATCH',
    //             headers: {
    //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
    //                 'Content-Type': 'application/x-www-form-urlencoded',
    //             },
    //             body: new URLSearchParams({
    //                 priority: priority.value,
    //                 _method: 'PATCH'
    //             })
    //         })
    //         .then(response => {
    //             if (response.ok) {
    //                 closePriorityModal();
    //                 location.reload();
    //             } else {
    //                 alert('Error updating priority');
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //             alert('Error updating priority');
    //         });
    // }

    // // ===== Close Modal When Clicking Outside =====
    // document.getElementById('agentModal')?.addEventListener('click', function(e) {
    //     if (e.target === this) closeAgentModal();
    // });

    // document.getElementById('priorityModal')?.addEventListener('click', function(e) {
    //     if (e.target === this) closePriorityModal();
    // });
</script>
