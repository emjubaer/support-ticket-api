        <!-- Sidebar -->
        <aside class="w-64  bg-gray-900 text-white min-h-screen p-5">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-blue-400">Support Agent</h2>
                <p class="text-sm text-gray-400 mt-1">Support Ticket System</p>
            </div>
            <nav class="px-4 space-y-2">
                <a href="{{ route('agent.dashboard') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('agent.dashboard') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-600' }} font-medium">Dashboard</a>

                <a href="{{ route('agent.tickets') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('agent.tickets') || request()->routeIs('agent.tickets.show') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-600' }}">Tickets</a>

                <a href="#"
                    class="block px-4 py-2 rounded {{ request()->routeIs('agent.profile') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-600' }}">Profile</a>
            </nav>
        </aside>
