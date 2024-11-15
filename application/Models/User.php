<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'author_id', 'id');
    }
}
