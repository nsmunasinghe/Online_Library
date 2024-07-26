<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BorrowingController extends Controller
{
    public function borrowBook(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::find($request->user_id);
        $book = Book::find($request->book_id);

        // Check if the book is already borrowed
        if ($user->borrowedBooks->contains($book->id)) {
            return response()->json(['error' => 'Book is already borrowed by this user.'], 400);
        }

        $user->borrowedBooks()->attach($book->id, ['borrowed_at' => now()]);

        return response()->json(['message' => 'Book borrowed successfully']);
    }

    public function returnBook(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::find($request->user_id);
        $book = Book::find($request->book_id);

        // Check if the book was borrowed by the user
        if (!$user->borrowedBooks->contains($book->id)) {
            return response()->json(['error' => 'This book was not borrowed by the user.'], 400);
        }

        $user->borrowedBooks()->updateExistingPivot($book->id, ['returned_at' => now()]);

        return response()->json(['message' => 'Book returned successfully']);
    }
}
