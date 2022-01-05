<?php

namespace App\Models;

use App\Models\User;
use App\Models\Reader;
use App\Models\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favourite extends Model
{
    protected $fillable = [
        'history_id',
        'user_id',
    ];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function histories(){
        return $this->belongsToMany(History::class);
    }
}
