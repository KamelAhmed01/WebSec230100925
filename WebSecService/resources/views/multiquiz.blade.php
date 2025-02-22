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
    @section('title', 'Multiplication Quiz')
    @section('content')
    <div class="card m-4">
        <div class="card-header">Multiplication Quiz</div>
        <div class="card-body">
            @php
                // Check if the quiz has been submitted.
                $submitted = request()->has('submitted');
                $numQuestions = 5;
                $questions = [];
                if ($submitted) {
                    // Retrieve each saved question and user's answer.
                    for ($i = 0; $i < $numQuestions; $i++) {
                        $a = request("a{$i}");
                        $b = request("b{$i}");
                        $userAnswer = request("answer{$i}");
                        $correct = ($a * $b == $userAnswer);
                        $questions[] = ['a' => $a, 'b' => $b, 'userAnswer' => $userAnswer, 'correct' => $correct];
                    }
                } else {
                    // Generate new questions.
                    for ($i = 0; $i < $numQuestions; $i++) {
                        $a = rand(1, 10);
                        $b = rand(1, 10);
                        $questions[] = ['a' => $a, 'b' => $b];
                    }
                }
            @endphp

            <form method="GET" action="{{ url('multiquiz') }}">
                @foreach ($questions as $i => $q)
                    <div class="mb-3">
                        <label class="form-label">Question {{ $i + 1 }}: What is {{ $q['a'] }} * {{ $q['b'] }}?</label>
                        @if($submitted)
                            <input type="number" name="answer{{ $i }}" class="form-control" value="{{ $q['userAnswer'] }}" readonly>
                            @if($q['correct'])
                                <div class="text-success mt-1">Correct!</div>
                            @else
                                <div class="text-danger mt-1">Incorrect. Correct answer: {{ $q['a'] * $q['b'] }}</div>
                            @endif
                        @else
                            <input type="number" name="answer{{ $i }}" class="form-control" required>
                        @endif
                        <!-- Pass along the question numbers as hidden fields -->
                        <input type="hidden" name="a{{ $i }}" value="{{ $q['a'] }}">
                        <input type="hidden" name="b{{ $i }}" value="{{ $q['b'] }}">
                    </div>
                @endforeach

                @if(!$submitted)
                    <button type="submit" name="submitted" value="1" class="btn btn-primary">Submit Answers</button>
                @else
                    @php
                        // Calculate quiz score.
                        $quizScore = collect($questions)->filter(function($q) {
                            return isset($q['correct']) && $q['correct'];
                        })->count();
                        // Retrieve previous total score from the session.
                        $totalScore = session()->get('totalScore', 0);
                        $totalScore += $quizScore;
                        session(['totalScore' => $totalScore]);
                    @endphp
                    <div class="alert alert-info">
                        Your score for this quiz: {{ $quizScore }}/{{ $numQuestions }}<br>
                        Your accumulated total score: {{ $totalScore }}
                    </div>
                    <a href="{{ url('multiquiz') }}" class="btn btn-info">Play Again</a>
                @endif
            </form>
        </div>
    </div>
    @endsection
</body>

</html>
