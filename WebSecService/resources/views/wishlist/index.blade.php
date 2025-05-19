<x-layout>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-pink-500" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                    clip-rule="evenodd" />
            </svg>
            My Wishlist
        </h1>

        @if ($wishlist->isEmpty())
            <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                </svg>
                <p class="mt-2 text-gray-500">Your wishlist is empty.</p>
                <a href="{{ route('products_list') }}"
                    class="mt-3 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Browse Products
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($wishlist as $product)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden flex flex-col">
                        <div class="p-2 flex justify-center bg-white">
                            <img src="{{ asset("images/$product->photo") }}" alt="{{ $product->name }}"
                                class="h-40 object-contain">
                        </div>

                        <div class="p-4 flex-grow">
                            <h3 class="font-medium text-gray-900">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $product->model }}</p>
                            <div class="mt-2 flex justify-between items-center">
                                <span
                                    class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>

                                @if ($product->stock > 0)
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">
                                        {{ $product->stock }} in stock
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-0.5 rounded-full">
                                        Out of stock
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-4 border-t border-gray-200 flex space-x-2">
                            <form action="{{ route('wishlist.destroy', $product->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center justify-center bg-pink-100 text-pink-700 hover:bg-pink-200 px-3 py-1.5 rounded-md text-sm transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Remove
                                </button>
                            </form>

                            @can('make_purchases')
                                @if ($product->stock > 0)
                                    <a href="{{ route('products_list') }}?keywords={{ urlencode($product->name) }}"
                                        class="flex-1 flex items-center justify-center bg-blue-600 text-white hover:bg-blue-700 px-3 py-1.5 rounded-md text-sm transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        View Product
                                    </a>
                                @endif
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>
