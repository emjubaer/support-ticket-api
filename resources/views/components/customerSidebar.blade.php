<aside class="w-64 bg-gray-900/90 backdrop-blur-lg text-white min-h-screen p-5 border-r border-gray-800">

    <div class="mb-8 text-center">
        <h2 class="text-2xl font-extrabold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
            Support Panel
        </h2>
        <p class="text-xs text-gray-400 mt-1">Ticket System</p>
    </div>

    <nav class="space-y-2">

        <a href="{{ route('customer.dashboard') }}"
           class="flex items-center gap-3 px-4 py-2 rounded transition-all duration-300
           {{ request()->routeIs('customer.dashboard')
           ? 'bg-gradient-to-r from-blue-500 to-indigo-600 shadow-md'
           : 'hover:bg-gray-700 hover:pl-6' }}">

            <span>🏠</span>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('customer.ticket') }}"
           class="flex items-center gap-3 px-4 py-2 rounded transition-all duration-300
           {{ request()->routeIs('customer.ticket') || request()->routeIs('customer.ticket.show')
           ? 'bg-gradient-to-r from-blue-500 to-indigo-600 shadow-md'
           : 'hover:bg-gray-700 hover:pl-6' }}">

            <span>🎫</span>
            <span>My Tickets</span>
        </a>

        <a href="#"
           class="flex items-center gap-3 px-4 py-2 rounded transition-all duration-300 hover:bg-gray-700 hover:pl-6">

            <span>👤</span>
            <span>Profile</span>
        </a>

    </nav>
</aside>
