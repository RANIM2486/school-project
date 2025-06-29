<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'min_grade',
        'max_grade',
        'exam1',
        'exam2',
        'exam3',
        'final_exam',
        'quiz',
        'teacher_id'
    ];


    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
     public function teachers()
{
    return $this->belongsToMany(User::class, 'subject_teacher');
}
    public function sections()
{
    return $this->belongsToMany(Section::class, 'subject_teacher');

}
}
