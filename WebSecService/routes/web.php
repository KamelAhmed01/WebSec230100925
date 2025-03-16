<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\ProductsController;

Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::post('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');


Route::get('/', function () {
    return view('welcome');
});
Route::get('/even', function () {
    return view('even');
});
Route::get('/prime', function () {
    return view('prime');
});
Route::get('/multable/{number?}', function ($number = null) {
    $j = $number ?? 2;
    return view('multable', compact('j'));
});
Route::get('/multiquiz', function () {
    return view('multiquiz');
});
Route::get('/minitest', function () {
    $items = [
        [
            'name' => 'Milk',
            'quantity' => 2,
            'price' => 3.50
        ],
        [
            'name' => 'Bread',
            'quantity' => 1,
            'price' => 2.00
        ],
        [
            'name' => 'Butter',
            'quantity' => 1,
            'price' => 1.00
        ]
    ];


    $total = array_reduce($items, function($carry, $item) {
        return $carry + ($item['quantity'] * $item['price']);
    }, 0);

    return view('minitest', compact('items', 'total'));
});

Route::get('/transcript', function () {
    $courses = [
        [
            'code' => 'CS101',
            'name' => 'Introduction to Programming',
            'ch' => 3,
            'grade' => 85
        ],
        [
            'code' => 'CS102',
            'name' => 'OOP',
            'ch' => 3,
            'grade' => 92
        ],
        [
            'code' => 'MATH201',
            'name' => 'Math I',
            'ch' => 4,
            'grade' => 88
        ],
        [
            'code' => 'ENG101',
            'name' => 'engeneering',
            'ch' => 3,
            'grade' => 78
        ]
    ];

    $courses = array_map(function($course) {
        $course['gpa'] = calculateGPA($course['grade']);
        $course['letter'] = getGradeLetter($course['grade']);
        return $course;
    }, $courses);

    $totalCH = array_sum(array_column($courses, 'ch'));
    $totalGPAPoints = array_sum(array_map(function($course) {
        return $course['ch'] * $course['gpa'];
    }, $courses));

    $cgpa = $totalGPAPoints / $totalCH;

    return view('transcript', compact('courses', 'cgpa'));
});

Route::get('/calculator', function () {
    return view('calculator');
})->name('calculator');

Route::get('/gpa-simulator', function () {
    // Course catalog with code, title and credit hours
    $courseCatalog = [
        [
            'code' => 'CS101',
            'title' => 'Introduction to Programming',
            'credit_hours' => 3
        ],
        [
            'code' => 'CS102',
            'title' => 'Object-Oriented Programming',
            'credit_hours' => 3
        ],
        [
            'code' => 'MATH201',
            'title' => 'Calculus I',
            'credit_hours' => 4
        ],
        [
            'code' => 'CS220',
            'title' => 'Data Structures',
            'credit_hours' => 3
        ],
        [
            'code' => 'ENG101',
            'title' => 'English Composition',
            'credit_hours' => 3
        ],
        [
            'code' => 'PHYS101',
            'title' => 'Physics I',
            'credit_hours' => 4
        ],
        [
            'code' => 'CHEM101',
            'title' => 'Chemistry I',
            'credit_hours' => 4
        ],
        [
            'code' => 'CS310',
            'title' => 'Algorithms',
            'credit_hours' => 3
        ]
    ];

    return view('gpa-simulator', compact('courseCatalog'));
});



