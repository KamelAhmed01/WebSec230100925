<?php

if (!function_exists('isPrime')) {
    function isPrime($number)
    {
        if ($number <= 1) return false;
        $i = $number - 1;
        while ($i > 1) {
            if ($number % $i == 0) return false;
            $i--;
        }
        return true;
    }
}

function calculateGPA($grade) {
    if ($grade >= 90) return 4.0;
    if ($grade >= 85) return 3.7;
    if ($grade >= 80) return 3.3;
    if ($grade >= 75) return 3.0;
    if ($grade >= 70) return 2.7;
    if ($grade >= 65) return 2.3;
    if ($grade >= 60) return 2.0;
    return 0.0;
}

function getGradeLetter($grade) {
    if ($grade >= 90) return 'A';
    if ($grade >= 85) return 'A-';
    if ($grade >= 80) return 'B+';
    if ($grade >= 75) return 'B';
    if ($grade >= 70) return 'B-';
    if ($grade >= 65) return 'C+';
    if ($grade >= 60) return 'C';
    return 'F';
}
