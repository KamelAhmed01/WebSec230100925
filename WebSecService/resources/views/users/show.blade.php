<x-layout>
    <div class="max-w-lg mx-auto my-10 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-blue-600 mb-6 text-center">User Details</h1>

        <div class="space-y-4">
            <div class="flex items-center justify-center mb-6">
                <div class="h-32 w-32 rounded-full bg-slate-600 flex items-center justify-center overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&background=random&size=128"
                        alt="{{ $user->username }}" class="h-full w-full object-cover">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-b border-gray-200 pb-3">
                <div class="font-semibold text-gray-700">ID</div>
                <div class="col-span-2">{{ $user->id }}</div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-b border-gray-200 pb-3">
                <div class="font-semibold text-gray-700">Username</div>
                <div class="col-span-2">{{ $user->username }}</div>
            </div>

            <div class="grid grid-cols-3 gap-4 border-b border-gray-200 pb-3">
                <div class="font-semibold text-gray-700">Email</div>
                <div class="col-span-2">{{ $user->email }}</div>
            </div>

            <!-- Credit balance displayed only for customers -->
            @if($user->hasRole('customer'))
            <div class="grid grid-cols-3 gap-4 border-b border-gray-200 pb-3">
                <div class="font-semibold text-gray-700">Credit Balance</div>
                <div class="col-span-2">
                    <span class="text-xl font-bold text-green-600">${{ number_format($user->credit->amount ?? 0, 2) }}</span>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-3 gap-4 border-b border-gray-200 pb-3">
                <div class="font-semibold text-gray-700">Role</div>
                <div class="col-span-2">
                    @if($user->roles->count() > 0)
                        @foreach($user->roles as $role)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($role->name) }}
                            </span>
                        @endforeach
                    @else
                        <span class="text-gray-500">No roles assigned</span>
                    @endif
                </div>
            </div>

            <!-- Permissions section visible only to admins -->
            @if(Auth::user()->hasRole('admin'))
            <div class="grid grid-cols-3 gap-4 border-b border-gray-200 pb-3">
                <div class="font-semibold text-gray-700">Permissions</div>
                <div class="col-span-2 flex flex-wrap gap-1">
                    @foreach($user->getAllPermissions() as $permission)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ $permission->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <div class="font-semibold text-gray-700">Member Since</div>
                <div class="text-gray-600 text-sm">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        {{ $user->created_at->diffForHumans(null, true) }}
                    </span>
                </div>
            </div>

            <div class="flex items-center justify-between pb-3">
                <div class="font-semibold text-gray-700">Last Activity</div>
                <div class="text-gray-600 text-sm">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        {{ $user->updated_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-300">
                    Back
                </a>

                <div class="flex space-x-2">
                    @can('edit_users')
                    <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300">
                        Edit
                    </a>
                    @endcan

                    @can('delete_users')
                    @if(auth()->id() !== $user->id)
                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-300">
                            Delete
                        </button>
                    </form>
                    @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-layout>
