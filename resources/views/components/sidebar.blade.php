        <!-- Sidebar -->
        <aside class="w-64  bg-gray-900 text-white min-h-screen p-5">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-blue-400">Support Admin</h2>
                <p class="text-sm text-gray-400 mt-1">Support Ticket System</p>
            </div>
            <nav class="px-4 space-y-2">
                <a href="{{ route('dashboard') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-100' }} font-medium">Dashboard</a>
                <a href="{{ route('tickets.index') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('tickets.index') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-100' }}">Tickets</a>
                <a href="{{ route('agents.index') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('agents.index') || request()->routeIs('agent.show') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-100' }}">Agents</a>
                <a href="{{ route('customers.index') }}"
                    class="block px-4 py-2 rounded {{ request()->routeIs('customers.index') ? 'bg-blue-50 text-blue-600' : 'hover:bg-gray-100' }}">Customers</a>
            </nav>
        </aside>
