<x-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Books Collection</h1>
        <a href="{{ route('books.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Add New Book
        </a>
    </div>

    @if(count($books) > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Added By</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($books as $book)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $book->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $book->author }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $book->published_year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $book->user->username }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $books->links() }}
        </div>
    @else
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <p class="text-gray-500">No books found. Add your first book!</p>
        </div>
    @endif
</x-layout>
