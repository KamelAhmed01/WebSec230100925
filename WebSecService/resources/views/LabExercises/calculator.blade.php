<x-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Simple Calculator</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4">
            <h4 class="text-xl font-semibold">Simple Calculator</h4>
        </div>
        <div class="p-6">
            <div class="max-w-md mx-auto">
                <div class="mb-4">
                    <label for="firstNumber" class="block text-gray-700 text-sm font-bold mb-2">First Number</label>
                    <input type="number" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="firstNumber" placeholder="Enter first number">
                </div>
                <div class="mb-4">
                    <label for="secondNumber" class="block text-gray-700 text-sm font-bold mb-2">Second Number</label>
                    <input type="number" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="secondNumber" placeholder="Enter second number">
                </div>
                <div class="mb-4">
                    <div class="flex flex-wrap gap-2">
                        <button type="button" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" onclick="calculate('add')">Add (+)</button>
                        <button type="button" class="px-4 py-2 bg-gray-600 text-white font-semibold rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2" onclick="calculate('subtract')">Subtract (-)</button>
                        <button type="button" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" onclick="calculate('multiply')">Multiply (×)</button>
                        <button type="button" class="px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="calculate('divide')">Divide (÷)</button>
                    </div>
                </div>
                <div class="bg-blue-100 text-blue-800 p-4 rounded-md mt-4 hidden" id="result">
                    <strong>Result:</strong> <span id="resultValue"></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculate(operation) {
            // Get the input values
            const firstNumber = parseFloat(document.getElementById('firstNumber').value);
            const secondNumber = parseFloat(document.getElementById('secondNumber').value);

            // Check if inputs are valid numbers
            if (isNaN(firstNumber) || isNaN(secondNumber)) {
                alert('Please enter valid numbers');
                return;
            }

            // Perform the calculation based on the operation
            let result;
            switch (operation) {
                case 'add':
                    result = firstNumber + secondNumber;
                    break;
                case 'subtract':
                    result = firstNumber - secondNumber;
                    break;
                case 'multiply':
                    result = firstNumber * secondNumber;
                    break;
                case 'divide':
                    if (secondNumber === 0) {
                        alert('Cannot divide by zero');
                        return;
                    }
                    result = firstNumber / secondNumber;
                    break;
                default:
                    alert('Unknown operation');
                    return;
            }

            // Display the result
            document.getElementById('resultValue').textContent = result;
            document.getElementById('result').classList.remove('hidden');
        }
    </script>
</x-layout>

