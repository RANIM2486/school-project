<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'note',
        'date',
        'type',
        'current_student_id',
        'user_id'
    ];

    public function current_student()
    {
        return $this->belongsTo(Current_Student::class, 'current_student_id');
    }

    public function user()
    {
        return
        $this->belongsTo(User::class);
    }


}
