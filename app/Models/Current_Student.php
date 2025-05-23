<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Current_Student extends Model
{
    use HasFactory;

    protected $fillable = [
      'student_id',
        'class_id',
        'section_id',
        'code',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function class()
    {
        return $this->belongsTo(classes::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

}
