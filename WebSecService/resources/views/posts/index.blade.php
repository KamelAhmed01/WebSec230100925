<x-layout>
    @auth
        <div class="user-dashboard p-4 bg-white rounded shadow-sm mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Welcome {{ Auth::user()->name }}!</h1>
            <p class="text-gray-600 mt-2">This is your personalized dashboard.</p>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-50 p-3 rounded border border-blue-200">
                    <h3 class="font-semibold text-blue-800">Your Posts</h3>
                    <p class="text-sm">Manage and create content</p>
                    <a href="#" class="text-blue-600 hover:underline text-sm">View all posts →</a>
                </div>
                <div class="bg-green-50 p-3 rounded border border-green-200">
                    <h3 class="font-semibold text-green-800">Account Settings</h3>
                    <p class="text-sm">Update your profile information</p>
                    <a href="#" class="text-green-600 hover:underline text-sm">Edit profile →</a>
                </div>
            </div>

            <div class="mt-4 text-sm text-gray-600">
                <p>Last login: Today at 10:30 AM</p>
            </div>
        </div>
    @endauth

    @guest
        <div class="guest-welcome p-4 bg-white rounded shadow-sm text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome to Our Platform</h1>
            <p class="text-gray-600 mb-6">Join our community to access exclusive content and features.</p>

            <div class="flex justify-center space-x-4">
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Log in
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">
                    Register
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 text-left">
                <div class="p-3">
                    <h3 class="font-semibold">Connect</h3>
                    <p class="text-sm text-gray-600">Join discussions with like-minded people</p>
                </div>
                <div class="p-3">
                    <h3 class="font-semibold">Share</h3>
                    <p class="text-sm text-gray-600">Contribute your thoughts and ideas</p>
                </div>
                <div class="p-3">
                    <h3 class="font-semibold">Discover</h3>
                    <p class="text-sm text-gray-600">Explore content from our community</p>
                </div>
            </div>
        </div>
    @endguest
</x-layout>


