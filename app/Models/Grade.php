<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{  use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'exam1',
        'exam2',
        'exam3',
        'quiz',
        'final_exam',
        'date',
        'guid_id'
    ];

   public function student()
    {
        return $this->belongsTo(student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function guide()
    {
        return $this->belongsTo(User::class, 'guide_id');
    }
}
