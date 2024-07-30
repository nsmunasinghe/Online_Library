<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/books', BookController::class);

Route::post('/books/{book}/borrow', [BorrowingController::class, 'borrowBook'])->name('books.borrow');
Route::post('/books/{book}/return', [BorrowingController::class, 'returnBook'])->name('books.return');
Route::get('/books/{book}/status', [BorrowingController::class, 'checkStatus'])->name('books.status');
