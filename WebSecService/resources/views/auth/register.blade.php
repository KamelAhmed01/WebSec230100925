<x-layout>
    <div class="max-w-md mx-auto my-10 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-blue-600 mb-6 text-center">Create an Account</h1>

        <form method="POST" action="/register" class="space-y-4">
            @csrf

            <div>
                <label for="username" class="block text-gray-700 font-medium mb-1">Username</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter your username"
                    required
                    value="{{ old('username') }}"
                >
                @error('username')
                    <p class="text-red-500 text-sm mt-1 break-words">{{ $message }}</p>
                @enderror
            </div>

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
                    placeholder="Create a strong password"
                    required
                >
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Confirm your password"
                    required
                >
            </div>

            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Register
                </button>
            </div>

            <div class="text-center text-sm text-gray-600 mt-4">
                Already have an account?
                <a href="/login" class="text-blue-600 hover:underline">Login here</a>
            </div>
        </form>
    </div>
</x-layout>
