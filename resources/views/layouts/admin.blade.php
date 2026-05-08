<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Area -->
        <div class="flex-1 flex flex-col">

            <!-- Topbar -->
            <header
                class="bg-white px-6 py-4 border-b shadow-sm flex items-center justify-between">

                <!-- Left Section -->
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        @yield('page_title', 'Admin Dashboard')
                    </h1>

                    <p class="text-sm text-gray-500">
                        Welcome back,
                        {{ auth()->user()->name ?? 'Admin' }}
                    </p>
                </div>

                <!-- Right Section -->
                <div class="flex items-center gap-6">

                    <!-- Notification -->
                    <div class="relative">

                        <!-- Bell Button -->
                        <button id="notificationButton"
                            class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-full transition">

                            <!-- Bell Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032
                                    2.032 0 0118 14.158V11a6.002
                                    6.002 0 00-4-5.659V5a2 2 0
                                    10-4 0v.341C7.67 6.165 6 8.388
                                    6 11v3.159c0 .538-.214 1.055-.595
                                    1.436L4 17h5m6 0v1a3 3 0
                                    11-6 0v-1m6 0H9" />
                            </svg>

                            <!-- Badge -->
                            @if (auth()->user()->unreadNotifications->count() > 0)

                                <span
                                    class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-[20px] h-5 px-1 text-xs font-bold text-white bg-red-500 rounded-full">

                                    {{ auth()->user()->unreadNotifications->count() }}

                                </span>

                            @endif
                        </button>

                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown"
                            class="hidden absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-xl border z-50 overflow-hidden">

                            <!-- Header -->
                            <div
                                class="px-4 py-3 border-b flex items-center justify-between">

                                <h3 class="font-semibold text-gray-700">
                                    Notifications
                                </h3>

                                @if (auth()->user()->unreadNotifications->count() > 0)

                                    <span
                                        class="text-xs text-blue-600 font-medium">

                                        {{ auth()->user()->unreadNotifications->count() }}
                                        New

                                    </span>

                                @endif
                            </div>

                            <!-- Notification List -->
                            <div class="max-h-96 overflow-y-auto">

                                @forelse(auth()->user()->unreadNotifications as $notification)

                                    <a href="{{ route('notifications.show', $notification->id) }}"
                                        class="block px-4 py-3 border-b hover:bg-gray-50 transition">

                                        <div class="flex items-start gap-3">

                                            <!-- Blue Dot -->
                                            <div
                                                class="w-2 h-2 bg-blue-500 rounded-full mt-2">
                                            </div>

                                            <!-- Content -->
                                            <div class="flex-1">

                                                <p
                                                    class="text-sm text-gray-700">

                                                    {{ $notification->data['message'] ?? 'New Notification' }}

                                                </p>

                                                <span
                                                    class="text-xs text-gray-500">

                                                    {{ $notification->created_at->diffForHumans() }}

                                                </span>

                                            </div>
                                        </div>
                                    </a>

                                @empty

                                    <div
                                        class="p-6 text-center text-sm text-gray-500">

                                        No new notifications

                                    </div>

                                @endforelse

                            </div>

                            <!-- Footer -->
                            <div class="p-3 bg-gray-50 text-center">

                                <a href="#"
                                    class="text-sm text-blue-600 hover:underline">

                                    View All Notifications

                                </a>

                            </div>

                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="text-right hidden sm:block">

                        <p class="text-sm font-semibold text-gray-700">

                            {{ auth()->user()->name ?? 'Admin' }}

                        </p>

                        <p class="text-xs text-gray-500">

                            {{ auth()->user()->email ?? 'admin@example.com' }}

                        </p>

                    </div>

                    <!-- Avatar -->
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=2563eb&color=fff"
                        alt="Avatar"
                        class="w-10 h-10 rounded-full border object-cover">

                    <!-- Logout -->
                    <form action="{{ route('logout') }}" method="POST">

                        @csrf

                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">

                            Logout

                        </button>

                    </form>

                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-6">

                <!-- Success Message -->
                @if (session('success'))

                    <div
                        class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-700 border border-green-300">

                        {{ session('success') }}

                    </div>

                @endif

                <!-- Error Message -->
                @if (session('error'))

                    <div
                        class="mb-4 px-4 py-3 rounded-lg bg-red-100 text-red-700 border border-red-300">

                        {{ session('error') }}

                    </div>

                @endif

                <!-- Validation Errors -->
                @if ($errors->any())

                    <div
                        class="mb-4 px-4 py-3 rounded-lg bg-red-100 text-red-700 border border-red-300">

                        <ul class="list-disc pl-5 space-y-1">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <!-- Page Content -->
                @yield('content')

            </main>

        </div>
    </div>

    <!-- Notification Dropdown Script -->
    <script>

        const notificationButton = document.getElementById('notificationButton');

        const notificationDropdown = document.getElementById('notificationDropdown');

        // Toggle Dropdown
        notificationButton.addEventListener('click', () => {

            notificationDropdown.classList.toggle('hidden');

        });

        // Close Dropdown Outside Click
        document.addEventListener('click', (e) => {

            if (
                !notificationButton.contains(e.target) &&
                !notificationDropdown.contains(e.target)
            ) {

                notificationDropdown.classList.add('hidden');

            }

        });

    </script>

</body>

</html>
