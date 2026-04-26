<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login | Support Ticketing</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">

    <div class="w-full max-w-md">

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-700 border border-green-300 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 text-red-700 border border-red-300 text-center">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 text-red-700 border border-red-300">
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">

            <!-- Title -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Support Ticketing</h1>
                <p class="text-sm text-gray-500 mt-1">Sign in to your dashboard</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                </div>

                <!-- Remember -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" class="rounded border-gray-300">
                        <span class="text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-blue-600 hover:underline">Forgot password?</a>
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-medium transition">
                    Login
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="px-3 text-xs text-gray-400">OR</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <!-- Register -->
            <div class="text-center text-sm">
                <p class="text-gray-600">
                    Not registered?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">
                        Sign up
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-500 mt-6">
            © 2026 Support Ticketing System
        </p>
    </div>

</body>

</html>
