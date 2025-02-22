<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kamel Ahmed</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body>
    @extends('layouts.master')
    @section('title', 'Multiplication Table')
    @section('content')
    <div class="card m-4">
        <div class="card-header">Multiplication Table</div>
        <div class="card-body">
            <form method="GET" action="{{ url('multable') }}">
                <div class="mb-3">
                    <label for="number" class="form-label">Enter Number</label>
                    <input type="number" id="number" name="number" class="form-control" value="{{ request('number', 5) }}">
                </div>
                <button type="submit" class="btn btn-primary">Generate Table</button>
            </form>
            @php($n = request('number', 5))
            <table class="table mt-3">
                @foreach (range(1, 10) as $i)
                <tr>
                    <td>{{ $i }} * {{ $n }}</td>
                    <td>= {{ $i * $n }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endsection
</body>

</html>
