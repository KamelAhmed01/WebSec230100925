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

            <div class="grid grid-cols-3 gap-4 border-b border-gray-200 pb-3">
                <div class="font-semibold text-gray-700">Created</div>
                <div class="col-span-2">{{ $user->created_at->format('F j, Y, g:i a') }}</div>
            </div>

            <div class="grid grid-cols-3 gap-4 pb-3">
                <div class="font-semibold text-gray-700">Last Updated</div>
                <div class="col-span-2">{{ $user->updated_at->format('F j, Y, g:i a') }}</div>
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-300">
                    Back to List
                </a>
                <div class="flex space-x-2">
                    <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">
                        Edit
                    </a>
                    @if(auth()->id() !== $user->id)
                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-300">
                            Delete
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>
