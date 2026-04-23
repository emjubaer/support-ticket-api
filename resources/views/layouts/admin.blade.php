<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">

        @include('components.sidebar')

        <!-- main content area -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        @yield('page_title', 'Admin Dashboard')
                    </h1>
                    <p class="text-sm text-gray-500">
                        Welcome back, {{ auth()->user()->name ?? 'Admin' }}
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-700">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ auth()->user()->email ?? 'admin@example.com' }}
                        </p>
                    </div>

                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=2563eb&color=fff"
                        alt="Admin Avatar" class="w-10 h-10 rounded-full border">

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
                <!--flash messages -->
                @if (session('success'))
                    <div class=" mb-4 px-4 rounded-lg bg-green-100 text-green-700 border border-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class=" mb-4 px-4 rounded-lg bg-red-100 text-red-700 border border-red-300">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class=" mb-4 px-4 rounded-lg bg-red-100 text-red-700 border border-red-300">
                        <ul class="list-disc pl-5 space-y-2">
                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
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
