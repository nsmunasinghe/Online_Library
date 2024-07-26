<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $book;
    public function __construct()
    {
        $this->book = new Book();
    }

    public function index()
    {
        try{
            return response()->json($this->book->all(), 200);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e], 500);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try{
            $book = $this->book->create($request->all());
            return response()->json($book, 201);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $book = $this->book->find($id);
            if (!$book) {
                return response()->json(['error' => 'Book not found'], 404);
            }
            return response()->json($book, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function edit(Book $book)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        try {
            $book = $this->book->find($id);
            if (!$book) {
                return response()->json(['error' => 'Book not found'], 404);
            }
            $book->update($request->all());
            return response()->json($book, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $book = $this->book->find($id);
            if (!$book) {
                return response()->json(['error' => 'Book not found'], 404);
            }
            $book->delete();
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
