<x-layout>
    <div class="bg-gradient-to-b from-gray-50 to-gray-100 min-h-screen pb-8">
        <!-- Modern header with original blue color -->
        <div class="bg-blue-600 text-white py-4 px-6 mb-6 shadow-md">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Product Management</h1>
                @can('add_products')
                <a href="{{ route('products_edit') }}" class="bg-white text-blue-600 py-2 px-5 rounded-md hover:bg-gray-100 transition duration-300 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-sm">
                    Add New Product
                </a>
                @endcan
            </div>
        </div>

        <div class="container mx-auto px-4">
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded shadow-sm mb-6" role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="h-6 w-6 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Modern sidebar with clean design -->
                <div class="w-full lg:w-72 flex-shrink-0">
                    <div class="bg-white shadow-sm rounded-lg p-5 mb-4 border border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter Products
                        </h2>
                        <form class="space-y-5">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Keywords</label>
                                    <input name="keywords" type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Search..." value="{{ request()->keywords }}"/>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                                    <div class="flex items-center space-x-3 mb-2">
                                        <div class="flex rounded-md shadow-sm flex-1">
                                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">$</span>
                                            <input name="min_price" type="number" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-r-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Min" value="{{ request()->min_price }}"/>
                                        </div>
                                        <div class="flex rounded-md shadow-sm flex-1">
                                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">$</span>
                                            <input name="max_price" type="number" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-r-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Max" value="{{ request()->max_price }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                                    <select name="order_by" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Select field</option>
                                        <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                                        <option value="price" {{ request()->order_by=="price"?"selected":"" }}>Price</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Direction</label>
                                    <select name="order_direction" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>Ascending</option>
                                        <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>Descending</option>
                                    </select>
                                </div>
                                <div class="pt-2">
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-300 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Apply Filters
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Main content area -->
                <div class="flex-1">
                    @if(count($products) == 0)
                    <div class="bg-white shadow-sm rounded-lg p-8 text-center border border-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500 mt-4 text-lg">No products found matching your criteria</p>
                        <a href="{{ route('products_list') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800 hover:underline font-medium">Clear all filters</a>
                    </div>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-100 hover:shadow-md transition-shadow duration-300 flex flex-col h-full">
                            <div class="h-52 p-4 bg-white flex items-center justify-center overflow-hidden">
                                <img src="{{asset("images/$product->photo")}}" class="h-full w-full object-contain" alt="{{$product->name}}">
                            </div>
                            <div class="p-5 border-t border-gray-100 flex flex-col flex-grow">
                                <h3 class="text-base font-medium text-gray-800 line-clamp-2 h-12 mb-3">{{$product->name}}</h3>
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-xl font-semibold text-gray-900">${{number_format($product->price, 2)}}</span>
                                    <span class="bg-green-100 text-green-800 text-[10px] font-medium px-2 py-0.5 rounded-full flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        In Stock
                                    </span>
                                </div>
                                <div class="text-xs text-gray-500 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Model: {{$product->model}} | Code: {{$product->code}}
                                </div>

                                @if(auth()->check() && (auth()->user()->can('edit_products') || auth()->user()->can('delete_products')))
                                <div class="flex space-x-2 mt-auto pt-2">
                                    @can('edit_products')
                                    <a href="{{route('products_edit', $product->id)}}" class="inline-flex items-center px-3 py-2 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 transition duration-200 flex-1 justify-center" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                    @endcan
                                    @can('delete_products')
                                    <form action="{{route('products_delete', $product->id)}}" method="post" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        {{ csrf_field() }}
                                        <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200 transition duration-200 w-full justify-center" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                        @if(method_exists($products, 'links'))
                            {{ $products->links() }}
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>
