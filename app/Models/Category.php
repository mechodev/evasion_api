<?php

namespace App\Models;

use App\Models\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{

    protected $fillable = [
        'title',
    ];

    use HasFactory;
    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
