<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class section extends Model
{   use HasFactory;

    protected $fillable = [
        'name',
        'class_id',

    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function currentStudents()
    {
        return $this->hasMany(Current_Student::class, 'section_id');
    }
}
