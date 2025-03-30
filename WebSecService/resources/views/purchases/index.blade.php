<x-layout>
    <div class="bg-gradient-to-b from-gray-50 to-gray-100 min-h-screen pb-8">
        <!-- Header -->
        <div class="bg-blue-600 text-white py-4 px-6 mb-6 shadow-md">
            <div class="container mx-auto">
                <h1 class="text-2xl font-bold">My Purchase History</h1>
            </div>
        </div>

        <div class="container mx-auto px-4">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow-sm mb-6" role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

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

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <!-- Credit information box -->
                <div class="bg-blue-50 border-b border-blue-100 p-4 flex justify-between items-center">
                    <div>
                        <h2 class="font-semibold text-blue-800">Your Current Credit</h2>
                        <p class="text-sm text-gray-600">Available balance for purchases</p>
                    </div>
                    <div class="text-2xl font-bold text-blue-700">${{ number_format(Auth::user()->credit->amount ?? 0, 2) }}</div>
                </div>

                @if($purchases->isEmpty())
                    <div class="p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-gray-500 mt-4 text-lg">You haven't made any purchases yet</p>
                        <a href="{{ route('products_list') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800 hover:underline font-medium">Browse Products</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Purchase ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Details
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($purchases as $purchase)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        #{{ $purchase->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $purchase->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($purchase->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button class="text-blue-600 hover:text-blue-800 hover:underline toggle-details" data-purchase-id="{{ $purchase->id }}">
                                            View Items
                                        </button>
                                    </td>
                                </tr>
                                <tr class="bg-gray-50 purchase-details hidden" id="purchase-{{ $purchase->id }}">
                                    <td colspan="4" class="px-6 py-4">
                                        <h4 class="font-medium text-gray-700 mb-2">Purchased Items:</h4>
                                        <div class="space-y-2">
                                            @foreach($purchase->purchaseItems as $item)
                                            <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                                                <div class="flex items-center">
                                                    @if($item->product->photo)
                                                    <img src="{{ asset('images/' . $item->product->photo) }}" class="h-10 w-10 object-contain mr-3" alt="{{ $item->product->name }}">
                                                    @endif
                                                    <div>
                                                        <div class="font-medium text-gray-800">{{ $item->product->name }}</div>
                                                        <div class="text-xs text-gray-500">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</div>
                                                    </div>
                                                </div>
                                                <div class="font-medium">${{ number_format($item->quantity * $item->price, 2) }}</div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-4 py-3 border-t border-gray-200">
                        {{ $purchases->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-details');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const purchaseId = this.dataset.purchaseId;
                    const detailsRow = document.getElementById(`purchase-${purchaseId}`);
                    detailsRow.classList.toggle('hidden');

                    if (detailsRow.classList.contains('hidden')) {
                        this.textContent = 'View Items';
                    } else {
                        this.textContent = 'Hide Items';
                    }
                });
            });
        });
    </script>
</x-layout>
