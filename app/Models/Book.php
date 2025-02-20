<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'genre',
        'price',
    ];

    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('borrowed_at', 'returned_at')
                    ->withTimestamps();
    }

    public function getBorrowedDateAttribute()
    {
        $user = auth()->user();
        $borrowedRecord = $this->users()->where('user_id', $user->id)->first();

        return $borrowedRecord ? $borrowedRecord->pivot->borrowed_at : null;
    }
}
