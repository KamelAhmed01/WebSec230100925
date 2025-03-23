<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\web\ProductsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a middleware group.
|
*/

Route::view('/', 'posts.index')->name('home');
Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('/first', function () {
    return view('LabExercises.first');
});
Route::get('/even', function () {
    return view('LabExercises.even');
});
Route::get('/prime', function () {
    return view('LabExercises.prime');
});
Route::get('/multable', function () {
    return view('LabExercises.multable');
});
Route::get('/multiquiz', function () {
    return view('LabExercises.multiquiz');
});
Route::get('/calculator', function () {
    return view('LabExercises.calculator');
});
Route::get('/gpa-simulator', function () {

    $courseCatalog = [
        [
            'code' => 'CSC101',
            'title' => 'Introduction to Computer Science',
            'credit_hours' => 3
        ],
        [
            'code' => 'CSC201',
            'title' => 'Data Structures',
            'credit_hours' => 4
        ],
        [
            'code' => 'MTH101',
            'title' => 'Calculus I',
            'credit_hours' => 3
        ],
        [
            'code' => 'PHY101',
            'title' => 'Physics I',
            'credit_hours' => 4
        ],
        [
            'code' => 'ENG101',
            'title' => 'English Composition',
            'credit_hours' => 3
        ]
    ];

    return view('LabExercises.gpa-simulator', compact('courseCatalog'));
});
Route::get('/minitest', function () {
    $items = [
        [
            'name' => 'Apple',
            'quantity' => 5,
            'price' => 0.99
        ],
        [
            'name' => 'Banana',
            'quantity' => 3,
            'price' => 0.59
        ],
        [
            'name' => 'Orange Juice',
            'quantity' => 2,
            'price' => 3.99
        ],
        [
            'name' => 'Bread',
            'quantity' => 1,
            'price' => 2.49
        ]
    ];

    // Calculate the total
    $total = 0;
    foreach ($items as $item) {
        $total += ($item['quantity'] * $item['price']);
    }

    return view('LabExercises.minitest', compact('items', 'total'));
});


Route::middleware('guest')->group(function () {
    // Views
    Route::view('/register', 'auth.register')->name('register');
    Route::view('/login', 'auth.login')->name('login');

    // POST handlers
    Route::post('/register', [AuthController::class, 'register_user']);
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth')->group(function () {

    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::resource('users', UserController::class);

    // Product routes with permission checks
    Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])
        ->name('products_edit');

    Route::post('products/save/{product?}', [ProductsController::class, 'save'])
        ->name('products_save');

    Route::post('products/delete/{product}', [ProductsController::class, 'delete'])
        ->name('products_delete');

    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
});
