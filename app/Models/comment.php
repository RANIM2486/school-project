<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date',
        'type',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
