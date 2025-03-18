<x-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Multiplication Table</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4">
            <h4 class="text-xl font-semibold">Multiplication Table</h4>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ url('multable') }}">
                <div class="mb-4">
                    <label for="number" class="block text-gray-700 text-sm font-bold mb-2">Enter Number</label>
                    <input type="number" id="number" name="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="{{ request('number', 5) }}">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Generate Table</button>
            </form>

            @php($n = request('number', 5))
            <div class="mt-6 overflow-hidden shadow ring-1 ring-black ring-opacity-5">
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach (range(1, 10) as $i)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 whitespace-nowrap text-sm font-medium text-gray-900 w-1/2">{{ $i }} * {{ $n }}</td>
                            <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-700 w-1/2">= {{ $i * $n }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
