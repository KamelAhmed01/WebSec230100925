<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kamel Ahmed</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

@extends('layouts.master')
@section('title', 'Home')
@section('content')
<!-- Original name input functionality -->
<script>
    function sayHello() {
        const name = document.getElementById('nameInput').value;
        if (name) {
            alert("Hello, " + name + "!");
        } else {
            alert("Please enter your name!");
        }
    }
</script>

<!-- First card with name input -->
<div class="card m-4">
    <div class="card-body">
        <div class="mb-3">
            <label for="nameInput" class="form-label">Enter your name:</label>
            <input type="text" class="form-control" id="nameInput" placeholder="Your name">
        </div>
        <button type="button" class="btn btn-primary" onclick="sayHello()">Greet Me!</button>
    </div>
</div>

<!-- New interactive buttons functionality -->
<script>
    $(document).ready(function(){
        let clickCount = 0;
        const gifUrl = 'https://media0.giphy.com/media/v1.Y2lkPTc5MGI3NjExcDIxNHZibzlzd25menJpMThvanB1ZXpucDV4OHQ1dnliajNwY2RsNSZlcD12MV9pbnRlcm5naWZfYnlfaWQmY3Q9Zw/26uf1EUQzKKGcIhJS/giphy.gif';

        $("#btn1").click(function(){
            $("#btn2").show();
        });

        $("#btn2").click(function(){
            clickCount++;

            if (clickCount < 6) {
                $("#ul1").append("<li>Hello</li>");
            }
            else if (clickCount >= 6 && clickCount <= 10) {
                // Clear previous content
                $("#ul1").empty();

                // Calculate size based on click count (increasing size from 6th to 10th click)
                const size = 100 + (clickCount - 6) * 50; // Increases by 50px each click

                // Add gif with dynamic size
                $("#ul1").html(`<img src="${gifUrl}" width="${size}" height="${size}">`);
            }
            else {
                // Reset everything after 10th click
                clickCount = 0;
                $("#ul1").empty();
            }
        });
    });
</script>

<!-- Second card with interactive buttons -->
<div class="card m-4">
    <div class="card-body">
        <button type="button" id="btn1" class="btn btn-primary">Press Me</button>
        <button type="button" id="btn2" class="btn btn-success" style="display: none;">Press Me Again</button>
        <ul id="ul1">
        </ul>
    </div>
</div>
@endsection




</body>

</html>

