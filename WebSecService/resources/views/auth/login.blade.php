<x-layout>
    <div class="max-w-md mx-auto my-10 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-blue-600 mb-6 text-center">Login</h1>

        <form method="POST" action="/login" class="space-y-6">
            @csrf

            @if(session('login_error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('login_error') }}</span>
                </div>
            @endif

            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email Address</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="you@example.com"
                    required
                    value="{{ old('email') }}"
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter your password"
                    required
                >
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                >
                <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
            </div>

            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Login
                </button>
            </div>

            <div class="text-center text-sm text-gray-600 mt-4">
                Don't have an account?
                <a href="/register" class="text-blue-600 hover:underline">Register here</a>
            </div>
        </form>
    </div>
</x-layout>
