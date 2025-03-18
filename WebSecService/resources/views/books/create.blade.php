<x-layout>
    <div class="max-w-md mx-auto my-10 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-blue-600 mb-6 text-center">Add New Book</h1>

        <form method="POST" action="{{ route('books.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="title" class="block text-gray-700 font-medium mb-1">Book Title</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    value="{{ old('title') }}"
                    required
                >
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="author" class="block text-gray-700 font-medium mb-1">Author</label>
                <input
                    type="text"
                    name="author"
                    id="author"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    value="{{ old('author') }}"
                    required
                >
                @error('author')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="published_year" class="block text-gray-700 font-medium mb-1">Published Year</label>
                <input
                    type="number"
                    name="published_year"
                    id="published_year"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    value="{{ old('published_year') }}"
                    min="1000"
                    max="{{ date('Y') }}"
                    placeholder="YYYY"
                    required
                >
                @error('published_year')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between pt-2">
                <a href="{{ route('books.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-300">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Add Book
                </button>
            </div>
        </form>
    </div>
</x-layout>
