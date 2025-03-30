<x-layout>
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800 mb-4 sm:mb-0">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                    @if(auth()->user()->hasRole('employee') && !auth()->user()->hasRole('admin'))
                    Customer Management
                    @else
                    User Management
                    @endif
                </span>
            </h1>

            <div class="flex items-center space-x-2">
                <div class="bg-gray-100 py-1 px-3 rounded-full text-sm text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    @php
                        // Calculate proper count based on user role
                        $userCount = 0;
                        if(auth()->user()->hasRole('employee') && !auth()->user()->hasRole('admin')) {
                            $userCount = $users->filter(function($user) {
                                return $user->hasRole('customer');
                            })->count();
                        } else {
                            $userCount = count($filteredUsers ?? $users);
                        }
                    @endphp
                    <span>{{ $userCount }} {{ Str::plural('user', $userCount) }}</span>
                </div>

                @can('create_users')
                <a href="{{ route('users.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New User
                </a>
                @endcan
            </div>
        </div>

        <!-- Remove the notification sections that are causing duplicates -->
        <!-- Search and filter section -->
        <div class="mb-5 bg-gray-50 p-4 rounded-md">
            <form action="{{ route('users.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div class="flex-grow min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Username or email">
                </div>

                @if(!auth()->user()->hasRole('employee') || auth()->user()->hasRole('admin'))
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select id="role" name="role" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All roles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="employee" {{ request('role') === 'employee' ? 'selected' : '' }}>Employee</option>
                        <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>
                </div>
                @endif

                <div class="flex space-x-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <a href="{{ route('users.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        @if(!auth()->user()->hasRole('employee') || auth()->user()->hasRole('admin'))
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                        @endif
                        @can('manage_credits')
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Credit</th>
                        @endcan
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Joined</th>
                        <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        // Filter users based on role if the current user is an employee
                        $filteredUsers = $users;
                        if (auth()->user()->hasRole('employee') && !auth()->user()->hasRole('admin')) {
                            $filteredUsers = $users->filter(function($user) {
                                return $user->hasRole('customer');
                            });
                        }

                        // Apply search filter if provided
                        if (request('search')) {
                            $search = request('search');
                            $filteredUsers = $filteredUsers->filter(function($user) use ($search) {
                                return stripos($user->username, $search) !== false ||
                                    tripos($user->email, $search) !== false;
                            });
                        }

                        // Apply role filter if provided and user is admin
                        if (request('role') && (auth()->user()->hasRole('admin'))) {
                            $role = request('role');
                            $filteredUsers = $filteredUsers->filter(function($user) use ($role) {
                                return $user->hasRole($role);
                            });
                        }
                    @endphp

                    @forelse($filteredUsers as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                                    {{ strtoupper(substr($user->username, 0, 2)) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->username }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->email }}
                        </td>
                        @if(!auth()->user()->hasRole('employee') || auth()->user()->hasRole('admin'))
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($user->roles->count() > 0)
                                @foreach($user->roles as $role)
                                    @php
                                        $roleColors = [
                                            'admin' => 'bg-purple-100 text-purple-800',
                                            'employee' => 'bg-blue-100 text-blue-800',
                                            'customer' => 'bg-green-100 text-green-800',
                                        ];
                                        $roleColor = $roleColors[$role->name] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $roleColor }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-gray-400">No role</span>
                            @endif
                        </td>
                        @endif
                        @can('manage_credits')
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($user->hasRole('customer'))
                            <div class="flex flex-col">
                                <span class="text-base font-medium text-gray-900">${{ number_format($user->credit->amount ?? 0, 2) }}</span>
                                <form action="{{ route('users.add-credit', $user->id) }}" method="post" class="mt-1 flex items-center">
                                    @csrf
                                    <div class="flex rounded-md shadow-sm">
                                        <input
                                            name="amount"
                                            type="number"
                                            step="0.01"
                                            min="0.01"
                                            class="w-14 text-xs border border-gray-300 rounded-l-md px-1 py-0.5 focus:ring-blue-500 focus:border-blue-500"
                                            required
                                        >
                                        <button type="submit" class="inline-flex items-center px-1 py-0.5 bg-green-100 text-green-700 rounded-r-md hover:bg-green-200 border border-green-200 transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @else
                            <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        @endcan
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex justify-center gap-1">
                                @can('view_users')
                                <a href="{{ route('users.show', $user) }}"
                                   class="inline-flex items-center p-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100 transition duration-200 tooltip"
                                   title="View">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                @endcan

                                @can('edit_users')
                                <a href="{{ route('users.edit', $user) }}"
                                   class="inline-flex items-center p-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100 transition duration-200 tooltip"
                                   title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                @endcan

                                @can('delete_users')
                                @if(auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this user?')"
                                        class="inline-flex items-center p-1 bg-red-50 text-red-700 rounded hover:bg-red-100 transition duration-200 border border-red-200 tooltip"
                                        title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ (auth()->user()->hasRole('employee') && !auth()->user()->hasRole('admin')) ? '4' : '6' }}" class="px-4 py-10 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="mt-2 text-lg">No users found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $users->appends(request()->except('page'))->links() }}
    </div>

    <style>
        .tooltip {
            position: relative;
        }
        .tooltip:hover:after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            white-space: nowrap;
            z-index: 10;
            margin-bottom: 5px;
        }
    </style>
</x-layout>
