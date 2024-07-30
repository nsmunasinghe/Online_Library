<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{

    public function borrowBook(Request $request, Book $book)
    {
        try{
            $loggedUser = User::find($request->user_id);

            // Check if the book is already borrowed
            $alreadyBorrowed = $book->users()->wherePivot('returned_at', null)->exists();

            if ($alreadyBorrowed) {
                return response()->json(['error' => 'This book is already borrowed'], 400);
            }

            $loggedUser->books()->attach($book->id);

            return response()->json(['message' => 'Book borrowed successfully'], 200);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Book borrorw failed.'], 500);
        }
    }

    public function returnBook(Request $request, Book $book)
    {
        try{
            $loggedUser = User::find($request->user_id);

            $alreadyBorrowed = $book->users()->wherePivot('returned_at', null)->exists();

            if (!$alreadyBorrowed) {
                return response()->json(['error' => 'This book is not borrowed by Anyone'], 400);
            }

            $loggedUser->books()->updateExistingPivot($book->id, ['returned_at' => now()]);

            return response()->json(['message' => 'Book returned successfully'], 200);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Book return failed.'], 500);
        }
    }

    public function checkStatus(Book $book){
        try {
            $userBook = $book->users()->wherePivot('returned_at', null)->first();

            if ($userBook) {
                return response()->json([
                    'isBorrowed' => true,
                    'borrowed_at' => $userBook->pivot->borrowed_at, // Assuming you have the 'borrowed_at' field
                ], 200);
            } else {
                return response()->json(['isBorrowed' => false], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to check book status: ' . $e->getMessage()], 500);
        }
    }
}
