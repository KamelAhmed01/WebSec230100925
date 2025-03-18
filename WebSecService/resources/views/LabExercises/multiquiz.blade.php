<x-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Multiplication Quiz</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4">
            <h4 class="text-xl font-semibold">Multiplication Quiz</h4>
        </div>
        <div class="p-6">
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
                <div class="space-y-6">
                    @foreach ($questions as $i => $q)
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Question {{ $i + 1 }}: What is {{ $q['a'] }} * {{ $q['b'] }}?</label>
                            @if($submitted)
                                <input type="number" name="answer{{ $i }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-100" value="{{ $q['userAnswer'] }}" readonly>
                                @if($q['correct'])
                                    <div class="mt-1 text-green-600">Correct!</div>
                                @else
                                    <div class="mt-1 text-red-600">Incorrect. Correct answer: {{ $q['a'] * $q['b'] }}</div>
                                @endif
                            @else
                                <input type="number" name="answer{{ $i }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            @endif
                            <!-- Pass along the question numbers as hidden fields -->
                            <input type="hidden" name="a{{ $i }}" value="{{ $q['a'] }}">
                            <input type="hidden" name="b{{ $i }}" value="{{ $q['b'] }}">
                        </div>
                    @endforeach

                    @if(!$submitted)
                        <button type="submit" name="submitted" value="1" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Submit Answers</button>
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
                        <div class="p-4 my-4 bg-blue-100 text-blue-800 rounded-md">
                            Your score for this quiz: {{ $quizScore }}/{{ $numQuestions }}<br>
                            Your accumulated total score: {{ $totalScore }}
                        </div>
                        <a href="{{ url('multiquiz') }}" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 inline-block">Play Again</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-layout>
