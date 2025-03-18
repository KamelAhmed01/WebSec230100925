<x-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Product Management</h1>
        @can('add_products')
        <a href="{{ route('products_edit') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Add New Product
        </a>
        @endcan
    </div>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700">Filter Products</h2>
        </div>
        <div class="p-6">
            <form class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keywords</label>
                        <input name="keywords" type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Search..." value="{{ request()->keywords }}"/>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                        <div class="flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">$</span>
                            <input name="min_price" type="number" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-r-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Min" value="{{ request()->min_price }}"/>
                        </div>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                        <div class="flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">$</span>
                            <input name="max_price" type="number" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-r-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Max" value="{{ request()->max_price }}"/>
                        </div>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order By</label>
                        <select name="order_by" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Select field</option>
                            <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                            <option value="price" {{ request()->order_by=="price"?"selected":"" }}>Price</option>
                        </select>
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Direction</label>
                        <select name="order_direction" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>Ascending</option>
                            <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>Descending</option>
                        </select>
                    </div>
                    <div class="md:col-span-1">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-300 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(count($products) == 0)
    <div class="bg-white shadow-md rounded-lg p-8 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-gray-500 mt-4">No products found matching your criteria</p>
        <a href="{{ route('products_list') }}" class="mt-4 inline-block text-blue-600 hover:underline">Clear filters</a>
    </div>
    @else
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    @if(auth()->check() && (auth()->user()->can('edit_products') || auth()->user()->can('delete_products')))
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-16 w-16 flex-shrink-0 mr-4 bg-gray-100 rounded overflow-hidden">
                                <img src="{{asset("images/$product->photo")}}" class="h-full w-full object-contain" alt="{{$product->name}}">
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{$product->name}}</div>
                                <div class="text-sm text-gray-500">{{$product->code}}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">Model: {{$product->model}}</div>
                        <div class="text-sm text-gray-500 max-w-xs truncate">{{$product->description}}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            ${{number_format($product->price, 2)}}
                        </span>
                    </td>
                    @if(auth()->check() && (auth()->user()->can('edit_products') || auth()->user()->can('delete_products')))
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            @can('edit_products')
                            <a href="{{route('products_edit', $product->id)}}" class="inline-flex items-center px-2.5 py-1.5 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 transition duration-200" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Edit</span>
                            </a>
                            @endcan
                            @can('delete_products')
                            <form action="{{route('products_delete', $product->id)}}" method="post" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                {{ csrf_field() }}
                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-red-100 text-red-700 rounded hover:bg-red-200 transition duration-200" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Delete</span>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        @if(method_exists($products, 'links'))
            {{ $products->links() }}
        @endif
    </div>
    @endif
</x-layout>
