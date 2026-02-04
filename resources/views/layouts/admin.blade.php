<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg">
        <div class="p-6 text-xl font-bold">Support Admin</div>
        <nav class="px-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded bg-blue-50 text-blue-600 font-medium">Dashboard</a>
            <a href="/admin/tickets" class="block px-4 py-2 rounded hover:bg-gray-100">Tickets</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-100">Agents</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-100">Customers</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <!-- Top Bar -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">@yield('page_title')</h1>
            <div class="flex items-center gap-3">
                <span class="text-sm">{{ auth()->user()->name ?? 'Admin' }}</span>
                <img src="https://ui-avatars.com/api/?name=Admin" class="w-8 h-8 rounded-full">
            </div>
        </div>

        @yield('content')
    </main>

</div>

</body>
</html>
