<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Customer Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        @include('components.customerSidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">

            <!-- Topbar -->
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">

                <!-- Left Section -->
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        @yield('page_title', 'Customer Dashboard')
                    </h1>

                    <p class="text-sm text-gray-500">
                        Welcome back, {{ auth()->user()->name ?? 'Customer' }}
                    </p>
                </div>

                <!-- Right Section -->
                <div class="flex items-center gap-4">

                    <!-- User Info -->
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-700">
                            {{ auth()->user()->name ?? 'Customer' }}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ auth()->user()->email ?? 'customer@example.com' }}
                        </p>
                    </div>

                    <!-- Avatar -->
                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Customer') }}&background=2563eb&color=fff"
                        alt="Customer Avatar"
                        class="w-10 h-10 rounded-full border"
                    >

                    <!-- Logout -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button
                            type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
                        >
                            Logout
                        </button>
                    </form>

                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">

                <!-- Success Message -->
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-700 border border-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error Message -->
                @if (session('error'))
                    <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 text-red-700 border border-red-300">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 text-red-700 border border-red-300">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')

            </main>
        </div>
    </div>

</body>
</html>
