<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Calculator</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body>
@extends('layouts.master')
@section('title', 'Simple Calculator')
@section('content')
    <div class="card m-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Simple Calculator</h4>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="firstNumber" class="form-label">First Number</label>
                        <input type="number" class="form-control" id="firstNumber" placeholder="Enter first number">
                    </div>
                    <div class="mb-3">
                        <label for="secondNumber" class="form-label">Second Number</label>
                        <input type="number" class="form-control" id="secondNumber" placeholder="Enter second number">
                    </div>
                    <div class="mb-3">
                        <div class="btn-group w-100" role="group">
                            <button type="button" class="btn btn-primary" onclick="calculate('add')">Add (+)</button>
                            <button type="button" class="btn btn-secondary" onclick="calculate('subtract')">Subtract (-)</button>
                            <button type="button" class="btn btn-success" onclick="calculate('multiply')">Multiply (×)</button>
                            <button type="button" class="btn btn-danger" onclick="calculate('divide')">Divide (÷)</button>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3" id="result" style="display:none;">
                        <strong>Result:</strong> <span id="resultValue"></span>
                    </div>
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
            document.getElementById('result').style.display = 'block';
        }
    </script>
@endsection
</body>
</html>

