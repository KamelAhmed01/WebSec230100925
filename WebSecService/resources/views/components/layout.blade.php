<!DOCTYPE html>
<html lang="en" class="overflow-x-hidden">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- Heroicons for modern icons -->
    <link rel="stylesheet" href="https://unpkg.com/heroicons@1.0.4/dist/heroicons.min.css">
</head>

<body class="bg-slate-100 text-slate-900 overflow-x-hidden">
    <header class="bg-slate-800 shadow-lg text-slate-100">
        <nav class="flex items-center justify-between p-5 max-w-screen-lg mx-auto">
            <div class="flex items-center space-x-4">
                <a href="{{route('home')}}" class="px-4 py-2 font-medium rounded-md transition-colors duration-200 hover:bg-slate-700 hover:text-white">Home</a>
                @auth
                <a href="{{route('users.index')}}" class="px-4 py-2 font-medium rounded-md transition-colors duration-200 hover:bg-slate-700 hover:text-white">Users</a>
                @endauth
                <a href="{{route('products_list')}}" class="px-4 py-2 font-medium rounded-md transition-colors duration-200 hover:bg-slate-700 hover:text-white">Products</a>
                <a href="{{route('books.index')}}" class="px-4 py-2 font-medium rounded-md transition-colors duration-200 hover:bg-slate-700 hover:text-white">Books</a>

                <!-- Lab Exercises Dropdown -->
                <div class="relative inline-block text-left">
                    <button id="labExercisesBtn" class="px-4 py-2 font-medium rounded-md transition-colors duration-200 hover:bg-slate-700 hover:text-white flex items-center">
                        Lab Exercises
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="labExercisesDropdown" class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                        <a href="{{ url('/first') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Interactive Demo</a>
                        <a href="{{ url('/even') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Even Numbers</a>
                        <a href="{{ url('/prime') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Prime Numbers</a>
                        <a href="{{ url('/multable') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Multiplication Table</a>
                        <a href="{{ url('/multiquiz') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Multiplication Quiz</a>
                        <a href="{{ url('/calculator') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Simple Calculator</a>
                        <a href="{{ url('/gpa-simulator') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">GPA Simulator</a>
                        <a href="{{ url('/minitest') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Market Bill</a>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <div class="relative">
                        <button id="profileBtn" class="h-10 w-10 rounded-full bg-slate-600 flex items-center justify-center overflow-hidden focus:outline-none focus:ring-2 focus:ring-slate-400 transition-transform hover:scale-105">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->username }}&background=random" alt="Profile" class="h-full w-full object-cover">
                        </button>
                        <div id="profileDropdown" class="absolute right-0 mt-3 w-64 bg-white rounded-lg shadow-xl py-2 z-50 hidden transform transition-all duration-200 border border-slate-200">
                            <!-- Friendly greeting with user's name -->
                            <div class="px-6 py-3 text-slate-800 border-b border-slate-200 bg-slate-50 rounded-t-lg">
                                <p class="text-sm text-slate-500">Welcome back</p>
                                <p class="font-bold text-lg">Hi, {{ Auth::user()->username }}!</p>
                            </div>

                            <!-- Menu items with icons -->
                            <div class="py-2">
                                <a href="{{ route('users.show', Auth::user()->id) }}" class="flex items-center px-6 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-slate-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    My Profile
                                </a>

                                <a href="{{ route('password.change') }}" class="flex items-center px-6 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-slate-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 116 0z" clip-rule="evenodd" />
                                    </svg>
                                    Change Password
                                </a>

                                <form method="POST" action="{{ route('logout') }}" class="block w-full text-left">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center px-6 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                        </svg>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{route('login')}}" class="px-4 py-2 font-medium rounded-md transition-colors duration-200 hover:bg-slate-700 hover:text-white">Login</a>
                    <a href="{{route('register')}}" class="px-4 py-2 font-medium border border-slate-600 rounded-md transition-all duration-200 hover:bg-slate-700 hover:border-slate-500 hover:text-white">Register</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="py-8 px-4 mx-auto max-w-screen-lg w-full">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{ $slot }}
    </main>

    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileBtn = document.getElementById('profileBtn');
            const profileDropdown = document.getElementById('profileDropdown');

            // Toggle dropdown when profile button is clicked
            profileBtn.addEventListener('click', function() {
                profileDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!profileBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });

            // Lab Exercises dropdown functionality
            const labExercisesBtn = document.getElementById('labExercisesBtn');
            const labExercisesDropdown = document.getElementById('labExercisesDropdown');

            labExercisesBtn.addEventListener('click', function(event) {
                event.stopPropagation();
                labExercisesDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function(event) {
                if (!labExercisesBtn.contains(event.target) && !labExercisesDropdown.contains(event.target)) {
                    labExercisesDropdown.classList.add('hidden');
                }
            });
        });
    </script>
    @endauth
</body>

</html>
