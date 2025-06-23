<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class section extends Model
{   use HasFactory;

    protected $fillable = [
        'name',
        'class_id',
        'guide_id',
        'teacher_id'
    ];
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
    public function guide()
    {
        return $this->belongsTo(User::class, 'guide_id');
    }
    public function currentStudents()
    {
        return $this->hasMany(Current_Student::class, 'section_id');
    }
}
