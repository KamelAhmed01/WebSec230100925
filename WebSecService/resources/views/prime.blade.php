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
@section('title', 'Prime Numbers')
@section('content')
 <div class="card m-4">
 <div class="card-header">Prime Numbers</div>
 <div class="card-body">
 @foreach (range(1, 100) as $i)
 @if(isPrime($i))
 <span class="badge bg-primary">{{$i}}</span>
 @else
 <span class="badge bg-secondary">{{$i}}</span>
 @endif
 @endforeach
 </div>
 </div>
@endsection

</body>

</html>
