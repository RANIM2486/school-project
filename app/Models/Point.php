<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable=['student_id','teacher_id','reason_id'];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id')->where('role', 'teacher');
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }
}
