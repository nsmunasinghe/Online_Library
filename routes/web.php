<?php

use App\Http\Controllers\ProfileController;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function (Request $request) {
    $query = $request->input('query');
    $books = Book::when($query, function($q) use ($query) {
        $q->where('title', 'like', "%{$query}%")
          ->orWhere('description', 'like', "%{$query}%")
          ->orWhere('genre', 'like', "%{$query}%");
    })->paginate(10);

    return Inertia::render('Home', [
        'books' => $books,
        'query' => $query,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin', function () {
        return Inertia::render('AdminPanel', [
            'books' => Book::all(),
        ]);
    })->name('admin');

    Route::get('/mybooks', function () {
        $user = auth()->user();

        $borrowedBooks = Book::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->whereNull('returned_at');
        })->get();

        return Inertia::render('MyBooks', [
            'myBooks' => $borrowedBooks,
        ]);
    })->name('mybooks');
});

require __DIR__.'/auth.php';
