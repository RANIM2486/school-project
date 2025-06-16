<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Ad extends Model
{
    use HasFactory;
    protected $fillbale=['user_id', 'title', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
