<?php

namespace App\Models;

use App\Models\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapter extends Model
{

    protected $fillable = [
        'number',
        'content',
        'history_id',
    ];

    use HasFactory;
    public function history()
    {
        return $this->belongsTo(History::class);
    }
}
