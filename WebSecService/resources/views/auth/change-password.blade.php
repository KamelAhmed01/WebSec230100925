<x-layout>
    <div class="max-w-md mx-auto my-10 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-blue-600 mb-6 text-center">Change Password</h1>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf

            <div>
                <label for="current_password" class="block text-gray-700 font-medium mb-1">Current Password</label>
                <input
                    type="password"
                    name="current_password"
                    id="current_password"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
                @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">New Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">Confirm New Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
            </div>

            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Update Password
                </button>
            </div>

            <div class="text-center mt-4">
                <a href="javascript:history.back()" class="text-blue-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</x-layout>
