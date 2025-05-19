<x-layout>
    @php
        // Calculate the maximum price from all products
        $maxPrice = 0;
        foreach ($products as $product) {
            if ($product->price > $maxPrice) {
                $maxPrice = $product->price;
            }
        }
        // Set a minimum reasonable value if no products or all prices are 0
        $maxPrice = $maxPrice ?: 1000;
    @endphp

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800 mb-4 sm:mb-0">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-blue-600" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                            clip-rule="evenodd" />
                    </svg>
                    Product Management
                </span>
            </h1>

            <div class="flex items-center space-x-2">
                @if (auth()->check() && auth()->user()->hasRole('customer'))
                    <div class="bg-blue-50 py-1.5 px-3 rounded-full text-sm font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-blue-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                            <path fill-rule="evenodd"
                                d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-blue-800">Your Balance: <span
                                class="font-bold">${{ number_format(auth()->user()->credit->amount ?? 0, 2) }}</span></span>
                    </div>
                @endif

                <div class="bg-gray-100 py-1 px-3 rounded-full text-sm text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-600" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ count($products) }} {{ Str::plural('product', count($products)) }}</span>
                </div>

                @can('add_products')
                    <a href="{{ route('products_edit') }}"
                        class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Add New Product
                    </a>
                @endcan
            </div>
        </div>

        <!-- Search and filter section -->
        <div class="mb-5 bg-gray-50 p-4 rounded-md">
            <form action="{{ route('products_list') }}" method="GET" class="space-y-6">
                <!-- Search bar with animated focus effect -->
                <div class="w-full">
                    <label for="keywords" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative">
                        <input type="text" id="keywords" name="keywords" value="{{ request('keywords') }}"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border-0 bg-white/80 shadow-sm focus:ring-2 focus:ring-blue-500 transition-all duration-300"
                            placeholder="Product name or model">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Modern filter controls in a single row -->
                <div class="w-full">
                    <div class="flex flex-wrap items-end gap-4">
                        <!-- Price range slider section -->
                        <div class="flex-grow min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                            <div class="flex items-center gap-2">
                                <!-- Price display label - Min -->
                                <div
                                    class="flex items-center bg-white px-2 py-1 rounded-full shadow-sm border border-gray-200">
                                    <span class="text-gray-500 mr-1">$</span>
                                    <input type="number" id="min_price" name="min_price"
                                        value="{{ request('min_price') ?? 0 }}"
                                        class="w-12 border-0 p-0 text-center focus:ring-0" placeholder="Min">
                                </div>

                                <!-- Slider container - reduced width -->
                                <div class="flex-grow px-1">
                                    <div class="relative h-8">
                                        <!-- Track -->
                                        <div class="absolute top-3 h-1 w-full bg-gray-200 rounded-full"></div>

                                        <!-- Active track -->
                                        <div class="absolute top-3 h-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full"
                                            id="price-range-track" style="left: 0%; right: 0%;"></div>

                                        <!-- Min handle -->
                                        <div class="absolute top-1.5 w-4 h-4 bg-white border border-blue-500 rounded-full shadow-md -ml-2 flex items-center justify-center cursor-pointer hover:scale-110 transition-transform"
                                            id="min-handle" style="left: 0%">
                                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
                                        </div>

                                        <!-- Max handle -->
                                        <div class="absolute top-1.5 w-4 h-4 bg-white border border-blue-500 rounded-full shadow-md -ml-2 flex items-center justify-center cursor-pointer hover:scale-110 transition-transform"
                                            id="max-handle" style="left: 100%">
                                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price display label - Max -->
                                <div
                                    class="flex items-center bg-white px-2 py-1 rounded-full shadow-sm border border-gray-200">
                                    <span class="text-gray-500 mr-1">$</span>
                                    <input type="number" id="max_price" name="max_price"
                                        value="{{ request('max_price') ?? $maxPrice }}"
                                        class="w-12 border-0 p-0 text-center focus:ring-0" placeholder="Max">
                                </div>
                            </div>
                        </div>

                        <!-- Sort field options -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                            <div class="inline-flex rounded-md shadow-sm" role="group" aria-label="Sort options">
                                <input type="hidden" name="order_by" id="order_by"
                                    value="{{ request('order_by', 'name') }}">
                                <button type="button" data-sort="name"
                                    class="sort-btn px-3 py-2 text-sm font-medium rounded-l-lg border {{ request('order_by', 'name') == 'name' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                                    Name
                                </button>
                                <button type="button" data-sort="price"
                                    class="sort-btn px-3 py-2 text-sm font-medium rounded-r-lg border-t border-b border-r {{ request('order_by') == 'price' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                                    Price
                                </button>
                            </div>
                        </div>

                        <!-- Direction toggle -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Direction</label>
                            <div class="relative">
                                <input type="hidden" name="order_direction" id="order_direction"
                                    value="{{ request('order_direction', 'ASC') }}">
                                <button type="button" id="direction-toggle"
                                    class="inline-flex items-center gap-2 px-3 py-2 border rounded-md bg-white shadow-sm hover:bg-gray-50 transition-all duration-200">
                                    <div id="direction-icon"
                                        class="transition-transform duration-300 {{ request('order_direction', 'ASC') == 'DESC' ? 'rotate-180' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.415L11 9.586V6z" />
                                        </svg>
                                    </div>
                                    <span
                                        id="direction-text">{{ request('order_direction', 'ASC') == 'ASC' ? 'Ascending' : 'Descending' }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Apply and reset buttons -->
                        <div class="ml-auto">
                            <div class="flex space-x-2">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Apply
                                </button>

                                <a href="{{ route('products_list') }}"
                                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition-colors flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Status message display -->
            @if (session('error'))
                <div class="mt-4 bg-red-50 border-l-4 border-red-500 p-4 relative" role="alert" id="error-message">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                {{ session('error') }}
                                @if (session('insufficientCredit'))
                                    <span class="block font-medium mt-1">
                                        Required: ${{ number_format(session('requiredAmount'), 2) }} |
                                        Your balance: ${{ number_format(auth()->user()->credit->amount ?? 0, 2) }} |
                                        Shortfall: ${{ number_format(session('shortfall'), 2) }}
                                    </span>
                                @endif
                            </p>
                        </div>
                        <button type="button" onclick="document.getElementById('error-message').style.display='none'"
                            class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="mt-4 bg-green-50 border-l-4 border-green-500 p-4 relative" role="alert"
                    id="success-message">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                        <button type="button"
                            onclick="document.getElementById('success-message').style.display='none'"
                            class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Keep everything below this line as is -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        @if (count($products) == 0)
            <div class="bg-white shadow-sm rounded-lg p-8 text-center border border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-500 mt-4 text-lg">No products found matching your criteria</p>
                <a href="{{ route('products_list') }}"
                    class="mt-4 inline-block text-blue-600 hover:text-blue-800 hover:underline font-medium">Clear
                    all filters</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    <div
                        class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200 hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                        <!-- Square aspect ratio image container -->
                        <div
                            class="aspect-square bg-white flex items-center justify-center overflow-hidden p-3 border-b border-gray-100">
                            <img src="{{ asset("images/$product->photo") }}" class="h-full w-full object-contain"
                                alt="{{ $product->name }}">
                        </div>

                        <div class="p-4 flex flex-col flex-grow">
                            <!-- Product name with fixed height -->
                            <h3 class="text-base font-medium text-gray-800 line-clamp-2 mb-2 min-h-[40px]">
                                {{ $product->name }}
                            </h3>

                            <!-- Clean info row with smaller text -->
                            <div class="text-xs text-gray-500 mb-2">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <span class="truncate">{{ $product->model }} | {{ $product->code }}</span>
                                </div>
                            </div>

                            <!-- Price and stock in a clean row -->
                            <div class="flex justify-between items-center mb-3">
                                <span
                                    class="text-lg font-semibold text-gray-900">${{ number_format($product->price, 2) }}</span>

                                <!-- Stock indicators -->
                                @can('make_purchases')
                                    @if ($product->stock > 10)
                                        <span
                                            class="bg-green-100 text-green-800 text-xs px-1.5 py-0.5 rounded-full whitespace-nowrap">{{ $product->stock }}
                                            in stock</span>
                                    @elseif($product->stock > 0)
                                        <span
                                            class="bg-red-100 text-red-800 text-xs px-1.5 py-0.5 rounded-full whitespace-nowrap">🔥
                                            {{ $product->stock }} left!</span>
                                    @elseif(!auth()->user()->hasRole('customer'))
                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs px-1.5 py-0.5 rounded-full whitespace-nowrap">Out
                                            of stock</span>
                                    @endif
                                @else
                                    @if ($product->stock > 0)
                                        <span
                                            class="bg-green-100 text-green-800 text-xs px-1.5 py-0.5 rounded-full whitespace-nowrap">{{ $product->stock }}
                                            in stock</span>
                                    @else
                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs px-1.5 py-0.5 rounded-full whitespace-nowrap">Out
                                            of stock</span>
                                    @endif
                                @endcan
                            </div>

                            <!-- Purchase section -->
                            @can('make_purchases')
                                @if ($product->stock > 0)
                                    <div class="mt-auto pt-3 border-t border-gray-100">
                                        <form action="{{ route('purchases.store', $product->id) }}" method="post"
                                            class="purchase-form" data-price="{{ $product->price }}"
                                            data-credit="{{ auth()->user()->credit->amount ?? 0 }}">
                                            @csrf
                                            <div class="flex items-center mb-2">
                                                <label for="quantity-{{ $product->id }}"
                                                    class="text-xs text-gray-600 mr-2">Qty:</label>
                                                <input type="number" id="quantity-{{ $product->id }}" name="quantity"
                                                    value="1" min="1" max="{{ $product->stock }}"
                                                    class="w-16 border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 quantity-input">
                                                <div class="ml-auto text-xs font-medium">
                                                    <span
                                                        class="total-price">${{ number_format($product->price, 2) }}</span>
                                                </div>
                                            </div>

                                            <div class="credit-warning hidden mb-2 text-xs text-red-600 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span>Insufficient credit. You need <span class="shortfall"></span>
                                                    more.</span>
                                            </div>

                                            <button type="submit"
                                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-1.5 px-4 rounded transition duration-300 flex items-center justify-center text-sm purchase-button">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Purchase
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="mt-auto pt-3 border-t border-gray-100">
                                        <div
                                            class="bg-red-50 text-red-700 text-xs py-1.5 px-2 rounded flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Out of Stock
                                        </div>
                                    </div>
                                @endif
                            @endcan

                            <!-- Add wishlist button after the purchase section but before employee controls -->
                            @auth
                                @can('manage_wishlist')
                                    <div class="mt-2">
                                        @if (auth()->user()->wishlist->contains($product->id))
                                            <form action="{{ route('wishlist.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-full flex items-center justify-center bg-pink-100 text-pink-700 hover:bg-pink-200 px-3 py-1.5 rounded-md text-sm transition duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Remove from Wishlist
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('wishlist.store', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full flex items-center justify-center border border-pink-300 text-pink-600 hover:bg-pink-50 px-3 py-1.5 rounded-md text-sm transition duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                                                    </svg>
                                                    Add to Wishlist
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endcan
                            @endauth

                            <!-- employee controls -->
                            @if (auth()->check() && (auth()->user()->can('edit_products') || auth()->user()->can('delete_products')))
                                <div class="flex space-x-1 mt-3 pt-3 border-t border-gray-100">
                                    @can('edit_products')
                                        <a href="{{ route('products_edit', $product->id) }}"
                                            class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100 transition duration-200 flex-1 justify-center text-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            <span>Edit</span>
                                        </a>
                                    @endcan
                                    @can('delete_products')
                                        <form action="{{ route('products_delete', $product->id) }}" method="post"
                                            class="flex-1"
                                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            {{ csrf_field() }}
                                            <button type="submit"
                                                class="inline-flex items-center px-2 py-1 bg-red-50 text-red-700 rounded hover:bg-red-100 transition duration-200 w-full justify-center text-xs">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                @if (method_exists($products, 'links'))
                    {{ $products->links() }}
                @endif
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Price Range Slider functionality
            const minHandle = document.getElementById('min-handle');
            const maxHandle = document.getElementById('max-handle');
            const rangeTrack = document.getElementById('price-range-track');
            const minInput = document.getElementById('min_price');
            const maxInput = document.getElementById('max_price');
            const sliderTrack = minHandle.parentElement;

            // Set initial positions with dynamic max price
            const maxPossiblePrice = {{ $maxPrice }}; // Using the PHP value calculated above
            let minPrice = parseInt(minInput.value) || 0;
            let maxPrice = parseInt(maxInput.value) || maxPossiblePrice;

            // Force the max value to be maxPossiblePrice if not set
            if (maxInput.value == "" || !maxInput.value) {
                maxPrice = maxPossiblePrice;
                maxInput.value = maxPossiblePrice;
            }

            // Initialize state for drag operations
            let isDraggingMin = false;
            let isDraggingMax = false;

            // Get track dimensions
            const getTrackBounds = () => sliderTrack.getBoundingClientRect();

            // Update visual positions
            function updateHandlePositions() {
                const minPercent = Math.max(0, Math.min(100, (minPrice / maxPossiblePrice) * 100));
                const maxPercent = Math.max(0, Math.min(100, (maxPrice / maxPossiblePrice) * 100));

                minHandle.style.left = `${minPercent}%`;
                maxHandle.style.left = `${maxPercent}%`;
                rangeTrack.style.left = `${minPercent}%`;
                rangeTrack.style.right = `${100 - maxPercent}%`;

                minInput.value = minPrice;
                maxInput.value = maxPrice;
            }

            // Calculate price based on position
            function calculatePrice(clientX) {
                const bounds = getTrackBounds();
                const position = clientX - bounds.left;
                const percent = Math.max(0, Math.min(1, position / bounds.width));
                return Math.round(percent * maxPossiblePrice);
            }

            // Handle events for min slider
            minHandle.addEventListener('mousedown', (e) => {
                e.preventDefault();
                isDraggingMin = true;
            });

            // Handle events for max slider
            maxHandle.addEventListener('mousedown', (e) => {
                e.preventDefault();
                isDraggingMax = true;
            });

            // Handle mouse movement
            document.addEventListener('mousemove', (e) => {
                if (!isDraggingMin && !isDraggingMax) return;

                const price = calculatePrice(e.clientX);

                if (isDraggingMin) {
                    minPrice = Math.min(price, maxPrice - 1);
                } else {
                    maxPrice = Math.max(price, minPrice + 1);
                }

                updateHandlePositions();
            });

            // Handle mouse up
            document.addEventListener('mouseup', () => {
                isDraggingMin = false;
                isDraggingMax = false;
            });

            // Touch support for mobile
            minHandle.addEventListener('touchstart', (e) => {
                e.preventDefault();
                isDraggingMin = true;
            });

            maxHandle.addEventListener('touchstart', (e) => {
                e.preventDefault();
                isDraggingMax = true;
            });

            document.addEventListener('touchmove', (e) => {
                if (!isDraggingMin && !isDraggingMax) return;

                const touch = e.touches[0];
                const price = calculatePrice(touch.clientX);

                if (isDraggingMin) {
                    minPrice = Math.min(price, maxPrice - 1);
                } else {
                    maxPrice = Math.max(price, minPrice + 1);
                }

                updateHandlePositions();
            });

            document.addEventListener('touchend', () => {
                isDraggingMin = false;
                isDraggingMax = false;
            });

            // Handle input changes
            minInput.addEventListener('change', function() {
                minPrice = Math.min(parseInt(this.value) || 0, maxPrice - 1);
                this.value = minPrice;
                updateHandlePositions();
            });

            maxInput.addEventListener('change', function() {
                maxPrice = Math.max(parseInt(this.value) || 0, minPrice + 1);
                this.value = maxPrice;
                updateHandlePositions();
            });

            // Track click functionality
            sliderTrack.addEventListener('click', (e) => {
                if (e.target === minHandle || e.target === maxHandle) return;

                const price = calculatePrice(e.clientX);
                // Determine which handle to move (closest one)
                if (Math.abs(price - minPrice) < Math.abs(price - maxPrice)) {
                    minPrice = Math.min(price, maxPrice - 1);
                } else {
                    maxPrice = Math.max(price, minPrice + 1);
                }

                updateHandlePositions();
            });

            // Initial update
            updateHandlePositions();

            // Sort buttons functionality (keep existing code)
            const sortButtons = document.querySelectorAll('.sort-btn');
            const orderByInput = document.getElementById('order_by');

            sortButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const sortValue = this.dataset.sort;
                    orderByInput.value = sortValue;

                    // Update UI
                    sortButtons.forEach(btn => {
                        if (btn.dataset.sort === sortValue) {
                            btn.classList.add('bg-blue-600', 'text-white',
                                'border-blue-600');
                            btn.classList.remove('bg-white', 'text-gray-700',
                                'border-gray-300', 'hover:bg-gray-50');
                        } else {
                            btn.classList.remove('bg-blue-600', 'text-white',
                                'border-blue-600');
                            btn.classList.add('bg-white', 'text-gray-700',
                                'border-gray-300', 'hover:bg-gray-50');
                        }
                    });
                });
            });

            // Direction toggle functionality (keep existing code)
            const directionToggle = document.getElementById('direction-toggle');
            const directionInput = document.getElementById('order_direction');
            const directionIcon = document.getElementById('direction-icon');
            const directionText = document.getElementById('direction-text');

            directionToggle.addEventListener('click', function() {
                if (directionInput.value === 'ASC') {
                    directionInput.value = 'DESC';
                    directionText.textContent = 'Descending';
                    directionIcon.classList.add('rotate-180');
                } else {
                    directionInput.value = 'ASC';
                    directionText.textContent = 'Ascending';
                    directionIcon.classList.remove('rotate-180');
                }
            });

            // Initialize all purchase forms with credit validation
            const purchaseForms = document.querySelectorAll('.purchase-form');

            purchaseForms.forEach(form => {
                const quantityInput = form.querySelector('.quantity-input');
                const totalPriceEl = form.querySelector('.total-price');
                const creditWarning = form.querySelector('.credit-warning');
                const shortfallEl = form.querySelector('.shortfall');
                const purchaseButton = form.querySelector('.purchase-button');

                const productPrice = parseFloat(form.dataset.price);
                const userCredit = parseFloat(form.dataset.credit);

                function updateTotals() {
                    const quantity = parseInt(quantityInput.value);
                    const totalPrice = productPrice * quantity;

                    // Update displayed price
                    totalPriceEl.textContent = '$' + totalPrice.toFixed(2);

                    // Check if user has enough credit
                    if (totalPrice > userCredit) {
                        const shortfall = (totalPrice - userCredit).toFixed(2);
                        shortfallEl.textContent = '$' + shortfall;
                        creditWarning.classList.remove('hidden');
                        purchaseButton.classList.add('bg-gray-400', 'hover:bg-gray-500');
                        purchaseButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                    } else {
                        creditWarning.classList.add('hidden');
                        purchaseButton.classList.remove('bg-gray-400', 'hover:bg-gray-500');
                        purchaseButton.classList.add('bg-green-600', 'hover:bg-green-700');
                    }
                }

                // Initialize and add event listeners
                updateTotals();
                quantityInput.addEventListener('change', updateTotals);
                quantityInput.addEventListener('input', updateTotals);
            });

            // Auto-hide messages after 5 seconds
            const messages = document.querySelectorAll('#error-message, #success-message');
            messages.forEach(message => {
                setTimeout(() => {
                    message.style.transition = 'opacity 1s ease-out';
                    message.style.opacity = 0;

                    setTimeout(() => {
                        message.style.display = 'none';
                    }, 1000);
                }, 5000);
            });

            // Existing JavaScript for the slider, etc.
            // ...
        });
    </script>
</x-layout>
