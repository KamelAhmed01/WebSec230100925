<x-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Prime Numbers</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4">
            <h4 class="text-xl font-semibold">Prime Numbers</h4>
        </div>
        <div class="p-6 flex flex-wrap gap-2">
            @foreach (range(1, 100) as $i)
                @if(isPrime($i))
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-600 text-white">{{ $i }}</span>
                @else
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-400 text-white">{{ $i }}</span>
                @endif
            @endforeach
        </div>
    </div>
</x-layout>
