<?php

namespace App\Models;

use App\Models\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'history_id',
        'user_id',
    ];


    public function history()
    {
        return $this->belongsTo(History::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
