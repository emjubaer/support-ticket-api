@extends('layouts.admin')

@section('title', 'Agents')
@section('page_title', 'Agents')

@section('content')
    <div class="bg-white rounded-xl shadow">
        <!-- Header -->
        <div class="p-5 border-b flex justify-between items-center">
            <h2 class="font-semibold text-lg">Support Agents</h2>
            <a href="#" onclick="openCreateAgentModal()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">
                Add New Agent
            </a>
        </div>

        <!-- Agents Table -->
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Agent ID</th>
                    <th class="p-3 text-left">Agent</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-center">Assigned Tickets</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($agents as $agent)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $loop->iteration }}</td>

                        <td class="p-3">{{ $agent->id }}</td>

                        <!-- Agent Info -->
                        <td class="p-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold">
                                    {{ strtoupper(substr($agent->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $agent->name }}</p>
                                    <p class="text-xs text-gray-500">Support Agent</p>
                                </div>
                            </div>
                        </td>

                        <td class="p-3 text-gray-600">
                            {{ $agent->email }}
                        </td>

                        <!-- Assigned Tickets -->
                        <td class="p-3 text-center">
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                {{ $agent->assigned_tickets_count }} Tickets
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="p-3 text-center">
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                Active
                            </span>
                        </td>

                        <!-- Action -->
                        <td class="p-3 text-center">
                            <a href="{{ route('agent.show', $agent) }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">
                            No agents found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <!-- Create Agent Modal -->
    <div id="createAgentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">

            <!-- Header -->
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">
                    👤 Create New Agent
                </h3>
                <button onclick="closeCreateAgentModal()" class="text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>

            <!-- Body -->
            <form action="{{ route('register.post') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Agent Name</label>
                    <input type="text" name="name" required
                        class="w-full border rounded-lg p-2 text-sm focus:ring-blue-200 focus:border-blue-500"
                        placeholder="Enter agent name">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required
                        class="w-full border rounded-lg p-2 text-sm focus:ring-blue-200 focus:border-blue-500"
                        placeholder="agent@email.com">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full border rounded-lg p-2 text-sm focus:ring-blue-200 focus:border-blue-500"
                        placeholder="********">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Role</label>
                    <select name="role"
                        class="w-full border rounded-lg p-2 text-sm focus:ring-blue-200 focus:border-blue-500">
                        <option value="agent">Agent</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" onclick="closeCreateAgentModal()"
                        class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        Create Agent
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection


<script>
    function openCreateAgentModal() {
        document.getElementById('createAgentModal').classList.remove('hidden');
    }

    function closeCreateAgentModal() {
        document.getElementById('createAgentModal').classList.add('hidden');
    }

</script>
