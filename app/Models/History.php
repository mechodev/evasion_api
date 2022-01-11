<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Favourite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'validated',
        'Appreciation',
        'chapter',
        'category_id',
        'user_id',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function favourites()
    {
        return $this->belongsToMany(Favourite::class);
    }
}
