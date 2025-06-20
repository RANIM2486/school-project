<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'level',
        'students_count',
        'fees',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    // ؟؟؟؟؟غير موجود
    // public function students()
    // {
    //     return $this->hasMany(Student::class, 'class_id');
    // }

    public function currentStudents()
    {
        return $this->hasMany(CurrentStudent::class, 'class_id');
    }
}

