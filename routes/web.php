<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.welcome');
});

Route::get('books', [BookController::class, 'index'])->name('books');
Route::get('books/create', [BookController::class, 'create']);
Route::post('books', [BookController::class, 'store']);
Route::get('books/{id?}', [BookController::class, 'show'])->name('show');
Route::get('books/{id?}/edit', [BookController::class, 'edit'])->name('edit');
Route::put('books/{id?}', [BookController::class, 'update'])->name('books');
Route::delete('books/{id?}', [BookController::class, 'destroy'])->name('books');

Route::fallback(function () {
    return view('partials.response', [
        'msg' => 'The site your trying to access is not available',
        'status' => '404 - Page Not Found'
    ]);
});
