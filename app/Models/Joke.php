<?php

namespace App\Models;

use Database\Factories\JokeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joke extends Model
{
    /** @use HasFactory<JokeFactory> */
    use HasFactory;

    protected $fillable = [
        'content',
        'category',
        'title',
        'tag',
        'author',
        'user_id'
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
