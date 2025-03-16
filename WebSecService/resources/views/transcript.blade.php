<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Transcript</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body>
@extends('layouts.master')
@section('title', 'Student Transcript')
@section('content')
    <div class="card m-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Student Academic Transcript</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>CH</th>
                        <th>Grade</th>
                        <th>Letter</th>
                        <th>GPA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td>{{ $course['code'] }}</td>
                            <td>{{ $course['name'] }}</td>
                            <td>{{ $course['ch'] }}</td>
                            <td>{{ $course['grade'] }}/100</td>
                            <td>{{ $course['letter'] }}</td>
                            <td>{{ number_format($course['gpa'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="alert alert-info mt-3">
                <strong>Cumulative GPA (CGPA):</strong> {{ number_format($cgpa, 2) }}
                ({{ getGradeLetter($cgpa * 25) }})
            </div>
        </div>
    </div>
@endsection
</body>
</html>

